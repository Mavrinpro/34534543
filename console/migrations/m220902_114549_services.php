<?php

use yii\db\Migration;

/**
 * Class m220902_114549_services
 */
class m220902_114549_services extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('services', [
            'id'                => $this->primaryKey(),
            'name'              => $this->string(100),
            'description'       => $this->text(),
            'price'             => $this->integer(),
            'date_create'       => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220902_114549_services cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220902_114549_services cannot be reverted.\n";

        return false;
    }
    */
}
