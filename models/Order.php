<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $email
 * @property string $phone
 * @property string $date_created
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_created'], 'safe'],
            [['name', 'address', 'email', 'phone'], 'string', 'max' => 255],
            ['email', 'email'],
            ['phone', 'match', 'pattern' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'address' => 'Адрес',
            'email' => 'Email',
            'phone' => 'Телефон',
            'date_created' => 'Дата создания',
        ];
    }
}
