@extends('web.layouts.app')
@section('content')
@include('web.layouts.header')
@include('web.layouts.header-search')

<div class="pricing-container poster-container-top">
        <div class="container-fluid">
            <div class="row">
                <div class="poster-image">
                    <img class="poster-image" src="{{ asset('public/web/images/comparison/comparison-poster.png')}}">
                </div>
            </div>
        </div>
        <div class="container p-0 plan-card-container">
            <div class=" header-text text-center">
                <h2 class="big-text blue-font">Comparision</h2>
            </div>
            <h3 class="medium-text blue-font col-10 mx-auto text-center">Consequat Ut aliquip sunt. Amet, pariatur cupidatat esse Excepteur. Officia mollit adipiscing officia. Mollit cillum Lorem ipsum id in.</h3>
            <h4 class="genral-text text-center blue-font font-weight-normal">Excepteur minim amet, aliquip. Dolore dolore velit mollit nisi ut. Ut reprehenderit pariatur cupidatat mollit eiusmod. Ipsum voluptate aute est. In ipsum deserunt dolor. Magna quis velit consequat consequat sit. Fugiat nisi est consectetur aute. Ullamco eu deserunt veniam, Ut ut. Laboris in est Excepteur incididunt aute. Quis officia proident, velit. Velit eu dolore consectetur occaecat Ut. Irure eiusmod adipiscing consequat incididunt laborum.</h4>
            <div class="row justify-content-center justify-content-lg-between plan-card-wrapper no-gutters">
                <div class="col-10 col-md-7 col-lg-3">
                    <div class="plan-card">
                        <div class="row no-gutters">
                            <div class="col-12 plan-image-wrapper text-center basic-image-wrapper">
                                <img class="img-fluid" src="{{ asset('public/web/images/common/basic-plan.png')}}">
                            </div>
                            <div class="col-12">
                                <ul class="plan-description">
                                    <li>
                                        Aute proident, dolore tempor.
                                    </li>
                                    <li>Ut officia commodo.</li>
                                    <li> Pariatur sunt cupidatat sint deserunt.</li>
                                    <li> Amet, sed ea adipiscing. Aute proident, dolore tempor.</li>
                                    <li> Ut officia commodo. Pariatur sunt cupidatat sint deserunt</li>
                                    <li>Amet, sed ea adipiscing.</li>
                                </ul>
                            </div>
                            <div class="col-12">
                                <div class="border-top plan-card-price text-center py-3 light-blue-font">
                                    <div class="medium-text">6 Months</div>
                                    <div class="medium-big-text semi-bold">Rs. 2,999.00</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="w-100 border-top text-center blue-font medium-text semi-bold py-3">
                                    BUY NOW
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-10 col-md-7 col-lg-3">
                    <div class="plan-card">
                        <div class="row no-gutters">
                            <div class="col-12 plan-image-wrapper text-center advanced-image-wrapper">
                                <img class="img-fluid" src="{{ asset('public/web/images/common/advanced-plan.png')}}">
                            </div>
                            <div class="col-12">
                                <ul class="plan-description">
                                    <li>
                                        Aute proident, dolore tempor.
                                    </li>
                                    <li>Ut officia commodo.</li>
                                    <li> Pariatur sunt cupidatat sint deserunt.</li>
                                    <li> Amet, sed ea adipiscing. Aute proident, dolore tempor.</li>
                                    <li> Ut officia commodo. Pariatur sunt cupidatat sint deserunt</li>
                                    <li>Amet, sed ea adipiscing.</li>
                                </ul>
                            </div>
                            <div class="col-12">
                                <div class="border-top plan-card-price text-center py-3 orange-font">
                                    <div class="medium-text">6 Months</div>
                                    <div class="medium-big-text semi-bold">Rs. 2,999.00</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="w-100 border-top text-center blue-font medium-text semi-bold py-3">
                                    BUY NOW
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-10 col-md-7 col-lg-3">
                    <div class="plan-card">
                        <div class="row no-gutters">
                            <div class="col-12 plan-image-wrapper text-center ultimate-image-wrapper">
                                <div class="offer-image position-absolute">
                                   <img class="img-fluid" src="{{ asset('public/web/images/common/offer.png')}}"> 
                                </div>
                                <img class="img-fluid" src="{{ asset('public/web/images/common/ultimate-plan.png')}}">
                            </div>
                            <div class="col-12">
                                <ul class="plan-description">
                                    <li>
                                        Aute proident, dolore tempor.
                                    </li>
                                    <li>Ut officia commodo.</li>
                                    <li> Pariatur sunt cupidatat sint deserunt.</li>
                                    <li> Amet, sed ea adipiscing. Aute proident, dolore tempor.</li>
                                    <li> Ut officia commodo. Pariatur sunt cupidatat sint deserunt</li>
                                    <li>Amet, sed ea adipiscing.</li>
                                </ul>
                            </div>
                            <div class="col-12">
                                <div class="border-top plan-card-price text-center py-3 purple-font">
                                    <div class="medium-text">6 Months</div>
                                    <div class="medium-big-text semi-bold">Rs. 2,999.00</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="w-100 border-top text-center blue-font medium-text semi-bold py-3">
                                    BUY NOW
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container comparison-container">
            <div class=" header-text text-center">
                <h2 class="big-text blue-font">Comparision</h2>
            </div>
            <div class="comparison-table-wrapper row justify-content-center">
                <h3 class="medium-text blue-font col-10 text-center mx-auto">Consequat Ut aliquip sunt. Amet, pariatur cupidatat esse Excepteur.
Officia mollit adipiscing officia. Mollit cillum Lorem ipsum id in.</h3>
                <div class="table-responsive-md col-12">
                    <table class="table table-bordered text-center">
                        <tbody>
                            <tr>
                                <th class="dark-background">Plans</th>
                                <td class="light-blue-background text-white">Basic</td>
                                <td class="green-background text-white">Advanced</td>
                                <td class="purple-background text-white">Ultimate</td>
                            </tr>
                            <tr>
                                <th>Aute proident,</th>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>Dolore tempor</th>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>Ut officia commodo cupidatat eu.
                                </th>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>Pariatur sunt cupidatat,</th>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>Sint deserunt.</th>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>Amet, sed ea adipiscing aliqua sed. ,
                                </th>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>Ut officia commodo cupidatat eu.
                                </th>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>Dolore tempor</th>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>Aute proident,</th>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>Aute proident,</th>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                                <td>
                                    <div class="tick-mark"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>
                                    <div class="price light-blue-font genral-text">Rs. 2,999.00</div>
                                </td>
                                <td>
                                    <div class="price green-font genral-text">Rs. 3,999.00</div>
                                </td>
                                <td>
                                    <div class="price purple-font genral-text">Rs. 5,999.00</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row flex-column align-items-center">
                <div class="col-12 col-md-4">
                    <button class="primary-button">BUILD YOUR PROFILE</button>
                </div>
            </div>
        </div>
</div>

@include('web.layouts.footer')
@endsection