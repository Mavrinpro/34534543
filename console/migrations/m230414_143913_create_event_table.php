<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%event}}`.
 */
class m230414_143913_create_event_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%event}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'user_id' => $this->integer(),
            'date_create' => $this->integer(),
            'date_update' => $this->integer(),
            'active' => $this->boolean()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%event}}');
    }
}
