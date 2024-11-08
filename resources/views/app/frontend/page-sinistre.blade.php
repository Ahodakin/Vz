@extends('layouts.frontend.master')

@section("title")
www.monassurance.ci :: Déclarer vos sinistres
@endsection 

@section("custom-styles")
<style type="text/css">
    
    .video-sinitre {
        border: solid 1px;
        width: 100%;
        height: 310px;
        margin-top: 15px;
        border-color: #EBECED;
    }
</style>

@endsection 

@section("custom-scripts")

@endsection 

@section('content')

<section class="subpage-header">
	<div class="container">
		<div class="site-title clearfix">
			<h2>Sinistres</h2>
			<ul class="breadcrumbs">
				<li><a href="/">Accueil</a></li>
				<li>sinistres</li>
			</ul>
		</div>
		<a href="javascript:;" data-toggle="modal" data-target="#new-sinistre" class="btn btn-primary get-in-touch" data-text="Déclarer un sinitre"><i class="fa fa-file-o"></i>Déclarer un sinitre</a>
		
	</div>
</section>
@if(session()->has('success'))
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-success alert-dismissable">{{session()->get('success')}}</div>
		</div>
	</div>
	@endif
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-6 animate fadeInLeft">
				<h3>Comment déclarer un sinistre à l’assurance auto ?</h3>
				<div class="height-10"></div>
				<p>Le sinistre est un événement malheureux qui peut se rapporter à un accident (incendie, accident de circulation, dégâts des eaux, etc.), Un vol ou un cambriolage… Déclarez votre sinistre sur Monassurance.ci</p>
			</div>
			<div class="col-md-6 animate fadeInRight">
				<div class="image-widget">

					<img src="/images/man-sinistre.jpg" alt="Declarer vos sinistres">
				</div>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="container">
		<div class="row">
			<div class="col-md-6 animate fadeInLeft">
				<div class="image-widget">
					<img src="images/sinistre2.jpg" class="img-shadow" alt="">
				</div>
			</div>
			<div class="col-md-6 animate fadeInRight">
				<h3>Que faire en cas de sinsitres</h3>
				<p>En cas de sinistre, il est important que l’assuré contacte son assureur par téléphone pour l’en informer. Il peut également lui demander conseil concernant les démarches à réaliser pour bénéficier de la meilleure indemnisation. </p>
				
				<h5>Documents à fournir</h5>
				
				<div id="accordion" role="tablist" aria-multiselectable="true">
					<div class="toggle">
						<div class="toggle-heading" role="tab">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							  <i class="fa fa-plus"></i> Le constat amiable
							</a>
						</div>
						<div id="collapseOne" class="panel-collapse collapse" role="tabpanel">
							<div class="toggle-body">
								<p>Le constat amiable contient les informations et circonstances du sinistre. Il permet de déterminer la responsabilité de personnes impliquées.</p>
							</div>
						</div>
					</div>
					<div class="toggle" >
						<div class="toggle-heading" role="tab">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseOne">
							  <i class="fa fa-plus"></i> La lettre de déclaration
							</a>
						</div>
						<div id="collapseThree" class="panel-collapse collapse" role="tabpanel">
							<div class="toggle-body">
								<p>La lettre de déclaration détaille les circonstances du sinistre et fait part de la demande d’indemnisation.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="container">
		<div class="row">
			<div class="col-md-7 animate fadeInLeft">
				<h3>Qu’est-ce qu’un sinistre ?</h3>
				<div class="height-10"></div>
				<p>Le sinistre est un événement malheureux qui peut se rapporter à :</p>
				<ul>
					<li>Un accident (incendie, accident de circulation, dégâts des eaux, etc.)</li>
					<li>Un vol ou un cambriolage</li>
				</ul>
				<p>Les contrats d’assurance souscrits auprès d'une compagnie d'assurance distinguent deux types de sinistres :</p>
			</div>
			<div class="col-md-5 animate fadeInRight">
				<div class="image-widget">

					<img src="/images/sinistre-auto.jpg" alt="Declarer vos sinistres">
				</div>
			</div>
		</div>
		<div class="row">
			<p>1-	Les sinistres dont l'assuré est victime et pour lesquels il devra réclamer une indemnisation</p>
			<p>2-	Les sinistres dont l'assuré est responsable et pour lesquels son assurance se chargera d'indemniser les dommages.</p>
			<p>Les garanties d'un contrat d'assurance concernent tous les biens que souhaite couvrir l'assuré et auxquels ont été affectés des évènements garantis par l'accord. L'article 31 du code des Assurances CIMA (Conférence Interafricaine des Marchés d’Assurance) régit les dommages et les sinistres. Il stipule que l'assurance concernant un bien donné s'inscrit dans le « principe indemnitaire » qui signifie qu'après un sinistre, l’indemnité due par l’assureur à l’assuré ne peut pas être supérieure au montant de la valeur du bien assuré au jour du sinistre. </p>
			<h3>Déclarer votre sinistre sur monassurance.ci</h3>
			<p>Vous êtes client de monassurance.ci, déclarez votre sinistre sur notre plateforme. Rendez-vous sur l’onglet « sinistre », remplissez le formulaire dédié et faites votre déclaration en ligne. Votre déclaration devrait se faire dans les moindres détails expliquant les circonstances du sinistre. 
Après validation du formulaire, vous recevrez un code de suivi et vous serez contactez par l’un de nos conseiller client pour la suite.
</p>
		<h3>Suivez le traitement de votre sinistre sur monassurance.ci</h3>
		<p>Avec Monassurance.ci, vous avez la possibilité de suivre l’évolution du traitement  de votre sinistre. Le code de suivi généré à la suite de la déclaration de votre sinistre sur notre plateforme à suivre votre dossier en ligne.</p>

		</div>
	</div>
</section>

<!-- Modal -->
<div class="modal fade" id="new-sinistre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Déclarer un sinitre</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="help-widget">
              <h5>Besoin d'aide ?</h5>
              <p>Faite vous appellez dans un delais d'une heure par l'un de nos conseillés clients.</p>
              <a href="#" class="btn btn-primary btn-white get-in-touch" data-text="FAQ"><i class="fa fa-question"></i>FAQ</a>
            </div>
            
            <a href="#." class="company-presentation-link" style="color:#fff"><i class="fa fa-phone"></i> ou appelez au (+225) 220 170 00</a>
          </div>
          <div class="col-md-6">
            <div class="form">
              
              <form  method="post" action="{{route('new.sinistre')}}">
              	{{csrf_field()}}
              	<input type="text" required data-delay="300" placeholder="Votre nom" name="sin_name" id="sin_name" class="input" >
              	<input type="text" required data-delay="300" placeholder="Votre numéro de téléphone" name="sin_phone" id="sin_phone" class="input phone" >
              	<input type="text" required data-delay="300" placeholder="Numéro de votre police d'assurance" name="sin_police" id="sin_police" class="input" >
              	<input type="text" required data-delay="300" placeholder="Date du sinistre (JJ/MM/AAAA)" name="sin_date" id="sin_date" class="input date datepicker" >
              	<textarea class="form-control" required name="sin_decla" id="sin_decla" rows="3" placeholder="Votre déclaration"></textarea>
              	<button class="btn btn-primary" name="sin" type="submit" data-text="Valider" onClick="">Valider</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-text="Quitter" data-dismiss="modal">Quitter</button>
    </div>
  </div>
</div>

@endsection