<script setup lang="ts">
import InputError from "@/components/InputError.vue";
import { useForm } from "@inertiajs/vue3";
import { nextTick, onMounted, ref, watch } from "vue";

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

const messagesContainer = ref<HTMLDivElement | null>(null);
const isFriendTyping = ref(false);
const friendTypingTimer = ref<number | null>(null);

const form = useForm({
  newMessage: null,
});

const sendMessage = () => {
  form.post(route("chat.send", props.friend), {
    preserveState: true,
    replace: true,
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
        behavior: "smooth",
      });
    }
  });
};

const sendTypingEvent = () => {
  window.Echo.private(`chat.${props.friend.id}`).whisper("typing", {
    userId: props.currentUser.id,
  });
};

onMounted(() => {
  scrollToBottom();

  window.Echo.private(`chat.${props.currentUser.id}`)
    .listen("MessageSent", (response: any) => {
      props.chatMessages.push(response.chatMessage);
    })
    .listenForWhisper("typing", (response: any) => {
      isFriendTyping.value = response.userId === props.friend.id;

      if (friendTypingTimer.value) {
        clearTimeout(friendTypingTimer.value);
      }

      friendTypingTimer.value = setTimeout(() => {
        isFriendTyping.value = false;
      }, 1000);
    });
});

watch(
  () => props.chatMessages,
  () => {
    scrollToBottom();
  },
  {
    immediate: true,
    deep: true,
  }
);
</script>

<template>
  <div>
    <div class="flex h-80 flex-col justify-end">
      <div ref="messagesContainer" class="max-h-fit overflow-y-auto p-4">
        <div
          v-for="message in chatMessages"
          :key="message.id"
          class="mb-2 flex items-center"
        >
          <div
            v-if="message.sender_id === currentUser.id"
            class="ml-auto rounded-lg bg-blue-500 p-2 text-white"
          >
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
          <input
            v-model="form.newMessage"
            @keydown="sendTypingEvent"
            type="text"
            placeholder="Type a message..."
            :class="[
              'rounded-lg border px-2 py-1',
              { 'border-1 border-red-600': form.errors.newMessage },
            ]"
          />
          <InputError :message="form.errors.newMessage" />
        </div>
        <button
          :disabled="form.processing"
          type="submit"
          class="ml-2 rounded-lg bg-blue-500 px-4 py-1 text-white"
        >
          Send
        </button>
      </form>
    </div>
    <small v-if="isFriendTyping" class="text-gray-700"
      >{{ friend.name }} is typing...</small
    >
  </div>
</template>
