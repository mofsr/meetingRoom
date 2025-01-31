import { createRouter, createWebHistory } from 'vue-router'; // Import Vue Router functions
import Login from '../components/Login.vue';  // Import your Login component
import Register from '../components/Register.vue';  // Import your Register component
import Home from '../components/Home.vue'; // An example Home page, you can replace with your own
import bookmeeting from '../components/MeetingRoomBooking.vue'; // An example Home page, you can replace with your own
import Mybooking from '../components/MyBookings.vue'; // An example Home page, you can replace with your own

const routes = [
  {
    path: '/',  // Home path
    name: 'home',
    component: Home,
  },
  {
    path: '/login',  // Login page path
    name: 'login',
    component: Login,
  },
  {
    path: '/register',  // Registration page path
    name: 'register',
    component: Register,
  },
  {
    path: '/bookmeeting',  // Registration page path
    name: 'bookmeeting',
    component: bookmeeting,
  },

  {
    path: '/Mybooking',  // Registration page path
    name: 'Mybooking',
    component: Mybooking,
  },
  
  // Add other routes for your app here
];

const router = createRouter({
  history: createWebHistory(), // Uses the HTML5 history mode for clean URLs
  routes,  // Define all your routes here
});

export default router; // Export the router to be used in the main app
