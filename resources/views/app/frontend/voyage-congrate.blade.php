@extends('layouts.frontend.master')

@section("title")
monassurance.ci :: Félicitation | Soyez rassurer, tout est géré.
@endsection 

@section("custom-styles")
<style type="text/css">
	.different-services{
		background:url('/images/parallax/voyage-bg.jpg') no-repeat center top;
		    padding-top: 60px;
	}
</style>
@endsection 

@section("custom-scripts")


<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function(){
		Typed.new(".element", {
			strings: ["<span style='color:#047f19'>Félicitation</span>,  <span class='color-default'><?= $prospect->firstname ?></span>", "<span style='color:#047f19'>Merci</span> d'avoir utilisé <span class='color-default'>mon<span style='color:#e6342a'>assurance</span>.ci</span>", "<span style='color:#047f19'>A bientôt !</span>"],
			typeSpeed: 10

		});
	});
</script>
@endsection 

@section('content')

<section class="subpage-header">
	<div class="container">
		<div class="site-title clearfix">
			<h2>Commande</h2>
			<ul class="breadcrumbs">
				<li><a href="/">Accueil</a></li>
				<li>commande</li>
			</ul>
		</div>
		{{--<a href="/login" class="btn btn-primary get-in-touch" data-text="Connectez-vous"><i class="fa fa-user"></i>Connectez-vous</a>--}}
	</div>
</section>
<!-- DIFFERENT SERVICES -->
<section class="different-services text-center parallax" style="margin-top:30px;">
	<div class="container">
		<div class="heading animate bounceIn">
			<h2 class="element"></h2>
			<br>
			<p>votre commande à été enregistré avec succès. Un conseiller client vous contactera pour la confirmation de votre commande</p>
			<br>
			<br>
			<br>
			<br>
			<br>
			{{--<a href="/register" class="btn btn-primary get-in-touch" data-text="Connectez-vous"><i class="fa fa-user"></i>Connectez-vous</a>--}}
		</div>
	</div>
</section><!-- / DIFFERENT SERVICES -->


	

@endsection