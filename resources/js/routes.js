$.routes = function() {
    return {
        '/': ['/js/pages/index.js'],
        '/support': ['/js/pages/support.js'],
        '/bonus': ['/js/pages/bonus.js'],
        '/user': ['/js/pages/user.js'],
        '/fairness': ['/js/pages/fairness.js'],
		'/leaderboard': ['/js/pages/leaderboard.js'],
        '/partner': ['/js/pages/partner.js'],
        '/game': [`/js/pages/${window.location.pathname.substr(window.location.pathname.lastIndexOf('/') + 1)}.js`],
        '/game/slot': ['/js/pages/slot.js'],
        '/game/slot/evoplay/': ['/js/pages/evoplay.js'],
        '/wallet': ['/js/pages/wallet.js'],
        '/live': ['/js/pages/live.js'],
        '/poker': ['/js/pages/poker.js'],
        '/huh': ['/js/pages/huh.js'],
        '/internalerror': ['/js/pages/internalerror.js'],
        '/welcome': ['/js/pages/welcome.js'],

        '/admin': ['/js/admin/pages/dashboard.js'],
        '/admin/promo': ['/js/admin/pages/promo.js'],
        '/admin/settings': ['/js/admin/pages/settings.js'],
        '/admin/notifications': ['/js/admin/pages/notifications.js'],
        '/admin/users': ['/js/admin/pages/users.js'],
        '/admin/user': ['/js/admin/pages/user.js'],
        '/admin/slotslist': ['/js/admin/pages/slotslist.js'],
        '/admin/wallet': ['/js/admin/pages/wallet.js'],
        '/admin/wallet_ignored': ['/js/admin/pages/wallet.js'],
        '/admin/modules': ['/js/admin/pages/modules.js'],
        '/admin/currency': ['/js/admin/pages/currency.js']
    }
};
