<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm, usePage, Link } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'

const user = usePage().props.auth.user

const profileForm = useForm({
    name: user.name,
    email: user.email,
    timezone: user.timezone ?? 'UTC',
    daily_calorie_goal: user.daily_calorie_goal ?? '',
    daily_protein_goal: user.daily_protein_goal ?? '',
    daily_carbs_goal: user.daily_carbs_goal ?? '',
    daily_fat_goal: user.daily_fat_goal ?? '',
})

const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

const updateProfile  = () => profileForm.patch(route('profile.update'))
const updatePassword = () => passwordForm.put(route('password.update'), { onSuccess: () => passwordForm.reset() })

const timezones = Intl.supportedValuesOf('timeZone')
</script>

<template>
    <AppLayout title="Profile">
        <div class="max-w-xl space-y-5">
            <div>
                <h1 class="text-xl font-semibold text-[#1A1A1A]">Profile</h1>
                <p class="text-sm text-[#888] mt-0.5">Manage your account and goals</p>
            </div>

            <!-- Account info -->
            <div class="bg-white rounded-2xl border border-[#EDE9E0] p-5">
                <h3 class="text-sm font-semibold text-[#1A1A1A] mb-4">Account</h3>
                <form @submit.prevent="updateProfile" class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-[#555] mb-1.5">Name</label>
                        <input v-model="profileForm.name" type="text" required
                            class="w-full px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] transition" />
                        <InputError :message="profileForm.errors.name" class="mt-1" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#555] mb-1.5">Email</label>
                        <input v-model="profileForm.email" type="email" required
                            class="w-full px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] transition" />
                        <InputError :message="profileForm.errors.email" class="mt-1" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#555] mb-1.5">Timezone</label>
                        <select v-model="profileForm.timezone"
                            class="w-full px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] transition">
                            <option v-for="tz in timezones" :key="tz" :value="tz">{{ tz }}</option>
                        </select>
                    </div>

                    <hr class="border-[#F0EDE6]" />

                    <p class="text-xs font-semibold text-[#888] uppercase tracking-wide">Daily Goals</p>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-[#555] mb-1.5">Calories (kcal)</label>
                            <input v-model="profileForm.daily_calorie_goal" type="number" min="0" placeholder="e.g. 2000"
                                class="w-full px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] transition" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#555] mb-1.5">Protein (g)</label>
                            <input v-model="profileForm.daily_protein_goal" type="number" min="0" placeholder="e.g. 120"
                                class="w-full px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] transition" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#555] mb-1.5">Carbs (g)</label>
                            <input v-model="profileForm.daily_carbs_goal" type="number" min="0" placeholder="e.g. 250"
                                class="w-full px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] transition" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#555] mb-1.5">Fat (g)</label>
                            <input v-model="profileForm.daily_fat_goal" type="number" min="0" placeholder="e.g. 65"
                                class="w-full px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] transition" />
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pt-1">
                        <button type="submit" :disabled="profileForm.processing"
                            class="px-4 py-2.5 bg-[#4A7259] text-white text-sm font-medium rounded-xl hover:bg-[#3A5A46] disabled:opacity-50 transition-colors">Save changes</button>
                        <span v-if="profileForm.recentlySuccessful" class="text-xs text-[#4A7259]">Saved.</span>
                    </div>
                </form>
            </div>

            <!-- Change password -->
            <div class="bg-white rounded-2xl border border-[#EDE9E0] p-5">
                <h3 class="text-sm font-semibold text-[#1A1A1A] mb-4">Change Password</h3>
                <form @submit.prevent="updatePassword" class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-[#555] mb-1.5">Current password</label>
                        <input v-model="passwordForm.current_password" type="password" autocomplete="current-password"
                            class="w-full px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] transition" />
                        <InputError :message="passwordForm.errors.current_password" class="mt-1" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#555] mb-1.5">New password</label>
                        <input v-model="passwordForm.password" type="password" autocomplete="new-password"
                            class="w-full px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] transition" />
                        <InputError :message="passwordForm.errors.password" class="mt-1" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#555] mb-1.5">Confirm new password</label>
                        <input v-model="passwordForm.password_confirmation" type="password" autocomplete="new-password"
                            class="w-full px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] transition" />
                    </div>
                    <div class="flex items-center gap-3 pt-1">
                        <button type="submit" :disabled="passwordForm.processing"
                            class="px-4 py-2.5 bg-[#4A7259] text-white text-sm font-medium rounded-xl hover:bg-[#3A5A46] disabled:opacity-50 transition-colors">Update password</button>
                        <span v-if="passwordForm.recentlySuccessful" class="text-xs text-[#4A7259]">Updated.</span>
                    </div>
                </form>
            </div>

            <!-- Danger zone -->
            <div class="bg-white rounded-2xl border border-[#EDE9E0] p-5">
                <h3 class="text-sm font-semibold text-[#1A1A1A] mb-1">Sign out</h3>
                <p class="text-xs text-[#888] mb-4">You'll be redirected to the login page.</p>
                <Link :href="route('logout')" method="post" as="button"
                    class="px-4 py-2 text-sm text-[#888] border border-[#E0DDD6] rounded-xl hover:border-[#E8956D] hover:text-[#E8956D] transition-colors">
                    Sign out
                </Link>
            </div>
        </div>
    </AppLayout>
</template>
