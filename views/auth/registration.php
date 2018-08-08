<?php

use yii\helpers\Url;

$this->title = 'Rejestracja';
?>

<?php if ($status == true): ?>
    <section class="slice--offset slice sct-color-1" id="register">
        <div class="container">
            <div class="row">
                <div class="col-md-8 ">
                    <div class="heading-3 strong-300 line-height-1_8">
                        <span class="c-base-1 strong-500"><?= $model->name ?>!</span> Na Twóją pocztę został wysłany
                        link aktywacyjny.
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php else: ?>
    <div class="login-form registration-form">
        <?= $this->render('_registration-form', [
            'model' => $model,
        ]) ?>
    </div>
<?php endif; ?>
