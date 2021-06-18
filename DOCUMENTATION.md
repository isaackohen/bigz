# Datagamble Setup

Follow standard Laravel tutorial to set up your server.

Configure database credentials in .env file and run this command to create database collections:
```
php artisan migrate
```

## WebSockets Setup

### Apache Proxy

```$bash
a2enmod proxy
a2enmod proxy_http
```

VirtualHost configuration

**HTTP**
```
ProxyPass        /socket.io http://localhost:8443/socket.io
ProxyPassReverse /socket.io http://localhost:8443/socket.io
```

**SSL**
```
ProxyPass        /socket.io https://localhost:8443/socket.io
ProxyPassReverse /socket.io https://localhost:8443/socket.io
```

### .env

Set **BROADCAST_DRIVER** to redis

### Starting

```
php artisan jwt:secret
laravel-echo-server init (When asked, use port 8443 and setup SSL if you want to use it)
laravel-echo-server start
```

Modify **laravel-echo-server.json**
```$json
"databaseConfig": {
	"redis": {},
	"sqlite": {
		"databasePath": "/database/laravel-echo-server.sqlite"
	},
	"listenWhishper": true,
	"prefixWhishper": "whisper"
},
```

To make client-side requests work and make them being processed by server, run this command:
```
php artisan datagamble:subscribe
```

### Troubleshooting

#### Website: infinite loading with text "Failed to connect to the server. Retrying in 5 second(s)..."

Either JWT is not configured (run ```php artisan jwt:secret```) or something else is causing server to give 500 error. Check your logs in storage/logs.

#### Lost server connection

Laravel-echo-server is configured incorrectly. Make sure it's running. If it's not running after you enabled SSL on your server, then modify laravel-echo-server.json with correct cert/cert key path.

#### No error messages, but chat doesn't show any message and /game pages are blank

```php artisan datagamble:subscribe``` should be running.

You may also check laravel-echo-server logs to be sure your users are authenticated to channels. Laravel-echo-server should be running in development mode to display this information.

## Bitcoin nodes setup

```$bash
cd <node folder>/bin
./start.sh
```

Modify credentials in start.sh files.

Full synchronization may take up to 1 week depending on server internet connection/CPU/etc.

### Ethereum

./start.sh is located in geth folder.

Ethereum lightclient node needs peers to work properly.
You may find them [here](https://gist.github.com/rfikki/e2a8c47f4460668557b1e3ec8bae9c11).

Install pm2 and run ```web3.js``` to process Ethereum payments.
```
cd <your website root>
npm install -g pm2
pm2 start web3.js
```

### BTC/BCH

*You may skip this, default configuration in start.sh file already have this configured.*

Bitcoin Core (BTC) and Bitcoin ABC (BCH) are using same default RPC port and datadir. Since you can't use same settings, you need to change their settings individually, otherwise one of them won't work.

