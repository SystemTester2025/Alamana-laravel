@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>إضافة قسم جديد</h1>
        <a href="{{ route('sections.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-circle-right me-1"></i> العودة للأقسام
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('sections.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">اسم القسم <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        <div class="form-text">سيتم استخدام هذا الاسم للعرض في لوحة التحكم</div>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="slug" class="form-label">الرابط (Slug)</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}">
                        <div class="form-text">سيتم إنشاؤه تلقائياً إذا تركته فارغاً</div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">العنوان <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="sub" class="form-label">العنوان الفرعي</label>
                        <input type="text" class="form-control @error('sub') is-invalid @enderror" id="sub" name="sub" value="{{ old('sub') }}">
                        @error('sub')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="key" class="form-label">المفتاح <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('key') is-invalid @enderror" id="key" name="key" value="{{ old('key') }}" required>
                    <div class="form-text">استخدم مفتاح فريد للقسم، مثل: hero, features, services، إلخ</div>
                    @error('key')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="desc" class="form-label">الوصف</label>
                    <textarea class="form-control @error('desc') is-invalid @enderror" id="desc" name="desc" rows="5">{{ old('desc') }}</textarea>
                    @error('desc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="border-top pt-3 text-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> حفظ القسم
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 