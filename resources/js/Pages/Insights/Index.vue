<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({ insights: Object })

const generating = ref(false)

const generate = () => {
    generating.value = true
    router.post(route('insights.generate'), {}, {
        onFinish: () => { generating.value = false }
    })
}

const markRead = (id) => router.patch(route('insights.read', id))
</script>

<template>
    <AppLayout title="Insights">
        <div class="max-w-xl space-y-5">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-[#1A1A1A]">Insights</h1>
                    <p class="text-sm text-[#888] mt-0.5">AI-powered coaching from your data</p>
                </div>
                <button @click="generate" :disabled="generating"
                    class="px-4 py-2 bg-[#4A7259] text-white text-sm font-medium rounded-xl hover:bg-[#3A5A46] disabled:opacity-50 transition-colors">
                    {{ generating ? 'Generating…' : '✦ Generate' }}
                </button>
            </div>

            <div v-if="!insights.data.length" class="bg-white rounded-2xl border border-[#EDE9E0] p-10 text-center">
                <p class="text-[#AAA] text-sm">No insights yet.</p>
                <p class="text-xs text-[#CCC] mt-1">Log meals and habits for a few days, then generate your first insight.</p>
            </div>

            <div v-else class="space-y-3">
                <div v-for="insight in insights.data" :key="insight.id"
                    class="bg-white rounded-2xl border p-5 transition-colors"
                    :class="insight.read_at ? 'border-[#EDE9E0]' : 'border-[#E8956D] shadow-sm'">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 bg-[#FFF0E8] rounded-full flex items-center justify-center text-xs">✦</span>
                            <span class="text-xs font-medium text-[#888] capitalize">{{ insight.type.replace('_', ' ') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-[#CCC]">{{ new Date(insight.created_at).toLocaleDateString() }}</span>
                            <button v-if="!insight.read_at" @click="markRead(insight.id)"
                                class="text-xs text-[#4A7259] hover:underline">Mark read</button>
                        </div>
                    </div>
                    <p class="text-sm text-[#333] leading-relaxed whitespace-pre-wrap">{{ insight.content }}</p>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="insights.last_page > 1" class="flex justify-center gap-2">
                <Link v-if="insights.prev_page_url" :href="insights.prev_page_url" class="px-3 py-1.5 text-xs border border-[#EDE9E0] rounded-lg bg-white text-[#888]">← Prev</Link>
                <Link v-if="insights.next_page_url" :href="insights.next_page_url" class="px-3 py-1.5 text-xs border border-[#EDE9E0] rounded-lg bg-white text-[#888]">Next →</Link>
            </div>
        </div>
    </AppLayout>
</template>
