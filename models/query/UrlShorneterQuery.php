<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\UrlShortener]].
 *
 * @see \app\models\UrlShortener
 */
class UrlShorneterQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\UrlShortener[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\UrlShortener|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
