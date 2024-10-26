<?php

namespace App\Livewire;

use App\Models\Allergeni;
use Livewire\Component;
use App\Models\PiattoDelGiorno;
use HTMLPurifier;
use HTMLPurifier_Config;

class AddFuoriMenuModal extends Component
{
    public $nome_italiano;
    public $nome_inglese;
    public $descrizione_italiano;
    public $descrizione_inglese;
    public $surgelato = false;
    public $prezzo;
    public $piattoId;
    public $showModal = false;
    public $deletePiatto = false;
    public $selectedAllergeni = [];
    public $allergeni;

    protected $listeners = ['openModal' => 'openModal', 'openEditModal' => 'openEditModal', 'deletePiatto' => 'deletePiatto'];

    public function mount()
    {
        $this->allergeni = Allergeni::all();
    }

    protected function sanitize($input)
    {
        // Converti i ritorni a capo in <br>
        $inputWithBreaks = nl2br($input, false); // Non usare htmlspecialchars qui

        // Configura HTMLPurifier
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'br'); // Permette solo i tag <br>
        $purifier = new HTMLPurifier($config);

        // Pulisci il contenuto
        return $purifier->purify($inputWithBreaks);
    }

    public function openModal()
    {
        $this->deletePiatto = false;
        $this->resetInputFields();
        $this->showModal = true;
        $this->dispatch('show-modal');
    }

    public function deletePiatto($piattoId)
    {
        $this->deletePiatto = true;
        $this->resetInputFields();
        $this->showModal = true;
        $this->dispatch('show-modal');
        $this->piattoId = $piattoId;
    }

    public function confirmDeletePiatto()
    {
        PiattoDelGiorno::find($this->piattoId)->delete();
        $this->dispatch('hide-modal');
        $this->dispatch('refreshList');
        $this->resetInputFields();
        // $this->deletePiatto = false;
    }

    public function openEditModal($id)
    {
        $this->deletePiatto = false;
        $piatto = PiattoDelGiorno::find($id);
        $this->piattoId = $piatto->id;

        // Sostituisci i <br> con \n nei campi di testo
        $this->nome_italiano = str_replace('<br />', "", $piatto->nome_italiano);
        $this->nome_inglese = str_replace('<br />', "", $piatto->nome_inglese);
        $this->descrizione_italiano = str_replace('<br />', "", $piatto->descrizione_italiano);
        $this->descrizione_inglese = str_replace('<br />', "", $piatto->descrizione_inglese);
        $this->prezzo = $piatto->prezzo;
        $this->surgelato = $piatto->surgelato;
        $this->selectedAllergeni = json_decode($piatto->allergeni, true) ?? [];
        $this->showModal = true;
        $this->dispatch('show-modal');
    }


    public function save()
    {
        // Convert empty strings to null for both descriptions
        if ($this->descrizione_italiano == '') {
            $this->descrizione_italiano = null;
        }

        if ($this->descrizione_inglese == '') {
            $this->descrizione_inglese = null;
        }

        // Validate the input data
        $validatedData = $this->validate([
            'nome_italiano' => 'required|string|max:255',
            'nome_inglese' => 'required|string|max:255',
            'descrizione_italiano' => 'string|nullable',
            'descrizione_inglese' => 'string|nullable',
            'prezzo' => 'required|numeric',
            'selectedAllergeni' => 'array',
            'selectedAllergeni.*' => 'exists:allergeni,id',
            'surgelato' => 'bool',
        ]);

        // Sanitizzare i campi di testo

        $this->nome_italiano = $this->sanitize($this->nome_italiano);
        $this->nome_inglese = $this->sanitize($this->nome_inglese);
        $this->descrizione_italiano = $this->sanitize($this->descrizione_italiano);
        $this->descrizione_inglese = $this->sanitize($this->descrizione_inglese);


        if ($this->descrizione_italiano != null || $this->descrizione_inglese != null) {
            $this->validate([
                'descrizione_italiano' => 'required|string|nullable',
                'descrizione_inglese' => 'required|string|nullable',
            ]);
        }
        // Update or create the piatto del giorno
        if ($this->piattoId) {
            PiattoDelGiorno::find($this->piattoId)->update([
                'nome_italiano' => $this->nome_italiano,
                'nome_inglese' => $this->nome_inglese,
                'descrizione_italiano' => $this->descrizione_italiano,
                'descrizione_inglese' => $this->descrizione_inglese,
                'prezzo' => $this->prezzo,
                'allergeni' => json_encode($this->selectedAllergeni),
                'surgelato' => $this->surgelato,
            ]);
        } else {
            PiattoDelGiorno::create([
                'nome_italiano' => $this->nome_italiano,
                'nome_inglese' => $this->nome_inglese,
                'descrizione_italiano' => $this->descrizione_italiano,
                'descrizione_inglese' => $this->descrizione_inglese,
                'prezzo' => $this->prezzo,
                'allergeni' => json_encode($this->selectedAllergeni),
                'surgelato' => $this->surgelato,
            ]);
        }

        $this->dispatch('hide-modal');
        $this->dispatch('refreshList');
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->nome_italiano = '';
        $this->nome_inglese = '';
        $this->descrizione_italiano = '';
        $this->descrizione_inglese = '';
        $this->prezzo = '';
        $this->piattoId = null;
        $this->selectedAllergeni = [];
        $this->surgelato = false;
    }

    public function render()
    {
        return view('livewire.add-fuori-menu-modal');
    }
}
