<!-- resources/views/global_sets/index.blade.php -->

@extends('layouts.template')

@section('content')
<style>
    /* Fix table header text visibility */
    .table thead th {
        color: #000000 !important;
        font-weight: 600 !important;
        background-color: #f8f9fa !important;
    }
    
    /* Make sure DataTable headers are also dark */
    table.dataTable thead th {
        color: #000000 !important;
        font-weight: 600 !important;
    }
    
    /* Fix any sorting icons visibility */
    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc:after {
        color: #000000 !important;
    }
</style>

<div class="container">
    <h3>Global Sets</h3>

    <!-- ปุ่มกดเรียก Modal เพื่อสร้าง Global Set ใหม่ -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createGlobalSetModal">
        + Create New Global Set
    </button>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-body">



    <!-- ตารางแสดง Global Sets -->
    <table class="table table-striped table-bordered" id="table-gobalset" >
        <thead>
            <tr>
                <th>ID</th>
                <th>Global Set Name</th>
                <th>Sort Order</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($globalSets as $globalSet)
            <tr>
                <td>{{ $globalSet->id }}</td>
                <td>{{ $globalSet->name }}</td>
                <td>{{ $globalSet->sort_order_preference }}</td>
                <td>
                    <!-- ปุ่ม Edit -->
                    @can('edit-customer')
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editGlobalSetModal_{{ $globalSet->id }}">
                        Edit
                    </button>
                    @endcan
                    

                    <!-- ปุ่ม Delete -->
                    @can('edit-customer')
                    <form action="{{ route('global-sets.destroy', $globalSet->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </form>
                    @endcan

                    <!-- Modal สำหรับแก้ไข Global Set -->
                    <div class="modal fade" id="editGlobalSetModal_{{ $globalSet->id }}" tabindex="-1" aria-labelledby="editGlobalSetModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <form action="{{ route('global-sets.update', $globalSet->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editGlobalSetModalLabel">
                                    Edit Global Set: {{ $globalSet->name }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label class="form-label">Global Set Name</label>
                                    <input type="text" class="form-control form-control-sm" name="name"
                                           value="{{ $globalSet->name }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control form-control-sm">{{ $globalSet->description }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Sort order preference</label>
                                    <select name="sort_order_preference" class="form-select">
                                        <option value="entered" {{ $globalSet->sort_order_preference == 'entered' ? 'selected' : '' }}>Entered order</option>
                                        <option value="alphabetical" {{ $globalSet->sort_order_preference == 'alphabetical' ? 'selected' : '' }}>Alphabetical order</option>
                                    </select>
                                </div>

                                <!-- ส่วนเพิ่ม/ลบค่าใน Global Set -->
                                <label class="form-label">Global Set Values</label>
                                <div style="max-height: 200px; overflow-y: auto; border: 1px solid #ccc; padding: 8px;">
                                <div id="value-wrapper-{{ $globalSet->id }}" >
                                    <!-- loop แสดงค่าเดิม -->
                                    @foreach($globalSet->values as $index => $value)
                                    <div class="input-group mb-1">
                                        <input type="hidden" name="values[{{ $index }}][id]" value="{{ $value->id }}">
                                        <input type="text" name="values[{{ $index }}][value]" class="form-control form-control-sm" value="{{ $value->value }}">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="this.parentNode.remove();">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                    @endforeach
                                    
                                
                                </div>
                                </div>
                                <button type="button" class="btn btn-secondary btn-sm mt-1"
                                        onclick="addValueField('{{ $globalSet->id }}')">
                                    + Add Value
                                </button>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!-- End Edit Modal -->
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</div>
</div>

<!-- Modal สำหรับสร้าง Global Set ใหม่ -->
<div class="modal fade" id="createGlobalSetModal" tabindex="-1" aria-labelledby="createGlobalSetModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('global-sets.store') }}" method="POST">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="createGlobalSetModalLabel">Create New Global Set</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <div class="mb-3">
                <label class="form-label">Global Set Name</label>
                <input type="text" class="form-control form-control-sm" name="name" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control form-control-sm"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Sort order preference</label>
                <select name="sort_order_preference" class="form-select">
                    <option value="entered">Entered order</option>
                    <option value="alphabetical">Alphabetical order</option>
                </select>
            </div>

            <!-- ส่วนเพิ่ม/ลบค่าใน Global Set -->
            <label class="form-label">Global Set Values</label>
            <div style="max-height: 200px; overflow-y: auto; border: 1px solid #ccc; padding: 8px;">
            <div id="value-wrapper-create">
                <!-- ช่องว่างเริ่มต้น 1 ช่อง -->
                <div class="input-group mb-2">
                    <input type="text" name="values[]" class="form-control form-control-sm">
                    <button type="button" class="btn btn-danger btn-sm" onclick="this.parentNode.remove();">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
            </div>
            <button type="button" class="btn btn-secondary btn-sm mt-1" onclick="addValueField('create')">
                + Add Value
            </button>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Close
            </button>
            <button type="submit" class="btn btn-primary">
                Save
            </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Script จัดการปุ่ม +Add Value -->
<script>
    $('#table-gobalset').DataTable();
function addValueField(id) {
    
    let wrapper = document.getElementById(`value-wrapper-${id}`);
    // หากเป็นตอน create
    if (!wrapper) {
        wrapper = document.getElementById('value-wrapper-create');
    }

    const div = document.createElement('div');
    div.classList.add('input-group', 'mb-2');

    div.innerHTML = `
        <input type="text" name="values[]" class="form-control form-control-sm">
   <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="this.parentNode.remove();">
                                                <i class="fa fa-trash"></i>
                                            </button>
    `;

    wrapper.appendChild(div);
}
</script>
@endsection
