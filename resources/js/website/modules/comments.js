/**
 * Blog comments — reply targeting (sets parent_id, focuses & scrolls to the
 * comment form) and cancel-reply. No-op unless reply buttons are present.
 */
export default function initComments() {
    const replyButtons = document.querySelectorAll('.reply-btn');
    if (!replyButtons.length) return;

    replyButtons.forEach((button) => {
        button.addEventListener('click', function () {
            const commentId = this.dataset.commentId;
            const parentInput = document.getElementById('parent_id');
            if (parentInput) parentInput.value = commentId;

            document.getElementById('comment')?.focus();
            document.querySelector('.comment-form')?.scrollIntoView({ behavior: 'smooth' });
        });
    });

    document.querySelector('.cancel-reply')?.addEventListener('click', () => {
        const parentInput = document.getElementById('parent_id');
        if (parentInput) parentInput.value = '';
    });
}
