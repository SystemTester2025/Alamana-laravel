@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>تعديل المحتوى</h1>
        <a href="{{ route('sections.show', $sectionPart->section_id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-circle-right me-1"></i> العودة للقسم
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('section-parts.update', $sectionPart->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="section_id" class="form-label">القسم <span class="text-danger">*</span></label>
                        <select class="form-select @error('section_id') is-invalid @enderror" id="section_id" name="section_id" required>
                            <option value="" disabled>اختر القسم</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}" {{ old('section_id', $sectionPart->section_id) == $section->id ? 'selected' : '' }}>
                                    {{ $section->name }} ({{ $section->key }})
                                </option>
                            @endforeach
                        </select>
                        @error('section_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="sort_order" class="form-label">الترتيب</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $sectionPart->sort_order) }}">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">العنوان <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $sectionPart->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="sub" class="form-label">العنوان الفرعي</label>
                        <input type="text" class="form-control @error('sub') is-invalid @enderror" id="sub" name="sub" value="{{ old('sub', $sectionPart->sub) }}">
                        @error('sub')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="key" class="form-label">المفتاح</label>
                        <input type="text" class="form-control @error('key') is-invalid @enderror" id="key" name="key" value="{{ old('key', $sectionPart->key) }}">
                        <div class="form-text">مفتاح اختياري لتحديد هذا المحتوى (مثل: feature_1, point_2)</div>
                        @error('key')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="value" class="form-label">القيمة</label>
                        <input type="text" class="form-control @error('value') is-invalid @enderror" id="value" name="value" value="{{ old('value', $sectionPart->value) }}">
                        <div class="form-text">قيمة اختيارية مرتبطة بالمفتاح</div>
                        @error('value')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="desc" class="form-label">الوصف</label>
                    <textarea class="form-control @error('desc') is-invalid @enderror" id="desc" name="desc" rows="5">{{ old('desc', $sectionPart->desc) }}</textarea>
                    @error('desc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="image" class="form-label">الصورة</label>
                    @if($sectionPart->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $sectionPart->image) }}" alt="{{ $sectionPart->title }}" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                    <div class="form-text">يجب أن تكون الصورة بصيغة jpeg, png, jpg, gif, svg وحجم أقصى 2 ميغابايت. اترك الحقل فارغا للاحتفاظ بالصورة الحالية.</div>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="border-top pt-3 text-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 