<?php

use yii\db\Migration;

/**
 * Class m221213_122611_add
 */
class m221213_122611_add extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('deals','email','deal_email');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221213_122611_add cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221213_122611_add cannot be reverted.\n";

        return false;
    }
    */
}
