<?php

use yii\db\Migration;

/**
 * Class m220916_100948_tags
 */
class m220916_100948_tags extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tags', [
            'id'              => $this->primaryKey(),
            'name'            => $this->string(100),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220916_100948_tags cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220916_100948_tags cannot be reverted.\n";

        return false;
    }
    */
}
