@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>النسخ الاحتياطي والاستعادة</h1>
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
    
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">إعادة تعيين البيانات</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>تحذير:</strong> إعادة تعيين البيانات سيؤدي إلى حذف البيانات الحالية واستبدالها بالبيانات الافتراضية.
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>اسم الجدول</th>
                            <th>الوصف</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($seeders as $key => $seeder)
                        <tr>
                            <td><strong>{{ $seeder['table'] }}</strong></td>
                            <td>{{ $seeder['description'] }}</td>
                            <td>
                                <form action="{{ route('backup.reset') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="seeder" value="{{ $seeder['class'] }}">
                                    <input type="hidden" name="table" value="{{ $seeder['table'] }}">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('هل أنت متأكد من إعادة تعيين جدول {{ $seeder['table'] }}؟ سيتم حذف جميع البيانات الحالية.')">
                                        <i class="fas fa-sync-alt me-1"></i> إعادة تعيين
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">إعادة تعيين جميع البيانات</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>تحذير:</strong> إعادة تعيين جميع البيانات سيؤدي إلى حذف جميع البيانات الحالية واستبدالها بالبيانات الافتراضية.
            </div>
            
            <div class="text-center">
                <form action="{{ route('backup.reset') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="seeder" value="DatabaseSeeder">
                    <input type="hidden" name="table" value="all">
                    <button type="submit" class="btn btn-danger btn-lg" onclick="return confirm('هل أنت متأكد من إعادة تعيين جميع البيانات؟ سيتم حذف جميع البيانات الحالية.')">
                        <i class="fas fa-sync-alt me-1"></i> إعادة تعيين جميع البيانات
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 