window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'c1883fa9515920f7b41f',
    wsHost: window.location.hostname,
    wsPort: 49153,
    forceTLS: false,
    disableStats: true,
});