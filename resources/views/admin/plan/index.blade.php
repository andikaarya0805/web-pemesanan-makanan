@extends('layouts.app')

@section('title', 'Manajemen Paket Langganan')

@section('content')
    <section class="admin-plans" style="padding: 150px 0 100px; background: var(--bg-alt); min-height: 100vh;">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
                <div>
                    <h4 style="color: var(--primary); font-weight: 600; margin-bottom: 0.5rem;">Katalog Produk</h4>
                    <h1 style="font-size: 2.5rem;">Paket <span>Langganan</span></h1>
                </div>
                <a href="{{ route('admin.plan.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Paket</a>
            </div>

            @if(session('success'))
                <div style="background: rgba(16, 185, 129, 0.1); color: var(--success); padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid var(--success);">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div style="background: white; border-radius: 24px; border: 1px solid var(--border); overflow: hidden; box-shadow: var(--shadow-sm);">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: var(--bg-alt); text-align: left;">
                            <th style="padding: 1.25rem 1.5rem; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">Nama Paket</th>
                            <th style="padding: 1.25rem 1.5rem; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">Harga / Minggu</th>
                            <th style="padding: 1.25rem 1.5rem; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">Menu / Minggu</th>
                            <th style="padding: 1.25rem 1.5rem; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">Status</th>
                            <th style="padding: 1.25rem 1.5rem; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted); text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($plans as $plan)
                            <tr style="border-top: 1px solid var(--border);">
                                <td style="padding: 1.5rem;">
                                    <div style="font-weight: 700; font-size: 1.125rem;">{{ $plan->name }}</div>
                                    <div style="font-size: 0.8125rem; color: var(--text-muted); margin-top: 0.25rem;">{{ Str::limit($plan->description, 50) }}</div>
                                </td>
                                <td style="padding: 1.5rem;">
                                    <div style="font-weight: 700; color: var(--primary);">Rp {{ number_format($plan->price_per_week, 0, ',', '.') }}</div>
                                </td>
                                <td style="padding: 1.5rem;">
                                    <span style="font-weight: 600;">{{ $plan->meals_per_week }} Makan</span>
                                </td>
                                <td style="padding: 1.5rem;">
                                    @if($plan->is_active)
                                        <span style="background: rgba(16, 185, 129, 0.1); color: var(--success); padding: 0.25rem 0.75rem; border-radius: 6px; font-size: 0.75rem; font-weight: 700;">AKTIF</span>
                                    @else
                                        <span style="background: var(--bg-alt); color: var(--text-muted); padding: 0.25rem 0.75rem; border-radius: 6px; font-size: 0.75rem; font-weight: 700;">NONAKTIF</span>
                                    @endif
                                </td>
                                <td style="padding: 1.5rem; text-align: right;">
                                    <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                        <a href="{{ route('admin.plan.edit', $plan) }}" class="btn btn-outline btn-sm" style="padding: 0.5rem;"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.plan.destroy', $plan) }}" method="POST" onsubmit="return confirm('Hapus paket ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline btn-sm" style="padding: 0.5rem; color: var(--error); border-color: var(--error);"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div style="margin-top: 2rem;">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
            </div>
        </div>
    </section>
@endsection
