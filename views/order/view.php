<?php

use app\components\Translator;
use app\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $order app\models\Order */

$this->title = Translator::translate('Order') . ': ' . $order->hash;

?>

<div class="view-order">
    <div class="row">

        <div class="col-md-12">
            <h1><?= Translator::translate('Order') . ': ' ?>
                <small><?= $order->hash ?></small>
            </h1>
            <hr>
            <p>
                <strong><?= Translator::translate('Price') . ': ' ?></strong> <?= round($order->price * $order->currency_rate,2) ?> <?= $order->currency->short_name ?>
                <br>
                <strong><?= Translator::translate('Date') . ': ' ?></strong> <?= $order->created_at ?> <br>
                <strong><?= Translator::translate('Status') . ': ' ?></strong> Done
            </p>
        </div>

        <div class="col-md-12">
            <h2><?= Translator::translate('Orderd games') . ': ' ?>
            </h2>
            <hr>

            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                <?php foreach ($order->orderGames as $key => $item): ?>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion"
                               href="#collapse<?= $key ?>"
                               aria-expanded="true" aria-controls="collapseOne">
                                <?= $item->game->name ?>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse<?= $key ?>" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="headingOne">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="<?= $item->game->smallImage ?>" class="img-responsive">
                                </div>
                                <div class="col-md-10">
                                    <h3> <?= $item->game->name ?></h3>
                                    <p>
                                        <strong><?= Translator::translate('Platform') ?></strong>: <?= $item->game->platform->name ?>
                                        <br>
                                        <strong><?= Translator::translate('Region') ?></strong>: <?= $item->game->region->name ?>
                                        <br>
                                        <strong><?= Translator::translate('Type') ?></strong>: <?= $item->game->getTypeName() ?>
                                    </p>
                                    <p>
                                        <strong><?= Translator::translate('Keys') ?></strong>: <br>
                                        <?php foreach (json_decode($item->keys, true) as $n => $key): ?>
                                            <?= $n + 1 ?>. <?= $key ?> <br>
                                        <?php endforeach; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>

        </div>


    </div>
</div>
