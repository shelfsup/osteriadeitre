<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CategoriaMenu;
use App\Models\PersonalizzaMenu;
use App\Models\SottocategoriaMenu;
use App\Models\PiattoMenu;
use App\Models\PiattoSottocategoria;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;

class MenuOnline extends Component
{
    public $categorie;
    public $nomeCategoria;
    public $nomeSottocategoria;
    public $descrizioneSottocategoria;
    public $nomePiatto;
    public $prezzoPiatto;
    public $descrizionePiatto;
    public $nomeCategoriaEnglish;
    public $nomeSottocategoriaEnglish;
    public $descrizioneSottocategoriaEnglish;
    public $nomePiattoEnglish;
    public $selectedLanguage = 'it'; // default to Italian

    public $modifyTitoloMenu = false;
    public $modifyTitoloSocial = false;
    public $titolo_menu_ita;
    public $titolo_menu_eng;
    public $titolo_social_ita;
    public $titolo_social_eng;

    protected $listeners = ['refreshMenu' => 'refreshCategories', 'switchLanguage' => 'switchLanguage'];


    public function mount()
    {
        $this->refreshCategories();
        $this->setTitoli();
    }

    // public function refreshCategories()
    // {
    //     $this->categorie = CategoriaMenu::where('enable', 1)
    //         ->with([
    //             'piatti' => function ($query) {
    //                 $query->where('enable', 1)->where('solo_asporto', 0)
    //                       ->orderBy('ordinamento'); // Ordinamento dei piatti
    //             },
    //             'sottocategorie' => function ($query) {
    //                 $query->where('enable', 1)
    //                       ->orderBy('ordinamento') // Ordinamento delle sottocategorie
    //                       ->with([
    //                           'piattiSottocategorie' => function ($query) {
    //                               $query->where('enable', 1)->where('solo_asporto', 0)
    //                                     ->orderBy('ordinamento'); // Ordinamento dei piatti nelle sottocategorie
    //                           }
    //                       ]);
    //             }
    //         ])
    //         ->where(function ($query) {
    //             $query->whereHas('piatti', function ($query) {
    //                     $query->where('enable', 1)->where('solo_asporto', 0);
    //                 })
    //                 ->orWhereHas('sottocategorie', function ($query) {
    //                     $query->where('enable', 1)
    //                           ->whereHas('piattiSottocategorie', function ($query) {
    //                               $query->where('enable', 1)->where('solo_asporto', 0);
    //                           });
    //                 });
    //         })
    //         ->orderBy('ordinamento') // Ordinamento delle categorie principali
    //         ->get();
    // }

    public function refreshCategories(){
    $this->categorie = CategoriaMenu::where('enable', 1)
        ->where(function ($query) {
            $query->whereHas('piatti', function ($query) {
                    $query->where('enable', 1)->where('solo_asporto', 0);
                })
                ->orWhereHas('sottocategorie', function ($query) {
                    $query->where('enable', 1)
                          ->whereHas('piattiSottocategorie', function ($query) {
                              $query->where('enable', 1)->where('solo_asporto', 0);
                          })
                          ->orWhereHas('sottoSottocategorie', function ($query) {
                              $query->where('enable', 1)
                                    ->whereHas('piattiSottoSottocategorie', function ($query) {
                                        $query->where('enable', 1)->where('solo_asporto', 0);
                                    });
                          });
                });
        })
        ->with([
            'piatti' => function ($query) {
                $query->where('enable', 1)->where('solo_asporto', 0)
                      ->orderBy('ordinamento');
            },
            'sottocategorie' => function ($query) {
                $query->where('enable', 1)
                      ->orderBy('ordinamento')
                      ->with([
                          'piattiSottocategorie' => function ($query) {
                              $query->where('enable', 1)->where('solo_asporto', 0)
                                    ->orderBy('ordinamento');
                          },
                          'sottoSottocategorie' => function ($query) {
                              $query->where('enable', 1)
                                    ->orderBy('ordinamento')
                                    ->with([
                                        'piattiSottoSottocategorie' => function ($query) {
                                            $query->where('enable', 1)->where('solo_asporto', 0)
                                                  ->orderBy('ordinamento');
                                        }
                                    ]);
                          }
                      ]);
            }
        ])
        ->orderBy('ordinamento')
        ->get();
}


    public function setTitoli()
    {
        $testiMenu = PersonalizzaMenu::where('id', 1)->first();

        $this->titolo_menu_ita = $testiMenu->titolo_menu_italiano;
        $this->titolo_menu_eng = $testiMenu->titolo_menu_inglese;
        $this->titolo_social_ita = $testiMenu->titolo_social_italiano;
        $this->titolo_social_eng = $testiMenu->titolo_social_inglese;

        if ($this->modifyTitoloMenu) {
            $this->modifyTitoloMenu = false;
        }

        if ($this->modifyTitoloSocial) {
            $this->modifyTitoloSocial = false;
        }
    }

    public function toggleTitoloMenu()
    {
        $this->modifyTitoloMenu = !$this->modifyTitoloMenu;
    }

    public function toggleTitoloSocial()
    {
        $this->modifyTitoloSocial = !$this->modifyTitoloSocial;
    }

    public function saveTitoli()
    {
        $testiMenu = PersonalizzaMenu::where('id', 1)->first();

        $testiMenu->titolo_menu_italiano = $this->titolo_menu_ita;
        $testiMenu->titolo_menu_inglese = $this->titolo_menu_eng;
        $testiMenu->titolo_social_italiano = $this->titolo_social_ita;
        $testiMenu->titolo_social_inglese = $this->titolo_social_eng;

        $testiMenu->save();

        if ($this->modifyTitoloMenu) {
            $this->modifyTitoloMenu = false;
        }

        if ($this->modifyTitoloSocial) {
            $this->modifyTitoloSocial = false;
        }
    }

    #[On('content-loaded')]
    public function switchLanguage($language)
    {
        $this->selectedLanguage = $language;
        $this->setTitoli();
    }

    public function render()
    {
        return view('livewire.menu-online', [
            'categorie' => $this->categorie,
            'selectedLanguage' => $this->selectedLanguage,
        ]);
    }
}
