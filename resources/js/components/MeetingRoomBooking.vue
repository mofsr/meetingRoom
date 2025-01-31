<template>
  <div class="container mt-5">
    <h2>Book a Meeting Room</h2>
    
    <form @submit.prevent="bookMeeting">
      <!-- Meeting Name -->
      <div class="mb-3">
        <label class="form-label">Meeting Name:</label>
        <input type="text" v-model="meeting.name" class="form-control" required />
      </div>

      <!-- Date & Time -->
      <div class="mb-3">
        <label class="form-label">Date and Time:</label>
        <input type="datetime-local" v-model="meeting.datetime" class="form-control" required :min="minDateTime" />
      </div>

      <!-- Duration -->
      <div class="mb-3">
        <label class="form-label">Duration:</label>
        <select v-model="meeting.duration" class="form-control" required>
          <option value="30">30 mins</option>
          <option value="60">60 mins</option>
          <option value="90">90 mins</option>
        </select>
      </div>

      <!-- Members -->
      <div class="mb-3">
        <label class="form-label">Number of Members:</label>
        <input type="number" v-model="meeting.members" class="form-control" required min="1" />
      </div>

      <!-- Meeting Room (Dynamically Fetched) -->
      <div class="mb-3">
        <label class="form-label">Meeting Room:</label>
        <select v-model="meeting.room_id" class="form-control" required>
          <option v-for="room in availableRooms" :key="room.id" :value="room.id">
            {{ room.name }} (Capacity: {{ room.capacity }})
          </option>
        </select>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn btn-primary">Book Meeting</button>
    </form>

    <!-- Error Message -->
    <p v-if="errorMessage" class="text-danger mt-3">{{ errorMessage }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      meeting: {
        name: "",
        datetime: "",
        duration: "",
        members: "",
        room_id: "",
      },
      availableRooms: [],
      errorMessage: "",
    };
  },
  computed: {
    minDateTime() {
      return new Date().toISOString().slice(0, 16);
    }
  },
  watch: {
    meeting: {
      handler() {
        this.fetchAvailableRooms();
      },
      deep: true
    }
  },
  methods: {
    async fetchAvailableRooms() {
      if (this.meeting.datetime && this.meeting.duration && this.meeting.members) {
        try {
          const response = await axios.get(`/api/available-rooms`, {
            params: this.meeting,
          });
          this.availableRooms = response.data;
        } catch (error) {
          console.error("Error fetching rooms:", error);
        }
      }
    },
    async bookMeeting() {
      try {
        const response = await axios.post(`/api/bookmeeting`, this.meeting);
        alert(response.data.message);
        this.$router.push("/mybooking"); // Redirect to bookings page
      } catch (error) {
        this.errorMessage = error.response?.data?.error || "Booking failed!";
      }
    }
  }
};
</script>
