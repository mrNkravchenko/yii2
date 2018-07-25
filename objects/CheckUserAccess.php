<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 12.07.18
 * Time: 23:29
 */

namespace app\objects;

use app\models\Access;
use app\models\User;
use function var_dump;
use Yii;
use yii\base\Model;


class CheckUserAccess
{


    /**
     * Уровень доступа к моделям
     *
     * @param Model $model
     *
     * @return int
     */
    public static function execute(Model $model): int
    {
        $adminEmail = Yii::$app->params['adminEmail'];
        $adminId = (int)User::find()->where(
            ['username' => $adminEmail]
        )->one()->id;

        $userId = (int)Yii::$app->user->id;
        if ($userId === $adminId) {
            return $model::LEVEL_EDIT;
        } else return $model::LEVEL_VIEW;


    }

    public static function isAdmin()
    {

        $adminEmail = Yii::$app->params['adminEmail'];
        $adminId = (int)User::find()->where(
            ['username' => $adminEmail]
        )->one()->id;

        $userId = (int)Yii::$app->user->id;

        return $adminId === $userId;

    }


}