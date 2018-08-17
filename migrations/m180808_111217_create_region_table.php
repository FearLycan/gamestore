<?php

use yii\db\Migration;

/**
 * Handles the creation of table `region`.
 */
class m180808_111217_create_region_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%region}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'slug' => $this->string(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
        ]);

        $this->createIndex('{{%region_name_index}}', '{{%region}}', 'name');
        $this->createIndex('{{%region_status_index}}', '{{%region}}', 'status');
        $this->createIndex('{{%region_created_at_index}}', '{{%region}}', 'created_at');
        $this->createIndex('{{%region_updated_at_index}}', '{{%region}}', 'updated_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%region}}');
    }
}
