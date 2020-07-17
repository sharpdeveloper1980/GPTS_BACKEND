@extends('web.layouts.app')
@section('content')
@include('web.layouts.header')
@include('web.layouts.header-search')

  <div class="comparison-container poster-container-top">
        <div class="container-fluid">
            <div class="row">
                <div class="poster-image">
                    <img class="poster-image" src="{{ asset('public/web/images/comparison/comparison-poster.png')}}">
                </div>
            </div>
        </div>
        <div class="container">
            <div class=" header-text text-center">
                <h2 class="big-text blue-font">Comparision</h2>
            </div>
            <div class="comparison-table-wrapper table-responsive-md">
                <h3 class="medium-text blue-font">You have selected 4 Courses (maxium) to compare</h3>
                <table class="table table-bordered text-center">
                    <tbody>
                        <tr>
                            <th>Course Name</th>
                            <td class="column-head">Graphic Designing</td>
                            <td class="column-head">UI Design</td>
                            <td class="column-head">Illustrator</td>
                            <td class="column-head">UX Design</td>
                        </tr>
                        <tr>
                            <th>Duration</th>
                            <td>
                                <div class="column-head">Certification</div> 3 months to 1 year
                                <div class="column-head">Diploma</div> 6 months to 2 year
                                <div class="column-head">Degree</div> 3 year to 4 year</td>
                            <td>
                                <div class="column-head">Certification</div> 3 months to 1 year
                                <div class="column-head">Diploma</div> 6 months to 2 year
                                <div class="column-head">Degree</div> 3 year to 4 year</td>
                            <td>
                                <div class="column-head">Certification</div> 3 months to 1 year
                                <div class="column-head">Diploma</div> 6 months to 2 year
                                <div class="column-head">Degree</div> 3 year to 4 year</td>
                            <td>
                                <div class="column-head">Certification</div> 3 months to 1 year
                                <div class="column-head">Diploma</div> 6 months to 2 year
                                <div class="column-head">Degree</div> 3 year to 4 year</td>
                        </tr>
                        <tr>
                            <th>Career Opportunities
                            </th>
                            <td>Laborum ut ad proident, dolor reprehenderit. Sunt non Lorem eu. Dolor consequat dolore in esse cupidatat. Ut in ut sed in aute. Minim tempor in nisi eu Duis. Mollit velit pariatur Duis. Deserunt dolore in cupidatat ullamco incididunt</td>
                            <td>Laborum ut ad proident, dolor reprehenderit. Sunt non Lorem eu. Dolor consequat dolore in esse cupidatat. Ut in ut sed in aute. Minim tempor in nisi eu Duis. Mollit velit pariatur Duis. Deserunt dolore in cupidatat ullamco incididunt</td>
                            <td>Laborum ut ad proident, dolor reprehenderit. Sunt non Lorem eu. Dolor consequat dolore in esse cupidatat. Ut in ut sed in aute. Minim tempor in nisi eu Duis. Mollit velit pariatur Duis. Deserunt dolore in cupidatat ullamco incididunt</td>
                            <td>Laborum ut ad proident, dolor reprehenderit. Sunt non Lorem eu. Dolor consequat dolore in esse cupidatat. Ut in ut sed in aute. Minim tempor in nisi eu Duis. Mollit velit pariatur Duis. Deserunt dolore in cupidatat ullamco incididunt</td>
                        </tr>
                        <tr>
                            <th>Average Fee</th>
                            <td>
                                <div class="cost column-head">INR 80,000</div> to
                                <div class="cost column-head">INR 3,00,000**</div>
                                <div class="small-text disclaimer-text">*It also depands on institutions, fee can more or less of this amount</div>
                            </td>
                            <td>
                                <div class="cost column-head">INR 80,000</div> to
                                <div class="cost column-head">INR 3,00,000**</div>
                                <div class="small-text disclaimer-text">*It also depands on institutions, fee can more or less of this amount</div>
                            </td>
                            <td>
                                <div class="cost column-head">INR 80,000</div> to
                                <div class="cost column-head">INR 3,00,000**</div>
                                <div class="small-text disclaimer-text">*It also depands on institutions, fee can more or less of this amount</div>
                            </td>
                            <td>
                                <div class="cost column-head">INR 80,000</div> to
                                <div class="cost column-head">INR 3,00,000**</div>
                                <div class="small-text disclaimer-text">*It also depands on institutions, fee can more or less of this amount</div>
                            </td>
                        </tr>
                        <tr class="text-center text-lg-left">
                            <th class="text-center">Average Salary</th>
                            <td>
                                <div class="row no-gutters">
                                    <div class="col-12 col-lg-6">Beginner</div>
                                    <div class="col-12 col-lg-6">up to <strong>20k / pm</strong> </div>
                                    <div class="col-12 col-lg-6">Intermediate</div>
                                    <div class="col-12 col-lg-6">up to <strong>40k / pm</strong> </div>
                                    <div class="col-12 col-lg-6">Beginner</div>
                                    <div class="col-12 col-lg-6">up to <strong>80k / pm</strong> </div>
                                    <div class="col-12 col-lg-6">Beginner</div>
                                    <div class="col-12 col-lg-6"><strong>1 Lakh + / pm</strong> </div>
                                </div>
                            </td>
                            <td>
                                <div class="row no-gutters">
                                    <div class="col-12 col-lg-6">Beginner</div>
                                    <div class="col-12 col-lg-6">up to <strong>20k / pm</strong> </div>
                                    <div class="col-12 col-lg-6">Intermediate</div>
                                    <div class="col-12 col-lg-6">up to <strong>40k / pm</strong> </div>
                                    <div class="col-12 col-lg-6">Beginner</div>
                                    <div class="col-12 col-lg-6">up to <strong>80k / pm</strong> </div>
                                    <div class="col-12 col-lg-6">Beginner</div>
                                    <div class="col-12 col-lg-6"><strong>1 Lakh + / pm</strong> </div>
                                </div>
                            </td>
                            <td>
                                <div class="row no-gutters">
                                    <div class="col-12 col-lg-6">Beginner</div>
                                    <div class="col-12 col-lg-6">up to <strong>20k / pm</strong> </div>
                                    <div class="col-12 col-lg-6">Intermediate</div>
                                    <div class="col-12 col-lg-6">up to <strong>40k / pm</strong> </div>
                                    <div class="col-12 col-lg-6">Beginner</div>
                                    <div class="col-12 col-lg-6">up to <strong>80k / pm</strong> </div>
                                    <div class="col-12 col-lg-6">Beginner</div>
                                    <div class="col-12 col-lg-6"><strong>1 Lakh + / pm</strong> </div>
                                </div>
                            </td>
                            <td>
                                <div class="row no-gutters">
                                    <div class="col-12 col-lg-6">Beginner</div>
                                    <div class="col-12 col-lg-6">up to <strong>20k / pm</strong> </div>
                                    <div class="col-12 col-lg-6">Intermediate</div>
                                    <div class="col-12 col-lg-6">up to <strong>40k / pm</strong> </div>
                                    <div class="col-12 col-lg-6">Beginner</div>
                                    <div class="col-12 col-lg-6">up to <strong>80k / pm</strong> </div>
                                    <div class="col-12 col-lg-6">Beginner</div>
                                    <div class="col-12 col-lg-6"><strong>1 Lakh + / pm</strong> </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Growth Rate</th>
                            <td>Laborum ut ad proident, dolor reprehenderit. Sunt non Lorem eu. Dolor consequat dolore in esse cupidatat. Ut in ut sed in aute. Minim tempor in nisi eu Duis. Mollit velit pariatur Duis. Deserunt dolore in cupidatat ullamco incididunt</td>
                            <td>Laborum ut ad proident, dolor reprehenderit. Sunt non Lorem eu. Dolor consequat dolore in esse cupidatat. Ut in ut sed in aute. Minim tempor in nisi eu Duis. Mollit velit pariatur Duis. Deserunt dolore in cupidatat ullamco incididunt</td>
                            <td>Laborum ut ad proident, dolor reprehenderit. Sunt non Lorem eu. Dolor consequat dolore in esse cupidatat. Ut in ut sed in aute. Minim tempor in nisi eu Duis. Mollit velit pariatur Duis. Deserunt dolore in cupidatat ullamco incididunt</td>
                            <td>Laborum ut ad proident, dolor reprehenderit. Sunt non Lorem eu. Dolor consequat dolore in esse cupidatat. Ut in ut sed in aute. Minim tempor in nisi eu Duis. Mollit velit pariatur Duis. Deserunt dolore in cupidatat ullamco incididunt</td>
                        </tr>
                        <tr class="table-button">
                            <th></th>
                            <td>KNOW MORE</td>
                            <td>KNOW MORE</td>
                            <td>KNOW MORE</td>
                            <td>KNOW MORE</td>
                        </tr>
                    </tbody>
                </table>
            </div>
           @include('web.layouts.common')
        </div>
    </div>    

@include('web.layouts.footer')
@endsection