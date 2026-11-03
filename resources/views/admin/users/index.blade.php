@extends('layouts.admin')
@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')
@section('breadcrumb')
    <li class="breadcrumb-item active">Users</li>
@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span><i class="fas fa-users me-2" style="color:#003d80;"></i>Daftar Pengguna</span>
            <div class="d-flex gap-2 flex-wrap">
                <form action="" method="GET" class="d-flex gap-2">
                    <select name="role" class="form-select form-select-sm" style="width:130px;"
                        onchange="this.form.submit()">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="mahasiswa" {{ request('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                    </select>
                    <input type="text" name="search" class="form-control form-control-sm" style="width:180px;"
                        placeholder="Cari nama/username..." value="{{ request('search') }}">
                    <button class="btn btn-sm btn-outline-primary">Cari</button>
                </form>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>Tambah User
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>NIM</th>
                        <th>Perhitungan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $u)
                        <tr>
                            <td>{{ $users->firstItem() + $i }}</td>
                            <td class="fw-semibold">{{ $u->nama_lengkap }}</td>
                            <td><code>{{ $u->username }}</code></td>
                            <td><small class="text-muted">{{ $u->email ?? '—' }}</small></td>
                            <td>
                                <span class="badge {{ $u->role == 'admin' ? 'bg-danger' : 'bg-primary' }}">
                                    {{ ucfirst($u->role) }}
                                </span>
                            </td>
                            <td><small>{{ $u->nim ?? '—' }}</small></td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $u->hasil_list_count ?? 0 }}×</span>
                            </td>
                            <td>
                                @if ($u->id_user !== Auth::id())
                                    <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Hapus user {{ $u->nama_lengkap }}? Semua data riwayatnya juga akan terhapus.')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-xs btn-outline-danger"
                                            style="font-size:11px;padding:3px 8px;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small">Akun Anda</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Tidak ada user ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($users->hasPages())
            <div class="card-footer">{{ $users->appends(request()->query())->links() }}</div>
        @endif
    </div>
@endsection
