<?php

use app\models\UrlShorneter;
use app\objects\CheckUserAccess;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UrlShortenerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Url Shorneters');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="url-shorneter-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php /*Pjax::begin(); */ ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Url Shorneter'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => yii\grid\SerialColumn::class],

            'id',
            'url_origin:url',
            [
                'attribute' => 'url_short:url',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->url_short, Url::base(true) . '/' . $model->url_short);
                },
            ],

            'created_at',
            'count_of_use',

            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'update' => function ($model) {
                        return CheckUserAccess::execute($model) === UrlShorneter::LEVEL_EDIT;
                    },
                    'delete' => function ($model) {
                        return CheckUserAccess::execute($model) === UrlShorneter::LEVEL_EDIT;
                    }
                ],


            ],

        ],
    ]); ?>
    <?php /*Pjax::end(); */ ?>
</div>
