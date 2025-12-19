@extends('layouts.app')

@section('title', 'Chỉnh sửa thú cưng: ' . $pet->name)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Chỉnh sửa: {{ $pet->name }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pets.update', $pet) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên thú cưng *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $pet->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Loại *</label>
                                    <select class="form-control @error('category_id') is-invalid @enderror" 
                                            id="category_id" name="category_id" required>
                                        <option value="">Chọn loại</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                    {{ (old('category_id', $pet->category_id) == $category->id) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="price" class="form-label">Giá (VND) *</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price', $pet->price) }}" required min="0">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="age" class="form-label">Tuổi (tháng) *</label>
                                    <input type="number" class="form-control @error('age') is-invalid @enderror" 
                                           id="age" name="age" value="{{ old('age', $pet->age) }}" required min="0">
                                    @error('age')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Giới tính *</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" 
                                            id="gender" name="gender" required>
                                        <option value="">Chọn giới tính</option>
                                        <option value="male" {{ old('gender', $pet->gender) == 'male' ? 'selected' : '' }}>Đực</option>
                                        <option value="female" {{ old('gender', $pet->gender) == 'female' ? 'selected' : '' }}>Cái</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="color" class="form-label">Màu sắc *</label>
                                    <input type="text" class="form-control @error('color') is-invalid @enderror" 
                                           id="color" name="color" value="{{ old('color', $pet->color) }}" required>
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="weight" class="form-label">Cân nặng (kg) *</label>
                                    <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" 
                                           id="weight" name="weight" value="{{ old('weight', $pet->weight) }}" required min="0">
                                    @error('weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="vaccination_status" class="form-label">Tình trạng vaccine *</label>
                                    <select class="form-control @error('vaccination_status') is-invalid @enderror" 
                                            id="vaccination_status" name="vaccination_status" required>
                                        <option value="">Chọn tình trạng</option>
                                        <option value="fully" {{ old('vaccination_status', $pet->vaccination_status) == 'fully' ? 'selected' : '' }}>
                                            Đã tiêm đầy đủ
                                        </option>
                                        <option value="partial" {{ old('vaccination_status', $pet->vaccination_status) == 'partial' ? 'selected' : '' }}>
                                            Đã tiêm một phần
                                        </option>
                                        <option value="none" {{ old('vaccination_status', $pet->vaccination_status) == 'none' ? 'selected' : '' }}>
                                            Chưa tiêm
                                        </option>
                                    </select>
                                    @error('vaccination_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" 
                                               id="is_featured" name="is_featured" value="1" 
                                               {{ old('is_featured', $pet->is_featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">Đánh dấu nổi bật</label>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" 
                                               id="is_active" name="is_active" value="1" 
                                               {{ old('is_active', $pet->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">Đang hoạt động</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description', $pet->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Hình ảnh thú cưng</label>
                            
                            @if(asset($pet->image))
                                <div class="mb-2">
                                    <img src="{{ $pet->image_url }}" alt="{{ $pet->name }}" 
                                        class="img-thumbnail" style="max-height: 200px;">
                                </div>
                            @endif
                            
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Để trống nếu không thay đổi ảnh</small>
                            
                            <div id="image-preview" class="mt-2 text-center"></div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('home') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Cập nhật
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection