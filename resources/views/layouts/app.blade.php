<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <title>@yield('title', 'Sardar Catering | Amsterdam Suites')</title>
    <meta name="description" content="@yield('description', 'Explore Sardar Catering suites in Amsterdam, browse amenities and plan your stay.')">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Sardar Catering Amsterdam">
    <meta property="og:title" content="@yield('title', 'Sardar Catering | Amsterdam Suites')">
    <meta property="og:description" content="@yield('description', 'Explore Sardar Catering suites in Amsterdam, browse amenities and plan your stay.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('favicon.svg') }}">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    @php $cssVersion = filemtime(is_file($cssFile = public_path('css/styles.css')) ? $cssFile : base_path('css/styles.css')); @endphp<link rel="stylesheet" href="{{ asset('css/styles.css') }}?v={{ $cssVersion }}">
    @stack('head')
</head>
<body>
    <a href="#main-content" class="skip-link">Skip to main content</a>
    <div class="utility-bar">
        <div class="container">
            <div class="utility-inner">
                <div class="utility-left">
                    <a href="tel:+31686099826"><i class="fas fa-phone" aria-hidden="true"></i> +31 6 8609 9826</a>
                </div>
                <div class="utility-right">
                    <a href="{{ route('contact') }}" class="util-link">Contact us</a>
                </div>
            </div>
        </div>
    </div>

    <header class="header" id="header">
        <div class="container">
            <div class="header-inner">
                <a href="{{ route('home') }}" class="logo">
                    <span class="logo-icon" aria-hidden="true">SC</span>
                    <span class="logo-text">
                        <span class="logo-name">Sardar Catering</span>
                        <span class="logo-tagline">Amsterdam suites</span>
                    </span>
                </a>
                <nav class="main-nav" id="mainNav" aria-label="Main navigation">
                    <ul class="nav-list">
                        <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Overview</a></li>
                        <li><a href="{{ route('suites') }}" class="nav-link {{ request()->routeIs('suites') ? 'active' : '' }}">Suites</a></li>
                        <li><a href="{{ route('amenities') }}" class="nav-link {{ request()->routeIs('amenities') ? 'active' : '' }}">Amenities</a></li>
                        <li><a href="{{ route('offers') }}" class="nav-link {{ request()->routeIs('offers') ? 'active' : '' }}">Offers</a></li>
                        <li><a href="{{ route('local-area') }}" class="nav-link {{ request()->routeIs('local-area') ? 'active' : '' }}">Local area</a></li>
                        <li><a href="{{ route('photos') }}" class="nav-link {{ request()->routeIs('photos') ? 'active' : '' }}">Photos</a></li>
                        <li><a href="{{ route('groups') }}" class="nav-link {{ request()->routeIs('groups') ? 'active' : '' }}">Groups</a></li>
                    </ul>
                </nav>
                <div class="header-actions">
                    <a href="{{ route('booking') }}" class="btn btn-primary btn-book">View prices</a>
                    <button type="button" class="mobile-toggle" id="mobileToggle" aria-label="Toggle navigation" aria-controls="mainNav" aria-expanded="false"><span></span><span></span><span></span></button>
                </div>
            </div>
        </div>
    </header>

    <main id="main-content" tabindex="-1">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <a href="{{ route('home') }}" class="footer-logo">
                        <span class="logo-icon" aria-hidden="true">SC</span>
                        <span class="logo-name">Sardar Catering</span>
                    </a>
                    <p class="footer-desc">Amsterdam suites</p>
                </div>
                <div class="footer-col">
                    <h4>Explore</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">Overview</a></li>
                        <li><a href="{{ route('suites') }}">Suites</a></li>
                        <li><a href="{{ route('amenities') }}">Amenities</a></li>
                        <li><a href="{{ route('offers') }}">Offers</a></li>
                        <li><a href="{{ route('local-area') }}">Local area</a></li>
                        <li><a href="{{ route('photos') }}">Photos</a></li>
                        <li><a href="{{ route('groups') }}">Groups</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Contact</h4>
                    <div class="footer-contact">
                        <p>Ladogameerhof 174<br>1060RE Amsterdam, Netherlands</p>
                        <p><a href="tel:+31686099826">+31 6 8609 9826</a></p>
                        <p><a href="mailto:contact@bdgss.com">contact@bdgss.com</a></p>
                        <p><a href="{{ route('contact') }}">Contact us</a></p>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Your stay</h4>
                    <div class="footer-contact">
                        <p>Check-in from 15:00</p>
                        <p>Check-out by 11:00</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-inner">
                    <p>&copy; {{ date('Y') }} Sardar Catering. All rights reserved.</p>
                    <p class="footer-legal"><a href="{{ route('terms') }}">Terms</a> · <a href="{{ route('privacy') }}">Privacy</a> · <a href="{{ route('refund') }}">Refund Policy</a></p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>
