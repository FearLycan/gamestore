<?php

use app\components\Helpers;
use app\components\Price;
use app\components\Translator;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Game */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Games', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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

                            <?php if(isset($model->region)): ?>
                                <?= $model->region->name ?>
                            <?php endif; ?>

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
                    <p class="lead product-price text-right" style="marg">
                        <?= Translator::translate('Price') ?> <?= Price::get($model->price) ?>
                    </p>
                </div>

                <div class="col-md-9 col-lg-offset-2 text-center">
                    <a href="<?= Url::to(['order/create', 'slug' => $model->slug]) ?>" data-method="post"
                       class="btn btn-success btn-lg btn-block"><?= Translator::translate('BUY NOW') ?></a>
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
                                                <th colspan="2">Minimal requirements</th>
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
                                                <th colspan="2">Recommended requirements</th>
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
