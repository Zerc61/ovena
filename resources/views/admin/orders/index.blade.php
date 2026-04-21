<div>
    <!-- Walk as if you are kissing the Earth with your feet. - Thich Nhat Hanh -->
</div>
@extends('layouts.admin')
@section('title', 'Kelola Pesanan')
@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
    <h1 style="font-size:22px;font-weight:600;color:var(--cream);">Pesanan</h1>
</div>

<div class="glass-card" style="padding:0;overflow:hidden;">
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Status</th>
                    <th style="width:140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $o)
                <tr>
                    <td style="font-weight:600;color:var(--cream);">#{{ $o->id }}</td>
                    <td style="font-size:12px;color:var(--cream-muted);">{{ $o->tanggal_order->format('d M Y, H:i') }}</td>
                    <td>
                        <div style="font-size:13px;color:var(--cream);">{{ $o->user->nama }}</div>
                        <div style="font-size:11px;color:var(--cream-muted);opacity:.4;">{{ $o->no_telp_penerima }}</div>
                    </td>
                    <td style="font-size:12px;color:var(--cream-muted);">{{ $o->details->count() }} item</td>
                    <td style="font-weight:600;color:var(--gold);">{{ number_format($o->total_harga,0,'.','.') }}</td>
                    <td style="font-size:11px;text-transform:capitalize;">{{ $o->metode_pembayaran }}</td>
                    <td><span class="status-badge status-{{ $o->status }}">{{ ucfirst($o->status) }}</span></td>
                    <td>
                        <div style="display:flex;gap:4px;align-items:center;">
                            <select class="form-input" style="padding:5px 8px;font-size:11px;width:auto;min-width:80px;" onchange="updateStatus(this, {{ $o->id }})">
                                @foreach(['pending','dibayar','diproses','dikirim','selesai'] as $s)
                                <option value="{{ $s }}" {{ $o->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($orders->isEmpty())
    <div style="text-align:center;padding:40px;color:var(--cream-muted);opacity:.3;font-size:13px;">Belum ada pesanan.</div>
    @endif
</div>
<div style="display:flex;justify-content:center;margin-top:16px;">{{ $orders->links() }}</div>

{{-- Modal Update Status (untuk dikirim butuh data kurir) --}}
<div class="modal-overlay" id="statusModal">
    <div class="modal-box" style="padding:28px;max-width:440px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <h3 style="font-size:17px;font-weight:600;color:var(--cream);">Update Status #<span id="statusOrderId"></span></h3>
            <button onclick="closeStatusModal()" style="background:none;border:none;cursor:pointer;color:var(--cream-muted);"><i data-lucide="x" style="width:18px;height:18px;"></i></button>
        </div>
        <form method="POST" id="statusForm">
            @csrf @method('PUT')
            <input type="hidden" name="status" id="sStatus">
            <div id="kurirFields" style="display:none;">
                <div style="margin-bottom:12px;"><label class="form-label">Nama Kurir</label><input class="form-input" name="nama_kurir" id="sKurir" required></div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div><label class="form-label">No. Telp Kurir</label><input class="form-input" name="no_telp_kurir" id="sTelp"></div>
                    <div><label class="form-label">Plat Kendaraan</label><input class="form-input" name="plat_kendaraan" id="sPlat"></div>
                </div>
            </div>
            <div style="display:flex;gap:8px;margin-top:18px;justify-content:flex-end;">
                <button type="button" class="btn-outline" onclick="closeStatusModal()">Batal</button>
                <button type="submit" class="btn-gold">Update</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let currentOrderId = null;
function updateStatus(select, orderId) {
    const status = select.value;
    if (status === 'dikirim') {
        currentOrderId = orderId;
        document.getElementById('statusOrderId').textContent = orderId;
        document.getElementById('sStatus').value = status;
        document.getElementById('statusForm').action = '/admin/pesanan/' + orderId + '/status';
        document.getElementById('kurirFields').style.display = 'block';
        document.getElementById('statusModal').classList.add('open');
    } else {
        quickUpdate(orderId, status);
    }
}
function quickUpdate(orderId, status) {
    const form = document.createElement('form');
    form.method = 'POST'; form.action = '/admin/pesanan/' + orderId + '/status';
    form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="PUT"><input type="hidden" name="status" value="' + status + '">';
    document.body.appendChild(form); form.submit();
}
function closeStatusModal() { document.getElementById('statusModal').classList.remove('open'); }
document.getElementById('statusModal').addEventListener('click', e => { if (e.target === e.currentTarget) closeStatusModal(); });
</script>
@endpush
@endsection