<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm, usePage } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'

const user = usePage().props.auth.user

const profileForm = useForm({
    name: user.name,
    email: user.email,
})

const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

const updateProfile = () => profileForm.patch(route('profile.update'))

const updatePassword = () => passwordForm.put(route('password.update'), {
    onSuccess: () => passwordForm.reset(),
})
</script>

<template>
    <AppLayout title="Profile">
        <div class="max-w-xl space-y-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Profile</h2>
                <p class="text-sm text-gray-400 mt-0.5">Manage your account information</p>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-6">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Account Info</h3>
                <form @submit.prevent="updateProfile" class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Name</label>
                        <input
                            v-model="profileForm.name"
                            type="text"
                            required
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 transition"
                        />
                        <InputError :message="profileForm.errors.name" class="mt-1" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Email</label>
                        <input
                            v-model="profileForm.email"
                            type="email"
                            required
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 transition"
                        />
                        <InputError :message="profileForm.errors.email" class="mt-1" />
                    </div>
                    <div class="flex items-center gap-3 pt-1">
                        <button
                            type="submit"
                            :disabled="profileForm.processing"
                            class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-700 disabled:opacity-50 transition-colors"
                        >
                            Save changes
                        </button>
                        <span v-if="profileForm.recentlySuccessful" class="text-xs text-green-600">Saved.</span>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-6">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Change Password</h3>
                <form @submit.prevent="updatePassword" class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Current password</label>
                        <input
                            v-model="passwordForm.current_password"
                            type="password"
                            autocomplete="current-password"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 transition"
                        />
                        <InputError :message="passwordForm.errors.current_password" class="mt-1" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">New password</label>
                        <input
                            v-model="passwordForm.password"
                            type="password"
                            autocomplete="new-password"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 transition"
                        />
                        <InputError :message="passwordForm.errors.password" class="mt-1" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Confirm new password</label>
                        <input
                            v-model="passwordForm.password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 transition"
                        />
                        <InputError :message="passwordForm.errors.password_confirmation" class="mt-1" />
                    </div>
                    <div class="flex items-center gap-3 pt-1">
                        <button
                            type="submit"
                            :disabled="passwordForm.processing"
                            class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-700 disabled:opacity-50 transition-colors"
                        >
                            Update password
                        </button>
                        <span v-if="passwordForm.recentlySuccessful" class="text-xs text-green-600">Updated.</span>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
