<?php


use yii\helpers\Url;

$this->title = 'Zaloguj się';

?>

<div class="login-form">
    <?= $this->render('_login-form', [
        'model' => $model,
    ]) ?>
</div>