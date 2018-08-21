<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('settings.app_name') }}</title>

		<!-- Styles -->
		<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
		
		<!-- Bootstrap -->
		<link href="{{ asset('/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="{{ asset('/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
		<!-- NProgress -->
		<link href="{{ asset('/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
		<!-- bootstrap-daterangepicker -->
		<link href="{{ asset('/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
		<!-- Datatables -->
		<link href="{{ asset('/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
		<!-- Select2 -->
		<link href="{{ asset('/vendors/select2/dist/css/select2.css') }}" rel="stylesheet">
		<!-- PNotify -->
		<link href="{{ asset('/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
		<link href="{{ asset('/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
		<link href="{{ asset('/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">
		<!-- FileInput -->
		<link href="{{ asset('/vendors/fileinput/fileinput.min.css') }}" rel="stylesheet">
		<!-- TimePicker -->
		<link href="{{ asset('/vendors/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
		<!-- Custom Theme Style -->
		<link href="{{ asset('/build/css/custom.min.css') }}" rel="stylesheet">
	</head>
	
	<body class="nav-md">
		<div class="container body">
			<div class="main_container">
				<div class="col-md-3 left_col">
					<div class="left_col scroll-view">
						<div class="navbar nav_title" style="border: 0;">
							<a href="{{ route('home') }}" class="site_title"><i class="fa fa-wechat"></i> <span>{{ config('settings.app_name') }}</span></a>
						</div>

						<div class="clearfix"></div>

						<!-- menu profile quick info -->
						@include('layouts.menu_profile')
						<!-- /menu profile quick info -->

						<br />

						<!-- sidebar menu -->
						@include('layouts.sidebar')
						<!-- /sidebar menu -->

						<!-- /menu footer buttons -->
						@include('layouts.footer_buttons')
						<!-- /menu footer buttons -->
					</div>
				</div>

				<!-- top navigation -->
				@include('layouts.top_navigation')
				<!-- /top navigation -->

				<!-- page content -->
				<div class="right_col" role="main">
					@yield('content')
				</div>
				<!-- /page content -->

				<!-- footer content -->
				@include('layouts.footer')
				<!-- /footer content -->
			</div>
		</div>
		
		@include('layouts.modal')
		
		<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
			{{ csrf_field() }}
		</form>
	
		<!-- Scripts -->
		<script src="{{ asset('/js/app.js') }}"></script>
		<!-- jQuery -->
		<script src="{{ asset('/vendors/jquery/dist/jquery.min.js') }}"></script>
		<!-- Bootstrap -->
		<script src="{{ asset('/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
		<!-- Datatables -->
		<script src="{{ asset('/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
		<script src="{{ asset('/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
		<script src="{{ asset('/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
		<script src="{{ asset('/vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
		<script src="{{ asset('/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
		<script src="{{ asset('/vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
		<script src="{{ asset('/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
		<script src="{{ asset('/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
		<script src="{{ asset('/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
		<script src="{{ asset('/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
		<script src="{{ asset('/vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
		<script src="{{ asset('/vendors/jszip/dist/jszip.min.js') }}"></script>
		<script src="{{ asset('/vendors/pdfmake/build/pdfmake.min.js') }}"></script>
		<script src="{{ asset('/vendors/pdfmake/build/vfs_fonts.js') }}"></script>
		<!-- FastClick -->
		<script src="{{ asset('/vendors/fastclick/lib/fastclick.js') }}"></script>
		<!-- NProgress -->
		<script src="{{ asset('/vendors/nprogress/nprogress.js') }}"></script>
		<!-- Chart.js -->
		<script src="{{ asset('/vendors/Chart.js/dist/Chart.min.js') }}"></script>
		<!-- jQuery Sparklines -->
		<script src="{{ asset('/vendors/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
		<!-- Flot -->
		<script src="{{ asset('/vendors/Flot/jquery.flot.js') }}"></script>
		<script src="{{ asset('/vendors/Flot/jquery.flot.pie.js') }}"></script>
		<script src="{{ asset('/vendors/Flot/jquery.flot.time.js') }}"></script>
		<script src="{{ asset('/vendors/Flot/jquery.flot.stack.js') }}"></script>
		<script src="{{ asset('/vendors/Flot/jquery.flot.resize.js') }}"></script>
		<!-- Flot plugins -->
		<script src="{{ asset('/vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
		<script src="{{ asset('/vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
		<script src="{{ asset('/vendors/flot.curvedlines/curvedLines.js') }}"></script>
		<!-- DateJS -->
		<script src="{{ asset('/vendors/DateJS/build/date.js') }}"></script>
		<!-- bootstrap-daterangepicker -->
		<script src="{{ asset('/vendors/moment/min/moment.min.js') }}"></script>
		<script src="{{ asset('/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
		<!-- Select2 -->
		<script src="{{ asset('/vendors/select2/dist/js/select2.js') }}"></script>
		<!-- validator -->
		<script src="{{ asset('/vendors/validator/validator.js') }}"></script>
		<!-- PNotify -->
		<script src="{{ asset('/vendors/pnotify/dist/pnotify.js') }}"></script>
		<script src="{{ asset('/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
		<script src="{{ asset('/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>
		<!-- jquery.inputmask -->
		<script src="{{ asset('/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') }}"></script>
		<!-- FileInput -->
		<script src="{{ asset('/vendors/fileinput/fileinput.min.js') }}"></script>
		<!-- TimePicker -->
		<script src="{{ asset('/vendors/timepicker/bootstrap-timepicker.min.js') }}"></script>
		<!-- Custom Theme Scripts -->
		<script src="{{ asset('/build/js/custom.js') }}"></script>
		
		<script>
			@yield('scripts')
			
			@if (session('status'))
				new PNotify({
					title: '{{ session()->get('status')[1] }}',
					text: '{{ session()->get('status')[2] }}',
					type: '{{ session()->get('status')[0] }}',
					styling: 'bootstrap3'
				});	
			@endif
		</script>
	</body>
</html>