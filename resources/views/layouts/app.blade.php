<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NutriBox') — Langganan Makanan Sehat</title>
    <meta name="description" content="@yield('meta_description', 'NutriBox - Platform langganan makanan sehat terbaik di Indonesia. Makanan organik, bergizi, dan praktis diantar ke rumah Anda.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="mainNav">
        <div class="container nav-container">
            <a href="{{ route('home') }}" class="nav-brand">
                <div class="brand-icon">
                    <i class="fas fa-seedling"></i>
                </div>
                <span>Nutri<strong>Box</strong></span>
            </a>

            <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
                <span></span><span></span><span></span>
            </button>

            <div class="nav-menu" id="navMenu">
                <ul class="nav-links">
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
                    <li><a href="{{ route('menu') }}" class="{{ request()->routeIs('menu') ? 'active' : '' }}">Menu</a></li>
                    <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">Tentang</a></li>
                    <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Kontak</a></li>
                </ul>

                <div class="nav-actions">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-shield-halved"></i> Admin
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-grid-2"></i> Dashboard
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-ghost btn-sm">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="flash-message flash-success" id="flashMessage">
        <div class="container">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="flash-close"><i class="fas fa-times"></i></button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="flash-message flash-error" id="flashMessage">
        <div class="container">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="flash-close"><i class="fas fa-times"></i></button>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="footer-logo">
                        <div class="brand-icon"><i class="fas fa-seedling"></i></div>
                        <span>Nutri<strong>Box</strong></span>
                    </div>
                    <p>Platform langganan makanan sehat terbaik di Indonesia. Makanan organik, bergizi, dan praktis diantar langsung ke rumah Anda.</p>
                    <div class="footer-socials">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <div class="footer-links">
                    <h4>Menu</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('menu') }}">Paket Langganan</a></li>
                        <li><a href="{{ route('about') }}">Tentang Kami</a></li>
                        <li><a href="{{ route('contact') }}">Hubungi Kami</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Layanan</h4>
                    <ul>
                        <li><a href="#">Konsultasi Gizi</a></li>
                        <li><a href="#">Meal Planning</a></li>
                        <li><a href="#">Corporate Catering</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h4>Kontak</h4>
                    <div class="contact-line"><i class="fas fa-envelope"></i> info@nutribox.id</div>
                    <div class="contact-line"><i class="fas fa-phone"></i> (021) 1234-5678</div>
                    <div class="contact-line"><i class="fab fa-whatsapp"></i> +62 812-3456-7890</div>
                    <div class="contact-line"><i class="fas fa-location-dot"></i> Jakarta Selatan, Indonesia</div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} NutriBox by GorryWell. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('mainNav');
            nav.classList.toggle('scrolled', window.scrollY > 50);
        });

        // Mobile menu toggle
        document.getElementById('navToggle').addEventListener('click', () => {
            document.getElementById('navMenu').classList.toggle('active');
            document.getElementById('navToggle').classList.toggle('active');
        });

        // Auto-hide flash messages
        setTimeout(() => {
            const flash = document.getElementById('flashMessage');
            if (flash) flash.style.opacity = '0';
            setTimeout(() => { if (flash) flash.remove(); }, 300);
        }, 5000);

        // Scroll animations
        const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
    </script>
    @stack('scripts')
</body>
</html>
