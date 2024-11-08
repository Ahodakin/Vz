<!DOCTYPE html>
<html dir="ltr" lang="fr-FR">
<head>
	<base href="" >
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>@yield('title')</title>
	<meta name="description" content="1er comparateur d’assurance en Côte d'Ivoire, monassurance.ci vous offre la possibilité de comparer plusieurs devis d’assurances pour en choisir le meilleur.Avec monassurance.ci, c'est l'assurance de faire des économies et gagner du temps.">

	<meta name="keywords" content="assurance,automobile,moto,voyage,habitation,côte d'ivoire, courtier, courtage,digitale, nsia,serenity,atlas,loyale,atlantique,sonam">

	<meta name="author" content="AROLI TECHNOLOGIE">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<link rel="icon" type="image/png" href="{{asset('images/favicon.png')}}">
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700%7COpen+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
 	<link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
 	<link rel="stylesheet" href="{{asset('css/advisor.css')}}">
 	<link rel="stylesheet" href="{{asset('css/plugins.css')}}">
 	<link rel="stylesheet" href="{{asset('css/color-default.css')}}">
 	<link rel="stylesheet" href="{{asset('css/hero-slider.css')}}">
 	<link rel="stylesheet" href="{{asset('css/responsive.css')}}">
 	<link rel="stylesheet" href="{{asset('css/animate.css')}}">
 	<link href="{{asset('css/select2/select2.min.css')}}" rel="stylesheet" />
 	<link href="{{asset('css/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet" />
	<link href="{{asset('js/cookieconsent/build/cookieconsent.min.css')}}" rel="stylesheet" />

	     <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	     <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	     <!--[if lt IE 9]>
	       <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	       <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	     <![endif]-->

	 	<!-- HEADER SCRIPTS

	     ================================================== -->
	<script src="{{asset('js/modernizr.js')}}"></script>


	@yield('custom-styles')
 	<style type="text/css">
 		.floating{
			position: fixed;
			z-index: 1000;
  			top: 50%;
  			right: 0px;
  			-webkit-transform-origin: 100% 50%;
  			      -moz-transform-origin: 100% 50%;
  			       -ms-transform-origin: 100% 50%;
  			        -o-transform-origin: 100% 50%;
  			           transform-origin: 100% 50%;
  			   -webkit-transform: rotate(90deg) translate(50%, 50%);
  			      -moz-transform: rotate(90deg) translate(50%, 50%);
  			       -ms-transform: rotate(90deg) translate(50%, 50%);
  			        -o-transform: rotate(90deg) translate(50%, 50%);
  			           transform: rotate(90deg) translate(50%, 50%);
  			border-radius: 0px;
  			background-color: #01a29c;
  			margin:auto;
  			height: 2.5

		}
 	</style>

	 	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109776078-1"></script>
	 	<script>
	 	  window.dataLayer = window.dataLayer || [];
	 	  function gtag(){dataLayer.push(arguments);}
	 	  gtag('js', new Date());

	 	  gtag('config', 'UA-109776078-1');
	 	</script>

	 	<!-- Google Tag Manager -->
	 	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	 	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	 	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	 	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	 	})(window,document,'script','dataLayer','GTM-WQ83JM4');</script>
	 	<!-- End Google Tag Manager -->

	 	<!-- Facebook Pixel Code -->
	 	<script>
	 	  !function(f,b,e,v,n,t,s)
	 	  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	 	  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	 	  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	 	  n.queue=[];t=b.createElement(e);t.async=!0;
	 	  t.src=v;s=b.getElementsByTagName(e)[0];
	 	  s.parentNode.insertBefore(t,s)}(window, document,'script',
	 	  'https://connect.facebook.net/en_US/fbevents.js');
	 	  fbq('init', '1067926503257541');
	 	  fbq('track', 'PageView');
	 	</script>
	 	<noscript><img height="1" width="1" style="display:none"
	 	  src="https://www.facebook.com/tr?id=1067926503257541&ev=PageView&noscript=1"
	 	/></noscript>
	 	<!-- End Facebook Pixel Code -->
</head>
<body class="fixed-header">
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WQ83JM4"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<!-- The Main Wrapper -->

		<!-- LOADER -->
		<div id="loader" class="loader">
			<div class="spinner">
			  <div class="double-bounce1"></div>
			  <div class="double-bounce2"></div>
			</div>
		</div>


		<div class="container" style="width:100%; padding-right:0px;padding-left:0px">
			@yield('content')
		</div>

		<a href="#." data-toggle="modal" data-target="#call-me" class="btn btn-primary floating" data-text="&nbsp;&nbsp;&nbsp;&nbsp;Je veux me faire appeler"><i class="icon-telephone114"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Besoin d'aide ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
		<!-- Footer -->
		<footer id="footer">


			@include('layouts.frontend.partials.footer-simple')
			@include('layouts.frontend.utils.want-to-call-me')


		</footer>
		<script src="{{asset('js/jquery-2.2.0.js')}}"></script>
		<script src="{{asset('js/smooth-scroll.js')}}"></script>
		<script src="{{asset('js/bootstrap.min.js')}}"></script>
		<script src="{{asset('js/counter.js')}}"></script>
		<script src="{{asset('js/common.js')}}"></script>
		<script src="{{asset('js/scripts.js')}}"></script>
		<script src="{{asset('js/hero-slider.js')}}"></script>
		<script src="{{asset('js/typed.min.js')}}"></script>
		<script src="{{asset('js/jquery.maskedinput.min.js')}}"></script>
		<script src="{{asset('css/select2/select2.min.js')}}"></script>
		<script src="{{asset('css/bootstrap-datetimepicker/build/js/moment.js')}}"></script>
		<script src="{{asset('css/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
		<script src="{{asset('js/cleave.js/dist/cleave.min.js')}}"></script>
		<script src="{{asset('js/cleave.js/dist/addons/cleave-phone.ci.js')}}"></script>
		<script type="text/javascript" src="{{asset('js/cookieconsent/build/cookieconsent.min.js')}}"></script>
		<script>
		window.addEventListener("load", function(){
		window.cookieconsent.initialise({
		  "palette": {
		    "popup": {
		      "background": "#eaf7f7",
		      "text": "#5c7291"
		    },
		    "button": {
		      "background": "#56cbdb",
		      "text": "#ffffff"
		    }
		  },
		  "content": {
		    "message": "En poursuivant votre navigation, vous acceptez le dépôt de cookies tiers destinés à améliorer votre expérience utilisateurs sur notre site web.",
		    "dismiss": "OK J'accepte",
		    "link": "En savoir plus",
		    "href": "#"
		  }
		})});
		</script>
		<script type="text/javascript">
			$(document).ready(function() {
				new Cleave('.phone-ci', {
				    phone: true,
				    phoneRegionCode: 'CI'
				});
				$(".phone").mask("99 99 99 99 99");
				$(".date").mask("99/99/9999");
				$('#btn_search_sin').click(function  () {
					$('#div_s_sin').show()
					$('#devis_police').hide()
				});

				$('#btn_search_dev').click(function  () {
					$('#devis_police').show()
					$('#div_s_sin').hide()
				});


			})
		</script>

		{{--<script type="text/javascript">
		var _videodesk= _videodesk || {};
		_videodesk['firstname'] = '' ;
		_videodesk['lastname'] = '' ;
		_videodesk['company'] = '' ;
		_videodesk['email'] = '' ;
		_videodesk['phone'] = '' ;
		_videodesk['customer_lang'] = '' ;
		_videodesk['customer_id'] = '' ;
		_videodesk['customer_url'] = '' ;
		_videodesk['cart_id'] = '' ;
		_videodesk['cart_url'] = '' ;
		_videodesk['uid'] = 'd2d40aa9817f8369a5baa8d902a2caf0' ;
		_videodesk['lang'] = 'fr' ;
		(function() {
		var videodesk = document.createElement('script'); videodesk.type = 'text/javascript'; videodesk.async = true;
		videodesk.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'module-videodesk.com/js/videodesk.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(videodesk, s);
		})();
		</script>--}}
		@yield('custom-scripts')
</body>
</html>
