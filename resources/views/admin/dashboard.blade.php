@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <section class="admin-dashboard" style="padding: 120px 0 80px; background: var(--bg-alt); min-height: 100vh;">
        <div class="container">
            <div class="section-header animate-on-scroll" style="text-align: left; margin-bottom: 3rem; display: flex; justify-content: space-between; align-items: flex-end;">
                <div>
                    <h4 style="color: var(--primary); font-weight: 600; margin-bottom: 0.5rem;">Admin Panel</h4>
                    <h1 style="font-size: 2.5rem;">Ringkasan <span>Operasional</span></h1>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <a href="#" class="btn btn-outline btn-sm"><i class="fas fa-file-export"></i> Laporan</a>
                    <a href="{{ route('admin.menu.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Menu Baru</a>
                </div>
            </div>

            <!-- Stats Ribbon -->
            <div class="feature-grid" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); margin-bottom: 3rem;">
                <div class="feature-card animate-on-scroll" style="padding: 2rem; border-left: 5px solid var(--primary);">
                    <p style="color: var(--text-muted); font-size: 0.8125rem; font-weight: 700; text-transform: uppercase;">Total Pelanggan</p>
                    <h2 style="font-size: 2.5rem; margin: 0.5rem 0;">{{ $stats['users'] }}</h2>
                    <span style="color: var(--success); font-size: 0.8125rem; font-weight: 600;"><i class="fas fa-arrow-up"></i> 12% dari bulan lalu</span>
                </div>
                <div class="feature-card animate-on-scroll" style="padding: 2rem; border-left: 5px solid #fbbf24;">
                    <p style="color: var(--text-muted); font-size: 0.8125rem; font-weight: 700; text-transform: uppercase;">Langganan Aktif</p>
                    <h2 style="font-size: 2.5rem; margin: 0.5rem 0;">{{ $stats['active_subscriptions'] }}</h2>
                    <span style="color: var(--success); font-size: 0.8125rem; font-weight: 600;"><i class="fas fa-check"></i> Semua pengiriman on-track</span>
                </div>
                <div class="feature-card animate-on-scroll" style="padding: 2rem; border-left: 5px solid #818cf8;">
                    <p style="color: var(--text-muted); font-size: 0.8125rem; font-weight: 700; text-transform: uppercase;">Total Pendapatan</p>
                    <h2 style="font-size: 2.5rem; margin: 0.5rem 0;">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</h2>
                    <span style="color: var(--text-muted); font-size: 0.8125rem;">Estimasi kotor tahunan</span>
                </div>
                <div class="feature-card animate-on-scroll" style="padding: 2rem; border-left: 5px solid #f472b6;">
                    <p style="color: var(--text-muted); font-size: 0.8125rem; font-weight: 700; text-transform: uppercase;">Aduan/Pesan</p>
                    <h2 style="font-size: 2.5rem; margin: 0.5rem 0;">{{ $stats['pending_messages'] }}</h2>
                    <span style="color: var(--error); font-size: 0.8125rem; font-weight: 600;"><i class="fas fa-clock"></i> {{ $stats['pending_messages'] }} belum dibalas</span>
                </div>
            </div>

            <div class="hero-grid" style="grid-template-columns: 2fr 1fr; align-items: flex-start; gap: 2.5rem;">
                <!-- Recent Orders -->
                <div class="animate-on-scroll">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h3 style="font-size: 1.25rem;">Langganan <span>Terbaru</span></h3>
                        <a href="#" style="color: var(--primary); font-size: 0.875rem; font-weight: 600;">Lihat Semua <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div style="background: white; border-radius: 20px; border: 1px solid var(--border); overflow: hidden;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: var(--bg-alt); text-align: left;">
                                    <th style="padding: 1rem 1.5rem; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">User</th>
                                    <th style="padding: 1rem 1.5rem; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">Paket</th>
                                    <th style="padding: 1rem 1.5rem; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">Total</th>
                                    <th style="padding: 1rem 1.5rem; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentSubscriptions as $sub)
                                    <tr style="border-top: 1px solid var(--border);">
                                        <td style="padding: 1.25rem 1.5rem;">
                                            <div style="font-weight: 600;">{{ $sub->user->name }}</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $sub->user->email }}</div>
                                        </td>
                                        <td style="padding: 1.25rem 1.5rem;">
                                            <span style="background: var(--primary-light); color: var(--primary); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">{{ $sub->plan->name }}</span>
                                        </td>
                                        <td style="padding: 1.25rem 1.5rem; font-weight: 600;">Rp {{ number_format($sub->total_price, 0, ',', '.') }}</td>
                                        <td style="padding: 1.25rem 1.5rem;">
                                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                <span style="width: 8px; height: 8px; border-radius: 50%; background: var(--success);"></span>
                                                <span style="font-size: 0.875rem; font-weight: 600;">{{ ucfirst($sub->status) }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Messages -->
                <div class="animate-on-scroll">
                    <h3 style="font-size: 1.25rem; margin-bottom: 1.5rem;">Pesan <span>Masuk</span></h3>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        @foreach($recentMessages as $message)
                            <div style="background: white; border-radius: 16px; border: 1px solid var(--border); padding: 1.25rem; position: relative;">
                                @if($message->status == 'new')
                                    <span style="position: absolute; top: 1.25rem; right: 1.25rem; width: 8px; height: 8px; background: var(--error); border-radius: 50%;"></span>
                                @endif
                                <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 0.75rem;">
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--bg-alt); color: var(--secondary); display: flex; align-items: center; justify-content: center; font-size: 0.875rem;"><i class="fas fa-user"></i></div>
                                    <div>
                                        <h4 style="margin: 0; font-size: 0.95rem;">{{ $message->name }}</h4>
                                        <p style="margin: 0; font-size: 0.75rem; color: var(--text-muted);">Subjek: {{ ucfirst($message->subject) }}</p>
                                    </div>
                                </div>
                                <p style="font-size: 0.875rem; color: var(--text-main); line-height: 1.5; margin-bottom: 1rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">"{{ $message->message }}"</p>
                                <a href="#" style="font-size: 0.8125rem; color: var(--primary); font-weight: 700; text-transform: uppercase;">Balas Pesan <i class="fas fa-reply" style="margin-left: 0.25rem;"></i></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Quick Management Section -->
            <div style="margin-top: 4rem;">
                <h3 style="font-size: 1.5rem; margin-bottom: 2rem;">Manajemen <span>Katalog</span></h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                    <a href="{{ route('admin.menu.index') }}" style="text-decoration: none; color: inherit;">
                        <div class="feature-card animate-on-scroll" style="padding: 2.5rem; display: flex; align-items: center; gap: 2rem; border: 1px solid var(--border); transition: all 0.3s ease;">
                            <div style="width: 70px; height: 70px; border-radius: 20px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 2rem;"><i class="fas fa-utensils"></i></div>
                            <div>
                                <h4 style="margin: 0 0 0.5rem; font-size: 1.25rem;">Kelola Menu</h4>
                                <p style="margin: 0; color: var(--text-muted); font-size: 0.875rem;">Tambah, edit, atau nonaktifkan pilihan makanan mingguan.</p>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('admin.plan.index') }}" style="text-decoration: none; color: inherit;">
                        <div class="feature-card animate-on-scroll" style="padding: 2.5rem; display: flex; align-items: center; gap: 2rem; border: 1px solid var(--border); transition: all 0.3s ease;">
                            <div style="width: 70px; height: 70px; border-radius: 20px; background: rgba(129, 140, 248, 0.1); color: #818cf8; display: flex; align-items: center; justify-content: center; font-size: 2rem;"><i class="fas fa-tags"></i></div>
                            <div>
                                <h4 style="margin: 0 0 0.5rem; font-size: 1.25rem;">Kelola Harga Paket</h4>
                                <p style="margin: 0; color: var(--text-muted); font-size: 0.875rem;">Sesuaikan harga langganan berdasarkan harga bahan baku.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
