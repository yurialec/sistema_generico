// resources/js/plugins/loadingOverlay.js
export default {
    install(app) {
        // --- CSS injetado uma única vez
        const styleId = 'qf-loading-styles';
        if (!document.getElementById(styleId)) {
            const css = `
        .qf-overlay {
          position: absolute;
          inset: 0;
          display: none;
          align-items: center;
          justify-content: center;
          background: rgba(227, 228, 230, 0.45);
        //   backdrop-filter: blur(1px);
          pointer-events: auto;
          border-radius: 10px;
        }
        .qf-overlay--show { display: flex; }
        .qf-overlay__box {
          display: flex;
          flex-direction: column;
          align-items: center;
          gap: .75rem;
          padding: 1rem 1.25rem;
        //   border-radius: .75rem;
        //   background: rgba(0,0,0,.35);
        }
        .qf-overlay__msg { color: #fff; font-size: .95rem; text-align: center; text-shadow: 0 1px 2px rgba(0,0,0,.3); }
        .qf-spinner {
          width: 48px; height: 48px; border: 4px solid #fff; border-top-color: transparent;
          border-radius: 50%; animation: qf-spin .8s linear infinite; box-shadow: 0 0 0 1px rgba(0,0,0,.06) inset;
        }
        @keyframes qf-spin { to { transform: rotate(360deg); } }

        /* fullscreen */
        #qf-overlay-fullscreen {
          position: fixed;
          inset: 0;
          z-index: 9999;
        }
        html.qf-no-scroll, body.qf-no-scroll { overflow: hidden !important; }
      `;
            const st = document.createElement('style');
            st.id = styleId;
            st.appendChild(document.createTextNode(css));
            document.head.appendChild(st);
        }

        // --- Overlay fullscreen singleton
        const fullId = 'qf-overlay-fullscreen';
        let fullEl = document.getElementById(fullId);
        if (!fullEl) {
            fullEl = document.createElement('div');
            fullEl.id = fullId;
            fullEl.className = 'qf-overlay';
            fullEl.innerHTML = `
        <div class="qf-overlay__box" role="alert" aria-busy="true" aria-live="polite">
          <div class="qf-spinner" aria-hidden="true"></div>
          <div class="qf-overlay__msg" id="qf-overlay-fullscreen-msg"></div>
        </div>
      `;
            document.body.appendChild(fullEl);
        }
        const fullMsgEl = () => document.getElementById('qf-overlay-fullscreen-msg');

        function toggleFullscreen(on, opts = {}) {
            const msg = typeof opts === 'string' ? opts : (opts?.message ?? '');
            if (msg && fullMsgEl()) fullMsgEl().textContent = msg;
            if (on) {
                fullEl.classList.add('qf-overlay--show');
                document.documentElement.classList.add('qf-no-scroll');
                document.body.classList.add('qf-no-scroll');
            } else {
                fullEl.classList.remove('qf-overlay--show');
                document.documentElement.classList.remove('qf-no-scroll');
                document.body.classList.remove('qf-no-scroll');
                if (fullMsgEl()) fullMsgEl().textContent = '';
            }
        }

        // API global, igual ao seu padrão
        function loadingUser(on, opts) { toggleFullscreen(!!on, opts); }

        app.config.globalProperties.loadingUser = loadingUser;
        window.loadingUser = loadingUser;

        // --- Diretiva v-loading para overlay escopado
        app.directive('loading', {
            mounted(el, binding) {
                // se container não tem posicionamento, tornamos relative (e lembramos pra desfazer)
                const computed = window.getComputedStyle(el);
                if (computed.position === 'static') {
                    el.dataset.qfWasStatic = '1';
                    el.style.position = 'relative';
                }

                // cria overlay interno
                const overlay = document.createElement('div');
                overlay.className = 'qf-overlay';
                overlay.innerHTML = `
          <div class="qf-overlay__box" role="alert" aria-busy="true" aria-live="polite">
            <div class="qf-spinner" aria-hidden="true"></div>
            <div class="qf-overlay__msg"></div>
          </div>
        `;
                overlay.style.zIndex = '10'; // acima do conteúdo do container

                el.appendChild(overlay);
                el.__qfOverlay = overlay; // ref interna

                // aplica estado inicial
                applyScoped(binding.value, overlay);
            },
            updated(el, binding) {
                if (!el.__qfOverlay) return;
                applyScoped(binding.value, el.__qfOverlay);
            },
            unmounted(el) {
                if (el.__qfOverlay) {
                    el.__qfOverlay.remove();
                    delete el.__qfOverlay;
                }
                if (el.dataset.qfWasStatic === '1') {
                    delete el.dataset.qfWasStatic;
                    el.style.position = ''; // restaura
                }
            }
        });

        // helper p/ diretiva
        function applyScoped(val, overlay) {
            // Aceita boolean ou objeto { show, message }
            let show = false, message = '';
            if (typeof val === 'boolean') show = val;
            else if (val && typeof val === 'object') {
                show = !!val.show;
                message = val.message ?? '';
            }
            const msgEl = overlay.querySelector('.qf-overlay__msg');
            if (msgEl) msgEl.textContent = message || '';
            overlay.classList.toggle('qf-overlay--show', show);
        }
    }
};
