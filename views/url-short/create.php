<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UrlShortener */


$this->title = Yii::t('app', 'Create Url Shortener');
/*$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Url Shorneters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
?>
<div class="url-shortener-create">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <h3 class="text-center"><?=$result?></h3>

    <p class="text-center"><?=Yii::t('app/site', 'Please fill out the following fields')?>:</p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
