/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

require('./components/Cart');

Echo.channel('new-order')
    .listen('NewOrderPlaced', (event) => {
        // Handle the new order event and update the dashboard
        console.log('New Order Placed:', event);
        // Add your logic to update the dashboard here
        console.log('Echo setup:', Echo);

    });

    