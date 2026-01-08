<!-- JAVASCRIPT -->
<script src="{{ URL::asset('build/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/node-waves/waves.min.js') }}"></script>
<!-- Icon -->
<script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>
<!-- Sweet Alerts js -->
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script>
    @if (session('success'))
        Swal.fire({
            title: 'Success',
            text: @json(session('success')),
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif

    @if (session('error'))
        Swal.fire({
            title: 'Error',
            text: @json(session('error')),
            icon: 'error',
            confirmButtonText: 'OK'
        });
    @endif
</script>

{{-- autologut script --}}
<script src="{{ URL::asset('build/libs/@curiosityx/bootstrap-session-timeout/index.js') }}"></script>

{{-- autologut script controls --}}
@auth
<script>
    $(function () {
        $.sessionTimeout({
            keepAliveUrl: '{{ url('/') }}',                 // or any cheap URL
            logoutButton: 'Logout',
            logoutUrl: '{{ route('auto.logout') }}',        // the route you added above
            redirUrl: '{{ route('auto.logout') }}',               // where to land after timeout
            warnAfter: 10 * 1000,                           // show dialog after 25s idle
            redirAfter: 20 * 1000,                          // actually log out at 30s
            countdownMessage: 'Redirecting in {timer} seconds.'
        });
    });
</script>
@endauth



 <script src="{{ URL::asset('build/js/app.js') }}"></script>       
@yield('scripts')