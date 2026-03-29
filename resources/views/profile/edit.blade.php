@extends('layouts.app')

@section('title', 'Edit Profil & Nutrisi')

@section('content')
    <section class="profile-section" style="padding: 150px 0 100px; background: var(--bg-alt);">
        <div class="container" style="max-width: 800px;">
            <div class="section-header animate-on-scroll" style="text-align: left; margin-bottom: 2rem;">
                <h1 style="font-size: 2.5rem;">Pengaturan <span>Profil</span></h1>
                <p>Perbarui informasi pribadi dan preferensi kesehatan Anda.</p>
            </div>

            @if(session('success'))
                <div style="background: rgba(16, 185, 129, 0.1); color: var(--success); padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid var(--success);">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="animate-on-scroll" style="background: white; border-radius: 24px; border: 1px solid var(--border); box-shadow: var(--shadow-sm); overflow: hidden;">
                <form action="{{ route('profile.update') }}" method="POST" style="padding: 2.5rem;">
                    @csrf
                    
                    <!-- Section: Personal Info -->
                    <div style="margin-bottom: 2.5rem; padding-bottom: 2rem; border-bottom: 1px solid var(--bg-alt);">
                        <h4 style="margin-bottom: 1.5rem; color: var(--secondary); display: flex; align-items: center; gap: 0.75rem;"><i class="fas fa-user-circle"></i> Informasi Pribadi</h4>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase;">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ $user->name }}" required style="width: 100%; border: 1px solid var(--border); padding: 0.75rem; border-radius: 10px; outline: none; transition: var(--transition);">
                                @error('name') <span style="font-size: 0.75rem; color: var(--danger);">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase;">Email</label>
                                <input type="email" name="email" value="{{ $user->email }}" required style="width: 100%; border: 1px solid var(--border); padding: 0.75rem; border-radius: 10px; outline: none; transition: var(--transition);">
                                @error('email') <span style="font-size: 0.75rem; color: var(--danger);">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase;">Nomor Telepon</label>
                                <input type="text" name="phone" value="{{ $user->phone }}" style="width: 100%; border: 1px solid var(--border); padding: 0.75rem; border-radius: 10px; outline: none; transition: var(--transition);">
                            </div>
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase;">Alamat</label>
                                <input type="text" name="address" value="{{ $user->address }}" style="width: 100%; border: 1px solid var(--border); padding: 0.75rem; border-radius: 10px; outline: none; transition: var(--transition);">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Health Profile -->
                    <div style="margin-bottom: 2.5rem; padding-bottom: 2rem; border-bottom: 1px solid var(--bg-alt);">
                        <h4 style="margin-bottom: 1.5rem; color: var(--secondary); display: flex; align-items: center; gap: 0.75rem;"><i class="fas fa-heartbeat"></i> Profil Nutrisi & Diet</h4>
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

                    <!-- Section: Security -->
                    <div style="margin-bottom: 2rem;">
                        <h4 style="margin-bottom: 1.5rem; color: var(--secondary); display: flex; align-items: center; gap: 0.75rem;"><i class="fas fa-shield-alt"></i> Keamanan (Opsional)</h4>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase;">Password Baru</label>
                                <input type="password" name="password" style="width: 100%; border: 1px solid var(--border); padding: 0.75rem; border-radius: 10px; outline: none; transition: var(--transition);">
                            </div>
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase;">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" style="width: 100%; border: 1px solid var(--border); padding: 0.75rem; border-radius: 10px; outline: none; transition: var(--transition);">
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem; margin-top: 3rem;">
                        <button type="submit" class="btn btn-primary" style="flex: 1; padding: 1rem;">Simpan Perubahan</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline" style="flex: 1; padding: 1rem; text-align: center;">Kembali ke Dashboard</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
