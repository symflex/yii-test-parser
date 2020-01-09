<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Offers]].
 *
 * @see Offers
 */
class OffersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Offers[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Offers|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
