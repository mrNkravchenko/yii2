<?php

namespace app\controllers;


use app\models\search\UserSearch;
use app\objects\CheckUserAccess;
use function var_dump;
use Yii;
use app\models\User;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST', 'GET', 'PUT'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (CheckUserAccess::isAdmin()){

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);

        } else return $this->goHome();

    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if (CheckUserAccess::isAdmin() || $model->id === Yii::$app->user->id){
            return $this->render('view', [
                'model' => $model,
            ]);

        } else return $this->goHome();


    }

    /**
     * Creates a new User model.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        $result = null;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->generateAuthKey();

            if ($model->save()){
                $model->sendActivationToEmail();


//                Yii::$app->response->refresh(); //очистка данных из формы
                $result = 'Письмо с данными активации успешно отправлено на ваш email адрес, для дальнейщенй регистрации перейдите по ссылке в письме';

            } else $model->addError('email', Yii::t('app/site', 'Your registration is not completed, an error occurred'));
        } else {

            //Проверяем наличие фразы в массиве ошибки
            if( isset($model->errors['email']) && strpos($model->errors['email'][0], 'уже занято') !== false) {
                $model->addError('email', Yii::t('app/site', 'You already have an account!'));
            }
        }

        return $this->render('create', [
            'model' => $model,
            'result' => $result,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->id === Yii::$app->user->id || CheckUserAccess::isAdmin()) {

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);

        } else return $this->goHome();


    }

    /**
     * Deletes an existing User model.
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
        if (CheckUserAccess::isAdmin()){
            $this->findModel($id)->delete();
        }


        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
