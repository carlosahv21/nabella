<?php

namespace App\Http\Livewire;

use Livewire\Component;

class WhatsAppContactModal extends Component
{
    public $isOpen = false;

    public function openModalWhatsApp()
    {
        logger('Botón presionado');
        $this->isOpen = true;
    }

    public function closeModalWhatsApp()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.whatsapp.contact-modal');
    }
}

