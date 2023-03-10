@extends('users.admin.layouts.master')
@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">

                    <h3 class="kt-subheader__title">Appointments</h3>

                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>


                    <a href="{{route('appointments.create')}}" class="btn btn-label-warning btn-bold btn-sm btn-icon-h kt-margin-l-10">
                        Add New
                    </a>

                    <div class="kt-input-icon kt-input-icon--right kt-subheader__search kt-hidden">
                        <input type="text" class="form-control" placeholder="Search order..." id="generalSearch">
                        <span class="kt-input-icon__icon kt-input-icon__icon--right">
                        <span><i class="flaticon2-search-1"></i></span>
                </span>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <a href="#" class="btn kt-subheader__btn-secondary">Today</a>

                        <a href="#" class="btn kt-subheader__btn-secondary">Month</a>

                        <a href="#" class="btn kt-subheader__btn-secondary">Year</a>

                        <a href="#" class="btn kt-subheader__btn-daterange" id="kt_dashboard_daterangepicker" data-toggle="kt-tooltip" title="" data-placement="left" data-bs-original-title="Select dashboard daterange">
                            <span class="kt-subheader__btn-daterange-title" id="kt_dashboard_daterangepicker_title">Today</span>&nbsp;
                            <span class="kt-subheader__btn-daterange-date" id="kt_dashboard_daterangepicker_date">Aug 31</span>
                            <i class="flaticon2-calendar-1"></i>
                        </a>

             
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Content Head -->

        <!-- begin:: Content Container-->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <div id="test">
                <div class="container">
                   <div class="row justify-content-center">
                   <div class="col-lg-8">
		<div class="kt-portlet">
			<div class="kt-portlet__head kt-ribbon kt-ribbon--right">
				<div class="kt-ribbon__target" style="top: -2px; right: 20px;">
					{{$Appointment->status}}
				</div>
				<div class="kt-portlet__head-label">
					<h3 class="kt-portlet__head-title">
                    {{$patients[0]->first_name}} you have and appointment with {{$doctor[0]->first_name}}
					</h3>
				</div>
			</div>
			<div class="kt-portlet__body kt-portlet__body--fit-top"><br>
            <h3 class="display-5"> {{$Appointment->date}} <small class="text-muted">{{$Appointment->time}}</small></h3>
            <div class="kt-section__content kt-section__content--solid">
                 <p class="lead"> NOTE : {{$Appointment->notes}} </p>
                    </div>
			</div>
		</div>
	</div>
</div>
</div>
</div>

        </div>
        <!-- end:: Content Container-->
    </div>
@endsection
