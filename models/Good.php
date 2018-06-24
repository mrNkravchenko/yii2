<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "good".
 *
 * @property int $id
 * @property string $name
 * @property int $count
 * @property string $email_provider
 * @property int $provider_id
 * @property string $date_create
 */
class Good extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'good';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['count', 'provider_id'], 'integer'],
            [['date_create'], 'safe'],
            [['name', 'email_provider'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'count' => 'Count',
            'email_provider' => 'Email Provider',
            'provider_id' => 'Provider ID',
            'date_create' => 'Date Create',
        ];
    }
}
