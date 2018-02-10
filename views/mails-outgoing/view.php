<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\MailsOutgoing */

$this->title = $model->num;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mails Outgoings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="mails-outgoing-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?if(count($model->mailsIncomingMailsOutgoings)>0):?>
    <div class="well">
        <h3>Хатлар ёзишмаси</h3>
        <?foreach($model->mailsIncomingMailsOutgoings as $mailInOut):?>
            <?if($mailInOut->direction == 2):?>
            <p>
                <a href="<?=Url::to(['mails-incoming/view', 'id' => $mailInOut->mails_incoming_id])?>" class="label label-success">
                    <?=$mailInOut->mailsIncoming->in_num?>
                </a>
                <?=$mailInOut->mailsIncoming->in_date?> <span class="label label-success"><</span>
            </p>
            <?else:?>
            <p>
                <a href="<?=Url::to(['mails-outgoing/view', 'id' => $mailInOut->mails_outgoing_id])?>" class="label label-warning">
                    <?=$mailInOut->mailsOutgoing->num?>
                </a>
                <?=$mailInOut->mailsOutgoing->date?> <span class="label label-warning">></span>
            </p>
            <?endif;?>
        <?endforeach;?>
    </div>
    <?endif;?>

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
                        echo Html::a($name, \yii\helpers\Url::base().'/web'.$name, ['target' => '_blank'])?>
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
