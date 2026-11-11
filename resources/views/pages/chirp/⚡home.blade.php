<?php

use Livewire\Component;
use App\Models\Chirp;

new class extends Component {
    public string $message = '';
    public string $search = '';

    // public function with(): array
    // {
    //     return [
    //         'chirps' => Chirp::query()
    //             ->with('user')
    //             ->when($this->search !== '', fn ($query) => $query->where('message', 'like', "%{$this->search}%"))
    //             ->latest()
    //             ->paginate(10),
    //     ];
    // }

    public function store()
    {
        $validated = $this->validate(
            [
                'message' => ['required', 'string', 'max:255'],
            ],
            [
                'message.required' => 'Please write something to chirp!',
                'message.max' => 'Chirps must be 255 characters or less.',
            ],
        );

        // Use the authenticated user
        auth()->user()->chirps()->create($validated);

        $this->reset('message');

        // Avisa al componente "chirp-list" que hay un nuevo chirp para que se refresque
        $this->dispatch('chirp-created');
    }
};
?>

<div class="col-lg-8 col-xl-7 mx-auto">
    <h1 class="fs-2 fw-bold mt-4">Latest Chirps</h1>

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <form wire:submit="store">
                
                <div>
                    <textarea wire:model="message" placeholder="What's on your mind?"
                        class="form-control chirp-textarea @error('message') is-invalid @enderror" rows="4" required></textarea>

                    @error('message')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary btn-sm">Chirp</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-4">
        <label for="search" class="form-label">Search chirps</label>
        <div class="input-group">
            <!-- Agregamos .debounce.300ms para no saturar la base de datos en cada tecla -->
            <input type="search" wire:model.live.debounce.300ms="search" id="search" placeholder="Filter by message"
                class="form-control" maxlength="100">

            <!-- Usamos $set para vaciar la variable $search al hacer clic -->
            <button type="button" wire:click="$set('search', '')" class="btn btn-outline-secondary"
                @disabled($search === '')>Clear</button>
        </div>
    </div>

    <div class="mt-4" id="chirp-search-error" role="alert" hidden></div>
    <div id="chirp-results" aria-live="polite" aria-busy="false">

        <livewire:chirp-list :search="$search" />
    </div>
</div>
