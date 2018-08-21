<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use kartik\growl\Growl;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

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
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $itemsLeft[] = ['label' => 'Gry', 'url' => ['/games']];

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $itemsLeft,
    ]);

    echo "<div id='nav-form' class=\"col-sm-3 col-md-6\"><form data-pjax=\"1\" class=\"navbar-form\" method='get' action='" . \yii\helpers\Url::to(['/games']) . "'>
            <div class=\"form-group\">
              <input name=\"search\" id='nav-search' type=\"text\" placeholder=\"Search\" class=\"form-control\">
            </div></form></div>";

    if (Yii::$app->user->isGuest) {
        $itemsRight[] = ['label' => 'Zaloguj się', 'url' => ['/auth/login']];
        $itemsRight[] = ['label' => 'Zarejestruj się', 'url' => ['/auth/registration']];
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


    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $itemsRight,
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


    /* $("#nav-form").hover(function () {
         $(this).removeClass('col-md-5').addClass('col-md-7');
         $('#eac-container-nav-search ul').delay(200).css('display', 'block');
     }, function () {
         $(this).removeClass('col-md-7').addClass('col-md-5');
         $('#eac-container-nav-search ul').css('display', 'none');
     });*/


    /*$( "#nav-form" ).click(function() {
        $(this).removeClass('col-md-5').addClass('col-md-7')
    });*/
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
