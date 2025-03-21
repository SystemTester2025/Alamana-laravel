@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>معرض الصور</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadImageModal">
            <i class="fas fa-plus me-1"></i> رفع صورة جديدة
        </button>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all">كل الصور</a>
                </li>
            </ul>
            
            <div class="tab-content">
                <div class="tab-pane fade show active" id="all">
                    <div class="row" id="image-gallery">
                        @forelse($images as $image)
                            <div class="col-md-3 col-sm-6 mb-4">
                                <div class="card h-100">
                                    @php
                                        $imageUrl = $image['full_url'] ?? asset($image['url']);
                                        // Check if URL is from external source and convert if needed
                                        if (strpos($imageUrl, 'http://localhost/') === 0 && request()->getPort() != 80) {
                                            $imageUrl = str_replace('http://localhost/', request()->getSchemeAndHttpHost() . '/', $imageUrl);
                                        }
                                    @endphp
                                    <img src="{{ $imageUrl }}" class="card-img-top img-thumbnail" alt="{{ $image['name'] }}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h6 class="card-title text-truncate" title="{{ $image['name'] }}">{{ $image['name'] }}</h6>
                                        <p class="card-text small text-muted">{{ $image['size'] }}</p>
                                    </div>
                                    <div class="card-footer d-flex justify-content-between">
                                        <button type="button" class="btn btn-sm btn-outline-secondary copy-btn" data-path="{{ $imageUrl }}">
                                            <i class="fas fa-copy"></i> نسخ المسار
                                        </button>
                                        @if(isset($image['id']))
                                            <form action="{{ route('images.destroy', ['image' => $image['id']]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف هذه الصورة؟')">
                                                    <i class="fas fa-trash"></i> حذف
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('images.destroy', ['image' => basename($image['url'])]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف هذه الصورة؟')">
                                                    <i class="fas fa-trash"></i> حذف
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info">
                                    لا توجد صور متاحة حالياً. قم برفع صور جديدة باستخدام زر "رفع صورة جديدة".
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Image Modal -->
<div class="modal fade" id="uploadImageModal" tabindex="-1" aria-labelledby="uploadImageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadImageModalLabel">رفع صورة جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">عنوان الصورة (اختياري)</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">اختر صورة</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        <div class="form-text">الصيغ المدعومة: JPG, JPEG, PNG, GIF. الحد الأقصى للحجم: 2MB</div>
                    </div>
                    <div class="mb-3">
                        <label for="alt" class="form-label">النص البديل (اختياري)</label>
                        <input type="text" class="form-control" id="alt" name="alt">
                        <div class="form-text">نص بديل للصورة يظهر إذا لم تتمكن الصورة من العرض (مهم لمحركات البحث)</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">رفع الصورة</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Copy image path to clipboard
        document.querySelectorAll('.copy-btn').forEach(button => {
            button.addEventListener('click', function() {
                const path = this.getAttribute('data-path');
                navigator.clipboard.writeText(path).then(() => {
                    // Show temporary tooltip
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-check"></i> تم النسخ';
                    setTimeout(() => {
                        this.innerHTML = originalText;
                    }, 2000);
                });
            });
        });
    });
</script>
@endsection 