<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model app\models\Access */

$this->title = $model->since;
$this->params['breadcrumbs'][] = ['label' => 'Accesses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($this->beginCache('current_time_on_access_view', [
        'duration' => 30,
    ])): ?>

        <?= date('Y-m-d H:i:s'); ?>
        <?= $this->endCache(); ?>

    <?php endif; ?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'note_id',
            'user_id',
            'since:date'
        ],
    ]) ?>

</div>
