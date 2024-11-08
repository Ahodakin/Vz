@extends('layouts.frontend.master')

@section("title")
www.monassurance.ci ::  Soyez rassurés, tout est géré.
@endsection

@section("custom-styles")
<link rel="stylesheet" href="{{asset('css/image-picker/image-picker.css')}}">
<link rel="stylesheet" href="{{asset('css/custom.css')}}">
<link rel="stylesheet" href="<?php echo asset('js/gallery/css/blueimp-gallery.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('js/datatables/css/jquery.dataTables.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('js/datatables/datatables.bootstrap.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('js/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('js/datatables/extensions/Responsive/css/dataTables.responsive.css')?>">
<link rel="stylesheet" href="<?php echo asset('js/datatables/extensions/ColVis/css/dataTables.colVis.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('js/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')?>">
<style type="text/css">

</style>
@endsection

@section("custom-scripts")
<script src="<?php echo asset('js/gallery/js/blueimp-gallery.min.js'); ?>"></script>
<script>
            $(window).load(function(){
                document.getElementById('links').onclick = function (event) {
                    event = event || window.event;
                    var target = event.target || event.srcElement,
                        link = target.src ? target.parentNode : target,
                        options = {index: link, event: event},
                        links = this.getElementsByTagName('a');
                    blueimp.Gallery(links, options);
                };

            });
        </script>
<div class="modal fade" id="renew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Renouveller sa police d'assurance</h5>
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

          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-text="Quitter" data-dismiss="modal">Quitter</button>
    </div>
  </div>
</div>
<script type="text/javascript" src="{{asset('css/image-picker/image-picker.min.js')}}"></script>
<script src="<?php echo asset('js/datatables/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo asset('js/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js'); ?>"></script>
<script src="<?php echo asset('js/datatables/extensions/Responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo asset('js/datatables/extensions/ColVis/js/dataTables.colVis.min.js'); ?>"></script>
<script src="<?php echo asset('js/datatables/extensions/TableTools/js/dataTables.tableTools.min.js'); ?>"></script>
<script>
	$(document).ready(function() {

	$("#phone").mask("99 99 99 99 99");
	$('.datepicker_newreleasedate').datetimepicker({
    format: 'DD/MM/YYYY'
    });

});
	$(".image-picker").imagepicker({
		show_label  : true,
		selected :  function (select) {
			console.log(this.val())

		}

	})

	$("#menu_contrat").click(function (e) {
		event.preventDefault();
		$(".space_main").removeClass("active")
		$("#menu_contrat").addClass("active")
		$("#content_contrat").show()
		$("#content_renouveler").hide()
		$("#content_compte").hide()
		$("#content_sinistre").hide()
		$("#content_plan").hide()
	})

	$("#menu_renouveler").click(function (e) {
		event.preventDefault();
		$(".space_main").removeClass("active")
		$("#menu_renouveler").addClass("active")
		$("#content_renouveler").show()
		$("#content_contrat").hide()
		$("#content_compte").hide()
		$("#content_sinistre").hide()
		$("#content_plan").hide()
	})

	$("#menu_compte").click(function (e) {
		event.preventDefault();
		$(".space_main").removeClass("active")
		$("#menu_compte").addClass("active")
		$("#content_compte").show()
		$("#content_renouveler").hide()
		$("#content_contrat").hide()
		$("#content_sinistre").hide()
		$("#content_plan").hide()
	})

	$("#menu_sinistre").click(function (e) {
		event.preventDefault();
		$(".space_main").removeClass("active")
		$("#menu_sinistre").addClass("active")
		$("#content_sinistre").show()
		$("#content_compte").hide()
		$("#content_renouveler").hide()
		$("#content_contrat").hide()
		$("#content_plan").hide()
	})

	$("#menu_plan").click(function (e) {
		event.preventDefault();
		$(".space_main").removeClass("active")
		$("#menu_plan").addClass("active")
		$("#content_plan").show()
		$("#content_sinistre").hide()
		$("#content_compte").hide()
		$("#content_renouveler").hide()
		$("#content_contrat").hide()
	})

	var t = $('.datatable_table').DataTable({
	    "dom": '<f<t>ip>',
	    "pageLength": 5,
	    "oLanguage": {
	        "oPaginate": {
	            "sFirst": "Premier",
	            "sLast": "Dernier",
	            "sNext": "<i class='fa fa-arrow-circle-right'></i>",
	            "sPrevious": "<i class='fa fa-arrow-circle-left'></i>",
	            "sEmptyTable": "Aucune ligne ne correspond à vos critères",
	        },
	        "sSearch": "Rechercher: ",
	        "sInfo": "_START_ - _END_ lignes sur _TOTAL_",
	        "sEmptyTable": "Aucun résultat trouvé",
	        "sZeroRecords": "Aucun résultat trouvé"
	    }
	});

	function loadContrat (id_contrat) {
	  $.get("/myspace/loadcontrat/"+id_contrat, function(data) {
	     if(data!='0'){
	     $('#form_renew_auto').show()
	     var d = JSON.parse(data);
	     $('#id_cont').val(d.qid);
	     $('#police').val(d.number_n);
	     $('#client').val(d.firstname +' '+ d.lastname);
	     var releasedate = new Date(d.releasedate)
	     releasedate.setMonth(releasedate.getMonth() + d.nbmois)
	     release_date = releasedate.toISOString().substr(0,10)
	     jj = release_date.split("-")[2]
	     mm = release_date.split("-")[1]
	     yyyy = release_date.split("-")[0]

	     $('#echeance').val(jj+'/'+mm+'/'+yyyy+" 00:00:00")
	     $('#newreleasedate').val(jj+'/'+mm+'/'+yyyy)


	        if(releasedate<(new Date()))
	            $('#status').html("<h3 class='alert alert-danger'>Contrat Expiré</h3>")
	        else
	            $('#status').html("<h3 class='alert alert-success'>Contrat en cours</h3>")
	     }else{
	     	$('#form_renew_auto').hide()
	     $('#id_cont').val("");
	     $('#police').val("");
	     $('#client').val("");
	     }
	  })
	}
</script>
@endsection

@section('content')

<section class="subpage-header">
	<div class="container">
		<div class="site-title clearfix">
			<h2>Mon espace</h2>
			<ul class="breadcrumbs">
				<li><a href="/">Accueil</a></li>
				<li>Mon espace personnel</li>
			</ul>
		</div>
		<a href="{{route('page.quote.auto')}}" class="btn btn-primary get-in-touch" data-text="Demander un dévis Auto"><i class="fa fa-file-o"></i>Demander un dévis Auto</a>
	</div>
</section>


			<!-- SERVICES CONTENT -->
            <section>
				<div class="container">
					@if(\Illuminate\Support\Facades\Session::has("success"))
						<div class="alert alert-success alert-dismissable text-center">
							{{\Illuminate\Support\Facades\Session::get("success")}}
						</div>
					@endif
					@if(\Illuminate\Support\Facades\Session::has("error"))
						<div class="alert alert-danger alert-dismissable text-center">
							{{\Illuminate\Support\Facades\Session::get("error")}}
						</div>
					@endif
					<div class="row">
						<div class="col-md-4 animate fadeInLeft">
							<aside>

								<ul class="left-nav">
									<li><a href="javascript:;" id="menu_compte"class="active space_main">Mon compte <i class="fa fa-angle-right"></i></a></li>
									<li><a href="javascript:;" id="menu_contrat" class="space_main">Mes contrats/Dévis<i class="fa fa-angle-right"></i></a></li>
									<li><a href="javascript:;" id="menu_renouveler" class="space_main">Renouveler<i class="fa fa-angle-right"></i></a></li>
									<li><a href="javascript:;" id="menu_sinistre"class="space_main">Déclarer un sinistre <i class="fa fa-angle-right"></i></a></li>
									<li><a href="javascript:;" id="menu_plan" class="space_main">Bon plan <i class="fa fa-angle-right"></i></a></li>
									<li><a href="{{route('logout')}}">Deconnexion <i class="fa fa-angle-right"></i></a></li>
								</ul>

								<div class="help-widget">
									<h5>Besoin d'aide ?</h5>
									<p>Faite vous appeler par l'un de nos conseiller client </p>
									<a href="#." class="btn btn-primary btn-white get-in-touch" data-text="Se faire appeler"><i class="icon-telephone114"></i>Se faire appeler</a>
								</div>

								<a href="#." class="company-presentation-link"><i class="fa fa-phone"></i>ou Appelez le 220 170 00</a>

							</aside>
						</div>
						<div class="col-md-8 animate fadeInRight" id="content_contrat" style="display:none">

							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#automobile" aria-controls="automobile" role="tab" data-toggle="tab">Automobile</a></li>
								<li role="presentation"><a href="#voyage" aria-controls="voyage" role="tab" data-toggle="tab">Voyage</a></li>
								{{--
								<li role="presentation"><a href="#habitation" aria-controls="habitation" role="tab" data-toggle="tab">Habitation</a></li>
								<li role="presentation"><a href="#prevoyance" aria-controls="prevoyance" role="tab" data-toggle="tab">Prévoyance</a></li>
								--}}
							 </ul>

							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="automobile">
									<!--<select class="image-picker show-labels show-html">
									  <option data-img-src="http://placekitten.com/220/200" value="1">Cute Kitten 1</option>
									  <option data-img-src="http://placekitten.com/180/200" value="2">Cute Kitten 2</option>
									</select>-->

									<!-- CASES NAV -->
									<ul class="cases-filter-nav animate fadeInUp">
										<!--<li><a href="#" data-filter="*">Tout</a></li>-->
										<li><a href="#" class="selected" data-filter=".contrats">Contrats/Police</a></li>
										<li><a href="#" data-filter=".devis">Dévis</a></li>
										<li><a href="#" data-filter=".docs">Documents</a></li>
										<a href="{{route('page.myspace.devis-auto')}}"><i class="fa fa-plane"></i>Nouveau dévis</a>
									</ul>
									<ul id="cases-container" class="cases-container">

										<li class="entry contrats" style="width:100%">

											<table class="table table-striped table-hover datatable_table">
												<thead>
													<tr>
														<th>#</th>
														<th>Commande</th>
														<th>Compagnie</th>
														<th>Date</th>
														<th>Echeance</th>
													</tr>
												</thead>
												<tbody>
													@foreach($contrats_auto as $key=>$c)
													<tr
														<?php
															$today = date('Y-m-d');
															$expire = date('Y-m-d', strtotime($c->releasedate . "+$c->nbmois months -1 days"));
															if(strtotime($today) >= strtotime($expire)){
																echo "style='background:#da565d'";
															}
															else{
																echo "style='background:#85e75e'";
															}

														?>
													>
														<td>{{ ++$key }}</td>
														<td><a target="_blank" href="{{ route('details.quote.auto',[$c->qid,$c->comp_id]) }}">
														{{$c->number_n}}<br/>
														{{$c->firstname ." ".$c->lastname}}
														</a></td>
														<td>{{$c->compname}}</td>
														<td>{{date('d/m/Y', strtotime($c->created_at))}}</td>
														<td>{{date('d/m/Y', strtotime($expire )). " 23:59:59"}}</td>
													</tr>
													@endforeach
												</tbody>
											</table>

										</li>



										<li class="devis">



											<table class="table table-bordered table-striped table-hover datatable_table">
												<thead>
													<tr>
														<th>#</th>
														<th>Commande</th>
														<th>Date</th>
														<th>Echeance</th>
													</tr>
												</thead>
												<tbody>
													@foreach($devis_auto as $key=>$c)
													<tr
													<?php
															$today = date('Y-m-d');
															$expire = date('Y-m-d', strtotime($c->releasedate . "+$c->nbmois months -1 days"));
															if(strtotime($today) >= strtotime($expire)){
																//echo "style='background:#da565d'";
															}
															else{
																//echo "style='background:#85e75e'";
															}

														?>
													>
														<td>{{ ++$key }}</td>
														<td>
														<a target="_blank" href="{{ ($c->company_id==0)? route('showDevisAllResult',$c->qid) : route('details.quote.auto',[$c->qid,$c->company_id])  }}">
														{{$c->number_n}}<br/>
														{{$c->firstname . " ". $c->lastname}}
														</a>
														</td>
														<td>{{date('d/m/Y', strtotime($c->created_at))}}</td>
														<td>{{date('d/m/Y', strtotime($expire)) . " 23:59:59"}} ({{$c->nbmois }} mois)</td>
													</tr>
													@endforeach
												</tbody>
											</table>

										</li>

										<li class="docs" id="links">
											@foreach($files as $file)
											<div class="cases-item animate fadeInUp">
												<a href="https://app.monassurance.ci/back/assets/js/vendor/file-upload/server/php/index.php?file={{$file}}&download=1">
													<figure>
														<img src="https://app.monassurance.ci/back/assets/js/vendor/file-upload/server/php/index.php?file={{$file}}&download=1" alt="">
														<figcaption>

														</figcaption>
													</figure>
												</a>
											</div>
											@endforeach

											<div id="blueimp-gallery" class="blueimp-gallery">
											    <div class="slides"></div>
											    <h3 class="title"></h3>
											    <a class="prev">‹</a>
											    <a class="next">›</a>
											    <a class="close">×</a>
											    <a class="play-pause"></a>
											    <ol class="indicator"></ol>
											</div>

										</li>

									</ul>
								</div>
								<div role="tabpanel" class="tab-pane" id="voyage">

									<ul  class="nav nav-tabs">
										<li class="active"><a  href="#1a" data-toggle="tab">Contrats/Police</a></li>
										<li><a href="#2a" data-toggle="tab">Dévis</a></li>
										<li><a href="{{route('page.quote.voyage')}}"><i class="fa fa-plane"></i>Nouveau dévis</a></li>
									</ul>
									<div class="tab-content clearfix">
										<div class="tab-pane active" id="1a">
									       <table class="table table-bordered table-striped table-hover datatable_table">
									       	<thead>
									       		<tr>
									       			<th>#</th>
									       			<th>Commande</th>
									       			<th>Client</th>
									       			<th>Début</th>
									       			<th>Echéance</th>
									       		</tr>
									       	</thead>
									       	<tbody>
									       		@foreach($contrats_voyage as $key=>$c)
									       		<tr>
									       		<td>{{++$key}}</td>
									       		<td><a href="{{ route('details.quote.travel', [$c->qid,$c->company_id])}}">{{$c->number_n}}</a> </td>
									       		<td>{{$c->lastname}} {{$c->firstname}}<br/>
									       		<i class="fa fa-phone"></i> : {{$c->contact}}<br/>
									       		<i class="fa fa-flag"></i> : {{getCountryById($c->nationality_id)}}<br/>
									       		</td>
									       		<td> {{date('d/m/Y', strtotime($c->departure_date))}}</td>
									       		<td> {{date('d/m/Y', strtotime($c->arrival_date))}}</td>

									       		</tr>
									       		@endforeach
									       	</tbody>
									       </table>
										</div>
										<div class="tab-pane" id="2a">
									       <table class="table table-bordered table-striped table-hover datatable_table">
									       	<thead>
									       		<tr>
									       			<th> </th>
									       			<th>Commande</th>
									       			<th>Client</th>
									       			<th>Début</th>
									       			<th>Echéance</th>
									       		</tr>
									       	</thead>
									       	<tbody>
									       		@foreach($devis_voyage as $key=>$c)
									       		<tr>
									       		<td>{{++$key}}</td>
									       		<td><a href="{{ route('details.quote.travel', [$c->qid,$c->company_id])}}">{{$c->number_n}}</a> </td>
									       		<td>{{$c->lastname}} {{$c->firstname}}<br/>
									       		<i class="fa fa-phone"></i> : {{$c->contact}}<br/>
									       		<i class="fa fa-flag"></i> : {{getCountryById($c->nationality_id)}}<br/>
									       		</td>
									       		<td> {{date('d/m/Y', strtotime($c->departure_date))}}</td>
									       		<td> {{date('d/m/Y', strtotime($c->arrival_date))}}</td>

									       		</tr>
									       		@endforeach
									       	</tbody>

									       </table>
										</div>
									</div>
								</div>
								{{--<div role="tabpanel" class="tab-pane" id="habitation">

								</div>
								<div role="tabpanel" class="tab-pane" id="prevoyance">

								</div>--}}
							</div>

						</div>

						<div class="col-md-8 animate fadeInRight" id="content_renouveler" style="display:none">

							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#automobile2" aria-controls="automobile2" role="tab" data-toggle="tab">Automobile</a></li>
								{{--<li role="presentation"><a href="#habitation2" aria-controls="habitation2" role="tab" data-toggle="tab">Habitation</a></li>
								<li role="presentation"><a href="#voyage2" aria-controls="voyage2" role="tab" data-toggle="tab">Voyage</a></li>
								<li role="presentation"><a href="#prevoyance2" aria-controls="prevoyance2" role="tab" data-toggle="tab">Prévoyance</a></li>--}}
							 </ul>

							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="automobile2">
									<div class="form-group">
										<label>Mes contrats</label>
										<select class="form-control" onchange="loadContrat(this.value)" name="list_contrat_auto" id="list_contrat_auto">
											<option>Choisir un contrat à renouveller</option>
											@foreach($contrats_auto as $key=>$c)
												<option value="{{$c->qid }}">{{ $c->number_n }} - {{ $c->firstname." ".$c->lastname }}</option>
											@endforeach
										</select>
									</div>
									<form id="form_renew_auto" class="form-horizontal" method="post" action="{{route('page.myspace.renewContract')}}" style="display:none">
									        <div class="text-center" id="status"></div>
									        {{csrf_field()}}
									        <input type="hidden" name="id_cont" id="id_cont" readonly>
									        <div class="form-group">
									            <label for="codeguar" class="col-sm-3 control-label">N° Police</label>
									            <div class="col-sm-9">
									                <input type="text" class="form-control" id="police" name="police" readonly placeholder="N° Police" readonly>
									            </div>
									        </div>
									        <div class="form-group">
									            <label for="codeguar" class="col-sm-3 control-label">Client</label>
									            <div class="col-sm-9">
									                <input type="text" class="form-control" id="client" name="client" readonly placeholder="Nom client" readonly>
									            </div>
									        </div>

									        <div class="form-group">
									            <label for="codeguar" class="col-sm-3 control-label">Date de fin de contrat</label>
									            <div class="col-sm-9">
									                <input type="text" class="form-control" id="echeance" name="echeance" readonly placeholder="Date d'échéance du contrat" readonly>
									            </div>
									        </div>

									        <div class="form-group">
									            <label for="codeguar" class="col-sm-3 control-label">Nouvelle date prise d'effet</label>
									            <div class="col-sm-9">
									                <div class="input-group datepicker_newreleasedate w-330 mt-8" >
									                    <input type="text"  name="newreleasedate" id="newreleasedate"  class="form-control">
									                    <span class="input-group-addon">
									                        <span class="fa fa-calendar"></span>
									                    </span>

									                </div>
									            </div>
									        </div>

									        <div class="form-group">
									            <label for="codeguar" class="col-sm-3 control-label">Périodicité</label>
									            <div class="col-sm-9">
									                <select id="periode" name="periode" class="form-control" required>
									                    <option></option>
									                 @foreach($periodes as $periode)
									                 <option value="{{$periode->id}}">{{$periode->periode}}</option>
									                 @endforeach
									                </select>
									            </div>
									        </div>
									   <div class="text-center">

										    <button type="submit" data-text="Renouveller" class="btn btn-success btn-ef btn-ef-3 btn-ef-3c mb-10">Renouveller </button>
									   </div>
									 </form>
								</div>
								{{--
								<div role="tabpanel" class="tab-pane" id="voyage2"></div>
								<div role="tabpanel" class="tab-pane" id="habitation2">

								</div>
								<div role="tabpanel" class="tab-pane" id="prevoyance2">

								</div>--}}
							</div>

						</div>

						<div class="col-md-8 animate fadeInRight" id="content_compte">
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
								<li role="presentation"><a href="#motdepasse" aria-controls="motdepasse" role="tab" data-toggle="tab">Mot de passe</a></li>
							 </ul>
							 <div class="tab-content">
							 	<div role="tabpanel" class="tab-pane active" id="profile">
									<form class="profile-settings" enctype="multipart/form-data" action="{{ route('page.myspace.update-profile') }}" method="post">
										{{csrf_field()}}

										<div class="row">

											<div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }} col-sm-6">
												<label for="first-name">Nom</label>
												<input type="text" class="form-control" id="name"  name="name" value="{{\Illuminate\Support\Facades\Auth::guard('space_perso')->user()->name}}" required>
												@if ($errors->has('name'))
					                                <span class="help-block">
					                                    <strong>{{ $errors->first('name') }}</strong>
					                                </span>
					                            @endif
											</div>

										</div>


										<div class="row">



											<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }} col-sm-6">
												<label for="phone">Contact</label>
												<input type="text" readonly class="form-control" id="phone" name="phone" value="{{\Illuminate\Support\Facades\Auth::guard('space_perso')->user()->phone_number}}" required>
												@if ($errors->has('phone'))
					                                <span class="help-block">
					                                    <strong>{{ $errors->first('phone') }}</strong>
					                                </span>
					                            @endif
											</div>

										</div>

										<div class="row">
											<div class="form-group">
	                                            <div class="col-sm-offset-2 col-sm-10">
	                                                <button type="submit" data-text="Modifier" class="btn btn-rounded btn-primary btn-sm">Modifier</button>
	                                                <button type="reset" class="btn btn-rounded btn-default btn-sm">Annuler</button>
	                                            </div>
	                                        </div>
                                        </div>

									</form>
								</div>
								<div role="tabpanel" class="tab-pane" id="motdepasse">
									<form class="profile-settings" method="post" action="{{ route('page.myspace.update-password') }}">
									<input type="hidden" class="form-control" value="{{csrf_token()}}" name="_token" id="_token">
										<div class="row">
											<div class="form-group col-md-12 legend">
												<h4><strong>Paramètres</strong> de sécurité</h4>
												<p>Proteger votre compte</p>
											</div>
										</div>

										<div class="row">

											<div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }} col-sm-6">
												<label for="phone_number">N° de téléphone</label>
												<input type="text" class="form-control" id="phone_number" name="phone_number" value="{{\Illuminate\Support\Facades\Auth::guard('space_perso')->user()->phone_number}}" required readonly>
												@if ($errors->has('phone_number'))
					                                <span class="help-block">
					                                    <strong>{{ $errors->first('phone_number') }}</strong>
					                                </span>
					                            @endif
											</div>


											<div class="form-group col-sm-6">
												<label for="password">Mot de passe actuel</label>
												<input type="password" class="form-control" id="currentpassword" required name="currentpassword" value="" >
											</div>

										</div>

										<div class="row">

											<div class="form-group col-sm-6">
												<label for="new-password">Nouveau mot de passe</label>
												<input type="password" class="form-control" id="newpassword" required name="newpassword">
											</div>

											<div class="form-group col-sm-6">
												<label for="new-password-repeat">Retaper nouveau mot de passe</label>
												<input type="password" class="form-control" id="newpasswordrepeat" name="newpasswordrepeat">
												<span id="newpass-result" required class="passcheck"></span>
											</div>

										</div>
										<div class="row">
											<div class="form-group">
	                                            <div class="col-sm-offset-2 col-sm-10">
	                                                <button  id="btnUpdPwd" type="submit" class="btn btn-rounded btn-primary btn-sm">Modifier</button>
	                                                <button type="reset" class="btn btn-rounded btn-default btn-sm">Annuler</button>
	                                            </div>
	                                        </div>
                                        </div>

									</form>
								</div>
							</div>
						</div>

						<div class="col-md-8 animate fadeInRight" id="content_sinistre" style="display:none">
							<div class="alert alert-info">
							  <strong><i class="fa fa-info"></i></strong> Fonctionnalités bientôt disponible!
							</div>
						</div>

						<div class="col-md-8 animate fadeInRight" id="content_plan" style="display:none">
							<div class="alert alert-info">
							  <strong><i class="fa fa-info"></i></strong> Fonctionnalités bientôt disponible!
							</div>
						</div>
					</div>

				</div>
			</section>
			<!-- / SERVICES CONTENT -->


@endsection
