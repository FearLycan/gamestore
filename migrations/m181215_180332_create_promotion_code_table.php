<?php

use yii\db\Migration;

/**
 * Handles the creation of table `promotion_code`.
 */
class m181215_180332_create_promotion_code_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%promotion_code}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string()->notNull(),
            'value' => $this->integer()->notNull(),
            'expiration' => $this->timestamp()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
        ]);

        $this->createIndex('{{%promotion_code_code_index}}', '{{%promotion_code}}', 'code');
        $this->createIndex('{{%promotion_code_created_at_index}}', '{{%promotion_code}}', 'created_at');
        $this->createIndex('{{%promotion_code_updated_at_index}}', '{{%promotion_code}}', 'updated_at');
        $this->createIndex('{{%promotion_code_expiration_index}}', '{{%promotion_code}}', 'expiration');

        $this->batchInsert('{{%promotion_code}}', ['code', 'value', 'expiration'], [
            ['PROMO5', 5, '2030-11-29 13:31:19'],
            ['PROMO10', 10, '2030-11-29 13:31:19'],
            ['PROMO15', 15, '2030-11-29 13:31:19'],
            ['PROMO30', 30, '2030-11-29 13:31:19'],
            ['CHRISTMAS', 50, '2030-11-29 13:31:19'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%promotion_code}}');
    }
}
