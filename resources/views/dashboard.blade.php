@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Dashboard Header -->
    <section class="dashboard-header" style="background: var(--bg-alt); padding: 120px 0 60px;">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 2rem;">
                <div class="animate-on-scroll">
                    <h4 style="color: var(--primary); font-weight: 600; margin-bottom: 0.5rem;">Selamat Datang Kembali,</h4>
                    <h1 style="font-size: 2.5rem;">{{ $user->name }} 👋</h1>
                </div>
                <div class="animate-on-scroll" style="display: flex; gap: 1rem;">
                    <a href="{{ route('menu') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Langganan Baru</a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="feature-grid" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); margin-top: 3rem;">
                <div class="feature-card animate-on-scroll" style="padding: 1.5rem; text-align: center;">
                    <div style="font-size: 2rem; color: var(--primary); margin-bottom: 0.5rem;"><i class="fas fa-calendar-check"></i></div>
                    <h2 style="font-size: 1.75rem; margin-bottom: 0.25rem;">{{ $activeCount }}</h2>
                    <p style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Paket Aktif</p>
                </div>
                <div class="feature-card animate-on-scroll" style="padding: 1.5rem; text-align: center;">
                    <div style="font-size: 2rem; color: #fbbf24; margin-bottom: 0.5rem;"><i class="fas fa-box"></i></div>
                    <h2 style="font-size: 1.75rem; margin-bottom: 0.25rem;">{{ $activeWeeks }}</h2>
                    <p style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Total Minggu</p>
                </div>
                <div class="feature-card animate-on-scroll" style="padding: 1.5rem; text-align: center;">
                    <div style="font-size: 2rem; color: #818cf8; margin-bottom: 0.5rem;"><i class="fas fa-wallet"></i></div>
                    <h2 style="font-size: 1.75rem; margin-bottom: 0.25rem;">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h2>
                    <p style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Pengeluaran</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Dashboard Content -->
    <section class="dashboard-main" style="padding-bottom: 100px;">
        <div class="container">
            <div class="hero-grid" style="grid-template-columns: 2fr 1fr; align-items: flex-start;">
                <!-- Active Subscriptions -->
                <div class="dashboard-content animate-on-scroll">
                    <h3 style="margin-bottom: 2rem; font-size: 1.5rem;">Langganan <span>Aktif</span></h3>
                    
                    @if($activeSubscriptions->count() > 0)
                        @foreach($activeSubscriptions as $sub)
                            <div class="subscription-card" style="background: white; border-radius: 20px; border: 1px solid var(--border); padding: 1.5rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                                <div style="display: flex; gap: 1.5rem; align-items: center;">
                                    <div style="width: 60px; height: 60px; border-radius: 12px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.5rem;"><i class="fas fa-utensils"></i></div>
                                    <div>
                                        <h4 style="margin: 0; font-size: 1.125rem;">Paket {{ ucfirst($sub->plan->name) }}</h4>
                                        <p style="margin: 0; font-size: 0.875rem; color: var(--text-muted);">Mulai: {{ $sub->start_date->format('d M Y') }} • @if($sub->status == 'active') <span style="color: var(--success); font-weight: 700;">Aktif</span> @else <span style="color: #fbbf24; font-weight: 700;">Dijeda</span> @endif</p>
                                    </div>
                                </div>
                                <div style="display: flex; gap: 0.75rem;">
                                    <button onclick="pauseSubscription({{ $sub->id }})" class="btn btn-ghost btn-sm" style="border: 1px solid var(--border); {{ $sub->status == 'paused' ? 'display:none' : '' }}"><i class="fas fa-pause"></i> Jeda</button>
                                    <a href="{{ route('subscription.show', $sub->id) }}" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i> Detail</a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="background: var(--bg-alt); text-align: center; padding: 4rem; border-radius: 30px; border: 2px dashed var(--border);">
                            <div style="font-size: 3rem; color: var(--border); margin-bottom: 1.5rem;"><i class="fas fa-shopping-basket"></i></div>
                            <h4 style="margin-bottom: 1rem;">Belum ada langganan aktif</h4>
                            <p style="color: var(--text-muted); margin-bottom: 2rem;">Mulai hidup sehat sekarang dengan memilih paket yang sesuai.</p>
                            <a href="{{ route('menu') }}" class="btn btn-primary">Lihat Paket Menu</a>
                        </div>
                    @endif

                    @if($activeCount > 0)
                        <h3 style="margin: 4rem 0 2rem; font-size: 1.5rem;">Pilih Menu <span>Mingguan Anda</span></h3>
                        <p style="color: var(--text-muted); margin-bottom: 2rem;">Silakan pilih menu favorit Anda untuk dikirimkan minggu ini.</p>
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 4rem;">
                            @foreach($availableMenu as $menu)
                                <div class="menu-selection-card" style="background: white; border-radius: 20px; border: 1px solid var(--border); overflow: hidden; transition: all 0.3s ease;">
                                    <div style="position: relative; height: 150px;">
                                        <img src="{{ $menu->image_url ?? asset('images/menu-placeholder.png') }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        <div style="position: absolute; top: 10px; right: 10px; background: rgba(255,255,255,0.9); padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; color: var(--primary);">
                                            {{ $menu->calories }} kcal
                                        </div>
                                    </div>
                                    <div style="padding: 1rem;">
                                        <h5 style="margin: 0 0 0.5rem; font-size: 1rem;">{{ $menu->name }}</h5>
                                        <p style="font-size: 0.75rem; color: var(--text-muted); line-height: 1.4; height: 2.8rem; overflow: hidden; margin-bottom: 1rem;">{{ $menu->description }}</p>
                                        <button onclick="addToSelection({{ $menu->id }}, '{{ $menu->name }}')" class="btn btn-outline btn-sm" style="width: 100%;"><i class="fas fa-plus"></i> Tambah</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <h3 style="margin: 4rem 0 2rem; font-size: 1.5rem;">Riwayat <span>Pesanan</span></h3>
                    <div style="background: white; border-radius: 20px; border: 1px solid var(--border); overflow: hidden;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: var(--bg-alt); text-align: left;">
                                    <th style="padding: 1rem 1.5rem; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">Paket</th>
                                    <th style="padding: 1rem 1.5rem; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">Tanggal</th>
                                    <th style="padding: 1rem 1.5rem; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">Harga</th>
                                    <th style="padding: 1rem 1.5rem; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted);">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderHistory as $order)
                                    <tr style="border-top: 1px solid var(--border);">
                                        <td style="padding: 1.25rem 1.5rem; font-weight: 600;">Paket {{ ucfirst($order->plan->name) }}</td>
                                        <td style="padding: 1.25rem 1.5rem; font-size: 0.875rem;">{{ $order->created_at->format('d M Y') }}</td>
                                        <td style="padding: 1.25rem 1.5rem; font-size: 0.875rem;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td style="padding: 1.25rem 1.5rem;">
                                            <span style="font-size: 0.75rem; font-weight: 700; padding: 0.25rem 0.75rem; border-radius: 6px; 
                                                @if($order->status == 'active') background: rgba(16, 185, 129, 0.1); color: var(--success);
                                                @elseif($order->status == 'completed') background: rgba(79, 70, 229, 0.1); color: #4f46e5;
                                                @else background: rgba(245, 158, 11, 0.1); color: #f59e0b; @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="dashboard-sidebar animate-on-scroll">
                    <div style="background: white; border-radius: 20px; border: 1px solid var(--border); padding: 2rem; position: sticky; top: 100px;">
                        <h4 style="margin-bottom: 1.5rem; font-size: 1.125rem;">Profil <span>Nutrisi</span></h4>
                        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                            <!-- ... existing info ... -->
                        </div>
                        
                        <div id="selection-summary" style="margin-top: 2rem; padding-top: 2rem; border-top: 2px dashed var(--border); display: none;">
                            <h4 style="margin-bottom: 1rem; font-size: 1rem;">Menu Terpilih (<span id="selection-count">0</span>)</h4>
                            <div id="selection-list" style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.5rem;"></div>
                            <button onclick="submitSelection()" class="btn btn-primary" style="width: 100%;">Konfirmasi Menu</button>
                        </div>
                        
                        <a href="{{ route('profile.edit') }}" class="btn btn-ghost" style="width: 100%; margin-top: 2rem; border: 1px solid var(--border);"><i class="fas fa-user-edit"></i> Edit Profil</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        let currentSelection = [];
        let activeSubId = {{ $activeSubscriptions->first()->id ?? 'null' }};

        function addToSelection(id, name) {
            if (!currentSelection.find(i => i.id === id)) {
                currentSelection.push({ id, name });
                updateSelectionUI();
            }
        }

        function removeFromSelection(id) {
            currentSelection = currentSelection.filter(i => i.id !== id);
            updateSelectionUI();
        }

        function updateSelectionUI() {
            const summary = document.getElementById('selection-summary');
            const list = document.getElementById('selection-list');
            const count = document.getElementById('selection-count');
            
            if (currentSelection.length > 0) {
                summary.style.display = 'block';
                count.innerText = currentSelection.length;
                list.innerHTML = currentSelection.map(item => `
                    <span style="background: var(--primary-light); color: var(--primary); padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: flex; align-items: center; gap: 5px;">
                        ${item.name} 
                        <i class="fas fa-times" style="cursor: pointer;" onclick="removeFromSelection(${item.id})"></i>
                    </span>
                `).join('');
            } else {
                summary.style.display = 'none';
            }
        }

        function submitSelection() {
            if (!activeSubId) return;
            
            fetch('{{ route("selection.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    subscription_id: activeSubId,
                    menu_item_ids: currentSelection.map(i => i.id)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    currentSelection = [];
                    updateSelectionUI();
                    location.reload();
                }
            });
        }

        function pauseSubscription(id) {
            if (confirm('Apakah Anda yakin ingin menjeda langganan ini?')) {
                fetch('{{ route("api.subscription.pause") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ subscription_id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    }
                });
            }
        }
    </script>
    @endpush
@endsection
