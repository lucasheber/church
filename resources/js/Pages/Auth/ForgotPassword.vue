<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    errors: {
        email: '',
    }
});

const submit = () => {
    form.post(route('forgot-password.post'), {
        onSuccess: () => {
            form.reset();
        }
    });
};
</script>
<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6 text-center">Forgot Password</h1>
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input v-model="form.email" type="email" id="email" name="email" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <div class="mt-1 text-sm text-red-500">
                        {{ form.errors.email ? form.errors.email : '' }}
                    </div>
                </div>
                <button type="submit"
                    class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Send Password Reset Link
                </button>
                <div class="mt-4 text-sm text-center">
                    <a :href="route('login')" class="text-blue-600 hover:text-blue-500">Remembered your password? Login</a>
                </div>
            </form>
        </div>
    </div>
</template>