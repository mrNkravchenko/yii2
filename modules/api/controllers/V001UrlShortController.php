<?php

namespace app\modules\api\controllers;

use app\modules\api\models\UserIpLimit;
use function var_dump;
use Yii;
use app\modules\api\models\UrlShortener;
use yii\filters\RateLimiter;
use yii\rest\Controller;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class V001UrlShortController extends /*ActiveController*/ /*Controller*/ Controller
{

    public $modelClass = UrlShortener::class;

    public $defaultAction = 'create';




    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
        ];

        return $behaviors;

    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {

        $model = new UrlShortener();
        $result = null;

        if ($model->load(Yii::$app->request->get())) {

            if ($model->save()) {

                $result['data'] = $model::findOne(['url_origin' => $model->url_origin]);
                $result['link'] = Url::base(true) . '/' . $model::findOne(['url_origin' => $model->url_origin])->url_short;

                $model->refresh();
            } else {

                if ($result['data'] = $model::findOne(['url_origin' => $model->url_origin])){

                    $result['link'] = Url::base(true) . '/' . $model::findOne(['url_origin' => $model->url_origin])->url_short;

                }

                $errors = $model->getErrors();

                $result['error'] = $errors;

            }
        }


        return $result;

    }


    /**
     * @param $id
     *
     * @return UrlShortener|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = UrlShortener::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
