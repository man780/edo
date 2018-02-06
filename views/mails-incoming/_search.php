<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MailsIncomingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mails-incoming-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'in_num') ?>

    <?= $form->field($model, 'in_date') ?>

    <?= $form->field($model, 'out_num') ?>

    <?= $form->field($model, 'out_date') ?>

    <?php // echo $form->field($model, 'organization') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'deadline') ?>

    <?php // echo $form->field($model, 'result') ?>

    <?php // echo $form->field($model, 'dcreated') ?>

    <?php // echo $form->field($model, 'bycreated') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
