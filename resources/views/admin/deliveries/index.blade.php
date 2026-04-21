@extends('layouts.admin')
@section('title', 'Pengiriman')
@section('content')
<div style="margin-bottom:20px;">
    <h1 style="font-size:22px;font-weight:600;color:var(--cream);">Pengiriman</h1>
</div>

<div class="glass-card" style="padding:0;overflow:hidden;">
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Kurir</th>
                    <th>Telepon Kurir</th>
                    <th>Kendaraan</th>
                    <th>Status</th>
                    <th>Berangkat</th>
                    <th>Sampai</th>
                    <th style="width:110px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($deliveries as $d)
                <tr>
                    <td style="font-weight:600;color:var(--cream);">#{{ $d->order_id }}</td>
                    <td>{{ $d->order->user->nama }}</td>
                    <td style="color:var(--cream);">{{ $d->nama_kurir }}</td>
                    <td style="font-size:12px;color:var(--cream-muted);">{{ $d->no_telp_kurir ?? '-' }}</td>
                    <td style="font-size:12px;color:var(--cream-muted);">{{ $d->plat_kendaraan ?? '-' }}</td>
                    <td><span class="status-badge status-{{ str_replace(' ','-',$d->status_pengantaran) }}">{{ ucfirst($d->status_pengantaran) }}</span></td>
                    <td style="font-size:12px;color:var(--cream-muted);">{{ $d->waktu_berangkat ? $d->waktu_berangkat->format('d M H:i') : '-' }}</td>
                    <td style="font-size:12px;">{{ $d->waktu_sampai ? '<span style="color:#4ade80;">'.$d->waktu_sampai->format('d M H:i').'</span>' : '-' }}</td>
                    <td>
                        @if($d->status_pengantaran !== 'terkirim')
                        <form method="POST" action="{{ route('admin.deliveries.update', $d) }}">
                            @csrf @method('PUT')
                            <input type="hidden" name="status_pengantaran" value="terkirim">
                            <button type="submit" class="btn-gold btn-sm" style="width:100%;" onclick="return confirm('Tandai sebagai terkirim?')"><i data-lucide="check" style="width:12px;height:12px;"></i> Terkirim</button>
                        </form>
                        @else
                        <span style="font-size:11px;color:#22c55e;">✓ Selesai</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($deliveries->isEmpty())
    <div style="text-align:center;padding:40px;color:var(--cream-muted);opacity:.3;font-size:13px;">Belum ada pengiriman aktif.</div>
    @endif
</div>
<div style="display:flex;justify-content:center;margin-top:16px;">{{ $deliveries->links() }}</div>
@endsection