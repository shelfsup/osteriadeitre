<?php

namespace App\Livewire\Toast;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;

class Toast extends Component
{

    public $type;
    public $message;

    protected $listeners = ['showToast'];

    public function showToast($toastData)
    {
        Log::info('dati apertura toast: ' . json_encode($toastData));

        // Check if $toastData is an array and has elements
        if (is_array($toastData) && isset($toastData['toastData'])) {
            // Extract 'toastData' from the first element of the array
            $toastData = $toastData['toastData'];

            // Check if $toastData has the expected keys
            if (isset($toastData['type'], $toastData['message'])) {
                $this->type = $toastData['type'];
                $this->message = $toastData['message'];

                // Dispatch a new event with the toast data
                $this->dispatch('setToast', ['type' => $this->type, 'message' => $this->message]);
            } else {
                // Log an error if 'type' or 'message' keys are missing
                Log::error("Invalid 'toastData' format: " . json_encode($toastData));
            }
        } else {
            // Log an error if $toastData is not in the expected format
            Log::error("Invalid 'toastData' format: " . json_encode($toastData));
        }
    }

    public function render()
    {
        return view('livewire.toast.toast');
    }
}
