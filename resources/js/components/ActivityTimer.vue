<script>
import { ref, onMounted, onUnmounted } from 'vue';

export default {

    props: ['user'],

    setup(props) {
        const timeoutId = ref(null);

        const createActivityLog = (type, email) => {
            axios.post('/api/logs/save', { type: type, email: email })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.log(error);
                });
        };

        const logout = () => {

            const email = props.user.email;

            createActivityLog('disconnection: {"State": "Por inactividad"}', email);

            setTimeout(() => {
                axios.post('/logout')
                    .then(response => {
                        if (response.data.success === true) {
                            window.location.href = "/logout";
                            localStorage.clear();
                        }
                    })
                    .catch(error => console.log(error));
            }, 2000);
        };

        const resetLocalStorageAfterInactivity = () => {
            if (timeoutId.value) {
                clearTimeout(timeoutId.value);
            }

            timeoutId.value = setTimeout(() => {
                logout();
            }, 60 * 60 * 1000);
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
