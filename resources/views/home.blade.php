@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div class="hero-content animate-on-scroll">
                <h1>Nutrisi Terbaik untuk <span>Gaya Hidup</span> Anda</h1>
                <p>Makan sehat jadi lebih mudah dengan NutriBox. Menu koki profesional, bahan organik, dan diantar langsung ke depan pintu Anda.</p>
                <div class="hero-btns">
                    <a href="{{ route('menu') }}" class="btn btn-primary">Lihat Paket</a>
                    <a href="{{ route('about') }}" class="btn btn-ghost">Pelajari Lebih Lanjut</a>
                </div>
                <div class="hero-stats" style="display: flex; gap: 2rem; margin-top: 3rem;">
                    <div class="stat-item">
                        <h3 style="font-size: 1.5rem; color: var(--primary);">2.5k+</h3>
                        <p style="font-size: 0.875rem; color: var(--text-muted);">Pelanggan Aktif</p>
                    </div>
                    <div class="stat-item">
                        <h3 style="font-size: 1.5rem; color: var(--primary);">50+</h3>
                        <p style="font-size: 0.875rem; color: var(--text-muted);">Menu Variatif</p>
                    </div>
                    <div class="stat-item">
                        <h3 style="font-size: 1.5rem; color: var(--primary);">100%</h3>
                        <p style="font-size: 0.875rem; color: var(--text-muted);">Bahan Organik</p>
                    </div>
                </div>
            </div>
            <div class="hero-image animate-on-scroll">
                <img src="{{ asset('images/hero.png') }}" alt="NutriBox Healthy Meal">
                <div class="floating-card" style="position: absolute; bottom: 30px; left: -20px; background: white; padding: 1rem; border-radius: 16px; box-shadow: var(--shadow-lg); display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #fbbf24; color: white; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <h4 style="margin: 0; font-size: 0.875rem;">Premium Quality</h4>
                        <p style="margin: 0; font-size: 0.75rem; color: var(--text-muted);">Sertifikasi Halal & BPOM</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2 class="section-title">Mengapa Memilih <span>NutriBox</span>?</h2>
                <p>Kami berkomitmen memberikan pengalaman makan sehat yang tak tertandingi dengan kemudahan proses pesanan.</p>
            </div>
            <div class="feature-grid">
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon-wrapper">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Bahan Segar Organik</h3>
                    <p>Kami hanya menggunakan bahan-bahan segar dari petani lokal yang teruji kualitasnya.</p>
                </div>
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon-wrapper">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h3>Koki Profesional</h3>
                    <p>Menu kami diracik oleh koki berpengalaman dan ahli gizi bersertifikat.</p>
                </div>
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon-wrapper">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h3>Pengiriman Tepat Waktu</h3>
                    <p>Makanan sampai di tangan Anda dalam kondisi segar dan siap santap.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Plans Preview -->
    <section class="plans-preview" style="background: var(--bg-alt);">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2 class="section-title">Pilih <span>Paket Sesuai Kebutuhan</span> Anda</h2>
                <p>Tersedia berbagai pilihan paket yang dapat disesuaikan dengan tujuan kesehatan Anda.</p>
            </div>
            <div class="feature-grid" style="grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));">
                @foreach ($plans as $plan)
                    <div class="feature-card animate-on-scroll" style="display: flex; flex-direction: column; height: 100%;">
                        <div style="margin-bottom: 2rem;">
                            <span style="background: var(--primary-light); color: var(--primary); padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">{{ $plan->name }}</span>
                            <h3 style="margin: 1rem 0 0.5rem; font-size: 1.75rem;">Rp {{ number_format($plan->price_per_week, 0, ',', '.') }}<span style="font-size: 0.875rem; color: var(--text-muted); font-weight: 400;">/minggu</span></h3>
                            <p style="color: var(--text-muted); font-size: 0.875rem;">{{ $plan->description }}</p>
                        </div>
                        <ul style="flex-grow: 1; margin-bottom: 2rem;">
                            @foreach ($plan->features as $feature)
                                <li style="margin-bottom: 0.75rem; font-size: 0.875rem; display: flex; align-items: flex-start; gap: 0.75rem;">
                                    <i class="fas fa-check-circle" style="color: var(--primary); margin-top: 0.25rem;"></i>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('order.create', ['plan' => $plan->name]) }}" class="btn btn-primary" style="width: 100%;">Mulai Sekarang</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2 class="section-title">Apa Kata <span>Mereka</span>?</h2>
                <p>Customer kami yang telah merasakan manfaat dari pola makan sehat NutriBox.</p>
            </div>
            <div class="feature-grid">
                @foreach ($testimonials as $testimonial)
                    <div class="feature-card animate-on-scroll">
                        <div class="quote-icon" style="font-size: 2rem; color: var(--primary-light); opacity: 0.5; margin-bottom: 1rem;">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p style="font-style: italic; margin-bottom: 2rem; color: var(--text-main);">"{{ $testimonial['message'] }}"</p>
                        <div class="client-info" style="display: flex; align-items: center; gap: 1rem;">
                            <div class="client-avatar" style="width: 50px; height: 50px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem;">
                                {{ $testimonial['avatar'] }}
                            </div>
                            <div>
                                <h4 style="margin: 0; font-size: 1rem;">{{ $testimonial['name'] }}</h4>
                                <p style="margin: 0; font-size: 0.75rem; color: var(--text-muted);">{{ $testimonial['role'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta" style="padding: 100px 0;">
        <div class="container">
            <div style="background: var(--secondary); border-radius: 30px; padding: 5rem 3rem; text-align: center; color: white; position: relative; overflow: hidden;">
                <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: var(--primary); opacity: 0.1; border-radius: 50%;"></div>
                <div style="position: absolute; bottom: -50px; left: -50px; width: 150px; height: 150px; background: var(--primary); opacity: 0.1; border-radius: 50%;"></div>
                
                <h2 style="color: white; font-size: 3rem; margin-bottom: 1.5rem;">Siap Memulai Hidup Sehat?</h2>
                <p style="color: #94a3b8; font-size: 1.25rem; max-width: 600px; margin: 0 auto 3rem;">Bergabunglah dengan ribuan orang lainnya yang telah memilih NutriBox untuk kualitas hidup yang lebih baik.</p>
                <div style="display: flex; gap: 1.25rem; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 1rem 2.5rem;">Daftar Sekarang</a>
                    <a href="{{ route('contact') }}" class="btn btn-outline" style="border-color: rgba(255,255,255,0.2); color: white; padding: 1rem 2.5rem;">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>
@endsection
