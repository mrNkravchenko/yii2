<?php

namespace app\controllers;


use app\models\UrlShorneter;
use app\models\User;
use function var_dump;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

//        TODO сделать редирект по ссылке и сделать апи

        if (Yii::$app->user->isGuest) {

            return $this->redirect(Url::to('site/login'));
        }

        $model = new UrlShorneter();
        $result = '';

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                $link = $_SERVER['HTTP_ORIGIN'] . '/' . $model->url_short;
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


        return $this->render('index', ['model' => $model, 'result' => $result]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /*
 * Подтверждение подписки.
 * В качестве GET-параметра принимается код, который сравнивается с тем, что в таблице user
 * в ячейке access_token. При успехе - ставится true в ячейку confirm.
 */
//    TODO разобраться почему, при активации пользователя пароль становиться друним.
    public function actionActivation()
    {
        $code = Yii::$app->request->get('access_token');
        $code = Html::encode($code);
        //ищем код подтверждения в БД
// TODO сделать через имеющиеся методы модели
        $find = User::findIdentityByAccessToken($code);

        if ($find) {
//            $find->confirm = 1;
            if ($find->save()) {
                $text = '<p>Поздравляю!</p>
            <p>Ваш e-mail подтвержден.</p>';
                //страница подтверждения

//                Yii::$app->response->refresh();
//                return $this->redirect(Url::home(true));
            }
        }
        $absoluteHomeUrl = Url::home(true);
//        return $this->redirect($absoluteHomeUrl, 303); //на главную
    }
}
