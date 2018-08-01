<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 20.07.18
 * Time: 20:53
 */

namespace app\commands;


use app\models\UrlShortener;
use function date;
use function strtotime;
use yii\console\Controller;
use yii\console\ExitCode;

class UrlShortenerController extends Controller
{

    public $defaultAction = 'clean';

    public function actionClean()
    {
        foreach ((UrlShortener::find()->each()) as $key => $model)
        {

            if ($model->created_at <= date('Y-m-d H:m:s', strtotime('-15 days'))) {
                $model->delete();
            }
        }

        return ExitCode::OK;
    }


}