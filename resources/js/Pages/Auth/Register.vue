<script setup>
import { useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'

const form = useForm({ name: '', email: '', password: '', password_confirmation: '' })
const submit = () => form.post(route('register'))
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-[#F6F4EF]">
        <div class="w-full max-w-sm">
            <div class="text-center mb-8">
                <div class="w-12 h-12 bg-[#4A7259] rounded-2xl mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <h1 class="text-xl font-semibold text-[#1A1A1A]">Create your account</h1>
                <p class="text-sm text-[#888] mt-1">Start your health journey</p>
            </div>
            <div class="bg-white rounded-2xl border border-[#EDE9E0] p-7 shadow-sm">
                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-[#555] mb-1.5">Name</label>
                        <input v-model="form.name" type="text" required autofocus autocomplete="name"
                            class="w-full px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] focus:border-transparent transition" />
                        <InputError :message="form.errors.name" class="mt-1.5" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#555] mb-1.5">Email</label>
                        <input v-model="form.email" type="email" required autocomplete="username"
                            class="w-full px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] focus:border-transparent transition" />
                        <InputError :message="form.errors.email" class="mt-1.5" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#555] mb-1.5">Password</label>
                        <input v-model="form.password" type="password" required autocomplete="new-password"
                            class="w-full px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] focus:border-transparent transition" />
                        <InputError :message="form.errors.password" class="mt-1.5" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#555] mb-1.5">Confirm password</label>
                        <input v-model="form.password_confirmation" type="password" required autocomplete="new-password"
                            class="w-full px-3.5 py-2.5 border border-[#E0DDD6] rounded-xl text-sm bg-[#FDFCF9] focus:outline-none focus:ring-2 focus:ring-[#4A7259] focus:border-transparent transition" />
                    </div>
                    <button type="submit" :disabled="form.processing"
                        class="w-full py-2.5 bg-[#4A7259] text-white text-sm font-medium rounded-xl hover:bg-[#3A5A46] disabled:opacity-50 transition-colors mt-1">
                        Create account
                    </button>
                </form>
                <p class="text-center text-xs text-[#AAA] mt-5">
                    Already have an account? <a :href="route('login')" class="text-[#4A7259] hover:underline">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</template>
