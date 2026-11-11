<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Chirp;
use Livewire\Attributes\Reactive;

new class extends Component {
    use WithPagination;

    // Recibe de forma reactiva el término desde el padre
    #[Reactive]
    public string $search = ''; 

    // Escucha si el padre guardó un chirp para resetear la paginación y mostrar el nuevo
    #[Livewire\Attributes\On('chirp-created')]
    public function refreshList()
    {
        $this->resetPage();
    }

    // Si el usuario cambia el texto de búsqueda, volvemos a la página 1 automáticamente
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function with(): array
    {
        return [
            'chirps' => Chirp::query()
                ->with('user')
                ->when($this->search !== '', fn ($query) => $query->where('message', 'like', "%{$this->search}%"))
                ->latest()
                ->paginate(10),
        ];
    }
};
?>

<div>
    <div class="d-flex flex-column gap-3">
        @forelse ($chirps as $chirp)
            <livewire:chirp :chirp="$chirp" :key="$chirp->id" />
        @empty
            <div class="py-5 text-center">
                <svg class="text-secondary opacity-50" width="48" height="48" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                    </path>
                </svg>
                <p class="text-secondary mt-3">
                    {{ $this->search !== '' ? 'No chirps match your search.' : 'No chirps yet. Be the first to chirp!' }}
                </p>
            </div>
        @endforelse

        {{ $chirps->links('pagination::bootstrap-5') }}
    </div>

</div>
