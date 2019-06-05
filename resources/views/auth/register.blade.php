@extends("auth.base")
@section("content")
    <div class="limiter">
            <div class="container-login100" style="background-image: url('{{ asset('auth_assets/images/bg-01.jpg') }}');">
                <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                    <form class="login100-form validate-form" action="{{ route('register.store') }}" method="post">
                        @csrf
                        <span class="login100-form-title p-b-49">
                            Register to Ma7fzti
                        </span>

                        {{-- First Name --}}
                        <div class="wrap-input100 validate-input m-b-23" data-validate = "First Name is reauired">
                            <span class="label-input100">First Name</span>
                            <input class="input100" type="text" name="first_name" placeholder="Type your First Name">
                            <span class="focus-input100" data-symbol="&#xf206;"></span>
                        </div>
                        {{-- /First Name --}}

                        {{-- Last Name --}}
                        <div class="wrap-input100 validate-input m-b-23" data-validate = "Last Name is reauired">
                            <span class="label-input100">Last Name</span>
                            <input class="input100" type="text" name="last_name" placeholder="Type your Last Name">
                            <span class="focus-input100" data-symbol="&#xf206;"></span>
                        </div>
                        {{-- /Last Name --}}

                        {{-- Email --}}
                        <div class="wrap-input100 validate-input m-b-23" data-validate = "Email is reauired">
                            <span class="label-input100">Email</span>
                            <input class="input100" type="email" name="email" placeholder="Type your Email">
                            <span class="focus-input100" data-symbol="&#xf206;"></span>
                        </div>
                        {{-- /Email --}}

                        {{-- Password --}}
                        <div class="wrap-input100 validate-input" data-validate="Password is required">
                            <span class="label-input100">Password</span>
                            <input class="input100" type="password" name="password" placeholder="Type your password">
                            <span class="focus-input100" data-symbol="&#xf190;"></span>
                        </div>
                        {{-- /Password --}}

                        <br>

                        {{-- Currency --}}
                        <div class="wrap-input100 validate-input m-b-23" data-validate = "Currency is required">
                            <span class="label-input100">Currency</span>
                            <input class="input100" type="text" name="currency" placeholder="Type your currency symbol">
                            <span class="focus-input100" data-symbol="&#xf19a;"></span>
                        </div>
                        {{-- /Currency --}}

                        {{-- Language --}}
                        <div class="wrap-input100 validate-input m-b-23" data-validate = "Language is required">
                            <span class="label-input100">Language</span>
                            <select name="language_code" id="language_code" class="form-control">
                                @foreach( $langs as $lang )
                                    <option value="{{ $lang->code }}">{{ $lang->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- /Language --}}
                        
                        <div class="container-login100-form-btn">
                            <div class="wrap-login100-form-btn">
                                <div class="login100-form-bgbtn"></div>
                                <button class="login100-form-btn">
                                    Register Now
                                </button>
                            </div>
                        </div>

                        <div class="flex-col-c p-t-5">
                                <span class="txt1 p-b-17">
                                    Have an account already?
                                </span>
    
                                <a href="{{route('login.show')}}" class="txt2">
                                    Sign In
                                </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        

        <div id="dropDownSelect1"></div>
    @endsection
