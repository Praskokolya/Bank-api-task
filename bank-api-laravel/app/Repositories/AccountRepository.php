<?php

namespace App\Repositories;

use App\Models\Account;
use App\Services\ExchangeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Extension\FrontMatter\FrontMatterParser;

class AccountRepository
{
    public function __construct(public Account $account, public ExchangeService $exchangeService) {}

    public function create($currency, $user)
    {
        $accountNumber = '';
        for ($i = 0; $i < 4; $i++) {
            $accountNumber .= rand(1000, 9999);
        }

        $this->account->create([
            'user_id' => $user->id,
            'currency' => $currency,
            'account_number' => $accountNumber,
        ]);
    }

    public function transfer($data, $user)
    {
        
        DB::transaction(function () use ($data) {
            $fromAccount = Account::where('account_number', $data['from_account'])->first();
            $toAccount = Account::where('account_number', $data['to_account'])->first();

            if ($fromAccount->balance < $data['amount']) {
                throw new \Exception('Insufficient funds to complete the transfer.');
            }
        $amount = $this->exchangeService->exchange($fromAccount->currency, $toAccount->currency, $data['amount']);

        $fromAccount->balance -= $data['amount'];
        $toAccount->balance += $amount;

        $fromAccount->save();
        $toAccount->save();
});
    }
}
