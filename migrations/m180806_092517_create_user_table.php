<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180806_092517_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'slug' => $this->string()->notNull(),
            'email' => $this->string(),
            'password' => $this->string(),
            'role' => $this->smallInteger()->notNull()->defaultValue(1),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'registered_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'last_login_at' => $this->timestamp()->null(),
            'last_seen' => $this->timestamp()->null(),
            'auth_key' => $this->string(),
            'verification_code' => $this->string(),
        ]);

        // unique constraints
        $this->createIndex('{{%user_email_unique}}', '{{%user}}', 'email', true);
        $this->createIndex('{{%user_name_unique}}', '{{%user}}', 'name', true);

        // indexes for performance
        $this->createIndex('{{%user_status_index}}', '{{%user}}', 'status');
        $this->createIndex('{{%user_role_index}}', '{{%user}}', 'role');
        $this->createIndex('{{%user_registered_at_index}}', '{{%user}}', 'registered_at');
        $this->createIndex('{{%user_last_login_at_index}}', '{{%user}}', 'last_login_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
