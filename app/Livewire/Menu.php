<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CategoriaMenu;
use App\Models\SottocategoriaMenu;
use App\Models\SottoSottocategoriaMenu;
use App\Models\PiattoMenu;
use App\Models\PiattoSottocategoria;
use App\Models\PiattiSottoSottocategoria;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;

class Menu extends Component
{
    public $categorie;
    public $nomeCategoria;
    public $nomeSottocategoria;
    public $nomeSottoSottocategoria;

    public $descrizioneSottocategoria;
    public $descrizioneSottoSottocategoria;

    public $nomePiatto;
    public $prezzoPiatto;
    public $descrizionePiatto;

    public $nomeCategoriaEnglish;
    public $nomeSottocategoriaEnglish;
    public $nomeSottoSottocategoriaEnglish;

    public $descrizioneSottocategoriaEnglish;
    public $descrizioneSottoSottocategoriaEnglish;

    public $nomePiattoEnglish;
    public $selectedLanguage = 'it'; // default to Italian

    protected $listeners = ['refreshMenu' => 'refreshCategories', 'switchLanguage' => 'switchLanguage'];

    protected $rules = [
        'nomeCategoria' => 'required|string|max:255',
        'nomeCategoriaEnglish' => 'required|string|max:255',
        'nomeSottocategoria' => 'required|string|max:255',
        'nomeSottocategoriaEnglish' => 'required|string|max:255',
        'descrizioneSottocategoria' => 'nullable|string',
        'descrizioneSottocategoriaEnglish' => 'nullable|string',
        'nomeSottoSottocategoria' => 'required|string|max:255',
        'nomeSottoSottocategoriaEnglish' => 'required|string|max:255',
        'descrizioneSottoSottocategoria' => 'nullable|string',
        'descrizioneSottoSottocategoriaEnglish' => 'nullable|string',
        'nomePiatto' => 'required|string|max:255',
        'nomePiattoEnglish' => 'required|string|max:255',
        'prezzoPiatto' => 'required|numeric',
        'descrizionePiatto' => 'nullable|string',
    ];

    public function mount()
    {
        $this->refreshCategories();
    }

    public function enablePiatto($idPiatto)
    {
        $piatto = PiattoMenu::findOrFail($idPiatto);

        $piatto->enable = !$piatto->enable;
        $piatto->save();
        $this->refreshCategories();
    }

    public function enablePiattoSottocategoria($idPiatto)
    {
        $piatto = PiattoSottocategoria::findOrFail($idPiatto);

        $piatto->enable = !$piatto->enable;
        $piatto->save();
        $this->refreshCategories();
    }

    public function enablePiattoSottoSottocategoria($idPiatto)
    {
        $piatto = PiattiSottoSottocategoria::findOrFail($idPiatto);

        $piatto->enable = !$piatto->enable;
        $piatto->save();
        $this->refreshCategories();
    }

    public function refreshCategories()
    {
        $this->categorie = null;

        $orderByField = 'ordinamento';

        $this->categorie = CategoriaMenu::with([
            'piatti' => function ($query) use ($orderByField) {
                $query->orderBy($orderByField);
            },
            'sottocategorie' => function ($query) use ($orderByField) {
                $query->orderBy($orderByField); // Ordinamento delle sottocategorie
            },
            'sottocategorie.piattiSottocategorie' => function ($query) use ($orderByField) {
                $query->orderBy($orderByField); // Ordinamento dei piatti nelle sottocategorie
            },
            'sottocategorie.sottoSottocategorie' => function ($query) use ($orderByField) {
                $query->orderBy($orderByField); // Ordinamento delle sotto-sottocategorie
            },
            'sottocategorie.sottoSottocategorie.piattiSottoSottocategorie' => function ($query) use ($orderByField) {
                $query->orderBy($orderByField); // Ordinamento dei piatti nelle sotto-sottocategorie
            }
        ])->orderBy($orderByField)->get();
    }

    public function enableSottocategoria($idSottocategoria)
    {
        $sottocategoriaToggle = SottocategoriaMenu::findOrFail($idSottocategoria);
        $sottocategoriaToggle->enable = !$sottocategoriaToggle->enable;
        $sottocategoriaToggle->save();
        $this->refreshCategories();
    }

    public function enableSottoSottocategoria($idSottoSottocategoria)
    {
        $sottoSottocategoriaToggle = SottoSottocategoriaMenu::findOrFail($idSottoSottocategoria);
        $sottoSottocategoriaToggle->enable = !$sottoSottocategoriaToggle->enable;
        $sottoSottocategoriaToggle->save();
        $this->refreshCategories();
    }

    public function enableCategoria($idCategoria)
    {
        $categoriaToggle = CategoriaMenu::findOrFail($idCategoria);
        $categoriaToggle->enable = !$categoriaToggle->enable;
        $categoriaToggle->save();
        $this->refreshCategories();
    }

    public function switchLanguage($language)
    {
        $this->selectedLanguage = $language;
    }

    #[On('updateElementOrder')]
    public function updateElementOrder($data)
    {
        // Aggiungi log per verificare i dati ricevuti
        // dd('updateElementOrder data:', $data);

        // Gestisci ordinamento categorie
        if (!empty($data['categorieId'])) {
            $this->reorderElement('App\Models\CategoriaMenu', $data['categorieId']);
        }

        // Gestisci ordinamento piatti
        if (!empty($data['piattiIds'])) {
            $this->reorderElement('App\Models\PiattoMenu', $data['piattiIds']);
        }

        // Gestisci ordinamento sottocategorie
        if (!empty($data['sottocategorieIds'])) {
            $this->reorderElement('App\Models\SottocategoriaMenu', $data['sottocategorieIds']);
        }

        // Gestisci ordinamento piattiSottocategorie
        if (!empty($data['piattiSottocategorieIds'])) {
            $this->reorderElement('App\Models\PiattoSottocategoria', $data['piattiSottocategorieIds']);
        }

        // Gestisci ordinamento sotto-sottocategorie
        if (!empty($data['sottoSottocategorieIds'])) {
            $this->reorderElement('App\Models\SottoSottocategoriaMenu', $data['sottoSottocategorieIds']);
        }

        // Gestisci ordinamento piattiSottoSottocategorie
        if (!empty($data['piattiSottoSottocategorieIds'])) {
            $this->reorderElement('App\Models\PiattiSottoSottocategoria', $data['piattiSottoSottocategorieIds']);
        }

        $this->refreshCategories();
    }


    private function reorderElement($model, $ids, $targetId = null)
    {
        foreach ($ids as $index => $id) {
            $element = $model::find($id);
            $element->ordinamento = $index;
            if ($targetId) {
                $element->categoria_id = $targetId; // Per categorie e sottocategorie
            }
            $element->save();
        }
    }

    public function render()
    {
        $this->dispatch('elementChanged');
        return view('livewire.menu', [
            'categorie' => $this->categorie,
            'selectedLanguage' => $this->selectedLanguage,
        ]);
    }
}
