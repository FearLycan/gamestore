<?php

use app\components\Translator;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'action' => ['cart/index'],
    'options' => [
        'data' => ['pjax' => '0'],
        'style' => 'margin-top:15px;',
    ],
]) ?>

<div class="col-md-6">
    <?= $form->field($model, 'code')->textInput(['placeholder' => Translator::translate('Promo Code')])->label(false); ?>
</div>
<div class="col-md-6">
    <button type="submit" id="addPromo" class="btn btn-default"><?= Translator::translate('Use Code') ?></button>
</div>

<?php ActiveForm::end() ?>
