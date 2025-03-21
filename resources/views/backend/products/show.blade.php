@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>تفاصيل المنتج</h1>
        <div>
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> تعديل
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-circle-right me-1"></i> العودة للمنتجات
            </a>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h2>{{ $product->title }}</h2>
                    @if($product->sub_title)
                        <h5 class="text-muted">{{ $product->sub_title }}</h5>
                    @endif
                    
                    <div class="mt-4">
                        <h5>معلومات المنتج</h5>
                        <table class="table table-bordered">
                            <tbody>
                                @if($product->category)
                                <tr>
                                    <th style="width: 150px;">التصنيف</th>
                                    <td>{{ $product->category }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>الترتيب</th>
                                    <td>{{ $product->sort_order }}</td>
                                </tr>
                                <tr>
                                    <th>منتج مميز</th>
                                    <td>{!! $product->featured ? '<span class="badge bg-success">نعم</span>' : '<span class="badge bg-secondary">لا</span>' !!}</td>
                                </tr>
                                <tr>
                                    <th>تاريخ الإنشاء</th>
                                    <td>{{ $product->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>آخر تحديث</th>
                                    <td>{{ $product->updated_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    @if($product->description)
                    <div class="mt-4">
                        <h5>الوصف</h5>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="col-md-6">
                    <div class="text-center">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->title }}" class="img-fluid rounded" style="max-height: 400px;">
                        @else
                            <div class="p-5 bg-light text-center rounded">
                                <i class="fas fa-image fa-5x text-muted"></i>
                                <p class="mt-3">لا توجد صورة للمنتج</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="border-top mt-4 pt-4 text-center">
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> حذف المنتج
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 