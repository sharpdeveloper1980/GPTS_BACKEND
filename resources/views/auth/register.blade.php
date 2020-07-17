@extends('web.layouts.app')
@section('content')
@include('web.layouts.header')
@include('web.layouts.header-search')
<!-- main header image -->
    <div class="container-fluid removePadding">
        <div class="row">
            <div class="col-12"> <img src="{{ asset('public/web/images/common/header.jpg')}}" class="img-fluid" alt="image"> </div>
        </div>
    </div>
    <!-- benefits of registration -->
    <div class="container-fluid greyBackground">
        <div class="container">
            <!-- heading -->
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center headingOne">Benefits of Registration</h3> </div>
            </div>
            <!-- 3 benefits -->
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                    <!-- icon --><img src="{{ asset('public/web/images/common/option1.png')}}" class="img-fluid center-block" alt="image">
                    <!-- heading -->
                    <h4 class="text-center text-uppercase headingAdvantage">option 1</h4>
                    <!-- paragraph -->
                    <p class="text-center paraAdvantageOption">Laborum ut ad proident, dolor reprehenderit. Sunt non Lorem eu. Dolor consequat dolore in esse cupidatat. Ut in ut sed in aute. Minim tempor in nisi eu Duis. Mollit velit pariatur Duis. Deserunt dolore in cupidatat ullamco incididunt</p>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                    <!-- icon --><img src="{{ asset('public/web/images/common/option2.png')}}" class="img-fluid center-block" alt="image">
                    <!-- heading -->
                    <h4 class="text-center text-uppercase headingAdvantage">option 2</h4>
                    <!-- paragraph -->
                    <p class="text-center paraAdvantageOption">Laborum ut ad proident, dolor reprehenderit. Sunt non Lorem eu. Dolor consequat dolore in esse cupidatat. Ut in ut sed in aute. Minim tempor in nisi eu Duis. Mollit velit pariatur Duis. Deserunt dolore in cupidatat ullamco incididunt</p>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                    <!-- icon --><img src="{{ asset('public/web/images/common/option3.png')}}" class="img-fluid center-block" alt="image">
                    <!-- heading -->
                    <h4 class="text-center text-uppercase headingAdvantage">option 3</h4>
                    <!-- paragraph -->
                    <p class="text-center paraAdvantageOption">Laborum ut ad proident, dolor reprehenderit. Sunt non Lorem eu. Dolor consequat dolore in esse cupidatat. Ut in ut sed in aute. Minim tempor in nisi eu Duis. Mollit velit pariatur Duis. Deserunt dolore in cupidatat ullamco incididunt</p>
                </div>
            </div>
        </div>
    </div>
    <!-- reigstration form -->
    <div class="container">
        <!-- navigation -->
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-tabs nav-tabsCustomTwo centerEverything">
                    <li class="nav-item"> <a class="nav-link registrationActive active" data-toggle="tab" href="#student">Student</a> </li>
                    <li class="nav-item"> <a class="nav-link registrationActive" data-toggle="tab" href="#institution">institution</a> </li>
                </ul>
            </div>
        </div>
        <!-- content -->
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12"></div>
            <!-- form -->
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                <div class="tab-content">
                    <div class="tab-pane container active" id="student">
                        <!-- form -->
                        <form method="POST" action="{{ route('register') }}">
                            <div class="headingTwo">Account Information</div>
                            <div class="form-group">
                                <label class="text-uppercase label-customLogin">Email ID</label>
                                <input type="email" class="form-control removeBorderRadius {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus> 
								 @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
							</div>
                            <div class="form-group">
                                <label class="text-uppercase label-customLogin">Name</label>
                                <input type="text" id="name" name="name" class="form-control removeBorderRadius {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" required autofocus>
								@if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
							</div>
                            <div class="form-group">
                                <label class="text-uppercase label-customLogin">Password</label>
                                <input id="password" type="password" class="form-control removeBorderRadius{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required> 
							</div>
                            <div class="form-group">
                                <label class="text-uppercase label-customLogin">confirm password</label>
                                <input type="password" class="form-control removeBorderRadius" id="password-confirm" type="password" name="password_confirmation" required> 
							</div>
                            <div class="headingTwo"> Contact Information</div>
                            <div class="form-group">
                                <label class="text-uppercase label-customLogin">Address</label>
                                <textarea class="form-control removeBorderRadius" id="address" id="address" ></textarea>
                            </div>
                            <div class="form-group"> 
                                <label class="text-uppercase label-customLogin">country</label>
                                <select class="form-control removeBorderRadius">
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="text-uppercase label-customLogin">city</label>
                                <select class="form-control removeBorderRadius">
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                    <option></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="text-uppercase label-customLogin">pin code</label>
                                <input type="text" class="form-control removeBorderRadius"> </div>
                            <div class="form-group">
                                <label class="text-uppercase label-customLogin">contact number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text removeBorderRadius">+91</div>
                                    </div>
                                    <input type="text" class="form-control removeBorderRadius"> </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label smallCheckText" for="defaultCheck1">Contact me on mobile for education products</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label smallCheckText" for="defaultCheck1">Contact me via email for education products</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label smallCheckText" for="defaultCheck1">Send me Great Place to Study Newsletter</label>
                            </div>
                            <div class="form-check termsMargin">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label smallCheckText" for="defaultCheck1">I agree to the <a href="#" target="_blank" class="termsColor">Terms and Conditions</a> and <a href="#" target="_blank">Privacy Policy</a> </label>
                            </div>
                            <!-- button -->
                            <div class="form-group">
                                <button type="button" class="btn btn-success btn-customSuccess removeBorderRadius text-uppercase">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- institutions -->
                    <div class="tab-pane container fade" id="institution">
                        <div class="row">
                            <h3>need fields</h3> </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12"></div>
        </div>
    </div>
    <!-- helpline -->
    <div class="container-fluid greyBackgroundTwo">
        <div class="row">
            <div class="col-12">
                <p class="text-center helplineTxtOne">Student Helpline Number : 011-444 444 44</p>
                <p class="text-center helplinetxtTwo">Timings : 9:30 AM - 5:00 PM, MON - FRI</p>
            </div>
        </div>
    </div>
@include('web.layouts.footer')
@endsection
