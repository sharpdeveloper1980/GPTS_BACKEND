<div class="container-fluid footer-container">
        <div class="row no-gutters justify-content-center black-font small-text position-relative">
            <div class="col-6 d-flex justify-content-center ">
                <div class="footer-link divider-right">
                    About Us
                </div>
                <div class="footer-link divider-right">
                    FAQs
                </div>
                <div class="footer-link">
                    Contact Us
                </div>
            </div>
            <div class="nationality ml-auto position-absolute"><span class="align-middle">IN - EN</span> <img src="{{ asset('public/web/images/homepage/Inidia-Flag-Icon.png') }}"></div>
        </div>
</div>

<!-- login modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content loginBackground removeBorderRadius">
                <div class="modal-body">
                    <div class="container-fluid">
                        <!-- navigation -->
                        <div class="row">
                            <!-- left side -->
                            <div class="col-12 removePadding">
                                <!-- two tabs -->
                                <ul class="nav nav-tabs nav-tabsCustom">
                                    <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#student">Student</a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#institution">institution</a> </li>
                                </ul>
                            </div>
                        </div>
                        <!-- content -->
                        <div class="row">
                            <div class="tab-content">
                                <div class="tab-pane container active show" id="student">
                                    <div class="row">
                                        <!-- right border -->
                                        <hr class="rightBr">
                                        <!-- left side -->
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <!-- form -->
                                            <form class="formMargintp">
                                                <div class="form-group">
                                                    <label class="text-uppercase label-customLogin">Email ID</label>
                                                    <input type="email" class="form-control removeBorderRadius" autofocus=""> </div>
                                                <div class="form-group">
                                                    <label class="text-uppercase label-customLogin">password</label>
                                                    <input type="password" class="form-control removeBorderRadius"> </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                    <label class="form-check-label smallCheckText" for="defaultCheck1"> Keep me signed in </label>
                                                </div>
                                                <!-- button -->
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-success btn-customSuccess removeBorderRadius text-uppercase">login</button>
                                                </div>
                                                <div class="form-group">
                                                    <a href="{{route('register')}}" class="btn btn-default btn-customDefault removeBorderRadius text-uppercase">signup</a>
                                                </div>
                                            </form>
                                            <!-- forgot password -->
                                            <div class="form-group"> <a href="#" class="forgotPass">Forgot password?</a> </div>
                                        </div>
                                        <!-- right side -->
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <h6 class="text-center text-uppercase loginWithtxt">or login with</h6>
                                            <!-- facebook button -->
                                            <div class="text-center">
                                                <button type="button" class="btn btn-success btn-customFacebook removeBorderRadius text-uppercase"><i class="fab fa-facebook-f fa-2x"></i> <span class="socialname">Facebook</span> </button>
                                            </div>
                                            <!-- google plus button -->
                                            <div class="text-center">
                                                <button type="button" class="btn btn-success btn-customGoogle removeBorderRadius text-uppercase"><i class="fab fa-google-plus-g fa-2x"></i> <span class="socialname">Google <i class="fas fa-plus"></i></span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- institutions -->
                                <div class="tab-pane container fade" id="institution">
                                    <div class="row">
                                        <!-- right border -->
                                        <hr class="rightBr">
                                        <!-- left side -->
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <!-- form -->
                                            <form class="formMargintp">
                                                <div class="form-group">
                                                    <label class="text-uppercase label-customLogin">Email ID</label>
                                                    <input type="email" class="form-control removeBorderRadius" autofocus=""> </div>
                                                <div class="form-group">
                                                    <label class="text-uppercase label-customLogin">password</label>
                                                    <input type="password" class="form-control removeBorderRadius"> </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                    <label class="form-check-label smallCheckText" for="defaultCheck1"> Keep me signed in </label>
                                                </div>
                                                <!-- button -->
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-success btn-customSuccess removeBorderRadius text-uppercase">login</button>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-default btn-customDefault removeBorderRadius text-uppercase">signup</button>
                                                </div>
                                            </form>
                                            <!-- forgot password -->
                                            <div class="form-group"> <a href="#" class="forgotPass">Forgot password?</a> </div>
                                        </div>
                                        <!-- right side -->
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <h3 class="text-center insituQuote"><span class="loginQuote"></span>Elit, enim dolore magna. In culpa magna aute amet,
voluptate. Sunt quis laboris labore labore.</h3> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>