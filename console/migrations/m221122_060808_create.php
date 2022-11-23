<?php

use yii\db\Migration;

/**
 * Class m221122_060808_create
 */
class m221122_060808_create extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('layouts_mail', [
            'id'                => $this->primaryKey(),
            'name'              => $this->string(150),
            'mail_id'           => $this->integer(),
            'text'              => $this->text(),
            'img'               => $this->string(300),
            'file'               => $this->string(300),
            'date_create'       => $this->timestamp(),
            'date_update'       => $this->timestamp(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221122_060808_create cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221122_060808_create cannot be reverted.\n";

        return false;
    }
    */
}
