@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">لوحة التحكم الرئيسية</h1>
    
    <!-- Maintenance Mode Warning -->
    @if(isset($maintenanceMode) && $maintenanceMode)
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
            <div>
                <strong>تنبيه!</strong> موقعك حاليًا في وضع الصيانة. الزوار لا يمكنهم الوصول إلى الموقع، فقط المديرين يمكنهم الوصول إلى لوحة التحكم.
                <div class="mt-2">
                    <a href="{{ route('settings.index') }}" class="btn btn-sm btn-light">تعديل الإعدادات</a>
                    <a href="{{ route('maintenance.preview') }}" target="_blank" class="btn btn-sm btn-outline-light ms-2">معاينة صفحة الصيانة</a>
                </div>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">إجمالي الأقسام</h6>
                            <h2 class="mb-0">{{ $stats['sections'] }}</h2>
                        </div>
                        <i class="fas fa-layer-group fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer bg-primary">
                    <a href="{{ route('sections.index') }}" class="text-white text-decoration-none">
                        عرض التفاصيل <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">إجمالي المنتجات</h6>
                            <h2 class="mb-0">{{ $stats['products'] }}</h2>
                        </div>
                        <i class="fas fa-box fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer bg-success">
                    <a href="{{ route('products.index') }}" class="text-white text-decoration-none">
                        عرض التفاصيل <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">رسائل التواصل</h6>
                            <h2 class="mb-0">{{ $stats['contacts'] }}</h2>
                            <small>{{ $stats['unread_contacts'] }} غير مقروءة</small>
                        </div>
                        <i class="fas fa-envelope fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer bg-warning">
                    <a href="{{ route('contacts.index') }}" class="text-white text-decoration-none">
                        عرض التفاصيل <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Latest Contacts -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">آخر رسائل التواصل</h5>
                </div>
                <div class="card-body">
                    @if($latest_contacts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الموضوع</th>
                                    <th>التاريخ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latest_contacts as $contact)
                                <tr>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->subject }}</td>
                                    <td>{{ $contact->created_at->format('Y-m-d') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-center">لا توجد رسائل تواصل حتى الآن.</p>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('contacts.index') }}" class="btn btn-sm btn-primary">
                        عرض جميع الرسائل
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Latest Products -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">آخر المنتجات</h5>
                </div>
                <div class="card-body">
                    @if($latest_products->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>العنوان</th>
                                    <th>القسم</th>
                                    <th>مميز</th>
                                    <th>التاريخ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latest_products as $product)
                                <tr>
                                    <td>{{ $product->title }}</td>
                                    <td>{{ $product->category }}</td>
                                    <td>{!! $product->featured ? '<span class="badge bg-success">نعم</span>' : '<span class="badge bg-secondary">لا</span>' !!}</td>
                                    <td>{{ $product->created_at->format('Y-m-d') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-center">لا توجد منتجات حتى الآن.</p>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary">
                        عرض جميع المنتجات
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 