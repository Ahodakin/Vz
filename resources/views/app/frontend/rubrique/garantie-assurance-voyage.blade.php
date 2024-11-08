@extends('layouts.frontend.master')

@section("title")
www.monassurance.ci :: Couverture assurance voyage
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
			<h2>La couverture assurance voyage</h2>
			<ul class="breadcrumbs">
				<li><a href="/">Accueil</a></li>
				<li>Assurance voyage</li>
			</ul>
		</div>
    <a href="{{route('page.quote.voyage')}}" class="btn btn-default get-in-touch" data-text="Comparer dévis voyage"><i class="fa fa-plus"></i>Comparer dévis voyage</a>
	</div>
</section>

<section class="bg-blue">
				<div class="container">
					<div class="row">
						<div class="col-md-6 animate fadeInLeft">
							<ul class="image-list-classic">
								<li><img src="/images/gagner-du-temps.png" alt=""></li>
								<li><img src="/images/visuel_voyage.png" alt=""></li>
							</ul>
						</div>
						<div class="col-md-6 animate fadeInRight">
							<h3>Que peut couvrir l'assurances voyages?</h3>
							<p>L’ASSURANCE VOYAGE, par définition compte avec un ensemble de garanties pour vous couvrir des conséquences des incidents qui peuvent survenir pendant vos voyages, déplacements et séjours à l’étranger. </p>
							
							
							<div id="accordion" role="tablist" aria-multiselectable="true">
								<div class="toggle">
									<div class="toggle-heading" role="tab">
										<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="collapsed">
										  <i class="fa fa-plus"></i> Les Garanties offertes
										</a>
									</div>
									<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
										<div class="toggle-body" style="padding:30px">
											<p>
												1.Frais médicaux suite à une maladie ou un accident<br/>
												2.Présence auprès de l’assuré hospitalisé<br/>
												3.Transport ou rapatriement en cas de maladie ou accident<br/>
												4.Rapatriement et transport du corps de l’assuré décédé<br/>
												5.Accompagnement de la dépouille mortelle<br/>
												6.Retour prématuré au domicile suite au décès d’un proche
											</p>
											<p style="font-weight:bold">Les garanties ci-dessus sont celles que l’on retrouve le plus souvent dans une assurance voyage, mais il existe aussi des garanties spéciales pour des situations particulières. </p>

										</div>
									</div>
								</div>
								<div class="toggle">
									<div class="toggle-heading" role="tab">
										<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseOne" class="">
										  <i class="fa fa-plus"></i>L'importance d'être couvert par une assurance voyage
										</a>
									</div>
									<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-expanded="false" style="height: 0px;">
										<div class="toggle-body" style="padding:30px">
											<p>
												<ul>						
													<li>Une maladie dans un village perdu d’Asie centrale,</li>
													<li>Des bagages égarés dans un aéroport à l’autre bout du monde,</li>
													<li>Le malheureux décès d’un membre de la famille proche dans votre pays d’origine,</li>
													<li>Un accident dans un magasin de luxe qui entraine des dommages matériels,</li>
												</ul>
											</p>
											<p style="font-weight:bold">Et tant d’autres situations, dans lesquelles on se rassure en pensant à l’assurance voyage que l’on a souscrite avant de partir !
											En effet, dès qu’on quitte son pays pour un voyage, c’est toujours une bonne idée de souscrire une assurance voyage qui garantisse une éventuelle une urgence médicale, un rapatriement sanitaire, bref tout ce qui, à l’étranger, devient vite un sujet d’inquiétude.
											 </p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					
				</div>
			</section>




	

@endsection