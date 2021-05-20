<?php


namespace App;


use App\Utils\BankAccountInterface;

class Account implements BankAccountInterface
{
    private $balanceAcc;
    private $id;

    public function __construct($balance, $id)
    {
        $this->balanceAcc = $balance;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getBalance(): int
    {
        return $this->balanceAcc;
    }

    /**
     * @param $amount
     * @return int
     */
    public function setBalance($amount): int
    {
        return $this->balanceAcc = $amount;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function deposit($amount): void {
        if ($amount > 0) {
            $this->balanceAcc += $amount;
        }
    }

    public function withdraw($amount): bool {
        if ($amount > 0 && $amount < $this->getBalance()) {
            $newBalance = $this->getBalance() - $amount;
            $this->setBalance($newBalance);
            return true;
        } else {
            return false;
        }

    }
}