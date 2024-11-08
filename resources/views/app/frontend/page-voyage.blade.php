@extends('layouts.frontend.master')

@section("title")
www.monassurance.ci :: Votre assurance voyage
@endsection 

@section("custom-styles")

@endsection 

@section("custom-scripts")
<style type="text/css">
	.different-services{
		background:url('images/parallax/voyage-bg.jpg') no-repeat center top;
	}
</style>
@endsection 

@section('content')

<section class="subpage-header">
	<div class="container">
		<div class="site-title clearfix">
			<h2>Voyage</h2>
			<ul class="breadcrumbs">
				<li><a href="/">Accueil</a></li>
				<li>voyage</li>
			</ul>
		</div>
		<a href="{{ route('page.quote.voyage') }}" class="btn btn-primary get-in-touch" data-text="Comparer dévis"><i class="fa fa-file-o"></i>Comparer dévis</a>
	</div>
</section>

<!-- DIFFERENT SERVICES -->
<section class="different-services text-center parallax" style="margin-top:30px;">
	<div class="container">
		<div class="heading animate bounceIn">
			<h2 class="color-white">LA MEILLEURE ASSURANCE VOYAGE AU MEILLEUR PRIX.</h2>

			<br>
			<br>
			<a href="{{ route('page.quote.voyage') }}" class="btn btn-primary get-in-touch" data-text="Comparer"><i class="fa fa-file-o"></i>Comparer</a>
		</div>
	</div>
</section><!-- / DIFFERENT SERVICES -->

<!-- WHO IS BEHIND -->
            <section class="bg-blue">
				<div class="container">
					<div class="services text-center">
						<div class="three-items-carousel owl-carousel">
							<div class="service-box">
								<i class="fa fa-question 3x"></i>
								<h4>Devis d'assurances voyage</h4>
								<p>Evitez les mauvaises surprises en souscrivant une assurance voyage!</p>
								<a href="{{ route('page.quote.voyage') }}" class="btn-link">En savoir plus</a>
							</div>
							<div class="service-box">
								<i class="icon-img-6"></i>
								<h4>Les garanties de l’assurance voyage</h4>
								<p>En souscrivant à un contrat d’assurance, votre assureur s’engage à vous protéger.</p>
								<a href="{{ route('rubrique.travel.insurance') }}" class="btn-link">En savoir plus</a>
							</div>
							<div class="service-box">
								<i class="icon-img-9"></i>
								<h4>Souscrire par téléphone</h4>
								<p>Avec Monassurance.ci, vous avez la possibilité de souscrire par téléphone à une assurance voyage.</p>
								<a href="#" class="btn-link">En savoir plus</a>
							</div>
							
						</div>
					</div>
				</div>
			</section><!-- / WHO IS BEHIND -->
	

@endsection