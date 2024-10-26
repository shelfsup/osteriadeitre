<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CategoriaMenu;
use App\Models\SottocategoriaMenu;
use App\Models\PiattoMenu;
use App\Models\PiattoSottocategoria;
use App\Models\Allergeni;
use App\Models\PiattiSottoSottocategoria;
use App\Models\SottoSottocategoriaMenu;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use HTMLPurifier;
use HTMLPurifier_Config;

class AddElementModal extends Component
{
    use WithFileUploads;

    public $photo_url;
    public $photoPreview;

    public $type;
    public $nome_italiano;
    public $nome_inglese;
    public $descrizione_italiano;
    public $descrizione_inglese;
    public $surgelato = false;
    public $prezzo;
    public $prezzo_asporto = 0;
    public $asporto = false;
    public $solo_asporto = false;
    public $categoria_id;
    public $sottocategoria_id;
    public $sottoSottocategoria_id;

    public $piatto_id;
    public $showModal = false;
    public $selectedAllergeni = [];
    public $allergeni;

    public $show_desc = false;

    protected $listeners = ['open-modal' => 'openModal'];

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



    // Aggiungi questo metodo al tuo componente Livewire
    public function updatedPhotoUrl()
    {
        $this->validate([
            'photo_url' => [
                'nullable',
                File::image()
                    ->min('1kb')
                    ->max('2mb'),
                // ->dimensions(Rule::dimensions()->width(800)->height(800)),
            ],
        ]);

        $this->photoPreview = $this->photo_url ? $this->photo_url->temporaryUrl() : null;
    }

    // Aggiungi un metodo per cancellare l'anteprima quando necessario
    public function clearPhotoPreview()
    {
        $this->photo_url = null;
        $this->photoPreview = null;
    }

    protected function catalogsPhotoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('jetstream.catalogs_photo_disk', 'public');
    }

    public function openModal($data)
    {
        $this->resetForm();

        $this->type = $data['type'];
        $this->categoria_id = $data['categoria_id'] ?? null;
        $this->sottocategoria_id = $data['sottocategoria_id'] ?? null;
        $this->sottoSottocategoria_id = $data['sotto_sottocategoria_id'] ?? null;
        $this->piatto_id = $data['piatto_id'] ?? null;

        if ($this->piatto_id) {
            if (in_array($this->type, ['modifica_piatto_categoria', 'modifica_piatto_sottocategoria', 'modifica_piatto_sotto_sottocategoria'])) {
                $piatto = $this->type == 'modifica_piatto_categoria' ? PiattoMenu::find($this->piatto_id) : ($this->type == 'modifica_piatto_sottocategoria' ? PiattoSottocategoria::find($this->piatto_id) : PiattiSottoSottocategoria::find($this->piatto_id));
                $this->nome_italiano = str_replace('<br />', "", $piatto->nome_italiano);
                $this->nome_inglese = str_replace('<br />', "", $piatto->nome_inglese);
                $this->descrizione_italiano = str_replace('<br />', "", $piatto->descrizione_italiano);
                $this->descrizione_inglese = str_replace('<br />', "", $piatto->descrizione_inglese);
                $this->prezzo = $piatto->prezzo;
                $this->surgelato = $piatto->surgelato;
                $this->selectedAllergeni = json_decode($piatto->allergeni, true) ?? [];
                $this->photoPreview = $piatto->photo == null ? null : Storage::url($piatto->photo);
                $this->show_desc = $piatto->show_desc;
                $this->asporto = $piatto->asporto;
                $this->solo_asporto = $piatto->solo_asporto;
                $this->prezzo_asporto = $piatto->prezzo_asporto;
            }
        } elseif (in_array($this->type, ['rinomina_categoria', 'rinomina_sottocategoria', 'rinomina_sotto_sottocategoria'])) {
            if ($this->categoria_id) {
                $categoria = CategoriaMenu::find($this->categoria_id);
                $this->nome_italiano = str_replace('<br />', "", $categoria->nome_italiano);
                $this->nome_inglese = str_replace('<br />', "", $categoria->nome_inglese);
            } elseif ($this->sottocategoria_id) {
                $sottocategoria = SottocategoriaMenu::find($this->sottocategoria_id);
                $this->nome_italiano = str_replace('<br />', "", $sottocategoria->nome_italiano);
                $this->nome_inglese = str_replace('<br />', "", $sottocategoria->nome_inglese);
            } elseif ($this->sottoSottocategoria_id) {
                $sottoSottocategoria = SottoSottocategoriaMenu::find($this->sottoSottocategoria_id);
                $this->nome_italiano = str_replace('<br />', "", $sottoSottocategoria->nome_italiano);
                $this->nome_inglese = str_replace('<br />', "", $sottoSottocategoria->nome_inglese);
            }
        }

        $this->dispatch('show-modal');
        $this->showModal = true;
    }


    public function messages()
    {
        return [
            'nome_italiano.required' => 'Il nome italiano è obbligatorio.',
            'nome_italiano.string' => 'Il nome italiano deve essere una stringa.',
            'nome_italiano.max' => 'Il nome italiano non può superare i 255 caratteri.',
            'nome_inglese.required' => 'Il nome inglese è obbligatorio.',
            'nome_inglese.string' => 'Il nome inglese deve essere una stringa.',
            'nome_inglese.max' => 'Il nome inglese non può superare i 255 caratteri.',
            'prezzo.required_if' => 'Il prezzo è obbligatorio.',
            'prezzo.numeric' => 'Il prezzo deve essere un numero.',
            'descrizione_italiano.string' => 'La descrizione in italiano deve essere una stringa.',
            'descrizione_inglese.string' => 'La descrizione in inglese deve essere una stringa.',
            'selectedAllergeni.array' => 'Gli allergeni devono essere un array.',
            'selectedAllergeni.*.exists' => 'Uno o più allergeni selezionati non sono validi.',
            'modifica_piatto_categoria.required_if' => 'Il prezzo è obbligatorio.',
            'modifica_piatto_sottocategoria.required_if' => 'Il prezzo è obbligatorio.',
            'prezzo_asporto.required_if' => 'Il prezzo da asporto è obbligatorio.'
        ];
    }

    public function save()
    {
        $validatedData = $this->validate([
            'nome_italiano' => 'required|string|max:255',
            'nome_inglese' => 'required|string|max:255',
            'prezzo' => 'required_if:type,piatto,modifica_piatto_categoria,modifica_piatto_sottocategoria,modifica_piatto_sotto_sottocategoria|numeric',
            'descrizione_italiano' => 'nullable|string|max:700',
            'descrizione_inglese' => 'nullable|string|max:700',
            'selectedAllergeni' => 'array',
            'selectedAllergeni.*' => 'exists:allergeni,id',
            'surgelato' => 'bool',
            'asporto' => 'bool',
            'solo_asporto' => 'bool',
            'prezzo_asporto' => 'nullable|required_if:asporto,true|numeric',
            'photo_url' => [
                'nullable',
                File::image()
                    ->min('1kb')
                    ->max('2mb'),
            ],
        ], $this->messages());

        if($this->prezzo_asporto == ''){
            $this->setPrezzoAsporto();
        }

        $newPhotoPath = $this->photo_url ? $this->photo_url->storePublicly('catalogs-product-photos', ['disk' => $this->catalogsPhotoDisk()]) : null;

        // Sanitizzare i campi di testo
        $this->nome_italiano = $this->sanitize($this->nome_italiano);
        $this->nome_inglese = $this->sanitize($this->nome_inglese);
        $this->descrizione_italiano = $this->sanitize($this->descrizione_italiano);
        $this->descrizione_inglese = $this->sanitize($this->descrizione_inglese);

        switch ($this->type) {
            case 'categoria':
                CategoriaMenu::create([
                    'nome_italiano' => $this->nome_italiano,
                    'nome_inglese' => $this->nome_inglese,
                ]);
                break;

            case 'sottocategoria':
                $this->validate([
                    'categoria_id' => 'required|exists:categorie_menu,id',
                ]);
                SottocategoriaMenu::create([
                    'nome_italiano' => $this->nome_italiano,
                    'nome_inglese' => $this->nome_inglese,
                    'descrizione_italiano' => $this->descrizione_italiano,
                    'descrizione_inglese' => $this->descrizione_inglese,
                    'id_categoria_menu' => $this->categoria_id,
                ]);
                break;

            case 'sottoSottocategoria':
                $this->validate([
                    'sottocategoria_id' => 'required|exists:sottocategorie_menu,id',
                ]);
                SottoSottocategoriaMenu::create([
                    'nome_italiano' => $this->nome_italiano,
                    'nome_inglese' => $this->nome_inglese,
                    'descrizione_italiano' => $this->descrizione_italiano,
                    'descrizione_inglese' => $this->descrizione_inglese,
                    'id_sottocategoria_menu' => $this->sottocategoria_id,
                ]);
                break;

            case 'piatto':
                if ($this->sottocategoria_id) {
                    PiattoSottocategoria::create([
                        'prezzo' => $this->prezzo,
                        'asporto' => $this->asporto,
                        'prezzo_asporto' => $this->prezzo_asporto,
                        'solo_asporto' => $this->solo_asporto,
                        'nome_italiano' => $this->nome_italiano,
                        'nome_inglese' => $this->nome_inglese,
                        'descrizione_italiano' => $this->descrizione_italiano,
                        'descrizione_inglese' => $this->descrizione_inglese,
                        'id_sottocategoria_menu' => $this->sottocategoria_id,
                        'allergeni' => json_encode($this->selectedAllergeni),
                        'surgelato' => $this->surgelato,
                        'photo' => $newPhotoPath,
                        'show_desc' => $this->show_desc,
                    ]);
                } elseif ($this->categoria_id) {
                    PiattoMenu::create([
                        'prezzo' => $this->prezzo,
                        'asporto' => $this->asporto,
                        'prezzo_asporto' => $this->prezzo_asporto,
                        'solo_asporto' => $this->solo_asporto,
                        'nome_italiano' => $this->nome_italiano,
                        'nome_inglese' => $this->nome_inglese,
                        'descrizione_italiano' => $this->descrizione_italiano,
                        'descrizione_inglese' => $this->descrizione_inglese,
                        'id_categoria_menu' => $this->categoria_id,
                        'allergeni' => json_encode($this->selectedAllergeni),
                        'surgelato' => $this->surgelato,
                        'photo' => $newPhotoPath,
                        'show_desc' => $this->show_desc,
                    ]);
                } elseif ($this->sottoSottocategoria_id) {
                    PiattiSottoSottocategoria::create([
                        'prezzo' => $this->prezzo,
                        'asporto' => $this->asporto,
                        'prezzo_asporto' => $this->prezzo_asporto,
                        'solo_asporto' => $this->solo_asporto,
                        'nome_italiano' => $this->nome_italiano,
                        'nome_inglese' => $this->nome_inglese,
                        'descrizione_italiano' => $this->descrizione_italiano,
                        'descrizione_inglese' => $this->descrizione_inglese,
                        'id_sotto_sottocategoria_menu' => $this->sottoSottocategoria_id,
                        'allergeni' => json_encode($this->selectedAllergeni),
                        'surgelato' => $this->surgelato,
                        'photo' => $newPhotoPath,
                        'show_desc' => $this->show_desc,
                    ]);
                }
                break;

            case 'modifica_piatto_categoria':
            case 'modifica_piatto_sottocategoria':
            case 'modifica_piatto_sotto_sottocategoria':
                $piatto = $this->type == 'modifica_piatto_categoria'
                    ? PiattoMenu::find($this->piatto_id)
                    : ($this->type == 'modifica_piatto_sottocategoria'
                        ? PiattoSottocategoria::find($this->piatto_id)
                        : SottoSottocategoriaMenu::find($this->piatto_id));

                // Se c'è una nuova foto, rimuovi la vecchia foto
                if ($newPhotoPath && $piatto->photo) {
                    Storage::disk($this->catalogsPhotoDisk())->delete($piatto->photo);
                }

                $piatto->update([
                    'nome_italiano' => $this->nome_italiano,
                    'nome_inglese' => $this->nome_inglese,
                    'descrizione_italiano' => $this->descrizione_italiano,
                    'descrizione_inglese' => $this->descrizione_inglese,
                    'prezzo' => $this->prezzo,
                    'asporto' => $this->asporto,
                    'prezzo_asporto' => $this->prezzo_asporto,
                    'solo_asporto' => $this->solo_asporto,
                    'surgelato' => $this->surgelato,
                    'allergeni' => json_encode($this->selectedAllergeni),
                    'photo' => $newPhotoPath ? $newPhotoPath : $piatto->photo,
                    'show_desc' => $this->show_desc,
                ]);
                break;

            case 'rinomina_categoria':
                $categoria = CategoriaMenu::find($this->categoria_id);
                $categoria->update([
                    'nome_italiano' => $this->nome_italiano,
                    'nome_inglese' => $this->nome_inglese,
                ]);
                break;

            case 'rinomina_sottocategoria':
                $sottocategoria = SottocategoriaMenu::find($this->sottocategoria_id);
                $sottocategoria->update([
                    'nome_italiano' => $this->nome_italiano,
                    'nome_inglese' => $this->nome_inglese,
                ]);
                break;

            case 'rinomina_sotto_sottocategoria':
                $sottoSottocategoria = SottoSottocategoriaMenu::find($this->sottoSottocategoria_id);
                $sottoSottocategoria->update([
                    'nome_italiano' => $this->nome_italiano,
                    'nome_inglese' => $this->nome_inglese,
                ]);
                break;
        }

        $this->showModal = false;
        $this->dispatch('hide-modal');
        $this->dispatch('refreshMenu');
        $this->resetForm();
    }

    public function setPrezzoAsporto(){
        $this->prezzo_asporto = 0;
    }


    public function deletePiattoCategoria()
    {
        PiattoMenu::findOrFail($this->piatto_id)->delete();
        $this->closeModal();
    }

    public function deletePiattoSottocategoria()
    {
        PiattoSottocategoria::findOrFail($this->piatto_id)->delete();
        $this->closeModal();
    }

    public function deleteCategory()
    {
        $categoria = CategoriaMenu::findOrFail($this->categoria_id);

        foreach ($categoria->sottocategorie as $sottocategoria) {
            $sottocategoria->piattiSottocategorie()->delete();
        }

        $categoria->sottocategorie()->delete();
        $categoria->piatti()->delete();
        $categoria->delete();

        $this->closeModal();
    }

    public function deleteSottoCategory()
    {
        $sottocategoria = SottocategoriaMenu::findOrFail($this->sottocategoria_id);

        $sottocategoria->piattiSottocategorie()->delete();
        $sottocategoria->delete();

        $this->closeModal();
    }

    public function deleteSottoSottoCategory()
    {
        $sottoSottocategoria = SottoSottocategoriaMenu::findOrFail($this->sottoSottocategoria_id);

        // Elimina piatti associati se necessario
        $sottoSottocategoria->piattiSottoSottocategorie()->delete();

        $sottoSottocategoria->delete();

        $this->closeModal();
    }

    public function deletePiattoSottoSottoCategory()
    {
        PiattiSottoSottocategoria::findOrFail($this->piatto_id)->delete();

        $this->closeModal();
    }


    public function resetForm()
    {
        $this->type = null;
        $this->nome_italiano = '';
        $this->nome_inglese = '';
        $this->descrizione_italiano = '';
        $this->descrizione_inglese = '';
        $this->prezzo = '';
        $this->categoria_id = null;
        $this->sottocategoria_id = null;
        $this->sottoSottocategoria_id = null;
        $this->piatto_id = null;
        $this->selectedAllergeni = [];
        $this->photo_url = null;
        $this->photoPreview = null;
        $this->show_desc = false;
        $this->asporto = false;
        $this->prezzo_asporto = null;
        $this->solo_asporto = false;
    }


    public function closeModal()
    {
        $this->showModal = false;
        $this->dispatch('hide-modal');
        $this->dispatch('refreshMenu');
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.add-element-modal');
    }
}
