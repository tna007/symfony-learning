<?php

namespace App\Controller;

use App\Account;
use App\Bank;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BankAccountController extends AbstractController
{
    #[Route('/bank/account', name: 'bank_account')]
    public function index(): Response
    {
        $bank = new Bank();
        $firstAccount = new Account(1000, 1234);
        $secondAccount = new Account(5000, 123456);
        $thirdAccount = new Account(10000, 123478);

        $bank->addAccount($firstAccount);
        $bank->addAccount($secondAccount);
        $bank->addAccount($thirdAccount);

//        $bank->getAccountById('123478')->deposit(1000);
//        $test = array('id' => $bank->getAccountById(123478));
//        return $this->json($test);
//
//        $bank->getAccountById('123456')->withdraw(-10000);

        return $this->json([
            'id' => $bank->getAccountById(123456),
            'balance' => $bank->getAccountById(123478)->getBalance(),
            'accounts' => $bank->getAccounts()
        ]);

//        $res = [];
//        $accounts = $bank->getAccounts();
//        foreach ($accounts as $acc) {
//            $res[] = array(
//                'id' => $acc->getId(),
//                'balance' => $acc->getBalance()
//            );
//        }
//        return $this->json($res);
    }
}
