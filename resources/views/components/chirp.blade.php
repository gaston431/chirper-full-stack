@props(['chirp'])

<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex gap-3">
            @if ($chirp->user)
                <img src="https://avatars.laravel.cloud/{{ urlencode($chirp->user->email) }}"
                    alt="{{ $chirp->user->name }}'s avatar" class="chirp-avatar rounded-circle flex-shrink-0" />
            @else
                <img src="https://avatars.laravel.cloud/f61123d5-0b27-434c-a4ae-c653c7fc9ed6?vibe=stealth"
                    alt="Anonymous User" class="chirp-avatar rounded-circle flex-shrink-0" />
            @endif

            <div class="flex-grow-1 chirp-content">
                <div class="d-flex justify-content-between align-items-start gap-2 w-100">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        @if($chirp->user)
                            <a href="{{ route('profile', $chirp->user) }}" class="small fw-semibold text-decoration-none text-reset"> 
                                {{ $chirp->user->name }}
                            </a>
                        @else
                            <span class="small fw-semibold">Anonymous</span>
                        @endif
                        
                        <span class="text-secondary">·</span>
                        <span class="small text-secondary">{{ $chirp->created_at->diffForHumans() }}</span>
                        @if ($chirp->updated_at->gt($chirp->created_at->addSeconds(5)))
                            <span class="text-secondary">·</span>
                            <span class="small text-secondary fst-italic">edited</span>
                        @endif
                    </div>

                    @can('update', $chirp)
                        <div class="d-flex gap-1 flex-shrink-0">
                            <a href="/chirps/{{ $chirp->id }}/edit" class="btn btn-outline-secondary btn-sm">
                                Edit
                            </a>
                            <form method="POST" action="/chirps/{{ $chirp->id }}" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this chirp?')"
                                    class="btn btn-outline-danger btn-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
                <p class="mt-2 mb-0 text-break">{{ $chirp->message }}</p>
            </div>
        </div>
    </div>
</div>
