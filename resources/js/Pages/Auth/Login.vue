<script setup>
import { useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'

const form = useForm({
    email: '',
    password: '',
    remember: false,
})

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    })
}
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50">
        <div class="w-full max-w-sm bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <div class="mb-8 text-center">
                <h1 class="text-xl font-semibold text-gray-900">Diet &amp; Habit Coach</h1>
                <p class="text-sm text-gray-400 mt-1">Sign in to your account</p>
            </div>

            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Email</label>
                    <input
                        v-model="form.email"
                        type="email"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="you@example.com"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                    />
                    <InputError :message="form.errors.email" class="mt-1" />
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Password</label>
                    <input
                        v-model="form.password"
                        type="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                    />
                    <InputError :message="form.errors.password" class="mt-1" />
                </div>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full py-2 px-4 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-700 disabled:opacity-50 transition-colors mt-2"
                >
                    Sign in
                </button>
            </form>
        </div>
    </div>
</template>
