@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
    <!-- About Hero -->
    <section class="about-hero" style="padding-top: 150px; padding-bottom: 100px; background: var(--bg-alt); position: relative; overflow: hidden;">
        <div class="container">
            <div class="hero-grid" style="align-items: center;">
                <div class="hero-content animate-on-scroll">
                    <span style="color: var(--primary); font-weight: 700; text-transform: uppercase; letter-spacing: 2px; font-size: 0.875rem;">Misi & Visi Kami</span>
                    <h1 style="font-size: 3.5rem; margin: 1rem 0 2rem;">Wujudkan Hidup Sehat dengan <span>Mudah & Nikmat</span></h1>
                    <p style="font-size: 1.125rem; color: var(--text-muted); line-height: 1.8;">NutriBox lahir dari keinginan untuk membantu masyarakat Indonesia mendapatkan nutrisi terbaik di tengah kesibukan sehari-hari. Kami percaya bahwa makanan sehat tidak harus membosankan atau sulit didapat.</p>
                </div>
                <div class="hero-image animate-on-scroll">
                    <img src="{{ asset('images/hero.png') }}" alt="NutriBox Mission" style="border-radius: 40px; box-shadow: var(--shadow-premium);">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats" style="padding: 80px 0; background: var(--white);">
        <div class="container">
            <div class="feature-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); text-align: center;">
                <div class="stat-card animate-on-scroll">
                    <h2 style="font-size: 3.5rem; color: var(--primary);">2024</h2>
                    <p style="text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); font-size: 0.875rem; font-weight: 600;">Berdiri Sejak</p>
                </div>
                <div class="stat-card animate-on-scroll" style="border-left: 1px solid var(--border); border-right: 1px solid var(--border);">
                    <h2 style="font-size: 3.5rem; color: var(--primary);">5k+</h2>
                    <p style="text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); font-size: 0.875rem; font-weight: 600;">Porsi per Bulan</p>
                </div>
                <div class="stat-card animate-on-scroll" style="border-right: 1px solid var(--border);">
                    <h2 style="font-size: 3.5rem; color: var(--primary);">15+</h2>
                    <h2 style="font-size: 3.5rem; color: var(--primary);">15+</h2>
                    <p style="text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); font-size: 0.875rem; font-weight: 600;">Mitra Petani Lokal</p>
                </div>
                <div class="stat-card animate-on-scroll">
                    <h2 style="font-size: 3.5rem; color: var(--primary);">98%</h2>
                    <p style="text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); font-size: 0.875rem; font-weight: 600;">Kepuasan Pelanggan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Story Section -->
    <section class="story" style="background: var(--bg-alt);">
        <div class="container">
            <div class="hero-grid" style="direction: rtl;">
                <div class="hero-content animate-on-scroll" style="direction: ltr;">
                    <h2 class="section-title" style="text-align: left;">Filosofi dari <span>Dapur Kami</span></h2>
                    <p style="margin-bottom: 1.5rem;">Kami tidak hanya sekadar mengantar makanan. Kami mengawasi setiap proses mulai dari pemilihan benih di tanah petani mitra kami hingga saat makanan hangat sampai di meja makan Anda.</p>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 2rem;">
                        <div style="display: flex; gap: 1rem; align-items: flex-start;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0;"><i class="fas fa-check" style="font-size: 0.75rem;"></i></div>
                            <div>
                                <h4 style="font-size: 1rem; margin-bottom: 0.5rem;">Kualitas Tinggi</h4>
                                <p style="font-size: 0.875rem; color: var(--text-muted);">Hanya bahan organik grade-A yang masuk ke dapur kami.</p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 1rem; align-items: flex-start;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0;"><i class="fas fa-check" style="font-size: 0.75rem;"></i></div>
                            <div>
                                <h4 style="font-size: 1rem; margin-bottom: 0.5rem;">Ahli Nutrisi</h4>
                                <p style="font-size: 0.875rem; color: var(--text-muted);">Setiap menu divalidasi oleh nutritionist bersertifikat.</p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 1rem; align-items: flex-start;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0;"><i class="fas fa-check" style="font-size: 0.75rem;"></i></div>
                            <div>
                                <h4 style="font-size: 1rem; margin-bottom: 0.5rem;">Ramah Lingkungan</h4>
                                <p style="font-size: 0.875rem; color: var(--text-muted);">Pengemasan minimal plastik dan dapat didaur ulang.</p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 1rem; align-items: flex-start;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0;"><i class="fas fa-check" style="font-size: 0.75rem;"></i></div>
                            <div>
                                <h4 style="font-size: 1rem; margin-bottom: 0.5rem;">Local Support</h4>
                                <p style="font-size: 0.875rem; color: var(--text-muted);">Memberdayakan petani lokal melalui kemitraan adil.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-image animate-on-scroll">
                    <img src="{{ asset('images/hero.png') }}" alt="NutriBox Team" style="border-radius: 40px; transform: scaleX(-1);">
                </div>
            </div>
        </div>
    </section>
@endsection
