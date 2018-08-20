<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searches\GameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Games';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-index">
    <?php Pjax::begin(); ?>

    <h1>
        <?php if (isset($link['platform']) || isset($link['genre'])): ?>
            <?= $link['name'] . ' - ' ?>
        <?php endif; ?>
        <?= Html::encode($this->title) ?>
        <small class="text-muted">(<?= $dataProvider->getTotalCount() ?> products)</small>
    </h1>


    <hr>

    <div class="row">
        <div class="col-md-3">

            <?= $this->render('_search', ['model' => $searchModel, 'link' => $link]); ?>

        </div>
        <div class="col-md-9">
            <div id="products" class="row list-group">
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => false,
                    'itemOptions' => ['class' => 'item col-xs-12 col-lg-4 col-md-4'],
                    'itemView' => '_game',
                    'options' => [
                        'tag' => 'div',
                        // 'class' => 'row cols-md-space cols-sm-space cols-xs-space',
                    ],
                ]); ?>
            </div>
        </div>
    </div>


    <?php Pjax::end(); ?>
</div>
