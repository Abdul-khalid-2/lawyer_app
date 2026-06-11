/**
 * Video show — posts watch time to the track-view endpoint every 30s and on
 * unload. Reads config from the [data-video-track-url] element; no-op without it.
 */
export default function initVideoShow() {
    const el = document.querySelector('[data-video-track-url]');
    if (!el) return;

    const url = el.dataset.videoTrackUrl;
    const duration = parseInt(el.dataset.videoDuration || '0', 10);
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

    let watchStartTime = Date.now();
    let watchInterval;

    const sendWatchTime = () => {
        const watchTime = Math.floor((Date.now() - watchStartTime) / 1000);
        const actualWatchTime = duration > 0 ? Math.min(watchTime, duration) : watchTime;

        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify({
                watch_time: actualWatchTime,
                completed: duration > 0 ? actualWatchTime >= duration * 0.9 : false,
            }),
            keepalive: true,
        }).catch(() => {});
    };

    watchInterval = setInterval(sendWatchTime, 30000);
    window.addEventListener('beforeunload', () => {
        clearInterval(watchInterval);
        sendWatchTime();
    });
}
