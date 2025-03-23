@extends('layouts.backend')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>إدارة الرسائل والبريد الإلكتروني</h6>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('contacts.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-paper-plane me-1"></i> إرسال رسالة جديدة
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="row">
                        <!-- Sidebar -->
                        <div class="col-md-3 border-end">
                            <div class="p-3">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('contacts.index', ['filter' => 'all']) }}" class="nav-link {{ $filter == 'all' ? 'active bg-light' : '' }}">
                                            <i class="fas fa-inbox me-2"></i> كل الرسائل
                                            <span class="badge bg-primary float-end">{{ $stats['all'] }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('contacts.index', ['filter' => 'incoming']) }}" class="nav-link {{ $filter == 'incoming' ? 'active bg-light' : '' }}">
                                            <i class="fas fa-envelope me-2"></i> الرسائل الواردة
                                            <span class="badge bg-info float-end">{{ $stats['incoming'] }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('contacts.index', ['filter' => 'outgoing']) }}" class="nav-link {{ $filter == 'outgoing' ? 'active bg-light' : '' }}">
                                            <i class="fas fa-paper-plane me-2"></i> الرسائل الصادرة
                                            <span class="badge bg-success float-end">{{ $stats['outgoing'] }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('contacts.index', ['filter' => 'unread']) }}" class="nav-link {{ $filter == 'unread' ? 'active bg-light' : '' }}">
                                            <i class="fas fa-envelope-open me-2"></i> غير مقروءة
                                            <span class="badge bg-danger float-end">{{ $stats['unread'] }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('contacts.index', ['filter' => 'trash']) }}" class="nav-link {{ $filter == 'trash' ? 'active bg-light' : '' }}">
                                            <i class="fas fa-trash me-2"></i> سلة المهملات
                                            <span class="badge bg-secondary float-end">{{ $stats['trash'] }}</span>
                                        </a>
                                    </li>
                                </ul>
                                
                                @if($filter == 'trash' && $stats['trash'] > 0)
                                <div class="mt-3">
                                    <form action="{{ route('contacts.empty-trash') }}" method="POST" onsubmit="return confirm('هل أنت متأكد من إفراغ سلة المهملات؟ هذا الإجراء لا يمكن التراجع عنه.')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm w-100">
                                            <i class="fas fa-trash-alt me-1"></i> إفراغ سلة المهملات
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Messages List -->
                        <div class="col-md-9">
                            <div class="p-3">
                                <!-- Search and Sort -->
                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <form action="{{ route('contacts.index') }}" method="GET">
                                            <input type="hidden" name="filter" value="{{ $filter }}">
                                            <input type="hidden" name="sort" value="{{ $sort }}">
                                            <div class="input-group">
                                                <input type="text" name="search" class="form-control" placeholder="بحث في الرسائل..." value="{{ $search ?? '' }}">
                                                <button class="btn btn-outline-primary" type="submit">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                                @if($search)
                                                <a href="{{ route('contacts.index', ['filter' => $filter, 'sort' => $sort]) }}" class="btn btn-outline-secondary">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-select" id="sort-messages">
                                            <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>الأحدث أولاً</option>
                                            <option value="oldest" {{ $sort == 'oldest' ? 'selected' : '' }}>الأقدم أولاً</option>
                                            <option value="a-z" {{ $sort == 'a-z' ? 'selected' : '' }}>الموضوع (أ-ي)</option>
                                            <option value="z-a" {{ $sort == 'z-a' ? 'selected' : '' }}>الموضوع (ي-أ)</option>
                                        </select>
                                    </div>
                                </div>
                                
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
                                
                                <!-- Messages Table -->
                                <div class="table-responsive">
                                    @if($messages->count() > 0)
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th width="5%"></th>
                                                <th width="25%">{{ $filter == 'outgoing' ? 'المستلم' : 'المرسل' }}</th>
                                                <th width="45%">الموضوع</th>
                                                <th width="15%">التاريخ</th>
                                                <th width="10%">إجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($messages as $message)
                                            <tr class="{{ (!$message->is_read && $message->isIncoming()) ? 'table-light fw-bold' : '' }}">
                                                <td class="text-center">
                                                    @if($message->isIncoming())
                                                        <i class="fas fa-envelope{{ $message->is_read ? '-open text-muted' : ' text-primary' }}"></i>
                                                    @else
                                                        <i class="fas fa-paper-plane text-info"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div>{{ $message->name }}</div>
                                                    <small class="text-muted">{{ $message->email }}</small>
                                                </td>
                                                <td>
                                                    <a href="{{ route('contacts.show', $message->id) }}" class="text-decoration-none text-dark">
                                                        {{ $message->subject }}
                                                    </a>
                                                    @if(!empty($message->attachments))
                                                        <i class="fas fa-paperclip ms-1 text-muted"></i>
                                                    @endif
                                                </td>
                                                <td>{{ $message->created_at->format('Y-m-d H:i') }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="{{ route('contacts.show', $message->id) }}" class="dropdown-item">
                                                                    <i class="fas fa-eye me-1"></i> عرض
                                                                </a>
                                                            </li>
                                                            
                                                            @if($message->isIncoming())
                                                            <li>
                                                                <form action="{{ route('contacts.toggle-read', $message->id) }}" method="POST">
                                                                    @csrf
                                                                    <button type="submit" class="dropdown-item">
                                                                        @if($message->is_read)
                                                                            <i class="fas fa-envelope me-1"></i> تحديد كغير مقروء
                                                                        @else
                                                                            <i class="fas fa-envelope-open me-1"></i> تحديد كمقروء
                                                                        @endif
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            @endif
                                                            
                                                            @if($message->status !== 'trash')
                                                            <li>
                                                                <form action="{{ route('contacts.trash', $message->id) }}" method="POST">
                                                                    @csrf
                                                                    <button type="submit" class="dropdown-item text-danger">
                                                                        <i class="fas fa-trash me-1"></i> نقل إلى المهملات
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            @else
                                                            <li>
                                                                <form action="{{ route('contacts.restore', $message->id) }}" method="POST">
                                                                    @csrf
                                                                    <button type="submit" class="dropdown-item">
                                                                        <i class="fas fa-trash-restore me-1"></i> استعادة
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('contacts.destroy', $message->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة نهائيًا؟')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item text-danger">
                                                                        <i class="fas fa-trash-alt me-1"></i> حذف نهائي
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    
                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $messages->appends(['filter' => $filter, 'search' => $search, 'sort' => $sort])->links() }}
                                    </div>
                                    @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <h5>لا توجد رسائل</h5>
                                        <p class="text-muted">لم يتم العثور على رسائل تطابق معايير البحث</p>
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

@section('extra_js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle sort option change
        document.getElementById('sort-messages').addEventListener('change', function() {
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('sort', this.value);
            window.location.href = currentUrl.toString();
        });
    });
</script>
@endsection 