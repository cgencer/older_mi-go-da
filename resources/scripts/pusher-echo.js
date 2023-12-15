window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

import Echo from "laravel-echo"

window.io = window.io || require('socket.io-client');
window.Echo = window.Echo || {};

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
//    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    wsHost: window.location.hostname,
    wsPort: 65535,
    wssPort: 65535,
    enabledTransports: ['ws', 'wss'],
//    encrypted: true,
    forceTLS: false,
    disableStats: true,
});

/*
Echo.connector.pusher.connection.bind( 'error', function( err ) {
    console.log(err);
});

Echo.connector.pusher.connection.bind('connected', function( ) {
    console.log('connected');
});

Echo.connector.pusher.connection.bind('disconnected', function( ) {
    console.log('disconnected');
});

Echo.connector.pusher.connection.bind('connecting', function( ) {
    console.log('connecting');
});
Echo.connector.pusher.connection.bind('initialized', function( ) {
    console.log('initialized');
});
Echo.connector.pusher.connection.bind('unavailable', function() {
    console.log('unavailable');
});
Echo.connector.pusher.connection.bind('failed', function( ) {
    console.log('failed');
});
*/