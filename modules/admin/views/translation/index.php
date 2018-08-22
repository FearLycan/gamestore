<?php

use app\modules\admin\models\Language;
use app\modules\admin\models\Translation;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\searches\TranslationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Translations';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="translation-index">



        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <h3 class="panel-title pull-left">
                            <i class="fa fa-font" aria-hidden="true"></i> Tłumaczenia
                        </h3>
                        <div class="btn-group pull-right">
                            <a href="<?= Url::to(['create']) ?>" class="btn btn-success btn-sm">Dodaj</a>
                        </div>
                    </div>
                    <div class="panel-body">

                        <?= $this->render('_search', ['model' => $searchModel]); ?>

                        <?= GridView::widget([
                            'id' => 'translations',
                            'dataProvider' => $dataProvider,
                            'layout' => "{items}\n{summary}\n{pager}",
                            'columns' => [
                                [
                                    'attribute' => 'id',
                                    'label' => '#',
                                    'contentOptions' => ['style' => 'width: 60px;'],
                                ],
                                ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['style' => 'width: 60px;']],
                                'phrase',
                                'translation',
                                [
                                    'label' => 'Language',
                                    'attribute' => 'language_id',
                                    'contentOptions' => ['style' => 'width: 150px'],
                                    'format' => 'raw',
                                    'filter' => ArrayHelper::map(Language::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'),
                                    'value' => function ($data) {
                                        /* @var Translation $data */
                                        return $data->language->name;
                                    },
                                ],
                                [
                                    'attribute' => 'scope',
                                    'contentOptions' => ['style' => 'width: 150px'],
                                ],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->registerJsFile(Yii::getAlias('@web') . '/administrator/js/plugins/EditTable/jquery.tabledit.min.js', ['depends' => [yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerCss(".table > tbody > tr.warning > td{background-color: #dff0d8;}"); ?>
<?php $this->beginBlock('script') ?>
    <script>
        $('form select').on('change', function () {
            $(this).closest('form').submit();
        })
    </script>

    <script>
        $('#translations table').Tabledit({
            url: '<?= Url::to(['translation/update-table']) ?>',
            deleteButton: false,
            saveButton: true,
            editButton: true,
            autoFocus: true,
            hideIdentifier: true,
            inputClass: 'form-control',
            buttons: {
                edit: {
                    class: 'btn btn-sm btn-primary',
                    html: '<span class="glyphicon glyphicon-pencil"></span> &nbsp EDIT',
                    action: 'edit'
                },
                save: {
                    class: 'btn btn-sm btn-success',
                    html: '<span class="glyphicon glyphicon-floppy-disk"></span> &nbsp Save'
                }
            },
            columns: {
                identifier: [0, 'id'],
                editable: [[3, 'translation']]
            },
            onSuccess: function (data, textStatus, jqXHR) {

                if (data['success']) {
                    console.log('victory!');
                }

                console.log('onSuccess(data, textStatus, jqXHR)');
                console.log(data);
                console.log(textStatus);
                console.log(jqXHR);
            },
        });
    </script>
<?php $this->endBlock() ?>