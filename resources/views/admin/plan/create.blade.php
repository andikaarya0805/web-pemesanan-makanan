@extends('layouts.app')

@section('title', 'Tambah Paket Langganan')

@section('content')
    <section class="admin-plans-create" style="padding: 150px 0 100px; background: var(--bg-alt); min-height: 100vh;">
        <div class="container" style="max-width: 800px;">
            <div style="margin-bottom: 2rem;">
                <a href="{{ route('admin.plan.index') }}" style="color: var(--text-muted); font-weight: 600; text-decoration: none;"><i class="fas fa-arrow-left"></i> Kembali ke Daftar Paket</a>
                <h1 style="font-size: 2rem; margin-top: 1rem;">Tambah <span>Paket Baru</span></h1>
            </div>

            <div style="background: white; border-radius: 24px; border: 1px solid var(--border); padding: 2.5rem; box-shadow: var(--shadow-sm);">
                <form action="{{ route('admin.plan.store') }}" method="POST">
                    @csrf
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nama Paket</label>
                            <input type="text" name="name" class="form-control" style="width: 100%;" placeholder="Contoh: Basic Plan" required>
                        </div>
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Status</label>
                            <label class="switch" style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer; margin-top: 0.5rem;">
                                <input type="checkbox" name="is_active" checked style="width: auto;">
                                <span style="font-weight: 500;">Aktifkan Paket</span>
                            </label>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Harga per Minggu (Rp)</label>
                            <input type="number" name="price_per_week" class="form-control" style="width: 100%;" placeholder="Rp" step="100" required>
                            <span style="font-size: 0.75rem; color: var(--text-muted);">Harga total yang akan dibayar user per minggu.</span>
                        </div>
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Jumlah Makan per Minggu</label>
                            <input type="number" name="meals_per_week" class="form-control" style="width: 100%;" placeholder="6" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Deskripsi</label>
                        <textarea name="description" class="form-control" style="width: 100%; min-height: 100px;" placeholder="Tuliskan deskripsi singkat paket..." required></textarea>
                    </div>

                    <div class="form-group" style="margin-bottom: 2rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Fitur & Keuntungan (Satu per baris)</label>
                        <textarea name="features" class="form-control" style="width: 100%; min-height: 150px; font-family: monospace;" placeholder="Pilihan Menu Diet Lengkap&#10;GRATIS Konsultasi Nutrisi&#10;Gratis Ongkir Seluruh Jakarta" required></textarea>
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Daftar ini akan muncul sebagai bullet points di halaman depan.</span>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem;"><i class="fas fa-save"></i> Simpan Paket</button>
                </form>
            </div>
        </div>
    </section>
@endsection
