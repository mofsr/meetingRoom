<template>
    <div class="login">
        <h2>Login</h2>
        <form @submit.prevent="login">
            <input v-model="email" type="email" placeholder="Email" required />
            <input v-model="password" type="password" placeholder="Password" required />
            <button type="submit">Login</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: '',
            password: '',
            errorMessage: '', // Store error messages here
        };
    },
    methods: {
        async login() {
            try {
                const response = await axios.post('http://127.0.0.1:8000/api/login', {
                    email: this.email,
                    password: this.password,
                });

                localStorage.setItem('token', response.data.token);
                this.$router.push('/mybooking'); // Redirect to home page
            } catch (error) {
                if (error.response) {
                    console.log(error.response);
                    // Handle API errors
                    if (error.response.status === 429) {
                        this.errorMessage = 'Too many login attempts. Try again in 24 hours.';
                        alert('Too many login attempts. Try again in 24 hours or Connect to admin.')
                    } else if (error.response.status === 401) {
                        this.errorMessage = 'Invalid credentials. Please try again.';
                        alert('Invalid credentials. Please try again.')
                    } else {
                        this.errorMessage = 'An error occurred. Please try again later.';
                        alert('An error occurred. Please try again later')
                    }
                } else {
                    this.errorMessage = 'Network error. Please check your connection.';
                    alert('Network error. Please check your connection.')
                }
            }
        },
    },
};
</script>

