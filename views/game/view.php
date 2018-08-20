<?php

use app\components\Helpers;
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
                            <h4 class="media-heading">Region</h4>
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
                            <h4 class="media-heading">Platform</h4>
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
                            <h4 class="media-heading">Type</h4>
                            <?= $model->getTypeName() ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9 col-lg-offset-2">
                    <p class="lead product-price text-right" style="marg">
                        Price <?= $model->price ?> <i class="fa fa-eur" aria-hidden="true"></i>
                    </p>
                </div>

                <div class="col-md-9 col-lg-offset-2 text-center">
                    <a href="#" class="btn btn-success btn-lg btn-block">BUY NOW</a>
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
                        Product description
                    </a>
                </li>
                <li role="presentation">
                    <a href="#requirements" aria-controls="requirements" role="tab" data-toggle="tab">
                        System requirements
                    </a>
                </li>
                <li role="presentation">
                    <a href="#videos" aria-controls="videos" role="tab" data-toggle="tab">
                        Videos
                    </a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fede in active" id="description">

                    <div class="row">
                        <div class="col-md-3">
                            <h2 class="product-tab">Product description</h2>
                        </div>
                        <div class="col-md-9">
                            <div style="margin-top: 20px;">
                                <?= $model->description ?>
                            </div>
                        </div>
                    </div>

                </div>
                <div role="tabpanel" class="tab-pane fade" id="requirements">

                    <div class="row">
                        <div class="col-md-3">
                            <h2 class="product-tab">System requirements</h2>
                        </div>
                        <div class="col-md-9">
                            <div style="margin-top: 20px;">

                                <p>
                                    Below are the minimum and recommended system specifications for
                                    <strong><?= Html::encode($model->name) ?></strong>. Due to potential programming
                                    changes, the minimum system
                                    requirements for <strong><?= Html::encode($model->name) ?></strong> may change over
                                    time.
                                </p>

                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Minimal requirements</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($model->getRequirements()['recommended'] as $key => $requirement): ?>
                                                <tr>
                                                    <td><?= Helpers::correctRequirements($key) ?>:</td>
                                                    <td><?= $requirement ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Recommended requirements</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($model->getRequirements()['recommended'] as $key => $requirement): ?>
                                                <tr>
                                                    <td><?= Helpers::correctRequirements($key) ?>:</td>
                                                    <td><?= $requirement ?></td>
                                                </tr>
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
                            <h2 class="product-tab">Videos</h2>
                        </div>
                        <div class="col-md-9">
                            <div style="margin-top: 20px;">
                                <?= $model->description ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


</div>
