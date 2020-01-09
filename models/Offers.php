<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "offers".
 *
 * @property int $id
 * @property int $network_id
 * @property int $internal_id
 * @property string $name
 * @property string $description
 * @property double $payout
 *
 * @property CountyToOffers[] $countyToOffers
 * @property Country[] $countries
 */
class Offers extends \yii\db\ActiveRecord
{
    public $_countriesArray;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'offers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['network_id', 'internal_id', 'name', 'payout'], 'required'],
            [['network_id', 'internal_id'], 'integer'],
            [['description'], 'string'],
            [['countriesArray'], 'safe'],
            [['payout'], 'number'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function getCountriesArray()
    {
        if ($this->_countriesArray === null) {
            $this->_countriesArray = $this->getCountries()->select('id')->column();
        }
        return $this->_countriesArray;
    }

    public function setCountriesArray($values)
    {
        $this->_countriesArray = (array)$values;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'network_id' => 'Network ID',
            'internal_id' => 'Internal ID',
            'name' => 'Name',
            'description' => 'Description',
            'payout' => 'Payout',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountyToOffers()
    {
        return $this->hasMany(CountyToOffers::className(), ['offer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountries()
    {
        return $this->hasMany(Country::className(), ['id' => 'country_id'])->viaTable('county_to_offers', ['offer_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CountyToOffersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountyToOffersQuery(get_called_class());
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->updateCountries();
        parent::afterSave($insert, $changedAttributes);
    }

    public function updateCountries()
    {
        $currentCountriesIds = $this->getCountries()->select('id')->column();
        $newCountriesIds = $this->getCountriesArray();
        foreach (array_filter(array_diff($newCountriesIds, $currentCountriesIds)) as $countryId) {
            if ($country = Country::findOne($countryId)) {
                $this->link('countries', $country);
            }
        }
        foreach (array_filter(array_diff($currentCountriesIds, $newCountriesIds)) as $countryId) {
            if ($country = Country::findOne($countryId)) {
                $this->unlink('countries', $country, true);
            }
        }
    }
}
