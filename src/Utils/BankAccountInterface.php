<?php


namespace App\Utils;


interface BankAccountInterface
{
    /**
     * @param int $amount contains non negative withdraw amount
     * @return bool
     */
    public function withdraw(int $amount): bool;

    /**
     * @param int $amount contains non negative deposit amount
     */
    public function deposit(int $amount): void;
}