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

    const TAG_LATEST = "latest";

    const BLOCK_TYPE_BLOCKS = "blocks";
    const BLOCK_TYPE_UNCLES = "uncles";

    public static $blockTypes = [
        self::BLOCK_TYPE_BLOCKS, self::BLOCK_TYPE_UNCLES
    ];

}
