<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Primary Meta Tags -->
    <title>Law-Skoolyst - Find the Right Lawyer & Legal Expert for Your Case</title>
    <meta name="description" content="Connect with verified lawyers, legal experts, and attorneys. Get professional legal advice, case consultation, and find the perfect lawyer for your specific needs.">
    <meta name="keywords" content="lawyer, legal advice, attorney, law firm, legal consultation, find lawyer, legal expert, case lawyer, legal services, law consultation, legal help, lawyer directory, legal professionals">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="Law-Skoolyst - Find the Right Lawyer & Legal Expert">
    <meta property="og:description" content="Connect with verified lawyers and legal experts. Get professional legal advice and find the perfect lawyer for your case.">
    <meta property="og:image" content="{{ asset('website/images/og-image.jpg') }}">
    <meta property="og:site_name" content="Law-Skoolyst">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="Law-Skoolyst - Find the Right Lawyer & Legal Expert">
    <meta property="twitter:description" content="Connect with verified lawyers and legal experts. Get professional legal advice for your legal needs.">
    <meta property="twitter:image" content="{{ asset('website/images/twitter-image.jpg') }}">
    
    <!-- Additional SEO Meta Tags -->
    <meta name="author" content="Law-Skoolyst">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="theme-color" content="#2c3e50">
    <meta name="msapplication-TileColor" content="#2c3e50">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Structured Data / JSON-LD -->
    <script type="application/ld+json">
        @php
        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'LegalService',
            'name' => 'Law-Skoolyst',
            'description' => 'Professional legal services and lawyer directory platform',
            'url' => url('/'),
            'logo' => asset('website/images/logo.png'),
            'address' => [
                '@type' => 'PostalAddress',
                'addressCountry' => 'US'
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'customer service',
                'availableLanguage' => 'English'
            ],
            'sameAs' => [
                'https://www.facebook.com/lawskoolyst',
                'https://www.twitter.com/lawskoolyst',
                'https://www.linkedin.com/company/lawskoolyst'
            ]
        ];
        @endphp
        @json($structuredData)
    </script>

    <!-- Favicon Configuration -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('favicon/safari-pinned-tab.svg') }}" color="#2c3e50">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <meta name="msapplication-TileColor" content="#2c3e50">
    <meta name="msapplication-config" content="{{ asset('favicon/browserconfig.xml') }}">
    <meta name="theme-color" content="#2c3e50">

    <!-- Preload Critical Resources -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    
    <!-- DNS Prefetch -->
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="//fonts.googleapis.com">

    <!-- CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('website/css/global.css') }}">

    @stack('css')


</head>

<body>

    @include('website.layout.navigation')

    @yield('content')

    @include('website.layout.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            @endif

            // Check for error message
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>

    <script>
        // public/js/auth.js
        class AuthManager {
            init() {
                this.setupLoginForms();
            }

            setupLoginForms() {
                // Setup all login forms on the page
                document.querySelectorAll('form[action*="login"]').forEach(form => {
                    form.addEventListener('submit', (e) => {
                        e.preventDefault();
                        this.handleLogin(form);
                    });
                });
            }

            async handleLogin(form) {
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;

                // Show loading
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Logging in...';

                try {
                    const formData = new FormData(form);

                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        window.location.href = data.redirect;
                    } else {
                        this.showError(data.message || 'Login failed');
                    }

                } catch (error) {
                    this.showError('Network error. Please try again.');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            }

            showError(message) {
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: message,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            }
        }
        document.addEventListener('DOMContentLoaded', () => {
            new AuthManager().init();
        });
    </script>

    @stack('js')

</body>

</html>