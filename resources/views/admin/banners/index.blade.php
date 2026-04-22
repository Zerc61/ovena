@extends('layouts.admin')
@section('title', 'Kelola Banner Promo')
@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
    <h1 style="font-size:22px;font-weight:600;color:var(--cream);">Banner Promo</h1>
    <button class="btn-gold" onclick="openModal('add')"><i data-lucide="plus" style="width:14px;height:14px;"></i> Tambah Banner</button>
</div>

<div class="glass-card" style="padding:0;overflow:hidden;">
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:120px;">Gambar</th>
                    <th>Judul & Subjudul</th>
                    <th>Status</th>
                    <th style="width:100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($banners as $b)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $b->gambar_url) }}" style="width:100px;height:50px;object-fit:cover;border-radius:6px;border:1px solid rgba(201,169,110,0.2);">
                    </td>
                    <td>
                        <div style="font-weight:500;color:var(--cream);">{{ $b->judul }}</div>
                        <div style="font-size:11px;color:var(--cream-muted);opacity:.6;margin-top:2px;">{{ $b->subjudul ?: '-' }}</div>
                    </td>
                    <td>
                        @if($b->is_active)
                            <span style="padding:4px 8px;background:rgba(74,222,128,0.1);color:#4ade80;border-radius:6px;font-size:11px;">Aktif</span>
                        @else
                            <span style="padding:4px 8px;background:rgba(248,113,113,0.1);color:#fca5a5;border-radius:6px;font-size:11px;">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:4px;">
                            <button class="btn-outline btn-sm" onclick="openModal('edit', {{ $b }})" title="Edit"><i data-lucide="pencil" style="width:12px;height:12px;"></i></button>
                            <form method="POST" action="{{ route('admin.banners.delete', $b) }}" onsubmit="return confirm('Hapus banner ini?')">
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
    @if($banners->isEmpty())
    <div style="text-align:center;padding:40px;color:var(--cream-muted);opacity:.3;font-size:13px;">Belum ada banner promo.</div>
    @endif
</div>
<div style="display:flex;justify-content:center;margin-top:16px;">{{ $banners->links() }}</div>

{{-- Modal --}}
<div class="modal-overlay" id="bannerModal">
    <div class="modal-box" style="padding:28px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <h3 style="font-size:17px;font-weight:600;color:var(--cream);" id="modalTitle">Tambah Banner</h3>
            <button onclick="closeModal()" style="background:none;border:none;cursor:pointer;color:var(--cream-muted);"><i data-lucide="x" style="width:18px;height:18px;"></i></button>
        </div>
       <form method="POST" id="bannerForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="POST" id="formMethod">
            <div style="display:grid;gap:12px;">
                <div><label class="form-label">Judul Promo</label><input class="form-input" name="judul" id="fJudul" required></div>
                <div><label class="form-label">Subjudul (Opsional)</label><input class="form-input" name="subjudul" id="fSubjudul"></div>
                <div><label class="form-label">Gambar Banner</label><input class="form-input" type="file" name="gambar_url" accept="image/*" id="fGambar"></div>
                
                <div>
                    <label class="form-label">Tautkan ke Produk (Opsional)</label>
                    <select class="form-input" name="product_id" id="fProduct">
                        <option value="">-- Tidak ditautkan (Scroll ke bawah) --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_produk }}</option>
                        @endforeach
                    </select>
                    <div style="font-size:10px;color:var(--cream-muted);opacity:.5;margin-top:4px;">Pilih produk agar tombol "Pesan Sekarang" mengarah ke detail produk tersebut.</div>
                </div>

                <div style="display:flex;align-items:center;margin-top:8px;">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;color:var(--cream-muted);">
                        <input type="checkbox" name="is_active" id="fActive" value="1" checked style="accent-color:var(--gold);"> Tampilkan di Halaman Utama
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
    const modal = document.getElementById('bannerModal');
    const title = document.getElementById('modalTitle');
    const form = document.getElementById('bannerForm');
    const method = document.getElementById('formMethod');

    if (mode === 'edit' && data) {
        title.textContent = 'Edit Banner';
        form.action = '{{ route("admin.banners.update", 0) }}'.replace('/0', '/' + data.id);
        method.value = 'PUT';
        document.getElementById('fJudul').value = data.judul;
        document.getElementById('fSubjudul').value = data.subjudul || '';
        document.getElementById('fActive').checked = data.is_active;
        document.getElementById('fProduct').value = data.product_id || '';
    } else {
        title.textContent = 'Tambah Banner';
        form.action = '{{ route("admin.banners.store") }}';
        method.value = 'POST';
        form.reset();
        document.getElementById('fActive').checked = true;
        document.getElementById('fProduct').value = '';
    }
    modal.classList.add('open');
}
function closeModal() { document.getElementById('bannerModal').classList.remove('open'); }
document.getElementById('bannerModal').addEventListener('click', e => { if (e.target === e.currentTarget) closeModal(); });
</script>
@endpush
@endsection