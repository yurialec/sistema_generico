// confirm.js
import { Modal } from 'bootstrap';

export default {
    install(app) {
        app.config.globalProperties.confirmYesNo = function (mensagem = 'Deseja continuar?') {
            return new Promise((resolve, reject) => {
                let modalEl = document.createElement('div');
                modalEl.innerHTML = `
                                    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-sm rounded-3 text-center p-4" style="max-width: 300px; margin: auto;">
                                        <div class="mb-3">
                                            <i class="bi bi-exclamation-circle-fill text-warning" style="font-size: 48px;"></i>
                                        </div>
                                        <p class="text-muted mb-4">${mensagem}</p>
                                        <div class="d-flex justify-content-center gap-2">
                                            <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="button" class="btn btn-danger btn-sm px-3" id="confirmarBtn">Sim</button>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    `;

                document.body.appendChild(modalEl);
                let modalInstance = new Modal(modalEl.querySelector('.modal'));
                modalInstance.show();

                modalEl.querySelector('#confirmarBtn').addEventListener('click', () => {
                    modalInstance.hide();
                    resolve();
                });

                modalEl.addEventListener('hidden.bs.modal', () => {
                    modalEl.remove();
                });
            });
        };
    }
};
