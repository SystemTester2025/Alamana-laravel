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

                            <h5 class="mt-4 mb-3">شعارات الموقع</h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="logo">شعار الموقع</label>
                                        <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror">
                                        @error('logo')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        
                                        @if($setting->logo)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo" class="img-thumbnail" style="max-height: 100px">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="favicon">أيقونة الموقع (Favicon)</label>
                                        <input type="file" name="favicon" id="favicon" class="form-control @error('favicon') is-invalid @enderror">
                                        @error('favicon')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        
                                        @if($setting->favicon)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $setting->favicon) }}" alt="Favicon" class="img-thumbnail" style="max-height: 50px">
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