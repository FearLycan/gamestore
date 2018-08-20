<?php

use app\components\Helpers;
use app\models\Game;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model Game */
?>

<div class="thumbnail product">
    <a href="<?= Url::to(['game/view', 'slug' => $model->slug]) ?>">
        <div class="product-img-background" style="background: url(<?= $model->smallImage ?>);">

            <img class="img-responsive product-img-small" src="<?= $model->smallImage ?>">

        </div>
    </a>


    <!--  <img class="group list-group-image" src="<? /*= $model->smallImage */ ?>" alt=""/>-->
    <div class="caption">
        <h4 class="group inner list-group-item-heading">
            <a href="<?= Url::to(['game/view', 'slug' => $model->slug]) ?>">
                <?= Helpers::cutThis(Html::encode($model->name),70) ?>
            </a>
        </h4>
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <p class="lead lead-price text-right">
                    <?= $model->price ?> <i class="fa fa-eur" aria-hidden="true"></i>
                </p>
            </div>
        </div>
    </div>
</div>



