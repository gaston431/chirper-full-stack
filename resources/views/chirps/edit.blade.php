<x-layout>
    <x-slot:title>
        Edit Chirp
    </x-slot:title>

    <div class="col-lg-8 col-xl-7 mx-auto">
        <h1 class="fs-2 fw-bold mt-4">Edit Chirp</h1>

        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <form method="POST" action="/chirps/{{ $chirp->id }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <textarea
                            name="message"
                            class="form-control chirp-textarea @error('message') is-invalid @enderror"
                            rows="4"
                            maxlength="255"
                            required
                        >{{ old('message', $chirp->message) }}</textarea>

                        @error('message')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="/" class="btn btn-outline-secondary btn-sm">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm">Update Chirp</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>