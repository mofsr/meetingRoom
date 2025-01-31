<template>
  <div class="container mt-5">
    <h2>My Bookings</h2>

    <!-- Filter Tabs -->
    <div class="mb-3">
      <button class="btn btn-primary me-2" :class="{ 'btn-dark': filter === 'upcoming' }" @click="setFilter('upcoming')">Upcoming</button>
      <button class="btn btn-secondary" :class="{ 'btn-dark': filter === 'past' }" @click="setFilter('past')">Past</button>
    </div>

    <!-- Booking List -->
    <div v-if="bookings.length">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Meeting Name</th>
            <th>Date & Time</th>
            <th>Duration</th>
            <th>Members</th>
            <th>Meeting Room</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="booking in bookings" :key="booking.id">
            <td>{{ booking.meeting_name }}</td>
            <td>{{ formatDate(booking.date_time) }}</td>
            <td>{{ booking.duration }} mins</td>
            <td>{{ booking.members }}</td>
            <td>{{ booking.room ? booking.room.name : 'N/A' }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- No Bookings Found -->
    <p v-else class="text-center text-muted">No {{ filter }} bookings found.</p>

    <!-- Pagination -->
    <div v-if="pagination.total > pagination.per_page">
      <button class="btn btn-outline-primary me-2" :disabled="pagination.current_page === 1" @click="fetchBookings(pagination.current_page - 1)">Previous</button>
      <button class="btn btn-outline-primary" :disabled="pagination.current_page === pagination.last_page" @click="fetchBookings(pagination.current_page + 1)">Next</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      bookings: [],
      filter: 'upcoming', // Default filter
      pagination: {},
    };
  },
  mounted() {
    this.fetchBookings();
  },
  methods: {
    async fetchBookings(page = 1) {
      try {
        const response = await axios.get(`/api/bookings`, {
          params: { filter: this.filter, page, per_page: 5 },
          headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
        });

        this.bookings = response.data.data;
        this.pagination = {
          current_page: response.data.current_page,
          last_page: response.data.last_page,
          per_page: response.data.per_page,
          total: response.data.total,
        };
      } catch (error) {
        console.error('Error fetching bookings:', error);
      }
    },
    setFilter(filterType) {
      this.filter = filterType;
      this.fetchBookings();
    },
    formatDate(datetime) {
      return new Date(datetime).toLocaleString();
    }
  }
};
</script>
