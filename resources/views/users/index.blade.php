@extends('layouts.master')
@section('title')
    User Management
@endsection
@section('css')
    <!-- jsvectormap css -->
    <link href="{{ URL::asset('build/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-title')
    User Management
@endsection
@section('body')

<body data-sidebar="colored">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{--
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Users</h4>
                <a href="{{ route('users.create') }}" class="btn btn-primary">Add New User</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at?->format('Y-m-d') }}</td>
                                <td class="text-end">
                                    <!-- actions moved to second table -->
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No users found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
        --}}

        <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-inline float-md-start mb-3">
                                    <div class="search-box me-2">
                                        <div class="position-relative">
                                            <input type="text" class="form-control border" placeholder="Search...">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 float-end">
                                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                                        <i class="mdi mdi-plus me-1"></i> Add User
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="table-responsive mb-4">
                            <table class="table table-hover table-nowrap align-middle mb-0 text-start">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" style="width: 200px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                    <tr>
                                        <td>
                                            @php
                                                $avatarSrc = $user->profile_picture_path
                                                    ? asset('storage/'.$user->profile_picture_path)
                                                    : URL::asset('build/images/users/avatar-4.jpg');
                                            @endphp
                                            <img src="{{ $avatarSrc }}" alt="Avatar"
                                                class="avatar-xs rounded-circle me-2">
                                            {{ trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: $user->name }}
                                        </td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ ucfirst($user->role) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item dropdown">
                                                    <a class="dropdown-toggle font-size-18 px-2" href="#" role="button"
                                                    data-bs-toggle="dropdown" aria-haspopup="true">
                                                        <i class="ri-more-2-fill"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="{{ route('users.edit', $user) }}">
                                                            <i class="ri-pencil-line me-1 align-middle"></i> Edit
                                                        </a>
                                                        <form action="{{ route('users.destroy', $user) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="ri-delete-bin-line me-1 align-middle"></i> Trash
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('users.force-logout', $user) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Force logout this user?');">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="ri-logout-box-line me-1 align-middle"></i> Force logout
                                                            </button>
                                                        </form>
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No users found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-6">
                                <div>
                                    @if($users->count())
                                        <p class="mb-sm-0">
                                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                                        </p>
                                    @else
                                        <p class="mb-sm-0">Showing 0 to 0 of 0 entries</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="float-sm-end">
                                    {{ $users->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
</div>
@endsection
@section('scripts')
        <!-- apexcharts -->
        <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>

        <!-- Vector map-->
        <script src="{{ URL::asset('build/libs/jsvectormap/jsvectormap.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/jsvectormap/maps/world-merc.js') }}"></script>

        <script src="{{ URL::asset('build/js/pages/dashboard.init.js') }}"></script>
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
