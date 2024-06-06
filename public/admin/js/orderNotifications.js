document.addEventListener('DOMContentLoaded', function() {
    if (!window.restaurantData) {
        console.error('Restaurant data not found.');
        return;
    }

    var restaurantId = window.restaurantData.restaurantId;
    var csrfToken = window.restaurantData.csrfToken;
    var soundPath = window.restaurantData.soundPath;

    var pusher = new Pusher('234577bd0d1513d54647', {
        cluster: 'ap2',
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-Token': csrfToken
            }
        }
    });

    var channel = pusher.subscribe('restaurant.' + restaurantId);

    channel.bind('App\\Events\\OrderPlacedEvent', function(data) {
        var orderId = data.order.id;
        var userName = data.user.first_name + ' ' + data.user.last_name;
        var tableNo = data.order.table_no;

        var toastContent = `
            <div>
                New order received - Order ID: ${orderId}, User: ${userName}, Table No: ${tableNo}
                <br>
                <button id="acceptButton" class="btn btn-success btn-sm" style="margin-top: 10px;">Accept</button>
                <button id="notAcceptButton" class="btn btn-danger btn-sm" style="margin-top: 10px;">Not Accept</button>
            </div>
        `;

        toastr.success(
            toastContent,
            '', {
                timeOut: 0,
                extendedTimeOut: 0,
                closeButton: true,
                onShown: function() {
                    var audio = new Audio(soundPath);
                    audio.play();

                    document.getElementById('acceptButton').addEventListener('click', function() {
                        toastr.remove();
                        handleOrderAction(orderId, true);
                    });
                    document.getElementById('notAcceptButton').addEventListener('click', function() {
                        toastr.remove();
                        handleOrderAction(orderId, false);
                    });
                }
            }
        );
    });

    function handleOrderAction(orderId, isAccepted) {
        var url = '/api/orders/' + orderId + '/status';
        var data = {
            status: isAccepted ? 'accepted' : 'rejected'
        };
    
        fetch(url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                var notificationMessage = isAccepted ? 'Your order has been accepted.' : 'Your order has been rejected.';
                toastr.success(notificationMessage);
    
                // Send notification back to API
                if (isAccepted) {
                    sendNotificationToCustomer(orderId);
                }
            } else {
                alert('Error: ' + data.message);
            }
            setTimeout(function() {
                window.location.reload();
            }, 3000);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }
    
    function sendNotificationToCustomer(orderId) {
        var notificationUrl = '/api/notify-customer/' + orderId + '/order-accepted';
    
        fetch(notificationUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Notification sent to customer');
            } else {
                console.error('Error sending notification to customer:', data.message);
            }
        })
        .catch((error) => {
            console.error('Error sending notification to customer:', error);
        });
    }
    
});
