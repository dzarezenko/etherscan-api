<?php

namespace etherscan\api\tools;

/**
 * HTTP requests support class.
 *
 * @category Etherscan API
 * @author Dmytro Zarezenko <dmytro.zarezenko@gmail.com>
 * @copyright (c) 2017, Dmytro Zarezenko
 *
 * @git https://github.com/dzarezenko/etherscan-api
 * @license http://opensource.org/licenses/MIT
 */
class Request {

    /**
     * Etherscan API Key value.
     *
     * @var type
     */
    private $apiKeyToken = "";

    /**
     * cURL handle.
     *
     * @var resource
     */
    private static $ch = null;

    public function __construct($apiKeyToken) {
        $this->apiKeyToken = $apiKeyToken;
    }

    /**
     * Executes curl request to the Etherscan API.
     *
     * @param array $req Request parameters list.
     *
     * @return array JSON data.
     * @throws \Exception If Curl error or Etherscan API error occurred.
     */
    public function exec(array $req = []) {
        usleep(250000);

        // API settings
        $req['apikey'] = $this->apiKeyToken;

        // generate the POST data string
        $postData = http_build_query($req, '', '&');

        // curl handle (initialize if required)
        if (is_null(self::$ch)) {
            self::$ch = curl_init();
            curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                self::$ch,
                CURLOPT_USERAGENT,
                'Mozilla/4.0 (compatible; Etherscan PHP API; ' . php_uname('a') . '; PHP/' . phpversion() . ')'
            );
        }
        curl_setopt(self::$ch, CURLOPT_URL, \etherscan\api\EtherscanAPIConf::API_URL);
        curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt(self::$ch, CURLOPT_SSL_VERIFYPEER, false);

        // run the query
        $res = curl_exec(self::$ch);
        if ($res === false) {
            throw new \Exception("Curl error: " . curl_error(self::$ch));
        }

        $json = json_decode($res, true);

        // Check for the Etherscan API error
        if (isset($json['error'])) {
            throw new \Exception("Etherscan API error: {$json['error']}");
        }

        return $json;
    }

    /**
     * Executes simple GET request to the Etherscan public API.
     *
     * @param string $url API method URL.
     *
     * @return array JSON data.
     */
    public static function json($url) {
        $opts = [
            'http' => [
                'method' => 'GET',
                'timeout' => 10
            ]
        ];
        $context = stream_context_create($opts);
        $feed = file_get_contents($url, false, $context);
        $json = json_decode($feed, true);

        return $json;
    }

}
