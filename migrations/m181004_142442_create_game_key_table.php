<?php

use yii\db\Migration;

/**
 * Handles the creation of table `game_key`.
 */
class m181004_142442_create_game_key_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%game_key}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'key' => $this->string()->notNull(),
            'uncover' => $this->timestamp()->null(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
        ]);

        $this->addForeignKey('{{%game_key_order_id_fk}}', '{{%game_key}}', 'order_id', '{{%order}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('{{%game_key_created_at_index}}', '{{%game_key}}', 'created_at');
        $this->createIndex('{{%game_key_updated_at_index}}', '{{%game_key}}', 'updated_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%game_key}}');
    }
}
