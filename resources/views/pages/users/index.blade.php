@extends('layouts.main')
@section('title', 'User')
@section('description', 'User Management')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1 class="card-title mb-0">User Management</h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        +
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>
                                            <span
                                                class="badge 
    @if ($user->role == 'admin') bg-primary
    @elseif($user->role == 'staf')
        bg-success
    @elseif($user->role == 'pimpinan')
        bg-danger
    @else
        bg-secondary @endif
">
                                                {{ ucfirst($user->role) }}
                                            </span>

                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editUserModal-{{ $user->id }}">
                                                Edit
                                            </button>


                                            <button type="button" class="btn btn-sm btn-danger btn-delete"
                                                data-url="{{ route('users.destroy', $user->id) }}"
                                                data-name="{{ $user->name }}">
                                                Delete
                                            </button>

                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No data</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- ================= EDIT MODAL ================= --}}
    @foreach ($users as $user)
        <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('users.update', $user->id) }}" method="POST" class="modal-content">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <x-form-input label="Name" name="name" :value="$user->name" required />
                        <x-form-input label="Email" name="email" type="email" :value="$user->email" required />
                        <x-form-input label="Nomor Telephone" name="phone" type="number" :value="$user->phone" />

                        <div class="mb-3">
                            <label>Role</label>
                            <select name="role" class="form-control" required>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="staf" {{ $user->role == 'staf' ? 'selected' : '' }}>Staff</option>
                                <option value="pimpinan" {{ $user->role == 'pimpinan' ? 'selected' : '' }}>Pimpinan
                                </option>
                            </select>
                        </div>

                        <x-form-input label="Password (optional)" name="password" type="password" />
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach


    {{-- ================= ADD MODAL ================= --}}
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('users.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <x-form-input label="Name" name="name" required />
                    <<x-form-input label="Email" type="email" name="email" required />
                    <<x-form-input label="Nomor Telephone" type="number" name="phone"/>
                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="">-- Select Role --</option>
                            <option value="admin">Admin</option>
                            <option value="staf">Staff</option>
                            <option value="pimpinan">Pimpinan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <x-form-input label="Password" type="password" name="password" required />
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
