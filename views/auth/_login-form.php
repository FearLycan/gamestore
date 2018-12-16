<?php

use app\components\Translator;
use yii\helpers\Url;
use kartik\form\ActiveForm;

/* @var $model \app\models\forms\LoginForm */

?>

<?php $form = ActiveForm::begin([
    'options' => ['class' => 'form-default'],
]) ?>

<h2 class="text-center">
    <?= Translator::translate('Sign in') ?>
</h2>

<?= $form->field($model, 'email', [
    'addon' => ['prepend' => ['content' => '<i class="fa fa-user" aria-hidden="true"></i>']]
])->textInput(['placeholder' => Translator::translate('E-mail address')])->label(false); ?>

<?= $form->field($model, 'password', [
    'addon' => ['prepend' => ['content' => '<i class="fa fa-lock"></i></span>']],
])->passwordInput(['placeholder' => Translator::translate('Password')])->label(false); ?>

<div class="form-group">
    <button type="submit" class="btn btn-primary login-btn btn-block"><?= Translator::translate('Sign in') ?></button>
</div>

<?php ActiveForm::end() ?>

<p class="text-center text-muted small"> <?= Translator::translate('You don\'t have an account?') ?> <a href="<?= Url::to(['auth/registration']) ?>"><?= Translator::translate('Sing up here!') ?></a></p>