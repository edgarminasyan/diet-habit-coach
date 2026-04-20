<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm, router } from '@inertiajs/vue3'
import { ref } from 'vue'

defineProps({ habits: Array })

const showAdd = ref(false)
const form = useForm({ name: '', description: '', reminder_time: '' })
const submit = () => form.post(route('habits.store'), { onSuccess: () => { form.reset(); showAdd.value = false } })

const toggleHabit = (habit) => {
    if (habit.completed) {
        router.delete(route('habits.unlog', habit.id))
    } else {
        router.post(route('habits.log', habit.id))
    }
}

const deleteHabit = (id) => {
    if (confirm('Remove this habit?')) router.delete(route('habits.destroy', id))
}
</script>

<template>
    <AppLayout title="Habits">
        <div class="max-w-xl space-y-5">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-[#1A1A1A]">Habits</h1>
                <button @click="showAdd = !showAdd"
                    class="px-4 py-2 bg-[#4A7259] text-white text-sm font-medium rounded-xl hover:bg-[#3A5A46] transition-colors">
                    + Add habit
                </button>
            </div>

            <!-- Add form -->
            <div v-if="showAdd" class="bg-white rounded-2xl border border-[#EDE9E0] p-5">
                <form @submit.prevent="submit" class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-[#555] mb-1.5">Habit name</label>
                        <input v-model="form.name" type="text" required autofocus placeholder="e.g. Drink 2L of water"
                            class="w-full px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] transition" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#555] mb-1.5">Description <span class="text-[#CCC]">(optional)</span></label>
                        <input v-model="form.description" type="text" placeholder="Why this habit matters"
                            class="w-full px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] transition" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#555] mb-1.5">Daily reminder <span class="text-[#CCC]">(optional)</span></label>
                        <input v-model="form.reminder_time" type="time"
                            class="w-full px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] transition" />
                    </div>
                    <div class="flex gap-2 pt-1">
                        <button type="submit" :disabled="form.processing"
                            class="flex-1 py-2.5 bg-[#4A7259] text-white text-sm font-medium rounded-xl hover:bg-[#3A5A46] disabled:opacity-50 transition-colors">Save</button>
                        <button type="button" @click="showAdd = false"
                            class="px-4 py-2.5 text-[#888] text-sm rounded-xl hover:bg-[#F6F4EF] transition-colors">Cancel</button>
                    </div>
                </form>
            </div>

            <!-- Habit list -->
            <div v-if="!habits.length" class="bg-white rounded-2xl border border-[#EDE9E0] p-10 text-center">
                <p class="text-[#AAA] text-sm">No habits yet. Add one above!</p>
            </div>

            <div v-else class="bg-white rounded-2xl border border-[#EDE9E0] divide-y divide-[#F6F4EF]">
                <div v-for="habit in habits" :key="habit.id" class="flex items-center gap-3 p-4">
                    <button @click="toggleHabit(habit)"
                        class="w-6 h-6 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition-colors"
                        :class="habit.completed ? 'bg-[#4A7259] border-[#4A7259]' : 'border-[#D5D0C8] hover:border-[#4A7259]'">
                        <svg v-if="habit.completed" class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-[#1A1A1A]" :class="{ 'line-through text-[#AAA]': habit.completed }">{{ habit.name }}</p>
                        <p v-if="habit.description" class="text-xs text-[#AAA] mt-0.5 truncate">{{ habit.description }}</p>
                    </div>
                    <span v-if="habit.streak > 1" class="text-xs text-[#E8956D] font-medium flex-shrink-0">{{ habit.streak }}d 🔥</span>
                    <button @click="deleteHabit(habit.id)" class="text-[#DDD] hover:text-[#E8956D] transition-colors flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
