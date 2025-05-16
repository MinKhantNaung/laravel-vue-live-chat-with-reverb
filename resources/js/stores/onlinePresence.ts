import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useOnlinePresenceStore = defineStore('onlinePresence', () => {
    const onlineUserIds = ref(new Set<number>());
    const joined = ref(false);

    const joinPresence = () => {
        if (joined.value) return;
        joined.value = true;

        window.Echo.join('online-users')
            .here((users: { id: number }[]) => {
                onlineUserIds.value = new Set(users.map(u => u.id));
            })
            .joining((user: { id: number }) => {
                onlineUserIds.value.add(user.id);
            })
            .leaving((user: { id: number }) => {
                onlineUserIds.value.delete(user.id);
            });
    };

    const leavePresence = () => {
        if (joined.value) {
            joined.value = false;
            window.Echo.leave('online-users');
        }
    };

    return {
        onlineUserIds,
        joinPresence,
        leavePresence,
    };
});
