<?php

use yii\db\Migration;

/**
 * Class m180810_210811_add_relations_to_game_table
 */
class m180810_210811_add_relations_to_game_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('{{%game_region_fk}}', '{{%game}}', 'region_id', '{{%region}}', 'id', 'SET NULL', 'SET NULL');
        $this->addForeignKey('{{%game_platform_fk}}', '{{%game}}', 'platform_id', '{{%platform}}', 'id', 'SET NULL', 'SET NULL');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180810_210811_add_relations_to_game_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180810_210811_add_relations_to_game_table cannot be reverted.\n";

        return false;
    }
    */
}
