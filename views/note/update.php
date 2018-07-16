<?php

use app\models\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Note */

//$author = new \app\models\Note();

//var_dump($model->author->name); exit;

$this->title = Yii::t('app', 'Update Note'). ' : ' . $model->id . ', автор - '. $model->author->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="note-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
