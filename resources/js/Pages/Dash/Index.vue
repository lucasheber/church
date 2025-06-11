<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6 text-center">Dashboard</h1>
            <p class="text-center text-gray-600">Welcome to your dashboard!</p>
            <div class="mt-6 text-center">
                <a v-on:click="logout()" class="text-blue-600 hover:text-blue-500">Logout</a>
            </div>
        </div>
    </div>
    <div class="fixed bottom-0 right-0 p-4">
        <p class="text-sm text-gray-500">© {{ new Date().getFullYear() }} Your Company</p>
    </div>
    <div class="fixed bottom-0 left-0 p-4">
        <p class="text-sm text-gray-500">Version 1.0.0</p>
    </div>
    <div class="fixed top-0 right-0 p-4">
        <p class="text-sm text-gray-500">Current Time: {{ new Date().toLocaleTimeString() }}</p>
    </div>
</template>
<script setup>
import { router } from '@inertiajs/vue3';

const logout = () => {
    router.post(route('logout'), {}, {
        onSuccess: () => {
            window.location.href = route('login');
        }
    });
};
</script>