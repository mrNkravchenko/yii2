<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 20.07.18
 * Time: 20:53
 */

namespace app\commands;


use app\models\UrlShorneter;
use function date;
use const PHP_EOL;
use function strtotime;
use function time;
use function var_dump;
use yii\console\Controller;
use yii\console\ExitCode;

class UrlShortenerController extends Controller
{

    public $defaultAction = 'clean';

    public function actionClean()
    {
        foreach ((UrlShorneter::find()->each()) as $key => $model)
        {

            if ($model->created_at <= date('Y-m-d H:m:s', strtotime('-15 days'))) {
                $model->delete();
            }
        }

        return ExitCode::OK;
    }


}