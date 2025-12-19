@extends('layouts.app')

@section('title', 'Danh sách thú cưng')

@section('content')
<div class="container-fluid py-4">

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Bộ lọc</h5>
                </div>
                <div class="card-body">
                    <form id="filter-form" action="{{ route('pets.index') }}" method="GET">
                        <!-- Search -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Tìm kiếm</label>
                            <div class="input-group">
                                <input type="text" 
                                       name="keyword" 
                                       class="form-control" 
                                       placeholder="Tên thú cưng..."
                                       value="{{ request('keyword') }}">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Danh mục</label>
                            <div class="list-group">
                                <a href="{{ route('pets.index') }}" 
                                   class="list-group-item list-group-item-action {{ !request('category') ? 'active' : '' }}">
                                    Tất cả danh mục
                                </a>
                                @foreach($categories as $category)
                                    <a href="{{ route('pets.index', ['category' => $category->slug]) }}" 
                                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ request('category') == $category->slug ? 'active' : '' }}">
                                        {{ $category->name }}
                                        <span class="badge bg-primary rounded-pill">?</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Khoảng giá</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" 
                                           name="min_price" 
                                           class="form-control" 
                                           placeholder="Từ" 
                                           value="{{ request('min_price') }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" 
                                           name="max_price" 
                                           class="form-control" 
                                           placeholder="Đến" 
                                           value="{{ request('max_price') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Giới tính</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="gender" id="gender_all" 
                                       value="" {{ !request('gender') ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="gender_all">Tất cả</label>
                                
                                <input type="radio" class="btn-check" name="gender" id="gender_male" 
                                       value="male" {{ request('gender') == 'male' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="gender_male">Đực</label>
                                
                                <input type="radio" class="btn-check" name="gender" id="gender_female" 
                                       value="female" {{ request('gender') == 'female' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="gender_female">Cái</label>
                            </div>
                        </div>

                        <!-- Vaccination Status -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Tình trạng vaccine</label>
                            <div class="list-group">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="vaccination_status" 
                                           id="vaccine_all" value="" {{ !request('vaccination_status') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="vaccine_all">
                                        Tất cả
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="vaccination_status" 
                                           id="vaccine_fully" value="fully" {{ request('vaccination_status') == 'Đã tiêm đầy đủ' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="vaccine_fully">
                                        <span class="badge bg-success">Đã tiêm đủ</span>
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="vaccination_status" 
                                           id="vaccine_partial" value="partial" {{ request('vaccination_status') == 'Đã tiêm một phần' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="vaccine_partial">
                                        <span class="badge bg-warning">Tiêm một phần</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="vaccination_status" 
                                           id="vaccine_none" value="none" {{ request('vaccination_status') == 'Chưa tiêm' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="vaccine_none">
                                        <span class="badge bg-secondary">Chưa tiêm</span>
                                    </label>
                                </div>
                            </div>
                        </div>


                        <!-- Action Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Áp dụng bộ lọc
                            </button>
                            <a href="{{ route('pets.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Xóa bộ lọc
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Danh sách thú cưng</h2>
                    <p class="text-muted mb-0">
                        @if(request()->anyFilled(['category', 'gender', 'vaccination_status', 'min_price', 'max_price']))
                            {{ $pets->total() }} kết quả tìm thấy
                        @else
                            Tất cả thú cưng ({{ $pets->total() }})
                        @endif
                    </p>
                </div>
                    <a href="{{ route('admin.pets.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Thêm thú cưng
                    </a>
            </div>

            <!-- Active Filters -->
            @if(request()->anyFilled(['category', 'gender', 'vaccination_status', 'min_price', 'max_price', 'min_age', 'max_age']))
                <div class="alert alert-info mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Bộ lọc đang áp dụng:</strong>
                            @if(request('category'))
                                @php
                                    $cat = \App\Models\Category::where('slug', request('category'))->first();
                                @endphp
                                @if($cat)
                                    <span class="badge bg-primary ms-2">{{ $cat->name }}</span>
                                @endif
                            @endif
                            @if(request('gender'))
                                <span class="badge bg-primary ms-2">
                                    {{ request('gender') == 'male' ? 'Đực' : 'Cái' }}
                                </span>
                            @endif
                            @if(request('vaccination_status'))
                                <span class="badge bg-primary ms-2">
                                    @if(request('vaccination_status') == 'fully')
                                        Đã tiêm đủ
                                    @elseif(request('vaccination_status') == 'partial')
                                        Tiêm một phần
                                    @else
                                        Chưa tiêm
                                    @endif
                                </span>
                            @endif
                            @if(request('min_price') || request('max_price'))
                                <span class="badge bg-primary ms-2">
                                    Giá: {{ request('min_price') ? number_format(request('min_price'), 0, ',', '.') . 'đ' : '0đ' }}
                                    - {{ request('max_price') ? number_format(request('max_price'), 0, ',', '.') . 'đ' : 'trở lên' }}
                                </span>
                            @endif
                            @if(request('min_age') || request('max_age'))
                                <span class="badge bg-primary ms-2">
                                    Tuổi: {{ request('min_age') ?? '0' }}
                                    - {{ request('max_age') ?? 'trở lên' }} tháng
                                </span>
                            @endif
                        </div>
                        <a href="{{ route('pets.index') }}" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            @endif

            <!-- Pets Grid -->
            @if($pets->count() > 0)
                <div class="row g-4">
                    @foreach($pets as $pet)
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="card pet-card h-100 border-0 shadow-sm hover-shadow">
                            <!-- Pet Image -->
                            <div class="position-relative overflow-hidden" style="height: 250px;">
                                <img src="{{ $pet->image_url }}" 
                                     class="card-img-top h-100 w-100" 
                                     alt="{{ $pet->name }}"
                                     style="object-fit: cover;">
                                
                                <!-- Status Badges -->
                                <div class="position-absolute top-0 start-0 m-3">
                                    @if($pet->is_featured)
                                        <span class="badge bg-warning">
                                            <i class="fas fa-star me-1"></i>Nổi bật
                                        </span>
                                    @endif
                                </div>
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-{{ $pet->is_active ? 'success' : 'danger' }}">
                                        {{ $pet->is_active ? 'Có sẵn' : 'Đã bán' }}
                                    </span>
                                </div>
                                
                                <!-- Category -->
                                <div class="position-absolute bottom-0 start-0 m-3">
                                    <span class="badge bg-dark bg-opacity-75">
                                        {{ $pet->category->name ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Pet Info -->
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-2">{{ $pet->name }}</h5>
                                
                                <!-- Basic Info -->
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="badge bg-info">
                                        <i class="fas fa-venus-mars me-1"></i>{{ $pet->gender_text }}
                                    </span>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-birthday-cake me-1"></i>{{ $pet->age }} tháng
                                    </span>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-weight me-1"></i>{{ intval($pet->weight) }} kg
                                    </span>
                                </div>
                                
                                <!-- Vaccination -->
                                <div class="mb-3">
                                    <span class="badge bg-{{ $pet->vaccination_status == 'fully' ? 'success' : ($pet->vaccination_status == 'partial' ? 'warning' : 'secondary') }}">
                                        <i class="fas fa-syringe me-1"></i>{{ $pet->vaccination_text }}
                                    </span>
                                </div>
                                
                                <!-- Color -->
                                @if($pet->color)
                                    <div class="mb-3">
                                        <small class="text-muted">
                                            <i class="fas fa-palette me-1"></i>Màu: {{ $pet->color }}
                                        </small>
                                    </div>
                                @endif
                                
                                <!-- Price -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <span class="fw-bold text-danger fs-5">{{ $pet->formatted_price }}</span>
                                    </div>
                                    <div>
                                        <small class="text-muted">Giá đã bao gồm VAT</small>
                                    </div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="d-grid gap-2">
                                    <a href="{{ route('pets.show', $pet->id) }}" 
                                       class="btn btn-primary">
                                        <i class="fas fa-eye me-2"></i>Xem chi tiết
                                    </a>
                                    
                                    <div class="btn-group">
                                        <a href="{{ route('admin.pets.edit', $pet) }}" 
                                           class="btn btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.pets.destroy', $pet) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Xóa thú cưng {{ $pet->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-5">
                    {{ $pets->withQueryString()->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="empty-state-icon mb-4">
                        <i class="fas fa-paw fa-4x text-muted"></i>
                    </div>
                    <h4 class="mb-3">Không tìm thấy thú cưng nào</h4>
                    <p class="text-muted mb-4">Hãy thử điều chỉnh bộ lọc hoặc quay lại sau</p>
                    <a href="{{ route('pets.index') }}" class="btn btn-primary">
                        <i class="fas fa-redo me-2"></i>Xem tất cả thú cưng
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.hover-shadow {
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
}

.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    border-color: #4dabf7;
}

.pet-card {
    border-radius: 15px;
    overflow: hidden;
}

.pet-card img {
    transition: transform 0.5s ease;
}

.pet-card:hover img {
    transform: scale(1.05);
}

.empty-state-icon {
    opacity: 0.5;
}

.sticky-top {
    position: sticky;
    z-index: 100;
}

.list-group-item.active {
    background-color: #4dabf7;
    border-color: #4dabf7;
}

.badge {
    font-weight: 500;
}
</style>
@endpush

@push('scripts')
<script>
// Auto submit filter form on change
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filter-form');
    const filterInputs = filterForm.querySelectorAll('input[type="radio"], input[type="number"]');
    
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            // For radio buttons and number inputs, submit immediately
            if (this.type === 'radio' || this.type === 'number') {
                setTimeout(() => {
                    filterForm.submit();
                }, 300);
            }
        });
        
        // For number inputs, add debounce
        if (input.type === 'number') {
            let timeout = null;
            input.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    filterForm.submit();
                }, 1000);
            });
        }
    });
});
</script>
@endpush