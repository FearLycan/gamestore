<?php

use yii\db\Migration;

/**
 * Handles the creation of table `genre`.
 */
class m180816_090513_create_genre_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%genre}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'slug' => $this->string(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
        ]);

        $this->createIndex('{{%genre_name_index}}', '{{%genre}}', 'name');
        $this->createIndex('{{%genre_status_index}}', '{{%genre}}', 'status');
        $this->createIndex('{{%genre_created_at_index}}', '{{%genre}}', 'created_at');
        $this->createIndex('{{%genre_updated_at_index}}', '{{%genre}}', 'updated_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%genre}}');
    }
}
