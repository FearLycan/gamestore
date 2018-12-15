<?php

use app\components\Helpers;
use app\components\Price;
use app\components\Translator;
use app\models\Cart;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Game */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Games', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss(".help-block { width: 200px; text-align: left; }");

?>
    <div class="game-view">

        <div class="row">
            <div class="col-md-3">
                <img class="img-responsive" src="<?= $model->smallImage ?>">
            </div>
            <div class="col-md-9">
                <h1 class="product-name"><?= Html::encode($this->title) ?></h1>

                <hr>

                <div class="row">
                    <div class="col-lg-3 col-lg-offset-2">
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-globe fa-3x" aria-hidden="true"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"> <?= Translator::translate('Region') ?> </h4>
                                <?= $model->region->name ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-th-large fa-3x" aria-hidden="true"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><?= Translator::translate('Platform') ?></h4>
                                <?= $model->platform->name ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-list-alt fa-3x" aria-hidden="true"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><?= Translator::translate('Type') ?></h4>
                                <?= $model->getTypeName() ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-9 col-lg-offset-2">
                        <p class="text-right" style="margin-top: 30px;">
                            <small>
                                <?= Translator::translate('Code') ?>: <?= Html::encode($model->g2a_id) ?><br>
                                <?= Translator::translate('QTY') ?>: <?= Html::encode($model->qty) ?>
                            </small>
                        </p>
                        <p class="lead product-price text-right" style="margin-top: 0px;">
                            <?= Translator::translate('Price') ?> <?= Price::get($model->price) ?>
                        </p>
                    </div>

                    <div class="col-md-9 col-lg-offset-2">

                        <div class="row">
                            <?php Pjax::begin(['id' => 'cpjax']); ?>
                            <?= $this->render('_cart-form', [
                                'model' => $cart,
                            ]) ?>


                            <?php if (Yii::$app->session->hasFlash('cart-success')): ?>

                                <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">
                                                    <?= Translator::translate('A new game has been added to your Shopping Cart.') ?>
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <h3>
                                                            <?= Html::encode($model->name) ?><br>
                                                            <small><?= Translator::translate('is in your cart.') ?></small>
                                                        </h3>

                                                        <a class="btn btn-warning pull-left"
                                                           href="<?= Url::to(['/games']) ?>" data-pjax="0">
                                                        <?= Translator::translate('Buy more') ?>
                                                        </a>
                                                        <a class="btn btn-success pull-right" data-pjax="0"
                                                           href="<?= Url::to(['cart/index']) ?>">
                                                            <?= Translator::translate('Go to cart') ?>
                                                        </a>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <hr>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <h4>
                                                            <?= Translator::translate('YOU MIGHT ALSO LIKE') ?>
                                                        </h4>
                                                        <hr>
                                                    </div>

                                                    <?php foreach (Cart::getCross($model->id) as $game): ?>

                                                        <div class="col-sm-6 col-md-4">

                                                            <div class="thumbnail product">
                                                                <a href="<?= Url::to(['game/view', 'slug' => $game->slug]) ?>" data-pjax="0">
                                                                    <img src="<?= $game->smallImage ?>"
                                                                         alt="<?= Html::encode($game->name) ?>">
                                                                </a>
                                                                <div class="caption">

                                                                    <h4 class="group inner list-group-item-heading">
                                                                        <a href="<?= Url::to(['game/view', 'slug' => $game->slug]) ?>" data-pjax="0">
                                                                            <?= Helpers::cutThis(Html::encode($game->name), 40) ?>
                                                                        </a>
                                                                    </h4>

                                                                    <p class="lead lead-price text-right">
                                                                        <?= Price::get($game->price) ?>
                                                                    </p>
                                                                    <p style="text-align: center;">
                                                                        <a href="<?= Url::to(['game/view', 'slug' => $game->slug]) ?>" data-pjax="0"
                                                                           class="btn btn-primary btn-block">
                                                                            <?= Translator::translate('Check this game') ?>
                                                                        </a>
                                                                    </p>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a class="btn btn-warning pull-left" href="<?= Url::to(['/games']) ?>">
                                                    <?= Translator::translate('Buy more') ?>
                                                </a>
                                                <a class="btn btn-success pull-right"
                                                   href="<?= Url::to(['cart/index']) ?>">
                                                    <?= Translator::translate('Go to cart') ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php endif; ?>

                            <?php Pjax::end(); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#description" aria-controls="description" role="tab" data-toggle="tab">
                            <?= Translator::translate('Product description') ?>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#requirements" aria-controls="requirements" role="tab" data-toggle="tab">
                            <?= Translator::translate('System requirements') ?>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#videos" aria-controls="videos" role="tab" data-toggle="tab">
                            <?= Translator::translate('Videos') ?>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#pegi" aria-controls="pegi" role="tab" data-toggle="tab">
                            <?= Translator::translate('PEGI') ?>
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fede in active" id="description">

                        <div class="row">
                            <div class="col-md-3">
                                <h2 class="product-tab"><?= Translator::translate('Product description') ?></h2>
                            </div>
                            <div class="col-md-9">
                                <div style="margin-top: 20px;">

                                    <table class="table table-striped table-bordered">
                                        <tbody>
                                        <tr>
                                            <th width="150"><?= Translator::translate('Developer') ?></th>
                                            <td><?= Html::encode($model->developer) ?></td>
                                        </tr>
                                        <tr>
                                            <th width="150"><?= Translator::translate('Publisher') ?></th>
                                            <td><?= Html::encode($model->publisher) ?></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <?= $model->description ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="requirements">

                        <div class="row">
                            <div class="col-md-3">
                                <h2 class="product-tab"><?= Translator::translate('System requirements') ?></h2>
                            </div>
                            <div class="col-md-9">
                                <div style="margin-top: 20px;">

                                    <p>
                                        Below are the minimum and recommended system specifications for
                                        <strong><?= Html::encode($model->name) ?></strong>.
                                    </p>
                                    <p>
                                        Due to potential programming changes, the minimum system requirements for
                                        <strong><?= Html::encode($model->name) ?></strong> may change over time.
                                    </p>

                                    <div class="row" style="margin-top: 30px;">

                                        <div class="col-md-12 text-center">
                                            <h3>Windows</h3>
                                        </div>

                                        <div class="col-md-6">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th colspan="2"><?= Translator::translate('Minimal requirements') ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($model->getRequirements()['minimal'] as $key => $requirement): ?>
                                                    <?php if (!empty(trim($requirement))): ?>
                                                        <tr>
                                                            <td>
                                                                <small><?= Helpers::correctRequirements($key) ?></small>
                                                            </td>
                                                            <td><?= $requirement ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th colspan="2"><?= Translator::translate('Recommended requirements') ?></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($model->getRequirements()['recommended'] as $key => $requirement): ?>
                                                    <?php if (!empty(trim($requirement))): ?>
                                                        <tr>
                                                            <td>
                                                                <small><?= Helpers::correctRequirements($key) ?></small>
                                                            </td>
                                                            <td><?= $requirement ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="videos">

                        <div class="row">
                            <div class="col-md-3">
                                <h2 class="product-tab"> <?= Translator::translate('Videos') ?></h2>
                            </div>
                            <div class="col-md-9">
                                <div style="margin-top: 20px;">
                                    <?php foreach ($model->getVideos() as $video): ?>

                                        <?php if ($video['type'] == 'YOUTUBE'): ?>
                                            <iframe width="100%" height="460" src="<?= $video['url'] ?>" frameborder="0"
                                                    allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                        <?php endif; ?>

                                        <hr>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="pegi">

                        <div class="row">
                            <div class="col-md-3">
                                <h2 class="product-tab"><?= Translator::translate('PEGI') ?></h2>
                            </div>
                            <div class="col-md-9">
                                <div style="margin-top: 20px;">
                                    <?php foreach ($model->getRestrictions() as $name => $restriction): ?>

                                        <?php if ($restriction): ?>
                                            <div class="col-md-3">
                                                <div class="thumbnail">
                                                    <img class="img-responsive"
                                                         src="<?= Url::to(['/images/PEGI/' . $name . '.jpg']) ?>"
                                                         alt="<?= $name ?>">
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

<?php $this->beginBlock('script') ?>
    <script>
        $('#myModal').modal('show');
    </script>
<?php $this->endBlock(); ?>