<?php

use yii\db\Migration;

/**
 * Class m221011_095446_add
 */
class m221011_095446_add extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%deals}}', 'del', $this->boolean(0)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('deals', 'del');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221011_095446_add cannot be reverted.\n";

        return false;
    }
    */
}
