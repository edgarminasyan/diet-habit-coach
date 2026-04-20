<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
    today: Object,
    calorie_goal: Number,
    habits: Array,
    unread_insights: Number,
})

const caloriePercent = computed(() =>
    props.calorie_goal ? Math.min(100, Math.round((props.today.calories / props.calorie_goal) * 100)) : null
)

const toggleHabit = (habit) => {
    if (habit.completed) {
        router.delete(route('habits.unlog', habit.id))
    } else {
        router.post(route('habits.log', habit.id))
    }
}
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="space-y-4">
            <!-- Header -->
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-[#1A1A1A]">Today</h1>
                    <p class="text-sm text-[#888] mt-0.5">{{ new Date().toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric' }) }}</p>
                </div>
                <Link :href="route('meals.create')"
                    class="px-4 py-2 bg-[#4A7259] text-white text-sm font-medium rounded-xl hover:bg-[#3A5A46] transition-colors">
                    + Log meal
                </Link>
            </div>

            <!-- Calories -->
            <div class="bg-white rounded-2xl border border-[#EDE9E0] p-5">
                <div class="flex items-center justify-between mb-1">
                    <p class="text-xs font-medium text-[#888] uppercase tracking-wide">Calories</p>
                    <p v-if="calorie_goal" class="text-xs text-[#AAA]">{{ today.calories }} / {{ calorie_goal }} kcal</p>
                </div>
                <p class="text-3xl font-semibold text-[#1A1A1A] mt-1">{{ today.calories }}<span class="text-base text-[#888] font-normal"> kcal</span></p>

                <div v-if="calorie_goal" class="mt-3 h-1.5 bg-[#F0EDE6] rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-700"
                        :class="caloriePercent > 100 ? 'bg-[#E8956D]' : 'bg-[#4A7259]'"
                        :style="{ width: caloriePercent + '%' }" />
                </div>

                <div class="grid grid-cols-3 gap-2 mt-4 pt-4 border-t border-[#F6F4EF]">
                    <div class="text-center">
                        <p class="text-[11px] text-[#AAA]">Protein</p>
                        <p class="text-sm font-semibold text-[#1A1A1A] mt-0.5">{{ today.protein }}g</p>
                    </div>
                    <div class="text-center">
                        <p class="text-[11px] text-[#AAA]">Carbs</p>
                        <p class="text-sm font-semibold text-[#1A1A1A] mt-0.5">{{ today.carbs }}g</p>
                    </div>
                    <div class="text-center">
                        <p class="text-[11px] text-[#AAA]">Fat</p>
                        <p class="text-sm font-semibold text-[#1A1A1A] mt-0.5">{{ today.fat }}g</p>
                    </div>
                </div>
            </div>

            <!-- Habits -->
            <div class="bg-white rounded-2xl border border-[#EDE9E0] p-5">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-[#1A1A1A]">Habits</p>
                    <Link :href="route('habits.index')" class="text-xs text-[#4A7259]">Manage</Link>
                </div>
                <div v-if="!habits.length" class="text-center py-4">
                    <p class="text-sm text-[#AAA]">No habits yet.</p>
                    <Link :href="route('habits.index')" class="text-sm text-[#4A7259] mt-1 inline-block">Add your first →</Link>
                </div>
                <div v-else class="space-y-1">
                    <button v-for="habit in habits.slice(0, 6)" :key="habit.id"
                        @click="toggleHabit(habit)"
                        class="w-full flex items-center justify-between py-2.5 px-1 rounded-xl hover:bg-[#F6F4EF] transition-colors text-left">
                        <div class="flex items-center gap-3">
                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition-colors"
                                :class="habit.completed ? 'bg-[#4A7259] border-[#4A7259]' : 'border-[#D5D0C8]'">
                                <svg v-if="habit.completed" class="w-2.5 h-2.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-sm" :class="habit.completed ? 'text-[#AAA] line-through' : 'text-[#1A1A1A]'">{{ habit.name }}</span>
                        </div>
                        <span v-if="habit.streak > 1" class="text-xs text-[#E8956D] font-medium">{{ habit.streak }}d 🔥</span>
                    </button>
                </div>
            </div>

            <!-- Insights nudge -->
            <Link v-if="unread_insights > 0" :href="route('insights.index')"
                class="flex items-center gap-3 bg-[#FFF8F3] border border-[#F5DFD0] rounded-2xl p-4 transition-opacity hover:opacity-80">
                <div class="w-9 h-9 bg-[#E8956D] rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-[#1A1A1A]">{{ unread_insights }} new insight{{ unread_insights > 1 ? 's' : '' }}</p>
                    <p class="text-xs text-[#888]">Your AI coach has something to share</p>
                </div>
                <svg class="w-4 h-4 text-[#CCC] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </Link>
        </div>
    </AppLayout>
</template>
