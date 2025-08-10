@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Portofolio</h1>
    <div class="row">
        @foreach($portfolios as $portfolio)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($portfolio->image)
                <img src="{{ asset('storage/' . $portfolio->image) }}" class="card-img-top" alt="{{ $portfolio->title }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $portfolio->title }}</h5>
                    <p class="card-text">{{ $portfolio->description }}</p>
                    @if($portfolio->link)
                    <a href="{{ $portfolio->link }}" class="btn btn-primary" target="_blank">Lihat</a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
