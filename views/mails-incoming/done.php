<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 10.02.2018
 * Time: 20:25
 */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Бажариш';
?>

<div class="mails-incoming-form-done">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'result')->textarea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>