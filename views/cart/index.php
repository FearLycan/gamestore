<?php

use app\components\Helpers;
use app\components\Price;
use app\components\Translator;
use app\models\PromotionCode;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$promo = PromotionCode::getRandomCode();

$this->title = Translator::translate('Cart');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="cart-index">
    <h1>
        <?= Html::encode($this->title) ?>
    </h1>


    <hr>
    <div class="row">

        <div class="container">

            <?php if (!empty($products)): ?>

                <?php if (!isset($products['promo-code'])): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">×</span></button>
                                Use <strong><?= $promo->code ?></strong> code to get
                                <strong><?= $promo->value ?>%</strong>
                                Off Your Order
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php Pjax::begin(['id' => 'ptable']); ?>
                <table id="cart" class="table table-hover table-condensed">
                    <thead>
                    <tr>
                        <th style="width:50%; text-transform: capitalize;"><?= Translator::translate('Product') ?></th>
                        <th style="width:10%"><?= Translator::translate('Price') ?></th>
                        <th style="width:8%" class="text-center"><?= Translator::translate('Quantity') ?></th>
                        <th style="width:22%" class="text-center"><?= Translator::translate('Subtotal') ?></th>
                        <th style="width:10%"></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($products['items'] as $key => $product): ?>
                        <tr data-id="<?= $product['id'] ?>">
                            <td data-th="Product">
                                <div class="row">
                                    <div class="col-sm-2 hidden-xs">
                                        <a href="<?= Url::to(['game/view', 'slug' => $product['slug']]) ?>">
                                            <img src="<?= $product['smallImage'] ?>" alt="<?= $product['name'] ?>"
                                                 class="img-responsive"/>
                                        </a>
                                    </div>
                                    <div class="col-sm-10">
                                        <a href="<?= Url::to(['game/view', 'slug' => $product['slug']]) ?>">
                                            <h4 class="nomargin"><?= Html::encode($product['name']) ?></h4>
                                        </a>
                                        <p>
                                            <?= Helpers::cutThis($product['description'], 150) ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Price"> <?= Price::get($product['price']) ?></td>
                            <td data-th="Quantity">
                                <input data-id="<?= $product['id'] ?>" type="number" min="1"
                                       max="<?= $product['qty'] ?>"
                                       class="form-control text-center"
                                       value="<?= Html::encode($product['quantity']) ?>">
                            </td>
                            <td data-th="Subtotal" class="text-center">
                                <?= Price::get($product['price'] * $product['quantity']) ?>
                            </td>
                            <td class="actions text-center">
                                <?= Html::a('<i class="fa fa-refresh"></i>', ['cart/index'],
                                    ['class' => 'btn btn-info btn-sm', 'style' => 'display:none;']); ?>

                                <a href="<?= Url::to(['cart/remove-item', 'id' => $product['id']]) ?>"
                                   class="btn btn-danger btn-sm"
                                   title="<?= Translator::translate('Remove') ?>"
                                   data-confirm="<?= Translator::translate('Are you sure to delete this item?') ?>"
                                   data-method="post">
                                    <i class="fa fa-trash-o"></i>
                                </a>

                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                    <tfoot>
                    <tr>
                        <td>
                            <div class="row">

                                <?php if (isset($products['promo-code'])): ?>
                                    <div class="col-md-5 ref" style="margin-top: 10px;">
                                        <p>
                                            Code: <strong><?= $products['promo-code']['code'] ?></strong>,
                                                value <strong><?= $products['promo-code']['value'] ?>%</strong>
                                        </p>
                                    </div>
                                    <div class="col-md-6" style="margin-top: 3px;">
                                        <a href="<?= Url::to(['cart/remove-promo']) ?>" class="btn btn-default"
                                           title="<?= Translator::translate('Remove') ?>"
                                           data-confirm="<?= Translator::translate('Are you sure to delete this promo code?') ?>"
                                           data-method="post">
                                            Remove Code
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <?= $this->render('_promo-form', [
                                        'model' => $promoCode,
                                    ]) ?>
                                <?php endif; ?>

                            </div>

                        </td>
                        <td>

                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="visible-xs">
                        <td class="text-center"><strong><?= Price::get($products['total']) ?></strong></td>
                    </tr>
                    <tr>
                        <td>
                            <a href="<?= Url::to(['/games']) ?>" class="btn btn-warning">
                                <i class="fa fa-angle-left"></i> <?= Translator::translate('Continue Shopping') ?>
                            </a>
                        </td>
                        <td colspan="2" class="hidden-xs"></td>
                        <td class="hidden-xs text-center">

                            <?php if (isset($products['total-promo'])): ?>
                                <strike><strong> <?= Price::get($products['total']) ?> </strong></strike><br>
                                <strong> <?= Price::get($products['total-promo']) ?> </strong>
                            <?php else: ?>
                                <strong> <?= Price::get($products['total']) ?> </strong>
                            <?php endif; ?>

                        </td>
                        <td>
                            <a href="<?= Url::to(['cart/summary']) ?>" class="btn btn-success btn-block">
                                <?= Translator::translate('Summary') ?> <i class="fa fa-angle-right"></i>
                            </a>
                        </td>
                    </tr>
                    </tfoot>
                </table>
                <?php Pjax::end() ?>

            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>


        </div>

    </div>
</div>

<?php $this->beginBlock('script') ?>
<script>

    $(document).ready(function () {
        $(".fa-refresh").first().trigger("click");
    });

    $(document).on('ready pjax:success', function () {
        $("input[type=number]").change(function () {

            var id = $(this).attr('data-id');
            var qty = $(this).val();

            $.post("<?= Url::to(['cart/add-item']) ?>", {id: id, qty: qty})
                .done(function () {
                    $.pjax.reload({container: '#ptable'});
                })
                .fail(function () {
                    alert("We got error, we are sorry");
                });
        });

        $help = $('.help-block');
        $promo = $('#promocodeform-code');

        if (($promo.length && $promo.val().length) && !$help.text().length) {
            $.pjax.reload({container: '#ptable'});
        }
    });

</script>
<?php $this->endBlock() ?>
