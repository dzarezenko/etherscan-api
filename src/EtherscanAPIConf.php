<?php

namespace etherscan\api;

/**
 * Etherscan API Configuration constants.
 *
 * @category Etherscan API
 * @author Dmytro Zarezenko <dmytro.zarezenko@gmail.com>
 * @copyright (c) 2017, Dmytro Zarezenko
 *
 * @git https://github.com/dzarezenko/etherscan-api
 * @license http://opensource.org/licenses/MIT
 */
class EtherscanAPIConf {

    const API_URL = "https://api.etherscan.io/api";

    const TESTNET_ROPSTEN = "ropsten";
    const TESTNET_KOVAN = "kovan";
    const TESTNET_RINKEBY = "rinkeby";

    /**
     * Returns API basic URL.
     *
     * @param string $net if null then return Mainnet. Otherwise return url / testnet if provided.
     *
     * @return string
     */
    public static function getAPIUrl($net = null) {
        
        // If $net is null return default mainnet url
        if (is_null($net)) {
            return self::API_URL;
        }
        
        // If $net is valid URL then return
        if (filter_var($net, FILTER_VALIDATE_URL)) {
            return $net;
        }
        
        // Otherwise treat $net as testnet name
        return "https://{$net}.etherscan.io/api";
    }

    const TAG_LATEST = "latest";

    const BLOCK_TYPE_BLOCKS = "blocks";
    const BLOCK_TYPE_UNCLES = "uncles";

    public static $blockTypes = [
        self::BLOCK_TYPE_BLOCKS, self::BLOCK_TYPE_UNCLES
    ];

}
