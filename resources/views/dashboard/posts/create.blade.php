<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .builder-palette {
            position: sticky;
            top: calc(var(--d-header-height) + 1rem);
        }
        .widget-card {
            cursor: grab;
            border: 2px dashed var(--d-border);
            transition: all 0.2s;
            margin-bottom: 10px;
            border-radius: var(--d-radius-sm);
            background: var(--d-surface);
        }
        .widget-card:hover {
            border-color: var(--d-primary);
            transform: translateY(-2px);
        }
        .canvas-area {
            background: var(--d-surface-alt);
            min-height: 400px;
            border: 2px dashed var(--d-border);
            border-radius: var(--d-radius-sm);
            padding: 20px;
        }
        .canvas-element {
            background: #fff;
            border: 1px solid var(--d-border);
            border-radius: var(--d-radius-sm);
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: var(--d-shadow-sm);
            transition: all 0.2s;
            position: relative;
        }
        .canvas-element:hover {
            border-color: var(--d-primary);
            box-shadow: var(--d-shadow);
        }
        .element-header {
            background: var(--d-surface-alt);
            padding: 8px 15px;
            margin: -15px -15px 15px -15px;
            border-radius: var(--d-radius-sm) var(--d-radius-sm) 0 0;
            border-bottom: 1px solid var(--d-border);
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .empty-canvas {
            text-align: center;
            padding: 60px 20px;
            color: var(--d-muted);
        }
        .position-controls { display: flex; gap: 5px; }
        .position-btn {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--d-border);
            background: white;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .position-btn:hover { background: var(--d-surface-alt); border-color: var(--d-muted); }
        .position-btn:disabled { opacity: 0.5; cursor: not-allowed; }
        .position-btn:disabled:hover { background: white; border-color: var(--d-border); }
        .element-type-badge {
            font-size: 0.75rem;
            background: var(--d-secondary);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            margin-left: 10px;
        }
        .position-btn.remove-btn { color: var(--d-danger); border-color: var(--d-danger); }
        .position-btn.remove-btn:hover { background: var(--d-danger); color: white; }
        .ckeditor-container { margin-top: 10px; border: 1px solid var(--d-border); border-radius: 4px; }
        .ckeditor-column { margin-bottom: 15px; }
        .cke_notification_warning { display: none; }
        /* Tags input */
        .tags-container {
            display: flex; flex-wrap: wrap; gap: 8px; margin-top: 8px; min-height: 42px;
            padding: 8px; border: 1px solid var(--d-border); border-radius: var(--d-radius-sm); background: #fff;
        }
        .tag-item {
            display: inline-flex; align-items: center; background: var(--d-surface-alt);
            border: 1px solid var(--d-border); border-radius: 20px; padding: 4px 12px; font-size: 0.875rem;
        }
        .tag-text { margin-right: 6px; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .tag-remove {
            background: none; border: none; color: var(--d-muted); cursor: pointer; font-size: 0.875rem;
            padding: 0; width: 16px; height: 16px; display: flex; align-items: center; justify-content: center; border-radius: 50%;
        }
        .tag-remove:hover { background: var(--d-muted); color: white; }
        .tags-input { flex: 1; min-width: 120px; border: none; outline: none; padding: 4px 8px; font-size: 0.875rem; }
        .tags-input:focus { box-shadow: none; }
        .tags-help-text { font-size: 0.75rem; color: var(--d-muted); margin-top: 4px; }
    </style>
    @endpush

    <div class="container-fluid">
        <x-dashboard.page-header title="Create Blog Post" subtitle="Build your article with the drag-and-drop content builder" icon="fas fa-pen-nib">
            <a href="{{ route('blog-posts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Posts
            </a>
        </x-dashboard.page-header>

        <div class="row g-4">
            <!-- Elements palette -->
            <div class="col-lg-3">
                <div class="builder-palette">
                    <div class="card">
                        <div class="card-header"><h6 class="card-title mb-0"><i class="fas fa-shapes me-2"></i>Blog Elements</h6></div>
                        <div class="card-body">
                            <div class="widget-card p-3" draggable="true" data-type="heading">
                                <div class="d-flex align-items-center"><i class="fas fa-heading text-primary me-2"></i><span>Heading</span></div>
                            </div>
                            <div class="widget-card p-3" draggable="true" data-type="text">
                                <div class="d-flex align-items-center"><i class="fas fa-paragraph text-primary me-2"></i><span>Text Content</span></div>
                            </div>
                            <div class="widget-card p-3" draggable="true" data-type="image">
                                <div class="d-flex align-items-center"><i class="fas fa-image text-primary me-2"></i><span>Image</span></div>
                            </div>
                            <div class="widget-card p-3" draggable="true" data-type="banner">
                                <div class="d-flex align-items-center"><i class="fas fa-flag text-primary me-2"></i><span>Banner</span></div>
                            </div>
                            <div class="widget-card p-3" draggable="true" data-type="columns">
                                <div class="d-flex align-items-center"><i class="fas fa-columns text-primary me-2"></i><span>Two Columns</span></div>
                            </div>
                            <hr>
                            <button class="btn btn-outline-primary btn-sm w-100 mb-2" onclick="builder.previewPage()">
                                <i class="fas fa-eye me-1"></i>Preview
                            </button>
                            <button class="btn btn-outline-danger btn-sm w-100" onclick="builder.clearCanvas()">
                                <i class="fas fa-trash me-1"></i>Clear All
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Builder area -->
            <div class="col-lg-9">
                <!-- Basic Information -->
                <div class="card mb-4">
                    <div class="card-header"><h5 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Basic Information</h5></div>
                    <div class="card-body">
                        <form id="blogPostForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Post Title *</label>
                                        <input type="text" class="form-control" id="title" name="title" required placeholder="Enter your blog post title">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="blog_category_id" class="form-label">Category</label>
                                        <select class="form-select" id="blog_category_id" name="blog_category_id">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="featured_image" class="form-label">Featured Image</label>
                                        <input type="file" class="form-control" id="featured_image" name="featured_image" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="draft">Draft</option>
                                            <option value="published">Published</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="excerpt" class="form-label">Excerpt</label>
                                <textarea class="form-control" id="excerpt" name="excerpt" rows="2" placeholder="Brief description of your blog post"></textarea>
                            </div>
                            <div class="mb-0">
                                <label for="tags" class="form-label">Tags</label>
                                <div class="tags-container" id="tagsContainer">
                                    <input type="text" class="tags-input" id="tagsInput" placeholder="Type a tag and press Enter or Space">
                                </div>
                                <div class="tags-help-text">Press Enter, Space, or comma to add a tag. Click the X to remove.</div>
                                <input type="hidden" id="tags" name="tags">
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Content Builder -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="fas fa-pencil-alt me-2"></i>Content Builder</h5>
                        <span class="badge bg-secondary" id="elementCount">0 elements</span>
                    </div>
                    <div class="card-body">
                        <div class="canvas-area" id="canvas">
                            <div class="empty-canvas" id="emptyCanvas">
                                <i class="fas fa-hand-pointer fa-2x mb-3"></i>
                                <h5>Drag elements here to build your blog post</h5>
                                <p class="text-muted">Select from the palette on the left and drop in this area</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <h6 class="mb-1">Ready to publish your blog post?</h6>
                                <p class="text-muted mb-0">Review your content and save when ready</p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('blog-posts.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Posts
                                </a>
                                <button type="button" class="btn btn-success" onclick="builder.saveBlogPost()">
                                    <i class="fas fa-save me-2"></i>Save Blog Post
                                </button>
                            </div>
                        </div>
                        <div id="saveResult" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Blog Post Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="previewContent"></div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        document.getElementById('featured_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const maxSize = 2000 * 1024; // 2000 KB in bytes
            const errorElement = document.getElementById('fileSizeError');
            if (errorElement) { errorElement.remove(); }
            if (file) {
                if (file.size > maxSize) {
                    const errorDiv = document.createElement('div');
                    errorDiv.id = 'fileSizeError';
                    errorDiv.className = 'alert alert-danger mt-2';
                    errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>File size must be less than 2000 KB. Please choose a smaller file.';
                    this.parentNode.appendChild(errorDiv);
                    this.value = '';
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            }
        });

        class TagsManager {
            constructor() { this.tags = []; this.init(); }
            init() { this.setupEventListeners(); }
            setupEventListeners() {
                const tagsInput = document.getElementById('tagsInput');
                tagsInput.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ' || e.key === ',') {
                        e.preventDefault();
                        this.addTag(tagsInput.value.trim());
                        tagsInput.value = '';
                    } else if (e.key === 'Backspace' && tagsInput.value === '' && this.tags.length > 0) {
                        this.removeTag(this.tags.length - 1);
                    }
                });
                tagsInput.addEventListener('blur', () => {
                    if (tagsInput.value.trim() !== '') { this.addTag(tagsInput.value.trim()); tagsInput.value = ''; }
                });
                tagsInput.addEventListener('keyup', (e) => { if (e.key === ' ') { e.preventDefault(); } });
            }
            addTag(tagText) {
                if (tagText === '') return;
                tagText = tagText.replace(/,/g, '').trim();
                if (tagText === '') return;
                if (this.tags.includes(tagText)) {
                    const existingTag = document.querySelector(`.tag-item[data-tag="${tagText}"]`);
                    if (existingTag) {
                        existingTag.style.backgroundColor = '#ffc107';
                        setTimeout(() => { existingTag.style.backgroundColor = ''; }, 1000);
                    }
                    return;
                }
                this.tags.push(tagText);
                const tagElement = document.createElement('div');
                tagElement.className = 'tag-item';
                tagElement.setAttribute('data-tag', tagText);
                tagElement.innerHTML = `
                    <span class="tag-text">${tagText}</span>
                    <button type="button" class="tag-remove" onclick="tagsManager.removeTagByElement(this.parentNode)">
                        <i class="fas fa-times"></i>
                    </button>`;
                const tagsInput = document.getElementById('tagsInput');
                document.getElementById('tagsContainer').insertBefore(tagElement, tagsInput);
                this.updateHiddenInput();
                tagsInput.focus();
            }
            removeTag(index) {
                if (index >= 0 && index < this.tags.length) {
                    this.tags.splice(index, 1);
                    this.renderTags();
                    this.updateHiddenInput();
                }
            }
            removeTagByElement(tagElement) {
                const tagText = tagElement.getAttribute('data-tag');
                const index = this.tags.indexOf(tagText);
                if (index !== -1) { this.removeTag(index); }
            }
            renderTags() {
                const tagsContainer = document.getElementById('tagsContainer');
                const tagsInput = document.getElementById('tagsInput');
                tagsContainer.querySelectorAll('.tag-item').forEach(el => el.remove());
                this.tags.forEach(tag => {
                    const tagElement = document.createElement('div');
                    tagElement.className = 'tag-item';
                    tagElement.setAttribute('data-tag', tag);
                    tagElement.innerHTML = `
                        <span class="tag-text">${tag}</span>
                        <button type="button" class="tag-remove" onclick="tagsManager.removeTagByElement(this.parentNode)">
                            <i class="fas fa-times"></i>
                        </button>`;
                    tagsContainer.insertBefore(tagElement, tagsInput);
                });
            }
            updateHiddenInput() { document.getElementById('tags').value = this.tags.join(','); }
            clearTags() { this.tags = []; this.renderTags(); this.updateHiddenInput(); }
            getTags() { return this.tags; }
            setTags(tagsArray) { this.tags = [...tagsArray]; this.renderTags(); this.updateHiddenInput(); }
        }

        class BlogPostBuilder {
            constructor() { this.elements = []; this.nextId = 1; this.ckEditors = new Map(); this.init(); }
            init() { this.setupDragAndDrop(); this.updateElementCount(); }
            setupDragAndDrop() {
                $('.widget-card').on('dragstart', (e) => {
                    const type = $(e.currentTarget).data('type');
                    e.originalEvent.dataTransfer.setData('text/plain', type);
                    e.originalEvent.dataTransfer.effectAllowed = 'copy';
                    $(e.currentTarget).addClass('dragging');
                });
                $('.widget-card').on('dragend', (e) => { $(e.currentTarget).removeClass('dragging'); });
                $('#canvas').on('dragover', (e) => {
                    e.preventDefault();
                    e.originalEvent.dataTransfer.dropEffect = 'copy';
                    $('#canvas').addClass('border-primary bg-light');
                });
                $('#canvas').on('dragleave', (e) => {
                    if (!$(e.currentTarget).has(e.relatedTarget).length) { $('#canvas').removeClass('border-primary bg-light'); }
                });
                $('#canvas').on('drop', (e) => {
                    e.preventDefault();
                    $('#canvas').removeClass('border-primary bg-light');
                    const type = e.originalEvent.dataTransfer.getData('text/plain');
                    if (type) { this.addElement(type); }
                });
            }
            addElement(type) {
                const id = `element_${this.nextId++}`;
                const element = { id: id, type: type, content: this.getDefaultContent(type), position: this.elements.length };
                this.elements.push(element);
                this.renderElement(element);
                this.updateElementCount();
                this.hideEmptyCanvas();
                this.updatePositionButtons();
            }
            getDefaultContent(type) {
                const defaults = {
                    heading: { text: 'New Heading', level: 'h2' },
                    text: { content: '<p>Enter your text content here...</p>' },
                    image: { src: '', alt: 'Image', caption: '' },
                    banner: { src: '', title: 'Banner Title', subtitle: 'Banner subtitle' },
                    columns: { left: '<p>Left column content...</p>', right: '<p>Right column content...</p>' }
                };
                return defaults[type] || {};
            }
            renderElement(element) {
                const html = this.getElementHTML(element);
                $('#canvas').append(html);
                this.attachElementEvents(element.id);
                this.initCKEditor(element.id, element.type);
            }
            getElementHTML(element) {
                const typeNames = { heading: 'Heading', text: 'Text', image: 'Image', banner: 'Banner', columns: 'Two Columns' };
                const controls = (id) => `
                    <div class="position-controls">
                        <button type="button" class="position-btn move-up" title="Move Up" onclick="builder.moveElementUp('${id}')"><i class="fas fa-arrow-up"></i></button>
                        <button type="button" class="position-btn move-down" title="Move Down" onclick="builder.moveElementDown('${id}')"><i class="fas fa-arrow-down"></i></button>
                        <button type="button" class="position-btn remove-btn" title="Remove Element" onclick="builder.removeElement('${id}')"><i class="fas fa-times"></i></button>
                    </div>`;
                const templates = {
                    heading: (el) => `
                        <div class="canvas-element" data-id="${el.id}">
                            <div class="element-header">
                                <div><span>${typeNames[el.type]}</span><span class="element-type-badge">${el.content.level || 'h2'}</span></div>
                                ${controls(el.id)}
                            </div>
                            <input type="text" class="form-control heading-input" value="${el.content.text}" placeholder="Enter heading text">
                            <select class="form-select mt-2 heading-level">
                                <option value="h1" ${el.content.level === 'h1' ? 'selected' : ''}>H1</option>
                                <option value="h2" ${el.content.level === 'h2' || !el.content.level ? 'selected' : ''}>H2</option>
                                <option value="h3" ${el.content.level === 'h3' ? 'selected' : ''}>H3</option>
                            </select>
                        </div>`,
                    text: (el) => `
                        <div class="canvas-element" data-id="${el.id}">
                            <div class="element-header"><div><span>${typeNames[el.type]}</span><span class="element-type-badge">Text</span></div>${controls(el.id)}</div>
                            <div class="ckeditor-container">
                                <textarea class="form-control ckeditor-text" id="ckeditor-text-${el.id}" rows="6">${el.content.content}</textarea>
                            </div>
                        </div>`,
                    image: (el) => `
                        <div class="canvas-element" data-id="${el.id}">
                            <div class="element-header"><div><span>${typeNames[el.type]}</span><span class="element-type-badge">Image</span></div>${controls(el.id)}</div>
                            <div class="mb-3"><input type="file" class="form-control image-upload" accept="image/*"></div>
                            <input type="text" class="form-control mb-2 image-caption" value="${el.content.caption}" placeholder="Image caption">
                            ${el.content.src ? `<img src="${el.content.src}" class="img-fluid mt-2" style="max-height: 200px;">` : ''}
                        </div>`,
                    banner: (el) => `
                        <div class="canvas-element" data-id="${el.id}">
                            <div class="element-header"><div><span>${typeNames[el.type]}</span><span class="element-type-badge">Banner</span></div>${controls(el.id)}</div>
                            <div class="mb-3"><input type="file" class="form-control image-upload" accept="image/*"></div>
                            <input type="text" class="form-control mb-2 banner-title" value="${el.content.title}" placeholder="Banner title">
                            <input type="text" class="form-control mb-2 banner-subtitle" value="${el.content.subtitle}" placeholder="Banner subtitle">
                            ${el.content.src ? `<img src="${el.content.src}" class="img-fluid mt-2" style="max-height: 200px;">` : ''}
                        </div>`,
                    columns: (el) => `
                        <div class="canvas-element" data-id="${el.id}">
                            <div class="element-header"><div><span>${typeNames[el.type]}</span><span class="element-type-badge">Columns</span></div>${controls(el.id)}</div>
                            <div class="row">
                                <div class="col-md-6 ckeditor-column">
                                    <label class="form-label">Left Column</label>
                                    <div class="ckeditor-container"><textarea class="form-control ckeditor-column-left" id="ckeditor-left-${el.id}" rows="6">${el.content.left}</textarea></div>
                                </div>
                                <div class="col-md-6 ckeditor-column">
                                    <label class="form-label">Right Column</label>
                                    <div class="ckeditor-container"><textarea class="form-control ckeditor-column-right" id="ckeditor-right-${el.id}" rows="6">${el.content.right}</textarea></div>
                                </div>
                            </div>
                        </div>`
                };
                return templates[element.type] ? templates[element.type](element) : '<div>Unknown element type</div>';
            }
            attachElementEvents(elementId) {
                $(`[data-id="${elementId}"] input, [data-id="${elementId}"] textarea, [data-id="${elementId}"] select`).on('change input', (e) => {
                    if ($(e.target).hasClass('ckeditor-text') || $(e.target).hasClass('ckeditor-column-left') || $(e.target).hasClass('ckeditor-column-right')) { return; }
                    this.updateElementContent(elementId, e.target);
                });
                $(`[data-id="${elementId}"] .image-upload`).on('change', (e) => { this.handleImageUpload(elementId, e.target); });
            }
            updateElementContent(elementId, target) {
                const element = this.elements.find(el => el.id === elementId);
                if (!element) return;
                const $target = $(target);
                const className = $target.attr('class');
                if (className.includes('heading-input')) { element.content.text = $target.val(); }
                else if (className.includes('heading-level')) {
                    element.content.level = $target.val();
                    const $badge = $(`[data-id="${elementId}"] .element-type-badge`);
                    if ($badge.length) { $badge.text($target.val()); }
                }
                else if (className.includes('image-caption')) { element.content.caption = $target.val(); }
                else if (className.includes('banner-title')) { element.content.title = $target.val(); }
                else if (className.includes('banner-subtitle')) { element.content.subtitle = $target.val(); }
            }
            handleImageUpload(elementId, fileInput) {
                const file = fileInput.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = (e) => {
                    const element = this.elements.find(el => el.id === elementId);
                    if (element) { element.content.src = e.target.result; this.updateElementDisplay(elementId); }
                };
                reader.readAsDataURL(file);
            }
            updateElementDisplay(elementId) {
                const element = this.elements.find(el => el.id === elementId);
                if (element) { $(`[data-id="${elementId}"]`).remove(); this.renderElement(element); }
            }
            removeElement(elementId) {
                if (!confirm('Remove this element?')) return;
                const index = this.elements.findIndex(el => el.id === elementId);
                if (index !== -1) {
                    this.elements.splice(index, 1);
                    this.elements.forEach((el, idx) => { el.position = idx; });
                    this.destroyCKEditor(elementId);
                    $(`[data-id="${elementId}"]`).remove();
                    this.updateElementCount();
                    this.updatePositionButtons();
                    if (this.elements.length === 0) { this.showEmptyCanvas(); }
                }
            }
            moveElementUp(elementId) {
                const index = this.elements.findIndex(el => el.id === elementId);
                if (index > 0) {
                    [this.elements[index], this.elements[index - 1]] = [this.elements[index - 1], this.elements[index]];
                    this.elements.forEach((el, idx) => { el.position = idx; });
                    this.renderAllElements();
                    this.updatePositionButtons();
                }
            }
            moveElementDown(elementId) {
                const index = this.elements.findIndex(el => el.id === elementId);
                if (index < this.elements.length - 1) {
                    [this.elements[index], this.elements[index + 1]] = [this.elements[index + 1], this.elements[index]];
                    this.elements.forEach((el, idx) => { el.position = idx; });
                    this.renderAllElements();
                    this.updatePositionButtons();
                }
            }
            renderAllElements() {
                $('#canvas').empty();
                this.elements.forEach(element => { this.renderElement(element); });
                if (this.elements.length === 0) { this.showEmptyCanvas(); }
            }
            updatePositionButtons() {
                this.elements.forEach((element, index) => {
                    $(`[data-id="${element.id}"] .move-up`).prop('disabled', index === 0);
                    $(`[data-id="${element.id}"] .move-down`).prop('disabled', index === this.elements.length - 1);
                });
            }
            updateElementCount() {
                $('#elementCount').text(`${this.elements.length} element${this.elements.length !== 1 ? 's' : ''}`);
            }
            hideEmptyCanvas() { $('#emptyCanvas').hide(); }
            showEmptyCanvas() { $('#emptyCanvas').show(); }
            clearCanvas() {
                if (!confirm('Clear all elements? This cannot be undone.')) return;
                this.ckEditors.forEach((editor) => { if (editor && editor.destroy) { editor.destroy(); } });
                this.ckEditors.clear();
                this.elements = [];
                $('#canvas').empty().append(`
                    <div class="empty-canvas" id="emptyCanvas">
                        <i class="fas fa-hand-pointer fa-2x mb-3"></i>
                        <h5>Drag elements here to build your blog post</h5>
                        <p class="text-muted">Select from the palette on the left and drop in this area</p>
                    </div>`);
                this.updateElementCount();
            }
            getPageData() {
                return { elements: this.elements, metadata: { created: new Date().toISOString(), total_elements: this.elements.length, version: '1.0' } };
            }
            previewPage() {
                if (this.elements.length === 0) { alert('Please add some elements to the canvas first'); return; }
                $('#previewContent').html(this.generatePreview());
                new bootstrap.Modal(document.getElementById('previewModal')).show();
            }
            generatePreview() {
                let html = '';
                this.elements.forEach(element => { html += this.renderPreviewElement(element); });
                return html || '<p class="text-muted text-center py-4">No content to preview</p>';
            }
            renderPreviewElement(element) {
                const templates = {
                    heading: (el) => `<${el.content.level} class="mb-3">${el.content.text}</${el.content.level}>`,
                    text: (el) => `<div class="mb-3">${el.content.content}</div>`,
                    image: (el) => `
                        <div class="mb-4">
                            ${el.content.src ? `<img src="${el.content.src}" class="img-fluid rounded mb-2" style="max-height: 300px;">` : '<div class="bg-light text-center py-5 rounded text-muted">No image</div>'}
                            ${el.content.caption ? `<p class="text-muted text-center mt-2">${el.content.caption}</p>` : ''}
                        </div>`,
                    banner: (el) => `
                        <div class="bg-light p-5 mb-4 text-center rounded">
                            ${el.content.src ? `<img src="${el.content.src}" class="img-fluid mb-3" style="max-height: 200px;">` : ''}
                            <h2>${el.content.title || 'Banner Title'}</h2>
                            <p class="lead">${el.content.subtitle || 'Banner subtitle'}</p>
                        </div>`,
                    columns: (el) => `
                        <div class="row mb-4">
                            <div class="col-md-6"><div class="bg-light p-3 rounded">${el.content.left}</div></div>
                            <div class="col-md-6"><div class="bg-light p-3 rounded">${el.content.right}</div></div>
                        </div>`
                };
                return templates[element.type] ? templates[element.type](element) : '';
            }
            async saveBlogPost() {
                const title = $('#title').val().trim();
                if (!title) { alert('Please enter a blog post title'); return; }
                if (this.elements.length === 0) { alert('Please add some content to your blog post before saving'); return; }
                const featuredImage = $('#featured_image')[0].files[0];
                const maxSize = 2000 * 1024;
                if (featuredImage && featuredImage.size > maxSize) { alert('Featured image size must be less than 2000 KB. Please choose a smaller file.'); return; }
                const formData = new FormData();
                formData.append('title', title);
                formData.append('blog_category_id', $('#blog_category_id').val());
                formData.append('excerpt', $('#excerpt').val());
                formData.append('status', $('#status').val());
                formData.append('tags', $('#tags').val());
                formData.append('structure', JSON.stringify(this.getPageData()));
                formData.append('_token', $('input[name="_token"]').val());
                if (featuredImage && featuredImage.size <= maxSize) { formData.append('featured_image', featuredImage); }
                const $saveBtn = $('.btn-success');
                $saveBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Saving...');
                try {
                    const response = await fetch('{{ route("blog-posts.store") }}', { method: 'POST', body: formData });
                    const result = await response.json();
                    if (result.success) {
                        $('#saveResult').html(`
                            <div class="alert alert-success">
                                <strong>Success!</strong> Blog post "${title}" has been created successfully.
                                <div class="mt-2">
                                    <a href="${result.redirect_url}" class="btn btn-primary btn-sm me-2">View Post</a>
                                    <a href="{{ route('blog-posts.index') }}" class="btn btn-secondary btn-sm">Back to Posts</a>
                                </div>
                            </div>`);
                        $('#blogPostForm')[0].reset();
                        this.clearCanvas();
                        tagsManager.clearTags();
                        $('#featured_image').removeClass('is-valid is-invalid');
                    } else { throw new Error(result.message); }
                } catch (error) {
                    $('#saveResult').html(`<div class="alert alert-danger"><strong>Error!</strong> ${error.message}</div>`);
                } finally {
                    $saveBtn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Save Blog Post');
                }
            }
            initCKEditor(elementId, elementType) {
                try {
                    const toolbar = [
                        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
                        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Blockquote'] },
                        { name: 'links', items: ['Link', 'Unlink'] },
                        { name: 'insert', items: ['Image', 'Table'] },
                        { name: 'tools', items: ['Maximize'] },
                        { name: 'document', items: ['Source'] }
                    ];
                    if (elementType === 'text') {
                        const editor = CKEDITOR.replace(`ckeditor-text-${elementId}`, { toolbar, height: 200 });
                        this.ckEditors.set(elementId, editor);
                        editor.on('change', () => {
                            const element = this.elements.find(el => el.id === elementId);
                            if (element) { element.content.content = editor.getData(); }
                        });
                    } else if (elementType === 'columns') {
                        const leftEditor = CKEDITOR.replace(`ckeditor-left-${elementId}`, { toolbar, height: 200 });
                        const rightEditor = CKEDITOR.replace(`ckeditor-right-${elementId}`, { toolbar, height: 200 });
                        this.ckEditors.set(`${elementId}-left`, leftEditor);
                        this.ckEditors.set(`${elementId}-right`, rightEditor);
                        leftEditor.on('change', () => {
                            const element = this.elements.find(el => el.id === elementId);
                            if (element) { element.content.left = leftEditor.getData(); }
                        });
                        rightEditor.on('change', () => {
                            const element = this.elements.find(el => el.id === elementId);
                            if (element) { element.content.right = rightEditor.getData(); }
                        });
                    }
                } catch (error) { console.error('Error initializing CKEditor:', error); }
            }
            destroyCKEditor(elementId) {
                [elementId, `${elementId}-left`, `${elementId}-right`].forEach((key) => {
                    if (this.ckEditors.has(key)) {
                        const editor = this.ckEditors.get(key);
                        if (editor && editor.destroy) { editor.destroy(); }
                        this.ckEditors.delete(key);
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            window.builder = new BlogPostBuilder();
            window.tagsManager = new TagsManager();
        });
    </script>
    @endpush
</x-app-layout>
