<?php

return [
    'rank' => [
        'level' => 'VIP Club - :level',
        '0' => 'New',
        '1' => 'Emerald',
        '2' => 'Amethyst',
        '3' => 'Gold',
        '4' => 'Platinum',
        '5' => 'Diamond'
    ],
    'description' => 'Your VIP Level increases simply by wagering bets in most games in any currency.',
    'description.2' => 'Your progress to next VIP rank can be followed here.',
    'benefits_description' => 'VIP Rewards:',
    'benefits' => 'VIP Club Rankings:',
    'benefit_list' => [
        'emerald' => [
            '1' => 'Daily Cashback Feature unlocked',
            '2' => 'Access to VIPDROPS',
            '3' => 'Get 10 Free Slot Spins',
            '4' => 'Faucet Amount Increased'
        ],
        'ruby' => [
            '1' => 'Daily DROP use-limit increased from 5 to 20',
            '2' => 'Increased Daily Cashback Reward',
            '3' => 'Faucet Amount Increased',
            '4' => 'DROP Reward increased by 25%'
        ],
        'gold' => [
            '1' => 'VIPDROPS do not affect the overall activation limit of DROP code',
            '2' => 'Promocode Reward increased by 50%',
            '3' => 'Increased Daily Cashback Reward',
            '4' => 'Get 50 Free Slot Spins'
        ],
        'platinum' => [
            '1' => 'Increased Daily Royalty Reward',
            '2' => 'Get 75 Free Slot Spins',
            '3' => 'Use Faucet System Hourly'
        ],
        'diamond' => [
            '1' => 'You are able to get customized and personalized rewards, such as custom border and animated avatar',
            '2' => 'DROP limit now resets every 12 hours',
            '3' => 'Increased Daily Cashback Reward',
            '4' => 'Get 150 Free Slot Spins'
        ]
    ],
    'bonus' => [
        'tooltip' => 'Daily Cashback',
        'title' => 'Daily Cashback',
        'progress_title' => 'Progress',
        'description' => "Once you reach Emerald Rank <svg style='width: 14px; height: 14px'><use href='#vip-emerald'></use></svg> within VIP Club, you are eligible to use Daily Cashback Feature. 
        Each wager over ".\App\Settings::where('name', 'dailybonus_minbet_slots')->first()->value." unlock 0.01% of your total daily cashback reward.<br>
                          <br>The total size of which is determined by your VIP Club Rank.<br>
                          <br>You can cash-in your Daily Cashback at any time, but keep in mind that after this you will not be able to receive this cash reward for the rest of the day.
                          <br><br>We reset the Daily Cashback every day at midnight. So make sure to remember to take the reward before midnight!",
        'timeout' => "<br><strong>You have already received Daily Cashback.</strong><br>Come back tomorrow!<br><br>"
    ]
];
