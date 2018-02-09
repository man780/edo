<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MailsIncoming */

$this->title = $model->in_num;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mails Incomings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mails-incoming-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?//= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?/*= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
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
            'in_num',
            'in_date',
            'out_num',
            'out_date',
            'organization',
            'description',
            'deadline',
            'type',
            'result',
            //'dcreated',
            //'bycreated',
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
                <?if(is_dir('.\files\in'.DIRECTORY_SEPARATOR.$model->id)):?>
                <?$files= \yii\helpers\FileHelper::findFiles('.\files\in'.DIRECTORY_SEPARATOR.$model->id);?>
                <?foreach($files as $index => $file):?>
                    <div>
                        <?$name = substr($file, strrpos($file, '/') + 1);
                        echo Html::a($name, \yii\helpers\Url::base().'/web'.$name)?>
                    </div>
                <?endforeach;?>
                <?else:?>
                    Файллар мавжуд эмас
                <?endif;?>
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
