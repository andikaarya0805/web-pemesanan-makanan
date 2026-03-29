@extends('layouts.app')

@section('title', 'Manajemen Menu')

@section('content')
    <section class="admin-menu" style="padding: 120px 0 80px; background: var(--bg-alt); min-height: 100vh;">
        <div class="container">
            <div class="section-header animate-on-scroll" style="text-align: left; margin-bottom: 3rem; display: flex; justify-content: space-between; align-items: flex-end;">
                <div>
                    <h4 style="color: var(--primary); font-weight: 600; margin-bottom: 0.5rem;">Admin Panel</h4>
                    <h1 style="font-size: 2.5rem;">Manajemen <span>Menu NutriBox</span></h1>
                </div>
                <a href="{{ route('admin.menu.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Menu Baru</a>
            </div>

            @if(session('success'))
                <div style="background: var(--success-light); color: var(--success); padding: 1rem; border-radius: 12px; margin-bottom: 2rem;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="menu-list animate-on-scroll">
                <div style="background: white; border-radius: 20px; border: 1px solid var(--border); overflow: hidden;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: var(--bg-alt); text-align: left;">
                                <th style="padding: 1rem 1.5rem; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">Foto</th>
                                <th style="padding: 1rem 1.5rem; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">Nama Menu</th>
                                <th style="padding: 1rem 1.5rem; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">Kategori</th>
                                <th style="padding: 1rem 1.5rem; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">Kalori</th>
                                <th style="padding: 1rem 1.5rem; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menuItems as $item)
                                <tr style="border-top: 1px solid var(--border);">
                                    <td style="padding: 1rem 1.5rem;">
                                        <img src="{{ $item->image_url ? asset($item->image_url) : asset('images/menu-placeholder.png') }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                    </td>
                                    <td style="padding: 1rem 1.5rem;">
                                        <div style="font-weight: 600;">{{ $item->name }}</div>
                                        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ ucfirst($item->dietary_type) }}</div>
                                    </td>
                                    <td style="padding: 1rem 1.5rem;">
                                        <span style="background: var(--primary-light); color: var(--primary); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">{{ $item->category }}</span>
                                    </td>
                                    <td style="padding: 1rem 1.5rem; font-weight: 600;">{{ $item->calories }} kkal</td>
                                    <td style="padding: 1rem 1.5rem;">
                                        <div style="display: flex; gap: 0.5rem;">
                                            <a href="{{ route('admin.menu.edit', $item->id) }}" class="btn-icon" style="color: var(--secondary);"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" style="background: none; border: none; color: var(--error); cursor: pointer;"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
