<?php

use yii\db\Migration;

/**
 * Handles the creation of table `translation`.
 */
class m180822_085706_create_translation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%translation}}', [
            'id' => $this->primaryKey(),
            'phrase' => $this->string()->notNull(),
            'translation' => $this->string()->null(),
            'scope' => $this->string()->null(),
            'language_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
        ]);

        $this->addForeignKey('{{%translation_language_id_fk}}', '{{%translation}}', 'language_id', '{{%language}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('{{%translation_phrase_index}}', '{{%translation}}', 'phrase');
        $this->createIndex('{{%translation_scope_index}}', '{{%translation}}', 'scope');
        $this->createIndex('{{%translation_translation_index}}', '{{%translation}}', 'translation');
        $this->createIndex('{{%translation_created_at_index}}', '{{%translation}}', 'created_at');
        $this->createIndex('{{%translation_updated_at_index}}', '{{%translation}}', 'updated_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%translation}}');
    }
}
