<?php

use yii\db\Migration;

/**
 * Class m221213_103645_add
 */
class m221213_103645_add extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%deals}}', 'call_recording', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221213_103645_add cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221213_103645_add cannot be reverted.\n";

        return false;
    }
    */
}
