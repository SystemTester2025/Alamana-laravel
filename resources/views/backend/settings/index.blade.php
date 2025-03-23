@extends('layouts.backend')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-lg-6 col-7">
                            <h6>إعدادات الموقع</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="p-4">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('settings.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="title">عنوان الموقع</label>
                                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $setting->title) }}" required>
                                        @error('title')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="email">البريد الإلكتروني</label>
                                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $setting->email) }}">
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="phone">رقم الهاتف</label>
                                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $setting->phone) }}">
                                        @error('phone')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="address">العنوان</label>
                                        <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $setting->address) }}">
                                        @error('address')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="description">وصف الموقع</label>
                                <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $setting->description) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <h5 class="mt-4 mb-3">وسائل التواصل الاجتماعي</h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="facebook">فيسبوك</label>
                                        <input type="url" name="facebook" id="facebook" class="form-control @error('facebook') is-invalid @enderror" value="{{ old('facebook', $setting->facebook) }}">
                                        @error('facebook')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="linkedin">لينكد إن</label>
                                        <input type="url" name="linkedin" id="linkedin" class="form-control @error('linkedin') is-invalid @enderror" value="{{ old('linkedin', $setting->linkedin) }}">
                                        @error('linkedin')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="instagram">انستجرام</label>
                                        <input type="url" name="instagram" id="instagram" class="form-control @error('instagram') is-invalid @enderror" value="{{ old('instagram', $setting->instagram) }}">
                                        @error('instagram')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="twitter">تويتر</label>
                                        <input type="url" name="twitter" id="twitter" class="form-control @error('twitter') is-invalid @enderror" value="{{ old('twitter', $setting->twitter) }}">
                                        @error('twitter')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4 mb-3">خيارات العرض</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="show_falling_leaves" name="show_falling_leaves" {{ $setting->show_falling_leaves ? 'checked' : '' }}>
                                            <label class="form-check-label" for="show_falling_leaves">تفعيل تأثير تساقط الأوراق</label>
                                        </div>
                                        <small class="form-text text-muted">عند تفعيل هذا الخيار، سيتم عرض تأثير تساقط أوراق الشجر على الموقع</small>
                                        <div class="mt-2">
                                            <button type="button" id="test_leaves_btn" class="btn btn-sm btn-secondary">اختبار التأثير</button>
                                            <span id="leaves_status" class="badge bg-info ms-2">الحالة: {{ $setting->show_falling_leaves ? 'مفعل' : 'غير مفعل' }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="maintenance_mode" name="maintenance_mode" {{ $setting->maintenance_mode ? 'checked' : '' }}>
                                            <label class="form-check-label" for="maintenance_mode">وضع الصيانة</label>
                                        </div>
                                        <small class="form-text text-muted">عند تفعيل هذا الخيار، سيتم عرض صفحة الصيانة بدلاً من الموقع</small>
                                        <div class="mt-2">
                                            <a href="{{ route('maintenance.preview') }}" target="_blank" class="btn btn-sm btn-info">معاينة صفحة الصيانة</a>
                                            <span id="maintenance_status" class="badge {{ $setting->maintenance_mode ? 'bg-danger' : 'bg-success' }} ms-2">
                                                الحالة: {{ $setting->maintenance_mode ? 'قيد الصيانة' : 'يعمل' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4 mb-3">شعارات الموقع</h5>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="logo">شعار الموقع</label>
                                        <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror">
                                        @error('logo')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        
                                        @if($setting->logo)
                                            <div class="mt-2">
                                                <img src="{{asset($setting->logo)}}" alt="Logo" class="img-thumbnail" style="max-height: 100px">

                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="favicon">أيقونة الموقع (Favicon)</label>
                                        <input type="file" name="favicon" id="favicon" class="form-control @error('favicon') is-invalid @enderror">
                                        @error('favicon')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        
                                        @if($setting->favicon)
                                            <div class="mt-2">
                                                <img src="{{ asset($setting->favicon)}}" alt="Favicon" class="img-thumbnail" style="max-height: 50px">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="logo">شعار أخر الموقع</label>
                                        <input type="file" name="footer_logo" id="footer_logo" class="form-control @error('footer_logo') is-invalid @enderror">
                                        @error('logo')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        
                                        @if($setting->footer_logo)
                                            <div class="mt-2">
                                                <img src="{{asset($setting->footer_logo)}}" alt="Logo" class="img-thumbnail" style="max-height: 100px">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_js')
<script>
    $(document).ready(function() {
        // Handle test leaves button
        $('#test_leaves_btn').on('click', function() {
            var isChecked = $('#show_falling_leaves').prop('checked');
            console.log('Current show_falling_leaves value:', isChecked);
            $('#leaves_status').html('الحالة: ' + (isChecked ? 'مفعل' : 'غير مفعل'));
        });

        // Update leaves status on checkbox change
        $('#show_falling_leaves').on('change', function() {
            var isChecked = $(this).prop('checked');
            $('#leaves_status').html('الحالة: ' + (isChecked ? 'مفعل' : 'غير مفعل'));
        });
        
        // Update maintenance status on checkbox change
        $('#maintenance_mode').on('change', function() {
            var isChecked = $(this).prop('checked');
            var statusText = isChecked ? 'قيد الصيانة' : 'يعمل';
            var statusClass = isChecked ? 'bg-danger' : 'bg-success';
            
            $('#maintenance_status')
                .removeClass('bg-danger bg-success')
                .addClass(statusClass)
                .html('الحالة: ' + statusText);
                
            if (isChecked) {
                alert('تنبيه: عند حفظ الإعدادات، سيتم تفعيل وضع الصيانة وسيتعذر على الزوار الوصول إلى الموقع');
            }
        });
    });
</script>
@endsection 