<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use dosamigos\fileupload\FileUploadUI;

/* @var $this yii\web\View */
/* @var $model app\models\MailsIncoming */
/* @var $form yii\widgets\ActiveForm */
$model->in_date =  date('Y-m-d H:i:s', time()+2*3600);
$model->out_date =  date('Y-m-d H:i:s', time()+2*3600);
$model->deadline =  date('Y-m-d H:i:s', time()+3*24*3600);
?>

<div class="mails-incoming-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'in_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'in_date')->widget(DateTimePicker::classname(), [
        'language' => 'uz',
        'pluginOptions' => [
            'todayHighlight' => true,
        ],
    ]);
    ?>

    <?= $form->field($model, 'out_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'out_date')->textInput()->widget(DateTimePicker::classname(), [
        'language' => 'uz',
        'pluginOptions' => [
            'todayHighlight' => true,
        ],
    ]);
    ?>

    <?= $form->field($model, 'organization')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deadline')->textInput()->widget(DateTimePicker::classname(), [
        'language' => 'uz',
        'pluginOptions' => [
            'todayHighlight' => true,
        ],
    ]); ?>

    <?= $form->field($model, 'result')->textInput(['maxlength' => true]) ?>






    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
