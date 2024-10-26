<?php

namespace App\Livewire;

use App\Models\PiattiSottoSottocategoria;
use App\Models\PiattoMenu;
use App\Models\PiattoSottocategoria;
use Livewire\Component;
use Livewire\Attributes\On;

class InfoBoxPiatti extends Component
{

    public $showPiatto = false;
    public $showNome;
    public $showDescrizione;
    public $showPhoto;
    public $showPrezzo;
    public $showSurgelato = false;
    public $showAllergeni = [];

    #[On('showPiatto')]
    public function showPiatto($piattoId, $lang, $prezzo_asporto=false)
    {
        $piatto = PiattoMenu::where('id', $piattoId)->first();
        $this->showPiatto = true;
        $this->showNome = $piatto->nome($lang);
        $this->showDescrizione = $piatto->descrizione($lang);
        $this->showPhoto = $piatto->photo;
        $this->showPrezzo = $prezzo_asporto ? $piatto->prezzo_asporto : $piatto->prezzo;
        $this->showSurgelato = $piatto->surgelato;
        $this->showAllergeni = json_decode($piatto->allergeni);
        $this->dispatch('openInfoPiatto');
    }

    #[On('showPiattoSottocategoria')]
    public function showPiattoSottocategoria($piattoId, $lang, $prezzo_asporto=false)
    {
        $piatto = PiattoSottocategoria::where('id', $piattoId)->first();

        $this->showPiatto = true;
        $this->showNome = $piatto->nome($lang);
        $this->showDescrizione = $piatto->descrizione($lang);
        $this->showPhoto = $piatto->photo;
        $this->showPrezzo = $prezzo_asporto ? $piatto->prezzo_asporto : $piatto->prezzo;
        $this->showSurgelato = $piatto->surgelato;
        $this->showAllergeni = json_decode($piatto->allergeni);

        $this->dispatch('openInfoPiatto');
    }

    #[On('showPiattoSottoSottocategoria')]
    public function showPiattoSottoSottocategoria($piattoId, $lang, $prezzo_asporto=false)
    {
        $piatto = PiattiSottoSottocategoria::where('id', $piattoId)->first();

        $this->showPiatto = true;
        $this->showNome = $piatto->nome($lang);
        $this->showDescrizione = $piatto->descrizione($lang);
        $this->showPhoto = $piatto->photo;
        $this->showPrezzo = $prezzo_asporto ? $piatto->prezzo_asporto : $piatto->prezzo;
        $this->showSurgelato = $piatto->surgelato;
        $this->showAllergeni = json_decode($piatto->allergeni);

        $this->dispatch('openInfoPiatto');
    }



    #[On('resetPiatto')]
    public function resetPiatto()
    {
        $this->showPiatto = false;
        $this->showNome = null;
        $this->showDescrizione = null;
        $this->showPhoto = null;
        $this->showPrezzo = null;
        $this->showSurgelato = false;
        $this->showAllergeni = null;
    }

    public function render()
    {
        return view('livewire.info-box-piatti');
    }
}
