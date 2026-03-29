@extends('layouts.app')

@section('title', 'Hubungi Kami')

@section('content')
    <!-- Contact Hero -->
    <section class="contact-header" style="background: var(--secondary); color: white; padding: 120px 0 80px;">
        <div class="container animate-on-scroll">
            <h1 style="color: white; font-size: 3.5rem; margin-bottom: 1rem;">Ada <span>Pertanyaan</span>?</h1>
            <p style="color: #94a3b8; font-size: 1.25rem;">Tim support kami siap membantu Anda 24/7.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-main" style="margin-top: -60px; padding-bottom: 100px;">
        <div class="container">
            <div class="hero-grid" style="align-items: flex-start; gap: 2.5rem;">
                <!-- Contact Info Card -->
                <div class="contact-info animate-on-scroll" style="background: var(--white); padding: 3rem; border-radius: 24px; border: 1px solid var(--border); box-shadow: var(--shadow- premium);">
                    <h2 style="margin-bottom: 2rem; font-size: 1.75rem;">Informasi <span>Kontak</span></h2>
                    
                    <div style="display: flex; flex-direction: column; gap: 2rem;">
                        <div style="display: flex; gap: 1.5rem; align-items: center;">
                            <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0;"><i class="fas fa-envelope"></i></div>
                            <div>
                                <h4 style="margin: 0; font-size: 1rem;">Email Kami</h4>
                                <p style="margin: 0; color: var(--text-muted);">info@nutribox.id</p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 1.5rem; align-items: center;">
                            <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0;"><i class="fas fa-phone"></i></div>
                            <div>
                                <h4 style="margin: 0; font-size: 1rem;">Telepon</h4>
                                <p style="margin: 0; color: var(--text-muted);">(021) 1234-5678</p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 1.5rem; align-items: center;">
                            <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0;"><i class="fab fa-whatsapp"></i></div>
                            <div>
                                <h4 style="margin: 0; font-size: 1rem;">WhatsApp</h4>
                                <p style="margin: 0; color: var(--text-muted);">+62 812-3456-7890</p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 1.5rem; align-items: center;">
                            <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0;"><i class="fas fa-location-dot"></i></div>
                            <div>
                                <h4 style="margin: 0; font-size: 1rem;">Kantor Pusat</h4>
                                <p style="margin: 0; color: var(--text-muted);">Jl. Sudirman No. 123, Jakarta Selatan</p>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--border);">
                        <h4>Ikuti Kami</h4>
                        <div class="footer-socials" style="margin-top: 1rem;">
                            <a href="#" style="background: var(--bg-alt); color: var(--secondary);"><i class="fab fa-instagram"></i></a>
                            <a href="#" style="background: var(--bg-alt); color: var(--secondary);"><i class="fab fa-facebook"></i></a>
                            <a href="#" style="background: var(--bg-alt); color: var(--secondary);"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form Card -->
                <div class="contact-form animate-on-scroll" style="background: var(--white); padding: 3rem; border-radius: 24px; border: 1px solid var(--border); box-shadow: var(--shadow-premium);">
                    <h2 style="margin-bottom: 2rem; font-size: 1.75rem;">Kirim <span>Pesan</span></h2>
                    
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Nama Lengkap</label>
                                <input type="text" name="name" required style="width: 100%; border: 1px solid var(--border); padding: 1rem; border-radius: 12px; outline: none; transition: var(--transition);" placeholder="Contoh: John Doe">
                            </div>
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Email</label>
                                <input type="email" name="email" required style="width: 100%; border: 1px solid var(--border); padding: 1rem; border-radius: 12px; outline: none; transition: var(--transition);" placeholder="email@contoh.com">
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Telepon / WhatsApp</label>
                                <input type="text" name="phone" style="width: 100%; border: 1px solid var(--border); padding: 1rem; border-radius: 12px; outline: none; transition: var(--transition);" placeholder="0812...">
                            </div>
                            <div class="form-group">
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Subjek</label>
                                <select name="subject" required style="width: 100%; border: 1px solid var(--border); padding: 1rem; border-radius: 12px; outline: none; background: white; transition: var(--transition);">
                                    <option value="general">Informasi Umum</option>
                                    <option value="order">Pertanyaan Pesanan</option>
                                    <option value="delivery">Layanan Pengiriman</option>
                                    <option value="nutrition">Konsultasi Gizi</option>
                                    <option value="partnership">Kemitraan</option>
                                    <option value="other">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 2rem;">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">Pesan</label>
                            <textarea name="message" required rows="5" style="width: 100%; border: 1px solid var(--border); padding: 1rem; border-radius: 12px; outline: none; transition: var(--transition); resize: none;" placeholder="Bagaimana kami dapat membantu Anda?"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem;">Kirim Sekarang <i class="fas fa-paper-plane" style="margin-left: 0.5rem;"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
