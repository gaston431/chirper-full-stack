import 'bootstrap';

const searchForm = document.getElementById('chirp-search-form');
const searchInput = document.getElementById('search');
const clearSearchButton = document.getElementById('clear-search');
const chirpResults = document.getElementById('chirp-results');
const searchError = document.getElementById('chirp-search-error');

if (searchForm && searchInput && clearSearchButton && chirpResults && searchError) {
    let debounceTimeout;
    let activeRequest;

    const updateBrowserUrl = (search, page = null) => {
        const url = new URL(window.location.href);

        if (search) {
            url.searchParams.set('search', search);
        } else {
            url.searchParams.delete('search');
        }

        if (page && page !== '1') {
            url.searchParams.set('page', page);
        } else {
            url.searchParams.delete('page');
        }

        window.history.replaceState(null, '', url);
    };

    const loadChirps = async (requestUrl = null) => {
        activeRequest?.abort();

        const controller = new AbortController();
        activeRequest = controller;
        chirpResults.setAttribute('aria-busy', 'true');
        searchError.hidden = true;
        clearSearchButton.disabled = searchInput.value.trim() === '';

        const url = requestUrl ?? new URL(searchForm.dataset.searchUrl, window.location.origin);
        // console.log(url)
        if (!requestUrl) {
            const search = searchInput.value.trim();

            if (search) {
                url.searchParams.set('search', search);
            } else {
                url.searchParams.delete('search');
            }

            url.searchParams.delete('page');
        }

        try {
            const response = await fetch(url, {
                headers: {
                    Accept: 'application/json, text/html',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                signal: controller.signal,
            });

            if (!response.ok) {
                let message = 'Unable to load chirps. Please try again.';

                if (response.headers.get('content-type')?.includes('application/json')) {
                    const payload = await response.json();
                    message = payload.errors?.search?.[0] ?? payload.message ?? message;
                }

                throw new Error(message);
            }

            chirpResults.innerHTML = await response.text();

            const search = url.searchParams.get('search') ?? '';
            searchInput.value = search;
            clearSearchButton.disabled = search === '';
            updateBrowserUrl(search, url.searchParams.get('page'));
        } catch (error) {
            if (error.name !== 'AbortError') {
                searchError.textContent = error.message;
                searchError.className = 'alert alert-danger mt-4';
                searchError.hidden = false;
            }
        } finally {
            if (activeRequest === controller) {
                activeRequest = null;
                chirpResults.setAttribute('aria-busy', 'false');
            }
        }
    };

    searchInput.addEventListener('input', () => {
        window.clearTimeout(debounceTimeout);
        clearSearchButton.disabled = searchInput.value.trim() === '';
        debounceTimeout = window.setTimeout(() => loadChirps(), 300);
    });

    // searchForm.addEventListener('submit', (event) => {
    //     event.preventDefault();
    //     window.clearTimeout(debounceTimeout);
    //     loadChirps();
    // });

    clearSearchButton.addEventListener('click', () => {
        window.clearTimeout(debounceTimeout);
        searchInput.value = '';
        loadChirps();
        searchInput.focus();
    });

    chirpResults.addEventListener('click', (event) => {
        const paginationLink = event.target.closest('.pagination a[href]');

        if (!paginationLink) {
            return;
        }

        const clickedUrl = new URL(paginationLink.href);

        if (clickedUrl.origin !== window.location.origin) {
            return;
        }

        const url = new URL(searchForm.dataset.searchUrl, window.location.origin);
        const search = searchInput.value.trim();
        const page = clickedUrl.searchParams.get('page');

        if (search) {
            url.searchParams.set('search', search);
        }

        if (page) {
            url.searchParams.set('page', page);
        }

        event.preventDefault();
        window.clearTimeout(debounceTimeout);
        loadChirps(url);
    });
}
