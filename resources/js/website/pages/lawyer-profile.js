/**
 * Lawyer profile — review form rating labels, char counter, validation.
 * No-op unless the review form (#reviewForm) is on the page.
 */
export default function initLawyerProfile() {
    const reviewForm = document.getElementById('reviewForm');
    const ratingInputs = document.querySelectorAll('.rating-input input[type="radio"]');
    const ratingText = document.getElementById('ratingText');
    const reviewTextarea = document.getElementById('review');
    const charCount = document.getElementById('charCount');

    if (!ratingInputs.length && !reviewForm) return;

    const ratingLabels = { 1: 'Poor', 2: 'Fair', 3: 'Good', 4: 'Very Good', 5: 'Excellent' };

    ratingInputs.forEach((input) => {
        input.addEventListener('mouseenter', function () {
            if (ratingText) ratingText.textContent = ratingLabels[this.value];
        });
        input.addEventListener('change', function () {
            if (ratingText) {
                ratingText.textContent = ratingLabels[this.value];
                ratingText.className = 'text-success fw-bold';
            }
        });
    });

    if (reviewTextarea && charCount) {
        reviewTextarea.addEventListener('input', function () {
            let length = this.value.length;
            if (length > 500) {
                this.value = this.value.substring(0, 500);
                length = 500;
            }
            charCount.textContent = length;
            charCount.className = length > 450 ? 'char-count-warning' : (length > 0 ? 'char-count-success' : '');
        });
        charCount.textContent = reviewTextarea.value.length;
    }

    if (reviewForm) {
        reviewForm.addEventListener('submit', function (e) {
            const rating = document.querySelector('input[name="rating"]:checked');
            const review = (document.getElementById('review')?.value || '').trim();

            if (!rating) { e.preventDefault(); alert('Please select a rating'); return; }
            if (!review) { e.preventDefault(); alert('Please write your review'); return; }
            if (review.length < 10) {
                e.preventDefault();
                alert('Please write a more detailed review (at least 10 characters)');
                return;
            }

            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Submitting...';
                submitBtn.disabled = true;
            }
        });
    }
}
