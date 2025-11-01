<x-front-layout title="Two Factor Auth">

    <!-- Start Account Login Area -->
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" action="{{route("two-factor.enable")}}" method="post">
                        @csrf
                        <div class="title">
                            <h3>Two Factor Auth</h3>
                            <p>You can enable/disable 2FA</p>
                        </div>
                        @if(session('status') == 'two-factor-authentication-enabled')
                            <div class="mb-4 font-medium text-sm">
                                please finish 2FA auth
                            </div>
                        @endif

                        <div class="button">
                            @if(! $user->two_factor_secret)
                                <button class="btn" type="submit">Enable</button>
                            @else
                                {!! $user->twoFactorQrCodeSvg() !!}
                            <h3>recovery code</h3>
                                <ul class="mb-3">
                                    @foreach($user->recoveryCodes() as $code)
                                        <li>{{$code}}</li>
                                    @endforeach
                                </ul>
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Disable</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Login Area -->

</x-front-layout>
