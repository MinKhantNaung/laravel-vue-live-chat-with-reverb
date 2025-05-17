<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, onMounted, onUnmounted, ref, toRefs, watch } from 'vue';
import { useToast } from 'vue-toastification';

const toast = useToast();

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

const { friend, currentUser, chatMessages } = toRefs(props);

const messagesContainer = ref<HTMLDivElement | null>(null);
const isFriendTyping = ref(false);
const friendTypingTimer = ref<number | null>(null);

const form = useForm({
    newMessage: null,
});

const sendMessage = () => {
    form.post(route('chat.send', friend.value), {
        async: true,
        preserveState: true,
        onSuccess: () => {
            form.reset();
        },
    });
};

const scrollToBottom = () => {
    nextTick(() => {
        if (messagesContainer.value) {
            messagesContainer.value.scrollTo({
                top: messagesContainer.value.scrollHeight,
                behavior: 'smooth',
            });
        }
    });
};

const sendTypingEvent = () => {
    window.Echo.private(`chat.${friend.value.id}`).whisper('typing', {
        userId: currentUser.value.id,
    });
};

onMounted(() => {
    scrollToBottom();

    window.Echo.private(`chat.${currentUser.value.id}`)
        .listen('MessageSent', (response: any) => {
            const incomingMessage = response.chatMessage;

            if (friend.value && friend.value.id === incomingMessage.sender_id) {
                chatMessages.value.push(incomingMessage);
            } else {
                toast.info(`${incomingMessage.sender.name}: ${incomingMessage.message}`);
            }
        })
        .listenForWhisper('typing', (response: any) => {
            isFriendTyping.value = response.userId === friend.value.id;

            if (friendTypingTimer.value) {
                clearTimeout(friendTypingTimer.value);
            }

            friendTypingTimer.value = setTimeout(() => {
                isFriendTyping.value = false;
            }, 1000);
        });
});

onUnmounted(() => {
    window.Echo.private(`chat.${currentUser.value.id}`).stopListening('MessageSent');
});

watch(
    () => chatMessages.value,
    () => {
        scrollToBottom();
    },
    {
        immediate: true,
        deep: true,
    },
);
</script>

<template>
    <div>
        <div class="flex h-80 flex-col justify-end">
            <div ref="messagesContainer" class="max-h-fit overflow-y-auto p-4">
                <div v-for="message in chatMessages" :key="message.id" class="mb-2 flex items-center">
                    <div v-if="message.sender_id === currentUser.id" class="ml-auto rounded-lg bg-blue-500 p-2 wrap-anywhere text-white">
                        {{ message.message }}
                    </div>
                    <div v-else class="mr-auto rounded-lg bg-gray-200 p-2 wrap-anywhere text-gray-900 dark:bg-gray-700 dark:text-gray-100">
                        {{ message.message }}
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center p-4">
            <form @submit.prevent="sendMessage" class="flex w-full">
                <div class="flex w-full flex-col">
                    <input
                        v-model="form.newMessage"
                        @keydown="sendTypingEvent"
                        type="text"
                        placeholder="Type a message..."
                        :class="['rounded-lg border px-2 py-1', { 'border-1 border-red-600': form.errors.newMessage }]"
                    />
                    <InputError :message="form.errors.newMessage" />
                </div>
                <button :disabled="form.processing" type="submit" class="ml-2 rounded-lg bg-blue-500 px-4 py-1 text-white">Send</button>
            </form>
        </div>
        <small v-if="isFriendTyping" class="text-gray-700">{{ friend.name }} is typing...</small>
    </div>
</template>
