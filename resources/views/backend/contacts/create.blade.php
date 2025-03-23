@extends('layouts.backend')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-6">
                            <h6>إرسال رسالة جديدة</h6>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{ route('contacts.index') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-arrow-right me-1"></i> العودة إلى الرسائل
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    
                    <form action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="to" class="form-label">المستلم</label>
                                <input type="email" name="to" id="to" class="form-control @error('to') is-invalid @enderror" value="{{ old('to') }}" required>
                                @error('to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cc" class="form-label">نسخة (CC)</label>
                                <input type="text" name="cc" id="cc" class="form-control @error('cc') is-invalid @enderror" value="{{ old('cc') }}" placeholder="example1@domain.com, example2@domain.com">
                                @error('cc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="bcc" class="form-label">نسخة مخفية (BCC)</label>
                                <input type="text" name="bcc" id="bcc" class="form-control @error('bcc') is-invalid @enderror" value="{{ old('bcc') }}" placeholder="example1@domain.com, example2@domain.com">
                                @error('bcc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="subject" class="form-label">الموضوع</label>
                                <input type="text" name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="message" class="form-label">الرسالة</label>
                                <textarea name="message" id="message" rows="10" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="attachments" class="form-label">المرفقات</label>
                                <input type="file" name="attachments[]" id="attachments" class="form-control @error('attachments.*') is-invalid @enderror" multiple>
                                <small class="form-text text-muted">يمكنك تحميل عدة ملفات (الحد الأقصى 10 ميجابايت لكل ملف)</small>
                                @error('attachments.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-12 d-flex justify-content-end">
                                <a href="{{ route('contacts.index') }}" class="btn btn-secondary me-2">إلغاء</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-1"></i> إرسال
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_js')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        ClassicEditor
            .create(document.querySelector('#message'), {
                language: 'ar',
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo']
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>
@endsection
