<?php

use yii\db\Migration;

/**
 * Class m221011_095810_drop
 */
class m221011_095810_drop extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('deals', 'del');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221011_095810_drop cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221011_095810_drop cannot be reverted.\n";

        return false;
    }
    */
}
