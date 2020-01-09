<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "county_to_offers".
 *
 * @property int $offer_id
 * @property int $country_id
 *
 * @property Offers $offer
 * @property Country $country
 */
class CountyToOffers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'county_to_offers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['offer_id', 'country_id'], 'required'],
            [['offer_id', 'country_id'], 'integer'],
            [['offer_id', 'country_id'], 'unique', 'targetAttribute' => ['offer_id', 'country_id']],
            [['offer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Offers::className(), 'targetAttribute' => ['offer_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'offer_id' => 'Offer ID',
            'country_id' => 'Country ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffer()
    {
        return $this->hasOne(Offers::className(), ['id' => 'offer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * {@inheritdoc}
     * @return CountyToOffersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountyToOffersQuery(get_called_class());
    }
}
