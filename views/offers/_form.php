<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Offers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="offers-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php
        echo $form->field($model, 'countriesArray')->widget(\kartik\select2\Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map($countries, 'id', 'code'),
                'options' => ['placeholder' => 'Выберите страны', 'multiple' => true],
                'maintainOrder' => true,
                'showToggleAll' => false,
                'pluginOptions' => [
                    'tags' => true,
                    'tokenSeparators' => [',', ' '],
                    'maximumInputLength' => 10
                ],
            ])->label('Tag Multiple');
    ?>

    <?= $form->field($model, 'network_id')->dropDownList(\yii\helpers\ArrayHelper::map($networks, 'id', 'name')) ?>

    <?= $form->field($model, 'internal_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'payout')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
