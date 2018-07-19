<?php




/* @var $this yii\web\View */
/* @var $model app\models\UrlShorneter */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', Yii::$app->name);
?>

<div class="jumbotron">
    <h1><?= Html::encode($this->title) ?></h1>

</div>


<div class="site-index">


    <h3 class="text-center"><?=$result?></h3>



    <p class="text-center"><?=Yii::t('app/site', 'Please fill out the following fields')?>:</p>

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
