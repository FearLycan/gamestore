<?php

use yii\db\Migration;

/**
 * Handles the creation of table `game`.
 */
class m180808_093153_create_game_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%game}}', [
            'id' => $this->primaryKey(),
            'g2a_id' => $this->bigInteger()->null(),
            'name' => $this->string()->notNull(),
            'type' => $this->smallInteger()->notNull(),
            'slug' => $this->string()->notNull(),
            'qty' => $this->integer()->notNull()->defaultValue(0),
            'min_price' => $this->decimal(4, 2)->notNull(),
            'price' => $this->decimal(4, 2)->notNull(),
            'discount' => $this->smallInteger(3)->null(),
            'thumbnail' => $this->string(),
            'smallImage' => $this->string(),
            'description' => $this->text(),
            'region' => $this->smallInteger()->notNull(),
            'developer' => $this->string()->null(),
            'publisher' => $this->string()->null(),
            'platform' => $this->smallInteger()->notNull(),
            'restrictions' => $this->string()->null(),
            'requirements' => $this->string()->null(),
            'videos' => $this->string()->null(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
        ]);

        $this->createIndex('{{%game_name_index}}', '{{%game}}', 'name');
        $this->createIndex('{{%game_created_at_index}}', '{{%game}}', 'created_at');
        $this->createIndex('{{%game_updated_at_index}}', '{{%game}}', 'updated_at');

        $this->createIndex('{{%game_status_index}}', '{{%game}}', 'status');
        $this->createIndex('{{%game_type_index}}', '{{%game}}', 'type');
        $this->createIndex('{{%game_region_index}}', '{{%game}}', 'region');
        $this->createIndex('{{%game_min_price_index}}', '{{%game}}', 'min_price');
        $this->createIndex('{{%game_price_index}}', '{{%game}}', 'price');
        $this->createIndex('{{%game_discount_index}}', '{{%game}}', 'discount');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%game}}');
    }
}
