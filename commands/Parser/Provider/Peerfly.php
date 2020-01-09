<?php

namespace app\commands\Parser\Provider;

use app\commands\Parser\BaseParser;

/**
 * Class Peerfly
 * @package app\commands\Parser\Provider
 */
final class Peerfly extends BaseParser
{

    public const DATA_FILE = 'peerfly.xml';

    /**
     * @return array
     */
    public function process()
    {
        $this->fetchSourceData();
        $file = $this->fileDataPath . '/' . self::DATA_FILE;
        $xml = simplexml_load_file($file);
        $items = $xml->xpath('//channel/item');
        $result = [];

        foreach ($items as $item) {

            $internalId = (int)$item->offerID;

            $result[$internalId] = [
                'name' => (string)$item->title,
                'payout' => (string)$item->payout,
                'countries' => $this->prepareCountries((string)$item->countries),
                'description' => (string)$item->description,
                'internal_id' => $internalId
            ];
        }
        //unlink($file);
        return $result;
    }
}
