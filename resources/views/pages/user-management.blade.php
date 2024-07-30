@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
    @if(session()->has('success') || session()->has('error'))
        <div id="alert">
            @include('components.alert')
        </div>
    @endif
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Users</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Username</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"> Email</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <div class="mb-0 text-sm">
                                                    {{ $user->username }}
                                                    @if($user->role == 'user' && $user->notifications->where('type', 'Send Request')->isNotEmpty())
                                                        <span class="badge badge-sm bg-gradient-success text-white">Request</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-sm font-weight-bold mb-0">
                                        {{ $user->email }}
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <div class="text-sm font-weight-bold mb-0">
                                        @php
                                            $role = $user->role ?? 'Role';
                                            switch ($role) {
                                                case 'user':
                                                    $roleName = 'User';
                                                    break;
                                                case 'admin':
                                                    $roleName = 'Admin';
                                                    break;
                                                case 'super_admin':
                                                    $roleName = 'Expert';
                                                    break;
                                                default:
                                                    $roleName = $role;
                                            }
                                        @endphp
                                        {{ $roleName }}
                                        </div>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                            <a class="btn btn-link text-sm text-dark font-weight-bold mb-0 px-3" href="{{ route('users.edit', $user->id) }}">
                                                <i class="fas fa-pencil-alt text-dark me-2"></i>Edit</a>
                                            <form id="deleteForm{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-link text-sm font-weight-bold mb-0 ps-2" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                                                    <i class="fas fa-trash me-2"></i>Delete</button>
                                            </form>
                                            <!-- Modal -->
                                            <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                    <div class="modal-header border-0">
                                                        <button type="button" class="btn-close modal1" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body pt-0">
                                                        <h5 class="modal-title d-flex justify-content-sm-center text-bolder mb-2 fs-4" id="deleteModalLabel{{ $user->id }}">Confirm Delete</h5>
                                                        <p class="d-flex justify-content-sm-center mb-0">Are you sure you want to delete this user?</p>
                                                        <p class="d-flex justify-content-sm-center mb-0">This action cannot be undone.</p>
                                                    </div>
                                                    <div class="modal-footer d-flex justify-content-sm-center border-0">
                                                        <button type="button" class="btn btn-secondary px-6" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-danger px-6" id="confirmDelete{{ $user->id }}">Delete</button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>

<!-- modal pop up -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach($users as $user)
            document.getElementById('confirmDelete{{ $user->id }}').addEventListener('click', function () {
                document.getElementById('deleteForm{{ $user->id }}').submit();
            });
        @endforeach
    });
</script>
@endsection
