@extends('layouts.backend')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>تعديل المحتوى</h1>
        <a href="{{ route('sections.show', $sectionPart->section_id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-circle-right me-1"></i> العودة للقسم
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('section-parts.update', $sectionPart->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="section_id" class="form-label">القسم <span class="text-danger">*</span></label>
                        <select class="form-select @error('section_id') is-invalid @enderror" id="section_id" name="section_id" required>
                            <option value="" disabled>اختر القسم</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}" {{ old('section_id', $sectionPart->section_id) == $section->id ? 'selected' : '' }}>
                                    {{ $section->name }} ({{ $section->key }})
                                </option>
                            @endforeach
                        </select>
                        @error('section_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="sort_order" class="form-label">الترتيب</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $sectionPart->sort_order) }}">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">العنوان <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $sectionPart->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="sub" class="form-label">العنوان الفرعي</label>
                        <input type="text" class="form-control @error('sub') is-invalid @enderror" id="sub" name="sub" value="{{ old('sub', $sectionPart->sub) }}">
                        @error('sub')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="key" class="form-label">المفتاح</label>
                        <input type="text" class="form-control @error('key') is-invalid @enderror" id="key" name="key" value="{{ old('key', $sectionPart->key) }}">
                        <div class="form-text">مفتاح اختياري لتحديد هذا المحتوى (مثل: feature_1, point_2)</div>
                        @error('key')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="value" class="form-label">القيمة</label>
                        <input type="text" class="form-control @error('value') is-invalid @enderror" id="value" name="value" value="{{ old('value', $sectionPart->value) }}">
                        <div class="form-text">قيمة اختيارية مرتبطة بالمفتاح</div>
                        @error('value')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="desc" class="form-label">الوصف</label>
                    <input type="hidden" id="desc" name="desc" value="{{ old('desc', $sectionPart->desc) }}">
                    
                    <div class="card">
                        <div class="card-header bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>محتوى الوصف</span>
                                <button type="button" class="btn btn-sm btn-primary" id="editTextBtn">
                                    <i class="fas fa-edit me-1"></i> تعديل النص
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="descPreview" class="p-3 border rounded bg-white">
                                {!! old('desc', $sectionPart->desc) !!}
                            </div>
                        </div>
                    </div>
                    
                    @error('desc')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="image" class="form-label">الصورة</label>
                    @if($sectionPart->image)
                        <div class="mb-2">
                            <img src="{{asset($sectionPart->image)}}" alt="{{ $sectionPart->title }}" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                    <div class="form-text">يجب أن تكون الصورة بصيغة jpeg, png, jpg, gif, svg وحجم أقصى 2 ميغابايت. اترك الحقل فارغا للاحتفاظ بالصورة الحالية.</div>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="border-top pt-3 text-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for text editing -->
<div class="modal fade" id="textEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تعديل النص</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="textEditorContainer">
                    <!-- Editable text fields will be inserted here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="saveTextEdits">حفظ التغييرات</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editTextBtn = document.getElementById('editTextBtn');
        const descField = document.getElementById('desc');
        const descPreview = document.getElementById('descPreview');
        const textEditorContainer = document.getElementById('textEditorContainer');
        const saveTextEdits = document.getElementById('saveTextEdits');
        const textEditModal = new bootstrap.Modal(document.getElementById('textEditModal'));
        
        // Ensure there's always some content (use a dot as minimum)
        let htmlStructure = descField.value || '.';
        
        // If the initial preview is empty, set it to a dot
        if (descPreview.innerHTML.trim() === '') {
            descPreview.innerHTML = '.';
            descField.value = '.';
        }
        
        editTextBtn.addEventListener('click', function() {
            try {
                // Parse HTML content and create editable fields for text nodes
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = htmlStructure;
                
                // Clear the editor container
                textEditorContainer.innerHTML = '';
                
                // Create a mapping of text content to form fields
                const textNodes = [];
                const editableFields = [];
                
                // Function to recursively find text nodes
                function extractTextNodes(element, path = '') {
                    if (!element || !element.childNodes) return;
                    
                    Array.from(element.childNodes).forEach((node, index) => {
                        const currentPath = path ? `${path}-${index}` : `${index}`;
                        
                        if (node.nodeType === Node.TEXT_NODE) {
                            // Only add non-empty text nodes (trimmed)
                            const trimmedText = node.textContent.trim();
                            if (trimmedText) {
                                textNodes.push({
                                    path: currentPath,
                                    node: node,
                                    text: node.textContent
                                });
                            }
                        } else if (node.nodeType === Node.ELEMENT_NODE) {
                            extractTextNodes(node, currentPath);
                        }
                    });
                }
                
                extractTextNodes(tempDiv);
                
                // If no text nodes were found, add a message
                if (textNodes.length === 0) {
                    const noNodesMessage = document.createElement('div');
                    noNodesMessage.className = 'alert alert-info';
                    noNodesMessage.textContent = 'لم يتم العثور على نص للتحرير. سيتم إضافة نقطة كمحتوى افتراضي.';
                    
                    const defaultInput = document.createElement('textarea');
                    defaultInput.className = 'form-control mt-3';
                    defaultInput.value = '.';
                    defaultInput.dataset.path = 'default';
                    defaultInput.rows = 2;
                    
                    textEditorContainer.appendChild(noNodesMessage);
                    textEditorContainer.appendChild(defaultInput);
                    editableFields.push(defaultInput);
                } else {
                    // Create form fields for each text node
                    textNodes.forEach((item, idx) => {
                        const fieldGroup = document.createElement('div');
                        fieldGroup.className = 'mb-3';
                        
                        const label = document.createElement('label');
                        label.className = 'form-label';
                        label.textContent = `النص ${idx + 1}`;
                        
                        const input = document.createElement('textarea');
                        input.className = 'form-control';
                        input.value = item.text;
                        input.dataset.path = item.path;
                        input.rows = Math.min(5, Math.max(2, (item.text.match(/\n/g) || []).length + 1));
                        
                        fieldGroup.appendChild(label);
                        fieldGroup.appendChild(input);
                        textEditorContainer.appendChild(fieldGroup);
                        editableFields.push(input);
                    });
                }
                
                textEditModal.show();
            } catch (error) {
                console.error("Error processing HTML content:", error);
                alert("حدث خطأ أثناء معالجة المحتوى. يرجى التحقق من التنسيق.");
            }
        });
        
        saveTextEdits.addEventListener('click', function() {
            try {
                // Get all input fields
                const inputs = textEditorContainer.querySelectorAll('textarea');
                
                // If there are no inputs, just close the modal
                if (inputs.length === 0) {
                    textEditModal.hide();
                    return;
                }
                
                // Check if we have the default input for empty content
                const defaultInput = Array.from(inputs).find(input => input.dataset.path === 'default');
                if (defaultInput) {
                    // For empty content, just use the default input value
                    const value = defaultInput.value.trim() === '' ? '.' : defaultInput.value;
                    htmlStructure = value;
                    descPreview.innerHTML = value;
                    descField.value = value;
                    textEditModal.hide();
                    return;
                }
                
                // Create a map of path to new text
                const textUpdates = {};
                inputs.forEach(input => {
                    // If input is empty, add a dot as a placeholder
                    const value = input.value.trim() === '' ? '.' : input.value;
                    textUpdates[input.dataset.path] = value;
                });
                
                // Parse the original HTML
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = htmlStructure;
                
                // Function to update text nodes based on path
                function updateTextNodes(element, path = '') {
                    if (!element || !element.childNodes) return;
                    
                    Array.from(element.childNodes).forEach((node, index) => {
                        const currentPath = path ? `${path}-${index}` : `${index}`;
                        
                        if (node.nodeType === Node.TEXT_NODE) {
                            // Check if this node's path is in our updates
                            if (textUpdates[currentPath] !== undefined) {
                                node.textContent = textUpdates[currentPath];
                            }
                        } else if (node.nodeType === Node.ELEMENT_NODE) {
                            updateTextNodes(node, currentPath);
                        }
                    });
                }
                
                updateTextNodes(tempDiv);
                
                // Update the preview and hidden field
                htmlStructure = tempDiv.innerHTML || '.';  // Ensure there's always content
                descPreview.innerHTML = htmlStructure;
                descField.value = htmlStructure;
                
                textEditModal.hide();
            } catch (error) {
                console.error("Error saving text edits:", error);
                alert("حدث خطأ أثناء حفظ التعديلات. يرجى المحاولة مرة أخرى.");
            }
        });
    });
</script>
@endpush 