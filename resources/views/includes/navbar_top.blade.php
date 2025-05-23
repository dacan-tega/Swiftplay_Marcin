<nav class="page__content__navbar">
    <aside class="page__content__navbar__esq">
        <div class="">
            <a class="page__navbar__logo" href="{{ url('/') }}">
                <img src="/assets/images/images-fix/license-1 copy.png" alt="" style="width:100%; height: 55px">
            </a>

            <button class="navbar-toggler-close close-button" type="button">
                <img src="{{ asset('/assets/images/svg/menu-nav.svg') }}" alt="" width="28">
            </button>
        </div>

        @if(!empty(config('setting')['instagram']))
            <a href="{{ config('setting')['instagram'] }}" target="_blank" class="social-icon" title="Instagram">
                <img src="{{ asset('assets/images/instagram.png') }}" alt="" width="32">
            </a>
        @endif

        @if(!empty(config('setting')['tiktok']))
            <a href="{{ config('setting')['tiktok'] }}" target="_blank" class="social-icon" title="Tiktok">
                <img src="{{ asset('assets/images/tiktok.png') }}" alt=""  width="32">
            </a>
        @endif

        @if(!empty(config('setting')['whatsapp']))
            <a href="{{ config('setting')['whatsapp'] }}" target="_blank" class="social-icon" title="Canal Whatsapp">
                <img src="{{ asset('assets/images/whatsapp.png') }}" alt="" width="32">
            </a>
        @endif
    </aside>
    <aside class="page__content__navbar__dir">

        @if(auth()->check())
            <a class="page__content__navbar__dir__saldo" href="{{ route('panel.wallet.index') }}">
                <h6>{{trans('includes.Your_balance')}} </h6>
                <div>
                    <i class="fas fa-plus"></i>
                    <span>{{ \Helper::getBalance() }}</span>
                </div>
            </a>

            @if(auth()->user()->notifications()->count() > 0)
                <a class="page__content__navbar__dir__notificacao" href="{{ route('panel.notifications.index') }}">
                    <i class="fas fa-bell"></i>
                </a>
            @endif

            @if(!in_array(request()->route()->getName(), ['panel.wallet.deposits', 'panel.wallet.index', 'panel.wallet.withdrawals']))
                <a data-izimodal-open="#deposit-modal" data-izimodal-zindex="20000" data-izimodal-preventclose="" href="" class="page__content__navbar__dir__btn">
                    <span>+</span>
                    <strong class="hidden-mobile">{{trans('includes.Deposit')}}</strong>
                </a>
            @endif

            <div class="dropdown">
                <button class=" profile-avatar" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-regular fa-user"></i>
                </button>
                <ul class="dropdown-menu">
                    @if(in_array(auth()->user()->role_id, [0,1]))
                        <li><a class="dropdown-item" href="{{ url('/admin/login') }}"><i class="fa-light fa-screwdriver-wrench menu-dropdown"></i> <span class="m-lg-2">{{trans('includes.Admin')}}</span></a></li>
                    @endif
                    <li><a class="dropdown-item" href="{{ route('panel.profile.index') }}"><i class="fa-solid fa-user menu-dropdown"></i> <span class="m-lg-2">{{trans('includes.My_profile')}}</span></a></li>
                    <li><a class="dropdown-item" href="{{ route('panel.wallet.index') }}"><i class="fa-regular fa-wallet menu-dropdown"></i> <span class="m-lg-2">{{trans('includes.Portfolio')}}</span></a></li>
                    <li><a class="dropdown-item" href="{{ route('panel.wallet.deposits') }}"><i class="fa-solid fa-money-bill-transfer menu-dropdown"></i> <span class="m-lg-2">{{trans('includes.Deposit')}}</span></a></li>
                    <li><a class="dropdown-item" href="{{ route('panel.wallet.withdrawals') }}"><i class="fa-regular fa-money-simple-from-bracket menu-dropdown"></i> <span class="m-lg-2">{{trans('includes.take_out')}}</span></a></li>
                    <li><a class="dropdown-item" href="{{ route('panel.affiliates.index') }}"><i class="fa-regular fa-users-viewfinder menu-dropdown"></i> <span class="m-lg-2">{{trans('includes.Affiliate')}}</span></a></li>
                    <li><a class="dropdown-item" href="{{ route('panel.notifications.index') }}"><i class="fas fa-bell  menu-dropdown"></i> <span class="m-lg-2">{{trans('includes.Notifications')}}</span></a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-right-from-bracket menu-dropdown"></i> <span class="m-lg-2">{{trans('includes.To_go_out')}}</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a class="page__content__navbar__dir__btn" href="" data-izimodal-open="#register-modal" data-izimodal-zindex="20000" data-izimodal-preventclose="">
                <strong><i class="fa-duotone fa-arrow-right-to-bracket mr-2"></i> {{trans('includes.Registrar')}}</strong>
            </a>
            <a class="sign-in mr-2" href="" data-izimodal-open="#login-modal" data-izimodal-zindex="20000" data-izimodal-preventclose="">
                <strong>{{trans('includes.To_enter')}}</strong>
            </a>
        @endif
    </aside>

</nav>

@if(!in_array(request()->route()->getName(), ['panel.wallet.deposits', 'panel.wallet.index', 'panel.wallet.withdrawals']))
    @include('includes.deposit')
@endif

<div id="login-modal" class="iziModal" data-izimodal-loop="" data-izimodal-zindex="20000">
    <div class="modal-dialog">
        <div class="modal-content modal-body">
            <div class="row">
                <div class="col-lg-6 banner-login p-0">
                    <img src="{{ asset('assets/images/br_bg.png') }}" alt="" class="img-fluid">
                </div>
                <div class="col-lg-6 relative p-0">
                    <div id="loading" class="loading-spinner">
                        <span class="spinner"></span>
                    </div>

                    <form id="loginForm" method="post" action="" class="form-login">
                        @csrf
                        <h5 class="mb-3 font-bold">{{trans('includes.To_enter')}}</h5>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="email"><i class="fa-regular fa-envelope text-success-emphasis"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="E-mail">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="password"><i class="fa-regular fa-lock text-success-emphasis"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="{{trans('includes.Password')}}">
                        </div>
                        <p>
                            <a href="{{ route('forgotPassword') }}" class="text-white text-small">{{trans('includes.Create_account')}}</a>
                        </p>
                        <div class="d-grid mt-3">
                            <button type="submit" class="btn-primary-theme btn-block w-full mb-3">
                                {{trans('includes.To_enter')}}
                            </button>
                        </div>
                        <p>{{trans('includes.New_to')}} {{ config('setting')->software_name }}? <a href="" onclick="openRegister(event)"><strong>{{trans('includes.Create_account')}}</strong></a></p>
                    </form>

                    <div class="login-wrap">
                        <div class="line-text">
                            <div class="l"></div>
                            <div class="t">{{trans('includes.Log_in')}}</div>
                            <div class="l"></div>
                        </div>

                        <div class="social-group">
                            <a href="{{ url('/auth/redirect/google') }}" class="login-with-google-btn w-full" >
                                {{trans('includes.Login_Google')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="register-modal" class="iziModal" data-izimodal-loop="">
    <div class="modal-dialog">
        <div class="modal-content modal-body">
            <div class="row">
                <div class="col-lg-6 banner-login">
                    <img src="{{ asset('assets/images/br_bg.png') }}" alt="" class="img-fluid">
                </div>
                <div class="col-lg-6 p-0">
                    <div class="relative" style="height: 100%;">
                        <div id="loading_register" class="loading-spinner">
                            <span class="spinner"></span>
                        </div>

                        <form id="registrationForm" action="" method="post" class="form-login">
                            @csrf
                            <h5 class="mb-3 font-bold">{{trans('includes.Register')}}</h5>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="user"><i class="fa-regular fa-user text-success-emphasis"></i></span>
                                <input type="text" name="{{trans('includes.name')}}" class="form-control" placeholder="{{trans('includes.User_name')}}" aria-label="{{trans('includes.User_name')}}" aria-describedby="user" required>
                            </div>
                            {{--                        <div class="input-group mb-3">--}}
                            {{--                            <span class="input-group-text" id="cpf"><i class="fa-light fa-address-card text-success-emphasis"></i></span>--}}
                            {{--                            <input type="text" name="cpf" class="form-control" placeholder="Digite seu CPF">--}}
                            {{--                        </div>--}}
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="email"><i class="fa-regular fa-envelope text-success-emphasis"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="E-mail" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="password"><i class="fa-regular fa-lock text-success-emphasis"></i></span>
                                <input id="passwordField" type="password" name="password" class="form-control" placeholder="{{trans('includes.Password')}}" required>
                                <button type="button" id="togglePassword" class="input-group-text" onclick="togglePasswordField()"><i id="eyeIcon" class="fa-regular fa-eye"></i></button>

                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="password"><i class="fa-regular fa-lock text-success-emphasis"></i></span>
                                <input id="passwordConfirmField" type="password" name="password_confirmation" class="form-control" placeholder="{{trans('includes.Confirm_the_Password')}}" required>
                                <button type="button" id="togglePassword" class="input-group-text" onclick="togglePasswordField()"><i id="eyeIcon" class="fa-regular fa-eye"></i></button>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="password"><i class="fa-brands fa-whatsapp text-success-emphasis"></i></span>
                                <input type="text" name="phone" class="form-control sp_celphones" placeholder="What's app" required>
                            </div>
                            @if(app('request')->input('affiliate'))
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="token"><i class="fa-light fa-user-group-simple text-success-emphasis"></i></span>
                                    <input type="text" name="affiliate_token" readonly class="form-control" placeholder="Token" value="{{ app('request')->input('affiliate') }}" required>
                                </div>
                            @endif
                            <div class="d-grid mt-3">
                                <button type="submit" class="btn-primary-theme btn-block w-full mb-3">
                                    {{trans('includes.Register_re')}}
                                </button>
                                <p class="text-center">
                                    {{trans('includes.clicking')}} <a href="" class="text-success-emphasis">{{trans('includes.terms_use')}}</a> e <a href="" class="text-success-emphasis">{{trans('includes.policy')}}</a> {{trans('includes.of')}} <a href="" class="text-success-emphasis">{{trans('includes.privacy')}} </a>.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
     .page__content__navbar{
        position: -webkit-sticky; /* For Safari */
    position: sticky;
    top: 0;
    width: 100%;
    z-index: 1000; /* Đảm bảo thanh menu luôn ở trên cùng */
    background-color:#0d131c;    
    }
        .sign-in {
    right: 120px;
    margin-left: 100px;
    
}
a.page__navbar__logo {
    margin-left: 30px;
    width: 210px; 
    
}
</style>
@push('scripts')
    <script src="{{ asset('/assets/js/jquery.mask.min.js') }}"></script>
    <script>
             $(document).ready(function() {
        @if (!auth()->check())
            $("#login-modal").iziModal('open');
        @endif
         });
        $("#login-modal").iziModal({
            title: 'LET\'S PLAY?',
            subtitle: 'We are waiting for you for another round!',
            headerColor: '#202327',
            theme: 'dark',  // light
            background:  '#202327',
            width: 700,
            closeOnEscape: false,
            overlayClose: false,
            onFullscreen: function(){},
            onResize: function(){},
            onOpening: function(){},
            onOpened: function(){},
            onClosing: function(){},
            onClosed: function(){},
            afterRender: function(){}
        });

        $("#register-modal").iziModal({
            title: 'REGISTER-RE',
            subtitle: 'We are waiting for you for another round!',
            headerColor: '#202327',
            theme: 'dark',  // light
            background:  '#202327',
            width: 700,
            closeOnEscape: false,
            overlayClose: false,
            onFullscreen: function(){},
            onResize: function(){},
            onOpening: function(){
                var SPMaskBehavior = function (val) {
                        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                    },
                    spOptions = {
                        onKeyPress: function(val, e, field, options) {
                            field.mask(SPMaskBehavior.apply({}, arguments), options);
                        }
                    };

                $('.sp_celphones').mask(SPMaskBehavior, spOptions);
            },
            onOpened: function(){},
            onClosing: function(){},
            onClosed: function() {
                limparCampos();
            },
            afterRender: function(){}
        });

        function limparCampos() {
            const campos = document.querySelectorAll('input'); // Seleciona todos os campos de entrada

            campos.forEach(campo => {
                campo.value = ''; // Limpa o valor de cada campo
            });
        }

        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita o comportamento padrão de envio do formulário

            // Exibe o loading
            const loadingElement = document.getElementById('loading');
            loadingElement.style.display = 'block';

            const formData = new FormData(this);

            fetch('{{ route('login') }}', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if(data.status) {
                        iziToast.show({
                            title: 'Success',
                            message: 'User logged in successfully',
                            theme: 'dark',
                            icon: 'fa-solid fa-check',
                            iconColor: '#ffffff',
                            backgroundColor: '#23ab0e',
                            position: 'topRight',
                            timeout: 500,
                            onClosing: function () {},
                            onClosed: function () {
                                $("#login-modal").iziModal('close');
                                window.location.replace('{{ url('/') }}');
                            }
                        });
                    }else{
                        if(data.error != undefined) {
                            iziToast.show({
                                title: 'Attention',
                                message: data.error,
                                theme: 'dark',
                                icon: 'fa-regular fa-circle-exclamation',
                                iconColor: '#ffffff',
                                backgroundColor: '#b51408',
                                position: 'topRight'
                            });
                        }else{
                            Object.entries(data).forEach(([key, value]) => {
                                iziToast.show({
                                    title: 'Attention',
                                    message: value[0],
                                    theme: 'dark',
                                    icon: 'fa-regular fa-circle-exclamation',
                                    iconColor: '#ffffff',
                                    backgroundColor: '#b51408',
                                    position: 'topRight'
                                });
                            });
                        }

                    }

                    loadingElement.style.display = 'none';
                })
                .catch(error => {


                    console.error('Error sending request:', error);
                    loadingElement.style.display = 'none';
                })
                .finally(() => {

                });
        });

        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita o comportamento padrão de envio do formulário

            // Exibe o loading
            const loadingElement = document.getElementById('loading_register');
            loadingElement.style.display = 'block';

            const formData = new FormData(this);

            fetch('{{ route('register') }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.status) {
                    iziToast.show({
                        timeout: 500,
                        title: 'Success',
                        message: 'User logged in successfully',
                        theme: 'dark',
                        icon: 'fa-solid fa-check',
                        iconColor: '#ffffff',
                        backgroundColor: '#23ab0e',
                        position: 'topRight',
                        onClosing: function () {},
                        onClosed: function () {
                            $("#register-modal").iziModal('close');
                            window.location.replace('{{ url('/') }}');
                        }
                    });
                }else{
                    if(data.error != undefined) {
                        iziToast.show({
                            title: 'Attention',
                            message: data.error,
                            theme: 'dark',
                            icon: 'fa-regular fa-circle-exclamation',
                            iconColor: '#ffffff',
                            backgroundColor: '#b51408',
                            position: 'topRight'
                        });
                    }else{
                        Object.entries(data).forEach(([key, value]) => {
                            iziToast.show({
                                title: 'Attention',
                                message: value[0],
                                theme: 'dark',
                                icon: 'fa-regular fa-circle-exclamation',
                                iconColor: '#ffffff',
                                backgroundColor: '#b51408',
                                position: 'topRight'
                            });
                        });
                    }
                }

                loadingElement.style.display = 'none';
            })
            .catch(error => {


                console.error('Error sending request:', error);
                loadingElement.style.display = 'none';
            });
        });

        function togglePasswordField() {
            const passwordField = document.getElementById('passwordField');
            const passwordConfirmField = document.getElementById('passwordConfirmField');
            const toggleButton = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordConfirmField.type = 'text';
                eyeIcon.className = 'fa-regular fa-eye-slash';
            } else {
                passwordField.type = 'password';
                passwordConfirmField.type = 'password';
                eyeIcon.className = 'fa-regular fa-eye';
            }
        }

        function openRegister(event) {
            event.preventDefault();

            $("#login-modal").iziModal('close');
            $("#register-modal").iziModal('open');
        }
    </script>

    @if(app('request')->input('action') == 'login')
        <script>
            $("#login-modal").iziModal('open');
        </script>
    @endif

    @if(app('request')->input('action') == 'register')
        <script>
            $("#register-modal").iziModal('open');
        </script>
    @endif
@endpush
