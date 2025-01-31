// Import Vue's createApp function
import { createApp } from 'vue';

// Import the root App component
import App from './App.vue';

// Import the router configuration
import router from './router';

// Import Bootstrap for styling
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';

// Import your MeetingRoomBooking component
import MeetingRoomBooking from './components/MeetingRoomBooking.vue';
import MyBookings from './components/MyBookings.vue';

// Create the Vue app instance
const app = createApp(App);

// Register the MeetingRoomBooking component globally
app.component('meeting-room-booking', MeetingRoomBooking);
app.component('my-booking', MyBookings);

// Tell Vue to use Vue Router
app.use(router);

// Mount the Vue app to the DOM element with the ID of "app"
app.mount('#app');
