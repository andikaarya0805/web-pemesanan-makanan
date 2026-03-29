@extends('layouts.app')

@section('title', 'Menu & Paket Langganan')

@section('content')
    <!-- Menu Header -->
    <section class="menu-header" style="background: var(--secondary); color: white; padding: 120px 0 80px; text-align: center;">
        <div class="container animate-on-scroll">
            <h1 style="color: white; font-size: 3.5rem; margin-bottom: 1.5rem;">Pilih Paket <span>Langganan</span> Anda</h1>
            <p style="color: #94a3b8; font-size: 1.25rem; max-width: 600px; margin: 0 auto;">Dapatkan makanan sehat berkualitas tinggi yang diantar langsung ke rumah Anda setiap hari.</p>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing" style="margin-top: -60px;">
        <div class="container">
            <div class="feature-grid" style="grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));">
                @foreach ($plans as $plan)
                    <div class="feature-card animate-on-scroll" style="display: flex; flex-direction: column; height: 100%; position: relative; {{ $plan->name == 'premium' ? 'border-color: var(--primary); box-shadow: var(--shadow-lg);' : '' }}">
                        @if ($plan->name == 'premium')
                            <div style="position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background: var(--primary); color: white; padding: 0.25rem 1rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Paling Populer</div>
                        @endif
                        <div style="margin-bottom: 2rem;">
                            <h3 style="margin: 0 0 1rem; font-size: 1.75rem; text-transform: capitalize;">{{ $plan->name }}</h3>
                            <h2 style="font-size: 2.5rem; margin-bottom: 0.5rem; color: var(--primary);">Rp {{ number_format($plan->price_per_week, 0, ',', '.') }}<span style="font-size: 1rem; color: var(--text-muted); font-weight: 400;">/minggu</span></h2>
                            <p style="color: var(--text-muted); font-size: 0.95rem;">{{ $plan->description }}</p>
                        </div>
                        <ul style="flex-grow: 1; margin-bottom: 2.5rem; border-top: 1px solid var(--border); padding-top: 2rem;">
                            @foreach ($plan->features as $feature)
                                <li style="margin-bottom: 1rem; font-size: 0.95rem; display: flex; align-items: flex-start; gap: 0.75rem;">
                                    <i class="fas fa-check-circle" style="color: var(--primary); margin-top: 0.25rem;"></i>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('order.create', ['plan' => $plan->name]) }}" class="btn {{ $plan->name == 'premium' ? 'btn-primary' : 'btn-outline' }}" style="width: 100%;">Pilih Paket Ini</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Menu Gallery -->
    <section class="menu-gallery">
        <div class="container">
            <div class="section-header animate-on-scroll">
                <h2 class="section-title">Explore <span>Menu Kami</span></h2>
                <p>Melihat sekilas kelezatan yang kami tawarkan setiap harinya.</p>
            </div>
            <div class="feature-grid" style="grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));">
                @foreach ($menuItems as $index => $item)
                    <div class="menu-card animate-on-scroll" style="background: white; border-radius: 24px; overflow: hidden; border: 1px solid var(--border); transition: var(--transition);">
                        <div class="menu-img-wrapper" style="height: 250px; overflow: hidden; position: relative;">
                            <img src="{{ $item->image_url ? asset($item->image_url) : asset('images/menu-placeholder.png') }}" alt="{{ $item->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            <div style="position: absolute; top: 15px; right: 15px; background: rgba(0,0,0,0.5); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; backdrop-filter: blur(4px);">{{ $item->calories }} kkal</div>
                            <div style="position: absolute; bottom: 15px; left: 15px; background: var(--primary); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">{{ $item->category }}</div>
                        </div>
                        <div style="padding: 1.5rem;">
                            <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem;">{{ $item->name }}</h3>
                            <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 1rem;">{{ $item->description }}</p>
                            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                <span style="font-size: 0.75rem; color: var(--primary); background: var(--primary-light); padding: 0.25rem 0.5rem; border-radius: 4px; font-weight: 600;">#{{ $item->dietary_type }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
