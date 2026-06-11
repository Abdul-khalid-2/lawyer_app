/**
 * View-time tracking — posts elapsed seconds to a tracking endpoint.
 * Activates only when <body data-track-url="..."> is present, so it is a
 * no-op on pages that don't track (the whole bundle stays one file).
 */
export default function initTrackTime() {
    const url = document.body.dataset.trackUrl;
    if (!url) return;

    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    const startTime = Date.now();
    let timer;

    const post = (seconds, keepalive = false) => {
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
            },
            body: JSON.stringify({ time_spent: seconds }),
            keepalive,
        }).catch(() => {});
    };

    timer = setInterval(() => {
        post(Math.floor((Date.now() - startTime) / 1000));
    }, 30000);

    window.addEventListener('beforeunload', () => {
        clearInterval(timer);
        post(Math.floor((Date.now() - startTime) / 1000), true);
    });
}
