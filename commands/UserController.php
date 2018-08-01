<?php
/**
 * Created by PhpStorm.
 * User: Никита
 * Date: 31.07.2018
 * Time: 16:21
 */

namespace app\commands;


use app\models\User;
use yii\console\Controller;
use yii\console\ExitCode;

class UserController extends Controller
{
    public $defaultAction = 'clean';


    /**
     * delete not confirmed ysers after 1 hour
     * @return int
     */
    public function actionClean()
    {
        $old_time = date('Y-m-d H:m:s', strtotime('-1 hour'));
        $users = User::find()
            ->where(['confirm' => 0])
            ->andWhere(['<','create_date', $old_time])
            ->each();


        foreach($users as $user) {


            $user->delete();

        }

        return ExitCode::OK;
    }

}