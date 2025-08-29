// confirm.js
import { Modal } from 'bootstrap';

export default {
    install(app) {
        // Injeta CSS uma única vez
        if (!document.getElementById('qf-confirm-style')) {
            const style = document.createElement('style');
            style.id = 'qf-confirm-style';
            style.textContent = `
        .qf-confirm-modal .modal-content {
          border: none;
          border-radius: 12px;
          box-shadow: 0 8px 24px rgba(0, 0, 0, .12);
        }
        .qf-confirm-body {
          padding: 24px;
          text-align: center;
          max-width: 300px;
          margin: 0 auto;
        }
        .qf-icon-warning {
          width: 64px;
          height: 64px;
          margin: 0 auto 12px;
          position: relative;
          border-radius: 50%;
          background: #fffbe6;
          border: 2px solid #f1c40f;
        }
        .qf-icon-warning::before {
          content: "";
          position: absolute;
          left: 50%;
          top: 12px;
          transform: translateX(-50%);
          width: 6px;
          height: 30px;
          background: #f1c40f;
          border-radius: 3px;
        }
        .qf-icon-warning::after {
          content: "";
          position: absolute;
          left: 50%;
          bottom: 10px;
          transform: translateX(-50%);
          width: 8px;
          height: 8px;
          background: #f1c40f;
          border-radius: 50%;
        }
        .qf-message { margin: 0 0 16px; color: #6c757d; line-height: 1.4; }
        .qf-actions { display: flex; justify-content: center; gap: 8px; }
        .qf-btn {
          font-size: .875rem; padding: .375rem .75rem; border-radius: 8px;
          border: 1px solid transparent; background: transparent; cursor: pointer;
          transition: background .15s ease, color .15s ease, border-color .15s ease;
        }
        .qf-btn-primary { color: #0d6efd; border-color: #0d6efd; }
        .qf-btn-primary:hover { background: #0d6efd; color: #fff; }
        .qf-btn-secondary { color: #6c757d; border-color: #6c757d; }
        .qf-btn-secondary:hover { background: #6c757d; color: #fff; }
      `;
            document.head.appendChild(style);
        }

        app.config.globalProperties.confirmYesNo = function (mensagem = 'Deseja continuar?') {
            return new Promise((resolve, reject) => {
                const id = `confirmModal-${Date.now()}-${Math.random().toString(36).slice(2)}`;
                const labelId = `${id}-label`;

                const wrapper = document.createElement('div');
                wrapper.innerHTML = `
          <div class="modal fade qf-confirm-modal" id="${id}" tabindex="-1" aria-labelledby="${labelId}" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
              <div class="modal-content">
                <div class="qf-confirm-body">
                  <div class="qf-icon-warning" aria-hidden="true"></div>
                  <p class="qf-message" id="${labelId}">${mensagem}</p>
                  <div class="qf-actions">
                    <button type="button" class="qf-btn qf-btn-secondary" data-bs-dismiss="modal" id="cancelarBtn">Cancelar</button>
                    <button type="button" class="qf-btn qf-btn-primary" id="confirmarBtn">Sim</button>
                  </div>
                </div>
              </div>
            </div>
          </div>`;
                const modalRoot = wrapper.firstElementChild;
                document.body.appendChild(modalRoot);

                const bsModal = new Modal(modalRoot);
                bsModal.show();

                let settled = false; // evita dupla resolução

                const confirmarBtn = modalRoot.querySelector('#confirmarBtn');
                const cancelarBtn = modalRoot.querySelector('#cancelarBtn');

                confirmarBtn.addEventListener('click', () => {
                    if (settled) return;
                    settled = true;
                    // resolve somente no "Sim"
                    resolve(true);
                    bsModal.hide();
                });

                cancelarBtn.addEventListener('click', () => {
                    if (settled) return;
                    settled = true;
                    // rejeita no "Cancelar"
                    reject(new Error('cancelled'));
                    // o data-bs-dismiss já vai fechar
                });

                // Fechamentos por ESC, clique no backdrop, X, etc => tratar como cancelado
                modalRoot.addEventListener('hidden.bs.modal', () => {
                    modalRoot.remove();
                    if (!settled) {
                        settled = true;
                        reject(new Error('dismissed'));
                    }
                }, { once: true });
            });
        };
    }
};
