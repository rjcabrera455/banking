import { useToast } from 'primevue/usetoast';

export default function toast() {
    const toast = useToast();

    function success(message) {
        toast.add({ severity: 'success', summary: message || alternateMessage, life: 3000 });
    }

    function error(message, alternateMessage = 'Oops! Something went wrong while fetching the data. Please try again later.') {
        toast.add({ severity: 'error', summary: message || alternateMessage, life: 3000 });
    }

    return { success, error };
}
