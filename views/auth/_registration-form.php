<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;

/* @var $model \app\models\forms\RegistrationForm */

?>

<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['class' => 'form-default'],
]) ?>

<h2 class="text-center">Zarejestruj się</h2>

<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-6">
        <?= $form->field($model, 'name', [
            'addon' => ['prepend' => ['content' => '<i class="fa fa-user" aria-hidden="true"></i>']]
        ])->textInput(['placeholder' => 'Nazwa'])->label(false); ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'email', [
            'addon' => ['prepend' => ['content' => '<i class="fa fa-envelope" aria-hidden="true"></i>']]
        ])->textInput(['placeholder' => 'Adres e-mail'])->label(false); ?>
    </div>
</div>

<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-6">
        <?= $form->field($model, 'password_first', [
            'addon' => ['prepend' => ['content' => '<i class="fa fa-lock"></i></span>']],
        ])->passwordInput(['placeholder' => 'Password'])->label(false); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'password_second', [
            'addon' => ['prepend' => ['content' => '<i class="fa fa-repeat"></i></span>']],
        ])->passwordInput(['placeholder' => 'Powtórz hasło'])->label(false); ?>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary login-btn btn-block">Zarejestruj się</button>
</div>
<div class="clearfix"></div>
<div class="or-seperator"><i>or</i></div>
<p class="text-center">Login with your social media account</p>
<div class="text-center social-btn">
    <a href="#" class="btn btn-primary"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
    <a href="#" class="btn btn-info"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
    <a href="#" class="btn btn-danger"><i class="fa fa-google"></i>&nbsp; Google</a>
</div>

<?php ActiveForm::end() ?>

<p class="text-center text-muted small">Masz już konto? <a href="<?= Url::to(['auth/login']) ?>">Zaloguj się tutaj!</a></p>

