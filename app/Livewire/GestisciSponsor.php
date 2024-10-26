<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;
use App\Models\Sponsor;

class GestisciSponsor extends Component
{
    protected $listeners = ['refreshSponsor' => '$refresh'];

    public function addSponsor()
    {
        $this->dispatch('open-modal-sponsor', ['type' => 'aggiungi_sponsor']);
    }

    public function editSponsor($sponsorId)
    {
        $this->dispatch('open-modal-sponsor', ['type' => 'modifica_sponsor', 'sponsor_id' => $sponsorId]);
    }

    public function toggleEnable($sponsorId)
    {
        $sponsor = Sponsor::find($sponsorId);
        if ($sponsor) {
            $sponsor->enable = !$sponsor->enable;
            $sponsor->save();
            $this->dispatch('refreshSponsor');
        }
    }

    public function deleteSocial($sponsorId)
    {
        $sponsor = Sponsor::find($sponsorId);
        if ($sponsor) {
            $sponsor->delete();
            $this->dispatch('refreshSponsor');
        }
    }

    #[On('refresh-sponsor')]
    public function render()
    {
        $sponsors = Sponsor::all();
        return view('livewire.gestisci-sponsor', compact('sponsors'));
    }
}
