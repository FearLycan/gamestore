<?php

use yii\db\Migration;

/**
 * Handles the creation of table `platform`.
 */
class m180808_111410_create_platform_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%platform}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'slug' => $this->string(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
        ]);

        $this->createIndex('{{%platform_name_index}}', '{{%platform}}', 'name');
        $this->createIndex('{{%platform_status_index}}', '{{%platform}}', 'status');
        $this->createIndex('{{%platform_created_at_index}}', '{{%platform}}', 'created_at');
        $this->createIndex('{{%platform_updated_at_index}}', '{{%platform}}', 'updated_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%platform}}');
    }
}
