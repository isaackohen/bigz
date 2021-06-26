<?php

return [
    'language' => 'English',
    'head' => [
        'index' => 'Home',
        'description' => 'Social Crypto Gambling Platform with tons of freebies and bonuses!',
        'games' => 'Games',
        'help' => 'Help',
        'promotions' => 'Promotions',
        'wallet' => '<i class="fad fa-wallet"></i>',
        'wallet_open_demo' => 'Demo',
        'wallet_real' => 'Real',
        'wallet_demo' => 'Demo',
        'fairness' => ' ',
        'chat' => 'Chat',
        'featured' => 'Featured',
        'gamelist' => 'All Games',
        'earn' => 'Earn',
        'admin' => 'Administration',
        'bonus' => 'Bonus',
        'bonus_short' => 'Bonus',
        'theme' => 'Theme',
        'profile' => 'Profile',
        'logout' => 'Exit',
        'invest' => 'Invest'
    ],
    'chat_commands' => [
        '/tip' => 'Tip user',
        '/rain' => 'Make it Rain',
        'modal' => [
            'rain' => [
                'amount' => 'Amount',
                'number_of_users' => 'Number of Users (Max 25)',
                'send' => 'Send Rain',
                'invalid_users_length' => 'Invalid number of users',
                'invalid_amount' => 'Invalid amount'
            ],
            'tip' => [
                'amount' => 'Amount',
                'send' => 'Send Tip',
                'user' => 'Username',
                'make_public' => 'Make tip public (will appear on global chat)',
                'invalid_name' => 'Invalid username',
                'invalid_amount' => 'Minimum tip amount not reached',
                'notify' => ':name tipped you :value <i class=":icon" style="color: :style"></i>'
            ]
        ]
    ],
    'tip' => 'Tip',
    'tip_chat' => '<a href=":link">:name</a> sent :value <i class=":icon" style="color: :style"></i> to <a href=":tolink">:toname</a>',
    'wallet' => [
        'demo' => [
            'error' => 'Your demo balance must be at zero',
            'obtain' => 'Receive demo balance'
        ]
    ],
    'demo' => [
        'title' => 'Attention',
        'description' => 'Registration is required if you want to play for real balance.',
        'register' => 'Sign up'
    ],
    'chat' => [
        'enter_message' => 'Message input..'
    ],
    'auth' => [
        'login' => 'Login',
        'register' => 'Signup',
        'through_login' => 'Login and password',
        'recovertext' => 'You can recover your account if you have set an recovery email.',
        'through_social' => 'Social networks',
        'wrong_credentials' => 'Wrong login or password',
        'credentials' => [
            'login' => 'Username',
            'password' => 'Password',
            'email' => 'Email'
        ],
        'create_account' => 'Create account',
        'forgot_password' => 'Forgot your password?',
        'notice' => 'I confirm that I am over 18 years old and I have read <a href="/terms/terms_and_conditions">terms of service</a>'
    ],
    'footer' => [
        'copyright' => 'Copyright &copy; 2021 BIGZ',
        'gaming_policy' => 'Game policy',
        'terms_and_conditions' => 'Terms and Conditions',
        'privacy_policy' => 'Privacy policy',
        'privacy_notice' => 'Privacy notice',
        'fairness' => 'Provably Fair',
        'game' => [
            'help' => 'Help',
            'wide' => 'Toggle Widescreen',
            'sound' => 'Sound',
            'quick' => 'Quick mode',
            'client_seed' => 'Change client seed'
        ]
    ],
    'profile' => [
        'security' => 'Security',
        'email' => 'Email',
        'email_update' => 'Update',
        'invalid_email' => 'Invalid email',
        'email_update_success' => 'Success!',
        'settings' => 'Settings',
        'wager' => 'Wagered',
        'games' => 'Total games',
        'best_mul' => 'Best payout',
        'best_win' => 'Best profit',
        'incognito' => 'User has hidden his profile',
        'set_private_profile' => 'Hide your profile',
        'set_private_bets' => 'Hide your bets',
        'empty' => 'Not enough data to display',
        'privacy' => 'Privacy',
        'fairness' => 'Fairness',
        'client_seed' => 'Client seed',
        'change' => 'Change',
        'change_avatar' => 'Change avatar',
        'avatar' => 'Avatar',
        'stats' => 'Statistics',
        'latest_games' => 'Latest games',
        'vip' => 'Loyalty',
        'partner' => 'Partner Program',
        'change_name' => 'Change name',
        'new_name' => 'New name',
        'social' => 'Linked accounts',
        'vk' => 'VKontakte',
        'fb' => 'Facebook',
        'google' => 'Google',
        'discord' => 'Discord',
        'link' => 'Link',
        'linked' => 'Linked',
        'somebody_already_linked' => 'This social network account has already been linked to another account',
        'link_discord' => 'To access Loyalty promo-codes and roles on the Discord server, you need to link your account.',
        'discord_vip' => 'Join <a href="'.\App\Settings::where('name', 'discord_invite_link')->first()->value.'" target="_blank" class="disable-pjax">our Discord server</a> and get access to exclusive Loyalty promocodes!',
        'discord_vip_ok' => 'Update server role',
        'vip_discord_updated' => 'Discord server role has been updated.',
        'bets' => 'Bets',
        'wins' => 'Wins',
        'losses' => 'Losses',
        'wagered' => 'Wagered',
        'total_profit' => 'Total profit',
        '2fa' => '2FA',
        'keep_secure' => 'Don\'t let anyone see this!',
        'copy_this_to_2fa' => 'Copy this code to your authenticator app',
        '2fa_code' => 'Two Factor Code',
        '2fa_enable' => 'Enable',
        'error_2fa' => 'Invalid 2FA code',
        '2fa_enabled' => '2FA is enabled on your account.',
        'disable_2fa' => 'Disable 2FA',
        '2fa_validate' => 'Validate',
        '2fa_description' => 'Enter 6-digit code from your two factor authenticator app',
        '2fa_digits' => ':digits digits left',
        'profit' => 'Profit',
        'games_c' => 'Games:'
    ],
    'notifications' => [
        'title' => 'Notifications',
        'withdraw_accepted' => [
            'title' => 'BIGZ',
            'message' => 'Your payment request created :diff (:sum :currency) was accepted.'
        ],
        'withdraw_declined' => [
            'title' => 'BIGZ',
            'message' => 'Your payment request created :diff (:sum :currency) was declined. Reason: :reason'
        ],
        'vip_discord' => [
            'title' => 'VIP',
            'message' => "You have reached <svg style='width: 14px; height: 14px'><use href='#vip-emerald'></use></svg> Emerald Loyalty status!
                         <br>We have added 15 free spins to your account!
                         <br><br>Want exclusive Loyalty promocodes? Join <a href='".\App\Settings::where('name', 'discord_invite_link')->first()->value."' class='disable-pjax' target='_blank'>our Discord server</a>.
                         <br><br><a href='javascript:void(0)' onclick='$(\".notifications-overlay\").click(); $.vip();' class='disable-pjax'>Loyalty Rewards and Bonuses</a>"
        ],
        'email_reminder' => [
            'title' => 'BIGZ',
            'message' => 'Do not forget to add email address, otherwise you could lose access to your account! <a href="/user/'.(auth()->guest() ? '' : auth()->user()->_id).'#security">Add email address</a>'
        ],
        'depositcredited' => 'Your deposit has been credited.',
        'withdrawsent' => 'Your withdraw has automatically been sent to your wallet.',
        'bonuscredited' => 'Your deposit bonus has been credited.',
        'deposit' => 'Your deposit has entered blockchain and will be credited after 1 confirmation.'
    ],
    'fairness' => [
        'client_seed' => 'Client seed:',
        'server_seed' => 'Server seed:',
        'nonce' => 'Nonce:'
    ],
    'not_available' => 'Unavailable',
    'obtained' => 'Obtained',
    'bets' => [
        'game' => 'Game',
        'player' => 'Player',
        'time' => 'Time',
        'bet' => 'Bet',
        'mul' => 'Payout',
        'win' => 'Profit',
        'manual' => 'Manual',
        'auto' => 'Auto',
        'games' => 'Number of games',
        'victory_stop' => 'Stop on Win',
        'on_win' => 'On win',
        'on_loss' => 'On loss',
        'reset' => 'Reset',
        'increase' => 'Increase',
        'auto_games_blocked' => 'To set a limit, click on &#8734;.',
        'hidden' => 'The player has hidden his profile',
        'hidden_name' => 'Hidden',
        'make_bet' => 'Place a bet',
        'all' => 'All',
        'mine' => 'My Bets',
        'high_rollers' => 'High Rollers',
        'lucky_wins' => 'Lucky Winners'
    ],
    'error' => [
        'websocket_connect_error' => 'Connecting to the server...',
        'token_grant_error' => 'Failed to connect to the server. Retrying in :seconds second(s)...',
        'token_grant_reconnecting' => 'Connecting to the server...',
        'offline_node' => 'Please wait a moment while we retry generating deposit address for you..',
        'auth' => 'Authorization is required',
        'wager' => 'Default amount - :value',
        'wager_min' => 'Minimal amount - :value',
        'wager_max' => 'Maximum amount - :value',
        'disabled' => 'Game is temporarily unavailable',
        'unknown_game' => 'Unknown game',
        'invalid_wager' => 'Not enough money',
        'unknown_error' => 'An error has occurred (Error :code)',
        'empty' => 'Select cells!',
        'gameinprogressbonus' => 'You currently have a game in-progress.',
        'should_have_empty_balance' => 'Your ETH balance is too big',
        'captcha' => 'Please verify that you are not a robot',
        'autobet_pick_something' => 'Select cells for automatic bid mode.',
        'disabled_notifications' => 'You have refused to accept notifications. This can be changed in your browser settings.',
        'connection_lost' => 'Lost server connection',
        'connection_recovered' => 'Connection restored',
        'disabled_bets' => 'Accepting bets is currently unavailable.',
        'disabled_demo_bets' => 'This game does not accept bets in demo mode.',
        'muted' => 'Chat is muted until :time',
        'invalid_withdraw' => 'Invalid withdrawal amount.',
        'only_one_withdraw' => 'You have already ordered withdrawal.',
        'enter_wallet' => 'Enter wallet number!',
        'promo_limit' => 'You have reached your promocode activation limit per day.',
        'autobet_mines_error' => 'You have selected more cells than the available crystals.',
        'vip_only_promocode' => 'This promotional code is only available with Emerald Loyalty and above.'
    ],
    'profit_monitoring' => [
        'title' => 'Statistics',
        'wager' => 'Wager',
        'profit' => 'Profit',
        'wins' => 'Wins',
        'losses' => 'Losses',
        'no_data' => 'No data'
    ],
    'add_email_notification' => 'Don\'t forget to add email address, otherwise you could lose access to your account! <a href="/user/'.(auth()->guest() ? '' : auth()->user()->_id).'#security">Add email address</a>',
    'rain' => 'It\'s raining!<br>:sum :currency',
    'premiumrain' => 'Super Drop! <br>:sum :currency',
    'premiumsnow' => 'Super Drop! <br>:sum :currency',
    'snow' => 'It\'s raining!<br>:sum :currency',
    'quiz' => 'Quiz Bot',
    'lines' => 'Lines',
    'currency_usd' => '~ &dollar;',
    'currency_euro' => '~ &euro;',
    'quiz_answer' => 'Correct answer:',
    'quiz_user' => 'User:',
    'chart' => 'Chart',
    'crash' => 'CRASHED',
    'yes' => 'Yes',
    'no' => 'No',
	'verify' => 'Check Provably Fair',
    'unit' => 'View $',
    'coming_soon' => 'Coming Soon',
    'reload' => 'Cooldown:',
    'spin' => 'Spin',
    'searchbar' => 'Search Games',
    'wager' => 'Bet amount',
    'chip' => 'Chip Value (:value)',
    'profit' => 'Profit',
    'payout' => 'Payout',
    'play' => '<i style="color: #0fc258; font-size: 14px;" class="fad fa-diamond"></i>  Bet',
    'cancel' => 'Cancel',
    'undo' => 'Undo',
    'close' => 'Close',
    'change' => 'Change',
    'even' => 'even',
    'odd' => 'odd',
    'to' => ':1 - :2',
    'take' => 'Take :value <i class=":icon"></i>',
    'takeindex' => ':value <i class=":icon"></i>',
    'start' => 'Start',
    'stop' => 'Stop',
    'overview' => 'View',
    'share_text' => 'Watch my game!',
    'share_vk' => 'Share the link on VK',
    'share_chat' => 'Send to chat',
    'share_telegram' => 'Share this game on Telegram',
    'share_twitter' => 'Share this game on Twitter',
    'share_link' => 'Share the link',
    'link_copied' => 'Copied!',
    'game_mode' => 'Game mode',
    'color' => 'Color',
    'yellow' => 'Yellow',
    'blue' => 'Blue',
    'pins' => 'Number of pins',
    'autopick' => '<i class="fas fa-wand-magic mr-1"></i> Auto Pick',
    'clear' => 'Clear',
    'mines' => 'Number of mines',
    'edit' => 'Edit',
    'add' => 'Add',
    'already_purchased' => 'Purchased',
    'purchase_sticker_pack' => 'Buy for :coins <i class="fas fa-coins"></i>',
    'hilo-higher' => 'Bet Higher',
    'hilo-lower' => 'Bet Lower',
    'hilo-same' => 'Bet Same',
    'hilo-skip' => 'Skip Card <i class="ml-1 fal fa-angle-double-right"></i>',
    'chance' => 'Chance',
    'chat_at' => 'Type @<strong>username</strong> to notify user',
    'autoStop' => 'Cashout at',
    'target_payout' => 'Target payout',
    'win_chance' => 'Win chance',
    'wait_game_start' => 'Waiting for the game to start...',
    'demo_popup_link' => 'Play for money',
    'double' => 'Double',
    'divide' => 'Split',
    'got' => 'Got',
    'videopoker' => [
        'f_r' => 'Royal Flush',
        's_f' => 'Straight Flush',
        'k' => 'Four of a kind',
        'f_h' => 'Full House',
        'f' => 'Flash',
        's' => 'Straight',
        't' => 'Triple',
        't_p' => 'Two pairs',
        'p' => 'Pair (J, Q, K, A)'
    ],
	'poker' => [
        'mindeposit' => 'Min. deposit $5',
        'invalid' => 'invalid',
        'notenough' => 'Not enough money',
		'minwithdraw' => 'Min. withdrawal $5',
		'success' => 'Success'
    ],
    'deal' => 'Deal cards',
    'stand' => 'Stand',
    'hit' => 'Hit',
    'split' => 'Split',
    'insurance' => 'Do you want insurance?',
    'accept' => 'Accept',
    'decline' => 'Decline',
    'insurance_success' => 'You bought insurance.',
    'blackjack' => [
        '0' => 'Draw',
        '1' => 'You lose',
        '2' => 'You won',
        '3' => 'You won',
        '4' => 'You lose',
        '5' => 'You won',
        '6' => 'You lose'
    ],
    'difficulty' => [
        'title' => 'Difficulty',
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High'
    ],
    'baccarat' => [
        'player' => 'Player',
        'draw' => 'Draw',
        'pair_player' => '[P] Pair',
        'pair_banker' => '[B] Pair',
        'banker' => 'Banker'
    ]
];
