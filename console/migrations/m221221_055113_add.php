<?php

use yii\db\Migration;

/**
 * Class m221221_055113_add
 */
class m221221_055113_add extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%time_tracking}}', 'count_time', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221221_055113_add cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221221_055113_add cannot be reverted.\n";

        return false;
    }
    */
}
