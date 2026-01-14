@extends('layouts.master-without-nav')
@section('title')
    Login
@endsection
@section('content')
    <div class="auth-maintenance d-flex align-items-center min-vh-100">
        <div class="bg-overlay bg-light"></div>
        <div class="container">
            <div class="row justify-content-center 3">
                <div class="col-md-10">
                    <div class="auth-full-page-content d-flex min-vh-100 py-sm-5 py-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100 py-0 py-xl-3">
                                <div class="text-center mb-4">
                                    {{-- <a href="index" class="">
                                        <img src="{{ URL::asset('build/images/monogram.png') }}" alt=""
                                            height="22" class="auth-logo logo-dark mx-auto">
                                        <img src="{{ URL::asset('build/images/monogram.png') }}" alt=""
                                            height="22" class="auth-logo logo-light mx-auto">
                                    </a> --}}
                                    <p class="text-muted mt-2">You care for your patients; We care for your business</p>
                                </div>

                                <div style="border-radius: 25px;" class="card my-auto overflow-hidden">
                                    <div class="row g-0">
                                        <div class="col-lg-6">
                                            <div class="bg-overlay bg-primary"></div>
                                            <div class="h-100 bg-auth align-items-end">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 login-watermark">
                                            <div class="p-lg-5 p-4">
                                                <div>
                                                    <div class="text-center mt-1">
                                                        <img src="{{ URL::asset('build/images/loginpagelogo.png') }}" alt="" style="width: 50%; padding-bottom: 40px">
                                                        <h1 class="font-size-30" style="padding-bottom: 10px">Sign In</h1>
                                                        <p class="text-muted">Sign in to continue to DMS Billing.</p>
                                                    </div>

                                                    <form method="POST" action="{{ route('login') }}" class="auth-input" style="padding-left:60px; padding-right:60px;">
                                                        @csrf
                                                       <div class="form-group">
                                                            {{-- <label for="login">Email or Username</label> --}}
                                                            <input id="login" type="text"
                                                                placeholder="Email or Username"
                                                                style="border-radius: 25px;"
                                                                class="form-control @error('login') is-invalid @enderror"
                                                                name="login" value="{{ old('login') }}" required autofocus>

                                                            @error('login')
                                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                            @enderror
                                                        </div>
                                                        {{-- <div class="mb-3">
                                                            <label class="form-label" for="password-input">Password</label>
                                                            <input type="password"
                                                                class="form-control @error('password') is-invalid @enderror"
                                                                placeholder="Enter password" id="password-input"
                                                                name="password" required autocomplete="current-password"
                                                                value="12345678">
                                                            @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div> --}}
                                                        <div class="password-field" >
                                                            <label style="background: transparent;" class="form-label" for="password-input">Password</label>
                                                            <div class="position-relative">
                                                                <input type="password"
                                                                    style="border-radius: 25px; background: transparent;"
                                                                    class="form-control password-input @error('password') is-invalid @enderror"
                                                                    id="password-input"
                                                                    name="password"
                                                                    placeholder="Enter Password">
                                                                <button type="button"
                                                                        class="btn btn-link text-muted position-absolute end-0 top-50 translate-middle-y password-toggle p-0"
                                                                        tabindex="-1">
                                                                    <i class="ri-eye-off-line m-3"></i>
                                                                </button>
                                                            </div>
                                                            @error('password')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror

                                                            {{-- <div class="mt-1 password-strength">
                                                                <div class="password-strength-bar"></div>
                                                                <small class="password-strength-label">Type a password</small>
                                                            </div> --}}
                                                        </div>

                                                        {{-- <div class="form-check d-flex justify-content-between">
                                                            <div>
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="remember" id="remember"
                                                                    {{ old('remember') ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="remember">Remember
                                                                    me</label>
                                                            </div>
                                                            <a href="{{ route('password.update') }}" class="text-end">Forget Password?</a>
                                                        </div> --}}

                                                        <div style="padding-left:10px; padding-right:10px;" class="mt-4 mb-4">
                                                            <button style="border-radius: 25px; background-color:black" class="btn btn-dark w-100" type="submit">Sign
                                                                In</button>
                                                        </div>

                                                        {{-- <div class="mt-4 pt-2 text-center">
                                                            <div class="signin-other-title">
                                                                <h5 class="font-size-14 mb-4 title">Sign In with</h5>
                                                            </div>
                                                            <div class="pt-2 hstack gap-2 justify-content-center">
                                                                <button type="button" class="btn btn-primary btn-sm"><i
                                                                        class="ri-facebook-fill font-size-16"></i></button>
                                                                <button type="button" class="btn btn-danger btn-sm"><i
                                                                        class="ri-google-fill font-size-16"></i></button>
                                                                <button type="button" class="btn btn-dark btn-sm"><i
                                                                        class="ri-github-fill font-size-16"></i></button>
                                                                <button type="button" class="btn btn-info btn-sm"><i
                                                                        class="ri-twitter-fill font-size-16"></i></button>
                                                            </div>
                                                        </div> --}}
                                                    </form>
                                                </div>

                                                {{-- <div class="mt-4 text-center">
                                                    <p class="mb-0">Don't have an account ? <a
                                                            href="{{ route('register') }}" class="fw-medium text-primary">
                                                            Register </a> </p>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->

                                <div class="mt-5 text-center">
                                    <p class="mb-0">©
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> Doctor Management Services. Crafted with <i
                                            class="mdi mdi-heart text-danger"></i> by DMS IT Team
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>
@endsection
@section('scripts')
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
        <script>
            // password strength meter/ password show hide functionality
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
