<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Translation */

$this->title = $model->phrase;
$this->params['breadcrumbs'][] = ['label' => 'Translations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="translation-view">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title pull-left"><i class="fa fa-font" aria-hidden="true"></i> Tłumaczenie:
                        <strong><?= Html::encode($model->phrase) ?></strong>
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
                            'phrase',
                            'translation',
                            'language_id',
                            'scope',
                            'created_at',
                            'updated_at',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
