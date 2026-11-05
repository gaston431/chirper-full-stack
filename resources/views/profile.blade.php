<x-layout>
    <x-slot:title>
        Profile
    </x-slot:title>

    <div class="col-lg-8 col-xl-7 mx-auto">
        <h1 class="fs-2 fw-bold mt-4">Latest Chirps {{ $user->name }}</h1>

        <form method="GET" action="{{ route('profile', $user) }}" class="mt-4" id="chirp-search-form"
            data-search-url="{{ route('user.chirps.search', $user) }}">
            <label for="search" class="form-label">Search chirps</label>
            <div class="input-group">
                <input type="search" name="search" id="search" value="{{ $search }}"
                    placeholder="Filter by message" class="form-control" maxlength="100">
                
                <button type="button" class="btn btn-outline-secondary" id="clear-search"
                    @disabled($search === '')>Clear</button>
            </div>
        </form>

        <div class="mt-4" id="chirp-search-error" role="alert" hidden></div>
        <div id="chirp-results" aria-live="polite" aria-busy="false">
            @include('components.chirp-list', ['chirps' => $chirps, 'search' => $search])
        </div>
    </div>

</x-layout>
