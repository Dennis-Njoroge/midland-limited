<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Chat */

$this->title = Yii::t('app', 'Create Chat');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Chats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
