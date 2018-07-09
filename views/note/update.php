<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Note */

$author = new \app\models\Note();



$this->title = 'Обновить заметку: ' . $model->id/*. ', автор - '. $author->getAuthor()*/;
$this->params['breadcrumbs'][] = ['label' => 'Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="note-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
