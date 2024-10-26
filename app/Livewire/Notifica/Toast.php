<?php

namespace App\Livewire\Notifica;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;

class Toast extends Component
{
    #[On('notifica')]
    public function refreshComponent()
    {
        $this->render();
    }


    public function render()
    {
        return view('livewire.notifica.toast');
    }
}
