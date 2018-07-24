<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UrlShorneter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="url-shorneter-form">

    <?php /*$form = ActiveForm::begin(); */?><!--

    <?/*= $form->field($model, 'url_origin')->textInput(['maxlength' => true]) */?>

    <?/*= $form->field($model, 'url_short')->textInput(['maxlength' => true]) */?>

    <?/*= $form->field($model, 'created_at')->textInput() */?>

    <?/*= $form->field($model, 'count_of_use')->textInput() */?>

    <div class="form-group">
        <?/*= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) */?>
    </div>

    --><?php /*ActiveForm::end(); */?>

    <?php $form = ActiveForm::begin([
        'id' => 'url-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-offset-2 col-lg-3 control-label'],
        ],
    ]); ?>


    <?= $form->field($model, 'url_origin')->input('url') ?>

    <?= $form->field($model, 'url_short')->textInput() ?>


    <div class="form-group">
        <div class="col-lg-offset-5 col-lg-7">
            <?= Html::submitButton(Yii::t('app', 'Generate'), ['class' => 'btn btn-primary', 'name' => 'generate-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
