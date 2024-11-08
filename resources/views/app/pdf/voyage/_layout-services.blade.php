<html>
	<head>
		<title>MONASSURANCE.CI | Services Optionnels</title>
		<link rel="stylesheet" href="{{ ltrim(mix('css/print-pdf.css'), '/') }}" />

	</head>
	<body style="background-color:#ccccc">
		@include('app.pdf.auto._header-services')
		@yield('content')
		@include('app.pdf.auto._footer')
	</body>
</html>
