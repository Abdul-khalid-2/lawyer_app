<x-app-layout>

    <style>
        .comment-content {
            line-height: 1.5;
        }
        .status-badge {
            font-size: 0.75rem;
        }
        .table tbody tr {
            transition: background-color 0.2s;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>
    <section id="comments-management" class="page-section">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('blog-posts.index') }}">Blog Posts</a></li>
                        <li class="breadcrumb-item active">Comments</li>
                    </ol>
                </nav>
                <h2 class="mb-1">Comments Management</h2>
                <p class="text-muted mb-0">Manage comments for: <strong>"{{ $post->title }}"</strong></p>
            </div>
            <a href="{{ route('blog-posts.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to Posts
            </a>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ $commentStats->total }}</h4>
                                <small>Total Comments</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-comments fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ $commentStats->approved }}</h4>
                                <small>Approved</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-check-circle fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ $commentStats->pending }}</h4>
                                <small>Pending</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-clock fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0">{{ $commentStats->rejected + $commentStats->spam }}</h4>
                                <small>Rejected/Spam</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-ban fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <label for="statusFilter" class="form-label">Filter by Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                            <option value="spam">Spam</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="searchFilter" class="form-label">Search Comments</label>
                        <input type="text" class="form-control" id="searchFilter" placeholder="Search comment content...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label d-block">&nbsp;</label>
                        <button type="button" class="btn btn-outline-secondary" id="resetFilters">
                            <i class="fas fa-refresh me-2"></i> Reset Filters
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comments Table -->
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Comments ({{ $comments->total() }})</h5>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-primary" id="selectAll">
                        <i class="fas fa-check-square me-1"></i> Select All
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-success dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-cog me-1"></i> Bulk Actions
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-bulk-action="approve"><i class="fas fa-check text-success me-2"></i>Approve Selected</a></li>
                            <li><a class="dropdown-item" href="#" data-bulk-action="reject"><i class="fas fa-times text-danger me-2"></i>Reject Selected</a></li>
                            <li><hr class="dropdown-divider"></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50" class="ps-3">
                                <input type="checkbox" id="selectAllCheckbox">
                            </th>
                            <th>Comment</th>
                            <th width="120">Author</th>
                            <th width="100">Status</th>
                            <th width="120">Date</th>
                            <th width="80">Replies</th>
                            <th width="150" class="pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments as $comment)
                        <tr data-comment-id="{{ $comment->id }}" data-status="{{ $comment->status }}">
                            <td class="ps-3">
                                <input type="checkbox" class="comment-checkbox" value="{{ $comment->id }}">
                            </td>
                            <td>
                                <div class="d-flex align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="comment-content mb-1">
                                            {{ Str::limit(strip_tags($comment->comment), 150) }}
                                        </div>
                                        @if($comment->replies_count > 0)
                                        <small class="text-muted">
                                            <i class="fas fa-reply me-1"></i>{{ $comment->replies_count }} repl{{ $comment->replies_count === 1 ? 'y' : 'ies' }}
                                        </small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $comment->user?->profile_image 
                                        ? asset('website/' . $comment->user->profile_image) 
                                        : asset('website/images/male_advocate_avatar.jpg') }}"
                                        alt="{{ $comment->user?->name ?? 'User' }}"
                                        class="rounded-circle me-2"
                                        style="width: 32px; height: 32px; object-fit: cover;">

                                    <div>
                                        <small class="fw-bold d-block">{{ $comment->user->name??$comment->name }}</small>
                                        <small class="text-muted">{{ $comment->user->email??$comment->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        'spam' => 'secondary'
                                    ];
                                @endphp

                                <span class="badge status-badge bg-{{ $statusColors[$comment->status] ?? 'secondary' }}">
                                    {{ ucfirst($comment->status) }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $comment->created_at->format('M j, Y') }}<br>
                                    <small>{{ $comment->created_at->format('g:i A') }}</small>
                                </small>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $comment->replies_count }}</span>
                            </td>
                            <td class="pe-3">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-info view-comment" 
                                            data-comment-id="{{ $comment->id }}"
                                            title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-primary dropdown-toggle" 
                                                data-bs-toggle="dropdown" title="Change Status">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item change-status" href="#" data-status="approved"><i class="fas fa-check text-success me-2"></i>Approve</a></li>
                                            <li><a class="dropdown-item change-status" href="#" data-status="pending"><i class="fas fa-clock text-warning me-2"></i>Pending</a></li>
                                            <li><a class="dropdown-item change-status" href="#" data-status="rejected"><i class="fas fa-times text-danger me-2"></i>Reject</a></li>
                                            <li><a class="dropdown-item change-status" href="#" data-status="spam"><i class="fas fa-ban text-secondary me-2"></i>Spam</a></li>
                                        </ul>
                                    </div>
                                    
                                    <button type="button" class="btn btn-outline-danger delete-comment" 
                                            data-comment-id="{{ $comment->id }}"
                                            title="Delete Comment">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-comments fa-2x text-muted mb-2"></i>
                                <p class="text-muted">No comments found for this post</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($comments->hasPages())
            <div class="card-footer">
                {{ $comments->links() }}
            </div>
            @endif
        </div>
    </section>

    <!-- Comment Detail Modal -->
    <div class="modal fade" id="commentDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Comment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="commentDetailContent">
                    <!-- Content will be loaded via AJAX -->
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Status colors mapping
            const statusColors = {
                'pending': 'warning',
                'approved': 'success',
                'rejected': 'danger',
                'spam': 'secondary'
            };

            // Select All functionality
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const commentCheckboxes = document.querySelectorAll('.comment-checkbox');

            selectAllCheckbox.addEventListener('change', function() {
                commentCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Individual checkbox change
            commentCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = document.querySelectorAll('.comment-checkbox:checked').length === commentCheckboxes.length;
                    selectAllCheckbox.checked = allChecked;
                    selectAllCheckbox.indeterminate = !allChecked && document.querySelectorAll('.comment-checkbox:checked').length > 0;
                });
            });

            // Change status for individual comment
            document.querySelectorAll('.change-status').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const commentId = this.closest('tr').dataset.commentId;
                    const newStatus = this.dataset.status;
                    
                    updateCommentStatus(commentId, newStatus);
                });
            });

            // View comment details
            document.querySelectorAll('.view-comment').forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.dataset.commentId;
                    viewCommentDetails(commentId);
                });
            });

            // Delete comment
            document.querySelectorAll('.delete-comment').forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.dataset.commentId;
                    deleteComment(commentId);
                });
            });

            // Bulk actions
            document.querySelectorAll('[data-bulk-action]').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const action = this.dataset.bulkAction;
                    const selectedComments = getSelectedComments();
                    
                    if (selectedComments.length === 0) {
                        showAlert('Please select at least one comment.', 'warning');
                        return;
                    }

                    if (action === 'delete') {
                        if (!confirm(`Are you sure you want to delete ${selectedComments.length} comment(s)?`)) {
                            return;
                        }
                    }

                    performBulkAction(selectedComments, action);
                });
            });

            // Filter functionality
            document.getElementById('statusFilter').addEventListener('change', filterComments);
            document.getElementById('searchFilter').addEventListener('input', filterComments);
            document.getElementById('resetFilters').addEventListener('click', resetFilters);

            function getSelectedComments() {
                return Array.from(document.querySelectorAll('.comment-checkbox:checked'))
                    .map(checkbox => checkbox.value);
            }

            function updateCommentStatus(commentId, newStatus) {
                fetch(`/comments/${commentId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = document.querySelector(`tr[data-comment-id="${commentId}"]`);
                        const statusBadge = row.querySelector('.status-badge');
                        
                        statusBadge.className = `badge status-badge bg-${statusColors[newStatus]}`;
                        statusBadge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                        
                        row.dataset.status = newStatus;
                        
                        showAlert(data.message, 'success');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error updating comment status', 'error');
                });
            }

            function viewCommentDetails(commentId) {
                fetch(`/comments/${commentId}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('commentDetailContent').innerHTML = html;
                    const modal = new bootstrap.Modal(document.getElementById('commentDetailModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error loading comment details', 'error');
                });
            }

            function deleteComment(commentId) {
                if (!confirm('Are you sure you want to delete this comment? This action cannot be undone.')) {
                    return;
                }

                fetch(`/comments/${commentId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`tr[data-comment-id="${commentId}"]`).remove();
                        showAlert(data.message, 'success');
                        // Update statistics if needed
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error deleting comment', 'error');
                });
            }

            function performBulkAction(commentIds, action) {
                const promises = commentIds.map(commentId => {
                    if (action === 'delete') {
                        return fetch(`/comments/${commentId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                    } else {
                        return fetch(`/comments/${commentId}/status`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ status: action })
                        });
                    }
                });

                Promise.all(promises)
                .then(() => {
                    showAlert(`Bulk action completed successfully`, 'success');
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error performing bulk action', 'error');
                });
            }

            function filterComments() {
                const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
                const searchFilter = document.getElementById('searchFilter').value.toLowerCase();
                
                document.querySelectorAll('tbody tr').forEach(row => {
                    const status = row.dataset.status;
                    const content = row.querySelector('.comment-content').textContent.toLowerCase();
                    
                    const statusMatch = !statusFilter || status === statusFilter;
                    const searchMatch = !searchFilter || content.includes(searchFilter);
                    
                    row.style.display = statusMatch && searchMatch ? '' : 'none';
                });
            }

            function resetFilters() {
                document.getElementById('statusFilter').value = '';
                document.getElementById('searchFilter').value = '';
                filterComments();
            }

            function showAlert(message, type) {
                // You can use Toastr or similar library here
                alert(`${type.toUpperCase()}: ${message}`);
            }
        });
    </script>
</x-app-layout>