<?php

use app\objects\CheckUserAccess;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UrlShorneter */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Url Shorneters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="url-shorneter-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (CheckUserAccess::execute($model) === $model::LEVEL_EDIT):?>

        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>

        <?php endif;?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'url_origin:url',
            'url_short:url',
            'created_at',
            'count_of_use',
        ],
    ]) ?>

</div>
