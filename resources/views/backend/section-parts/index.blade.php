@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>إدارة محتويات الأقسام</h1>
        <a href="{{ route('section-parts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> إضافة محتوى جديد
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            @if($sectionParts->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="15%">القسم</th>
                            <th width="15%">العنوان</th>
                            <th width="15%">العنوان الفرعي</th>
                            <th width="10%">المفتاح</th>
                            <th width="10%">القيمة</th>
                            <th width="5%">الترتيب</th>
                            <th width="10%">الصورة</th>
                            <th width="15%">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sectionParts as $part)
                        <tr>
                            <td>{{ $part->id }}</td>
                            <td>{{ $part->section->name }}</td>
                            <td>{{ $part->title }}</td>
                            <td>{{ $part->sub ?: 'غير محدد' }}</td>
                            <td>{{ $part->key ?: 'غير محدد' }}</td>
                            <td>{{ $part->value ?: 'غير محدد' }}</td>
                            <td>{{ $part->sort_order }}</td>
                            <td>
                                @if($part->image)
                                <img src="{{ asset('storage/' . $part->image) }}" alt="{{ $part->title }}" width="50">
                                @else
                                <span class="text-muted">بدون صورة</span>
                                @endif
                            </td>
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
                <h5>لا توجد محتويات للأقسام حتى الآن</h5>
                <p>قم بإضافة محتوى جديد بالنقر على زر "إضافة محتوى جديد"</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 