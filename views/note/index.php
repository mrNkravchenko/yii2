<?php

use app\models\Access;
use app\objects\CheckNoteAccess;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\NoteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Notes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Notes'), \yii\helpers\Url::to(['note/create']), ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => \yii\grid\SerialColumn::class,
            ],
            [
                'attribute' => 'text',
                'format' => 'raw',
                'value' => function ($model) {
                    $text = StringHelper::truncateWords($model->text, 2, '...', true);
                    return Html::a($text, ['note/view', 'id' => $model->id]);
                }
            ],
            'author.name',
            [
                'attribute' => 'date_create',
                'format' => ['date', 'php:d.m.Y H:i'],
            ],
            [
                'class' => \yii\grid\ActionColumn::class,
                'visibleButtons' => [
                    'update' => function ($model) {
                        return (new CheckNoteAccess())->execute($model) === Access::LEVEL_EDIT;
                    },
                    'delete' => function ($model) {
                        return (new CheckNoteAccess())->execute($model) === Access::LEVEL_EDIT;
                    }
                ],
            ],
        ],


    ]); ?>

</div>
