<?php

use yii\db\Migration;

/**
 * Class m220902_064118_doctors
 */
class m220902_064118_doctors extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('doctors', [
			'id'                => $this->primaryKey(),
			'name'              => $this->string(100),
			'last_name'         => $this->string(100),
			'first_name'        => $this->string(100),
			'specialization'    => $this->string(300),
			'work_experience'   => $this->integer(),
			'treated_patients'  => $this->integer(),
			'photo'             => $this->string(300),
			'specialization_text' => $this->text(),
			'about_doc'         => $this->text(),
			'sertificates'      => $this->text(),
			'education'         => $this->text(),
            'date_create'       => $this->dateTime()
			]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220902_064118_doctors cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220902_064118_doctors cannot be reverted.\n";

        return false;
    }
    */
}
