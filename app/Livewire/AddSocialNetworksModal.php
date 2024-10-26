<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use App\Models\SocialNetwork;

class AddSocialNetworksModal extends Component
{
    use WithFileUploads;

    public $photo_url;
    public $photoPreview;
    public $type;
    public $nome_social;
    public $link_profilo;
    public $enable;
    public $showModal = false;
    public $social_id;
    public $inverti_img_social = false;

    protected $listeners = ['open-modal' => 'openModal'];

    public function mount()
    {
        $this->resetForm();
    }

    public function updatedPhotoUrl()
    {
        $this->validate([
            'photo_url' => [
                'nullable',
                File::image()
                    ->min('1kb')
                    ->max('2mb'),
            ],
        ]);

        $this->photoPreview = $this->photo_url ? $this->photo_url->temporaryUrl() : null;
    }

    public function clearPhotoPreview()
    {
        $this->photo_url = null;
        $this->photoPreview = null;
    }

    protected function catalogsPhotoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('jetstream.social_icons_disk', 'public');
    }

    public function openModal($data)
    {
        $this->resetForm();

        $this->type = $data['type'];
        $this->social_id = $data['social_id'] ?? null;

        if ($this->social_id) {
            if (in_array($this->type, ['modifica_social'])) {
                $social = SocialNetwork::find($this->social_id);
                if ($social) {
                    $this->nome_social = $social->nome_social;
                    $this->link_profilo = $social->link_profilo;
                    $this->enable = $social->enable;
                    $this->photoPreview = $social->photo ? Storage::url($social->photo) : null;
                    $this->inverti_img_social = $social->inverti;
                }
            }
        }

        $this->dispatch('show-modal');
        $this->showModal = true;
    }

    public function deleteSocial()
    {
        $social = SocialNetwork::findOrFail($this->social_id);
        $social->delete();

        $this->closeModal();
    }

    public function save()
    {
        $validatedData = $this->validate([
            'nome_social' => 'required|string|max:255',
            'link_profilo' => 'required|url',
            'photo_url' => [
                'nullable',

                File::image()
                    ->min('1kb')
                    ->max('2mb'),
            ],
            'inverti_img_social' => 'bool',
        ], $this->messages());

        if ($this->photo_url) {
            $newPhotoPath = $this->photo_url->storePublicly('social_icons_disk', ['disk' => $this->catalogsPhotoDisk()]);
        }

        if ($this->social_id) {
            $social = SocialNetwork::find($this->social_id);
            $social->update([
                'nome_social' => $this->nome_social,
                'link_profilo' => $this->link_profilo,
                'photo' => $newPhotoPath ?? $social->photo,
                'enable' => $this->enable ?? 0,
                'inverti' => $this->inverti_img_social ?? 0
            ]);
        } else {
            SocialNetwork::create([
                'nome_social' => $this->nome_social,
                'link_profilo' => $this->link_profilo,
                'photo' => $newPhotoPath ?? null,
                'enable' => 0,
                'inverti' => $this->inverti_img_social ?? 0
            ]);
        }

        $this->closeModal();
    }

    public function messages()
    {
        return [
            'nome_social.required' => 'Il nome è obbligatorio.',
            'nome_social.string' => 'Il nome deve essere una stringa.',
            'link_profilo.required' => 'L\'URL è obbligatorio.',
            'link_profilo.url' => 'L\'URL inserito non è valido.',
        ];
    }

    public function resetForm()
    {
        $this->type = null;
        $this->nome_social = null;
        $this->link_profilo = null;
        $this->enable = null;
        $this->photo_url = null;
        $this->photoPreview = null;
        $this->social_id = null;
        $this->inverti_img_social = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->dispatch('hide-modal');
        $this->dispatch('refresh-social');
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.add-social-networks-modal');
    }
}
