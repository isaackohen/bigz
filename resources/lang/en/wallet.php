<?php

return [
    'tabs' => [
        'deposit' => 'Deposit',
        'withdraw' => 'Withdraw',
        'poker' => 'Poker',
        'history' => 'History',
        'deposits' => 'Deposits',
        'withdraws' => 'Withdraws'
    ],
    'deposit' => [
        'address' => 'Your :currency deposit address',
        'go' => 'Generate Deposit Address',
        'balance' => 'Selected Cryptocurrency',
        'pick' => ' ',
        'minimum' => 'Minimum deposit for this currency: ',
        'title' => 'Generated Deposit Address!',
        'content' => 'Your deposit address has been generated, valid for next 24 hours:',

        'minimumdepo' => 'Send only 1 deposit per address, address automatically refreshes after deposit. Min deposit: ',
        'confirmations' => ' '
        //'confirmations' => 'Only send :currency to this address, :confirmations confirmation(s) required.'
    ],
    'withdraw' => [
        'address' => '<i class=":icon"></i> :currency Address',
        'amount' => 'Amount (Min :min <i class=":icon"></i>)',
        'button' => 'Withdraw',
        'balance' => 'Selected Cryptocurrency',
        'sum' => 'Withdraw Request',
        'enter_wallet' => 'Enter crypto address you want to receive funds on:',
        'wallet' => 'Your Withdrawal Address',
        'go' => 'Initiate Withdrawal',

        'fee' => 'You need to have :fee <i class=":icon"></i> left on your account to cover the transaction fee.'
    ],
    'history' => [
        'empty' => 'Nothing to show.',
        'name' => 'Currency',
        'sum' => 'Amount',
        'ledger' => 'Ledger',
        'date' => 'Date',
        'status' => 'Status',
        'confirmations' => 'Confirmations',
        'id' => 'ID: :id',
        'paid' => 'Successful',
        'wallet' => 'Address: :wallet',
        'cancel' => 'Cancel',
        'withdraw_cancelled' => 'Cancelled.',
        'withdraw_status' => [
            'moderation' => 'Pending',
            'accepted' => 'Successful',
            'declined' => 'Cancelled',
            'reason' => 'Reason:',
            'cancelled' => 'Cancelled by user'
        ]
    ],
    'copy' => 'Copy',
    'fast' => 'Istant deposit & instant withdrawals.',
    'troubles' => 'Contact support if you have any questions.',

    'copied' => 'Copied!'
];
