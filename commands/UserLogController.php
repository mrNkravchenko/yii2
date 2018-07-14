<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 14.07.18
 * Time: 13:26
 */

namespace app\commands;


use app\models\UserLog;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

class UserLogController extends Controller
{
    public $defaultAction = 'clean';

    /**
     * @return int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionClean()
    {
        $userLogsCount = UserLog::find()->count('id');

        Console::startProgress(0, $userLogsCount);

        foreach (UserLog::find()->each() as $index => $value) {

            /* @var $model UserLog */
            $model->delete();


            /*if (($index % ($userLogsCount/100)) == 0) {

            }*/

            Console::updateProgress($index++, $userLogsCount);

        }

        Console::updateProgress($userLogsCount, $userLogsCount);
        Console::endProgress();
        return ExitCode::OK;

    }

}