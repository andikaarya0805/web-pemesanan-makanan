@extends('layouts.app')

@section('title', 'Detail Langganan')

@section('content')
    <section class="subscription-detail" style="padding: 150px 0 100px; background: var(--bg-alt);">
        <div class="container" style="max-width: 1000px;">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                <a href="{{ route('dashboard') }}" style="width: 40px; height: 40px; border-radius: 50%; background: white; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text);"><i class="fas fa-arrow-left"></i></a>
                <h1 style="font-size: 2rem; margin: 0;">Detail <span>Langganan</span></h1>
            </div>

            <div class="hero-grid" style="grid-template-columns: 1fr 2fr; align-items: flex-start; gap: 2rem;">
                <!-- Left: Plan Summary -->
                <div class="animate-on-scroll">
                    <div style="background: white; border-radius: 24px; border: 1px solid var(--border); padding: 2rem; box-shadow: var(--shadow-sm);">
                        <div style="width: 80px; height: 80px; border-radius: 20px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin-bottom: 1.5rem;"><i class="fas fa-utensils"></i></div>
                        <h2 style="font-size: 1.5rem; margin-bottom: 0.5rem;">Paket {{ ucfirst($subscription->plan->name) }}</h2>
                        <span style="font-size: 0.75rem; font-weight: 700; padding: 0.25rem 0.75rem; border-radius: 6px; background: rgba(16, 185, 129, 0.1); color: var(--success);">{{ ucfirst($subscription->status) }}</span>
                        
                        <div style="margin-top: 2rem; display: flex; flex-direction: column; gap: 1.25rem;">
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: var(--text-muted); font-size: 0.875rem;">Mulai</span>
                                <span style="font-weight: 600;">{{ $subscription->start_date->format('d M Y') }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: var(--text-muted); font-size: 0.875rem;">Durasi</span>
                                <span style="font-weight: 600;">{{ $subscription->duration_weeks }} Minggu</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: var(--text-muted); font-size: 0.875rem;">Metode Bayar</span>
                                <span style="font-weight: 600; text-transform: uppercase;">{{ str_replace('_', ' ', $subscription->payment_method) }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding-top: 1rem; border-top: 1px solid var(--bg-alt);">
                                <span style="color: var(--text-muted); font-size: 0.875rem;">Total Biaya</span>
                                <span style="font-weight: 700; color: var(--primary);">Rp {{ number_format($subscription->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div style="margin-top: 2rem;">
                            <h4 style="font-size: 0.875rem; margin-bottom: 0.75rem;">Alamat Pengiriman</h4>
                            <p style="font-size: 0.875rem; color: var(--text-muted); line-height: 1.6;">{{ $subscription->delivery_address }}</p>
                        </div>
                        
                        <a href="{{ route('invoice.show', $subscription->id) }}" class="btn btn-outline" style="width: 100%; margin-top: 2rem;"><i class="fas fa-file-invoice"></i> Lihat Invoice</a>
                    </div>
                </div>

                <!-- Right: Meal Selections -->
                <div class="animate-on-scroll">
                    <div style="background: white; border-radius: 24px; border: 1px solid var(--border); padding: 2rem; box-shadow: var(--shadow-sm);">
                        <h3 style="margin-bottom: 2rem;">Menu <span>Terpilih</span></h3>
                        
                        @if($selections->count() > 0)
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                                @foreach($selections as $selection)
                                    <div style="display: flex; gap: 1rem; align-items: center; padding: 1rem; border: 1px solid var(--border); border-radius: 16px; background: var(--bg-alt);">
                                        <div style="width: 60px; height: 60px; border-radius: 12px; overflow: hidden; flex-shrink: 0;">
                                            <img src="{{ $selection->menuItem->image_url ?? asset('images/menu-placeholder.png') }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                        <div>
                                            <h5 style="margin: 0; font-size: 0.9375rem;">{{ $selection->menuItem->name }}</h5>
                                            <p style="margin: 0.25rem 0 0; font-size: 0.75rem; color: var(--text-muted);">{{ $selection->menuItem->calories }} kcal • <span style="color: var(--primary); font-weight: 600;">Pekan {{ $selection->week_number }}</span></p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div style="background: var(--primary-light); color: var(--primary); border-radius: 16px; padding: 1.5rem; margin-top: 2rem; display: flex; gap: 1rem; align-items: center;">
                                <i class="fas fa-info-circle fa-lg"></i>
                                <p style="margin: 0; font-size: 0.875rem; font-weight: 500;">Anda dapat mengganti pilihan menu setiap hari Sabtu sebelum pengiriman pekan berikutnya dimulai.</p>
                            </div>
                        @else
                            <div style="text-align: center; padding: 3rem;">
                                <div style="font-size: 3rem; color: var(--border); margin-bottom: 1.5rem;"><i class="fas fa-concierge-bell"></i></div>
                                <h4>Belum ada menu yang dipilih</h4>
                                <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Silakan kembali ke dashboard untuk memilih menu mingguan Anda.</p>
                                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">Ke Dashboard</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
