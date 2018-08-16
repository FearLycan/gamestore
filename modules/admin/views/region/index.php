<?php

use app\modules\admin\models\Region;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\searches\RegionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Regions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title pull-left">
                        <i class="fa fa-globe" aria-hidden="true"></i> Lista regionów
                    </h3>
                    <div class="btn-group pull-right">
                        <a href="<?= Url::to(['create']) ?>" class="btn btn-success btn-sm">Dodaj</a>
                    </div>
                </div>
                <div class="panel-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'layout' => "{items}\n{summary}\n{pager}",
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 60px;']],
                            [
                                'attribute' => 'name',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    /* @var Platform $data */
                                    return Html::a($data->name, ['view', 'id' => $data->id]) . '<small class="text-muted">(ID: ' . $data->id . ')</small>';
                                },
                            ],
                            [
                                'label' => 'Status',
                                'attribute' => 'status',
                                'contentOptions' => ['style' => 'width: 150px'],
                                'format' => 'raw',
                                'filter' => Region::getStatusNames(),
                                'value' => function ($data) {
                                    /* @var Platform $data */
                                    return $data->getStatusName();
                                },
                            ],
                            [
                                'attribute' => 'created_at',
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'width: 200px;'],
                            ],
                            [
                                'attribute' => 'updated_at',
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'width: 200px;'],
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'contentOptions' => ['style' => 'width: 110px'],
                                'template' => '{new_action1} {new_action2}',
                                'buttons' => [
                                    'new_action1' => function ($url, $model, $key) {
                                        return Html::a(
                                            'Edytuj',
                                            ['update', 'id' => $model->id],
                                            ['title' => 'Edytuj', 'class' => 'btn btn-primary btn-xs']
                                        );
                                    },
                                    'new_action2' => function ($url, $model, $key) {
                                        return Html::a(
                                            'Usuń',
                                            ['delete', 'id' => $model->id],
                                            [
                                                'title' => 'Usuń', 'class' => 'btn btn-danger btn-xs',
                                                'data-confirm' => 'Are you sure to delete this item?',
                                                'data-method' => 'post'
                                            ]
                                        );
                                    },
                                ],
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>
