<?php

use yii\db\Migration;

/**
 * Class m220916_070802_deals
 */
class m220916_070802_deals extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('deals', [
            'id'              => $this->primaryKey(),
            'name'            => $this->string(100),
            'phone'           => $this->string(20),
            'tag'             => $this->string(200),
            'date_create'     => $this->dateTime(),
            'status'          => $this->string(),
            'id_operator'     => $this->integer(),
            'id_filial'       => $this->integer(),
            'id_comment'      => $this->integer(),
            'deal_sum'        => $this->integer(),

        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220916_070802_deals cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220916_070802_deals cannot be reverted.\n";

        return false;
    }
    */
}
