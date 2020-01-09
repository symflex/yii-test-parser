<?php

namespace app\commands\Parser\Provider;

use app\commands\Parser\BaseParser;

/**
 * Class Offerdollar
 * @package app\commands\Parser\Provider
 */
final class Offerdollar extends BaseParser
{
    public const DATA_FILE = 'offerdollar.xml';

    /**
     * @return array
     */
    public function process()
    {
        $this->fetchSourceData();
        $file = $this->fileDataPath . '/' . self::DATA_FILE;
        $xml = simplexml_load_file($file);
        $items = $xml->xpath('//campaigns/campaign');
        $result = [];

        foreach ($items as $item) {

            $internalId = (int)$item->campaign_id;

            $result[$internalId] = [
                'name' => (string)$item->campaign_name,
                'payout' => trim((string)$item->payout, '$'),
                'countries' => $this->prepareCountries((string)$item->countries),
                'description' => (string)$item->campaign_desc,
                'internal_id' => $internalId
            ];
        }
        //unlink($file);
        return $result;
    }
}
