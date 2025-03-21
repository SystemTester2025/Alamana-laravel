@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>تفاصيل القسم: {{ $section->name }}</h1>
        <div>
            <a href="{{ route('sections.edit', $section->id) }}" class="btn btn-primary me-2">
                <i class="fas fa-edit me-1"></i> تعديل
            </a>
            <a href="{{ route('sections.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-circle-right me-1"></i> العودة للأقسام
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">معلومات القسم</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-3">الاسم:</dt>
                                <dd class="col-sm-9">{{ $section->name }}</dd>
                                
                                <dt class="col-sm-3">الرابط:</dt>
                                <dd class="col-sm-9">{{ $section->slug }}</dd>
                                
                                <dt class="col-sm-3">المفتاح:</dt>
                                <dd class="col-sm-9">{{ $section->key }}</dd>
                                
                                <dt class="col-sm-3">العنوان:</dt>
                                <dd class="col-sm-9">{{ $section->title }}</dd>
                                
                                <dt class="col-sm-3">العنوان الفرعي:</dt>
                                <dd class="col-sm-9">{{ $section->sub ?: 'غير محدد' }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dt>الوصف:</dt>
                            <dd>{{ $section->desc ?: 'لا يوجد وصف' }}</dd>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">محتويات القسم</h5>
                    <a href="{{ route('section-parts.create') }}?section_id={{ $section->id }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> إضافة محتوى جديد
                    </a>
                </div>
                <div class="card-body">
                    @if($section->sectionParts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>العنوان</th>
                                    <th>العنوان الفرعي</th>
                                    <th>المفتاح</th>
                                    <th>القيمة</th>
                                    <th>الترتيب</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($section->sectionParts as $part)
                                <tr>
                                    <td>{{ $part->id }}</td>
                                    <td>{{ $part->title }}</td>
                                    <td>{{ $part->sub ?: 'غير محدد' }}</td>
                                    <td>{{ $part->key ?: 'غير محدد' }}</td>
                                    <td>{{ $part->value ?: 'غير محدد' }}</td>
                                    <td>{{ $part->sort_order }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('section-parts.edit', $part->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('section-parts.destroy', $part->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المحتوى؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center p-5">
                        <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i>
                        <h5>لا يوجد محتوى لهذا القسم</h5>
                        <p>قم بإضافة محتوى جديد بالنقر على زر "إضافة محتوى جديد"</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 