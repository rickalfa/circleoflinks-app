<x-guest-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        
                        <div class="mb-4 text-muted">
                            {{ __('¡Gracias por unirte a CircleOfLinks! Antes de empezar a crear tu red, necesitamos que confirmes tu cuenta. Te hemos enviado un enlace de verificación a tu correo. Si no lo recibiste, con gusto te enviaremos otro.') }}
                        </div>

                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success mb-4" role="alert">
                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </div>
                        @endif

                        <div class="d-flex align-items-center justify-content-between mt-4">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Resend Verification Email') }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link text-decoration-none text-muted p-0">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>