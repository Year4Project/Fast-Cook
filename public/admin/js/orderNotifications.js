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
        <div class="m-0 p-0">
            <h5>New Order Received</h5>
            <p><strong>Order ID: ${orderId}</strong></p>
            <p><strong>User: ${userName}</strong></p>
            <p><strong>Table No: ${tableNo}</strong></p>
            <div style="margin-top: 10px;">
                <button id="acceptButton" class="btn btn-success btn-sm">Accept</button>
                <button id="notAcceptButton" class="btn btn-danger btn-sm" style="margin-left: 10px;">Not Accept</button>
            </div>
        </div>
    `;
    


        toastr.success(
            toastContent,
            '', {
                timeOut: 0,
                extendedTimeOut: 0,
                closeButton: true,
                onShown: function() {
                    playAudio(); // Play audio when order is received

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

    function playAudio() {
        var audio = new Audio(soundPath);
        audio.play().catch(function(error) {
            console.error('Audio playback failed:', error);
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
