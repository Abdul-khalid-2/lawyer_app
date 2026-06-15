<!-- Footer -->
<footer class="footer mt-auto">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
        <p class="text-muted mb-0">&copy; {{ date('Y') }} Law-Skoolyst. All rights reserved.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('website.page', 'privacy-policy') }}" class="text-muted text-decoration-none" target="_blank" rel="noopener">Privacy Policy</a>
            <a href="{{ route('website.page', 'terms-of-service') }}" class="text-muted text-decoration-none" target="_blank" rel="noopener">Terms of Service</a>
            <a href="{{ route('website.page', 'faq') }}" class="text-muted text-decoration-none" target="_blank" rel="noopener">Support</a>
        </div>
    </div>
</footer>

<!-- Bootstrap JS (needed for dropdowns/modals/tooltips; sidebar logic lives in the dashboard JS bundle) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
