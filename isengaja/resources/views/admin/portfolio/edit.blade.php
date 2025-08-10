@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1>Edit Portofolio</h1>
    <form action="{{ route('admin.portfolio.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="title" class="form-control" value="{{ $portfolio->title }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" required>{{ $portfolio->description }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Gambar</label>
            <input type="file" name="image" class="form-control">
            @if($portfolio->image)
            <img src="{{ asset('storage/' . $portfolio->image) }}" width="120" class="mt-2">
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Link</label>
            <input type="url" name="link" class="form-control" value="{{ $portfolio->link }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
