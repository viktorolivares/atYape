import { toast } from "vue3-toastify";
import 'vue3-toastify/dist/index.css';

export default {
  data() {
    return {
      toastOptions: {
        position: "top-center",
        theme: "colored",
        autoClose: 1000,
        type: toast.TYPE.DEFAULT,
      },
    };
  },

  methods: {

    showToast(message, options = {}) {
      toast(message, { ...this.toastOptions, ...options });
    },
  },
};
