<?php

use yii\db\Migration;

/**
 * Handles the creation of table `system_error_page`.
 */
class m180914_114054_create_system_error_page_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%log_error_page}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string(),
            'IP' => $this->string(40)->notNull(),
            'type' => $this->smallInteger(),
            'description' => $this->string()->null(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('{{%log_error_page_created_at_index}}', '{{%log_error_page}}', 'created_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%log_error_page}}');
    }
}
