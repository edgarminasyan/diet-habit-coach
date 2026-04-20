<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

defineProps({ title: String })

const page = usePage()
const user = computed(() => page.props.auth.user)
const unreadInsights = computed(() => page.props.unread_insights ?? 0)

const nav = [
    { name: 'Home',     routeName: 'dashboard',      icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
    { name: 'Meals',    routeName: 'meals.index',    icon: 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z' },
    { name: 'Habits',   routeName: 'habits.index',   icon: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' },
    { name: 'Progress', routeName: 'progress',       icon: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z' },
    { name: 'Insights', routeName: 'insights.index', icon: 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z', badge: true },
]
</script>

<template>
    <div class="min-h-screen bg-[#F6F4EF] pb-20 lg:pb-0">
        <!-- Desktop nav -->
        <nav class="hidden lg:block bg-white border-b border-[#EDE9E0] sticky top-0 z-40">
            <div class="max-w-5xl mx-auto px-6 flex items-center justify-between h-14">
                <Link :href="route('dashboard')" class="text-sm font-semibold text-[#1A1A1A] tracking-tight">Diet &amp; Habit Coach</Link>
                <div class="flex items-center gap-1">
                    <Link v-for="item in nav" :key="item.routeName" :href="route(item.routeName)"
                        class="relative px-3 py-1.5 text-sm rounded-lg transition-colors"
                        :class="route().current(item.routeName) ? 'bg-[#EEF4F0] text-[#4A7259] font-medium' : 'text-[#888] hover:text-[#1A1A1A]'">
                        {{ item.name }}
                        <span v-if="item.badge && unreadInsights > 0"
                            class="absolute -top-1 -right-1 w-4 h-4 bg-[#E8956D] rounded-full text-white text-[9px] flex items-center justify-center font-bold">
                            {{ unreadInsights }}
                        </span>
                    </Link>
                </div>
                <Link :href="route('profile.edit')" class="text-sm text-[#888] hover:text-[#1A1A1A] transition-colors">{{ user.name }}</Link>
            </div>
        </nav>

        <!-- Content -->
        <main class="max-w-5xl mx-auto px-4 sm:px-6 py-6 lg:py-8"><slot /></main>

        <!-- Mobile bottom nav -->
        <nav class="lg:hidden fixed bottom-0 inset-x-0 bg-white border-t border-[#EDE9E0] z-40">
            <div class="flex">
                <Link v-for="item in nav" :key="item.routeName" :href="route(item.routeName)"
                    class="relative flex-1 flex flex-col items-center justify-center py-2.5 gap-0.5 transition-colors"
                    :class="route().current(item.routeName) ? 'text-[#4A7259]' : 'text-[#BBB]'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" :d="item.icon" />
                    </svg>
                    <span class="text-[10px] font-medium">{{ item.name }}</span>
                    <span v-if="item.badge && unreadInsights > 0"
                        class="absolute top-1.5 right-1/4 w-3.5 h-3.5 bg-[#E8956D] rounded-full text-white text-[8px] flex items-center justify-center font-bold">
                        {{ unreadInsights }}
                    </span>
                </Link>
            </div>
        </nav>
    </div>
</template>
