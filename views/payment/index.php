<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-index">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">Payments</h4>
                    <p class="card-category">View all payments made</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="pull-right">
                                <?= Html::a('Create Payment', ['create'], ['class' => 'btn btn-success']) ?>
                            </p>
                            <?= ExportMenu::widget([
                                'dataProvider' => $dataProvider,
                                'columns' =>[
                                    [
                                        'class' => 'kartik\grid\SerialColumn',
                                        'pageSummary'=>'Total Amount',
                                        'pageSummaryOptions' => ['colspan' => 5],

                                    ],
                                    'transaction_no',
                                    'payment_mode',
                                    'paid_by',
                                    [
                                        'label'=>'Date',
                                        'attribute'=>'created_on',
                                        'format'=>'date',
                                    ],
                                    [
                                        'attribute'=>'amount',
                                        'format' => ['decimal', 2],
                                        'hAlign'=>'right',
                                        'pageSummary' => true,
                                        'footer' => true,

                                    ],
                                    [
                                        'class' => 'kartik\grid\ActionColumn',
                                        'visibleButtons'=>[
                                            'update'=>false,
                                            'delete'=>false,
                                        ]
                                    ],

                                ],
                            ]);?>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <?php Pjax::begin(); ?>
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $searchModel,
                                    'columns' => [
                                        [
                                                'class' => 'kartik\grid\SerialColumn',
                                            'pageSummary'=>'Total Amount',
                                            'pageSummaryOptions' => ['colspan' => 5],

                                        ],
                                        'transaction_no',
                                        'payment_mode',
                                        'paid_by',
                                        [
                                            'label'=>'Date',
                                            'attribute'=>'created_on',
                                            'format'=>'date',
                                        ],
                                        [
                                            'attribute'=>'amount',
                                            'format' => ['decimal', 2],
                                            'hAlign'=>'right',
                                            'pageSummary' => true,
                                            'footer' => true,

                                        ],
                                        [
                                            'class' => 'kartik\grid\ActionColumn',
                                            'visibleButtons'=>[
                                                    'update'=>false,
                                                    'delete'=>false,
                                            ]
                                        ],

                                    ],
                                    'toggleDataContainer' => ['class' => 'btn-group mr-2'],
                                    // set export properties
                                    'export' => [
                                        'fontAwesome' => true
                                    ],
                                    // parameters from the demo form
                                    'bordered' => true,
                                    'striped' => true,
                                    'condensed' => false,
                                    'responsive' => true,
                                    'hover' => true,
                                    'showPageSummary' => true,

                                ]); ?>
                                <?php Pjax::end(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
