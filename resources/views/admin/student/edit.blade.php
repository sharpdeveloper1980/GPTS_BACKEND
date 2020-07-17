@extends('admin.layouts.app')

@section('title', 'View Student')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>View Student</h1>
    </section>
    <section class="content">	
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">View Student</h3>
                        <div class="pull-right">
                            <a href="{!! url('/admin/students'); !!}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if (\Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ \Session::get('success') }}</p>
                    </div>
                    @endif 
                    {{ Form::model($student, ['method' => 'post','url' => ['/admin/edit-student', @$student->id] ,'files' => true]) }}
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="row form-group gallerylist">

                            <div>
                                <div class="col-md-3 form-group ">

                                    {{ Form::label('name', 'Student Name') }} : {{@$student->name}} 
                                    @if($student->name!='')
                                    <a onClick="javascript: return confirm('Are you sure you want to delete this?');" href="{{Url('/')}}/admin/updateStaudent/name/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                    @endif
                                </div>
                                <div class="col-md-3 form-group ">
                                    {{ Form::label('name', 'Email Id') }} : {{@$student->email}}
                                    
                                    
                                </div>
                                <div class="col-md-3 form-group ">
                                    {{ Form::label('name', 'Contact No.') }} : {{@$student->contact}}
                                    @if($student->contact!='')
                                    <a onClick="javascript: return confirm('Are you sure you want to delete this?');"  href="{{Url('/')}}/admin/updateStaudent/contact/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                    @endif
                                </div>
                                <div class="col-md-3 form-group ">
                                    {{ Form::label('name', 'Skype Id') }} : {{@$student->skype_id}}
                                    @if($student->skype_id!='')
                                    <a onClick="javascript: return confirm('Are you sure you want to delete this?');" href="{{Url('/')}}/admin/updateStaudent/skype_id/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                @endif
                                </div>
                                <div class="col-md-3 form-group ">
                                    {{ Form::label('name', 'College Year') }} : {{@$student->collage_year}}
                                    @if($student->collage_year!='')
                                    <a onClick="javascript: return confirm('Are you sure you want to delete this?');" href="{{Url('/')}}/admin/updateStaudent/collage_year/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                    @endif
                                </div>
                                <div class="col-md-3 form-group ">
                                    {{ Form::label('name', 'Date of Birth') }} : {{@$student->dob}}
                                  @if($student->dob!='')
                                    <a onClick="javascript: return confirm('Are you sure you want to delete this?');" href="{{Url('/')}}/admin/updateStaudent/dob/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                    @endif
                                </div>
                                <div class="col-md-3 form-group ">
                                    {{ Form::label('name', 'Age') }} : {{@$student->age}}
                                  @if($student->age!='')
                                    <a onClick="javascript: return confirm('Are you sure you want to delete this?');" href="{{Url('/')}}/admin/updateStaudent/age/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                    @endif
                                </div>
                                <div class="col-md-3 form-group ">
                                    {{ Form::label('name', 'Gender') }} : {{@$student->gender}}
                                    @if($student->gender!='')
                                    <a onClick="javascript: return confirm('Are you sure you want to delete this?');" href="{{Url('/')}}/admin/updateStaudent/gender/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                    @endif
                                </div>
                                <div class="col-md-3 form-group ">
                                    {{ Form::label('Address', 'Address') }} : {{@$student->address}}
                                    @if($student->address!='')
                                    <a onClick="javascript: return confirm('Are you sure you want to delete this?');" href="{{Url('/')}}/admin/updateStaudent/address/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                    @endif
                                </div>
                                <div class="col-md-3 form-group ">
                                    {{ Form::label('Address', 'Pincode') }} : {{@$student->pincode}}
                                     @if($student->pincode!='')
                                    <a href="{{Url('/')}}/admin/updateStaudent/pincode/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                    @endif
                                </div>
                                <div class="col-md-3 form-group ">
                                    {{ Form::label('Address', 'Country') }} : {!! App\Helpers\Helper::getCountryName($student->country) !!}
                                    
                                </div>
                                <div class="col-md-3 form-group ">
                                    {{ Form::label('Address', 'State') }} : {!! App\Helpers\Helper::getStateName($student->state) !!}
                                   
                                </div>
                               
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <h4>Permanent Address</h4>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {{ Form::label('Address', 'Address') }} : {{@$student->permanent_address}}
                                         @if($student->permanent_address!='')
                                        <a onClick="javascript: return confirm('Are you sure you want to delete this?');" href="{{Url('/')}}/admin/updateStaudent/permanent_address/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        @endif
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {{ Form::label('Address', 'Country') }} : {!! App\Helpers\Helper::getCountryName($student->permanent_country) !!}
                                        
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {{ Form::label('Address', 'State') }} : {!! App\Helpers\Helper::getStateName($student->permanent_state) !!}
                                       
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {{ Form::label('Address', 'Pincode') }} : {{@$student->permanent_pincode}}
                                       @if($student->permanent_pincode!='')
                                        <a onClick="javascript: return confirm('Are you sure you want to delete this?');" href="{{Url('/')}}/admin/updateStaudent/permanent_pincode/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <h4>Father Information</h4>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {{ Form::label('Name', 'Name') }} : {{@$student->permanent_address}}
                                        @if($student->permanent_address!='')
                                        <a onClick="javascript: return confirm('Are you sure you want to delete this?');" href="{{Url('/')}}/admin/updateStaudent/permanent_address/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        @endif
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {{ Form::label('Occupation', 'Occupation') }} : {{@$student->father_occupation}}
                                       @if($student->father_occupation!='')
                                        <a onClick="javascript: return confirm('Are you sure you want to delete this?');" href="{{Url('/')}}/admin/updateStaudent/father_occupation/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                    @endif
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {{ Form::label('Address', 'Eduction') }} : {{@$student->father_highest_education}}
                                      @if($student->father_highest_education!='')
                                        <a onClick="javascript: return confirm('Are you sure you want to delete this?');" href="{{Url('/')}}/admin/updateStaudent/father_highest_education/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                    @endif
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {{ Form::label('Address', 'Email Id')}} : {{@$student->father_email_id}}
                                        @if($student->father_email_id!='')  
                                        <a onClick="javascript: return confirm('Are you sure you want to delete this?');" href="{{Url('/')}}/admin/updateStaudent/father_email_id/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        @endif
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {{ Form::label('Address', 'Contact Number') }} : {{@$student->father_contact_no}}
                                         @if($student->father_contact_no!='')
                                        <a onClick="javascript: return confirm('Are you sure you want to delete this?');" href="{{Url('/')}}/admin/updateStaudent/father_contact_no/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        @endif
                                    </div>
                                     <div class="col-md-3 form-group">
                                        {{ Form::label('Address', 'Income') }} : {{@$student->family_income}}
                                        @if($student->family_income!='')
                                        <a onClick="javascript: return confirm('Are you sure you want to delete this?');" href="{{Url('/')}}/admin/updateStaudent/family_income/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <h4>Mother Information</h4>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {{ Form::label('Name', 'Name') }} : {{@$student->mother_name}}
                                        @if($student->mother_name!='')
                                        <a onClick="javascript: return confirm('Are you sure you want to delete this?');" href="{{Url('/')}}/admin/updateStaudent/mother_name/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        @endif
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {{ Form::label('Occupation', 'Occupation') }} : {{@$student->mother_occupation}}
                                      @if($student->mother_occupation!='')
                                        <a onClick="javascript: return confirm('Are you sure you want to delete this?');" href="{{Url('/')}}/admin/updateStaudent/mother_occupation/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        @endif
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {{ Form::label('Address', 'Eduction') }} : {{@$student->mother_highest_education}}
                                      @if($student->mother_highest_education!='')
                                        <a onClick="javascript: return confirm('Are you sure you want to delete this?');" href="{{Url('/')}}/admin/updateStaudent/mother_highest_education/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        @endif
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {{ Form::label('Address', 'Email Id')}} : {{@$student->mother_email_id}}
                                       @if($student->mother_email_id!='')
                                        <a onClick="javascript: return confirm('Are you sure you want to delete this?');" href="{{Url('/')}}/admin/updateStaudent/mother_email_id/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        @endif
                                    </div>
                                    <div class="col-md-3 form-group">
                                        {{ Form::label('Address', 'Contact Number') }} : {{@$student->mother_contact_no}}
                                       @if($student->mother_contact_no!='')
                                        <a onClick="javascript: return confirm('Are you sure you want to delete this?');" href="{{Url('/')}}/admin/updateStaudent/mother_contact_no/{{@$student->id}}" title="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        @endif
                                    </div>
         
                                </div>
                            </div>

                            <div>


                            </div>
                        </div>

                    </div>				
                    {!! Form::close() !!}
                </div>
                <!-- /.box --> 
            </div>
        </div>
    </section> 
</div>

<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




