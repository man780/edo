<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MailsOutgoing */

$this->title = $model->num;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mails Outgoings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mails-outgoing-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?/*= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) */?><!--
        --><?/*= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) */?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'num',
            'date',
            'organization',
            'description',
            'result',
        ],
    ]) ?>

    <div class="row">
        <div class="col-md-4">
            <div class="well">
                <h3>Ижрочилар</h3>
                <?foreach($model->users as $user):?>
                    <div>
                        <?=$user->username?>
                    </div>
                <?endforeach;?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="well">
                <h3>Файллар</h3>
                <?$files= \yii\helpers\FileHelper::findFiles('.\files\out'.DIRECTORY_SEPARATOR.$model->id);?>
                <?foreach($files as $index => $file):?>
                    <div>
                        <?$name = substr($file, strrpos($file, '/') + 1);
                        echo Html::a($name, \yii\helpers\Url::base().'/web'.$name)?>
                    </div>
                <?endforeach;?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="well">
                <h3>Тадбирлар</h3>

                <?foreach($model->events as $event):?>
                    <div>
                        <?=$event->name?>
                    </div>
                <?endforeach;?>
            </div>
        </div>
    </div>

</div>
