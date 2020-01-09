<?php

namespace app\commands\Parser;

/**
 * Class BaseParser
 * @package app\commands\Parser
 */
abstract class BaseParser
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $fileDataPath;

    /**
     * BaseParser constructor.
     * @param string $url
     * @param string $fileDataPath
     */
    public function __construct(string $url, string $fileDataPath)
    {
        $this->url = $url;
        $this->fileDataPath = $fileDataPath;
    }

    /**
     *
     */
    final protected function fetchSourceData()
    {
        $fp = fopen ($this->fileDataPath . '/' . static::DATA_FILE, 'w+');
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }

    /**
     * @param string $countries
     * @return array|string
     */
    protected function prepareCountries(string $countries)
    {
        if ($countries === 'all') {
            return $countries;
        }
        $counties = explode(',', $countries);
        $counties = array_map(function ($country) {
            return strtolower(trim($country));
        }, $counties);

        return $counties;
    }

    abstract public function process();
}
