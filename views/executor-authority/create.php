<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ExecutorAuthority */

$this->title = Yii::t('app', 'Create Executor Authority');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Executor Authorities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="executor-authority-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
