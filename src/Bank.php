<?php


namespace App;


class Bank
{
    private array $accounts;

    public function __construct()
    {
        $this->accounts = [];
    }

    public function addAccount(Account $account)
    {
        $this->accounts[] = $account;
    }

    /**
     * @return array
     */
    public function getAccounts(): array
    {
        return $this->accounts;
    }

    /**
     * look under the array of accounts for the one with matching id
     * return the account if found
     * @param string $accountId
     * @return Account
     */
    public function getAccountById(string $accountId): Account
    {
        //TODO: update this so it returns the matching account id in the accounts array
        $key = intval(array_keys($this->accounts, $accountId));
        return $this->accounts[$key];
    }
}