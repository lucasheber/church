<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6 text-center">Register</h1>
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input v-model="form.name" type="text" id="name" name="name" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <div class="mt-1 text-sm text-red-500">
                        {{ form.errors.name ? form.errors.name : '' }}
                    </div>
                </div>
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
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                        Password</label>
                    <input v-model="form.password_confirmation" type="password" id="password_confirmation"
                        name="password_confirmation" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <div class="mt-1 text-sm text-red-500">
                        {{ form.errors.password_confirmation ? form.errors.password_confirmation : '' }}
                    </div>
                </div>
                <button type="submit"
                    class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Register
                </button>
                <div class="mt-4 text-sm text-center">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-500">Already have an account?
                        Login</a>
                </div>
            </form>
        </div>
    </div>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3';
const props = defineProps({});
const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    errors: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
    }
});
const submit = () => {
    form.post(route('register.post'), {
        onSuccess: () => {
            form.reset();
        }
    });
};
</script>