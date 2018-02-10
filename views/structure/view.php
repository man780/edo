<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Structure */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Structures'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="structure-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <!--<p>
        <?/*= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) */?>
        <?/*= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) */?>
    </p>-->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'num',
            'name',
        ],
    ]) ?>

    <div class="row">
        <div class="col-md-6">
            <div class="well">
                <h4>Кирувчи хатлар</h4>
                <?foreach($model->mailsIncomings as $mails):?>
                    <?=Html::a($mails->in_num, ['mails-incoming/view', 'id' => $mails->id]);?>
                <?endforeach?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="well">
                <h4>Чиқувчи хатлар</h4>
                <?foreach($model->mailsOutgoings as $mails):?>
                    <?=Html::a($mails->num, ['mails-outgoing/view', 'id' => $mails->id]);?>
                <?endforeach?>
            </div>
        </div>
    </div>

</div>
