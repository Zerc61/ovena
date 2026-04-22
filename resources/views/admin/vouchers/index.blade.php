@extends('layouts.admin')
@section('title', 'Kelola Voucher')
@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
    <h1 style="font-size:22px;font-weight:600;color:var(--cream);">Voucher Diskon</h1>
    <button class="btn-gold" onclick="openModal('add')"><i data-lucide="plus" style="width:14px;height:14px;"></i> Buat Voucher</button>
</div>

<div class="glass-card" style="padding:0;overflow:hidden;">
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Potongan</th>
                    <th>Min. Belanja</th>
                    <th>Kuota / Sisa</th>
                    <th>Kadaluarsa</th>
                    <th>Status</th>
                    <th style="width:100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vouchers as $v)
                <tr>
                    <td><span style="font-family:monospace;font-weight:bold;color:var(--gold);background:rgba(201,169,110,0.1);padding:4px 8px;border-radius:4px;">{{ $v->kode_voucher }}</span></td>
                    <td>{{ $v->tipe === 'persen' ? $v->nilai . '%' : 'Rp ' . number_format($v->nilai,0,'.','.') }}</td>
                    <td>Rp {{ number_format($v->min_belanja,0,'.','.') }}</td>
                    <td>{{ $v->kuota ? $v->kuota . 'x' : 'Tanpa Batas' }}</td>
                    <td>{{ $v->berlaku_sampai ? \Carbon\Carbon::parse($v->berlaku_sampai)->format('d M Y') : 'Selamanya' }}</td>
                    <td>
                        @if($v->is_active && (!$v->berlaku_sampai || \Carbon\Carbon::parse($v->berlaku_sampai)->isFuture()))
                            <span style="color:#4ade80;font-size:12px;">Aktif</span>
                        @else
                            <span style="color:#fca5a5;font-size:12px;">Tidak Aktif / Expired</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:4px;">
                            <button class="btn-outline btn-sm" onclick="openModal('edit', {{ $v }})" title="Edit"><i data-lucide="pencil" style="width:12px;height:12px;"></i></button>
                            <form method="POST" action="{{ route('admin.vouchers.delete', $v) }}" onsubmit="return confirm('Hapus voucher ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger btn-sm" title="Hapus"><i data-lucide="trash-2" style="width:12px;height:12px;"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($vouchers->isEmpty())
    <div style="text-align:center;padding:40px;color:var(--cream-muted);opacity:.3;font-size:13px;">Belum ada voucher.</div>
    @endif
</div>
<div style="display:flex;justify-content:center;margin-top:16px;">{{ $vouchers->links() }}</div>

{{-- Modal --}}
<div class="modal-overlay" id="voucherModal">
    <div class="modal-box" style="padding:28px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <h3 style="font-size:17px;font-weight:600;color:var(--cream);" id="modalTitle">Tambah Voucher</h3>
            <button onclick="closeModal()" style="background:none;border:none;cursor:pointer;color:var(--cream-muted);"><i data-lucide="x" style="width:18px;height:18px;"></i></button>
        </div>
        <form method="POST" id="voucherForm">
            @csrf
            <input type="hidden" name="_method" value="POST" id="formMethod">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div style="grid-column:span 2;"><label class="form-label">Kode Voucher</label><input class="form-input" name="kode_voucher" id="fKode" placeholder="Contoh: MERDEKA50" style="text-transform:uppercase;" required></div>
                <div><label class="form-label">Tipe Diskon</label><select class="form-input" name="tipe" id="fTipe" required><option value="persen">Persentase (%)</option><option value="nominal">Nominal (Rp)</option></select></div>
                <div><label class="form-label">Nilai Diskon</label><input class="form-input" type="number" name="nilai" id="fNilai" min="1" required></div>
                <div><label class="form-label">Minimal Belanja (Rp)</label><input class="form-input" type="number" name="min_belanja" id="fMin" value="0" required></div>
                <div><label class="form-label">Batas Kuota Pengguna</label><input class="form-input" type="number" name="kuota" id="fKuota" placeholder="Kosongkan jika tak terbatas"></div>
                <div style="grid-column:span 2;"><label class="form-label">Berlaku Sampai (Opsional)</label><input class="form-input" type="date" name="berlaku_sampai" id="fTgl"></div>
                <div style="grid-column:span 2;margin-top:8px;">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;color:var(--cream-muted);">
                        <input type="checkbox" name="is_active" id="fActive" value="1" checked style="accent-color:var(--gold);"> Aktifkan Voucher Ini
                    </label>
                </div>
            </div>
            <div style="display:flex;gap:8px;margin-top:24px;justify-content:flex-end;">
                <button type="button" class="btn-outline" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-gold">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openModal(mode, data) {
    const modal = document.getElementById('voucherModal');
    const title = document.getElementById('modalTitle');
    const form = document.getElementById('voucherForm');
    const method = document.getElementById('formMethod');

    if (mode === 'edit' && data) {
        title.textContent = 'Edit Voucher';
        form.action = '{{ route("admin.vouchers.update", 0) }}'.replace('/0', '/' + data.id);
        method.value = 'PUT';
        document.getElementById('fKode').value = data.kode_voucher;
        document.getElementById('fTipe').value = data.tipe;
        document.getElementById('fNilai').value = data.nilai;
        document.getElementById('fMin').value = data.min_belanja;
        document.getElementById('fKuota').value = data.kuota || '';
        document.getElementById('fTgl').value = data.berlaku_sampai ? data.berlaku_sampai.split('T')[0] : '';
        document.getElementById('fActive').checked = data.is_active;
    } else {
        title.textContent = 'Buat Voucher';
        form.action = '{{ route("admin.vouchers.store") }}';
        method.value = 'POST';
        form.reset();
        document.getElementById('fActive').checked = true;
    }
    modal.classList.add('open');
}
function closeModal() { document.getElementById('voucherModal').classList.remove('open'); }
document.getElementById('voucherModal').addEventListener('click', e => { if (e.target === e.currentTarget) closeModal(); });
</script>
@endpush
@endsection