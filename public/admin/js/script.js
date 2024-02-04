// Listen for new order events
window.Echo.private('restaurant-orders')
    .listen('NewOrderEvent', (e) => {
        console.log('New Order Received:', e.order);
        // Update the UI to reflect the new order
    });
