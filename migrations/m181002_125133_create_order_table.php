<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m181002_125133_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'g2a_order_id' => $this->string()->null(),
            'g2a_game_id' => $this->bigInteger()->notNull(),
            'hash' => $this->string()->notNull(),
            'buyer_id' => $this->integer()->notNull(),
            'price' => $this->decimal(4, 2)->notNull(),
            'selling_price' => $this->decimal(4, 2)->null(),
            'currency_id' => $this->integer()->notNull(),
            'currency_rate' => $this->decimal(7, 5)->notNull(),
            'g2a_transaction_id' => $this->string()->null(),
            'status' => $this->smallInteger()->defaultValue(0),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
        ]);

        $this->addForeignKey('{{%order_buyer_id_fk}}', '{{%order}}', 'buyer_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('{{%order_currency_id_fk}}', '{{%order}}', 'currency_id', '{{%currency}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('{{%order_status_index}}', '{{%order}}', 'status');
        $this->createIndex('{{%ordery_created_at_index}}', '{{%order}}', 'created_at');
        $this->createIndex('{{%order_updated_at_index}}', '{{%order}}', 'updated_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}
