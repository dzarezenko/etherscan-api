<?php

namespace etherscan\api;

use etherscan\api\tools\Request;

/**
 * Etherscan API Wrapper.
 *
 * @category Etherscan API
 * @author Dmytro Zarezenko <dmytro.zarezenko@gmail.com>
 * @copyright (c) 2017, Dmytro Zarezenko
 *
 * @git https://github.com/dzarezenko/etherscan-api
 * @license http://opensource.org/licenses/MIT
 */
class Etherscan {

    /**
     * Etherscan API key token.
     *
     * @var string
     */
    private $apiKeyToken;

    /**
     * cURL request object.
     *
     * @var Request
     */
    private $request = null;

    public function __construct($apiKeyToken = null) {
        if (is_null($apiKeyToken)) {
            return;
        }

        $this->apiKeyToken = $apiKeyToken;
        $this->request = new Request($apiKeyToken);
    }

    // === Account APIs ========================================================

    /**
     * Get Ether Balance for a single Address.
     *
     * @param string $address Ether address.
     * @param string $tag
     *
     * @return array
     */
    public function balance($address, $tag = EtherscanAPIConf::TAG_LATEST) {
        return $this->request->exec([
            'module' => "account",
            'action' => "balance",
            'address' => $address,
            'tag' => $tag
        ]);
    }

    /**
     * Get Ether Balance for multiple Addresses in a single call.
     *
     * @param string $addresses Ether address.
     * @param string $tag
     *
     * @return array
     */
    public function balanceMulti($addresses, $tag = EtherscanAPIConf::TAG_LATEST) {
        if (is_array($addresses)) {
            $addresses = implode(",", $addresses);
        }

        return $this->request->exec([
            'module' => "account",
            'action' => "balancemulti",
            'address' => $addresses,
            'tag' => $tag
        ]);
    }

    /**
     * Get a list of 'Normal' Transactions By Address.
     * (Returns up to a maximum of the last 10000 transactions only).
     *
     * @param string $address Ether address.
     * @param int $startBlock Starting blockNo to retrieve results
     * @param int $endBlock Ending blockNo to retrieve results
     * @param string $sort 'asc' or 'desc'
     * @param int $page Page number
     * @param int $offset Offset
     *
     * @return array
     */
    public function transactionList($address, $startBlock = 0, $endBlock = 99999999, $sort = "asc", $page = null, $offset = null) {
        $params = [
            'module' => "account",
            'action' => "txlist",
            'address' => $address,
            'startblock' => $startBlock,
            'endblock' => $endBlock,
            'sort' => $sort
        ];

        if (!is_null($page)) {
            $params['page'] = (int)$page;
        }

        if (!is_null($offset)) {
            $params['offset'] = (int)$offset;
        }

        return $this->request->exec($params);
    }

    /**
     * Get a list of 'Internal' Transactions by Address
     * (Returns up to a maximum of the last 10000 transactions only).
     *
     * @param string $address Ether address.
     * @param int $startBlock Starting blockNo to retrieve results
     * @param int $endBlock Ending blockNo to retrieve results
     * @param string $sort 'asc' or 'desc'
     * @param int $page Page number
     * @param int $offset Offset
     *
     * @return array
     */
    public function transactionListInternalByAddress($address, $startBlock = 0, $endBlock = 99999999, $sort = "asc", $page = null, $offset = null) {
        $params = [
            'module' => "account",
            'action' => "txlistinternal",
            'address' => $address,
            'startblock' => $startBlock,
            'endblock' => $endBlock,
            'sort' => $sort
        ];

        if (!is_null($page)) {
            $params['page'] = (int)$page;
        }

        if (!is_null($offset)) {
            $params['offset'] = (int)$offset;
        }

        return $this->request->exec($params);
    }

    /**
     * Get "Internal Transactions" by Transaction Hash.
     *
     * @param string $transactionHash
     *
     * @return array
     */
    public function transactionListInternalByHash($transactionHash) {
        return $this->request->exec([
            'module' => "account",
            'action' => "txlistinternal",
            'txhash' => $transactionHash
        ]);
    }

    /**
     * Get list of Blocks Mined by Address.
     *
     * @param string $address Ether address
     * @param string $blockType "blocks" or "uncles"
     * @param int $page Page number
     * @param int $offset Offset
     *
     * @return array
     */
    public function getMinedBlocks($address, $blockType = EtherscanAPIConf::BLOCK_TYPE_BLOCKS, $page = null, $offset = null) {
        if (!in_array($blockType, EtherscanAPIConf::$blockTypes)) {
            throw new \Exception("Invalid block type");
        }

        $params = [
            'module' => "account",
            'action' => "getminedblocks",
            'address' => $address,
            'blocktype' => $blockType,
        ];

        if (!is_null($page)) {
            $params['page'] = (int)$page;
        }

        if (!is_null($offset)) {
            $params['offset'] = (int)$offset;
        }

        return $this->request->exec($params);
    }

    // === Contract APIs =======================================================

    /**
     * Get Contract ABI for Verified Contract Source Codes.
     * (Newly verified Contracts are synched to the API servers within 5 minutes or less).
     *
     * @param string $address Ether address.
     *
     * @return array
     */
    public function getABI($address) {
        return $this->request->exec([
            'module' => "contract",
            'action' => "getabi",
            'address' => $address
        ]);
    }

    /**
     * Get Contract ABI for Verified Contract Source Codes.
     * (Newly verified Contracts are synched to the API servers within 5 minutes or less).
     *
     * @param string $address Ether address.
     *
     * @return array
     */
    public function getContractABI($address) {
        return $this->getABI($address);
    }

    // === Transaction APIs ====================================================

    /**
     * Check Contract Execution Status (if there was an error during contract execution).
     * Note: isError":"0" = Pass , isError":"1" = Error during Contract Execution.
     *
     * @param string $transactionHash
     *
     * @return int
     */
    public function getStatus($transactionHash) {
        return $this->request->exec([
            'module' => "transaction",
            'action' => "getstatus",
            'txhash' => $transactionHash
        ]);
    }

    /**
     * Check Contract Execution Status (if there was an error during contract execution).
     * Note: isError":"0" = Pass , isError":"1" = Error during Contract Execution.
     *
     * @param string $transactionHash
     *
     * @return int
     */
    public function getContractExecutionStatus($transactionHash) {
        return $this->getStatus($transactionHash);
    }

    // === Blocks APIs =========================================================

    /**
     * Get Block And Uncle Rewards by BlockNo.
     *
     * @param int $blockNumber
     *
     * @return array
     */
    public function getBlockReward($blockNumber) {
        return $this->request->exec([
            'module' => "block",
            'action' => "getblockreward",
            'blockno' => $blockNumber
        ]);
    }

    // === Event Logs ==========================================================

    //TODO: implement

    // === Geth/Parity Proxy APIs ==============================================

    //TODO: implement

    // === Websockets ==========================================================

    //TODO: implement

    // === Token Info ==========================================================

    /**
     * Get Token TotalSupply by TokenName (Supported TokenNames: DGD, MKR,
     * FirstBlood, HackerGold, ICONOMI, Pluton, REP, SNGLS).
     *
     * or
     *
     * by ContractAddress.
     *
     * @param string $tokenIdentifier Token name from the list or contract address.
     *
     * @return array
     */
    public function tokenSupply($tokenIdentifier) {
        $params = [
            'module' => "stats",
            'action' => "tokensupply",
        ];

        if (strlen($tokenIdentifier) === 42) {
            $params['contractaddress'] = $tokenIdentifier;
        } else {
            $params['tokenname'] = $tokenIdentifier;
        }

        return $this->request->exec($params);
    }

    /**
     * Get Token Account Balance by known TokenName (Supported TokenNames: DGD,
     * MKR, FirstBlood, HackerGold, ICONOMI, Pluton, REP, SNGLS).
     *
     * or
     *
     * for TokenContractAddress.
     *
     * @param string $tokenIdentifier Token name from the list or contract address.
     * @param string $address Ether address.
     * @param string $tag
     *
     * @return array
     */
    public function tokenBalance($tokenIdentifier, $address, $tag = EtherscanAPIConf::TAG_LATEST) {
        $params = [
            'module' => "stats",
            'action' => "tokenbalance",
            'address' => $address,
            'tag' => $tag
        ];

        if (strlen($tokenIdentifier) === 42) {
            $params['contractaddress'] = $tokenIdentifier;
        } else {
            $params['tokenname'] = $tokenIdentifier;
        }

        return $this->request->exec($params);
    }

    // === General Stats =======================================================

    /**
     * Get Total Supply of Ether.
     *
     * @return int Result returned in Wei, to get value in Ether divide
     *           resultAbove / 1000000000000000000
     */
    public function ethSupply() {
        return $this->request->exec([
            'module' => "stats",
            'action' => "ethsupply",
        ]);
    }

    /**
     * Get Ether LastPrice Price.
     *
     * @return float
     */
    public function ethPrice() {
        return $this->request->exec([
            'module' => "stats",
            'action' => "ethprice",
        ]);
    }

    // === Utility methods =====================================================

    /**
     * Converts Wei value to the Ether float value.
     *
     * @param int $amount
     *
     * @return float
     */
    public static function convertEtherAmount($amount) {
        return (float)$amount / pow(10, 18);
    }

    /**
     * Checks if transaction is input transaction.
     *
     * @param string $address Ether address.
     * @param array $transactionData Transaction data.
     *
     * @return bool
     */
    public static function isInputTransaction($address, $transactionData) {
        return (strtolower($transactionData['to']) === strtolower($address));
    }

    /**
     * Checks if transaction is output transaction.
     *
     * @param string $address Ether address.
     * @param array $transactionData Transaction data.
     *
     * @return bool
     */
    public static function isOutputTransaction($address, $transactionData) {
        return (strtolower($transactionData['from']) === strtolower($address));
    }

}
