<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MailsOutgoingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mails-outgoing-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'num') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'organization') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'result') ?>

    <?php // echo $form->field($model, 'dcreated') ?>

    <?php // echo $form->field($model, 'bycreated') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
