<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ExecutorAuthoritySerach */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="executor-authority-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'mini_name') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'details') ?>

    <?= $form->field($model, 'phones') ?>

    <?php // echo $form->field($model, 'emails') ?>

    <?php // echo $form->field($model, 'address') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
