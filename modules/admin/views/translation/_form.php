<?php

use app\modules\admin\models\Language;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Translation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="translation-form">
    <div class="row">
        <?php $form = ActiveForm::begin(); ?>

        <div class="col-md-6">
            <?= $form->field($model, 'phrase')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'translation')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'scope')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'language_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Language::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Język...'],
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
