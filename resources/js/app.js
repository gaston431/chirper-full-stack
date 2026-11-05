import $ from 'jquery';
import 'bootstrap';

window.$ = window.jQuery = $;

$(function () {
    const searchForm = $('#chirp-search-form');
    const searchInput = $('#search');
    const clearSearchButton = $('#clear-search');
    const chirpResults = $('#chirp-results');
    const searchError = $('#chirp-search-error');

    if (
        !searchForm.length
        || !searchInput.length
        || !clearSearchButton.length
        || !chirpResults.length
        || !searchError.length
    ) {
        return;
    }

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

    const loadChirps = (requestUrl = null) => {
        activeRequest?.abort();

        chirpResults.attr('aria-busy', 'true');
        searchError.prop('hidden', true);
        clearSearchButton.prop('disabled', !searchInput.val().trim());

        const url = requestUrl ?? new URL(searchForm.data('search-url'), window.location.origin);

        if (!requestUrl) {
            const search = searchInput.val().trim();

            if (search) {
                url.searchParams.set('search', search);
            } else {
                url.searchParams.delete('search');
            }

            url.searchParams.delete('page');
        }

        const request = $.ajax({
            url: url.toString(),
            method: 'GET',
            dataType: 'html',
            headers: {
                Accept: 'application/json, text/html',
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

        activeRequest = request;

        request.done((html) => {
            chirpResults.html(html);

            const search = url.searchParams.get('search') ?? '';
            searchInput.val(search);
            clearSearchButton.prop('disabled', search === '');
            updateBrowserUrl(search, url.searchParams.get('page'));
        });

        request.fail((xhr, status) => {
            if (status === 'abort') {
                return;
            }

            const message = xhr.responseJSON?.errors?.search?.[0]
                ?? xhr.responseJSON?.message
                ?? 'Unable to load chirps. Please try again.';

            searchError
                .text(message)
                .removeClass('d-none')
                .addClass('alert alert-danger mt-4')
                .prop('hidden', false);
        });

        request.always(() => {
            if (activeRequest === request) {
                activeRequest = null;
                chirpResults.attr('aria-busy', 'false');
            }
        });
    };

    searchInput.on('input', () => {
        window.clearTimeout(debounceTimeout);
        clearSearchButton.prop('disabled', !searchInput.val().trim());
        debounceTimeout = window.setTimeout(() => loadChirps(), 300);
    });

    // searchForm.on('submit', (event) => {
    //     event.preventDefault();
    //     window.clearTimeout(debounceTimeout);
    //     loadChirps();
    // });

    clearSearchButton.on('click', () => {
        window.clearTimeout(debounceTimeout);
        searchInput.val('');
        loadChirps();
        searchInput.trigger('focus');
    });

    chirpResults.on('click', '.pagination a[href]', function (event) {
        const clickedUrl = new URL(this.href);

        if (clickedUrl.origin !== window.location.origin) {
            return;
        }

        const url = new URL(searchForm.data('search-url'), window.location.origin);
        const search = searchInput.val().trim();
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
});
