<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;

use app\models\Structure;
use app\models\MailsIncoming;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\MailsOutgoing */
/* @var $form yii\widgets\ActiveForm */

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
    
    $('.structure').change(function() {
        var v = $(this).val();
        var num = $('.num').val();
        var num_arr = num.split('-');
        if(num_arr.length > 1 ){
            $('.num').val(v+'-'+num_arr[1]);
        }else{
            $('.num').val(v+'-'+num);
        }
    });
JS;
$this->registerJs($script);

$mailsIn = MailsIncoming::find()->all();
$mailsInList = ArrayHelper::map($mailsIn,'id','in_num');
?>

<div class="mails-outgoing-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mailIncoming')->widget(Select2::classname(), [
        'data' => $mailsInList,
        'language' => 'uz',
        'options' => ['placeholder' => 'Кирувчи хат рақамини танланг ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true,
        ],
    ]) ?>

    <?
    $structures = Structure::find()->all();
    $list = ArrayHelper::map($structures,'num','name');
    $params = [
        'prompt' => 'Бўлимни танланг...',
        'class'=>'form-control structure',
    ];
    echo $form->field($model, 'structure_id')->dropDownList($list,$params);?>

    <?= $form->field($model, 'num')->textInput(['maxlength' => true,  'class' => 'form-control num']) ?>

    <?= $form->field($model, 'date')->widget(DateTimePicker::classname(), [
        'language' => 'uz',
        'pluginOptions' => [
            'todayHighlight' => true,
        ],
    ]); ?>

    <?= $form->field($model, 'organization')->widget(Select2::classname(), [
        'data' => $data,
        'language' => 'ru',
        'options' => ['placeholder' => 'Ташкилотни танланг ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'result')->textInput(['maxlength' => true]) ?>

    <div class="container  executor-list">
        <?if(!$model->isNewRecord):?>
            <?foreach ($items as $executor):?>
                <div class="row executor">
                    <?=Html::label('Ижрочи', 'executors')?>
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
