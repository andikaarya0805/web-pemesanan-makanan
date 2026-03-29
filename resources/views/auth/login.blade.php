@extends('layouts.app')

@section('title', 'Masuk ke NutriBox')

@section('content')
    <section class="auth-section" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: var(--bg-alt); padding: 120px 0 80px;">
        <div class="container" style="max-width: 500px;">
            <div class="auth-card animate-on-scroll" style="background: var(--white); border-radius: 24px; border: 1px solid var(--border); box-shadow: var(--shadow-premium); overflow: hidden;">
                <div style="background: var(--secondary); padding: 3rem 2rem; text-align: center; color: white;">
                    <div class="brand-icon" style="margin: 0 auto 1.5rem; width: 60px; height: 60px; font-size: 1.5rem;"><i class="fas fa-seedling"></i></div>
                    <h2 style="color: white; font-size: 1.75rem; margin-bottom: 0.5rem;">Selamat Datang Kembali</h2>
                    <p style="color: #94a3b8; font-size: 0.875rem;">Silakan masuk untuk mengelola langganan Anda.</p>
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

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group" style="margin-bottom: 1.5rem;">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Email</label>
                            <div style="position: relative;">
                                <i class="fas fa-envelope" style="position: absolute; left: 1rem; top: 1rem; color: var(--text-muted);"></i>
                                <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; border: 1px solid var(--border); padding: 1rem 1rem 1rem 3rem; border-radius: 12px; outline: none; transition: var(--transition);" placeholder="email@anda.com">
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <label style="font-weight: 600; font-size: 0.875rem;">Password</label>
                                <a href="#" style="font-size: 0.75rem; color: var(--primary); font-weight: 600;">Lupa Password?</a>
                            </div>
                            <div style="position: relative;">
                                <i class="fas fa-lock" style="position: absolute; left: 1rem; top: 1rem; color: var(--text-muted);"></i>
                                <input type="password" name="password" required style="width: 100%; border: 1px solid var(--border); padding: 1rem 1rem 1rem 3rem; border-radius: 12px; outline: none; transition: var(--transition);" placeholder="••••••••">
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 2rem;">
                            <input type="checkbox" name="remember" id="remember" style="width: 1rem; height: 1rem; border-radius: 4px;">
                            <label for="remember" style="font-size: 0.875rem; color: var(--text-muted); cursor: pointer;">Ingat saya di perangkat ini</label>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem;">Masuk Sekarang</button>
                    </form>

                    <div style="margin-top: 2rem; text-align: center; font-size: 0.875rem; color: var(--text-muted);">
                        Belum punya akun? <a href="{{ route('register') }}" style="color: var(--primary); font-weight: 700;">Daftar Gratis</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
