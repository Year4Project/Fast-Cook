<!-- resources/js/components/OrderNotification.vue -->

<template>
    <div>
      <!-- Your notification display logic here -->
      <div v-if="notification">
        New order placed! Order ID: {{ notification.order_id }}
      </div>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        notification: null,
      };
    },
    // mounted() {
    //   window.Echo.channel('private-user.' + userId)
    //     .notification((notification) => {
    //       // Handle the new order notification
    //       console.log('New Order Notification:', notification);
    //       this.notification = notification;
    //       // Add your logic to update the UI or display a notification
    //     });
    // },
  };
  </script>
