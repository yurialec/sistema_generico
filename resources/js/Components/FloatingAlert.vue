<template>
    <transition name="fade">
        <div v-if="visible" :class="[
            'alert',
            alertClass,
            'alert-dismissible',
            'position-fixed',
            'end-0',
            'mt-3',
            'me-3',
            'shadow',
            'fade',
            showClass
        ]" style="z-index: 1080; top: 60px;" role="alert">
            <div v-html="message"></div>
            <button type="button" class="btn-close" aria-label="Close" @click="visible = false"></button>
        </div>
    </transition>
</template>

<script>
export default {
    name: 'FloatingAlert',
    data() {
        return {
            visible: false,
            message: '',
            type: 'success', // 'success' | 'danger'
        };
    },
    computed: {
        alertClass() {
            return {
                'alert-success': this.type === 'success',
                'alert-danger': this.type === 'danger',
            };
        },
        showClass() {
            return this.visible ? 'show' : '';
        },
    },
    methods: {
        show(message, type = 'success') {
            if (message && message.isAxiosError && message.response) {
                const err = message.response.data;
                if (err && err.errors) {
                    this.message = Object.values(err.errors).flat().join('<br>');
                } else if (err && err.message) {
                    this.message = err.message;
                } else {
                    this.message = 'Erro de comunicação com o servidor.';
                }
            }
            else if (Array.isArray(message)) {
                this.message = message.join('<br>');
            }
            else if (typeof message === 'object' && message !== null) {
                this.message = Object.values(message).flat().join('<br>');
            }
            else {
                this.message = message;
            }

            this.type = type;
            this.visible = true;

            setTimeout(() => (this.visible = false), 4000);
        },
    },
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
