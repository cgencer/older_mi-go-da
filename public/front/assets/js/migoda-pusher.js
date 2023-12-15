"use strict";

var _laravelEcho = _interopRequireDefault(require("laravel-echo"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

window.io = window.io || require('socket.io-client');
window.Echo = window.Echo || {};
window.Pusher = require('pusher-js');
window.Echo = new _laravelEcho["default"]({
  broadcaster: 'pusher',
  key: 'c1883fa9515920f7b41f',
  wsHost: window.location.hostname,
  wsPort: 49153,
  wssPort: 49153,
  enabledTransports: ['ws', 'wss'],
  encrypted: true,
  forceTLS: false,
  disableStats: true
});
