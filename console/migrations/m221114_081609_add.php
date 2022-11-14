<?php

use yii\db\Migration;

/**
 * Class m221114_081609_add
 */
class m221114_081609_add extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tasks}}', 'date_end', $this->timestamp());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221114_081609_add cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221114_081609_add cannot be reverted.\n";

        return false;
    }
    */
}
