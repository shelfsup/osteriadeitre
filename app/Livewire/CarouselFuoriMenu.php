<?php

namespace App\Livewire;

use App\Models\PersonalizzaMenu;
use App\Models\PiattoDelGiorno;
use Livewire\Component;

class CarouselFuoriMenu extends Component
{
    public $selectedLanguage = 'it'; // default to Italian
    public $titolo_ita;
    public $titolo_eng;
    public $sottotitolo_ita;
    public $sottotitolo_eng;
    public $modifyTitolo = false;
    public $modifySottotitolo = false;

    protected $listeners = ['switchLanguage' => 'switchLanguage'];

    public function mount()
    {
        $this->setTitoli();
    }

    public function setTitoli()
    {
        $testiMenu = PersonalizzaMenu::where('id', 1)->first();

        $this->titolo_ita = $testiMenu->titolo_italiano;
        $this->titolo_eng = $testiMenu->titolo_inglese;
        $this->sottotitolo_ita = $testiMenu->sottotitolo_italiano;
        $this->sottotitolo_eng = $testiMenu->sottotitolo_inglese;

        if ($this->modifyTitolo) {
            $this->modifyTitolo = false;
        }

        if ($this->modifySottotitolo) {
            $this->modifySottotitolo = false;
        }
    }

    public function toggleTitolo()
    {
        $this->modifyTitolo = !$this->modifyTitolo;
    }

    public function toggleSottotitolo()
    {
        $this->modifySottotitolo = !$this->modifySottotitolo;
    }

    public function saveTitoli()
    {
        $testiMenu = PersonalizzaMenu::where('id', 1)->first();

        $testiMenu->titolo_italiano = $this->titolo_ita;
        $testiMenu->titolo_inglese = $this->titolo_eng;
        $testiMenu->sottotitolo_italiano = $this->sottotitolo_ita;
        $testiMenu->sottotitolo_inglese = $this->sottotitolo_eng;

        $testiMenu->save();

        if ($this->modifyTitolo) {
            $this->modifyTitolo = false;
        }

        if ($this->modifySottotitolo) {
            $this->modifySottotitolo = false;
        }
    }

    public function switchLanguage($language)
    {
        $this->selectedLanguage = $language;
        $this->setTitoli();
        $this->dispatch('resetCarousel');
    }

    public function render()
    {
        $piatti = PiattoDelGiorno::where('enable', 1)->get();
        return view('livewire.carousel-fuori-menu', compact(['piatti']));
    }
}
