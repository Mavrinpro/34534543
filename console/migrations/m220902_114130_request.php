<?php

use yii\db\Migration;

/**
 * Class m220902_114130_request
 */
class m220902_114130_request extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('request', [
            'id'                => $this->primaryKey(),
            'name'              => $this->string(100),
            'phone'             => $this->string(20),
            'page'              => $this->string(200),
            'date_create'       => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220902_114130_request cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220902_114130_request cannot be reverted.\n";

        return false;
    }
    */
}
