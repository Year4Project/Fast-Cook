<!-- resources/js/components/OrderComponent.vue -->

<template>
    <div>
      <h2>Real-time Order Updates</h2>
      <ul>
        <li v-for="order in orders" :key="order.user_id">
          {{ order.user_id }} ordered {{ order.quantity }} items
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        orders: [],
      };
    },
    mounted() {
      window.Echo.channel('orders')
        .listen('OrderCreated', (event) => {
          this.orders.push(event);
        });
    },
  };
  </script>
  