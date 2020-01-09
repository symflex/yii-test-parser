<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Offers */

$this->title = 'Create Offers';
$this->params['breadcrumbs'][] = ['label' => 'Offers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'countries' => $countries,
        'networks' => $networks
    ]) ?>

</div>
