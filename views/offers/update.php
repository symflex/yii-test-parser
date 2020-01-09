<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Offers */

$this->title = 'Update Offers: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Offers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="offers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'countries' => $countries,
        'networks' => $networks
    ]) ?>

</div>
