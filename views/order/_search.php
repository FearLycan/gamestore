<?php

use app\components\Translator;
use yii\widgets\ActiveForm;

?>

<div class="row">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="col-md-4 col-md-offset-8">
        <?= $form->field($model, 'hash')->textInput(['placeholder' => Translator::translate('Order code')])->label(false) ?>
    </div>

    <input type="submit" style="position: absolute; left: -9999px"/>

    <?php ActiveForm::end(); ?>
</div>

