<?php

use yii\db\Migration;

/**
 * Class m221010_120600_add
 */
class m221010_120600_add extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%deals}}', 'del', $this->boolean(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221010_120600_add cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221010_120600_add cannot be reverted.\n";

        return false;
    }
    */
}
