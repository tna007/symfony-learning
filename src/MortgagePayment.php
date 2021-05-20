<?php


namespace App;


use App\Utils\BankAccountInterface;

class MortgagePayment
{
    private BankAccountInterface $account;

    public function __construct(BankAccountInterface $account) {
        $this->account = $account;
    }

    public function makePayment(int $amount): void {
        $sufficientFund = $this->account->withdraw($amount);

        if ($sufficientFund) {
            echo 'Payment has been made';
        } else {
            echo 'Insufficient fund';
        }
    }
}