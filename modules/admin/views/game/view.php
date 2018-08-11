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

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'g2a_id',
            'name',
            'type',
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
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
