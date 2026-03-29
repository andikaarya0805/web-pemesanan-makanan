@extends('layouts.app')

@section('title', 'Edit Paket ' . $plan->name)

@section('content')
    <section class="admin-plans-edit" style="padding: 150px 0 100px; background: var(--bg-alt); min-height: 100vh;">
        <div class="container" style="max-width: 800px;">
            <div style="margin-bottom: 2rem;">
                <a href="{{ route('admin.plan.index') }}" style="color: var(--text-muted); font-weight: 600; text-decoration: none;"><i class="fas fa-arrow-left"></i> Kembali ke Daftar Paket</a>
                <h1 style="font-size: 2rem; margin-top: 1rem;">Edit Paket <span>{{ $plan->name }}</span></h1>
            </div>

            <div style="background: white; border-radius: 24px; border: 1px solid var(--border); padding: 2.5rem; box-shadow: var(--shadow-sm);">
                <form action="{{ route('admin.plan.update', $plan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nama Paket</label>
                            <input type="text" name="name" value="{{ $plan->name }}" class="form-control" style="width: 100%;" required>
                        </div>
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Status</label>
                            <label class="switch" style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer; margin-top: 0.5rem;">
                                <input type="checkbox" name="is_active" {{ $plan->is_active ? 'checked' : '' }} style="width: auto;">
                                <span style="font-weight: 500;">Aktifkan Paket</span>
                            </label>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Harga per Minggu (Rp)</label>
                            <input type="number" name="price_per_week" value="{{ $plan->price_per_week }}" class="form-control" style="width: 100%;" step="100" required>
                            <span style="font-size: 0.75rem; color: var(--text-muted);">Sesuaikan jika harga bahan baku di pasar berubah.</span>
                        </div>
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Jumlah Makan per Minggu</label>
                            <input type="number" name="meals_per_week" value="{{ $plan->meals_per_week }}" class="form-control" style="width: 100%;" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Deskripsi</label>
                        <textarea name="description" class="form-control" style="width: 100%; min-height: 100px;" required>{{ $plan->description }}</textarea>
                    </div>

                    <div class="form-group" style="margin-bottom: 2rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Fitur & Keuntungan (Satu per baris)</label>
                        <textarea name="features" class="form-control" style="width: 100%; min-height: 150px; font-family: monospace;" required>{{ $plan->features_string }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem;"><i class="fas fa-save"></i> Perbarui Paket</button>
                </form>
            </div>
            
            @if($plan->subscriptions_count > 0)
                <div style="margin-top: 1.5rem; font-size: 0.875rem; color: var(--error);">
                    <i class="fas fa-exclamation-triangle"></i> Peringatan: Paket ini memiliki {{ $plan->subscriptions_count }} pelanggan aktif. Perubahan harga akan berlaku pada tagihan periode berikutnya.
                </div>
            @endif
        </div>
    </section>
@endsection
