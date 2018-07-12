<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'options' => ['class' => 'form-horizontal center-block'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-offset-2 col-lg-3 control-label'],
        ]
    ]); ?>

    <?= $form->field($model, 'username')->input('email') ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>


    <div class="form-group">
        <div class="col-lg-offset-5 col-lg-2">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
