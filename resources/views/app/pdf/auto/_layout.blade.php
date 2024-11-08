<html>
	<head>
		<title>MONASSURANCE.CI | Soyez rassuré tout est géré</title>
		<link rel="stylesheet" href="{{ ltrim(mix('css/print-pdf.css'), '/') }}" />
		<link rel="icon" type="image/png" href="{{ ltrim(mix('/images/favicon.png'), '/') }}">

		<style>
		.page-break {
		    page-break-after: always;
		}
		</style>
	</head>
	<body style="background-color:#ccccc">

		@yield('content')
		@include('app.pdf.auto._footer')
	</body>
</html>
