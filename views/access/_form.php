<?php

use app\models\Note;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Access */
/* @var $form yii\widgets\ActiveForm */
?>


<!--

<?php
/*    $form = ActiveForm::begin();
...
// получаем всех авторов
    $authors = Author::find()->all();
// формируем массив, с ключем равным полю 'id' и значением равным полю 'name'
    $items = ArrayHelper::map($authors,'id','name');
    $params = [
        'prompt' => 'Укажите автора записи'
    ];
    echo $form->field($model, 'author')->dropDownList($items,$params);
...
    ActiveForm::end();
*/?>


-->


<div class="access-form">

    <?php $form = ActiveForm::begin();
    $authors = User::find()->where(['not in', 'id', [Yii::$app->user->getId()]])->all();
    $notes = Note::find()->where(['creator' => Yii::$app->user->getId()])->all();
    $noteItems = ArrayHelper::map($notes, 'id', 'text');
    $authorItems = ArrayHelper::map($authors,'id','name');
    $authorParams = [
        'prompt' => 'Укажите кому дотсупна запись'
    ];
    $noteParams = [
        'prompt' => 'Выберете заметку для доступа'
    ];


    ?>



    <?= $form->field($model, 'note_id')->dropDownList($noteItems, $noteParams) ?>

    <?= $form->field($model, 'user_id')->dropDownList($authorItems,$authorParams) ?>

    <?= $form->field($model, 'since')->textInput(['type' => 'date']);?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
