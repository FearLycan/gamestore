<?php
/* @var $game \app\models\Game */

use app\components\Price;
use app\components\Translator;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $game->name;
$this->params['breadcrumbs'][] = ['label' => 'Games', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="order-create">
    <h1>
        New Transaction
    </h1>

    <hr>

    <div class="row">
        <div class="col-md-3">
            <img class="img-responsive" src="<?= $game->smallImage ?>">
        </div>
        <div class="col-md-9">
            <h2 class="product-name"><?= Html::encode($this->title) ?></h2>

            <hr>

            <div class="row">
                <div class="col-lg-3 col-lg-offset-2">
                    <div class="media">
                        <div class="media-left">
                            <i class="fa fa-globe fa-3x" aria-hidden="true"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"> <?= Translator::translate('Region') ?> </h4>
                            <?= $game->region->name ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="media">
                        <div class="media-left">
                            <i class="fa fa-th-large fa-3x" aria-hidden="true"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?= Translator::translate('Platform') ?></h4>
                            <?= $game->platform->name ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="media">
                        <div class="media-left">
                            <i class="fa fa-list-alt fa-3x" aria-hidden="true"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?= Translator::translate('Type') ?></h4>
                            <?= $game->getTypeName() ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9 col-lg-offset-2">
                    <p class="lead product-price text-right" style="marg">
                        <?= Translator::translate('Price') ?> <?= Price::get($game->price) ?>
                    </p>
                </div>

                <div class="col-md-9 col-lg-offset-2 text-center">
                    <a href="<?= Url::to(['order/place-an-order', 'slug' => $game->slug]) ?>" data-method="post"
                       class="btn btn-success btn-lg btn-block"><?= Translator::translate('Place an order') ?></a>
                </div>
            </div>
        </div>
    </div>

</div>
