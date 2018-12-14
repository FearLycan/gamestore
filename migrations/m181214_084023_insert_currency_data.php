<?php

use app\models\Currency;
use yii\db\Migration;

/**
 * Class m181214_084023_insert_currency_data
 */
class m181214_084023_insert_currency_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%currency}}', ['country', 'name', 'short_name', 'code', 'rate', 'side'], [
            ['Europe', 'Euro', '<i class="fa fa-eur" aria-hidden="true"></i>', 'EUR', '1.00000', Currency::SIDE_RIGHT],
            ['Polska', 'złoty', 'zł', 'PLN', '4.29499', Currency::SIDE_RIGHT],
            ['USA', 'dollar', '<i class="fa fa-usd" aria-hidden="true"></i>', 'USD', '1.13455', Currency::SIDE_LEFT],
            ['UK', 'pound sterling', '<i class="fa fa-gbp" aria-hidden="true"></i>', 'GBP', '0.898931', Currency::SIDE_LEFT],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181214_084023_insert_currency_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181214_084023_insert_currency_data cannot be reverted.\n";

        return false;
    }
    */
}
