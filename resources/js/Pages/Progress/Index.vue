<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { computed } from 'vue'

const props = defineProps({
    calories_by_day: Object,
    habit_completion: Array,
    calorie_goal: Number,
})

const last30Days = computed(() => {
    const days = []
    for (let i = 29; i >= 0; i--) {
        const d = new Date()
        d.setDate(d.getDate() - i)
        const key = d.toISOString().slice(0, 10)
        days.push({
            date: key,
            label: d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }),
            calories: props.calories_by_day[key]?.calories ?? 0,
            meals: props.calories_by_day[key]?.meals ?? 0,
        })
    }
    return days
})

const maxCal = computed(() => Math.max(...last30Days.value.map(d => d.calories), props.calorie_goal ?? 0, 1))

const avg = computed(() => {
    const days = last30Days.value.filter(d => d.calories > 0)
    return days.length ? Math.round(days.reduce((s, d) => s + d.calories, 0) / days.length) : 0
})
</script>

<template>
    <AppLayout title="Progress">
        <div class="space-y-5">
            <h1 class="text-xl font-semibold text-[#1A1A1A]">Progress</h1>

            <!-- Summary cards -->
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-white rounded-2xl border border-[#EDE9E0] p-4">
                    <p class="text-xs text-[#AAA] uppercase tracking-wide">Avg. calories</p>
                    <p class="text-2xl font-semibold text-[#1A1A1A] mt-1">{{ avg }}<span class="text-sm font-normal text-[#888]"> kcal</span></p>
                </div>
                <div class="bg-white rounded-2xl border border-[#EDE9E0] p-4">
                    <p class="text-xs text-[#AAA] uppercase tracking-wide">Days logged</p>
                    <p class="text-2xl font-semibold text-[#1A1A1A] mt-1">{{ last30Days.filter(d => d.calories > 0).length }}<span class="text-sm font-normal text-[#888]"> / 30</span></p>
                </div>
            </div>

            <!-- Calorie chart -->
            <div class="bg-white rounded-2xl border border-[#EDE9E0] p-5">
                <p class="text-sm font-semibold text-[#1A1A1A] mb-4">Calories — last 30 days</p>
                <div class="flex items-end gap-0.5 h-28">
                    <div v-for="day in last30Days" :key="day.date"
                        class="flex-1 flex flex-col items-center justify-end group relative">
                        <div class="w-full rounded-t-sm transition-all duration-300"
                            :class="day.calories > 0 ? 'bg-[#4A7259]' : 'bg-[#F0EDE6]'"
                            :style="{ height: day.calories > 0 ? Math.max(4, (day.calories / maxCal) * 112) + 'px' : '4px' }">
                        </div>
                        <!-- Goal line marker -->
                        <div v-if="calorie_goal && day.calories > calorie_goal"
                            class="absolute top-0 left-0 right-0 h-full flex items-end">
                            <div class="w-full h-px bg-[#E8956D] opacity-60" :style="{ marginBottom: (calorie_goal / maxCal) * 112 + 'px' }"></div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between mt-2 text-[10px] text-[#CCC]">
                    <span>{{ last30Days[0].label }}</span>
                    <span>{{ last30Days[last30Days.length - 1].label }}</span>
                </div>
            </div>

            <!-- Habit completion -->
            <div v-if="habit_completion.length" class="bg-white rounded-2xl border border-[#EDE9E0] p-5">
                <p class="text-sm font-semibold text-[#1A1A1A] mb-4">Habit completion — last 30 days</p>
                <div class="space-y-3">
                    <div v-for="habit in habit_completion" :key="habit.name">
                        <div class="flex items-center justify-between mb-1">
                            <p class="text-sm text-[#1A1A1A]">{{ habit.name }}</p>
                            <div class="flex items-center gap-2">
                                <span v-if="habit.streak > 1" class="text-xs text-[#E8956D]">{{ habit.streak }}d 🔥</span>
                                <span class="text-xs font-medium text-[#888]">{{ habit.completion_rate }}%</span>
                            </div>
                        </div>
                        <div class="h-1.5 bg-[#F0EDE6] rounded-full overflow-hidden">
                            <div class="h-full bg-[#4A7259] rounded-full transition-all duration-700"
                                :style="{ width: habit.completion_rate + '%' }" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
