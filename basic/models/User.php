<?php

namespace app\models;

use app\models\query\UserQuery;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $name
 * @property string $password_hash
 * @property string $access_token
 * @property string $auth_key
 * @property int $creator_id
 * @property int $updater_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Task[] $tasksCreated
 * @property Task[] $tasksUpdated
 * @property TaskUser[] $taskUsers
 * @property Task[] accessedTasks
 * @mixin TimestampBehavior
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $password;
    const RELATION_TASKS_CREATED = 'tasksCreated';
    const RELATION_TASKS_UPDATED = 'tasksUpdated';
    const RELATION_TASKS_USERS = 'taskUsers';
    const RELATION_TASKS_ACCESSED = 'accessedTasks';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'name'], 'required'],
            [['creator_id', 'updater_id', 'created_at', 'updated_at'], 'integer'],
            [['username', 'name', 'password', 'access_token', 'auth_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'creator_id',
                'updatedByAttribute' => 'updater_id',
            ],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     *
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            $this->auth_key = yii::$app->security->generateRandomString();
        }

        if ($this->password) {
            $this->password_hash = yii::$app->security->generatePasswordHash($this->password);
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'name' => 'Name',
            'password_hash' => 'Password Hash',
            'access_token' => 'Access Token',
            'auth_key' => 'Auth Key',
            'creator_id' => 'Creator ID',
            'updater_id' => 'Updater ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasksCreated()
    {
        return $this->hasMany(Task::className(), ['creator_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasksUpdated()
    {
        return $this->hasMany(Task::className(), ['updater_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskUsers()
    {
        return $this->hasMany(TaskUser::className(), ['user_id' => 'id']);

    }

    public function getAccessedTasks()
    {
        return $this->hasMany(Task::className(), ['id' => 'task_id'])
            ->via(self::RELATION_TASKS_USERS);
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * @param $username
     * @return User|null
     */
    public static function findByUsername($username)
    {
        return User::findOne(['username' => $username]);
    }

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
