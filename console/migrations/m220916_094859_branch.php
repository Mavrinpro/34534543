<?php

use yii\db\Migration;

/**
 * Class m220916_094859_branch
 */
class m220916_094859_branch extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('branch', [
            'id'              => $this->primaryKey(),
            'name'            => $this->string(100),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220916_094859_branch cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220916_094859_branch cannot be reverted.\n";

        return false;
    }
    */
}
