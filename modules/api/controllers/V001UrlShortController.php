<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\models\UrlShortener;
use yii\console\Response;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class V001UrlShortController extends ActiveController
{

    public $modelClass = UrlShortener::class;

    public $defaultAction = 'create';

    public function actionCreate()
    {
//        \yii\web\Response::FORMAT_JSON;

//        var_dump($this); exit;
        $model = new UrlShortener();
        $result = '';

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                $link = Url::base(true) . '/' . $model->url_short;
                $result = Html::a($link, Url::to($link, true));
                $model->refresh();
            } else {
                $result = '';
//                var_dump($model);exit;
                $errors = $model->getErrors('url_origin');
                foreach ($errors as $key => $error){
                    $result .= $error . ' ';
                }

            }
        }

        return Json::encode($result);

//        return $this->render('create', ['model' => $model, 'result' => $result]);
    }


    protected function findModel($id)
    {
        if (($model = UrlShortener::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
