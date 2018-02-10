<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\MailsIncoming */

$this->title = $model->in_num;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mails Incomings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mails-incoming-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?//vd($model->mailsIncomingMailsOutgoings)?>
    <?if(count($model->mailsIncomingMailsOutgoings)>0):?>
        <div class="well">
            <h3>Хатлар ёзишмаси</h3>
            <?foreach($model->mailsIncomingMailsOutgoings as $mailInOut):?>
                <?if($mailInOut->direction == 1):?>
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
        <?if($model->status == 2 && Yii::$app->user->id == 3):?>
            <?= Html::a(Yii::t('app', 'Тасдиқлаш'), ['confirm', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?endif;?>
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
            [// the owner name of the model
                'attribute' => 'status',
                'value' => $model->getStatus0($model->status),
            ],
            //'dcreated',
            //'bycreated',
        ],
    ]) ?>
    <div class="row">
        <div class="col-md-4">
            <div class="well">
                <h3>Ижрочилар</h3>
                <?foreach($model->mailsIncomingUsers as $user):?>
                    <div class="alert alert-<?=($user->is_viewed == 0)?'danger':'info'?>">
                        <?=$user->user->username?>
                        <?if(Yii::$app->user->id == $user->user_id && $model->status == 1):?>
                        <?= Html::a(Yii::t('app', 'Бажариш'), ['done', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                        <?endif;?>
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
