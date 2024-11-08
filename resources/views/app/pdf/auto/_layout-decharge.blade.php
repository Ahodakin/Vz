<html>
	<head>
		<title>MONASSURANCE.CI | Commande</title>
		<link rel="stylesheet" href="{{ ltrim(mix('css/print.css'), '/') }}" />
		<link rel="icon" type="image/png" href="{{ ltrim(mix('/images/favicon.png'), '/') }}">
		<style>
		.page-break {
		    page-break-after: always;
		}

		.space{
			bottom: 150px;
		}
		</style>
	</head>
	<body style="background-color:#ccccc">

		@yield('content')

	</body>
</html>
