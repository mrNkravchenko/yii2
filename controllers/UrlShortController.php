<?php

namespace app\controllers;

use app\objects\CheckUserAccess;
use function var_dump;
use Yii;
use app\models\UrlShortener;
use app\models\search\UrlShortenerSearch;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UrlShortController implements the CRUD actions for UrlShortener model.
 */
class UrlShortController extends Controller
{
    public $defaultAction = 'create';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => false,
                    ],


                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all UrlShortener models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UrlShortenerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Displays a single UrlShortener model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UrlShortener model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {

            return $this->redirect(Url::to('site/login'));
//            return $this->actionLogin();
        }

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

        return $this->render('create', ['model' => $model, 'result' => $result]);
    }

    /**
     * Updates an existing UrlShortener model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);

        if (CheckUserAccess::execute($model) === $model::LEVEL_EDIT) {



            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);

        } else return $this->redirect(['index']);


    }

    /**
     * Deletes an existing UrlShortener model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (CheckUserAccess::execute($model) === $model::LEVEL_EDIT) {

            $model->delete();

            return $this->redirect(['index']);

        } else return $this->redirect(['index']);

    }

    /**
     * @param $code
     *
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionRedirect($code)
    {

        if ($model = UrlShortener::findOne(['url_short' => $code])) {
            $model->count_of_use++;
//            $model->url_short = $code;
//            var_dump($model->update(true));exit;
            $model->update(false);
//            var_dump($model->getDirtyAttributes());exit;
            $this->redirect($model->url_origin);
        } else $this->redirect(Url::base(true));

    }

    /**
     * Finds the UrlShortener model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return UrlShortener the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UrlShortener::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
