<?php

namespace app\controllers;

use app\models\Access;
use app\models\search\UserSearch;
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
                    'delete' => ['POST'],
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

        if (Yii::$app->user->id === User::find()->where(['username' => 'mrnkravchenko@gmail.com'])) {

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
//        TODO Доделать - закрыть доступ к просмотру, обновлению и редактированию пользователей, кроме Админа
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }*/

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->generateAuthKey();

            if ($model->save()){
                $model->sendActivationToEmail();
                Yii::$app->response->refresh(); //очистка данных из формы
                echo "<p style='color:green'>На Ваш e-mail отправлено письмо со ссылкой.<br><br>"
                    . "Перейдите по ней для активации подписки!</p>";
                exit;
            } else echo "<p style='color:red'>". Yii::t('app/site', 'Your registration is not completed, an error occurred') . "</p>";
        } else {

            //Проверяем наличие фразы в массиве ошибки
            if( isset($model->errors['email']) && strpos($model->errors['email'][0], 'уже занято') !== false) {
                echo "<p style='color:red'>" . Yii::t('app/site', 'You already have an account!') . "</p>";
            }
        }
//        return $this->redirect(['view', 'id' => $model->id]);


        return $this->render('create', [
            'model' => $model,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

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
