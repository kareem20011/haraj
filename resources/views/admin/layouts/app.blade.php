<!doctype html>
<html lang="en">

<head>

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>{{ __('titles.brand') }} - {{ __('titles.dashboard') }}</title>

	<!-- favicon -->
	<link rel="icon" type="image/x-icon" sizes="152x152" href="{{ asset('assets/images/favicon.png') }}">

	<!-- Bootstrap CSS-->
	<link rel="stylesheet" href="{{ asset('assets/admin/modules/bootstrap-5.1.3/css/bootstrap.css') }}">
	<!-- Style CSS -->
	<link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
	<!-- FontAwesome CSS-->
	<link rel="stylesheet" href="{{ asset('assets/admin/modules/fontawesome6.1.1/css/all.css') }}">

	<!-- custome -->
	<link rel="stylesheet" href="{{ asset('assets/admin/css/custome.css') }}?v={{ time() }}">
</head>

<body>

	<!--Topbar -->
	@include('admin.layouts.includes.topbar')

	<!--Sidebar-->
	@include('admin.layouts.includes.sidebar')




	<div class="sidebar-overlay"></div>

	<!-- Contents -->
	<div class="content-start transition">
		<div class="container-fluid dashboard">
			@yield('admin.contents')
		</div>
	</div>


	<!-- Preloader -->
	<div class="loader">
		<div class="spinner-border text-light" role="status">
			<span class="sr-only">Loading...</span>
		</div>
	</div>

	<!-- Loader -->
	<div class="loader-overlay"></div>

	<!-- General JS Scripts -->
	<script src="assets/js/atrana.js"></script>

	<!-- JS Libraies -->
	<script src="{{ asset('assets/admin/modules/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/admin/modules/bootstrap-5.1.3/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('assets/admin/modules/popper/popper.min.js') }}"></script>

	<!-- Template JS File -->
	<script src="{{ asset('assets/admin/js/script.js') }}"></script>
	<script src="{{ asset('assets/admin/js/custom.js') }}"></script>

	<script>
		window.onload = function() {
			var alertBoxes = document.querySelectorAll('.alert');

			alertBoxes.forEach(function(alertBox) {
				setTimeout(function() {
					$(alertBox).fadeOut('slow');
				}, 3000);
			});
		};
	</script>

</body>

</html>