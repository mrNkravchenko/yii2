<?php

namespace app\models;

use Yii;

use yii\filters\RateLimitInterface;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\swiftmailer\Mailer;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $surname
 * @property string $name
 * @property string $password
 * @property string $salt
 * @property string $access_token
 * @property string $create_date
 * @property bool $confirm
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'surname', 'name', 'password'], 'required'],
            [['create_date'], 'safe'],
            [['confirm'], 'boolean'],
            [['username', 'surname', 'name', 'password', 'salt', 'access_token'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['access_token'], 'unique'],
            [['username'], 'email'],
            [['username', 'access_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Your Login / email address'),
            'surname' => Yii::t('app', 'Your surname'),
            'name' => Yii::t('app', 'Your name'),
            'password' => Yii::t('app', 'Your password'),
            'salt' => 'Salt',
            'access_token' => 'Access Token',
            'create_date' => Yii::t('app', 'Date Create'),
            'confirm' => 'Confirm Registration Status',
        ];
    }

    /**
     * Before save event handler
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if($this->isAttributeChanged('confirm')){
                return true;
            }

            if ($this->getIsNewRecord() && !empty($this->password)) {
                $this->salt = $this->saltGenerator();

            }
            if (!empty($this->password)) {

//                var_dump($this->password, $this->salt, md5($this->password . $this->salt));

                $this->password = $this->passWithSalt($this->password, $this->salt);
            } else {
                unset($this->password);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Generate the salt
     * @return string
     */
    public function saltGenerator()
    {
        return md5($this->username);
    }

    /**
     * Return pass with the salt
     * @param $password
     * @param $salt
     * @return string
     */
    public function passWithSalt($password, $salt)
    {
        return md5($password . $salt);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->access_token;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
//        var_dump($this->passWithSalt($password, $this->salt));
        return $this->password === $this->passWithSalt($password, $this->salt);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $this->passWithSalt($password, $this->saltGenerator());
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        try {
            $this->access_token = Yii::$app->security->generateRandomString();
        } catch (\Exception $exception) {
            Yii::warning($exception . Yii::t('app', "Mistake"));
        }

    }


    /**
     *
     */
    public function sendActivationToEmail()
    {
        $absoluteHomeUrl = Url::home(true); //http://ваш сайт
        $serverName = Yii::$app->request->serverName; //ваш сайт без http
        $url = $absoluteHomeUrl.'activation?access_token='.$this->access_token;

        /*if ($link = UrlShortener::getApiResponse($absoluteHomeUrl . 'api/v-001-url-short/create?access-token='. $this->access_token . '&url_origin='. $url)) {
            $url = Json::decode($link)['link'];
        }*/

        $msg = "Здравствуйте! Спасибо за регистрацию на сайте $serverName!  Вам осталось только подтвердить свой e-mail. Для этого перейдите по ссылке $url";


        $msg_html = "<h2 style='font-weight:bold;border-bottom:1px dotted #ccc;'>Здравствуйте! Спасибо за регистрацию на сайте <a href='{$absoluteHomeUrl}'>$serverName</a></h2>\r\n";
        $msg_html .= "<p><strong>Вам осталось только подтвердить свой e-mail.</strong></p>\r\n";
        $msg_html .= "<p><strong>Для этого перейдите по </strong><a href='{$url}'>ссылке</a></p>\r\n";

        Yii::$app->mailer->compose('layouts/html')
            ->setFrom('no-reply@u1565117062233.u-host.in')
            ->setTo($this->username)
            ->setSubject('Подтверждение подписки.')
            ->setTextBody($msg)
            ->setHtmlBody($msg_html)
            ->send();

    }

    /**
     *
     */
    public function sendInfoEmailToUser()
    {
        $absoluteHomeUrl = Url::home(true);
        $serverName = Yii::$app->request->serverName;

        $msg_html = "<h2 style='font-weight:bold;border-bottom:1px dotted #ccc;'>Здравствуйте, {$this->name}! Спасибо за регистрацию на сайте <a href='". $absoluteHomeUrl ."'>$serverName</a></h2>\r\n";
        $msg_html .= "<p>Пожалуйста сохраните это письмо, с информацией о Вашей учетной записи:</p>\r\n";
        $msg_html .= "<p><strong>Ваш логин: <span style='color: greenyellow'>{$this->username}</span></strong></p>\r\n";
        $msg_html .= "<p><strong>Индивидуальный токен для доступа к API и для восстановления пароля: <span style='color: red'>{$this->access_token}</span></strong></p>\r\n";
        $msg_html .= "<p>данное письмо сформированно автоматически, не нужно на него отвечать</p>\r\n";



        Yii::$app->mailer->compose('layouts/html')
            ->setFrom('no-reply@u1565117062233.u-host.in')
            ->setTo($this->username)
            ->setSubject('Регистрационная информация')
            ->setHtmlBody($msg_html)
            ->send();

    }

}
