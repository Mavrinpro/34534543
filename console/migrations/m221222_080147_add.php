<?php

use yii\db\Migration;

/**
 * Class m221222_080147_add
 */
class m221222_080147_add extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%time_tracking}}', 'work', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221222_080147_add cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221222_080147_add cannot be reverted.\n";

        return false;
    }
    */
}
