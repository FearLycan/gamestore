<?php

use app\modules\admin\models\Game;
use app\modules\admin\models\Genre;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Game */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="game-form">
    <div class="row">
        <?php $form = ActiveForm::begin(); ?>

        <div class="col-md-4">
            <?= $form->field($model, 'min_price')->textInput(['maxlength' => true, 'disabled' => true]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'discount')->textInput() ?>
        </div>


        <div class="col-md-2">
            <?= $form->field($model, 'status')->widget(Select2::classname(), [
                'data' => Game::getStatusNames(),
                'options' => ['placeholder' => 'Status'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'genre')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Genre::find()->where(['status' => Genre::STATUS_ACTIVE])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Gatunki...', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
