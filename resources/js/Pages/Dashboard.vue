<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { usePage } from '@inertiajs/vue3'

const { auth } = usePage().props
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="space-y-8">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Welcome back, {{ auth.user.name }}</h2>
                <p class="text-sm text-gray-400 mt-0.5">Here's your overview for today</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl border border-gray-100 p-5">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Meals Today</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-2">—</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Habits Done</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-2">—</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Day Streak</p>
                    <p class="text-2xl font-semibold text-gray-900 mt-2">—</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
