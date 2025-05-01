<script setup lang="ts">
import InputError from "@/components/InputError.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
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

const form = useForm({
    newMessage: null,
});

function sendMessage() {
    form.post(route("chat.send", props.friend), {
        onSuccess: () => {
            form.reset();
        },
    });
}
</script>

<template>
    <div>
        <div class="flex h-80 flex-col justify-end">
            <div class="max-h-fit overflow-y-auto p-4">
                <div v-for="message in chatMessages" :key="message.id as number" class="mb-2 flex items-center">
                    <div v-if="message.sender_id === currentUser.id"
                        class="ml-auto rounded-lg bg-blue-500 p-2 text-white">
                        {{ message.message }}
                    </div>
                    <div v-else class="mr-auto rounded-lg bg-gray-200 p-2">
                        {{ message.message }}
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center p-4">
            <form @submit.prevent="sendMessage" class="flex w-full">
                <div class="flex w-full flex-col">
                    <input v-model="form.newMessage" type="text" placeholder="Type a message..." :class="[
                        'rounded-lg border px-2 py-1',
                        { 'border-1 border-red-600': form.errors.newMessage },
                    ]" />
                    <InputError :message="form.errors.newMessage" />
                </div>
                <button :disabled="form.processing" type="submit"
                    class="ml-2 rounded-lg bg-blue-500 px-4 py-1 text-white">
                    Send
                </button>
            </form>
        </div>
    </div>
</template>
