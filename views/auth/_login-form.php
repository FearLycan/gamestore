<?php

use yii\helpers\Url;
use kartik\form\ActiveForm;

/* @var $model \app\models\forms\LoginForm */

?>

<?php $form = ActiveForm::begin([
    'options' => ['class' => 'form-default'],
]) ?>

<h2 class="text-center">Zaloguj się</h2>

<?= $form->field($model, 'email', [
    'addon' => ['prepend' => ['content' => '<i class="fa fa-user" aria-hidden="true"></i>']]
])->textInput(['placeholder' => 'E-mail address'])->label(false); ?>

<?= $form->field($model, 'password', [
    'addon' => ['prepend' => ['content' => '<i class="fa fa-lock"></i></span>']],
])->passwordInput(['placeholder' => 'Password'])->label(false); ?>

<div class="form-group">
    <button type="submit" class="btn btn-primary login-btn btn-block">Zaloguj się</button>
</div>
<div class="clearfix">

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
        </div>

        <div class="col-md-6">
            <a href="#" class="pull-right">Nie pamiętasz hasła?</a>
        </div>
    </div>


    <!--<label class="pull-left checkbox-inline"><input type="checkbox"> Remember me</label>-->






</div>
<div class="or-seperator"><i>or</i></div>
<p class="text-center">Login with your social media account</p>
<div class="text-center social-btn">
    <a href="#" class="btn btn-primary"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
    <a href="#" class="btn btn-info"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
    <a href="#" class="btn btn-danger"><i class="fa fa-google"></i>&nbsp; Google</a>
</div>

<?php ActiveForm::end() ?>

<p class="text-center text-muted small">Nie masz konta? <a href="<?= Url::to(['auth/registration']) ?>">Zarejestruj się tutaj!</a></p>