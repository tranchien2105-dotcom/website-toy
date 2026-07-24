@extends('welcome')
@section('main')
    <div class="linking">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="#">Trang chủ</a></li>
                <li class="active">Authentication</li>
            </ol>
        </div>
    </div>

    <!-- Blog -->
    <section class="login-sec padding-top-30 padding-bottom-100">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <!-- Login Your Account -->
                    <h5>Login Your Account</h5>

                    <!-- FORM -->
                    <form>
                        <ul class="row">
                            <li class="col-sm-12">
                                <label>Username
                                    <input type="text" class="form-control" name="name" placeholder="">
                                </label>
                            </li>
                            <li class="col-sm-12">
                                <label>Password
                                    <input type="password" class="form-control" name="pass" placeholder="">
                                </label>
                            </li>
                            <li class="col-sm-6">
                                <div class="checkbox checkbox-primary">
                                    <input id="cate1" class="styled" type="checkbox">
                                    <label for="cate1"> Keep me logged in </label>
                                </div>
                            </li>
                            <li class="col-sm-6"> <a href="#." class="forget">Forgot your password?</a> </li>
                            <li class="col-sm-12 text-left">
                                <button type="submit" class="btn-round">Login</button>
                            </li>
                        </ul>
                    </form>

                    <a href="{{ route('google.login') }}" class="btn btn-danger w-100">
                        Login with Google
                    </a>

                </div>

                <!-- Don’t have an Account? Register now -->
                <div class="col-md-6">
                    <h5>Don’t have an Account? Register now</h5>

                    <!-- FORM -->
                    <form>
                        <ul class="row">
                            <li class="col-sm-12">
                                <label>Username
                                    <input type="text" class="form-control" name="name" placeholder="">
                                </label>
                            </li>
                            <li class="col-sm-12">
                                <label>Email
                                    <input type="password" class="form-control" name="pass" placeholder="">
                                </label>
                            </li>
                            <li class="col-sm-12">
                                <label>Password
                                    <input type="password" class="form-control" name="pass" placeholder="">
                                </label>
                            </li>
                            <li class="col-sm-12 text-left">
                                <button type="submit" class="btn-round">Register</button>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection