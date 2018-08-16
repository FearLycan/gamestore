<?php

use yii\db\Migration;

/**
 * Handles the creation of table `game_genre`.
 */
class m180816_090823_create_game_genre_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%game_genre}}', [
            'game_id' => $this->integer()->notNull(),
            'genre_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('{{%game_genre_pk}}', '{{%game_genre}}', ['game_id', 'genre_id']);
        $this->addForeignKey('{{%game_id_fk}}', '{{%game_genre}}', 'game_id', '{{%game}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('{{%genre_id_fk}}', '{{%game_genre}}', 'genre_id', '{{%genre}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('{{%game_id_fk}}', '{{%game_genre}}');
        $this->dropForeignKey('{{%genre_id_fk}}', '{{%game_genre}}');
        $this->dropTable('{{%game_genre}}');
    }
}
