<?php

use app\components\Translator;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = Translator::translate('Order list');

$this->registerCss(".label{
    font-size: 15px;
    text-align: center;
    display: block;
    padding: 5px 0;} table > thead > tr > th{text-align:center;} a:hover{text-decoration:none;} ");

?>

<div class="order-index">
    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            <h1>
                <?= $this->title ?>
            </h1>
            <hr>
        </div>

        <div class="col-md-12">

            <?php echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget(['dataProvider' => $dataProvider,
                'layout' => "{items}\n{summary}\n{pager}",
                'columns' => [
                    [
                        'attribute' => 'hash',
                        'label' => Translator::translate('Order code'),
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width: 150px;'],
                        'value' => function ($data) {
                            /* @var \app\models\Order $data */
                            return '<a href="' . Url::to(['order/view', 'hash' => $data->hash]) . '"><span class="label label-primary">' . strtoupper(substr($data->hash, 0, 10)) . '</span></a>';
                        },
                    ],
                    [
                        'attribute' => 'created_at',
                        'label' => Translator::translate('Created at'),
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width: 200px; text-align:center;'],
                    ],
                    [
                        'attribute' => 'status',
                        'label' => Translator::translate('Status'),
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width: 150px; text-align:center;'],
                        'value' => function ($data) {
                            /* @var \app\models\Order $data */
                            return 'Done';
                        },
                    ],
                    [
                        'attribute' => 'price',
                        'label' => Translator::translate('Price'),
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width: 150px; text-align:center;'],
                        'value' => function ($data) {
                            /* @var \app\models\Order $data */
                            return round($data->price * $data->currency_rate, 2) . ' ' . $data->currency->short_name;
                        },
                    ],
                    [
                        'label' => '',
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width: 80px; text-align:center;'],
                        'value' => function ($data) {
                            /* @var \app\models\Order $data */
                            return \yii\helpers\Html::a(Translator::translate('Check'), ['order/view', 'hash' => $data->hash], ['class' => 'btn btn-success btn-sm']);
                        },
                    ],
                ],
            ]); ?>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>
