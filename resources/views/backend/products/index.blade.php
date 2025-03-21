@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>إدارة المنتجات</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> إضافة منتج جديد
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="15%">الصورة</th>
                            <th width="20%">العنوان</th>
                            <th width="15%">التصنيف</th>
                            <th width="10%">مميز</th>
                            <th width="10%">الترتيب</th>
                            <th width="15%">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" width="100">
                                @else
                                <span class="text-muted">بدون صورة</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $product->title }}</strong>
                                @if($product->sub_title)
                                <br><small>{{ $product->sub_title }}</small>
                                @endif
                            </td>
                            <td>{{ $product->category ?: 'غير مصنف' }}</td>
                            <td>
                                @if($product->featured)
                                <span class="badge bg-success">نعم</span>
                                @else
                                <span class="badge bg-secondary">لا</span>
                                @endif
                            </td>
                            <td>{{ $product->sort_order }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">
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
                <i class="fas fa-box fa-3x mb-3 text-muted"></i>
                <h5>لا توجد منتجات حتى الآن</h5>
                <p>قم بإضافة منتج جديد بالنقر على زر "إضافة منتج جديد"</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 