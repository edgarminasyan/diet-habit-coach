<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'

defineProps({ meals: Object })

const mealTypeColor = { breakfast: '#F5E6C8', lunch: '#C8E6D4', dinner: '#C8D4E6', snack: '#E6C8D4' }
const mealTypeText  = { breakfast: '#8B6914', lunch: '#2D6A4F', dinner: '#1D3557', snack: '#6A2D4F' }

const deleteMeal = (id) => {
    if (confirm('Delete this meal?')) router.delete(route('meals.destroy', id))
}
</script>

<template>
    <AppLayout title="Meals">
        <div class="space-y-5">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-[#1A1A1A]">Meals</h1>
                <Link :href="route('meals.create')" class="px-4 py-2 bg-[#4A7259] text-white text-sm font-medium rounded-xl hover:bg-[#3A5A46] transition-colors">
                    + Log meal
                </Link>
            </div>

            <div v-if="!meals.data.length" class="bg-white rounded-2xl border border-[#EDE9E0] p-10 text-center">
                <p class="text-[#AAA] text-sm">No meals logged yet.</p>
            </div>

            <div v-else class="space-y-3">
                <div v-for="meal in meals.data" :key="meal.id"
                    class="bg-white rounded-2xl border border-[#EDE9E0] p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full capitalize"
                                :style="{ background: mealTypeColor[meal.meal_type], color: mealTypeText[meal.meal_type] }">
                                {{ meal.meal_type }}
                            </span>
                            <span class="text-sm font-medium text-[#1A1A1A]">{{ meal.name }}</span>
                        </div>
                        <button @click="deleteMeal(meal.id)" class="text-[#CCC] hover:text-[#E8956D] transition-colors ml-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex items-center gap-4 mt-3">
                        <div class="text-center">
                            <p class="text-base font-semibold text-[#1A1A1A]">{{ Math.round(meal.items.reduce((s, i) => s + i.calories, 0)) }}</p>
                            <p class="text-[10px] text-[#AAA]">kcal</p>
                        </div>
                        <div class="flex gap-3 text-xs text-[#888]">
                            <span>P {{ Math.round(meal.items.reduce((s, i) => s + i.protein, 0)) }}g</span>
                            <span>C {{ Math.round(meal.items.reduce((s, i) => s + i.carbs, 0)) }}g</span>
                            <span>F {{ Math.round(meal.items.reduce((s, i) => s + i.fat, 0)) }}g</span>
                        </div>
                        <span class="ml-auto text-xs text-[#AAA]">{{ new Date(meal.logged_at).toLocaleDateString() }}</span>
                    </div>

                    <div v-if="meal.items.length" class="mt-3 pt-3 border-t border-[#F6F4EF] space-y-1">
                        <div v-for="item in meal.items" :key="item.id" class="flex items-center justify-between text-xs text-[#888]">
                            <span>{{ item.description || item.food_item?.name || '—' }}
                                <span v-if="item.quantity_grams" class="text-[#BBB]"> · {{ item.quantity_grams }}g</span>
                            </span>
                            <span class="font-medium text-[#666]">{{ Math.round(item.calories) }} kcal</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="meals.last_page > 1" class="flex justify-center gap-2">
                <Link v-if="meals.prev_page_url" :href="meals.prev_page_url" class="px-3 py-1.5 text-xs border border-[#EDE9E0] rounded-lg bg-white text-[#888] hover:text-[#1A1A1A]">← Prev</Link>
                <Link v-if="meals.next_page_url" :href="meals.next_page_url" class="px-3 py-1.5 text-xs border border-[#EDE9E0] rounded-lg bg-white text-[#888] hover:text-[#1A1A1A]">Next →</Link>
            </div>
        </div>
    </AppLayout>
</template>
