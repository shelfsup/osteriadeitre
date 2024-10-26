<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PiattoDelGiorno;

class FuoriMenu extends Component
{
    public $piattiDelGiorno;
    public $selectedLanguage = 'it'; // default to Italian

    protected $listeners = ['refreshList' => '$refresh', 'switchLanguage' => 'switchLanguage'];

    public function deletePiatto($id)
    {
        PiattoDelGiorno::find($id)->delete();
        $this->dispatch('refreshList');
    }

    public function switchLanguage($language)
    {
        $this->selectedLanguage = $language;
    }

    public function enablePiatto($idPiatto)
    {
        $piatto = PiattoDelGiorno::findOrFail($idPiatto);

        $piatto->enable = !$piatto->enable;
        $piatto->save();
    }

    public function render()
    {
        $this->piattiDelGiorno = PiattoDelGiorno::all();
        return view('livewire.fuori-menu', ['piattiDelGiorno' => $this->piattiDelGiorno]);
    }
}
