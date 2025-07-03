export default {
    install(app) {
        const containerId = 'floating-alert-container';

        if (!document.getElementById(containerId)) {
            const el = document.createElement('div');
            el.id = containerId;
            el.style.position = 'fixed';
            el.style.top = '60px';
            el.style.right = '20px';
            el.style.zIndex = '1080';
            document.body.appendChild(el);
        }

        function showAlert(message, type = 'success') {
            const el = document.getElementById(containerId);
            if (!el) return;

            const alert = document.createElement('div');
            alert.classList.add(
                'alert',
                `alert-${type}`,
                'alert-dismissible',
                'fade',
                'show',
                'shadow',
                'mt-2'
            );
            alert.style.minWidth = '250px';
            alert.innerHTML = `
        <div>${formatMessage(message)}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      `;
            el.appendChild(alert);

            setTimeout(() => {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 500);
            }, 4000);
        }

        function formatMessage(message) {
            if (message?.isAxiosError && message.response) {
                const err = message.response.data;
                if (err?.errors) return Object.values(err.errors).flat().join('<br>');
                if (err?.message) return err.message;
                return 'Erro de comunicação com o servidor.';
            }
            if (Array.isArray(message)) return message.join('<br>');
            if (typeof message === 'object' && message !== null) return Object.values(message).flat().join('<br>');
            return message;
        }

        app.config.globalProperties.alertSuccess = (msg) => showAlert(msg, 'success');
        app.config.globalProperties.alertDanger = (msg) => showAlert(msg, 'danger');

        window.alertSuccess = (msg) => showAlert(msg, 'success');
        window.alertDanger = (msg) => showAlert(msg, 'danger');
    }
};
