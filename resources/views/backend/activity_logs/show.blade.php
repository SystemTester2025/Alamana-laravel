@extends('layouts.backend')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-lg-6 col-7">
                            <h6>تفاصيل سجل النشاط</h6>
                            <p class="text-sm mb-0">
                                <i class="fa fa-clock text-info"></i>
                                {{ $activityLog->created_at->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                        <div class="col-lg-6 col-5 my-auto text-end">
                            <a href="{{ route('activity-logs.index') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-arrow-right me-1"></i> العودة للقائمة
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="text-uppercase text-sm">المعلومات الأساسية</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th style="width: 30%">المستخدم</th>
                                                    <td>{{ $activityLog->user_id ? $activityLog->user->name : 'النظام' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>الإجراء</th>
                                                    <td>
                                                        <span class="badge bg-{{ $activityLog->action == 'create' ? 'success' : ($activityLog->action == 'update' ? 'info' : 'danger') }}">
                                                            @if($activityLog->action == 'create')
                                                                إنشاء
                                                            @elseif($activityLog->action == 'update')
                                                                تحديث
                                                            @elseif($activityLog->action == 'delete')
                                                                حذف
                                                            @else
                                                                {{ $activityLog->action }}
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>نوع البيانات</th>
                                                    <td>
                                                        @php
                                                            $typeName = $activityLog->model_type ? basename(str_replace('\\', '/', $activityLog->model_type)) : '';
                                                            
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
                                                        @if($activityLog->model_id)
                                                            <small>(#{{ $activityLog->model_id }})</small>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>الوصف</th>
                                                    <td>{{ $activityLog->description }}</td>
                                                </tr>
                                                <tr>
                                                    <th>التاريخ</th>
                                                    <td>{{ $activityLog->created_at->format('Y-m-d H:i:s') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>عنوان IP</th>
                                                    <td>{{ $activityLog->ip_address ?? 'غير متاح' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="text-uppercase text-sm">تفاصيل التغييرات</h6>
                                    @if($activityLog->action == 'update' && $activityLog->before_details && $activityLog->after_details)
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>الحقل</th>
                                                        <th>القيمة القديمة</th>
                                                        <th>القيمة الجديدة</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($activityLog->before_details as $key => $oldValue)
                                                        @if(in_array($key, ['id', 'created_at', 'updated_at', 'deleted_at']))
                                                            @continue
                                                        @endif
                                                        
                                                        @php
                                                            $newValue = $activityLog->after_details[$key] ?? null;
                                                            $oldValueDisplay = is_array($oldValue) ? json_encode($oldValue, JSON_UNESCAPED_UNICODE) : $oldValue;
                                                            $newValueDisplay = is_array($newValue) ? json_encode($newValue, JSON_UNESCAPED_UNICODE) : $newValue;
                                                            
                                                            // Handle image paths to display only filename
                                                            if (is_string($oldValueDisplay) && strpos($oldValueDisplay, '/') !== false && (strpos($oldValueDisplay, '.jpg') !== false || strpos($oldValueDisplay, '.png') !== false || strpos($oldValueDisplay, '.gif') !== false)) {
                                                                $oldValueDisplay = basename($oldValueDisplay);
                                                            }
                                                            
                                                            if (is_string($newValueDisplay) && strpos($newValueDisplay, '/') !== false && (strpos($newValueDisplay, '.jpg') !== false || strpos($newValueDisplay, '.png') !== false || strpos($newValueDisplay, '.gif') !== false)) {
                                                                $newValueDisplay = basename($newValueDisplay);
                                                            }
                                                        @endphp
                                                        
                                                        @if($oldValueDisplay != $newValueDisplay)
                                                            <tr>
                                                                <td>
                                                                    @switch($key)
                                                                        @case('title')
                                                                            العنوان
                                                                            @break
                                                                        @case('name')
                                                                            الاسم
                                                                            @break
                                                                        @case('sub_title')
                                                                        @case('sub')
                                                                            العنوان الفرعي
                                                                            @break
                                                                        @case('description')
                                                                        @case('desc')
                                                                            الوصف
                                                                            @break
                                                                        @case('image')
                                                                            الصورة
                                                                            @break
                                                                        @case('sort_order')
                                                                            الترتيب
                                                                            @break
                                                                        @case('email')
                                                                            البريد الإلكتروني
                                                                            @break
                                                                        @case('phone')
                                                                            رقم الهاتف
                                                                            @break
                                                                        @case('address')
                                                                            العنوان
                                                                            @break
                                                                        @default
                                                                            {{ $key }}
                                                                    @endswitch
                                                                </td>
                                                                <td class="text-danger">
                                                                    @if($key == 'image' && $oldValueDisplay)
                                                                        <img src="{{ asset('storage/' . $oldValue) }}" width="50" class="img-thumbnail">
                                                                    @else
                                                                        {{ $oldValueDisplay ?: 'فارغ' }}
                                                                    @endif
                                                                </td>
                                                                <td class="text-success">
                                                                    @if($key == 'image' && $newValueDisplay)
                                                                        <img src="{{ asset('storage/' . $newValue) }}" width="50" class="img-thumbnail">
                                                                    @else
                                                                        {{ $newValueDisplay ?: 'فارغ' }}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @elseif($activityLog->action == 'create' && $activityLog->after_details)
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>الحقل</th>
                                                        <th>القيمة</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($activityLog->after_details as $key => $value)
                                                        @if(in_array($key, ['id', 'created_at', 'updated_at', 'deleted_at']))
                                                            @continue
                                                        @endif
                                                        
                                                        @php
                                                            $valueDisplay = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value;
                                                            
                                                            // Handle image paths
                                                            if (is_string($valueDisplay) && strpos($valueDisplay, '/') !== false && (strpos($valueDisplay, '.jpg') !== false || strpos($valueDisplay, '.png') !== false || strpos($valueDisplay, '.gif') !== false)) {
                                                                $valueDisplay = basename($valueDisplay);
                                                            }
                                                        @endphp
                                                        
                                                        <tr>
                                                            <td>
                                                                @switch($key)
                                                                    @case('title')
                                                                        العنوان
                                                                        @break
                                                                    @case('name')
                                                                        الاسم
                                                                        @break
                                                                    @case('sub_title')
                                                                    @case('sub')
                                                                        العنوان الفرعي
                                                                        @break
                                                                    @case('description')
                                                                    @case('desc')
                                                                        الوصف
                                                                        @break
                                                                    @case('image')
                                                                        الصورة
                                                                        @break
                                                                    @case('sort_order')
                                                                        الترتيب
                                                                        @break
                                                                    @case('email')
                                                                        البريد الإلكتروني
                                                                        @break
                                                                    @case('phone')
                                                                        رقم الهاتف
                                                                        @break
                                                                    @case('address')
                                                                        العنوان
                                                                        @break
                                                                    @default
                                                                        {{ $key }}
                                                                @endswitch
                                                            </td>
                                                            <td>
                                                                @if($key == 'image' && $value)
                                                                    <img src="{{ asset('storage/' . $value) }}" width="50" class="img-thumbnail">
                                                                @else
                                                                    {{ $valueDisplay ?: 'فارغ' }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @elseif($activityLog->action == 'delete' && $activityLog->before_details)
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>الحقل</th>
                                                        <th>القيمة المحذوفة</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($activityLog->before_details as $key => $value)
                                                        @if(in_array($key, ['id', 'created_at', 'updated_at', 'deleted_at']))
                                                            @continue
                                                        @endif
                                                        
                                                        @php
                                                            $valueDisplay = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value;
                                                            
                                                            // Handle image paths
                                                            if (is_string($valueDisplay) && strpos($valueDisplay, '/') !== false && (strpos($valueDisplay, '.jpg') !== false || strpos($valueDisplay, '.png') !== false || strpos($valueDisplay, '.gif') !== false)) {
                                                                $valueDisplay = basename($valueDisplay);
                                                            }
                                                        @endphp
                                                        
                                                        <tr>
                                                            <td>
                                                                @switch($key)
                                                                    @case('title')
                                                                        العنوان
                                                                        @break
                                                                    @case('name')
                                                                        الاسم
                                                                        @break
                                                                    @case('sub_title')
                                                                    @case('sub')
                                                                        العنوان الفرعي
                                                                        @break
                                                                    @case('description')
                                                                    @case('desc')
                                                                        الوصف
                                                                        @break
                                                                    @case('image')
                                                                        الصورة
                                                                        @break
                                                                    @case('sort_order')
                                                                        الترتيب
                                                                        @break
                                                                    @case('email')
                                                                        البريد الإلكتروني
                                                                        @break
                                                                    @case('phone')
                                                                        رقم الهاتف
                                                                        @break
                                                                    @case('address')
                                                                        العنوان
                                                                        @break
                                                                    @default
                                                                        {{ $key }}
                                                                @endswitch
                                                            </td>
                                                            <td class="text-danger">
                                                                @if($key == 'image' && $value)
                                                                    <div>{{ $valueDisplay }}</div>
                                                                @else
                                                                    {{ $valueDisplay ?: 'فارغ' }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            لا توجد تفاصيل إضافية متاحة لهذا النشاط.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 