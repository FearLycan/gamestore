<?php

use app\components\Translator;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;

/* @var $model \app\models\forms\RegistrationForm */

?>

<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['class' => 'form-default'],
]) ?>

<h2 class="text-center"><?= Translator::translate('Sign up') ?></h2>

<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-6">
        <?= $form->field($model, 'name', [
            'addon' => ['prepend' => ['content' => '<i class="fa fa-user" aria-hidden="true"></i>']]
        ])->textInput(['placeholder' => Translator::translate('Name')])->label(false); ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'email', [
            'addon' => ['prepend' => ['content' => '<i class="fa fa-envelope" aria-hidden="true"></i>']]
        ])->textInput(['placeholder' => Translator::translate('E-mail address')])->label(false); ?>
    </div>
</div>

<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-6">
        <?= $form->field($model, 'password_first', [
            'addon' => ['prepend' => ['content' => '<i class="fa fa-lock"></i></span>']],
        ])->passwordInput(['placeholder' => Translator::translate('Password')])->label(false); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'password_second', [
            'addon' => ['prepend' => ['content' => '<i class="fa fa-repeat"></i></span>']],
        ])->passwordInput(['placeholder' => Translator::translate('Repeat password')])->label(false); ?>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary login-btn btn-block"><?= Translator::translate('Sign up') ?></button>
</div>

<?php ActiveForm::end() ?>

<p class="text-center text-muted small"> <?= Translator::translate('Already have an account?') ?> <a href="<?= Url::to(['auth/login']) ?>"><?= Translator::translate('Sing up here!') ?></a></p>

