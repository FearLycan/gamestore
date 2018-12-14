<?php

use app\components\Translator;
use app\models\forms\CartForm;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    //'enableAjaxValidation' => true,
    'options' => ['data' => ['pjax' => true]],
]) ?>

<div class="col-md-2">
    <?= $form->field($model, 'qty')->textInput(['type' => 'number', 'min' => CartForm::MIN_QTY, 'style' => 'min-height:35px;'])->label(false); ?>
</div>
<div class="col-md-10">
    <button type="submit" class="btn btn-success btn-block"><?= Translator::translate('ADD TO CART') ?></button>
</div>

<?php ActiveForm::end() ?>
