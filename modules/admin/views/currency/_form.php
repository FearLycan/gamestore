<?php

use app\models\Currency;
use app\modules\admin\models\forms\CurrencyForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Currency */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="currency-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->hint('złoty, euro, dolar') ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'short_name')->textInput(['maxlength' => true])->hint('zł, $') ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true])->hint('PLN, USD') ?>
        </div>

        <?php if (Yii::$app->controller->action->id == 'create'): ?>
            <div class="col-md-2">
                <?= $form->field($model, 'rate')->textInput(['maxlength' => true])->hint('Based on euro') ?>
            </div>
        <?php else: ?>
            <div class="col-md-2">
                <?= $form->field($model, 'rate')->textInput(['maxlength' => true, 'disabled' => true])->hint('Based on euro') ?>
            </div>
        <?php endif; ?>

    </div>

    <div class="row">

        <div class="col-md-2">
            <?= $form->field($model, 'side')->widget(Select2::classname(), [
                'data' => Currency::getSidesNames(),
                'options' => ['placeholder' => 'Side'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'status')->widget(Select2::classname(), [
                'data' => Currency::getStatusNames(),
                'options' => ['placeholder' => 'Status'],
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
