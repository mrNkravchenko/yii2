<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evrnt_note".
 *
 * @property int $id
 * @property string $text
 * @property int $creator
 * @property string $date_create
 */
class Note extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evrnt_note';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'creator'], 'required'],
            [['text'], 'string'],
            [['creator'], 'integer'],
            [['date_create'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'text' => Yii::t('app', 'Text'),
            'creator' => Yii::t('app', 'Creator'),
            'date_create' => Yii::t('app', 'Date Create'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\NoteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\NoteQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        $result = parent::beforeSave($insert);
        if (!$this->creator) {
            $this->creator = \Yii::$app->user->id;
        }
        if (!$this->date_create) {
            $this->date_create = \date('Y-m-d H:i:s');
        }
        return $result;
    }

    public function getAutor()
    {
        return $this->hasOne(User::className(), ['id' => 'creator']);

    }

    public function getAccess()
    {
        return $this->hasMany(Access::className(), ['note_id' => 'id']);
    }
}
