@extends('layouts.frontend.master')

@section("title")
www.monassurance.ci :: Rechercher un sinistre
@endsection 

@section("custom-styles")



@endsection 

@section("custom-scripts")
<script type="text/javascript">
			$(document).ready(function() {
				$("#num_devis").mask("ARO/99999999/9999");
			})
		</script>
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
              	<input type="text" required data-delay="300" placeholder="JJ/MM/AAAA" name="sin_date" id="sin_date" class="input date datepicker" >
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

@section('content')

<section class="subpage-header">
	<div class="container">
		<div class="site-title clearfix">
			<h2>Automobile</h2>
			<ul class="breadcrumbs">
				<li><a href="/">Accueil</a></li>
				<li>Rechercher un sinistre</li>
			</ul>
		</div>
		<a href="javascript;" data-toggle="modal" data-target="#new-sinistre" class="btn btn-primary get-in-touch" data-text="Déclarer votre sinistre"><i class="fa fa-file-o"></i>Déclarer votre sinistre</a>
	</div>
</section>


<!-- WHO IS BEHIND -->
			@if($hasSinistre)
			<section class="bg-blue">
				<div class="container">
					@if(session()->has('success'))
					    <div class="text-center">
					        <div class="alert alert-success alert-dismissable">
					        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					            <h4>{{session()->get('success')}}</h4>
					        </div>
					    </div>
					@endif

					<table class="table table-hover table-striped">
						<thead>
							<th>#</th>
							<th>N° Police</th>
							<th>Date du sinistre</th>
							<th>Status</th>
							<th>Décision</th>
						</thead>
						<tbody>
							<tr>
								<td>{{ $sinistre->sin_number }}</td>
								<td>{{ $sinistre->client_policy_number }}</td>
								<td>{{ date('d/m/Y', strtotime($sinistre->date_sinistre)) }}</td>
								<td>{!! get_sinistre_status($sinistre->sin_status) !!}</td>
								<td>{!! get_sinistre_decision($sinistre->decision_sin) !!}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</section><!-- / WHO IS BEHIND -->
			@else
            <section class="bg-blue">
				<div class="container">
					@if(Session::has('error'))
					    <div class="text-center">
					        <div class="alert alert-danger alert-dismissable">
					        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					            <h4>{{Session::get('error')}}</h4>
					        </div>
					    </div>
					@endif

					<form method="post"  action="{{route('submit.search.sinistre')}}">
					{{csrf_field()}}
					  <div class="col-md-8">
					    <div class="form-group">
					    <label class="control-label">Numéro de sinistre</label>
					    <input type="text" required class="form-control" name="num_sinistre" id="num_sinistre" placeholder="Entrer votre numéro de sinistre">
					  </div> 
					  </div>
					  <div class="col-md-4"> 
					  <br>
					  <button type="submit" data-text="Rechercher" class="btn btn-primary get-in-touch"> <i class="fa fa-search"></i>Rechercher</button></div>
					</form>
				</div>
			</section><!-- / WHO IS BEHIND -->
			@endif
	

@endsection