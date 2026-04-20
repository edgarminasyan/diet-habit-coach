<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    title: String,
})
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-14">
                    <Link :href="route('dashboard')" class="text-sm font-semibold text-gray-900 tracking-tight">
                        Diet &amp; Habit Coach
                    </Link>
                    <div class="flex items-center gap-5">
                        <Link :href="route('profile.edit')" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">
                            Profile
                        </Link>
                        <Link :href="route('logout')" method="post" as="button" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">
                            Sign out
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <slot />
        </main>
    </div>
</template>
