@extends('layouts.app')

@section('title', 'PetStore - Thiên đường thú cưng')

@section('content')

<!-- Featured Pets -->
@if(isset($featuredPets) && $featuredPets->count() > 0)
<section class="py-5">
    <div class="container">
        <div style="display: flex; align-items: center; justify-content:center; margin-bottom: 20px;">
            <h2>Thú cưng nổi bật</h2>
        </div>
        <div class="row">
            @foreach($featuredPets as $pet)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card pet-card shadow-sm h-100">
                    @if($pet->image)
                        <img src="{{ $pet->image_url }}" 
                             class="card-img-top" alt="{{ $pet->name }}" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="/images/default-pet.jpg" 
                             class="card-img-top" alt="{{ $pet->name }}" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $pet->name }}</h5>
                        <p class="card-text">
                            <small class="text-muted">{{ $pet->breed }} • {{ $pet->age }} tháng</small>
                        </p>
                        <div class="price mb-2">
                            @if($pet->sale_price)
                                <span class="text-decoration-line-through text-muted">
                                    {{ number_format($pet->price, 0, ',', '.') }}đ
                                </span>
                                <span class="text-danger fw-bold">
                                    {{ number_format($pet->sale_price, 0, ',', '.') }}đ
                                </span>
                            @else
                                <span class="fw-bold">{{ number_format($pet->price, 0, ',', '.') }}đ</span>
                            @endif
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('pets.show', $pet->id) }}" class="btn btn-outline-primary btn-sm">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- Cuối section Featured Pets -->
    @if(isset($featuredPets) && $featuredPets->count() > 0)
    <!-- ... existing code ... -->

    <div class="text-center mt-4">
        <a href="{{ route('pets.index') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-paw me-2"></i> Xem tất cả thú cưng
        </a>
    </div>
    @endif
</section>

@else
<section class="py-5">
    <div class="container text-center">
        <h2 class="mb-4">Chưa có thú cưng nổi bật</h2>
        <p class="text-muted mb-4">Hãy thêm thú cưng đầu tiên của bạn!</p>
         <a href="{{ route('admin.pets.create') }}" class="btn btn-success btn-lg">
            <i class="fas fa-plus me-2"></i> Thêm thú cưng ngay
        </a>
    </div>
</section>
@endif

<!-- Categories -->
@if(isset($categories) && $categories->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div style="display: flex; align-items: center; justify-content:center; margin-bottom: 20px;">
            <h2>Danh mục thú cưng</h2>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-info btn-sm ms-2">
                <i class="fas fa-folder-plus"></i> Thêm danh mục
            </a>
        </div>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-3 mb-3">
                <div class="category-card bg-white shadow-sm p-4 text-center">
                    <i class="fas fa-paw fa-3x mb-3 text-primary"></i>
                    <h5>{{ $category->name }}</h5>
                    <p class="text-muted">{{ $category->pets_count ?? 0 }} thú cưng</p>
                    <a href="{{ route('pets.index', ['category' => $category->slug]) }}" 
                       class="btn btn-outline-primary btn-sm">
                        Xem tất cả
                    </a>
                    <div class="btn-group">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" 
                            class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Xóa thú cưng?')">
                                Xóa
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@else
<section class="py-5">
    <div class="container text-center">
        <h2 class="mb-4">Chưa có danh mục thú cưng</h2>
        <p class="text-muted mb-4">Hãy thêm danh mục thú cưng đầu tiên của bạn!</p>
         <a href="{{ route('admin.categories.create') }}" class="btn btn-success btn-lg">
            <i class="fas fa-plus me-2"></i> Thêm danh mục thú cưng ngay
        </a>
    </div>
</section>
@endif
@endsection