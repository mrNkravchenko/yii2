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
    public function execute(Note $model): int
    {
        $authorId = (int)$model->creator;
        $userId = (int)\Yii::$app->user->id;
        if ($authorId === $userId) {
            return Access::LEVEL_EDIT;
        }
        $query = Access::find()
            ->forNote($model)
            ->forUserId($userId)
            ->forCurrentDate();
        $accessNote = $query->one();
        if ($accessNote) {
            return Access::LEVEL_VIEW;
        }
        return Access::LEVEL_DENIED;
    }
}