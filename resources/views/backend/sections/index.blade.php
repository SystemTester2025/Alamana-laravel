@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>إدارة الأقسام</h1>
        <a href="{{ route('sections.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> إضافة قسم جديد
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            @if($sections->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="15%">المفتاح</th>
                            <th width="20%">العنوان</th>
                            <th width="20%">العنوان الفرعي</th>
                            <th width="25%">الوصف</th>
                            <th width="15%">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sections as $section)
                        <tr>
                            <td>{{ $section->id }}</td>
                            <td>{{ $section->key }}</td>
                            <td>{{ $section->title }}</td>
                            <td>{{ $section->sub }}</td>
                            <td>{{ Str::limit($section->desc, 50) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('sections.show', $section->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('sections.edit', $section->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('sections.destroy', $section->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا القسم؟');">
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
                <h5>لا توجد أقسام حتى الآن</h5>
                <p>قم بإضافة قسم جديد بالنقر على زر "إضافة قسم جديد"</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 