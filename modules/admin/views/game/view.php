<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Game */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Games', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-view">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title pull-left"><i class="fa fa-list" aria-hidden="true"></i> Gra:
                        <strong><?= Html::encode($model->name) ?></strong>
                    </h3>
                    <div class="pull-right">
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                </div>
                <div class="panel-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'g2a_id',
                            'name',
                            [
                                'attribute' => 'genres',
                                'value' => $model->getGenresList(),
                            ],
                            [
                                'attribute' => 'type',
                                'format' => 'raw',
                                'value' => $model->getTypesName(),
                            ],
                            'slug',
                            'qty',
                            'min_price',
                            'price',
                            'discount',
                            'thumbnail',
                            'smallImage',
                            [
                                'attribute' => 'description',
                                'format' => 'raw',
                                'value' => $model->description,
                            ],
                            [
                                'attribute' => 'region_id',
                                'format' => 'raw',
                                'value' => $model->region->name,
                            ],
                            'developer',
                            'publisher',
                            [
                                'attribute' => 'platform_id',
                                'format' => 'raw',
                                'value' => $model->platform->name,
                            ],
                            'restrictions',
                            'requirements:ntext',
                            'videos:ntext',
                            [
                                'attribute' => 'status',
                                'value' => $model->getStatusName(),
                            ],
                            'created_at',
                            'updated_at',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>