<?php

use yii\db\Migration;

/**
 * Class m220920_064621_statuses
 */
class m220920_064621_statuses extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('statuses', [
            'id'              => $this->primaryKey(),
            'name'            => $this->string(100),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220920_064621_statuses cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220920_064621_statuses cannot be reverted.\n";

        return false;
    }
    */
}
