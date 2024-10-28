<style>
    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-container {
        background: white;
        padding: 20px;
        border-radius: 10px;
        width: 300px;
    }

    .contact {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .contact img {
        border-radius: 50%;
        width: 50px;
        height: 50px;
        margin-right: 10px;
    }

    .whatsapp-icon {
        background: url('/path/to/whatsapp_icon.png') no-repeat;
        width: 24px;
        height: 24px;
    }

    .whatsapp-button {
        position: fixed;
        bottom: 20px;
        /* Distancia desde la parte inferior */
        right: 20px;
        /* Distancia desde la parte derecha */
        background-color: #25D366;
        /* Color verde de WhatsApp */
        color: white;
        border-radius: 50%;
        width: 60px;
        /* Tamaño del botón */
        height: 60px;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
        /* Sombra */
        z-index: 1000;
        /* Para asegurarse de que esté por encima de otros elementos */
        transition: transform 0.3s ease;
    }

    .whatsapp-button:hover {
        transform: scale(1.1);
        /* Efecto al pasar el mouse */
    }

    .whatsapp-button i {
        font-size: 30px;
        /* Tamaño del ícono */
        color: white;
    }
</style>

<!-- Botón de WhatsApp -->
<button class="whatsapp-button" wire:click="openModalWhatsApp">
    <i class="material-icons notranslate">add</i>
</button>

<!-- Modal -->
@if($isOpen)
    <div class="modal-backdrop">
        <div class="modal-container">
            <div class="modal-header">
                <h2>Iniciar conversación</h2>
                <button wire:click="closeModalWhatsApp" class="close-button">X</button>
            </div>
            <div class="modal-body">
                <!-- Contactos de WhatsApp -->
                <div class="contact">
                    <img src="{{ asset('assets/img/team-1.jpg') }}" alt="Karen Rodríguez">
                    <div>
                        <h4>Ventas 1</h4>
                        <p>Karen Rodríguez</p>
                        <a href="https://wa.me/1234567890" target="_blank">
                            <i class="whatsapp-icon"></i>
                        </a>
                    </div>
                </div>
                <div class="contact">
                    <img src="{{ asset('assets/img/team-2.jpg') }}" alt="Camila Yepez">
                    <div>
                        <h4>Ventas 2</h4>
                        <p>Camila Yepez</p>
                        <a href="https://wa.me/0987654321" target="_blank">
                            <i class="whatsapp-icon"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
