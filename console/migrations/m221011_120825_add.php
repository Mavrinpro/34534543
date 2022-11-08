<?php

use yii\db\Migration;

/**
 * Class m221011_120825_add
 */
class m221011_120825_add extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%deals}}', 'date_update', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221011_120825_add cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221011_120825_add cannot be reverted.\n";

        return false;
    }
    */
}
