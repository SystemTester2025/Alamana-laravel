@extends('layouts.backend')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-lg-6 col-7">
                            <h6>سجل النشاطات</h6>
                        </div>
                        <div class="col-lg-6 col-5 my-auto text-end">
                            <form id="clearLogsForm" action="{{ route('activity-logs.clear') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف كل سجلات النشاط؟')">
                                    <i class="fas fa-trash-alt me-1"></i> حذف الكل
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="p-3">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <form action="{{ route('activity-logs.index') }}" method="GET" class="row g-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="action">الإجراء</label>
                                            <select name="action" id="action" class="form-control">
                                                <option value="">الكل</option>
                                                @foreach($actions as $action)
                                                    <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                                        @if($action == 'create')
                                                            إنشاء
                                                        @elseif($action == 'update')
                                                            تحديث
                                                        @elseif($action == 'delete')
                                                            حذف
                                                        @else
                                                            {{ $action }}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="model_type">نوع البيانات</label>
                                            <select name="model_type" id="model_type" class="form-control">
                                                <option value="">الكل</option>
                                                @foreach($modelTypes as $type)
                                                    <option value="{{ $type }}" {{ request('model_type') == $type ? 'selected' : '' }}>
                                                        @php
                                                            $typeName = basename(str_replace('\\', '/', $type));
                                                            
                                                            switch($typeName) {
                                                                case 'Product':
                                                                    echo 'منتج';
                                                                    break;
                                                                case 'Section':
                                                                    echo 'قسم';
                                                                    break;
                                                                case 'SectionPart':
                                                                    echo 'عنصر قسم';
                                                                    break;
                                                                case 'Setting':
                                                                    echo 'إعدادات';
                                                                    break;
                                                                default:
                                                                    echo $typeName;
                                                            }
                                                        @endphp
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="search">بحث</label>
                                            <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="بحث في الوصف...">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="d-block">&nbsp;</label>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search me-1"></i> بحث
                                            </button>
                                            <a href="{{ route('activity-logs.index') }}" class="btn btn-secondary">
                                                <i class="fas fa-sync me-1"></i> إعادة تعيين
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">المستخدم</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الإجراء</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">نوع البيانات</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الوصف</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">التاريخ</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">الخيارات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($logs as $log)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ asset('assets/img/user.png') }}" class="avatar avatar-sm me-3" alt="user">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $log->user_name ?? 'النظام' }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="px-2 py-1">
                                                    <span class="badge bg-{{ $log->action == 'create' ? 'success' : ($log->action == 'update' ? 'info' : 'danger') }}">
                                                        @if($log->action == 'create')
                                                            إنشاء
                                                        @elseif($log->action == 'update')
                                                            تحديث
                                                        @elseif($log->action == 'delete')
                                                            حذف
                                                        @else
                                                            {{ $log->action }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="px-2 py-1">
                                                    <span class="text-sm">
                                                        @php
                                                            $typeName = $log->model_type ? basename(str_replace('\\', '/', $log->model_type)) : '';
                                                            
                                                            switch($typeName) {
                                                                case 'Product':
                                                                    echo 'منتج';
                                                                    break;
                                                                case 'Section':
                                                                    echo 'قسم';
                                                                    break;
                                                                case 'SectionPart':
                                                                    echo 'عنصر قسم';
                                                                    break;
                                                                case 'Setting':
                                                                    echo 'إعدادات';
                                                                    break;
                                                                default:
                                                                    echo $typeName;
                                                            }
                                                        @endphp
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="px-2 py-1">
                                                    <p class="text-sm mb-0">{{ $log->description }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="px-2 py-1">
                                                    <span class="text-sm">{{ $log->created_at->format('Y-m-d H:i:s') }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="px-2 py-1">
                                                    <a href="{{ route('activity-logs.show', $log) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-3">لا توجد سجلات نشاط</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $logs->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 