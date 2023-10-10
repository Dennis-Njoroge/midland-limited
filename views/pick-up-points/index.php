<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PickUpPointsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pick Up Points';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pick-up-points-index">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">Pick-up Points</h4>
                    <p class="card-category">View all pick up points</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="pull-right">
                                <?= Html::a('Create Pick-up Point', ['create'], ['class' => 'btn btn-info']) ?>
                            </p>

                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <?php Pjax::begin(); ?>
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $searchModel,
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn'],
                                        'p_name',
                                        'charge',

                                        ['class' => 'yii\grid\ActionColumn'],
                                    ],
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
