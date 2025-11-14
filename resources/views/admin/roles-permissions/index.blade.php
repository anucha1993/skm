@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">จัดการ Roles และ Permissions</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">จัดการสิทธิ์</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Role Management -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Roles และ Permissions</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Role Name</th>
                                    <th>Permissions</th>
                                    <th>Users Count</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td>
                                        <strong>{{ ucfirst($role->name) }}</strong>
                                    </td>
                                    <td>
                                        @if($role->permissions->count() > 0)
                                            @foreach($role->permissions->take(3) as $permission)
                                                <span class="badge bg-primary me-1">{{ $permission->name_view }}</span>
                                            @endforeach
                                            @if($role->permissions->count() > 3)
                                                <span class="text-muted">และอีก {{ $role->permissions->count() - 3 }} รายการ</span>
                                            @endif
                                        @else
                                            <span class="text-muted">ไม่มีสิทธิ์</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $role->users->count() }} คน</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary edit-role-btn" 
                                                data-role-id="{{ $role->id }}"
                                                data-role-name="{{ $role->name }}"
                                                data-permissions="{{ $role->permissions->pluck('name')->toJson() }}">
                                            <i class="fas fa-edit"></i> แก้ไข
                                        </button>
                                        @can('delete-role')
                                        <button class="btn btn-sm btn-danger delete-role-btn" 
                                                data-role-id="{{ $role->id }}">
                                            <i class="fas fa-trash"></i> ลบ
                                        </button>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $roles->links() }}
                </div>
            </div>
        </div>

        <!-- Create/Edit Role Form -->
        <div class="col-lg-4">
            @can('create-role')
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0" id="form-title">สร้าง Role ใหม่</h5>
                </div>
                <div class="card-body">
                    <form id="role-form">
                        <input type="hidden" id="role-id" name="role_id">
                        <div class="mb-3">
                            <label for="role-name" class="form-label">ชื่อ Role</label>
                            <input type="text" class="form-control" id="role-name" name="name" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Permissions</label>
                            <div class="permission-groups">
                                @foreach($permissions as $actionName => $permissionGroup)
                                <div class="mb-3">
                                    <h6 class="text-primary">{{ $actionName ?? 'อื่นๆ' }}</h6>
                                    @foreach($permissionGroup as $permission)
                                    <div class="form-check">
                                        <input class="form-check-input permission-checkbox" 
                                               type="checkbox" 
                                               value="{{ $permission->name }}" 
                                               id="perm-{{ $permission->id }}"
                                               name="permissions[]">
                                        <label class="form-check-label" for="perm-{{ $permission->id }}">
                                            {{ $permission->name_view }}
                                            @if(in_array($permission->name, ['finance-view', 'finance-manage']))
                                                <span class="badge bg-warning text-dark">การเงิน</span>
                                            @endif
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" id="submit-btn">
                                <i class="fas fa-save"></i> สร้าง Role
                            </button>
                            <button type="button" class="btn btn-secondary" id="cancel-btn" style="display: none;">
                                <i class="fas fa-times"></i> ยกเลิก
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endcan

            <!-- User Role Assignment -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">กำหนด Role ให้ผู้ใช้</h5>
                </div>
                <div class="card-body">
                    <form id="user-role-form">
                        <div class="mb-3">
                            <label for="user-select" class="form-label">เลือกผู้ใช้</label>
                            <select class="form-select" id="user-select" name="user_id" required>
                                <option value="">-- เลือกผู้ใช้ --</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" 
                                        data-current-roles="{{ $user->roles->pluck('name')->toJson() }}">
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Roles</label>
                            <div id="user-roles-checkboxes">
                                @foreach($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input user-role-checkbox" 
                                           type="checkbox" 
                                           value="{{ $role->name }}" 
                                           id="user-role-{{ $role->id }}"
                                           name="roles[]">
                                    <label class="form-check-label" for="user-role-{{ $role->id }}">
                                        {{ ucfirst($role->name) }}
                                        <small class="text-muted">({{ $role->permissions->count() }} permissions)</small>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-user-check"></i> อัพเดท User Roles
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Role form submission
    $('#role-form').on('submit', function(e) {
        e.preventDefault();
        
        let roleId = $('#role-id').val();
        let formData = new FormData(this);
        let url = roleId ? `/admin/roles/${roleId}` : '/admin/roles';
        let method = roleId ? 'PUT' : 'POST';
        
        if (method === 'PUT') {
            formData.append('_method', 'PUT');
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    Swal.fire('สำเร็จ!', response.message, 'success');
                    location.reload();
                } else {
                    Swal.fire('เกิดข้อผิดพลาด!', response.message, 'error');
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = 'เกิดข้อผิดพลาด!';
                if (errors) {
                    errorMessage = Object.values(errors).flat().join('\n');
                }
                Swal.fire('เกิดข้อผิดพลาด!', errorMessage, 'error');
            }
        });
    });
    
    // Edit role button
    $('.edit-role-btn').on('click', function() {
        let roleId = $(this).data('role-id');
        let roleName = $(this).data('role-name');
        let permissions = JSON.parse($(this).data('permissions'));
        
        $('#form-title').text('แก้ไข Role');
        $('#role-id').val(roleId);
        $('#role-name').val(roleName);
        $('#submit-btn').html('<i class="fas fa-save"></i> อัพเดท Role');
        $('#cancel-btn').show();
        
        // Clear all checkboxes first
        $('.permission-checkbox').prop('checked', false);
        
        // Check permissions that this role has
        permissions.forEach(function(permission) {
            $(`.permission-checkbox[value="${permission}"]`).prop('checked', true);
        });
    });
    
    // Cancel edit
    $('#cancel-btn').on('click', function() {
        $('#form-title').text('สร้าง Role ใหม่');
        $('#role-form')[0].reset();
        $('#role-id').val('');
        $('#submit-btn').html('<i class="fas fa-save"></i> สร้าง Role');
        $('#cancel-btn').hide();
        $('.permission-checkbox').prop('checked', false);
    });
    
    // Delete role
    $('.delete-role-btn').on('click', function() {
        let roleId = $(this).data('role-id');
        
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: 'การลบ Role นี้จะไม่สามารถย้อนกลับได้!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                $.ajax({
                    url: `/admin/roles/${roleId}`,
                    method: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('ลบแล้ว!', response.message, 'success');
                            location.reload();
                        } else {
                            Swal.fire('เกิดข้อผิดพลาด!', response.message, 'error');
                        }
                    }
                });
            }
        });
    });
    
    // User role selection
    $('#user-select').on('change', function() {
        let currentRoles = JSON.parse($(this).find(':selected').data('current-roles') || '[]');
        
        // Clear all user role checkboxes
        $('.user-role-checkbox').prop('checked', false);
        
        // Check current roles
        currentRoles.forEach(function(role) {
            $(`.user-role-checkbox[value="${role}"]`).prop('checked', true);
        });
    });
    
    // User role form submission
    $('#user-role-form').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            url: '/admin/assign-role',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    Swal.fire('สำเร็จ!', response.message, 'success');
                    location.reload();
                } else {
                    Swal.fire('เกิดข้อผิดพลาด!', response.message, 'error');
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = 'เกิดข้อผิดพลาด!';
                if (errors) {
                    errorMessage = Object.values(errors).flat().join('\n');
                }
                Swal.fire('เกิดข้อผิดพลาด!', errorMessage, 'error');
            }
        });
    });
});
</script>
@endpush
@endsection