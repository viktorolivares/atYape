<script>
import { ref, onMounted, onUnmounted } from 'vue';

export default {

    props: ['user'],

    setup(props) {

        const timeoutId = ref(null);

        const logout = () => {
            axios.post('/logout')
                .then(response => {
                    if (response.data === 204) {
                        localStorage.clear();
                        setTimeout(() => {
                            window.location.href = "/logout";
                        }, 2000);
                    }
                })
                .catch(error => console.log(error));
        };

        const resetLocalStorageAfterInactivity = () => {
            if (timeoutId.value) {
                clearTimeout(timeoutId.value);
            }

            timeoutId.value = setTimeout(() => {
                logout();
            }, 30 * 60 * 1000);
        };

        const userActivity = () => {
            resetLocalStorageAfterInactivity();
        };

        onMounted(() => {
            window.addEventListener('mousemove', userActivity);
            window.addEventListener('keydown', userActivity);
            window.addEventListener('scroll', userActivity);
        });

        onUnmounted(() => {
            window.removeEventListener('mousemove', userActivity);
            window.removeEventListener('keydown', userActivity);
            window.removeEventListener('scroll', userActivity);
            clearTimeout(timeoutId.value);
        });

        resetLocalStorageAfterInactivity();

        return {};
    }
}
</script>
