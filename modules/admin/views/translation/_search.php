<?php

use app\modules\admin\models\Language;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\searches\TranslationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="translation-search">
    <div class="row">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => [
                'data-pjax' => 1
            ],
        ]); ?>

        <div class="col-md-2 col-lg-offset-7">
            <?= $form->field($model, 'language_id')
                ->dropDownList(ArrayHelper::map(Language::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'))
                ->label(false) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'phrase')->label(false) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>