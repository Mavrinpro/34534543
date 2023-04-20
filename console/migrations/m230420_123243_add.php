<?php

use yii\db\Migration;

/**
 * Class m230420_123243_add
 */
class m230420_123243_add extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%files}}', 'user_id_update', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230420_123243_add cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230420_123243_add cannot be reverted.\n";

        return false;
    }
    */
}
