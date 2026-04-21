@extends('layouts.admin')
@section('title', 'Kelola Produk')
@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
    <h1 style="font-size:22px;font-weight:600;color:var(--cream);">Produk</h1>
    <button class="btn-gold" onclick="openModal('add')"><i data-lucide="plus" style="width:14px;height:14px;"></i> Tambah Produk</button>
</div>

{{-- Kategori Section --}}
<div id="catSection" class="glass-card" style="margin-bottom:20px;padding:16px 20px;">
    <h3 style="font-size:13px;font-weight:600;color:var(--cream);margin-bottom:12px;">Kategori</h3>
    <form method="POST" action="{{ route('admin.categories.store') }}" style="display:flex;gap:8px;margin-bottom:12px;">
        @csrf
        <input class="form-input" name="nama_kategori" placeholder="Nama kategori baru" required style="max-width:260px;">
        <button type="submit" class="btn-gold btn-sm">Tambah</button>
    </form>
    <div style="display:flex;flex-wrap:wrap;gap:6px;">
        @foreach($categories as $cat)
        <span style="display:inline-flex;align-items:center;gap:6px;padding:5px 12px;background:rgba(201,169,110,0.06);border:1px solid rgba(201,169,110,0.1);border-radius:8px;font-size:12px;color:var(--cream-muted);">
            {{ $cat->nama_kategori }}
            <span style="font-size:10px;opacity:.4;">({{ $cat->products_count }})</span>
            <form method="POST" action="{{ route('admin.categories.delete', $cat) }}" style="display:inline;" onsubmit="return confirm('Hapus kategori ini?')">
                @csrf @method('DELETE')
                <button type="submit" style="background:none;border:none;cursor:pointer;color:rgba(248,113,113,0.5);padding:0;line-height:1;" title="Hapus"><i data-lucide="x" style="width:12px;height:12px;"></i></button>
            </form>
        </span>
        @endforeach
    </div>
</div>

{{-- Tabel Produk --}}
<div class="glass-card" style="padding:0;overflow:hidden;">
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:60px;">Gambar</th>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Fragile</th>
                    <th style="width:100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $p)
                <tr>
                    <td>
                        @if($p->image_url)
                        <img src="{{ $p->image_url }}" class="prod-img">
                        @else
                        <div class="prod-img" style="background:rgba(26,14,8,0.8);display:flex;align-items:center;justify-content:center;"><i data-lucide="image-off" style="width:18px;height:18px;color:var(--cream-muted);opacity:.3;"></i></div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:500;color:var(--cream);">{{ $p->nama_produk }}</div>
                        <div style="font-size:11px;color:var(--cream-muted);opacity:.4;margin-top:2px;max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $p->deskripsi }}</div>
                    </td>
                    <td><span style="font-size:12px;color:var(--cream-muted);">{{ $p->category->nama_kategori ?? '-' }}</span></td>
                    <td style="font-weight:600;color:var(--gold);">{{ number_format($p->harga,0,'.','.') }}</td>
                    <td>
                        <span style="color:{{ $p->stok > 5 ? 'var(--cream)' : ($p->stok > 0 ? 'var(--gold)' : '#f87171') }};">{{ $p->stok }}</span>
                    </td>
                   <td>
    @if($p->is_fragile)
        <span style="display:inline-flex;align-items:center;gap:4px;padding:4px 8px;background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.2);border-radius:6px;color:#fca5a5;font-size:11px;font-weight:500;">
            <i data-lucide="alert-triangle" style="width:12px;height:12px;"></i> Fragile
        </span>
    @else
        <span style="display:inline-flex;align-items:center;gap:4px;color:var(--cream-muted);opacity:0.4;font-size:11px;">
            <i data-lucide="package" style="width:12px;height:12px;"></i> Aman
        </span>
    @endif
</td>
                    <td>
                        <div style="display:flex;gap:4px;">
                            <button class="btn-outline btn-sm" onclick="openModal('edit', {{ $p }})" title="Edit"><i data-lucide="pencil" style="width:12px;height:12px;"></i></button>
                            <form method="POST" action="{{ route('admin.products.delete', $p) }}" onsubmit="return confirm('Hapus produk ini?')">
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
    @if($products->isEmpty())
    <div style="text-align:center;padding:40px;color:var(--cream-muted);opacity:.3;font-size:13px;">Belum ada produk.</div>
    @endif
</div>
<div style="display:flex;justify-content:center;margin-top:16px;">{{ $products->links() }}</div>

{{-- Modal Tambah/Edit --}}
<div class="modal-overlay" id="productModal">
    <div class="modal-box" style="padding:28px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <h3 style="font-size:17px;font-weight:600;color:var(--cream);" id="modalTitle">Tambah Produk</h3>
            <button onclick="closeModal()" style="background:none;border:none;cursor:pointer;color:var(--cream-muted);"><i data-lucide="x" style="width:18px;height:18px;"></i></button>
        </div>
        <form method="POST" id="productForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="POST" id="formMethod">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div style="grid-column:span 2;"><label class="form-label">Nama Produk</label><input class="form-input" name="nama_produk" id="fNama" required></div>
                <div><label class="form-label">Kategori</label><select class="form-input" name="kategori_id" id="fKategori"><option value="">Pilih...</option>@foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->nama_kategori }}</option>@endforeach</select></div>
                <div><label class="form-label">Harga</label><input class="form-input" type="number" name="harga" id="fHarga" min="0" required></div>
                <div><label class="form-label">Stok</label><input class="form-input" type="number" name="stok" id="fStok" min="0" required></div>
                <div><label class="form-label">Umur Simpan (hari)</label><input class="form-input" type="number" name="umur_simpan" id="fUmur" min="1"></div>
                <div style="grid-column:span 2;"><label class="form-label">Deskripsi</label><textarea class="form-input" name="deskripsi" id="fDesk" rows="2"></textarea></div>
                <div><label class="form-label">Gambar</label><input class="form-input" type="file" name="url_gambar" accept="image/*" id="fGambar"><div style="font-size:10px;color:var(--cream-muted);opacity:.3;margin-top:3px;">JPG/PNG/WEBP, max 2MB</div></div>
                <div style="display:flex;align-items:flex-end;padding-bottom:2px;">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:12px;color:var(--cream-muted);">
                        <input type="checkbox" name="is_fragile" id="fFragile" value="1" checked style="accent-color:var(--gold);">
                        Fragile (mudah hancur)
                    </label>
                </div>
            </div>
            <div style="display:flex;gap:8px;margin-top:18px;justify-content:flex-end;">
                <button type="button" class="btn-outline" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-gold">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openModal(mode, data) {
    const modal = document.getElementById('productModal');
    const title = document.getElementById('modalTitle');
    const form = document.getElementById('productForm');
    const method = document.getElementById('formMethod');

    if (mode === 'edit' && data) {
        title.textContent = 'Edit Produk';
        form.action = '{{ route("admin.products.update", 0) }}'.replace('/0', '/' + data.id);
        method.value = 'PUT';
        document.getElementById('fNama').value = data.nama_produk;
        document.getElementById('fKategori').value = data.kategori_id || '';
        document.getElementById('fHarga').value = data.harga;
        document.getElementById('fStok').value = data.stok;
        document.getElementById('fUmur').value = data.umur_simpan || '';
        document.getElementById('fDesk').value = data.deskripsi || '';
        document.getElementById('fFragile').checked = data.is_fragile === true || data.is_fragile === 1;
    } else {
        title.textContent = 'Tambah Produk';
        form.action = '{{ route("admin.products.store") }}';
        method.value = 'POST';
        form.reset();
        document.getElementById('fFragile').checked = true;
    }
    modal.classList.add('open');
}
function closeModal() { document.getElementById('productModal').classList.remove('open'); }
document.getElementById('productModal').addEventListener('click', e => { if (e.target === e.currentTarget) closeModal(); });
</script>
@endpush
@endsection