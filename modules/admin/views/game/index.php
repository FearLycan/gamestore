<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\searches\GameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Games';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title pull-left">
                        <i class="fa fa-list" aria-hidden="true"></i> Lista gier
                    </h3>
                </div>
                <div class="panel-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            /* [
                                 'attribute' => 'thumbnail',
                                 'format' => 'raw',
                                 'filter' => false,
                                 'value' => function ($data) {
                                     return Html::img($data->thumbnail);
                                 },
                                 'contentOptions' => ['style' => 'width: 50px;'],
                             ],*/
                            [
                                'attribute' => 'name',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    /* @var \app\models\Game $data */
                                    return Html::a($data->name, ['game/view', 'id' => $data->id]) . '<small class="text-muted">(' . $data->g2a_id . ')</small>';
                                },
                            ],
                            [
                                'attribute' => 'min_price',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    /* @var \app\models\Game $data */
                                    return $data->min_price;
                                },
                                'contentOptions' => ['style' => 'width: 80px; text-align: center;'],
                            ],
                            [
                                'attribute' => 'qty',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    /* @var \app\models\Game $data */
                                    return $data->qty;
                                },
                                'contentOptions' => ['style' => 'width: 80px; text-align: center;'],
                            ],
                            [
                                'attribute' => 'platform',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    /* @var \app\models\Game $data */
                                    return $data->platform;
                                },
                            ],
                            [
                                'attribute' => 'type',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    /* @var \app\models\Game $data */
                                    return $data->type;
                                },
                            ],
                            'region',
                            //'qty',

                            //'price',
                            //'discount',
                            //'thumbnail',
                            //'smallImage',
                            //'description:ntext',
                            //'region',
                            //'developer',
                            //'publisher',
                            //'platform',
                            //'restrictions',
                            //'requirements:ntext',
                            //'videos:ntext',
                            //'status',
                            //'created_at',
                            //'updated_at',

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'contentOptions' => ['style' => 'width: 55px'],
                                'template' => '{new_action1} {new_action2}',
                                'buttons' => [
                                    'new_action1' => function ($url, $model, $key) {
                                        return Html::a(
                                            'Edytuj',
                                            ['game/update', 'id' => $model->id],
                                            ['title' => 'Edytuj', 'class' => 'btn btn-primary btn-xs']
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
