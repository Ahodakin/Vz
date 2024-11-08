@extends('layouts.frontend.master')

@section("title")
www.monassurance.ci ::  Félicitation | Soyez rassurés, tout est géré.
@endsection 

@section("custom-styles")
<style type="text/css">
	.different-services{
		background:url('/images/main-banner/1/1.jpg') no-repeat center top;
		    padding-top: 60px;
	}
</style>
@endsection 

@section("custom-scripts")


<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function(){
		Typed.new(".element", {
			strings: ["<span style='color:#047f19'>Félicitation</span>,  <span class='color-default'><?= $prospect->firstname ?></span>", "<span style='color:#047f19'>Merci</span> <span style='color:#fff'>d'avoir utilisé<span> <span class='color-default'>mon<span style='color:#e6342a'>assurance.ci</span></span>", "<span style='color:#047f19'>A bientôt !</span>"],
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
		{{--<a href="/register" class="btn btn-primary get-in-touch" data-text="Créer un espace personnel"><i class="fa fa-user"></i>Créer un espace personnel</a>--}}
	</div>
</section>
<!-- DIFFERENT SERVICES -->
<section class="different-services text-center parallax" style="margin-top:30px;">
	<div class="container">
		<div class="heading animate bounceIn">
			<h2 class="element"></h2>
			<br>
			<p style="color:#fff;margin-top:80px;font-size:25px">Votre commande à été enregistré avec succès. Un conseiller client vous contactera pour la confirmation de votre commande</p>
			<br>
			<br>
			<br>
			<br>
			<br>
			{{--<a href="/register" class="btn btn-primary get-in-touch" data-text="Mon espace personnel"><i class="fa fa-user"></i>Mon espace personnel</a>--}}
		</div>
	</div>
</section><!-- / DIFFERENT SERVICES -->


	

@endsection