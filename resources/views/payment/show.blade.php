@extends('layouts.app')

@section('title', 'Pilih Metode Pembayaran')

@section('content')
    <section class="payment-selection" style="padding: 120px 0 80px; background: var(--bg-alt); min-height: 100vh;">
        <div class="container" style="max-width: 900px;">
            <div class="section-header animate-on-scroll" style="text-align: center; margin-bottom: 3rem;">
                <h4 style="color: var(--primary); font-weight: 600; margin-bottom: 0.5rem;">Selesaikan Pesanan</h4>
                <h1 style="font-size: 2.5rem;">Pilih <span>Metode Pembayaran</span></h1>
                <p style="color: var(--text-muted); margin-top: 1rem;">Total Tagihan: <span style="font-weight: 700; color: var(--secondary); font-size: 1.25rem;">Rp {{ number_format($subscription->total_price, 0, ',', '.') }}</span></p>
            </div>

            <form action="{{ route('payment.process', $subscription->id) }}" method="POST" id="payment-form">
                @csrf
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                    
                    <!-- COD -->
                    <label style="cursor: pointer;">
                        <input type="radio" name="payment_method" value="cod" style="display: none;" onchange="updateSelection(this)">
                        <div class="payment-card" style="background: white; padding: 2rem; border-radius: 24px; border: 2px solid var(--border); text-align: center; transition: all 0.3s ease; height: 100%;">
                            <div style="width: 60px; height: 60px; background: var(--primary-light); color: var(--primary); border-radius: 15px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem;">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                            <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem;">COD</h3>
                            <p style="font-size: 0.875rem; color: var(--text-muted);">Bayar tunai saat kurir mengantarkan box pertama Anda.</p>
                        </div>
                    </label>

                    <!-- QRIS -->
                    <label style="cursor: pointer;">
                        <input type="radio" name="payment_method" value="qris" style="display: none;" onchange="updateSelection(this)">
                        <div class="payment-card" style="background: white; padding: 2rem; border-radius: 24px; border: 2px solid var(--border); text-align: center; transition: all 0.3s ease; height: 100%;">
                            <div style="width: 60px; height: 60px; background: var(--secondary-light); color: var(--secondary); border-radius: 15px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem;">
                                <i class="fas fa-qrcode"></i>
                            </div>
                            <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem;">QRIS</h3>
                            <p style="font-size: 0.875rem; color: var(--text-muted);">Scan kode QR menggunakan e-wallet atau aplikasi bank Anda.</p>
                        </div>
                    </label>

                    <!-- Bank Transfer -->
                    <label style="cursor: pointer;">
                        <input type="radio" name="payment_method" value="bank_transfer" style="display: none;" onchange="updateSelection(this)">
                        <div class="payment-card" style="background: white; padding: 2rem; border-radius: 24px; border: 2px solid var(--border); text-align: center; transition: all 0.3s ease; height: 100%;">
                            <div style="width: 60px; height: 60px; background: #e0f2fe; color: #0284c7; border-radius: 15px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem;">
                                <i class="fas fa-university"></i>
                            </div>
                            <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem;">Transfer Bank</h3>
                            <p style="font-size: 0.875rem; color: var(--text-muted);">Transfer ke rekening virtual account BCA/Mandiri/BNI.</p>
                        </div>
                    </label>

                </div>

                <div id="payment-details" style="margin-top: 3rem; display: none;" class="animate-on-scroll">
                    <!-- Dynamic Details based on selection -->
                    <div id="qris-simulation" style="display: none; text-align: center; background: white; padding: 2rem; border-radius: 24px; border: 1px solid var(--border);">
                        <h4>Scan QRIS NutriBox</h4>
                        <div style="background: #f8fafc; padding: 20px; border-radius: 10px; display: inline-block; margin: 20px 0;">
                             <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=NutriBoxSimulation" style="display: block;">
                        </div>
                        <p style="font-size: 0.875rem; color: var(--text-muted);">Silakan klik "Konfirmasi Pembayaran" setelah Anda membayar.</p>
                    </div>

                    <div id="bank-simulation" style="display: none; background: white; padding: 2rem; border-radius: 24px; border: 1px solid var(--border);">
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border); padding-bottom: 1rem; margin-bottom: 1rem;">
                            <h4 style="margin: 0;">Virtual Account BCA</h4>
                            <span style="font-weight: 700; color: var(--primary);">88301 0812 3456 7890</span>
                        </div>
                        <p style="font-size: 0.875rem; color: var(--text-muted);">Atas Nama: <strong>PT NUTRIBOX INDONESIA</strong></p>
                    </div>

                    <div style="margin-top: 2rem; text-align: center;">
                        <button type="submit" class="btn btn-primary btn-lg" style="min-width: 300px;">Konfirmasi Pembayaran</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <style>
        .payment-card:hover {
            border-color: var(--primary) !important;
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }
        input[type="radio"]:checked + .payment-card {
            border-color: var(--primary) !important;
            background: var(--primary-light) !important;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
        }
    </style>

    <script>
        function updateSelection(input) {
            const details = document.getElementById('payment-details');
            const qris = document.getElementById('qris-simulation');
            const bank = document.getElementById('bank-simulation');
            
            details.style.display = 'block';
            qris.style.display = input.value === 'qris' ? 'block' : 'none';
            bank.style.display = input.value === 'bank_transfer' ? 'block' : 'none';
            
            // Re-trigger scroll animations for new content
            if (window.observer) {
                details.querySelectorAll('.animate-on-scroll').forEach(el => window.observer.observe(el));
            }
        }
    </script>
@endsection
