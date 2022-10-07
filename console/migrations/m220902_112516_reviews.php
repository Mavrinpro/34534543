<?php

use yii\db\Migration;

/**
 * Class m220902_112516_reviews
 */
class m220902_112516_reviews extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('reviews', [
            'id'                => $this->primaryKey(),
            'name'              => $this->string(100),
            'phone'             => $this->string(20),
            'number_card'       => $this->string(10),
            'id_doc'            => $this->integer(),
            'review'            => $this->text(),
            'date_create'       => $this->dateTime()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220902_112516_reviews cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220902_112516_reviews cannot be reverted.\n";

        return false;
    }
    */
}
