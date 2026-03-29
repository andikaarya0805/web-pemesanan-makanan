@extends('layouts.app')

@section('title', 'Pesan Paket ' . ucfirst($plan->name))

@section('content')
    <section class="order-section" style="padding: 150px 0 100px; background: var(--bg-alt);">
        <div class="container" style="max-width: 900px;">
            <div class="section-header animate-on-scroll" style="text-align: left; margin-bottom: 3rem;">
                <h1 style="font-size: 2.5rem;">Konfigurasi <span>Pesanan</span> Anda</h1>
                <p>Personalikan paket {{ ucfirst($plan->name) }} sesuai dengan profil gizi Anda.</p>
            </div>

            <div class="hero-grid" style="grid-template-columns: 2fr 1fr; align-items: flex-start; gap: 2rem;">
                <!-- Order Form -->
                <div class="order-form animate-on-scroll" style="background: white; padding: 2.5rem; border-radius: 24px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
                    <form action="{{ route('order.store') }}" method="POST" id="orderForm">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                        
                        <!-- Step 1: Schedule -->
                        <div style="margin-bottom: 2.5rem; padding-bottom: 2rem; border-bottom: 1px solid var(--bg-alt);">
                            <h4 style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;"><span style="width: 28px; height: 28px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem;">1</span> Jadwal Pengiriman</h4>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                                <div class="form-group">
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase;">Mulai Tanggal</label>
                                    <input type="date" name="start_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" style="width: 100%; border: 1px solid var(--border); padding: 0.75rem; border-radius: 10px; outline: none; transition: var(--transition);">
                                </div>
                                <div class="form-group">
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase;">Durasi Langganan</label>
                                    <select name="duration" id="duration" required style="width: 100%; border: 1px solid var(--border); padding: 0.75rem; border-radius: 10px; outline: none; background: white; transition: var(--transition);">
                                        <option value="1">1 Minggu</option>
                                        <option value="4" selected>4 Minggu (Sangat Disarankan)</option>
                                        <option value="12">12 Minggu</option>
                                        <option value="24">24 Minggu</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Personalization -->
                        <div style="margin-bottom: 2.5rem; padding-bottom: 2rem; border-bottom: 1px solid var(--bg-alt);">
                            <h4 style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;"><span style="width: 28px; height: 28px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem;">2</span> Profil Nutrisi</h4>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                                <div class="form-group">
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase;">Preferensi Diet</label>
                                    <select name="dietary_preferences" style="width: 100%; border: 1px solid var(--border); padding: 0.75rem; border-radius: 10px; outline: none; background: white; transition: var(--transition);">
                                        <option value="none" {{ $user->dietary_preferences == 'none' ? 'selected' : '' }}>None</option>
                                        <option value="vegetarian" {{ $user->dietary_preferences == 'vegetarian' ? 'selected' : '' }}>Vegetarian</option>
                                        <option value="vegan" {{ $user->dietary_preferences == 'vegan' ? 'selected' : '' }}>Vegan</option>
                                        <option value="keto" {{ $user->dietary_preferences == 'keto' ? 'selected' : '' }}>Keto</option>
                                        <option value="paleo" {{ $user->dietary_preferences == 'paleo' ? 'selected' : '' }}>Paleo</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase;">Tujuan Kesehatan</label>
                                    <select name="goals" style="width: 100%; border: 1px solid var(--border); padding: 0.75rem; border-radius: 10px; outline: none; background: white; transition: var(--transition);">
                                        <option value="general-health" {{ $user->goals == 'general-health' ? 'selected' : '' }}>Health Maintenance</option>
                                        <option value="weight-loss" {{ $user->goals == 'weight-loss' ? 'selected' : '' }}>Weight Loss</option>
                                        <option value="weight-gain" {{ $user->goals == 'weight-gain' ? 'selected' : '' }}>Weight Gain</option>
                                        <option value="muscle-gain" {{ $user->goals == 'muscle-gain' ? 'selected' : '' }}>Muscle Gain</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 1.5rem;">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase;">Alergi Makanan</label>
                                <input type="text" name="allergies" value="{{ $user->allergies }}" style="width: 100%; border: 1px solid var(--border); padding: 0.75rem; border-radius: 10px; outline: none; transition: var(--transition);" placeholder="Kosongkan jika tidak ada">
                            </div>
                        </div>

                        <!-- Step 3: Delivery -->
                        <div style="margin-bottom: 2.5rem; padding-bottom: 2rem; border-bottom: 1px solid var(--bg-alt);">
                            <h4 style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;"><span style="width: 28px; height: 28px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem;">3</span> Informasi Pengiriman</h4>
                            <div class="form-group" style="margin-bottom: 1rem;">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase;">Alamat Lengkap</label>
                                <textarea name="delivery_address" required rows="3" style="width: 100%; border: 1px solid var(--border); padding: 0.75rem; border-radius: 10px; outline: none; transition: var(--transition); resize: none;" placeholder="Alamat lengkap pengiriman...">{{ $user->address }}</textarea>
                            </div>
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase;">Catatan Tambahan</label>
                                <input type="text" name="notes" style="width: 100%; border: 1px solid var(--border); padding: 0.75rem; border-radius: 10px; outline: none; transition: var(--transition);" placeholder="Pesan untuk kurir...">
                            </div>
                        </div>

                        <!-- Step 4: Payment -->
                        <div style="margin-bottom: 2rem;">
                            <h4 style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;"><span style="width: 28px; height: 28px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem;">4</span> Pilih Metode Pembayaran</h4>
                            <div style="display: grid; grid-template-columns: 1fr; gap: 0.75rem;">
                                <label style="display: flex; align-items: center; gap: 1rem; border: 1px solid var(--border); padding: 1rem; border-radius: 12px; cursor: pointer; transition: all 0.3s ease;">
                                    <input type="radio" name="payment_method" value="qris" required style="accent-color: var(--primary); width: 1.2rem; height: 1.2rem;">
                                    <div style="flex: 1;">
                                        <div style="font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                                            <span>QRIS (ShopeePay, OVO, GoPay)</span>
                                            <i class="fas fa-qrcode" style="color: var(--primary);"></i>
                                        </div>
                                        <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0.25rem 0 0;">Pembayaran instan melalui kode QR</p>
                                    </div>
                                </label>
                                <label style="display: flex; align-items: center; gap: 1rem; border: 1px solid var(--border); padding: 1rem; border-radius: 12px; cursor: pointer; transition: all 0.3s ease;">
                                    <input type="radio" name="payment_method" value="bank_transfer" style="accent-color: var(--primary); width: 1.2rem; height: 1.2rem;">
                                    <div style="flex: 1;">
                                        <div style="font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                                            <span>Transfer Bank</span>
                                            <i class="fas fa-university" style="color: var(--primary);"></i>
                                        </div>
                                        <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0.25rem 0 0;">Transfer manual ke rekening NutriBox</p>
                                    </div>
                                </label>
                                <label style="display: flex; align-items: center; gap: 1rem; border: 1px solid var(--border); padding: 1rem; border-radius: 12px; cursor: pointer; transition: all 0.3s ease;">
                                    <input type="radio" name="payment_method" value="cod" style="accent-color: var(--primary); width: 1.2rem; height: 1.2rem;">
                                    <div style="flex: 1;">
                                        <div style="font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                                            <span>Cash on Delivery (COD)</span>
                                            <i class="fas fa-hand-holding-usd" style="color: var(--primary);"></i>
                                        </div>
                                        <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0.25rem 0 0;">Bayar saat makanan diantar</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Order Summary -->
                <div class="order-summary animate-on-scroll" style="position: sticky; top: 120px;">
                    <div style="background: var(--secondary); color: white; border-radius: 20px; padding: 2rem;">
                        <h4 style="color: white; margin-bottom: 1.5rem; font-size: 1.125rem;">Ringkasan <span>Pesanan</span></h4>
                        <div style="display: flex; flex-direction: column; gap: 1rem; padding-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1);">
                            <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                                <span style="color: #94a3b8;">Paket</span>
                                <span style="font-weight: 600;">{{ ucfirst($plan->name) }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                                <span style="color: #94a3b8;">Harga Mingguan</span>
                                <span style="font-weight: 600;">Rp {{ number_format($plan->price_per_week, 0, ',', '.') }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                                <span style="color: #94a3b8;">Durasi</span>
                                <span style="font-weight: 600;" id="summaryDuration">4 Minggu</span>
                            </div>
                        </div>
                        <div style="padding-top: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
                                <span style="color: #94a3b8;">Total Tagihan</span>
                                <h2 style="color: var(--primary); font-size: 1.75rem; margin: 0;" id="totalPriceDisplay">Rp {{ number_format($plan->price_per_week * 4, 0, ',', '.') }}</h2>
                            </div>
                            <button type="submit" form="orderForm" class="btn btn-primary" style="width: 100%; padding: 1rem;">Konfirmasi Pesanan</button>
                            <p style="text-align: center; font-size: 0.75rem; color: #64748b; margin-top: 1rem;">Pembayaran akan dikonfirmasi setelah pesanan kami terima.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        const durationSelect = document.getElementById('duration');
        const summaryDuration = document.getElementById('summaryDuration');
        const totalPriceDisplay = document.getElementById('totalPriceDisplay');
        const pricePerWeek = {{ $plan->price_per_week }};

        durationSelect.addEventListener('change', () => {
            const weeks = durationSelect.value;
            const total = pricePerWeek * weeks;
            
            summaryDuration.textContent = weeks + ' Minggu';
            totalPriceDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
        });
    </script>
    @endpush
@endsection
