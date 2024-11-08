@extends('layouts.frontend.master')

@section("title")
www.monassurance.ci :: Toutes les offres automobiles aux meilleurs prix.
@endsection  

@section("custom-styles")

<link rel="stylesheet" href="{{asset('css/custom.css')}}">
<style type="text/css">
	input[type="text"], input[type="email"], input[type="number"], input[type="password"] {
	    background: #fff;
	    border: 1px solid #ccc;
	    border-radius: 8px;
	    width: 100%;
	    padding: 0 25px;
	    height: 35px;
	    font-family: "Open Sans",sans-serif;
	}
</style>
@endsection 

@section("custom-scripts")

<script type="text/javascript">
$(function () {
	        $('#datetimepicker_priseeffet').datetimepicker({
	        	format: 'DD/MM/YYYY',
	            showTodayButton: true,
	            widgetPositioning:{
	               horizontal: 'auto',
	               vertical:'bottom'
	            }
	        });
	    })
</script>

<div class="modal fade" id="UpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
	  <div class="modal-header">
	    <h5 class="modal-title" id="exampleModalLabel">Modifier les infos de votre assurance</h5>
	    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	      <span aria-hidden="true">&times;</span>
	    </button>
	  </div>
	  <div class="modal-body">
	  <form class="form-horizontal" action="{{ route('updateGuaranteAssurance') }}" method="post">
	  	{{csrf_field()}}
	  
	  <input type="hidden" value="{{ $prospect->assurance_auto_info_id }}" readonly>
	    <div class="row">
	        <div class="col-md-6">
	                    <label class="control-label input-label" for="priseeffet">Date de prise d'effet du contrat souhaitée*</label>
	                    <div class='input-group' id='datetimepicker_priseeffet'>
	                        <input type='text' class="form-control date_priseeffet" placeholder="DD/MM/YYYY" required name="priseeffet" id="priseeffet" value="{{ date('d/m/Y', strtotime($prospect->assurance_release_date)) }}" />
	                        <span class="input-group-addon">
	                            <span class="glyphicon glyphicon-calendar"></span>
	                        </span>
	                  </div>
	        </div>
	        <div class="col-md-6">
	            <label class="control-label input-label" for="priseeffet">Périodicité/Durée du contrat*</label>
	            <select class="form-control" required id="periode" name="periode">
	            @foreach($periodes as $p)
	              <option value="{{$p->id}}" {{ ($prospect->pid==$p->id)? 'selected':'' }}>{{$p->periode}}</option>
	            @endforeach
	            </select>
	        </div>
	      </div>
	      <div class="row" style="margin-top:25px">
	      	<div class="col-md-12">
		      <label class="control-label input-label" for="">Formule d'assurance*</label><br/>
		      <div class="row">
		        <div class="col-md-12">
		          <div class="col-md-6">
		            <div class="radio radio-primary">
		              <input type="radio" id="tsimple" value="tsimple" name="formule" {{($prospect->guarante=="tsimple")?'checked':''}}>
		              <label for="tsimple" id="lb_tsimple"> <i title="L’assurance « au tiers » est la formule d’assurance auto la plus basique et la moins chère. Contrairement à la couverture optimale du contrat « tous risques », la formule « au tiers » ne dédommage que les préjudices physiques et matériels causés à un tiers en cas d’accident." class="tooltips">Tiers Simple </i></label>
		            </div>
		          </div>
		          <div class="col-md-6">
		            <div class="radio radio-primary">
		              <input type="radio" class="disable_mens" id="tcomplet" value="tcomplet" name="formule" {{($prospect->guarante=="tcomplet")?'checked':''}}>
		              <label for="tcomplet" id="lb_tcomplet"><i title="A mi-chemin entre les formules « au tiers » et « tous risques », l’assurance auto « Tiers Complet » répond à la demande des automobilistes cherchant à souscrire un niveau de protection correct, sans pour autant augmenter leur budget auto." class="tooltips"> Tiers Complet</i> </label>
		            </div>
		          </div>
		        </div>
		      </div><br/>
		      <div class="row">
		        <div class="col-md-12">
		          <div class="col-md-6" style="display:none">
		            <div class="radio radio-primary">
		              <input type="radio" class="disable_mens" id="tcol" value="tcol" name="formule">
		              <label for="tcol" id="lb_tcol"> <i title="Présente en option dans les contrats d’assurance auto, la garantie « tierce collision » prend en charge les dégâts matériels survenus suite à une collision avec autrui. Avantageuse pour les assurés « au tiers », cette protection n’entre néanmoins en jeu que sous certaines conditions." class="tooltips"> Tiers Collision </i></label>
		            </div>
		          </div>
		          <div class="col-md-6">
		            <div class="radio radio-primary">
		              <input type="radio" class="disable_mens" id="trisque" value="toutrisque" name="formule" {{($prospect->guarante=="toutrisque")?'checked':''}}>
		              <label for="trisque" id="lb_trisque"><i title="L’assurance « tous risques » est la formule d’assurance voiture la plus complète, mais aussi la plus chère. Elle s’adresse aux automobilistes qui souhaitent circuler l’esprit tranquille, en étant certains de bénéficier de la meilleure couverture possible contre les risques." class="tooltips"> Tous risques </i></label>
		            </div>
		          </div>
		        </div>
		      </div>
		    </div>
	      </div>
	      <div class="form-group" style="text-align:center ">
	      	<button class="btn btn-success" type="submit" data-text="Modifier">Modifier</button>
	      </div>
	  </form>
	  </div>
	  <div class="modal-footer">
	    <button type="button" class="btn btn-secondary" data-text="Quitter" data-dismiss="modal">Quitter</button>
	</div>
	</div>
	</div>
</div>

@endsection 

@section('content')
<!-- Modal -->

<section class="subpage-header">
	<div class="container">
		<div class="site-title clearfix">
			<h2>Comparer d'autres offres</h2>
			<ul class="breadcrumbs">
				<li><a href="/">Accueil</a></li>
				<li>Automobile</li>
			</ul>
		</div>
    <a href="{{route('page.quote.auto')}}" class="btn btn-default get-in-touch" data-text="Comparer dévis"><i class="fa fa-plus"></i>Nouveau dévis</a>&nbsp;
    @if($prospect->status==0)
    <a href="{{--route('page.quote.auto')--}}" data-toggle="modal"  data-target="#UpdateModal" class="btn btn-primary get-in-touch" data-text="Modifier"><i class="fa fa-edit"></i>Modifier</a>
	</div>
	@endif
</section>
 <section class="bg-blue">
	<div class="container">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Compagnie</th>
					<th>Garanties</th>
					<th>Périodicité</th>
					<th>Prime</th>
					<th>FAC</th>
					<th>Services</th>
					<th>Total</th>
					<th>Details</th>
				</tr>
			</thead>
			<tbody>
				@foreach($quotations as $q)
				<tr>
					<td><img width="83x30" src="/images/assureurs/{{$q->logo}}" /></td>
					<td>{{$q->formule_selected}}</td>
					<td>{{$q->desc_periode}}</td>
					<td>{{number_format($q->TTC-$q->FG)}}</td>
					<td>{{number_format($q->FG)}}</td>
					<td>{{number_format($q->som_serv)}}</td>
					<td>{{number_format($q->TTC+$q->som_serv)}}</td>
					<td><a title="Voir détails" href="/details/devis/{{$q->id_quote}}/{{$q->idcomp}}" style="background-color:#4cae4c;" class="btn btn-success"><i class="fa fa-search"></i></a>  </td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</section>


	

@endsection