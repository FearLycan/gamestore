<?php
/**
 * Created by PhpStorm.
 * User: Damian Brończyk
 * Date: 03.10.2018
 * Time: 11:36
 */

use app\components\Translator;
use app\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $order app\models\Order */

$this->title = 'Zamówienie ' . $order->game->name;

?>

<div class="view-order">
    <div class="row">

        <div class="col-md-2">
            <img src="<?= $order->game->smallImage ?>" class="img-responsive">
        </div>

        <div class="col-md-10">
            <h2 class="product-name"><?= Html::encode($order->game->name) ?></h2>

            <div class="row">
                <div class="col-lg-3">
                    <div class="media">
                        <div class="media-left">
                            <i class="fa fa-globe fa-1x" aria-hidden="true"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"> <?= Translator::translate('Region') ?> </h4>
                            <?= $order->game->region->name ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="media">
                        <div class="media-left">
                            <i class="fa fa-th-large fa-1x" aria-hidden="true"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?= Translator::translate('Platform') ?></h4>
                            <?= $order->game->platform->name ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="media">
                        <div class="media-left">
                            <i class="fa fa-list-alt fa-1x" aria-hidden="true"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?= Translator::translate('Type') ?></h4>
                            <?= $order->game->getTypeName() ?>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <p>
                Status zamówienia: <strong><?= $order->getStatusName() ?></strong>
            </p>

            <p>
                Cena: <?= round($order->price * $order->currency_rate, 2) ?> <?= $order->currency->code ?>
            </p>

            <?php if ($order->status == Order::STATUS_COMPLATE): ?>
                <p>
                    Klucz: <?= $order->gameKey->key ?>
                </p>
            <?php endif; ?>

            <?php if ($order->status == Order::STATUS_NEW) : ?>
                <a href="<?= Url::to(['order/pay', 'hash' => $order->hash]) ?>" data-method="post"
                   class="btn btn-success btn-lg btn-block"><?= Translator::translate('Pay') ?></a>
            <?php endif; ?>

            <?php if ($order->status == Order::STATUS_PAID) : ?>
                <a href="<?= Url::to(['order/get-key', 'hash' => $order->hash]) ?>" data-method="post"
                   class="btn btn-success btn-lg btn-block"><?= Translator::translate('Get key') ?></a>
            <?php endif; ?>

        </div>

    </div>
</div>
