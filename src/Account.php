<?php


namespace App;


class Account
{
    private $balanceAcc;
    private $id;

    public function __construct($balance, $id)
    {
        $this->balanceAcc = $balance;
        $this->id = $id;
    }

    /**
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balanceAcc;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function deposit($amount) {
        return $this->balanceAcc += $amount;
    }

    public function withdraw($withdrawn) {
        return $this->balanceAcc -= $withdrawn;
    }
}