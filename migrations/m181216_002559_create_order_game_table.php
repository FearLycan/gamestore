<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_game`.
 */
class m181216_002559_create_order_game_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_game}}', [
            'id' => $this->primaryKey(),
            'game_id' => $this->integer()->notNull(),
            'order_id' => $this->integer()->notNull(),
            'keys' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
        ]);

        $this->addForeignKey('{{%order_game_game_id_fk}}', '{{%order_game}}', 'game_id', '{{%game}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('{{%order_game_order_id_fk}}', '{{%order_game}}', 'order_id', '{{%order}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('{{%order_game_created_at_index}}', '{{%order_game}}', 'created_at');
        $this->createIndex('{{%order_game_updated_at_index}}', '{{%order_game}}', 'updated_at');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_game}}');
    }
}
