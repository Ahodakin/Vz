@extends('layouts.frontend.master')

@section("title")
www.monassurance.ci :: Comparer vos dévis d'assurance Moto 
@endsection 

@section("custom-styles")

@endsection 

@section("custom-scripts")
<style type="text/css">
	.different-services{
		background:url('images/parallax/moto-bg.jpg') no-repeat center top;
	}
</style>
@endsection 

@section('content')

<section class="subpage-header">
	<div class="container">
		<div class="site-title clearfix">
			<h2>Moto</h2>
			<ul class="breadcrumbs">
				<li><a href="/">Accueil</a></li>
				<li>Moto</li>
			</ul>
		</div>
		<a href="{{route('page.quote.moto')}}" class="btn btn-primary get-in-touch" data-text="Comparer dévis"><i class="fa fa-file-o"></i>Comparer dévis</a>
	</div>
</section>

<!-- DIFFERENT SERVICES -->
<section class="different-services text-center parallax" style="margin-top:30px;">
	<div class="container">
		<div class="heading animate bounceIn">
			<h2 class="color-white">Comparez plusieurs assureurs moto en 1 clique</h2>
			<br>
			<a href="{{route('page.quote.moto')}}" class="btn btn-primary get-in-touch" data-text="Comparer"><i class="fa fa-file-o"></i>Comparer</a>
		</div>
	</div>
</section><!-- / DIFFERENT SERVICES -->

<!-- WHO IS BEHIND -->
            <section class="bg-blue">
				<div class="container">
					<div class="services text-center">
						<div class="three-items-carousel owl-carousel">
							<div class="service-box">
								<i class="fa fa-phone 3x"></i>
								<h4>Souscrire par téléphone</h4>
								<p>Avec Monassurance.ci, vous avez la possibilité de souscrire par téléphone.</p>
								<a href="#" class="btn-link">En savoir plus</a>
							</div>
							<div class="service-box">
								<i class="fa fa-info"></i>
								<h4>Infos nécessaires</h4>
								<p>Certaines informations sont nécessaires pour votre souscription par téléphone.</p>
								<a href="#" class="btn-link">En savoir plus</a>
							</div>
							<div class="service-box">
								<i class="icon-img-2"></i>
								<h4>Les garanties</h4>
								<p>En souscrivant à un contrat d’assurance, votre assureur s’engage à vous protéger.</p>
								<a href="#" class="btn-link">En savoir plus</a>
							</div>
							<div class="service-box">
								<i class="icon-img-6"></i>
								<h4>Declarer un sinistre</h4>
								<p>Déclarer votre sinistre en quelques clique sur www.monassurance.ci</p>
								<a href="#" class="btn-link">En savoir plus</a>
							</div>
							
							
						</div>
					</div>
				</div>
			</section><!-- / WHO IS BEHIND -->
	

@endsection