<?php

use app\components\Helpers;
use app\components\Price;
use app\components\Translator;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Translator::translate('Summary');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cart-summary">
    <h1>
        <?= Html::encode($this->title) ?>
    </h1>


    <hr>
    <div class="row">

        <div class="container">


            <table id="cart" class="table table-hover table-condensed">
                <thead>
                <tr>
                    <th style="width:55%; text-transform: capitalize;"><?= Translator::translate('Product') ?></th>
                    <th style="width:10%"><?= Translator::translate('Price') ?></th>
                    <th style="width:8%" class="text-center"><?= Translator::translate('Quantity') ?></th>
                    <th style="width:17%" class="text-center"><?= Translator::translate('Subtotal') ?></th>
                    <th style="width:10%"></th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($products['items'] as $key => $product): ?>
                    <tr data-id="<?= $product['id'] ?>">
                        <td data-th="Product">
                            <div class="row">
                                <div class="col-sm-2 hidden-xs">
                                    <a href="<?= Url::to(['game/view', 'slug' => $product['slug']]) ?>">
                                        <img src="<?= $product['smallImage'] ?>" alt="<?= $product['name'] ?>"
                                             class="img-responsive"/>
                                    </a>
                                </div>
                                <div class="col-sm-10">
                                    <a href="<?= Url::to(['game/view', 'slug' => $product['slug']]) ?>">
                                        <h4 class="nomargin"><?= Html::encode($product['name']) ?></h4>
                                    </a>
                                    <p>
                                        <?= Helpers::cutThis($product['description'], 150) ?>
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td data-th="Price"> <?= Price::get($product['price']) ?></td>
                        <td data-th="Quantity" class="text-center">
                            <?= $product['quantity'] ?>
                        </td>
                        <td data-th="Subtotal" class="text-center">
                            <?= Price::get($product['price'] * $product['quantity']) ?>
                        </td>
                        <td class="actions text-center">

                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
                <tfoot>
                <?php if (isset($products['promo-code'])): ?>
                    <tr>
                        <td>
                            <div class="row">
                                <div class="col-md-8" style="margin-top: 10px;">
                                    <p>
                                        <?= Translator::translate('Promotion Code') ?>:
                                        <strong><?= $products['promo-code']['code'] ?></strong>,
                                        <?= Translator::translate('value') ?>:
                                        <strong><?= $products['promo-code']['value'] ?>%</strong>
                                    </p>
                                </div>
                            </div>

                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td>
                        <div class="row">
                            <div class="col-md-6" style="margin-top: 10px;">
                                <p>
                                    <?= Translator::translate('Delivery method') ?>:
                                    <strong><?= Translator::translate('address e-mail') ?></strong>
                                </p>
                            </div>
                            <div class="col-md-6" style="margin-top: 10px;">
                                <p>
                                    <strong><?= Yii::$app->user->identity->email ?></strong>
                                </p>
                            </div>
                        </div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="visible-xs">
                    <td class="text-center"><strong><?= Price::get($products['total']) ?></strong></td>
                </tr>
                <tr>
                    <td>
                        <a href="<?= Url::to(['cart/index']) ?>" class="btn btn-warning">
                            <i class="fa fa-angle-left"></i> <?= Translator::translate('Back') ?>
                        </a>
                    </td>
                    <td colspan="2" class="hidden-xs"></td>
                    <td class="hidden-xs text-center">

                        <?php if (isset($products['total-promo'])): ?>
                            <strike><strong> <?= Price::get($products['total']) ?> </strong></strike><br>
                            <strong> <?= Price::get($products['total-promo']) ?> </strong>
                        <?php else: ?>
                            <strong> <?= Price::get($products['total']) ?> </strong>
                        <?php endif; ?>

                    </td>
                    <td>
                        <a href="<?= Url::to(['order/place-an-order']) ?>" data-method="post" class="btn btn-success btn-block">
                            <?= Translator::translate('Checkout') ?> <i class="fa fa-angle-right"></i>
                        </a>
                    </td>
                </tr>
                </tfoot>
            </table>


        </div>

    </div>
</div>
