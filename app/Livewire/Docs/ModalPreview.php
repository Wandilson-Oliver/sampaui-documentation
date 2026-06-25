<?php

namespace App\Livewire\Docs;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class ModalPreview extends Component
{
    public bool $open = false;

    public string $title = 'Confirmar ação';

    public function render(): View
    {
        return view('livewire.docs.modal-preview');
    }
}
