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
                        <textarea name="message" placeholder="What's on your mind?"
                            class="form-control chirp-textarea @error('message') is-invalid @enderror" rows="4" required>{{ old('message') }}</textarea>

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

        <form method="GET" action="{{ route('home') }}" class="mt-4" id="chirp-search-form"
            data-search-url="{{ route('chirps.search') }}">
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

    {{-- <script type="module">
        const div = document.getElementById('container')
        const API_URL = 'http://localhost:8000/getChirps'
        const inputSearch = document.getElementById('search')
        // let chirps = []
        let search = inputSearch.value ?? ''
        const loadChirps = async (search) => {
            try {
                const response = await fetch(API_URL + "?search=" + encodeURIComponent(search))
                // console.log(response.ok)
                if (!response.ok) throw new Error('Error al obtener chirps')
                // return await response.json()
                const htmlContent = await response.text()
                // console.log(htmlContent)
                div.innerHTML = htmlContent
            } catch (error) {
                console.error(error)
                alert('No se pudo conectar con la API')
            }
        }

        await loadChirps(search)

        inputSearch.addEventListener('input', async function(){
            await loadChirps(inputSearch.value)
        })

    </script> --}}
</x-layout>
