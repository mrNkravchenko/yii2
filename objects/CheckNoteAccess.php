<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 04.07.18
 * Time: 22:24
 */



namespace app\objects;
use app\models\Access;
use app\models\Note;
class CheckNoteAccess
{
    /**
     * Уровень доступа к заметке
     *
     * @param Note $model
     *
     * @return int
     */
    public function execute(Note $model)
    {
        $authorId = (int)$model->creator;
        $userId = (int)\Yii::$app->user->id;
        if ($authorId === $userId) {
            return Access::LEVEL_EDIT;
        }
        $accessNote = Access::find()
            ->forNote($model)
            ->forUserId($userId)
            ->one();
        if ($accessNote) {
            return Access::LEVEL_VIEW;
        }
        return Access::LEVEL_DENIED;
    }
}