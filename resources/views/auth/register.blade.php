@extends('layouts.app')

@section('title', 'Daftar NutriBox')

@section('content')
    <section class="auth-section" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: var(--bg-alt); padding: 120px 0 80px;">
        <div class="container" style="max-width: 600px;">
            <div class="auth-card animate-on-scroll" style="background: var(--white); border-radius: 24px; border: 1px solid var(--border); box-shadow: var(--shadow-premium); overflow: hidden;">
                <div style="background: var(--primary); padding: 3rem 2rem; text-align: center; color: white;">
                    <div class="brand-icon" style="margin: 0 auto 1.5rem; width: 60px; height: 60px; font-size: 1.5rem; background: rgba(255,255,255,0.2);"><i class="fas fa-user-plus"></i></div>
                    <h2 style="color: white; font-size: 1.75rem; margin-bottom: 0.5rem;">Bergabung Sekarang</h2>
                    <p style="color: rgba(255,255,255,0.8); font-size: 0.875rem;">Mulai perjalanan hidup sehat Anda hari ini.</p>
                </div>
                
                <div style="padding: 3rem 2rem;">
                    @if ($errors->any())
                        <div style="background: rgba(239, 68, 68, 0.1); color: var(--error); padding: 1rem; border-radius: 12px; margin-bottom: 2rem; font-size: 0.875rem;">
                            <ul style="margin: 0; padding-left: 1.25rem;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="form-group" style="margin-bottom: 1.5rem;">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Nama Lengkap</label>
                            <div style="position: relative;">
                                <i class="fas fa-user" style="position: absolute; left: 1rem; top: 1rem; color: var(--text-muted);"></i>
                                <input type="text" name="name" value="{{ old('name') }}" required style="width: 100%; border: 1px solid var(--border); padding: 1rem 1rem 1rem 3rem; border-radius: 12px; outline: none; transition: var(--transition);" placeholder="Contoh: John Doe">
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Email</label>
                                <div style="position: relative;">
                                    <i class="fas fa-envelope" style="position: absolute; left: 1rem; top: 1rem; color: var(--text-muted);"></i>
                                    <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; border: 1px solid var(--border); padding: 1rem 1rem 1rem 3rem; border-radius: 12px; outline: none; transition: var(--transition);" placeholder="email@anda.com">
                                </div>
                            </div>
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Telepon</label>
                                <div style="position: relative;">
                                    <i class="fas fa-phone" style="position: absolute; left: 1rem; top: 1rem; color: var(--text-muted);"></i>
                                    <input type="text" name="phone" value="{{ old('phone') }}" required style="width: 100%; border: 1px solid var(--border); padding: 1rem 1rem 1rem 3rem; border-radius: 12px; outline: none; transition: var(--transition);" placeholder="0812...">
                                </div>
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Password</label>
                                <div style="position: relative;">
                                    <i class="fas fa-lock" style="position: absolute; left: 1rem; top: 1rem; color: var(--text-muted);"></i>
                                    <input type="password" name="password" required style="width: 100%; border: 1px solid var(--border); padding: 1rem 1rem 1rem 3rem; border-radius: 12px; outline: none; transition: var(--transition);" placeholder="••••••••">
                                </div>
                            </div>
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Konfirmasi Password</label>
                                <div style="position: relative;">
                                    <i class="fas fa-shield-check" style="position: absolute; left: 1rem; top: 1rem; color: var(--text-muted);"></i>
                                    <input type="password" name="password_confirmation" required style="width: 100%; border: 1px solid var(--border); padding: 1rem 1rem 1rem 3rem; border-radius: 12px; outline: none; transition: var(--transition);" placeholder="••••••••">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem;">Daftar Sekarang</button>
                    </form>

                    <div style="margin-top: 2rem; text-align: center; font-size: 0.875rem; color: var(--text-muted);">
                        Sudah punya akun? <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 700;">Masuk di sini</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
