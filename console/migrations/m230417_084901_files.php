<?php

use yii\db\Migration;

/**
 * Class m230417_084901_files
 */
class m230417_084901_files extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('files', [
            'id'                => $this->primaryKey(),
            'name'              => $this->string(),
            'date_at'           => $this->integer(11),
            'date_end'          => $this->integer(11),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230417_084901_files cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230417_084901_files cannot be reverted.\n";

        return false;
    }
    */
}
