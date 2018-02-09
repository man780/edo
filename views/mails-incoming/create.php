<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MailsIncoming */

$this->title = Yii::t('app', 'Create Mails Incoming');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mails Incomings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mails-incoming-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data' => $data,
        'events' => $events,
    ]) ?>

</div>
