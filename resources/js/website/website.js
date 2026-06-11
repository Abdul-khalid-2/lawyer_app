/**
 * Website bundle — single Vite entry for the public site.
 * Page-specific modules self-guard (no-op when their elements aren't present),
 * so one bundle serves every page.
 */
import initFlashMessages from './modules/flash-messages';
import AuthManager from './modules/auth-manager';
import initTrackTime from './modules/track-time';
import initLoadMore from './modules/load-more';
import initComments from './modules/comments';
import initLawyerProfile from './pages/lawyer-profile';
import initVideoShow from './pages/video-show';

document.addEventListener('DOMContentLoaded', () => {
    initFlashMessages();
    new AuthManager().init();
    initTrackTime();
    initLoadMore();
    initComments();
    initLawyerProfile();
    initVideoShow();
});
