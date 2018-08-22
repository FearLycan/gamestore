<?php

use app\modules\admin\models\Language;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Language */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="language-form">
    <div class="row">
        <?php $form = ActiveForm::begin(); ?>

        <div class="col-md-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->hint('Name like Polski or English') ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'short_name')->textInput(['maxlength' => true])->hint('Short Name like pl or en') ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'language_tag')->textInput(['maxlength' => true])->hint('Language tag like PL-pl or en-US') ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'status')->widget(Select2::classname(), [
                'data' => Language::getStatusNames(),
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
