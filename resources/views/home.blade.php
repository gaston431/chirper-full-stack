<x-layout>
    <x-slot:title>
        Home Feed
    </x-slot:title>

    <div class="col-lg-8 col-xl-7 mx-auto">
        <h1 class="fs-2 fw-bold mt-4">Latest Chirps</h1>

        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <form method="POST" action="/chirps">
                    @csrf
                    <div>
                        <textarea
                            name="message"
                            placeholder="What's on your mind?"
                            class="form-control chirp-textarea @error('message') is-invalid @enderror"
                            rows="4"
                            required
                        >{{ old('message') }}</textarea>

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

        <div class="d-flex flex-column gap-3 mt-4">
            @forelse ($chirps as $chirp)
                <x-chirp :chirp="$chirp" />
            @empty
                <div class="py-5 text-center">
                    <svg class="text-secondary opacity-50" width="48" height="48" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                        </path>
                    </svg>
                    <p class="text-secondary mt-3">No chirps yet. Be the first to chirp!</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>
