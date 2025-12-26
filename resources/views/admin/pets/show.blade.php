@extends('layouts.app')

@section('title', $pet->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                 @if($pet->image)
                    <img src="{{ $pet->image_url }}" 
                            class="card-img-top" alt="{{ $pet->name }}" style="height: 480px; object-fit: cover;">
                @else
                    <img src="/images/default-pet.jpg" 
                            class="card-img-top" alt="{{ $pet->name }}" style="height: 480px; object-fit: cover;">
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">{{ $pet->name }}</h2>
                    
                    <div class="mb-3">
                        <span class="badge bg-primary">{{ $pet->category->name ?? 'N/A' }}</span>
                        @if($pet->is_featured)
                            <span class="badge bg-warning">Nổi bật</span>
                        @endif
                        <span class="badge bg-{{ $pet->is_active ? 'success' : 'danger' }}">
                            {{ $pet->is_active ? 'Đang bán' : 'Ngừng bán' }}
                        </span>
                    </div>

                    @if($pet->sale_price)
                        <h3 class="text-danger">
                            {{ $pet->formatted_price }}
                        </h3>
                        <h3 class="text-danger">
                            {{ $pet->formatted_price }}
                        </h3>
                    @else
                        <h3 class="text-danger">{{ $pet->formatted_price }}</h3>
                    @endif
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tuổi:</strong> {{ $pet->age }} tháng</p>
                            <p><strong>Giới tính:</strong> {{ $pet->gender_text }}</p>
                            <p><strong>Màu sắc:</strong> {{ $pet->color }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Cân nặng:</strong> {{ intval($pet->weight) }} kg</p>
                            <p><strong>Tình trạng vaccine:</strong> {{ $pet->vaccination_text }}</p> 
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h5>Mô tả:</h5>
                    <p>{{ $pet->description }}</p>
                    
                    <div class="mt-4">
                        <a href="{{ route('admin.pets.edit', $pet) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a>
                        <a href="{{ route('pets.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection