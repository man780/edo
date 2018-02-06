<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MailsOutgoing */

$this->title = Yii::t('app', 'Create Mails Outgoing');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mails Outgoings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mails-outgoing-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
