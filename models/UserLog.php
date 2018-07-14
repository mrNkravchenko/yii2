<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_log".
 *
 * @property int $id
 * @property int $user_id
 * @property string $login_date
 */
class UserLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'login_date' => Yii::t('app', 'Login Date'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\UserLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\UserLogQuery(get_called_class());
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
