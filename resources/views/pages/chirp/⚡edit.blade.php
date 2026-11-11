<?php

use Livewire\Component;
use App\Models\Chirp;

new class extends Component
{
    public Chirp $chirp;
    public string $message = '';

    public function mount()
    {
        $this->message = $this->chirp->message;
    }

    public function updateChirp()
    {
        $this->authorize('update', $this->chirp);

        $validated = $this->validate([
            'message' => ['required', 'string', 'max:255'],
        ]);
        
        $this->chirp->update([
            'message' => $validated['message'],
        ]);

        $this->redirect('/chirp/home', navigate: true);
    }
};
?>

<div>
    <div class="col-lg-8 col-xl-7 mx-auto">
        <h1 class="fs-2 fw-bold mt-4">Edit Chirp</h1>

        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <form wire:submit="updateChirp">

                    <div>
                        <textarea
                            wire:model="message"
                            class="form-control chirp-textarea @error('message') is-invalid @enderror"
                            rows="4"
                            maxlength="255"
                            required
                        ></textarea>

                        @error('message')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="/chirp/home" wire:navigate class="btn btn-outline-secondary btn-sm">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm">Update Chirp</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>