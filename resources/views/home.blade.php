@extends('layouts.app')

@section('title', 'PetStore - Thiên đường thú cưng')

@section('content')
<!-- Hero Section -->
<section class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 mb-4">Chào mừng đến với PetStore</h1>
        <p class="lead mb-4">Nơi tìm thấy người bạn đồng hành hoàn hảo cho gia đình bạn</p>
        <a href="{{ route('pets.index') }}" class="btn btn-primary btn-lg">Khám phá ngay</a>
    </div>
</section>

<!-- Featured Pets -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Thú cưng nổi bật</h2>
        <div class="row">
            @foreach($featuredPets as $pet)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card pet-card shadow-sm h-100">
                    <img src="{{ $pet->main_image->image_path ?? '/images/default-pet.jpg' }}" 
                         class="card-img-top" alt="{{ $pet->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $pet->name }}</h5>
                        <p class="card-text">
                            <small class="text-muted">{{ $pet->breed }} • {{ $pet->age }} tháng</small>
                        </p>
                        <div class="price">
                            @if($pet->sale_price)
                                <span class="sale-price">{{ number_format($pet->price, 0, ',', '.') }}đ</span>
                                <span>{{ number_format($pet->sale_price, 0, ',', '.') }}đ</span>
                            @else
                                <span>{{ number_format($pet->price, 0, ',', '.') }}đ</span>
                            @endif
                        </div>
                        <a href="{{ route('pets.show', $pet->slug) }}" class="btn btn-outline-primary btn-sm mt-2">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Categories -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Danh mục thú cưng</h2>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-3 mb-3">
                <div class="category-card bg-white shadow-sm">
                    <i class="fas fa-paw fa-3x mb-3 text-primary"></i>
                    <h5>{{ $category->name }}</h5>
                    <p class="text-muted">{{ $category->pets_count ?? 0 }} thú cưng</p>
                    <a href="{{ route('pets.index', ['category' => $category->slug]) }}" class="btn btn-outline-primary">
                        Xem tất cả
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection