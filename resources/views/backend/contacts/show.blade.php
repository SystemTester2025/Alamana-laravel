@extends('layouts.backend')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-6">
                            <h6>تفاصيل الرسالة</h6>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{ route('contacts.index') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-arrow-right me-1"></i> العودة إلى الرسائل
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    
                    <div class="message-header border-bottom pb-3 mb-3">
                        <div class="row">
                            <div class="col-md-8">
                                <h4>{{ $message->subject }}</h4>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge {{ $message->isIncoming() ? 'bg-primary' : 'bg-info' }}">
                                    {{ $message->isIncoming() ? 'رسالة واردة' : 'رسالة صادرة' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="message-meta mt-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1">
                                        <strong>{{ $message->isIncoming() ? 'المرسل:' : 'المستلم:' }}</strong>
                                        {{ $message->name }} &lt;{{ $message->email }}&gt;
                                    </p>
                                    
                                    @if($message->cc)
                                    <p class="mb-1">
                                        <strong>نسخة:</strong> {{ $message->cc }}
                                    </p>
                                    @endif
                                    
                                    @if($message->bcc)
                                    <p class="mb-1">
                                        <strong>نسخة مخفية:</strong> {{ $message->bcc }}
                                    </p>
                                    @endif
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <p class="mb-1">
                                        <strong>التاريخ:</strong> {{ $message->created_at->format('Y-m-d H:i') }}
                                    </p>
                                    
                                    @if($message->is_replied)
                                    <p class="mb-1">
                                        <strong>تم الرد:</strong> {{ $message->reply_date->format('Y-m-d H:i') }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="message-content border-bottom pb-3 mb-3">
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($message->message)) !!}
                        </div>
                        
                        @if(!empty($message->attachments))
                        <div class="message-attachments mt-3">
                            <h6>المرفقات:</h6>
                            <div class="row">
                                @foreach($message->attachments as $attachment)
                                <div class="col-md-4 mb-2">
                                    <div class="card">
                                        <div class="card-body py-2">
                                            <i class="fas fa-paperclip me-1"></i>
                                            {{ basename($attachment) }}
                                            <a href="{{ asset('storage/' . $attachment) }}" class="btn btn-sm btn-outline-primary float-end" download>
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    @if($message->is_replied)
                    <div class="message-reply border-bottom pb-3 mb-3">
                        <h5 class="mb-3">الرد السابق:</h5>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($message->reply_message)) !!}
                        </div>
                    </div>
                    @endif
                    
                    @if($message->isIncoming() && $message->status !== 'trash')
                    <div class="message-reply-form">
                        <h5 class="mb-3">الرد على الرسالة</h5>
                        <form action="{{ route('contacts.reply', $message->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cc" class="form-label">نسخة (CC)</label>
                                    <input type="text" name="cc" id="cc" class="form-control @error('cc') is-invalid @enderror" placeholder="example1@domain.com, example2@domain.com">
                                    @error('cc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="bcc" class="form-label">نسخة مخفية (BCC)</label>
                                    <input type="text" name="bcc" id="bcc" class="form-control @error('bcc') is-invalid @enderror" placeholder="example1@domain.com, example2@domain.com">
                                    @error('bcc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="reply_message" class="form-label">رسالة الرد</label>
                                    <textarea name="reply_message" id="reply_message" rows="10" class="form-control @error('reply_message') is-invalid @enderror" required>{{ old('reply_message') }}</textarea>
                                    @error('reply_message')
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
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-reply me-1"></i> إرسال الرد
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                    
                    <div class="message-actions mt-4">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-between">
                                <div>
                                    @if($message->status !== 'trash')
                                    <form action="{{ route('contacts.trash', $message->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash me-1"></i> نقل إلى المهملات
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('contacts.restore', $message->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary">
                                            <i class="fas fa-trash-restore me-1"></i> استعادة الرسالة
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('contacts.destroy', $message->id) }}" method="POST" class="d-inline ms-2" onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة نهائيًا؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash-alt me-1"></i> حذف نهائي
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                
                                <div>
                                    @if($message->isIncoming())
                                    <form action="{{ route('contacts.toggle-read', $message->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-info">
                                            @if($message->is_read)
                                                <i class="fas fa-envelope me-1"></i> تحديد كغير مقروء
                                            @else
                                                <i class="fas fa-envelope-open me-1"></i> تحديد كمقروء
                                            @endif
                                        </button>
                                    </form>
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

@section('extra_js')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('reply_message')) {
            ClassicEditor
                .create(document.querySelector('#reply_message'), {
                    language: 'ar',
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo']
                })
                .catch(error => {
                    console.error(error);
                });
        }
    });
</script>
@endsection 