<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%deals}}`.
 */
class m220916_083933_add_deal_sum_column_to_deals_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%deals}}', 'deal_sum', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%deals}}', 'deal_sum');
    }
}
