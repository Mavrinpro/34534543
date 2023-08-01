<?php

use yii\db\Migration;

/**
 * Class m230531_065605_add
 */
class m230531_065605_add extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%deals}}', 'special', $this->integer()->after('gender'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('deals', 'special');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230531_065605_add cannot be reverted.\n";

        return false;
    }
    */
}
