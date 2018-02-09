<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\MailsIncoming */
/* @var $form yii\widgets\ActiveForm */
$model->in_date =  date('Y-m-d H:i:s', time()+2*3600);
$model->out_date =  date('Y-m-d H:i:s', time()+2*3600);
$model->deadline =  date('Y-m-d H:i:s', time()+3*24*3600);

$items = $model->getUsersAll();

$script = <<< JS
    $('.add-executor').click(function(){
        var executor = $('.executor:last').clone();
        //console.log(executor.find('.executorAuthorities'));
        num = $('.executor').length;
        executor.find('.executorAuthorities').attr('id', 'w'+num);
        $('.executor-list').append(executor);
    });
    $('.remove-executor').click(function(){
        if($('.executor').length > 1)
        $('.executor:last').remove();
    });
JS;
$this->registerJs($script);
?>

<div class="mails-incoming-form">

    <?php $form = ActiveForm::begin([
        //'id' => 'banner-form',
        'options' => [
            'enctype' => 'multipart/form-data'
        ],
    ]); ?>

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

    <?= $form->field($model, 'organization')->widget(Select2::classname(), [
        'data' => $data,
        'language' => 'ru',
        'options' => ['placeholder' => 'Ташкилотни танланг ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'deadline')->textInput()->widget(DateTimePicker::classname(), [
        'language' => 'uz',
        'pluginOptions' => [
            'todayHighlight' => true,
        ],
    ]); ?>

    <?= $form->field($model, 'type')->widget(Select2::classname(), [
        'data' => $model->types,
        'language' => 'ru',
        'options' => ['placeholder' => 'Ташкилотни танланг ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <div class="container  executor-list">
        <?if(!$model->isNewRecord):?>
            <?foreach ($items as $executor):?>
                <div class="row executor">
                    <?=Html::label('Ижро учун масъуллар', 'sourceFinancing')?>
                    <?
                    echo Html::dropDownList('executors[]',null , $items, ['class'=>'form-control']);
                    ?>
                </div>
            <?endforeach;?>
        <?else:?>
            <div class="row executor">
                <?=Html::label('Ижро учун масъуллар', 'sourceFinancing')?>
                <?
                echo Html::dropDownList('executors[]', '', $items, ['class'=>'form-control', 'prompt'=>'']);
                ?>
            </div>
        <?endif;?>
    </div>
    <div class="container row">
        <a href="javascript:void(0);" class="btn btn-success add-executor">+</a>
        <a href="javascript:void(0);" class="btn btn-danger remove-executor">-</a>
    </div>

    <?= $form->field($model, 'files[]')->fileInput(['multiple' => true]);?>

    <?= $form->field($model, 'events')->widget(Select2::classname(), [
        'data' => $events,
        'language' => 'uz',
        'options' => ['placeholder' => 'Тадбирни танланг ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true,
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
