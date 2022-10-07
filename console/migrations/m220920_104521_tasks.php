<?php

use yii\db\Migration;

/**
 * Class m220920_104521_tasks
 */
class m220920_104521_tasks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tasks', [
            'id'              => $this->primaryKey(),
            'name'            => $this->string(100),
            'user_id'         => $this->integer(),
            'date_create' => $this->dateTime(),
            'date_update' => $this->dateTime(),
            'status' => $this->boolean()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220920_104521_tasks cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220920_104521_tasks cannot be reverted.\n";

        return false;
    }
    */
}
