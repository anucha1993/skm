@extends('layouts.template')

@section('content')
<div class="col-md-12">


<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Add New Role
                </div>
                <div class="float-end">
                    <a href="{{ route('roles.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('roles.store') }}" method="post">
                    @csrf

                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    

                    
                    <div class="mb-3 row">
                        <label for="permissions" class="col-md-4 col-form-label text-md-end text-start"></label>
                        <div class="col-md-6">
                            <div class="form-group">
                                @forelse ($permissions as $groupName => $groupPermissions)
                                    <div class="mb-2">
                                        <h5>{{ $groupName }}</h5>
                                        <div class="d-flex flex-wrap">
                                            @forelse ($groupPermissions as $permission)
                                                <div class="form-check me-4" style="width: 45%;">
                                                    <input class="form-check-input @error('permissions') is-invalid @enderror"
                                                           type="checkbox"
                                                           value="{{ $permission->id }}"
                                                           id="permission_{{ $permission->id }}"
                                                           name="permissions[]">
                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                        {{ $permission->action_name.'-'.$permission->name_view }}
                                                    </label>
                                                </div>
                                            @empty
                                                <p>No permissions in this group.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                @empty
                                    <p>No permissions available.</p>
                                @endforelse
                            </div>
                            @if ($errors->has('permissions'))
                                <span class="text-danger">{{ $errors->first('permissions') }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- <div class="mb-3 row">
                        <label for="permissions" class="col-md-4 col-form-label text-md-end text-start">Permissions</label>
                        <div class="col-md-6">
                            <div class="form-group">
                                @forelse ($permissions as $permission)
                                    <div class="form-check">
                                        <input class="form-check-input @error('permissions') is-invalid @enderror"
                                               type="checkbox"
                                               value="{{ $permission->id }}"
                                               id="permission_{{ $permission->id }}"
                                               name="permissions[]"
                                               {{ in_array($permission->id, $rolePermissions ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @empty
                                    <p>No permissions available.</p>
                                @endforelse
                            </div>
                            @if ($errors->has('permissions'))
                                <span class="text-danger">{{ $errors->first('permissions') }}</span>
                            @endif
                        </div>
                    </div> --}}
                    
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Role">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>    
</div>
</div>
    
@endsection