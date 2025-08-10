@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1>Daftar Portofolio</h1>
    <a href="{{ route('admin.portfolio.create') }}" class="btn btn-success mb-3">Tambah Portofolio</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Link</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($portfolios as $portfolio)
            <tr>
                <td>{{ $portfolio->title }}</td>
                <td>{{ $portfolio->description }}</td>
                <td>
                    @if($portfolio->image)
                        <img src="{{ asset('storage/' . $portfolio->image) }}" width="80">
                    @endif
                </td>
                <td>
                    @if($portfolio->link)
                        <a href="{{ $portfolio->link }}" target="_blank">Lihat</a>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.portfolio.edit', $portfolio->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('admin.portfolio.destroy', $portfolio->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
