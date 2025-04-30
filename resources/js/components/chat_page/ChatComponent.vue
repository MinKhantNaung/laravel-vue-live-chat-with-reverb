<script setup lang="ts">
defineProps({
    friend: {
        type: Object,
        required: true,
    },
    currentUser: {
        type: Object,
        required: true,
    },
    chatMessages: {
        type: Array as () => { id: number; sender_id: number; message: string }[],
        required: true,
    },
});
</script>

<template>
    <div>
        <div class="flex h-80 flex-col justify-end">
            <div class="max-h-fit overflow-y-auto p-4">
                <div v-for="message in chatMessages" :key="message.id as number" class="mb-2 flex items-center">
                    <div v-if="message.sender_id === currentUser.id" class="ml-auto rounded-lg bg-blue-500 p-2 text-white">
                        {{ message.message }}
                    </div>
                    <div v-else class="mr-auto rounded-lg bg-gray-200 p-2">
                        {{ message.message }}
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center p-4">
            <input type="text" placeholder="Type a message..." class="flex-1 rounded-lg border px-2 py-1" />
            <button class="ml-2 rounded-lg bg-blue-500 px-4 py-1 text-white">Send</button>
        </div>
    </div>
</template>
