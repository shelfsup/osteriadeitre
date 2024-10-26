<?php

namespace App\Livewire;

use App\Models\SocialNetwork;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;

class GestisciSocialNetwork extends Component
{
    protected $listeners = ['refreshMenu' => '$refresh'];

    public function addSocial()
    {
        $this->dispatch('open-modal', ['type' => 'aggiungi_social']);
    }

    public function editSocial($socialId)
    {
        $this->dispatch('open-modal', ['type' => 'modifica_social', 'social_id' => $socialId]);
    }

    public function toggleEnable($socialId)
    {
        $social = SocialNetwork::find($socialId);
        if ($social) {
            $social->enable = !$social->enable;
            $social->save();
            $this->dispatch('refreshMenu');
        }
    }

    public function deleteSocial($socialId)
    {
        $social = SocialNetwork::find($socialId);
        if ($social) {
            $social->delete();
            $this->dispatch('refreshMenu');
        }
    }

    #[On('refresh-social')]
    public function render()
    {
        $socialNetworks = SocialNetwork::all();
        return view('livewire.gestisci-social-network', compact('socialNetworks'));
    }
}
