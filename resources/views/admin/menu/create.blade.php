@extends('layouts.app')

@section('title', (isset($menu) ? 'Edit' : 'Tambah') . ' Menu')

@section('content')
    <section class="admin-menu-form" style="padding: 120px 0 80px; background: var(--bg-alt); min-height: 100vh;">
        <div class="container" style="max-width: 800px;">
            <div class="section-header animate-on-scroll" style="text-align: left; margin-bottom: 3rem;">
                <h4 style="color: var(--primary); font-weight: 600; margin-bottom: 0.5rem;">Admin Panel</h4>
                <h1 style="font-size: 2.5rem;">{{ isset($menu) ? 'Edit' : 'Tambah' }} <span>Menu NutriBox</span></h1>
            </div>

            <div class="animate-on-scroll" style="background: white; padding: 2.5rem; border-radius: 24px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
                <form action="{{ isset($menu) ? route('admin.menu.update', $menu->id) : route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($menu)) @method('PUT') @endif

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase;">Nama Menu</label>
                            <input type="text" name="name" value="{{ $menu->name ?? old('name') }}" required style="width: 100%; border: 1px solid var(--border); padding: 0.75rem; border-radius: 10px; outline: none;">
                        </div>
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase;">Kategori</label>
                            <select name="category" required style="width: 100%; border: 1px solid var(--border); padding: 0.75rem; border-radius: 10px; outline: none; background: white;">
                                <option value="Lunch" {{ (isset($menu) && $menu->category == 'Lunch') ? 'selected' : '' }}>Lunch</option>
                                <option value="Dinner" {{ (isset($menu) && $menu->category == 'Dinner') ? 'selected' : '' }}>Dinner</option>
                                <option value="Breakfast" {{ (isset($menu) && $menu->category == 'Breakfast') ? 'selected' : '' }}>Breakfast</option>
                                <option value="Snack" {{ (isset($menu) && $menu->category == 'Snack') ? 'selected' : '' }}>Snack</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase;">Kalori (kkal)</label>
                            <input type="number" name="calories" value="{{ $menu->calories ?? old('calories') }}" required style="width: 100%; border: 1px solid var(--border); padding: 0.75rem; border-radius: 10px; outline: none;">
                        </div>
                        <div class="form-group">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase;">Dietary Type</label>
                            <select name="dietary_type" required style="width: 100%; border: 1px solid var(--border); padding: 0.75rem; border-radius: 10px; outline: none; background: white;">
                                <option value="Standard" {{ (isset($menu) && $menu->dietary_type == 'Standard') ? 'selected' : '' }}>Standard</option>
                                <option value="Vegetarian" {{ (isset($menu) && $menu->dietary_type == 'Vegetarian') ? 'selected' : '' }}>Vegetarian</option>
                                <option value="Vegan" {{ (isset($menu) && $menu->dietary_type == 'Vegan') ? 'selected' : '' }}>Vegan</option>
                                <option value="Keto" {{ (isset($menu) && $menu->dietary_type == 'Keto') ? 'selected' : '' }}>Keto</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase;">Deskripsi Singkat</label>
                        <textarea name="description" rows="3" required style="width: 100%; border: 1px solid var(--border); padding: 0.75rem; border-radius: 10px; outline: none; resize: none;">{{ $menu->description ?? old('description') }}</textarea>
                    </div>

                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.8125rem; color: var(--text-muted); text-transform: uppercase;">Foto Menu</label>
                        <input type="file" name="image" style="width: 100%; border: 1px solid var(--border); padding: 0.75rem; border-radius: 10px; outline: none;">
                        @if(isset($menu) && $menu->image_url)
                            <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
                                <p style="font-size: 0.75rem; color: var(--text-muted);">Foto Saat Ini:</p>
                                <img src="{{ $menu->image_url }}" style="width: 50px; height: 50px; border-radius: 4px; object-fit: cover;">
                            </div>
                        @endif
                    </div>

                    <div style="display: flex; gap: 1rem; margin-top: 2.5rem;">
                        <button type="submit" class="btn btn-primary" style="flex: 1;">{{ isset($menu) ? 'Simpan Perubahan' : 'Buat Menu' }}</button>
                        <a href="{{ route('admin.menu.index') }}" class="btn btn-outline" style="flex: 1; text-align: center;">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
