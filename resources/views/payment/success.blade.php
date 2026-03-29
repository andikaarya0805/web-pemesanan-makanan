@extends('layouts.app')

@section('title', 'Pembayaran Berhasil')

@section('content')
    <section class="payment-success" style="padding: 120px 0 80px; background: var(--bg-alt); min-height: 100vh;">
        <div class="container" style="max-width: 700px; text-align: center;">
            <div class="animate-on-scroll" style="background: white; padding: 4rem; border-radius: 32px; box-shadow: var(--shadow-lg); border: 1px solid var(--border);">
                <div style="width: 100px; height: 100px; background: var(--success); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; font-size: 3rem; box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);">
                    <i class="fas fa-check"></i>
                </div>
                
                <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">Pembayaran <span>Diterima!</span></h1>
                <p style="color: var(--text-muted); font-size: 1.125rem; max-width: 500px; margin: 0 auto 3rem;">
                    Terima kasih telah berlangganan NutriBox. Status langganan Anda kini telah **Aktif**. Selamat menikmati perjalanan sehat Anda!
                </p>

                <div style="background: var(--bg-alt); padding: 2rem; border-radius: 20px; margin-bottom: 3rem; text-align: left;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                        <span style="color: var(--text-muted);">Nomor Langganan:</span>
                        <span style="font-weight: 600;">#NBX-{{ $subscription->id }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                        <span style="color: var(--text-muted);">Metode Pembayaran:</span>
                        <span style="font-weight: 600; text-transform: uppercase;">{{ str_replace('_', ' ', $subscription->payment_method) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--text-muted);">Total Bayar:</span>
                        <span style="font-weight: 700; color: var(--primary);">Rp {{ number_format($subscription->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; justify-content: center;">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary" style="flex: 1;">Ke Dashboard</a>
                    <a href="{{ route('invoice.show', $subscription->id) }}" class="btn btn-outline" style="flex: 1;">Lihat Invoice</a>
                </div>
            </div>
        </div>
    </section>
@endsection
