@extends('layouts.master')
@section('title')
    User Management - View / Edit User
@endsection
@section('css')
    <!-- jsvectormap css -->
    <link href="{{ URL::asset('build/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Plugins css -->
    <link href="{{ URL::asset('build/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        /*password strength meter */
        .password-strength {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .password-strength-bar {
            flex: 1;
            height: 4px;
            border-radius: 2px;
            background-color: #e9ecef;
            position: relative;
            overflow: hidden;
        }
        .password-strength-bar::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: var(--strength-width, 0%);
            background-color: var(--strength-color, #dc3545);
            transition: width 0.2s ease, background-color 0.2s ease;
        }
        .password-strength-label {
            min-width: 70px;
        }
    </style>
@endsection
@section('page-title')
    User Management
@endsection
@section('body')

<body data-sidebar="colored">
@endsection

@section('content')
<div class="row">
    @php
        $authUser = auth()->user();
        $isAdmin = $authUser && $authUser->role === 'admin';
        $isProfile = $mode === 'profile';
    @endphp
    <div class="col-12">
    <form method="POST"
        enctype="multipart/form-data"
        action="{{ $mode === 'create'
                ? route('users.store')
                : route('users.update', $user) }}">
            @csrf
            @if($mode === 'edit' || $mode === 'profile')
                @method('PUT')
            @endif
        <div class="card">
            {{-- <div class="card-header">
                <h4 class="card-title mb-0">
                    {{ $mode === 'create' ? 'Add New User' : 'View / Edit User' }}
                </h4>
            </div> --}}
            <div class="card-body">
                {{-- <form method="POST"
                    enctype="multipart/form-data"
                    action="{{ $mode === 'create'
                            ? route('users.store')
                            : route('users.update', $user) }}">
                        @csrf
                        @if($mode === 'edit' || $mode === 'profile')
                            @method('PUT')
                        @endif --}}

                    {{--personal details --}}
                    <div class="row">
                        <strong style="font-style: italic;" class="text-primary mb-2">Personal Details</strong>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">First Name (Real)</label>
                            <input type="text" name="first_name"
                                   value="{{ old('first_name', $user->first_name) }}"
                                   class="form-control @error('first_name') is-invalid @enderror"
                                   >
                            @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Last Name (Real)</label>
                            <input type="text" name="last_name"
                                   value="{{ old('last_name', $user->last_name) }}"
                                   class="form-control @error('last_last') is-invalid @enderror">
                            @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone"
                                    placeholder="(999) 999-9999"
                                   value="{{ old('phone', $user->phone) }}"
                                   class="form-control @error('phone') is-invalid @enderror">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob"
                                   value="{{ old('dob', optional($user->dob)->format('Y-m-d')) }}"
                                   class="form-control @error('dob') is-invalid @enderror">
                            @error('dob')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                {{-- </form> --}}
            </div>
        </div>

        {{-- login details --}}
        <div class="card">
            <div class="card-body">
                    <div class="row">
                        <strong style="font-style: italic;" class="text-primary mb-2">Login Details</strong>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username"
                                   value="{{ old('username', $user->username) }}"
                                   class="form-control @error('username') is-invalid @enderror">
                            @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3 mb-3 password-field">
                            <label class="form-label">Password @if($mode === 'edit')<small>(leave blank to keep)</small>@endif</label>
                            <div class="position-relative">
                                <input type="password" name="password"
                                       class="form-control password-input @error('password') is-invalid @enderror">
                                <button type="button"
                                        class="btn btn-link text-muted position-absolute end-0 top-50 translate-middle-y password-toggle p-0"
                                        tabindex="-1">
                                    <i class="ri-eye-off-line m-2"></i>
                                </button>
                            </div>
                            @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            <div class="mt-1 password-strength">
                                <div class="password-strength-bar"></div>
                                <small class="password-strength-label">Type a password</small>
                            </div>
                            <small>Password must be at least 8 characters long and include letters, numbers, and symbols.</small>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status"
                                    class="form-select @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status', $user->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $user->status ?? 'active') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
            </div>
        </div>

        {{-- offical details --}}
        <div class="card">
            <div class="card-body">
                <div class="row">
                        
                        <strong style="font-style: italic;" class="text-primary mb-2">Official Details</strong>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Display Name</label>
                            <input type="text" name="name"
                                   value="{{ old('name', $user->name) }}"
                                   class="form-control @error('name') is-invalid @enderror">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Employee ID</label>
                            <input type="text" name="employee_id"
                                   value="{{ old('employee_id', $user->employee_id) }}"
                                   class="form-control @error('employee_id') is-invalid @enderror">
                            @error('employee_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Pseudo First Name</label>
                            <input type="text" name="pseudo_first_name"
                                   value="{{ old('pseudo_first_name', $user->pseudo_first_name) }}"
                                   class="form-control @error('pseudo_first_name') is-invalid @enderror">
                            @error('pseudo_first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Pseudo Last Name</label>
                            <input type="text" name="pseudo_last_name"
                                   value="{{ old('pseudo_last_name', $user->pseudo_last_name) }}"
                                   class="form-control @error('pseudo_last_name') is-invalid @enderror">
                            @error('pseudo_last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Official Email</label>
                            <input type="email" name="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Role</label>
                            <select name="role"
                                    class="form-select @error('role') is-invalid @enderror">
                                @foreach(['admin','manager','collector','biller'] as $role)
                                    <option value="{{ $role }}"
                                        {{ old('role', $user->role ?? 'biller') === $role ? 'selected' : '' }}>
                                        {{ ucfirst($role) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Designation</label>
                            <input type="text" name="designation"
                                   value="{{ old('designation', $user->designation) }}"
                                   class="form-control @error('designation') is-invalid @enderror">
                            @error('designation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
            </div>
        </div>

        {{-- signature and profile picture upload --}}
        <div class="card">
            <div class="card-body">                
                    <div class="row">
                        <strong style="font-style: italic;" class="text-primary mb-2">Other Info</strong>

                        {{-- <div class="col-md-4 mb-3">
                            <label class="form-label">Profile Picture (PNG, JPEG)</label>
                            @if($user->profile_picture_path)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$user->profile_picture_path) }}"
                                        alt="Profile picture" class="img-thumbnail" style="max-height: 80px;">
                                </div>
                            @endif
                            <input type="file" name="profile_picture"
                                accept="image/png,image/jpeg"
                                class="form-control @error('profile_picture') is-invalid @enderror">
                            @error('profile_picture')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div> --}}

                        <div class="col-md-4 mb-3 d-flex align-items-center gap-3">
                            <div class="position-relative d-inline-block">
                                @php
                                    $profileSrc = $user->profile_picture_path
                                        ? asset('storage/'.$user->profile_picture_path)
                                        : URL::asset('build/images/users/avatar-2.jpg');
                                @endphp
                                <label class="form-label">Profile Picture (PNG, JPEG)</label>
                                <img id="profile_preview" src="{{ $profileSrc }}" alt="Profile picture"
                                     class="img-thumbnail rounded-circle"
                                     style="width: 80px; height: 80px; object-fit: cover;">

                                <button type="button"
                                        class="btn btn-sm btn-primary position-absolute d-flex align-items-center justify-content-center"
                                        style="right: -5px; bottom: -5px; border-radius: 50%; width: 24px; height: 24px; padding: 0;"
                                        onclick="document.getElementById('profile_picture_input').click();">
                                    <i class="ri-edit-2-fill" style="font-size: 14px;"></i>
                                </button>
                            </div>
                            <input id="profile_picture_input" type="file" name="profile_picture"
                                   accept="image/png,image/jpeg"
                                   class="d-none @error('profile_picture') is-invalid @enderror">
                            @error('profile_picture')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        {{-- <div class="col-md-4 mb-3">
                            <label class="form-label">Signature (PNG, JPEG)</label>
                            @if($user->signature_path)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$user->signature_path) }}"
                                        alt="Signature" class="img-thumbnail" style="max-height: 80px;">
                                </div>
                            @endif
                            <input type="file" name="signature"
                                accept="image/png,image/jpeg"
                                class="form-control @error('signature') is-invalid @enderror">
                            @error('signature')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div> --}}

                        {{-- signature upload --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label d-block">Signature (PNG, JPEG)</label>
                            <div class="position-relative d-inline-block">
                                @if($user->signature_path)
                                    <img id="signature_preview" src="{{ asset('storage/'.$user->signature_path) }}"
                                        alt="Signature" class="img-thumbnail"
                                        style="width: 160px; height: 80px; object-fit: contain;">
                                @else
                                    <img id="signature_preview" src="" alt="Signature"
                                        class="img-thumbnail d-none"
                                        style="width: 160px; height: 80px; object-fit: contain;">
                                @endif
                                <button type="button"
                                        class="btn btn-sm btn-primary position-absolute d-flex align-items-center justify-content-center"
                                        style="right: -5px; bottom: -5px; border-radius: 50%; width: 24px; height: 24px; padding: 0;"
                                        onclick="document.getElementById('signature_input').click();">
                                    <i class="ri-edit-2-fill" style="font-size: 14px;"></i>
                                </button>
                            </div>

                            <input id="signature_input" type="file" name="signature"
                                   accept="image/png,image/jpeg"
                                   class="d-none @error('signature') is-invalid @enderror">
                            @error('signature')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>                        
                    </div>
            </div>
        </div>

        <div class="m-3">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to list</a>
            <button type="submit" class="btn btn-primary">
                {{ $mode === 'create' ? 'Create User' : 'Save Changes' }}
            </button>
        </div>
    </form>
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
    <script>
        // password strength meter
        document.addEventListener('DOMContentLoaded', function () {
            const fields = document.querySelectorAll('.password-field');

            fields.forEach(function (field) {
                const input = field.querySelector('.password-input');
                const toggle = field.querySelector('.password-toggle');
                const bar = field.querySelector('.password-strength-bar');
                const label = field.querySelector('.password-strength-label');

                if (!input) return;

                if (toggle) {
                    toggle.addEventListener('click', function () {
                        const isPassword = input.type === 'password';
                        input.type = isPassword ? 'text' : 'password';

                        const icon = toggle.querySelector('i');
                        if (icon) {
                            icon.classList.toggle('ri-eye-off-line', !isPassword);
                            icon.classList.toggle('ri-eye-line', isPassword);
                        }
                    });
                }

                input.addEventListener('input', function () {
                    const val = input.value || '';
                    const score = calculatePasswordScore(val);

                    let width = '0%';
                    let color = '#dc3545';
                    let text = 'Too weak';

                    if (!val.length) {
                        width = '0%';
                        text = 'Type a password';
                    } else if (score <= 1) {
                        width = '25%';
                        color = '#dc3545';
                        text = 'Too weak';
                    } else if (score === 2) {
                        width = '50%';
                        color = '#fd7e14';
                        text = 'Weak';
                    } else if (score === 3) {
                        width = '75%';
                        color = '#ffc107';
                        text = 'Medium';
                    } else if (score >= 4) {
                        width = '100%';
                        color = '#198754';
                        text = 'Strong';
                    }

                    if (bar) {
                        bar.style.setProperty('--strength-width', width);
                        bar.style.setProperty('--strength-color', color);
                    }
                    if (label) {
                        label.textContent = text;
                    }
                });
            });

            function calculatePasswordScore(password) {
                let score = 0;
                if (password.length >= 8) score++;
                if (/[A-Z]/.test(password)) score++;
                if (/[a-z]/.test(password)) score++;
                if (/\d/.test(password)) score++;
                if (/[^A-Za-z0-9]/.test(password)) score++;
                return score;
            }
        });
    </script>
    <script>
        // profile picture and signature preview
        document.addEventListener('DOMContentLoaded', function () {
            function attachImagePreview(inputId, imgId) {
                const input = document.getElementById(inputId);
                const img   = document.getElementById(imgId);

                if (!input || !img) return;

                input.addEventListener('change', function () {
                    const file = this.files && this.files[0];
                    if (!file) return;

                    const url = URL.createObjectURL(file);
                    img.src = url;
                    img.classList.remove('d-none');
                });
            }

            attachImagePreview('profile_picture_input', 'profile_preview');
            attachImagePreview('signature_input', 'signature_preview');
        });
    </script>
@endsection
