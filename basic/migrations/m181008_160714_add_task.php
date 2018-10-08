<?php

use yii\db\Migration;

/**
 * Class m181008_160714_add_task
 */
class m181008_160714_add_task extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'creator_id' => $this->integer()->notNull(),
            'updater_id' => $this->integer(),
            'created_id' => $this->integer()->notNull(),
            'updated_id' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('task');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181008_160714_add_task cannot be reverted.\n";

        return false;
    }
    */
}
