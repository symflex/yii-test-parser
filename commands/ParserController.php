<?php

namespace app\commands;

use app\models\AdNetworks;
use app\models\Country;
use app\models\Offers;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;

class ParserController extends Controller
{
    protected $network;

    public function actionIndex(int $networkId = null)
    {
        if ($networkId) {
            $network = AdNetworks::findOne(['id' => $networkId]);
            $parserClass = $network->parser;

            $parser = new $parserClass($network->url, \Yii::getAlias('@runtime'));
            $offers = $parser->process();
            $this->insertOrUpdateOffers($networkId, $offers);
        } else {
            $networks = AdNetworks::find()->all();

            foreach ($networks as $network) {
                $parserClass = $network->parser;

                $parser = new $parserClass($network->url, \Yii::getAlias('@runtime'));
                $offers = $parser->process();
                $this->insertOrUpdateOffers($network->id, $offers);
            }
        }
    }

    public function insertOrUpdateOffers(int $networkId, array $offers)
    {
        $countries = [];

        foreach ($offers as $offer) {
            $countries[$offer['internal_id']] = $offer['countries'];
            unset($offer['countries']);
            $offer['network_id'] = $networkId;
            \Yii::$app->db->createCommand()
                ->upsert('offers', $offer, true)
                ->execute();
        }

        $allOffers = Offers::findAll(['network_id' => $networkId]);

        foreach ($allOffers as $offer) {

            if (
                is_string($countries[$offer->internal_id])
                && $countries === 'all'
            ) {
                $dbCountries = Country::find()
                                ->select(['id'])
                                ->asArray()
                                ->all();
            } else {
                $dbCountries = Country::find()
                                ->select(['id'])
                                ->where(['in', 'code', $countries[$offer->internal_id]])
                                ->asArray()
                                ->all();
            }

            if (!empty($dbCountries)) {
                $dbCountries = ArrayHelper::map($dbCountries, 'id', 'id');

                $offer->setCountriesArray($dbCountries);
                $offer->save();
            }
        }
    }
}
