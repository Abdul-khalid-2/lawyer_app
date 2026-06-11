/**
 * Lawyers "load more" + filters + infinite scroll.
 * Activates only when #lawyersContainer[data-load-more-url] is present.
 */
export default function initLoadMore() {
    const container = document.getElementById('lawyersContainer');
    const url = container?.dataset.loadMoreUrl;
    if (!container || !url) return;

    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    const spinner = document.getElementById('loadingSpinner');
    const noMore = document.getElementById('noMoreMessage');
    const specInput = document.getElementById('specializationFilter');
    const locInput = document.getElementById('locationFilter');
    const applyBtn = document.getElementById('applyFilters');

    let skip = container.children.length;
    let isLoading = false;
    let hasMore = container.children.length >= 10;
    let currentSpecialization = specInput?.value || '';
    let currentLocation = locInput?.value || '';

    function resetAndLoad() {
        skip = 0;
        hasMore = true;
        isLoading = false;
        container.innerHTML = '';
        noMore?.classList.add('d-none');
        loadLawyers(0);
    }

    function loadLawyers(currentSkip = skip) {
        if (isLoading || !hasMore) return;
        isLoading = true;
        spinner?.classList.remove('d-none');

        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify({
                skip: currentSkip,
                specialization: currentSpecialization,
                location: currentLocation,
            }),
        })
            .then((res) => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then((data) => {
                if (data.html && data.html.trim() !== '') {
                    container.insertAdjacentHTML('beforeend', data.html);
                }
                hasMore = data.hasMore;
                skip = data.nextSkip;

                if (currentSkip === 0 && container.children.length === 0) {
                    container.innerHTML =
                        '<div class="col-12 text-center"><p class="text-muted">No lawyers found matching your criteria.</p></div>';
                }
                if (!hasMore && currentSkip > 0) {
                    noMore?.classList.remove('d-none');
                }
            })
            .catch(() => {
                hasMore = false;
                if (currentSkip === 0) {
                    container.innerHTML =
                        '<div class="col-12 text-center"><p class="text-danger">Error loading lawyers. Please try again.</p></div>';
                }
            })
            .finally(() => {
                isLoading = false;
                spinner?.classList.add('d-none');
            });
    }

    applyBtn?.addEventListener('click', () => {
        currentSpecialization = specInput?.value || '';
        currentLocation = locInput?.value || '';
        resetAndLoad();
    });

    locInput?.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') applyBtn?.click();
    });

    window.addEventListener('scroll', () => {
        if (!hasMore || isLoading) return;
        const { scrollTop, scrollHeight, clientHeight } = document.documentElement;
        if (scrollTop + clientHeight >= scrollHeight - 300) {
            loadLawyers();
        }
    });
}
