<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Note */

$this->title = Yii::t('app', 'Create Notes');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notes'), 'url' => Url::to(['note/index'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
