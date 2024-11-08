@extends('layouts.frontend.master')

@section("title")
www.monassurance.ci :: Pourquoi monassurance.ci
@endsection  

@section("custom-styles")
<link rel="stylesheet" type="text/css" href="{{asset('css/print.css')}}">
<link rel="stylesheet" href="{{asset('css/custom.css')}}">
<style type="text/css">
	.different-services{
		background:url('/images/parallax/girl-auto-bg.jpg') no-repeat center top;
	}
</style>
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
			<h2>Pourquoi monassurance.ci</h2>
			<ul class="breadcrumbs">
				<li><a href="/">Accueil</a></li>
				<li>Pourquoi monassurance.ci</li>
			</ul>
		</div>
	</div>
</section>
<!-- DIFFERENT SERVICES -->
<section class="different-services text-center parallax" style="margin-top:30px;">
	<div class="container">
		<div class="heading animate bounceIn">
			<h1 class="color-white">06 Bonnes raisons de choisir monassurance.ci</h1>
			<p class="color-white">Premier comparateur d’assurance  en Côte  d’Ivoire, monassurance.ci vous permet  de choisir librement votre assurance en comparant plusieurs offres afin de faire des économies et gagner du temps.</p>
		</div>
	</div>
</section><!-- / DIFFERENT SERVICES -->

<section class="serv padding-top-100 padding-bottom-100">
  <div class="container"> 
    <div class="serv-welcome text-center">
      <ul class="row">
        
        <!-- serv -->
        <li class="col-md-6 nopuce">
          <article class="z-depth-1">
            <div class="icon"> <i class="">1</i> </div>
            <h5 class="margin-top-30 margin-bottom-10" >Monassurance.ci,  premier comparateur  d’assurance en Côte d’ivoire </h5>
            <p>
            Avec monassurance.ci, vous avez désormais la possibilité d’effectuer des simulations de devis de plusieurs compagnies d’assurance et choisir l’offre qui vous convient le mieux.<br/><br/>
             </p>
        </li>
        
        <!-- serv -->
        <li class="col-md-6 nopuce">
          <article class="z-depth-1">
            <div class="icon"> <i class="">2</i> </div>
            <h5 class="margin-top-30 margin-bottom-10">Monassurance.ci vous fait gagner du temps.</h5>
            <p>Avec monassurance.ci, plus besoin de vous déplacer physiquement chez votre courtier ou en compagnie, gagnez du temps en vous connectant sur www.monassurance.ci votre courtier en ligne et obtenez votre devis en seulement quelques minutes.  </p>
            </article>
        </li>
      </ul>

      <ul class="row" style="margin-top:15px">
        
        <!-- serv -->
        <li class="col-md-6 nopuce">
          <article class="z-depth-1">
            <div class="icon"> <i class="">3</i> </div>
            <h5 class="margin-top-30 margin-bottom-10" >Monassurance.ci  vous  permet  de  réaliser des économies </h5>
            <p>Avec monassurance.ci, vous pouvez réaliser des économies de temps et d’argent en comparant plusieurs offres d’assurances à garantie égale et choisir celle qui correspond à votre budget tout en vous offrant un meilleur rapport qualité/prix.
             </p>
        </li>
        
        <!-- serv -->
        <li class="col-md-6 nopuce">
          <article class="z-depth-1">
            <div class="icon"> <i class="">4</i> </div>
            <h5 class="margin-top-30 margin-bottom-10">Monassurance.ci vous livre votre assurance</h5>
            <p>Avec monassurance.ci, votre assurance vous trouve partout où que vous soyez à Abidjan, 7jr/7 même les jours fériés et réglez à la livraison.<br/>  <br/><br/>  </p>
            </article>
        </li>
      </ul>

      <ul class="row" style="margin-top:15px">
        
        <!-- serv -->
        <li class="col-md-6 nopuce">
          <article class="z-depth-1">
            <div class="icon"> <i class="">5</i> </div>
            <h5 class="margin-top-30 margin-bottom-10" >Monassurance.ci  l’ami qui vous assiste tout le long de votre parcours</h5>
            <p>Avec monassurrance.ci, bénéficiez de l’assistance de nos conseillers en ligne 7jr/7 pour répondre à vos préoccupations et vous accompagner tout le long de votre parcours.</p>
			<p>- En cas de sinistre, déclarer votre sinistre directement en ligne ou appelez le 220 170 00, nos conseillers vous ferons parvenir des agents facilitateurs pour vous aider dans la gestion de votre sinistre.</p>
			<p>- Votre véhicule est dans un état critique ? grâce à notre large réseau de garagistes et de remorqueurs, votre véhicule sera déplacé dans les minutes qui suivent vers le garage partenaire le plus proche.</p>
			<p>- Avec monassurance.ci, plus qu’un client, votre êtes un ami. Recevez chaque semaine des conseils et astuces qui vous permettront de mieux gérer votre assurance et réduire le risque d’incident.</p>
        </li>
        
        <!-- serv -->
        <li class="col-md-6 nopuce">
          <article class="z-depth-1">
            <div class="icon"> <i class="">6</i> </div>
            <h5 class="margin-top-30 margin-bottom-10">Monassurance.ci vous livre votre assurance</h5>
            <p>Monassurance.ci  est une plateforme fiable et sécurisée qui vous permet d’effectuer votre devis sans risque de perdre vos données. Grace à nos valeurs qui allient professionnalisme, respect et rigueurs, nos plateformes sont développées par des experts du métier de l’assurance et des nouvelles technologies suivant les normes  standard internationaux ISO.<br/>  <br/><br/><br/>  <br/><br/> <br/><br/>  </p>
            </article>
        </li>
      </ul>
    </div>
  </div>
</section>


	

@endsection