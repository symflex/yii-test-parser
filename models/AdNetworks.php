<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ad_networks".
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string $parser
 *
 * @property Offers[] $offers
 */
class AdNetworks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ad_networks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'url', 'parser'], 'required'],
            [['name', 'url', 'parser'], 'string', 'max' => 255],
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
            'url' => 'Url',
            'parser' => 'Parser',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffers()
    {
        return $this->hasMany(Offers::className(), ['network_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return AdNetworksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdNetworksQuery(get_called_class());
    }

    public function getList()
    {
        return self::find()->select(['id', 'name'])->all();
    }
}
