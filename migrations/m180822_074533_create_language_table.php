<?php

use yii\db\Migration;

/**
 * Handles the creation of table `language`.
 */
class m180822_074533_create_language_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%language}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'short_name' => $this->string(),
            'language_tag' => $this->string(),
            'slug' => $this->string(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
        ]);

        $this->createIndex('{{%language_name_index}}', '{{%language}}', 'name');
        $this->createIndex('{{%language_short_name_index}}', '{{%language}}', 'short_name');
        $this->createIndex('{{%language_language_tag_index}}', '{{%language}}', 'language_tag');
        $this->createIndex('{{%language_slug_index}}', '{{%language}}', 'slug');
        $this->createIndex('{{%language_status_index}}', '{{%language}}', 'status');
        $this->createIndex('{{%language_created_at_index}}', '{{%language}}', 'created_at');
        $this->createIndex('{{%language_updated_at_index}}', '{{%language}}', 'updated_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%language}}');
    }
}
