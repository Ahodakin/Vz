@extends('layouts.frontend.master')

@section("title")
www.monassurance.ci :: Votre Assurance Habitation 
@endsection 

@section("custom-styles")

@endsection 

@section("custom-scripts")
<style type="text/css">
	.different-services{
		background:url('images/parallax/home-bg.jpg') no-repeat center top;
	}
</style>
@endsection 

@section('content')

<section class="subpage-header">
	<div class="container">
		<div class="site-title clearfix">
			<h2>Habitation</h2>
			<ul class="breadcrumbs">
				<li><a href="/">Accueil</a></li>
				<li>Habitation</li>
			</ul>
		</div>
		<a href="" class="btn btn-primary get-in-touch" data-text="Demander un dévis"><i class="fa fa-file-o"></i>Demander un dévis</a>
	</div>
</section>

<!-- DIFFERENT SERVICES -->
<section class="different-services text-center parallax" style="margin-top:30px;">
	<div class="container">
		<div class="heading animate bounceIn">
			<br>
			<br>
			<br>
			<br>
			<a href="" class="btn btn-primary get-in-touch" data-text="Demander un dévis"><i class="fa fa-file-o"></i>Demander un dévis</a>
		</div>
	</div>
</section><!-- / DIFFERENT SERVICES -->

<!-- WHO IS BEHIND -->
            <section class="bg-blue">
				<div class="container">
					<div class="services text-center">
						<div class="three-items-carousel owl-carousel">
							<div class="service-box">
								<i class="icon-img-1"></i>
								<h4>Les garanties</h4>
								<p>Lorem ipsum dolor sit amet, Let it it floats back to you.</p>
								<a href="news-detail.html" class="btn-link">En savoir plus</a>
							</div>
							<div class="service-box">
								<i class="icon-img-6"></i>
								<h4>Declarer sinistre</h4>
								<p>Lorem ipsum dolor sit amet, Let it it floats back to you.</p>
								<a href="news-detail.html" class="btn-link">En savoir plus</a>
							</div>
							<div class="service-box">
								<i class="icon-img-9"></i>
								<h4>Souscrire par téléphone</h4>
								<p>Lorem ipsum dolor sit amet, Let it it floats back to you.</p>
								<a href="news-detail.html" class="btn-link">En savoir plus</a>
							</div>
						</div>
					</div>
				</div>
			</section><!-- / WHO IS BEHIND -->
	

@endsection