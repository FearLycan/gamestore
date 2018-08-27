<?php

use yii\db\Migration;

/**
 * Handles the creation of table `currency`.
 */
class m180823_134757_create_currency_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%currency}}', [
            'id' => $this->primaryKey(),
            'country' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'short_name' => $this->string()->notNull(),
            'code' => $this->string(12)->notNull(),
            'rate' => $this->decimal(7, 5)->notNull(),
            'side' => $this->smallInteger(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
        ]);

        $this->createIndex('{{%currency_name_index}}', '{{%currency}}', 'name');
        $this->createIndex('{{%currency_short_name_index}}', '{{%currency}}', 'short_name');
        $this->createIndex('{{%currency_code_index}}', '{{%currency}}', 'code');
        $this->createIndex('{{%currency_rate_index}}', '{{%currency}}', 'rate');

        $this->createIndex('{{%currency_created_at_index}}', '{{%currency}}', 'created_at');
        $this->createIndex('{{%currency_updated_at_index}}', '{{%currency}}', 'updated_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%currency}}');
    }
}
