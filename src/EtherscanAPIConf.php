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
     * @param string $net Mainnet - if null, or testnet if provided.
     *
     * @return string
     */
    public static function getAPIUrl($net = null) {
        if (is_null($net)) {
            return self::API_URL;
        }

        return "https://{$net}.etherscan.io/api";
    }

    const TAG_LATEST = "latest";

    const BLOCK_TYPE_BLOCKS = "blocks";
    const BLOCK_TYPE_UNCLES = "uncles";

    public static $blockTypes = [
        self::BLOCK_TYPE_BLOCKS, self::BLOCK_TYPE_UNCLES
    ];

}
