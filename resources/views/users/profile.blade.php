@extends('layouts.master')

@section('title', 'My Profile')

@section('css')
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

@section('body')
<body data-sidebar="colored">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">My Profile</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row align-items-center">
                        {{-- Profile picture + basic info --}}
                        <div class="col-md-4 mb-3 d-flex align-items-center gap-3">
                            <div class="position-relative d-inline-block">
                                @php
                                    $profileSrc = $user->profile_picture_path
                                        ? asset('storage/'.$user->profile_picture_path)
                                        : URL::asset('build/images/users/avatar-2.jpg');
                                @endphp
                                <img src="{{ $profileSrc }}" alt="Profile picture"
                                     class="img-thumbnail rounded-circle"
                                     style="width: 80px; height: 80px; object-fit: cover;">

                                <button type="button"
                                        class="btn btn-sm btn-primary position-absolute d-flex align-items-center justify-content-center"
                                        style="right: -5px; bottom: -5px; border-radius: 50%; width: 24px; height: 24px; padding: 0;"
                                        onclick="document.getElementById('profile_picture_input').click();">
                                    <i class="ri-edit-2-fill" style="font-size: 14px;"></i>
                                </button>
                            </div>
                            <div class="min-w-0">
                                <h5 class="mb-1 text-truncate">{{ $user->name }}</h5>
                                <p class="mb-0 text-muted text-truncate">{{ $user->email }}</p>
                                <p class="mb-0 text-muted">Username: {{ $user->username }}</p>
                                <p class="mb-0 text-muted">Role: {{ ucfirst($user->role) }}</p>
                            </div>

                            <input id="profile_picture_input" type="file" name="profile_picture"
                                   accept="image/png,image/jpeg"
                                   class="d-none @error('profile_picture') is-invalid @enderror">
                            @error('profile_picture')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        {{-- Signature --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label d-block">Signature (PNG, JPEG)</label>
                            <div class="position-relative d-inline-block">
                                @if($user->signature_path)
                                    <img src="{{ asset('storage/'.$user->signature_path) }}"
                                         alt="Signature" class="img-thumbnail"
                                         style="width: 160px; height: 80px; object-fit: contain;">
                                @else
                                    <div class="img-thumbnail d-flex align-items-center justify-content-center"
                                         style="width: 160px; height: 80px;">
                                        <span class="text-muted">No signature</span>
                                    </div>
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

                        {{-- Password --}}
                        <div class="col-md-4 mb-3 password-field" style="width: 20%">
                            <label class="form-label" for="password-input">Change Password</label>
                            <div class="position-relative">
                                <input type="password"
                                    class="form-control password-input @error('password') is-invalid @enderror"
                                    id="password-input"
                                    name="password"
                                    placeholder="Enter New password">
                                <button type="button"
                                        class="btn btn-link text-muted position-absolute end-0 top-50 translate-middle-y password-toggle p-0"
                                        tabindex="-1">
                                    <i class="ri-eye-off-line m-3"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                            <div class="mt-1 password-strength">
                                <div class="password-strength-bar"></div>
                                <small class="password-strength-label">Type a password</small>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="table-responsive mb-3">
                        <table class="table table-sm table-striped mb-0 w-50">
                            <tbody>
                                <tr>
                                    <th style="">First Name</th>
                                    <td>{{ $user->first_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Last Name</th>
                                    <td>{{ $user->last_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Display Name</th>
                                    <td>{{ $user->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Pseudo First Name</th>
                                    <td>{{ $user->pseudo_first_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Pseudo Last Name</th>
                                    <td>{{ $user->pseudo_last_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Official Email</th>
                                    <td>{{ $user->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td>{{ $user->username ?? '-' }}</td>
                                </tr>
                                {{-- <tr>
                                    <th>Status</th>
                                    <td>{{ ucfirst($user->status) }}</td>
                                </tr> --}}
                                <tr>
                                    <th>Designation</th>
                                    <td>{{ $user->designation ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Employee ID</th>
                                    <td>{{ $user->employee_id ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Date of Birth</th>
                                    <td>{{ optional($user->dob)->format('Y-m-d') ?? '-' }}</td>
                                </tr>
                                {{-- <tr>
                                    <th>Last Login</th>
                                    <td>{{ optional($user->last_login_at)->format('Y-m-d H:i') ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ optional($user->created_at)->format('Y-m-d H:i') ?? '-' }}</td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Save Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
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
@endsection