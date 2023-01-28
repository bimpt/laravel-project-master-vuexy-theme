@extends('layouts/layoutMaster')

@section('title', 'Login Basic - Pages')

@section('content')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <div class="card">
                <div class="card-body p-4">
                    <div class="app-brand justify-content-center mb-4 mt-2">
                        <a href="{{url('/')}}" class="app-brand-link d-flex flex-column gap-2">
                            <span class="app-brand-logo demo">@include('_partials.macros', ["height"=>20, "withbg"=> 'fill: #fff;'])</span>
                            <span class="app-brand-text demo text-body fw-bold mt-1 mx-3">{{config('variables.templateName')}}</span>
                        </a>
                    </div>
                    
                    <h5 class="mb-1 pt-2">Selemat datang! 👋</h5>
                    <p class="mb-4"><small>Silahkan masukan username dan password Anda.</small></p>

                    <form action="{{ route('login') }}" id="login-form" method="post" class="auth-login-form mt-2">
                        @csrf

                        <div class="form-group mb-3" data-field="username">
                            <label for="username" class="form-label">E-Mail atau Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Masukan email atau username Anda" autofocus>
                        </div>

                        <div class="form-group mb-3" data-field="password">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" name="remember" type="checkbox" id="remember">
                                <label class="form-check-label" for="remember-me">
                                    <small>Selalu diingat</small>
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary d-flex">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('vendor-style')
<!-- Vendor -->
<link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
@endsection

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/pages-auth.js')}}"></script>
<script type="text/javascript">
    $(function() {
        new AjaxFormSubmitter({
            form: '#login-form',
            scrollToError: false,
            success: function(response) {
                if (response.success) {
                    localStorage.setItem('token', response.token);
                    window.location.href = response.redirectTo;
                }
            },
            error: function(xhr) { }
        })
    });
</script>
@endsection
