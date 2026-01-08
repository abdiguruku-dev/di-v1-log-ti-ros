@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="w-full px-6 py-6">

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen User</h1>
            <p class="text-slate-500 text-sm">Kelola data pengguna sistem sekolah.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-xl shadow-lg hover:bg-indigo-700 transition-all flex items-center gap-2 font-bold text-sm">
            <i class="fa-solid fa-plus"></i> Tambah User
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex justify-between items-center shadow-sm">
            <span><i class="fa-solid fa-check-circle mr-2"></i> {{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold hover:text-green-900">&times;</button>
        </div>
    @endif

    <div class="bg-white/60 backdrop-blur-lg rounded-2xl p-4 shadow-sm border border-slate-200/60 mb-6">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-3 w-full md:w-auto">
            <div class="relative w-full md:w-64">
                <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari Nama / Email..." 
                       class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 bg-white/50">
            </div>
            <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded-xl hover:bg-slate-900 transition-all font-medium">
                Cari
            </button>
        </form>
    </div>

    <div class="bg-white/80 backdrop-blur-md rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Role (Jabatan)</th>
                        <th class="px-6 py-4">Terdaftar</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-indigo-50/30 transition-colors">
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-lg">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-400">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-3">
                            @foreach($user->roles as $role)
                                @php
                                    $colorClass = match($role->name) {
                                        'super-admin' => 'bg-red-100 text-red-600 border-red-200',
                                        'guru' => 'bg-indigo-100 text-indigo-600 border-indigo-200',
                                        'staff-tu' => 'bg-orange-100 text-orange-600 border-orange-200',
                                        default => 'bg-slate-100 text-slate-600 border-slate-200'
                                    };
                                @endphp
                                <span class="px-2 py-1 text-[10px] font-bold rounded-lg border {{ $colorClass }}">
                                    {{ strtoupper($role->name) }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-6 py-3">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 transition-colors">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-400">
                            <i class="fa-solid fa-user-slash text-4xl mb-3"></i>
                            <p>Belum ada data user.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    </div>

</div>
@endsection