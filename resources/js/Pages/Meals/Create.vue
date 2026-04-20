<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import InputError from '@/Components/InputError.vue'
import axios from 'axios'

const form = useForm({
    name: '',
    meal_type: 'lunch',
    logged_at: new Date().toISOString().slice(0, 16),
    items: [],
})

const searchQuery  = ref('')
const searchResults = ref([])
const searching    = ref(false)
const aiInput      = ref('')

const addAiItem = () => {
    if (!aiInput.value.trim()) return
    form.items.push({ method: 'ai', description: aiInput.value.trim() })
    aiInput.value = ''
}

const searchFood = async () => {
    if (searchQuery.value.length < 2) return
    searching.value = true
    const { data } = await axios.get(route('foods.search'), { params: { q: searchQuery.value } })
    searchResults.value = data
    searching.value = false
}

const selectFood = (food) => {
    form.items.push({ method: 'search', food_item_id: food.id, food_name: food.name, quantity_grams: 100 })
    searchResults.value = []
    searchQuery.value = ''
}

const removeItem = (i) => form.items.splice(i, 1)

const submit = () => form.post(route('meals.store'))
</script>

<template>
    <AppLayout title="Log Meal">
        <div class="max-w-xl space-y-5">
            <h1 class="text-xl font-semibold text-[#1A1A1A]">Log a meal</h1>

            <form @submit.prevent="submit" class="space-y-4">
                <!-- Meal info -->
                <div class="bg-white rounded-2xl border border-[#EDE9E0] p-5 space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-[#555] mb-1.5">Meal name</label>
                        <input v-model="form.name" type="text" required placeholder="e.g. Lunch at home"
                            class="w-full px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] transition" />
                        <InputError :message="form.errors.name" class="mt-1" />
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-[#555] mb-1.5">Type</label>
                            <select v-model="form.meal_type"
                                class="w-full px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] transition">
                                <option value="breakfast">Breakfast</option>
                                <option value="lunch">Lunch</option>
                                <option value="dinner">Dinner</option>
                                <option value="snack">Snack</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#555] mb-1.5">When</label>
                            <input v-model="form.logged_at" type="datetime-local"
                                class="w-full px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] transition" />
                        </div>
                    </div>
                </div>

                <!-- AI estimate -->
                <div class="bg-white rounded-2xl border border-[#EDE9E0] p-5">
                    <p class="text-sm font-semibold text-[#1A1A1A] mb-1">Describe a food item</p>
                    <p class="text-xs text-[#888] mb-3">AI will estimate the calories automatically</p>
                    <div class="flex gap-2">
                        <input v-model="aiInput" type="text" placeholder="e.g. 2 scrambled eggs with butter"
                            @keydown.enter.prevent="addAiItem"
                            class="flex-1 px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] transition" />
                        <button type="button" @click="addAiItem"
                            class="px-4 py-2.5 bg-[#F6F4EF] text-[#4A7259] text-sm font-medium rounded-xl hover:bg-[#EEF4F0] transition">
                            Add
                        </button>
                    </div>
                </div>

                <!-- Food search -->
                <div class="bg-white rounded-2xl border border-[#EDE9E0] p-5">
                    <p class="text-sm font-semibold text-[#1A1A1A] mb-1">Search food database</p>
                    <p class="text-xs text-[#888] mb-3">2M+ products from Open Food Facts</p>
                    <div class="flex gap-2">
                        <input v-model="searchQuery" type="text" placeholder="Search foods…"
                            @keydown.enter.prevent="searchFood"
                            class="flex-1 px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] transition" />
                        <button type="button" @click="searchFood" :disabled="searching"
                            class="px-4 py-2.5 bg-[#F6F4EF] text-[#4A7259] text-sm font-medium rounded-xl hover:bg-[#EEF4F0] disabled:opacity-50 transition">
                            {{ searching ? '…' : 'Search' }}
                        </button>
                    </div>
                    <div v-if="searchResults.length" class="mt-2 border border-[#EDE9E0] rounded-xl overflow-hidden">
                        <button v-for="food in searchResults" :key="food.off_id" type="button"
                            @click="selectFood(food)"
                            class="w-full flex items-center justify-between px-4 py-3 hover:bg-[#F6F4EF] transition-colors text-left border-b border-[#F0EDE6] last:border-0">
                            <div>
                                <p class="text-sm text-[#1A1A1A]">{{ food.name }}</p>
                                <p v-if="food.brand" class="text-xs text-[#AAA]">{{ food.brand }}</p>
                            </div>
                            <span class="text-xs text-[#888] ml-3 flex-shrink-0">{{ food.calories_per_100g }} kcal/100g</span>
                        </button>
                    </div>
                </div>

                <!-- Items list -->
                <div v-if="form.items.length" class="bg-white rounded-2xl border border-[#EDE9E0] p-5">
                    <p class="text-sm font-semibold text-[#1A1A1A] mb-3">Items ({{ form.items.length }})</p>
                    <div class="space-y-2">
                        <div v-for="(item, i) in form.items" :key="i"
                            class="flex items-center gap-3 bg-[#F6F4EF] rounded-xl px-3 py-2.5">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-[#1A1A1A] truncate">{{ item.description || item.food_name }}</p>
                                <span class="text-[10px] px-1.5 py-0.5 rounded-full font-medium"
                                    :class="item.method === 'ai' ? 'bg-[#FFF0E8] text-[#E8956D]' : 'bg-[#EEF4F0] text-[#4A7259]'">
                                    {{ item.method === 'ai' ? 'AI estimate' : 'From database' }}
                                </span>
                            </div>
                            <input v-if="item.method === 'search'" v-model="item.quantity_grams" type="number" min="1"
                                class="w-16 px-2 py-1 border border-[#E0DDD6] rounded-lg text-xs text-center bg-white focus:outline-none focus:ring-1 focus:ring-[#4A7259]" />
                            <button type="button" @click="removeItem(i)" class="text-[#CCC] hover:text-[#E8956D] transition-colors flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <InputError :message="form.errors.items" />

                <button type="submit" :disabled="form.processing || !form.items.length"
                    class="w-full py-3 bg-[#4A7259] text-white text-sm font-medium rounded-xl hover:bg-[#3A5A46] disabled:opacity-50 transition-colors">
                    {{ form.processing ? 'Saving…' : 'Save meal' }}
                </button>
            </form>
        </div>
    </AppLayout>
</template>
