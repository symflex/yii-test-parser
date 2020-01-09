<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AdNetworks */

$this->title = 'Create Ad Networks';
$this->params['breadcrumbs'][] = ['label' => 'Ad Networks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ad-networks-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'parsers' => $parsers
    ]) ?>

</div>
