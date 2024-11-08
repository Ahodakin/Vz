@extends('layouts.frontend.master')

@section("title")
www.monassurance.ci :: Comment comparer sur monassurance.ci
@endsection  

@section("custom-styles")
<link rel="stylesheet" type="text/css" href="{{asset('css/print.css')}}">
<link rel="stylesheet" href="{{asset('css/custom.css')}}">
@endsection 

@section("custom-scripts")
<script src="{{asset('js/cleave.js/dist/cleave.min.js')}}"></script>
<script src="{{asset('js/cleave.js/dist/addons/cleave-phone.ci.js')}}"></script>
<script type="text/javascript">

</script>


@endsection 

@section('content')
<!-- Modal -->

<section class="subpage-header">
	<div class="container">
		<div class="site-title clearfix">
			<h2>Comment comparer?</h2>
			<ul class="breadcrumbs">
				<li><a href="/">Accueil</a></li>
				<li>comment comparer</li>
			</ul>
		</div>
    <a href="{{route('page.quote.auto')}}" class="btn btn-default get-in-touch" data-text="Comparer dévis Auto"><i class="fa fa-plus"></i>Comparer dévis Auto</a>
	</div>
</section>
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-6 animate fadeInLeft">
				<h2>Comparer simplement</h2>
				<div class="height-10"></div>
				<p>Il n’est désormais plus nécessaire de faire le tour des maisons et intermédiaires d’assurance pour trouver une bonne couverture auto. Monassurance.ci vous donne la possibilité de générer plusieurs devis d’assureurs en ligne, de comparer, de choisir l’offre qui vous convient et de souscrire immédiatement.</p>
				<p>Avant de souscrire à un contrat d’assurance auto, il est indispensable de pouvoir comparer plusieurs devis d’assurance. Pour faciliter la recherche d’une couverture au meilleur prix qui soit adaptée à votre véhicule, Monassurance.ci vous permet de comparer un panel de devis directement en ligne.</p>
				<p>La comparaison passe par le remplissage d’un formulaire et certaines informations sont requises :</p>
			</div>
			<div class="col-md-6 animate fadeInRight">
				<div class="image-widget">
					<img src="/images/about-img1.jpg" class="img-shadow" alt="">
				</div>
			</div>
		</div>
		<div class="row" style="margin-top:25px">
			<div class="col-md-6 animate fadeInLeft">
				<div class="image-widget">
					<img src="/images/car-on-hand.jpg" class="img-shadow" alt="">
				</div>
			</div>
			<div class="col-md-6 animate fadeInRight">
				<h2>L'assurance</h2>
				<div class="height-10"></div>
				<p>Vous devez choisir la formule d’assurance souhaitée et la période du contrat. Vous avez la possibilité de choisir une assurance de préférence qui vous sera présenté en premier choix. Cependant les autres devis sont disponibles pour des éventuelles comparaisons afin de vous aider à la prise de décision.</p>
				<p>Une gamme de formules de couverture vous ai présenté allant du minimum obligatoire à souscrire, l’assurance tiers simple jusqu’à une couverture la plus complète – l’assurance tous risques. Le choix de formule dépend principalement de l’usage et de l’âge du véhicule et du budget de l’assuré. <a href="#">Plus de détails sur les formules de couvertures</a></p>
			</div>
		</div>
		<div class="row" style="margin-top:25px">
			
			<div class="col-md-6 animate fadeInLeft">
				<h2>Profil de l'assuré</h2>
				<div class="height-10"></div>
				<p>vous devez renseigner les informations relatives à votre personne. Si votre nom et prénom ne sont pas ceux figurant sur la carte grise, vous devez renseigner les bonnes informations dans les champs dédiés. Ces informations serviront à vous identifier et à éditer votre police et l’attestation d’assurance.</p>
				<h2>Services à valeurs ajoutés</h2>
				<div class="height-10"></div>
				<p>Monassurance.ci vous propose des services supplémentaires qui vous faciliterons la vie. Ces services sont optionnels et comprennent le remorquage dans les meilleurs délais en cas de panne et un service d’assistance urgente pour tout problème.</p>
			</div>
			<div class="col-md-6 animate fadeInRight">
				<div class="image-widget">
					<img src="/images/man-black.jpg" class="img-shadow" alt="">
				</div>
			</div>
		</div>
		<div class="row" style="margin-top:25px">
			<div class="col-md-6 animate fadeInLeft">
				<div class="image-widget">
					<img src="/images/girl-in-car.jpg" class="img-shadow" alt="">
				</div>
			</div>
			<div class="col-md-6 animate fadeInRight">
				<h2>Choisir l’offre qui vous convient</h2>
				<div class="height-10"></div>
				<p>Une fois le formulaire renseigné dans sa totalité et après validation, vous accédez à la page de résultats des différents devis générés. Cette page présente le devis le plus moins cher et l’ensemble des devis correspondant à votre profil parmi les offres des assureurs présents sur le panel de monassurance.ci</p>
				<p>Les devis générés sur la page de comparaison présentent les tarifs et garanties de chaque offre de manière simple pour vous aider à trouver le contrat qui vous correspond le mieux. Vous pouvez aussi accéder aux détails de chaque devis.</p>
				<p><i>Il est conseillé de remplir au plus juste le formulaire pour obtenir des offres adaptées, mais également car ces renseignements seront directement utilisé pour l’établissement de votre assurance en cas de souscription</i></p>
			</div>
		</div>

		<div class="row" style="margin-top:25px">
			
			<div class="col-md-6 animate fadeInRight">
				<h2>Souscrivez à votre assurance</h2>
				<div class="height-10"></div>
				<p>Une fois le choix de la police d’assurance effectué, vous pouvez confirmer celui-ci avec votre numéro de téléphone et la situation géographique à laquelle vous souhaitez vous faire livrer. Un SMS de confirmation vous est envoyé dans les secondes qui suivre votre souscription et vous serez contacter à la suite par nos conseillers clients.</p>
			</div>
			<div class="col-md-6 animate fadeInLeft">
				<div class="image-widget">
					<img src="/images/yoopi-girl.jpg" class="img-shadow" alt="">
				</div>
			</div>
		</div>
	</div>
</section>


	

@endsection