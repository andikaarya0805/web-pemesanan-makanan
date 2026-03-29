<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #NBX-{{ $subscription->id }} - NutriBox</title>
    <style>
        :root {
            --primary: #059669;
            --secondary: #1e293b;
            --text: #334155;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --bg-alt: #f8fafc;
        }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--text);
            margin: 0;
            padding: 40px;
            line-height: 1.5;
            background: white;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            border: 1px solid var(--border);
            padding: 40px;
            border-radius: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
        }
        .logo h1 {
            color: var(--primary);
            margin: 0;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }
        .logo h1 span {
            color: var(--secondary);
        }
        .invoice-details {
            text-align: right;
        }
        .invoice-details h2 {
            margin: 0;
            font-size: 2rem;
            color: var(--secondary);
            text-transform: uppercase;
        }
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        .bill-to h3, .invoice-info h3 {
            font-size: 0.875rem;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 12px;
            letter-spacing: 0.05em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        th {
            text-align: left;
            padding: 12px;
            background: var(--bg-alt);
            color: var(--text-muted);
            font-size: 0.875rem;
            text-transform: uppercase;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid var(--border);
        }
        .total-section {
            margin-left: auto;
            width: 300px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }
        .total-row.grand-total {
            border-top: 2px solid var(--primary);
            margin-top: 8px;
            padding-top: 16px;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
        }
        .footer {
            margin-top: 60px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            text-align: center;
            font-size: 0.875rem;
            color: var(--text-muted);
        }
        @media print {
            body { padding: 0; }
            .invoice-box { border: none; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="max-width: 800px; margin: 0 auto 20px; text-align: right;">
        <button onclick="window.print()" style="background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600;">Cetak Invoice</button>
        <a href="{{ route('dashboard') }}" style="color: var(--text-muted); text-decoration: none; margin-left: 15px; font-size: 0.875rem;">Kembali ke Dashboard</a>
    </div>

    <div class="invoice-box">
        <div class="header">
            <div class="logo">
                <h1>Nutri<span>Box</span></h1>
                <p style="font-size: 0.875rem; color: var(--text-muted); margin-top: 5px;">Healthy Fuel for Your Life</p>
            </div>
            <div class="invoice-details">
                <h2>INVOICE</h2>
                <p style="color: var(--text-muted); margin: 5px 0;">#NBX-{{ $subscription->id }}</p>
            </div>
        </div>

        <div class="grid">
            <div class="bill-to">
                <h3>Ditagihkan Kepada</h3>
                <p style="font-weight: 600; margin: 0;">{{ $subscription->user->name }}</p>
                <p style="margin: 5px 0; font-size: 0.875rem; color: var(--text-muted);">{{ $subscription->delivery_address }}</p>
                <p style="margin: 5px 0; font-size: 0.875rem; color: var(--text-muted);">{{ $subscription->user->phone }}</p>
            </div>
            <div class="invoice-info">
                <h3>Informasi Pesanan</h3>
                <p style="margin: 5px 0; font-size: 0.875rem;"><span style="color: var(--text-muted);">Tanggal:</span> {{ $subscription->created_at->format('d M Y') }}</p>
                <p style="margin: 5px 0; font-size: 0.875rem;"><span style="color: var(--text-muted);">Metode:</span> {{ strtoupper($subscription->payment_method) }}</p>
                <p style="margin: 5px 0; font-size: 0.875rem;"><span style="color: var(--text-muted);">Status:</span> <span style="color: var(--primary); font-weight: 600;">ACTIVE</span></p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Deskripsi Layanan</th>
                    <th style="text-align: center;">Durasi</th>
                    <th style="text-align: right;">Harga/Minggu</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div style="font-weight: 600;">Paket Langganan {{ $subscription->plan->name }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px;">Pilihan sehat untuk kebutuhan nutrisi harian Anda.</div>
                    </td>
                    <td style="text-align: center;">{{ $subscription->duration_weeks }} Minggu</td>
                    <td style="text-align: right;">Rp {{ number_format($subscription->plan->price_per_week, 0, ',', '.') }}</td>
                    <td style="text-align: right;">Rp {{ number_format($subscription->total_price, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-row">
                <span style="color: var(--text-muted);">Subtotal</span>
                <span>Rp {{ number_format($subscription->total_price, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span style="color: var(--text-muted);">Pajak (0%)</span>
                <span>Rp 0</span>
            </div>
            <div class="total-row grand-total">
                <span>TOTAL</span>
                <span>Rp {{ number_format($subscription->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="footer">
            <p style="margin-bottom: 5px;"><strong>PT NUTRIBOX INDONESIA</strong></p>
            <p style="font-size: 0.75rem;">Jl. Sehat No. 123, Kawasan Industri Hijau, Jakarta Selatan, Indonesia</p>
            <p style="font-size: 0.75rem; margin-top: 15px;">Terima kasih telah mempercayakan kesehatan Anda kepada kami.</p>
        </div>
    </div>
</body>
</html>
