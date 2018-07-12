<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 12.07.18
 * Time: 23:29
 */

namespace app\objects;
use app\models\User;
use Yii;


class CheckUserAccess
{

//    TODO Доделать контроль Юзеров к каким либо данным

    /**
     * Уровень доступа к заметке
     *
     * @param Note $model
     *
     * @return int
     */
    public function execute(Note $model): int
    {
        $adminId = (int)User::find()->where(
            ['username' => 'mrnkravchenko@gmail.com']
        )->one()->id;
        var_dump($adminId);exit;
        $userId = (int)Yii::$app->user->id;
        if ($userId === $userId) {
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