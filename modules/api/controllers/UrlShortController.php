<?php

namespace app\modules\api\controllers;

use app\models\UrlShortener;
use yii\rest\ActiveController;

class UrlShortController extends ActiveController
{

    public $modelClass = UrlShortener::class;

    public function actionCreate()
    {
        echo 'ghdbtn';exit;
    }

}
