<?php

use app\models\Genre;
use app\models\Platform;
use app\models\Region;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\searches\GameSearch */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="game-search">

        <?php $form = ActiveForm::begin([
            'action' => [$link['link']],
            'method' => 'get',
            'options' => [
                'data-pjax' => 1
            ],
        ]); ?>

        <div class="filter">
            <h4>Genres</h4>

            <?= $form->field($model, 'genre')
                ->inline(false)
                ->checkboxList(Genre::getGenresNames(), [
                    'itemOptions' => [
                        'class' => 'checkbox-filter',
                    ]])
                ->label(false); ?>

        </div>

        <hr style="margin: 30px 0;">

        <div class="filter">
            <h4>Price</h4>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'min_price')->textInput(['maxlength' => true, 'placeholder' => 'Min price'])->label(false) ?>
                </div>
                <!--<div class="col-md-2 text-center">
                    <div class="form-group">
                        <label class="control-label">-</label>
                    </div>
                </div>-->
                <div class="col-md-6">
                    <?= $form->field($model, 'max_price')->textInput(['maxlength' => true, 'placeholder' => 'Max price'])->label(false) ?>
                </div>
            </div>
        </div>

        <hr style="margin: 30px 0;">

        <div class="filter">
            <h4>Platforms</h4>

            <?= $form->field($model, 'platform')
                ->inline(false)
                ->checkboxList(Platform::getPlatformsNames(), [
                    'itemOptions' => [
                        'class' => 'checkbox-filter',
                    ]])
                ->label(false); ?>
        </div>

        <hr style="margin: 30px 0;">

        <div class="filter">
            <h4>Regions</h4>

            <?= $form->field($model, 'region')
                ->inline(false)
                ->checkboxList(Region::getRegionsNames(), [
                    'itemOptions' => [
                        'class' => 'checkbox-filter',
                    ]])
                ->label(false); ?>
        </div>

        <hr style="margin: 30px 0;">

        <?= $form->field($model, 'search')->hiddenInput()->label(false); ?>

        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary btn-block']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


<?php $this->beginBlock('script') ?>
    <script>
        search = $("#search").val();
        $("#nav-search").val(search);

        $("#nav-search").change(function () {
            search = $(this).val();
            $("#search").val(search);
        });
    </script>
<?php $this->endBlock() ?>