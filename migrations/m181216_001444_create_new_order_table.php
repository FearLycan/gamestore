<?php

use yii\db\Migration;

/**
 * Handles the creation of table `new_order`.
 */
class m181216_001444_create_new_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'hash' => $this->string()->notNull(),
            'buyer_id' => $this->integer()->notNull(),
            'price' => $this->decimal(18, 12)->notNull(),
            'currency_id' => $this->integer()->notNull(),
            'currency_rate' => $this->decimal(7, 5)->notNull(),
            'status' => $this->smallInteger()->defaultValue(0),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
        ]);

        $this->addForeignKey('{{%order_buyer_id_fk}}', '{{%order}}', 'buyer_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('{{%order_currency_id_fk}}', '{{%order}}', 'currency_id', '{{%currency}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('{{%order_created_at_index}}', '{{%order}}', 'created_at');
        $this->createIndex('{{%order_updated_at_index}}', '{{%order}}', 'updated_at');
        $this->createIndex('{{%order_status_index}}', '{{%order}}', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}
