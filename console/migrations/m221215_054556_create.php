<?php

use yii\db\Migration;

/**
 * Class m221215_054556_create
 */
class m221215_054556_create extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('time_tracking', [
            'id'                => $this->primaryKey(),
            'user_id'           => $this->integer(11),
            'date_at'           => $this->integer(11),
            'date_end'          => $this->integer(11),
            'session_start'     => $this->integer(11),
            'session_end'       => $this->integer(11),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221215_054556_create cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221215_054556_create cannot be reverted.\n";

        return false;
    }
    */
}
