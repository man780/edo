<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MailsOutgoingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Mails Outgoings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mails-outgoing-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?if(Yii::$app->user->id == 2):?>
        <p>
            <?= Html::a(Yii::t('app', 'Create Mails Outgoing'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?endif;?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'num',
            'date',
            'organization',
            'description',
            'result',
            //'dcreated',
            //'bycreated',

            //['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>
</div>
