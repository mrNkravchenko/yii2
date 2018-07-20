<?php

namespace app\models;

use function base_convert;
use ErrorException;
use Exception;
use function strlen;
use function trim;
use function uniqid;
use function var_dump;
use Yii;
use yii\bootstrap\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "url_shorneter".
 *
 * @property int $id
 * @property string $url_origin
 * @property string $url_short
 * @property string $created_at
 * @property int $count_of_use
 */
class UrlShorneter extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'url_shorneter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url_origin'], 'required'],
            [['created_at'], 'safe'],
            [['count_of_use'], 'integer'],
            [['url_origin', 'url_short'], 'string', 'max' => 255],
            [['url_origin'], 'unique'],
            [['url_short'], 'unique'],
            [['url_origin'], 'url'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'url_origin' => Yii::t('app', 'Url Origin'),
            'url_short' => Yii::t('app', 'Url Short'),
            'created_at' => Yii::t('app', 'Created At'),
            'count_of_use' => Yii::t('app', 'Count Of Use'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\UrlShorneterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\UrlShorneterQuery(get_called_class());
    }


    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {

            $this->url_origin = trim($this->url_origin);

//            проверяем валидацию введенного url
            if ($this::checkOriginUrl($this->url_origin)) {

                //  проверяем введен ли пользовательский короткий url
                if (strlen($this->url_short) >= 4) {

                    //  проверяем уникальный ли пользовательский короткий url
                    if (!$this::checkShortUrl($this->url_short)) {

                        return true;

                    } else {
                        $this->url_short = '';
                        $this->addError('url_short', 'Ваш url не прошел валидацию, такой url уже есть, оставьте поле пустым или введите новый короткий url:');
                    }

                }
                return true;

            } else $this->addError('url_origin', 'Ваш url не прошел валидацию');
        } else $this->addError('url_origin', 'Произошла ошибка');

        return false;

    }


    /**
     * @return void
     */
    public function afterValidate()
    {
        parent::afterValidate();

        if (!empty($this->getErrors('url_origin'))) {

            $link = $_SERVER['HTTP_ORIGIN'] . '/' . $this::findOne(['url_origin' => $this->url_origin])->url_short;

            $this->addError('url_origin', 'Значения для поля: ' . $this::findOne(['url_origin' => $this->url_origin])->url_short . '.');

            $this->addError('url_origin', 'Ваша ссылка: ' . Html::a($link, Url::to($link, true)));
        }
    }

    public function afterSave($insert, $changedAttributes)
    {

        // генерируем короткий url

        parent::afterSave($insert, $changedAttributes);



        if (!strlen($this->url_short) >= 4) {
            $this->url_short = $this::generateShortUrl($this->url_origin);
        }


        if ($this->isAttributeChanged('url_short')) {

            $this->save();

        }
        return false;


    }

    public static function generateShortUrl($url_origin)
    {
        $id = static::findOne(['url_origin' => $url_origin])->id;

        // основание текущее
        $base = 10;

        // основанеи новое
        $newBase = 32; //

        //так как число для конвертации берется из primary key, то оно всегда будет уникально, поэтому используем простую функцию передода числа и не заморачиваемся:)
        return base_convert(($id + 9999990), $base, $newBase);

    }

    public static function getShortUrl($url_origin)
    {

        return static::findOne(['url_origin' => $url_origin])->url_short;

    }

    public static function checkShortUrl($url_short)
    {
        return static::findOne(['url_short' => $url_short]);
    }

    public static function checkOriginUrl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_NOBODY, true);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_exec($ch);

        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return (!empty($response) && $response != 404);


    }
}
