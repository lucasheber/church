<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const props = defineProps({});

const form = useForm({
    email: '',
    password: '',
    remember: false,
    errors: {
        email: '',
        password: '',
        message: ''
    }
});
const submit = () => {
    form.post(route('login.post'), {
        onSuccess: () => {
            form.reset();
        }
    });
};

</script>
<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input v-model="form.email" type="email" id="email" name="email" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">

                    <div class="mt-1 text-sm text-red-500">
                        {{ form.errors.email ? form.errors.email : '' }}
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input v-model="form.password" type="password" id="password" name="password" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">

                    <div class="mt-1 text-sm text-red-500">
                        {{ form.errors.password ? form.errors.password : '' }}
                    </div>
                </div>
                <div class="flex items-center mb-4">
                    <input v-model="form.remember" type="checkbox" id="remember" name="remember"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
                </div>
                <button type="submit"
                    class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Login
                </button>
                <div class="mt-4 text-sm text-center">
                    <a :href="route('register')" class="text-blue-600 hover:text-blue-500">Don't have an account?
                        Register</a>
                </div>
                <div class="mt-2 text-sm text-center">
                    <a :href="route('forgot-password')" class="text-blue-600 hover:text-blue-500">Forgot your
                        password?</a>
                </div>
            </form>
            <div v-if="form.errors.message" class="mt-4 text-red-600">
                {{ form.errors.message }}
            </div>

        </div>
    </div>
</template>