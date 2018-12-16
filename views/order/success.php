<?php
/**
 * Created by PhpStorm.
 * User: Damian
 * Date: 16.12.2018
 * Time: 02:06
 */
use app\components\Translator;
use yii\helpers\Url;

$this->title = Translator::translate('Order confirmation');

?>

<div class="order-success">
    <div class="row">
        <div class="col-md-12">
            <h1>
                <?= Translator::translate('Order confirmation') ?>
            </h1>
            <hr>
            <p>
                <?= Translator::translate('Your order has been registered.') ?>
                <?= Translator::translate('You can check it') ?>
                <a href="<?= Url::to(['order/view', 'hash' => $order->hash]) ?>"><?= Translator::translate('here') ?></a>.
            </p>
        </div>
    </div>
</div>
