<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Blog Post - LegalConsultent</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CKEditor 4 -->
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

    <style>
        .builder-container {
            background: #f8f9fa;
            min-height: 100vh;
        }
        
        .sidebar {
            background: white;
            border-right: 1px solid #dee2e6;
            height: 100vh;
            overflow-y: auto;
            position: fixed;
            width: 300px;
        }
        
        .main-content {
            margin-left: 300px;
            padding: 20px;
        }
        
        .widget-card {
            cursor: grab;
            border: 2px dashed #dee2e6;
            transition: all 0.3s;
            margin-bottom: 10px;
            border-radius: 8px;
        }
        
        .widget-card:hover {
            border-color: #0d6efd;
            transform: translateY(-2px);
        }
        
        .canvas-area {
            background: white;
            min-height: 400px;
            border: 2px dashed #ced4da;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .canvas-element {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s;
            position: relative;
        }
        
        .canvas-element:hover {
            border-color: #0d6efd;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .element-header {
            background: #f8f9fa;
            padding: 8px 15px;
            margin: -15px -15px 15px -15px;
            border-radius: 8px 8px 0 0;
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .empty-canvas {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        
        .position-controls {
            display: flex;
            gap: 5px;
        }
        
        .position-btn {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #dee2e6;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .position-btn:hover {
            background: #f8f9fa;
            border-color: #6c757d;
        }
        
        .position-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .position-btn:disabled:hover {
            background: white;
            border-color: #dee2e6;
        }
        
        .element-type-badge {
            font-size: 0.75rem;
            background: #6c757d;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            margin-left: 10px;
        }
        
        .position-btn.remove-btn {
            color: #dc3545;
            border-color: #dc3545;
        }

        .position-btn.remove-btn:hover {
            background: #dc3545;
            color: white;
        }

        /* CKEditor Styles */
        .ckeditor-container {
            margin-top: 10px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }
        
        .ckeditor-column {
            margin-bottom: 15px;
        }

        .cke_notification_warning{
            display: none;
        }

        .basic-info-card {
            margin-bottom: 20px;
        }
        
    </style>
</head>

<body>
    <div class="builder-container">
        <div class="d-flex">
            <!-- Sidebar -->
            <div class="sidebar p-3">
                <h5 class="mb-3">Blog Elements</h5>
                
                <div class="widget-card p-3" draggable="true" data-type="heading">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-heading text-primary me-2"></i>
                        <span>Heading</span>
                    </div>
                </div>
                
                <div class="widget-card p-3" draggable="true" data-type="text">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-paragraph text-primary me-2"></i>
                        <span>Text Content</span>
                    </div>
                </div>
                
                <div class="widget-card p-3" draggable="true" data-type="image">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-image text-primary me-2"></i>
                        <span>Image</span>
                    </div>
                </div>
                
                <div class="widget-card p-3" draggable="true" data-type="banner">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-banner text-primary me-2"></i>
                        <span>Banner</span>
                    </div>
                </div>
                
                <div class="widget-card p-3" draggable="true" data-type="columns">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-columns text-primary me-2"></i>
                        <span>Two Columns</span>
                    </div>
                </div>

                <hr>
                
                <div class="mt-3">
                    <button class="btn btn-outline-primary btn-sm w-100 mb-2" onclick="builder.previewPage()">
                        <i class="fas fa-eye me-1"></i>Preview
                    </button>
                    <button class="btn btn-outline-danger btn-sm w-100" onclick="builder.clearCanvas()">
                        <i class="fas fa-trash me-1"></i>Clear All
                    </button>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="main-content flex-grow-1">
                <!-- Basic Information Card -->
                <div class="card basic-info-card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <form id="blogPostForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Post Title *</label>
                                        <input type="text" class="form-control" id="title" name="title" required
                                               placeholder="Enter your blog post title">
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
                                <textarea class="form-control" id="excerpt" name="excerpt" rows="2" 
                                          placeholder="Brief description of your blog post"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                <input type="text" class="form-control" id="tags" name="tags" 
                                       placeholder="Enter tags separated by commas (e.g., legal, advice, law)">
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Page Builder Canvas -->
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-pencil-alt me-2"></i>Content Builder</h5>
                            <span class="badge bg-light text-dark" id="elementCount">0 elements</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="canvas-area" id="canvas">
                            <div class="empty-canvas" id="emptyCanvas">
                                <i class="fas fa-arrow-left fa-2x mb-3"></i>
                                <h5>Drag elements here to build your blog post</h5>
                                <p class="text-muted">Select from the sidebar and drop in this area</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save Section -->
                <div class="card mt-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-save me-2"></i>Save Blog Post</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
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

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        class BlogPostBuilder {
            constructor() {
                this.elements = [];
                this.nextId = 1;
                this.ckEditors = new Map();
                this.init();
            }

            init() {
                this.setupDragAndDrop();
                this.updateElementCount();
            }

            setupDragAndDrop() {
                // Make widgets draggable
                $('.widget-card').on('dragstart', (e) => {
                    const type = $(e.currentTarget).data('type');
                    e.originalEvent.dataTransfer.setData('text/plain', type);
                    e.originalEvent.dataTransfer.effectAllowed = 'copy';
                    $(e.currentTarget).addClass('dragging');
                });

                $('.widget-card').on('dragend', (e) => {
                    $(e.currentTarget).removeClass('dragging');
                });

                // Canvas drop zone
                $('#canvas').on('dragover', (e) => {
                    e.preventDefault();
                    e.originalEvent.dataTransfer.dropEffect = 'copy';
                    $('#canvas').addClass('border-primary bg-light');
                });

                $('#canvas').on('dragleave', (e) => {
                    if (!$(e.currentTarget).has(e.relatedTarget).length) {
                        $('#canvas').removeClass('border-primary bg-light');
                    }
                });

                $('#canvas').on('drop', (e) => {
                    e.preventDefault();
                    $('#canvas').removeClass('border-primary bg-light');
                    
                    const type = e.originalEvent.dataTransfer.getData('text/plain');
                    if (type) {
                        this.addElement(type);
                    }
                });
            }

            addElement(type) {
                const id = `element_${this.nextId++}`;
                const element = {
                    id: id,
                    type: type,
                    content: this.getDefaultContent(type),
                    position: this.elements.length
                };

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
                    columns: { 
                        left: '<p>Left column content...</p>', 
                        right: '<p>Right column content...</p>' 
                    }
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
                const typeNames = {
                    heading: 'Heading',
                    text: 'Text',
                    image: 'Image',
                    banner: 'Banner',
                    columns: 'Two Columns'
                };

                const templates = {
                    heading: (el) => `
                        <div class="canvas-element" data-id="${el.id}">
                            <div class="element-header">
                                <div>
                                    <span>${typeNames[el.type]}</span>
                                    <span class="element-type-badge">${el.content.level || 'h2'}</span>
                                </div>
                                <div class="position-controls">
                                    <button type="button" class="position-btn move-up" title="Move Up" onclick="builder.moveElementUp('${el.id}')">
                                        <i class="fas fa-arrow-up"></i>
                                    </button>
                                    <button type="button" class="position-btn move-down" title="Move Down" onclick="builder.moveElementDown('${el.id}')">
                                        <i class="fas fa-arrow-down"></i>
                                    </button>
                                    <button type="button" class="position-btn remove-btn" title="Remove Element" onclick="builder.removeElement('${el.id}')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <input type="text" class="form-control heading-input" 
                                value="${el.content.text}" 
                                placeholder="Enter heading text">
                            <select class="form-select mt-2 heading-level">
                                <option value="h1" ${el.content.level === 'h1' ? 'selected' : ''}>H1</option>
                                <option value="h2" ${el.content.level === 'h2' || !el.content.level ? 'selected' : ''}>H2</option>
                                <option value="h3" ${el.content.level === 'h3' ? 'selected' : ''}>H3</option>
                            </select>
                        </div>
                    `,
                    
                    text: (el) => `
                        <div class="canvas-element" data-id="${el.id}">
                            <div class="element-header">
                                <div>
                                    <span>${typeNames[el.type]}</span>
                                    <span class="element-type-badge">Text</span>
                                </div>
                                <div class="position-controls">
                                    <button type="button" class="position-btn move-up" title="Move Up" onclick="builder.moveElementUp('${el.id}')">
                                        <i class="fas fa-arrow-up"></i>
                                    </button>
                                    <button type="button" class="position-btn move-down" title="Move Down" onclick="builder.moveElementDown('${el.id}')">
                                        <i class="fas fa-arrow-down"></i>
                                    </button>
                                    <button type="button" class="position-btn remove-btn" title="Remove Element" onclick="builder.removeElement('${el.id}')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="ckeditor-container">
                                <textarea class="form-control ckeditor-text" id="ckeditor-text-${el.id}" rows="6">${el.content.content}</textarea>
                            </div>
                        </div>
                    `,
                    
                    image: (el) => `
                        <div class="canvas-element" data-id="${el.id}">
                            <div class="element-header">
                                <div>
                                    <span>${typeNames[el.type]}</span>
                                    <span class="element-type-badge">Image</span>
                                </div>
                                <div class="position-controls">
                                    <button type="button" class="position-btn move-up" title="Move Up" onclick="builder.moveElementUp('${el.id}')">
                                        <i class="fas fa-arrow-up"></i>
                                    </button>
                                    <button type="button" class="position-btn move-down" title="Move Down" onclick="builder.moveElementDown('${el.id}')">
                                        <i class="fas fa-arrow-down"></i>
                                    </button>
                                    <button type="button" class="position-btn remove-btn" title="Remove Element" onclick="builder.removeElement('${el.id}')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="file" class="form-control image-upload" accept="image/*">
                            </div>
                            <input type="text" class="form-control mb-2 image-caption" 
                                value="${el.content.caption}" placeholder="Image caption">
                            ${el.content.src ? `<img src="${el.content.src}" class="img-fluid mt-2" style="max-height: 200px;">` : ''}
                        </div>
                    `,
                    
                    banner: (el) => `
                        <div class="canvas-element" data-id="${el.id}">
                            <div class="element-header">
                                <div>
                                    <span>${typeNames[el.type]}</span>
                                    <span class="element-type-badge">Banner</span>
                                </div>
                                <div class="position-controls">
                                    <button type="button" class="position-btn move-up" title="Move Up" onclick="builder.moveElementUp('${el.id}')">
                                        <i class="fas fa-arrow-up"></i>
                                    </button>
                                    <button type="button" class="position-btn move-down" title="Move Down" onclick="builder.moveElementDown('${el.id}')">
                                        <i class="fas fa-arrow-down"></i>
                                    </button>
                                    <button type="button" class="position-btn remove-btn" title="Remove Element" onclick="builder.removeElement('${el.id}')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="file" class="form-control image-upload" accept="image/*">
                            </div>
                            <input type="text" class="form-control mb-2 banner-title" 
                                value="${el.content.title}" placeholder="Banner title">
                            <input type="text" class="form-control mb-2 banner-subtitle" 
                                value="${el.content.subtitle}" placeholder="Banner subtitle">
                            ${el.content.src ? `<img src="${el.content.src}" class="img-fluid mt-2" style="max-height: 200px;">` : ''}
                        </div>
                    `,
                    
                    columns: (el) => `
                        <div class="canvas-element" data-id="${el.id}">
                            <div class="element-header">
                                <div>
                                    <span>${typeNames[el.type]}</span>
                                    <span class="element-type-badge">Columns</span>
                                </div>
                                <div class="position-controls">
                                    <button type="button" class="position-btn move-up" title="Move Up" onclick="builder.moveElementUp('${el.id}')">
                                        <i class="fas fa-arrow-up"></i>
                                    </button>
                                    <button type="button" class="position-btn move-down" title="Move Down" onclick="builder.moveElementDown('${el.id}')">
                                        <i class="fas fa-arrow-down"></i>
                                    </button>
                                    <button type="button" class="position-btn remove-btn" title="Remove Element" onclick="builder.removeElement('${el.id}')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 ckeditor-column">
                                    <label class="form-label">Left Column</label>
                                    <div class="ckeditor-container">
                                        <textarea class="form-control ckeditor-column-left" id="ckeditor-left-${el.id}" rows="6">${el.content.left}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 ckeditor-column">
                                    <label class="form-label">Right Column</label>
                                    <div class="ckeditor-container">
                                        <textarea class="form-control ckeditor-column-right" id="ckeditor-right-${el.id}" rows="6">${el.content.right}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `
                };

                return templates[element.type] ? templates[element.type](element) : '<div>Unknown element type</div>';
            }

            attachElementEvents(elementId) {
                $(`[data-id="${elementId}"] input, [data-id="${elementId}"] textarea, [data-id="${elementId}"] select`).on('change input', (e) => {
                    if ($(e.target).hasClass('ckeditor-text') || 
                        $(e.target).hasClass('ckeditor-column-left') || 
                        $(e.target).hasClass('ckeditor-column-right')) {
                        return;
                    }
                    this.updateElementContent(elementId, e.target);
                });

                $(`[data-id="${elementId}"] .image-upload`).on('change', (e) => {
                    this.handleImageUpload(elementId, e.target);
                });
            }

            updateElementContent(elementId, target) {
                const element = this.elements.find(el => el.id === elementId);
                if (!element) return;

                const $target = $(target);
                const className = $target.attr('class');
                
                if (className.includes('heading-input')) {
                    element.content.text = $target.val();
                } else if (className.includes('heading-level')) {
                    element.content.level = $target.val();
                    const $badge = $(`[data-id="${elementId}"] .element-type-badge`);
                    if ($badge.length) {
                        $badge.text($target.val());
                    }
                } else if (className.includes('image-caption')) {
                    element.content.caption = $target.val();
                } else if (className.includes('banner-title')) {
                    element.content.title = $target.val();
                } else if (className.includes('banner-subtitle')) {
                    element.content.subtitle = $target.val();
                }
            }

            handleImageUpload(elementId, fileInput) {
                const file = fileInput.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = (e) => {
                    const element = this.elements.find(el => el.id === elementId);
                    if (element) {
                        element.content.src = e.target.result;
                        this.updateElementDisplay(elementId);
                    }
                };
                reader.readAsDataURL(file);
            }

            updateElementDisplay(elementId) {
                const element = this.elements.find(el => el.id === elementId);
                if (element) {
                    $(`[data-id="${elementId}"]`).remove();
                    this.renderElement(element);
                }
            }

            removeElement(elementId) {
                if (!confirm('Remove this element?')) return;
                
                const index = this.elements.findIndex(el => el.id === elementId);
                if (index !== -1) {
                    this.elements.splice(index, 1);
                    
                    this.elements.forEach((el, idx) => {
                        el.position = idx;
                    });
                    
                    this.destroyCKEditor(elementId);
                    
                    $(`[data-id="${elementId}"]`).remove();
                    
                    this.updateElementCount();
                    this.updatePositionButtons();
                    
                    if (this.elements.length === 0) {
                        this.showEmptyCanvas();
                    }
                }
            }

            moveElementUp(elementId) {
                const index = this.elements.findIndex(el => el.id === elementId);
                if (index > 0) {
                    [this.elements[index], this.elements[index - 1]] = [this.elements[index - 1], this.elements[index]];
                    
                    this.elements.forEach((el, idx) => {
                        el.position = idx;
                    });
                    
                    this.renderAllElements();
                    this.updatePositionButtons();
                }
            }

            moveElementDown(elementId) {
                const index = this.elements.findIndex(el => el.id === elementId);
                if (index < this.elements.length - 1) {
                    [this.elements[index], this.elements[index + 1]] = [this.elements[index + 1], this.elements[index]];
                    
                    this.elements.forEach((el, idx) => {
                        el.position = idx;
                    });
                    
                    this.renderAllElements();
                    this.updatePositionButtons();
                }
            }

            renderAllElements() {
                $('#canvas').empty();
                this.elements.forEach(element => {
                    this.renderElement(element);
                });
                if (this.elements.length === 0) {
                    this.showEmptyCanvas();
                }
            }

            updatePositionButtons() {
                this.elements.forEach((element, index) => {
                    const $upBtn = $(`[data-id="${element.id}"] .move-up`);
                    const $downBtn = $(`[data-id="${element.id}"] .move-down`);
                    
                    $upBtn.prop('disabled', index === 0);
                    $downBtn.prop('disabled', index === this.elements.length - 1);
                });
            }

            updateElementCount() {
                $('#elementCount').text(`${this.elements.length} element${this.elements.length !== 1 ? 's' : ''}`);
            }

            hideEmptyCanvas() {
                $('#emptyCanvas').hide();
            }

            showEmptyCanvas() {
                $('#emptyCanvas').show();
            }

            clearCanvas() {
                if (!confirm('Clear all elements? This cannot be undone.')) return;
                
                this.ckEditors.forEach((editor, key) => {
                    if (editor && editor.destroy) {
                        editor.destroy();
                    }
                });
                this.ckEditors.clear();
                
                this.elements = [];
                $('#canvas').empty().append($('#emptyCanvas').show());
                $('#canvas').append(`
                <div class="empty-canvas" id="emptyCanvas">
                        <i class="fas fa-arrow-left fa-2x mb-3"></i>
                        <h5>Drag elements here to build your blog post</h5>
                        <p class="text-muted">Select from the sidebar and drop in this area</p>
                    </div>`);
                this.updateElementCount();
            }

            getPageData() {
                return {
                    elements: this.elements,
                    metadata: {
                        created: new Date().toISOString(),
                        total_elements: this.elements.length,
                        version: '1.0'
                    }
                };
            }

            previewPage() {
                if (this.elements.length === 0) {
                    alert('Please add some elements to the canvas first');
                    return;
                }

                const previewHTML = this.generatePreview();
                $('#previewContent').html(previewHTML);
                
                const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
                previewModal.show();
            }

            generatePreview() {
                let html = '';
                this.elements.forEach(element => {
                    html += this.renderPreviewElement(element);
                });
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
                        </div>
                    `,
                    banner: (el) => `
                        <div class="bg-light p-5 mb-4 text-center rounded">
                            ${el.content.src ? `<img src="${el.content.src}" class="img-fluid mb-3" style="max-height: 200px;">` : ''}
                            <h2>${el.content.title || 'Banner Title'}</h2>
                            <p class="lead">${el.content.subtitle || 'Banner subtitle'}</p>
                        </div>
                    `,
                    columns: (el) => `
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="bg-light p-3 rounded">
                                    ${el.content.left}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light p-3 rounded">
                                    ${el.content.right}
                                </div>
                            </div>
                        </div>
                    `
                };

                return templates[element.type] ? templates[element.type](element) : '';
            }

            async saveBlogPost() {
                const title = $('#title').val().trim();
                if (!title) {
                    alert('Please enter a blog post title');
                    return;
                }

                if (this.elements.length === 0) {
                    alert('Please add some content to your blog post before saving');
                    return;
                }

                const formData = new FormData();
                formData.append('title', title);
                formData.append('blog_category_id', $('#blog_category_id').val());
                formData.append('excerpt', $('#excerpt').val());
                formData.append('status', $('#status').val());
                formData.append('tags', $('#tags').val());
                formData.append('structure', JSON.stringify(this.getPageData()));
                formData.append('_token', $('input[name="_token"]').val());

                // Add featured image if selected
                const featuredImage = $('#featured_image')[0].files[0];
                if (featuredImage) {
                    formData.append('featured_image', featuredImage);
                }

                const $saveBtn = $('.btn-success');
                $saveBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Saving...');

                try {
                    const response = await fetch('{{ route("blog-posts.store") }}', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        $('#saveResult').html(`
                            <div class="alert alert-success">
                                <strong>Success!</strong> Blog post "${title}" has been created successfully.
                                <br>
                                <div class="mt-2">
                                    <a href="${result.redirect_url}" class="btn btn-primary btn-sm me-2">View Post</a>
                                    <a href="{{ route('blog-posts.index') }}" class="btn btn-secondary btn-sm">Back to Posts</a>
                                </div>
                            </div>
                        `);
                        
                        // Reset form
                        $('#blogPostForm')[0].reset();
                        this.clearCanvas();
                    } else {
                        throw new Error(result.message);
                    }
                } catch (error) {
                    $('#saveResult').html(`
                        <div class="alert alert-danger">
                            <strong>Error!</strong> ${error.message}
                        </div>
                    `);
                } finally {
                    $saveBtn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Save Blog Post');
                }
            }

            // CKEditor Methods
            initCKEditor(elementId, elementType) {
                try {
                    if (elementType === 'text') {
                        const editor = CKEDITOR.replace(`ckeditor-text-${elementId}`, {
                            toolbar: [
                                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
                                { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Blockquote'] },
                                { name: 'links', items: ['Link', 'Unlink'] },
                                { name: 'insert', items: ['Image', 'Table'] },
                                { name: 'tools', items: ['Maximize'] },
                                { name: 'document', items: ['Source'] }
                            ],
                            height: 200
                        });
                        
                        this.ckEditors.set(elementId, editor);
                        
                        editor.on('change', () => {
                            const element = this.elements.find(el => el.id === elementId);
                            if (element) {
                                element.content.content = editor.getData();
                            }
                        });
                        
                    } else if (elementType === 'columns') {
                        const leftEditor = CKEDITOR.replace(`ckeditor-left-${elementId}`, {
                            toolbar: [
                                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
                                { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Blockquote'] },
                                { name: 'links', items: ['Link', 'Unlink'] },
                                { name: 'insert', items: ['Image', 'Table'] },
                                { name: 'tools', items: ['Maximize'] },
                                { name: 'document', items: ['Source'] }
                            ],
                            height: 200
                        });
                        
                        const rightEditor = CKEDITOR.replace(`ckeditor-right-${elementId}`, {
                            toolbar: [
                                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
                                { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Blockquote'] },
                                { name: 'links', items: ['Link', 'Unlink'] },
                                { name: 'insert', items: ['Image', 'Table'] },
                                { name: 'tools', items: ['Maximize'] },
                                { name: 'document', items: ['Source'] }
                            ],
                            height: 200
                        });
                        
                        this.ckEditors.set(`${elementId}-left`, leftEditor);
                        this.ckEditors.set(`${elementId}-right`, rightEditor);
                        
                        leftEditor.on('change', () => {
                            const element = this.elements.find(el => el.id === elementId);
                            if (element) {
                                element.content.left = leftEditor.getData();
                            }
                        });
                        
                        rightEditor.on('change', () => {
                            const element = this.elements.find(el => el.id === elementId);
                            if (element) {
                                element.content.right = rightEditor.getData();
                            }
                        });
                    }
                } catch (error) {
                    console.error('Error initializing CKEditor:', error);
                }
            }

            destroyCKEditor(elementId) {
                if (this.ckEditors.has(elementId)) {
                    const editor = this.ckEditors.get(elementId);
                    if (editor && editor.destroy) {
                        editor.destroy();
                    }
                    this.ckEditors.delete(elementId);
                }
                
                if (this.ckEditors.has(`${elementId}-left`)) {
                    const editor = this.ckEditors.get(`${elementId}-left`);
                    if (editor && editor.destroy) {
                        editor.destroy();
                    }
                    this.ckEditors.delete(`${elementId}-left`);
                }
                
                if (this.ckEditors.has(`${elementId}-right`)) {
                    const editor = this.ckEditors.get(`${elementId}-right`);
                    if (editor && editor.destroy) {
                        editor.destroy();
                    }
                    this.ckEditors.delete(`${elementId}-right`);
                }
            }
        }

        // Initialize the blog post builder when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            window.builder = new BlogPostBuilder();
        });
    </script>
</body>
</html>