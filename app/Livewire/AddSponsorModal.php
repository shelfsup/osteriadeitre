<?php

namespace App\Livewire;

use App\Models\Sponsor;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class AddSponsorModal extends Component
{
    use WithFileUploads;

    public $photo_url;
    public $photoPreview;
    public $type;
    public $nome_sponsor;
    public $link_sponsor;
    public $enable;
    public $showModal = false;
    public $sponsor_id;
    public $inverti = false;

    protected $listeners = ['open-modal-sponsor' => 'openModal'];

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

    protected function sponsorsPhotoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('jetstream.sponsor_photo_disk', 'public');
    }

    public function openModal($data)
    {
        $this->resetForm();

        $this->type = $data['type'];
        $this->sponsor_id = $data['sponsor_id'] ?? null;

        if ($this->sponsor_id) {
            if (in_array($this->type, ['modifica_sponsor'])) {
                $sponsor = Sponsor::find($this->sponsor_id);
                if ($sponsor) {
                    $this->nome_sponsor = $sponsor->nome_sponsor;
                    $this->link_sponsor = $sponsor->link_sponsor;
                    $this->enable = $sponsor->enable;
                    $this->photoPreview = $sponsor->photo ? Storage::url($sponsor->photo) : null;
                    $this->inverti = $sponsor->inverti ?? false;
                }
            }
        }

        $this->dispatch('show-modal-sponsor');
        $this->showModal = true;
    }

    public function deleteSponsor()
    {
        $sponsor = Sponsor::findOrFail($this->sponsor_id);
        $sponsor->delete();

        $this->closeModal();
    }

    public function save()
    {
        $validatedData = $this->validate([
            'nome_sponsor' => 'required|string|max:255',
            'link_sponsor' => 'url|nullable',
            'photo_url' => [
                'nullable',
                File::image()
                    ->min('1kb')
                    ->max('2mb'),
            ],
        ], $this->messages());

        if ($this->photo_url) {
            $newPhotoPath = $this->photo_url->storePublicly('sponsor_photo_disk', ['disk' => $this->sponsorsPhotoDisk()]);
        }

        if ($this->sponsor_id) {
            $sponsor = Sponsor::find($this->sponsor_id);
            $sponsor->update([
                'nome_sponsor' => $this->nome_sponsor,
                'link_sponsor' => $this->link_sponsor,
                'photo' => $newPhotoPath ?? $sponsor->photo,
                'enable' => $this->enable ?? 0,
                'inverti' => $this->inverti
            ]);
        } else {
            Sponsor::create([
                'nome_sponsor' => $this->nome_sponsor,
                'link_sponsor' => $this->link_sponsor,
                'photo' => $newPhotoPath ?? null,
                'enable' => 0,
                'inverti' => $this->inverti
            ]);
        }

        $this->closeModal();
    }

    public function messages()
    {
        return [
            'nome_sponsor.required' => 'Il nome è obbligatorio.',
            'nome_sponsor.string' => 'Il nome deve essere una stringa.',
            'link_sponsor.required' => 'L\'URL è obbligatorio.',
            'link_sponsor.url' => 'L\'URL inserito non è valido.',
        ];
    }

    public function resetForm()
    {
        $this->type = null;
        $this->nome_sponsor = null;
        $this->link_sponsor = null;
        $this->enable = null;
        $this->photo_url = null;
        $this->photoPreview = null;
        $this->sponsor_id = null;
        $this->inverti = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->dispatch('hide-modal-sponsor');
        $this->dispatch('refresh-sponsor');
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.add-sponsor-modal');
    }
}
