<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\components\Helpers;
use app\models\Currency;
use app\models\Language;
use kartik\growl\Growl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use app\assets\AppAsset;
use app\components\Translator;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <div class="above-nav">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <?= Html::beginForm(['site/language'], 'post', ['data-pjax' => '1', 'id' => 'language-form']); ?>
                    <div class="form-group">
                        <?= Html::dropDownList('language', Yii::$app->language, ArrayHelper::map(Language::find()->orderBy(['name' => SORT_ASC])->all(), 'short_name', 'name'),
                            ['class' => 'form-control language-dropdown']) ?>
                    </div>
                    <?= Html::endForm() ?>
                </div>
                <div class="col-md-2">
                    <?= Html::beginForm(['site/currency'], 'post', ['data-pjax' => '1', 'id' => 'currency-form']); ?>
                    <div class="form-group">
                        <?= Html::dropDownList('currency', Yii::$app->params['currency'], ArrayHelper::map(Currency::find()->where(['status' => Currency::STATUS_ACTIVE])->orderBy(['name' => SORT_ASC])->all(), 'code', 'code'),
                            ['class' => 'form-control language-dropdown']) ?>
                    </div>
                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $itemsLeft[] = ['label' => Translator::translate('Games'), 'url' => ['/games']];

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $itemsLeft,
    ]);

    echo "<div id='nav-form' class=\"col-sm-3 col-md-6\"><form data-pjax=\"1\" class=\"navbar-form\" method='get' action='" . \yii\helpers\Url::to(['/games']) . "'>
            <div class=\"form-group\">
              <input name=\"search\" id='nav-search' type=\"text\" placeholder='" . Translator::translate('Search') . "' class=\"form-control\">
            </div></form></div>";

    if (Yii::$app->user->isGuest) {
        $itemsRight[] = ['label' => Translator::translate('Sign in'), 'url' => ['/auth/login']];
        $itemsRight[] = ['label' => Translator::translate('Sign up'), 'url' => ['/auth/registration']];
    } else {
        $itemsRight[] = [
            'label' => Yii::$app->user->identity->name,
            'items' => [
                ['label' => 'Profil', 'url' => '#'],
                '<li class="divider"></li>',
                '<li>'
                . Html::beginForm(['/auth/logout'], 'post')
                . Html::submitButton(
                    'Wyloguj się',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>',
            ],
        ];
    }

    $itemsRight[] = ['label' => '<i class="fa fa-shopping-cart" aria-hidden="true"></i> (' . Helpers::cart() . ')', 'url' => ['cart/index']];


    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $itemsRight,
        'encodeLabels' => false,
    ]);
    NavBar::end();
    ?>

    <div class="scrollbar" id="style-2">
        <div class="force-overflow"></div>
    </div>

    <?php foreach (Yii::$app->session->getAllFlashes() as $key => $session): ?>
        <?= Growl::widget([
            'type' => $key,
            'body' => $session['message'],
            'showSeparator' => true,
            'delay' => 200,
            'pluginOptions' => [
                'showProgressbar' => true,
                'placement' => [
                    'from' => 'top',
                    'align' => 'right',
                    'timer' => 850,
                ]
            ]
        ]); ?>
    <?php endforeach; ?>

    <div class="container">
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>

<?= $this->blocks['script'] ?>

<script>
    $("#language-form select").on('change', function () {
        $(this).closest('form').submit();
    });

    $("#currency-form select").on('change', function () {
        $(this).closest('form').submit();
    });

    $('.navbar').affix({
        offset: {top: 30}
    });
</script>

<script>
    var options = {
        url: function (phrase) {
            return "<?= Url::to(['site/json'], true) ?>?phrase=" + encodeURIComponent(phrase);
        },
        getValue: function (element) {
            return element.name;
        },
        list: {
            onClickEvent: function () {
                var value = $("#nav-search").getSelectedItemData().link;

                window.location = value;

            }
        },
        template: {
            type: "custom",
            method: function (title, item) {

                var price = '';
                if (item.type == 'game') {
                    price = '<p class="text-left">' + item.price + '<i class="fa fa-eur" aria-hidden="true"></i></p>';
                }


                return '<div class="row">' +
                    '<div class="col-md-2">'
                    + '<img class="img-responsive" src="' + item.img + '">'
                    + '</div>' +
                    '<div class="col-md-10"><strong>' +
                    item.name +
                    '</strong>' + price + '</div>'
                    + '</div>';
            }
        },
        requestDelay: 300
    };

    $("#nav-search").easyAutocomplete(options);

</script>

</body>
</html>
<?php $this->endPage() ?>
