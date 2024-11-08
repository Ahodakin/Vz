@extends('layouts.frontend.master')

@section("title")
www.monassurance.ci ::  Détails de Votre dévis Voyage.
@endsection  

@section("custom-styles")
<link rel="stylesheet" type="text/css" href="{{asset('css/print.css')}}">
<link rel="stylesheet" href="{{asset('css/custom.css')}}">

<style type="text/css">
	p{
		line-height: 15px;
	}

	.tt{
		font-size: 23px;
		font-weight: bold;
		margin-top: 25px
	}

	.my-textarea{
	background: #fff;
    border: 1px solid #838383;
    border-radius: 30px;
    width: 100%;
    padding: 10px 25px;
    margin-bottom: 10px;
    font-size: 14px
	}
</style>
@endsection 

@section("custom-scripts")
<script src="{{asset('js/cleave.js/dist/cleave.min.js')}}"></script>
<script src="{{asset('js/cleave.js/dist/addons/cleave-phone.ci.js')}}"></script>
<script type="text/javascript">
/*new Cleave('.delivery_phone', {
            phone: true,
            phoneRegionCode: 'CI'
        });*/
function disabledBtn () {
    var conditions = document.querySelector('#conditions');
  var contrat = document.querySelector('#contrat');
  var confirmBtn = document.querySelector('#confirmBtn');
  if(conditions.checked && contrat.checked) confirmBtn.disabled = false; else confirmBtn.disabled = true;

}
$(document).ready(function() {
	$("#confirmForm").submit(function (e){   
	    event.preventDefault();       
	    var valid = true;
	      $('#confirmForm input[required]').each(function(i, el){
	        if(valid && $(el).val()=='' ) valid = false; 
	      })

	    if(valid){
	    	$("#confirmLoader").fadeIn();
	    	 $("#submitForm").attr('disabled',true) 
	    	setTimeout(function() {       	         
		        $.ajax({
			      url: $("#confirmForm").attr('action'),
			      type: $("#confirmForm").attr('method'),
			      data: $("#confirmForm").serialize(),
			      success: function(data){
			      	$("#msg").html('<div class="alert alert-success">Félicitation votre commande à été enregistrer</div>')
			      	id_quote = JSON.parse(data)
              console.log(data)
			      	setTimeout(function() {
			      		window.location.href = "/devis/voyage/congrate/"+id_quote		      		
			      	}, 1000);
			      	$("#confirmLoader").fadeOut();
			      	$("#submitForm").attr('disabled',false) 
			      },
			      error: function (e) {
			      	$("#msg").html('<div class="alert alert-danger">Oups une erreur inattendu s\'est produite! Contactez notre service support</div>')
			      	$("#confirmLoader").fadeOut();
			      	$("#submitForm").attr('disabled',false) 
			      }
			    });
	    	},2000)
	    }
	    else{
	        return valid;
	    }
	 })
})
</script>


@endsection 

@section('content')
<!-- Modal -->

<section class="subpage-header">
	<div class="container">
		<div class="site-title clearfix">
			<h2>Voyage</h2>
			<ul class="breadcrumbs">
				<li><a href="/">Accueil</a></li>
				<li>Assurance Voyage</li>
			</ul>
		</div>
		<a href="{{route('page.quote.voyage')}}" class="btn btn-primary get-in-touch" data-text="Demander un dévis"><i class="fa fa-file-o"></i>Nouveau dévis</a>
	</div>
</section>
<div class="container">
<header class="clearfix print">
  <div id="logo">
    <img src="/images/assureurs/{{$data->logo}}">
  </div>
  <div id="company">
    <h2 class="name">{{$data->companyname}}</h2>
    <div>{{$data->compphone}}</div>
    <div>Date commande: {{date('d/m/Y H:i:s', strtotime($prospect->date_devis))}}</div>
  </div>
</header>
<main>
  <div id="details" class="clearfix">
    <div id="client">
      <div class="to">L'ASSUR&#201;:</div>
      <h2 class="name">
        {{$prospect->lastname}} {{$prospect->firstname}}
      </h2>
      @if($prospect->status==0)
      <div class="address">{{$prospect->contact}}</div>
      @if(!is_numeric(intval(substr($prospect->email, 0,1))))
      <div class="email"><a href="mailto:{{$prospect->email}}">{{$prospect->email}}</a></div>
      @endif
      @endif
    </div>
    <div id="invoice">
          <h1>{{ get_pdf_label($prospect->status) }} n°<u>{{$prospect->number_n}}</u></h1>
          <div class="date"><strong>Durée: </strong> {{$data->ASSURANCE->DUREE}} Jours</div>
          <div class="date"><strong>Date de depart:</strong> {{date('d/m/Y', strtotime($prospect->departure_date))}}</div>
          <div class="date"><strong>Date de retour:</strong> {{date('d/m/Y', strtotime($prospect->arrival_date))}}</div>
        </div>
	</div>
<div id="notices">
  <div>STATUT COMMANDE:</div>
  <div class="notice">{{ get_commande_status_by_text($prospect->status_devis) }}</div>
</div>
<div id="info_produit">
	<div id="produit">CARACTERISTIQUE DE l'ASSURANCE</div>
	<table border="1">
		<tr align="left">
          <td><strong>Date depart : </strong>{{date('d/m/Y', strtotime($prospect->departure_date))}}</td>
          <td><strong>Date de retour : </strong>{{date('d/m/Y', strtotime($prospect->arrival_date))}}</td>
          <td><strong>Durée : </strong>{{$data->ASSURANCE->DUREE}} Jours</td>
          <td><strong>Pays de destination : </strong>{{strtoupper($data->ASSURANCE->ZONE)}} ({{$prospect->pays_name}})</td>
        </tr>
        <tr align="left">
          <td><strong>Nationalité : </strong>{{getCountryById($prospect->nationality_id)}}</td>
          <td><strong>N° Passeport : </strong>{{$prospect->passport_num}}</td>
          <td colspan="2"><strong>Expiration passeport : </strong>{{date('d/m/Y', strtotime($prospect->date_expire_passport))}}</td>

        </tr>
      <tr align="left">
        <td colspan="2"><strong>Adresse courante : </strong>{{$prospect->current_addr}}</td>
        <td colspan="2"><strong>Adresse de destination : </strong>{{$prospect->destination_addr}}</td>
        
      </tr>
	</table>
</div>
<div style="font-size:1.2em;font-weight:bold" class="text-center">VOTRE PROPOSITION</div>
  <table border="0" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <th class="no">#</th>
        <th class="desc">DESIGNATION</th>
        <th class="total">PRIME</th>
      </tr>
    </thead>
    <tbody>
    	<tr>
    		<td class="no" align="center">1</td>
    		<td class="desc"><h3 style="font-size: 1.2em;">Assurance voyage pour la zone {{strtoupper($data->ASSURANCE->ZONE)}} ({{$prospect->pays_name}})</h3></td>
    		<td class="total">{{number_format($data->PRIME)}}</td>
    	</tr>
    </tbody>
    <tfoot>    
	<tr>
		<td colspan="2"><b>PRIME NET TTC</b></td>
		<td>{{number_format($data->PRIME)}}</td>
	</tr>
	<tr>
        <td colspan="2"><b>FRAIS DE LIVRAISON</b></td>
        <td><b>{{number_format(($data->FG))}}</b></td>
      </tr>
      <tr>
        <td colspan="2">NET A PAYER</td>
        <td><?php echo number_format($data->PRIME+$data->FG); ?></td>
      </tr>
    </tfoot>
  </table>
</main>

@if($prospect->status_devis==0)
<div class="row text-center" style="margin-bottom:20px">
      <div class="col-md-12">
        <div class="form-group">
          <div class="col-md-6">
            <div class="checkbox checkbox-primary">
              <input type="checkbox" id="conditions" onchange="disabledBtn()" value="1" name="conditions">
              <label class="checkpopover" for="conditions"> J'accepte les <a href="javascript:;">conditions d'utilisation du site</a> </label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="checkbox checkbox-primary">
              <input type="checkbox" id="contrat" onchange="disabledBtn()" value="1" name="contrat">
              <label class="checkpopover" for="contrat"> J'ai pris connaissance du <a href="javascript:;">du contrat d'assurance de la compagnie </a> </label>
            </div>
          </div>
      </div>
      </div>
    </div>
    @endif
    <div class="row" style="margin-bottom:25px">
        <div class="col-md-12 text-center">
       
        <a href="{{ route('showDevisVoyagePDF',[$data->idcomp,$prospect->quote_id]) }}" target="_BLANK" data-text="Telecharger la proformat" style="background-color:#01a29c; " class="btn btn-primary get-in-touch"><i class="fa fa-print"></i> Telecharger la proformat</a>  
        {{--<button type="button" data-text="Telecharger le contrat"   style="background-color:#01a29c" class="btn btn-primary get-in-touch"><i class="fa fa-download"></i> Telecharger le contrat</button>  --}}
        @if($prospect->status_devis==0)
        <button type="button"  data-toggle="modal" data-text="Confirmer la commande" id="confirmBtn" disabled data-target="#confirmModal" style="background-color:#4cae4c;" class="btn btn-primary get-in-touch"> <i class="fa fa-check"></i> Confirmer la commande</button>  
        </div>
        @endif
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
	  <div class="modal-header">
	    <h5 class="modal-title" id="exampleModalLabel">Je confirme ma commande</h5>
	    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	      <span aria-hidden="true">&times;</span>
	    </button>
	  </div>
	  <div class="modal-body">
	    <div class="row">
	      <div class="col-md-6">
	            <div class="help-widget">
	              <h5>Récapitulatif de commande</h5>
                <p>Commande #<b>{{$prospect->number_n}}</b></p>
	              <p>Type Assurance : VOYAGE</p>
	              <p>Durée : {{$data->ASSURANCE->DUREE}} jours</p>
	              <p>Période : Du {{date('d/m/Y', strtotime($prospect->departure_date))}} au {{date('d/m/Y', strtotime($prospect->arrival_date))}}</p>
	              <p>Coût assurance : <?php echo number_format($data->PRIME); ?> FCFA</p>
                <p>Frais de livraison : <?php echo number_format($data->FG); ?> FCFA</p>

	              <p class="tt">TOTAL : <?php echo number_format($data->PRIME+$data->FG); ?> FCFA</p>

	            </div>
	        
	        	<a href="#." class="company-presentation-link" style="color:#fff"><i class="fa fa-phone"></i> Appelez nous au (+225) 220 170 00</a>
	      </div>
	      <div class="col-md-6">
	        <div class="form">
	          <form  method="post" action="{{route('confirm.auto.quotation')}}" id="confirmForm" onSubmit="return false">
	          {{csrf_field()}}
	          	<div id="msg"></div>
	          	<input type="hidden" value="{{$prospect->quote_id}}" name="qid">
	          	<input type="hidden" value="{{$data->idcomp}}" name="comp_id">
	            <input type="text" required placeholder="Votre numéro de téléphone" name="delivery_phone" value="{{$prospect->contact}}" id="delivery_phone" class="input delivery_phone" >

	            <textarea class="my-textarea" rows="5" required name="delivery_location" placeholder="Votre adresse de livraison ou situation géographique"></textarea>
              <textarea name="hide_msg" id="hide_msg" readonly style="display:none">COMMANDE #{{$prospect->number_n}}
TYPE D'ASSURANCE : VOYAGE
DUREE  : {{$data->ASSURANCE->DUREE}} JOURS
PERIODE : Du {{date('d/m/Y', strtotime($prospect->departure_date))}} au {{date('d/m/Y', strtotime($prospect->arrival_date))}}
PRIME D'ASSURANCE : <?php echo number_format($data->PRIME); ?> FCFA
FRAIS DE LIVRAISON : <?php echo number_format($data->FG); ?> FCFA
TOTAL : <?php echo number_format($data->PRIME+$data->FG); ?> FCFA
              </textarea>
	            <button class="btn btn-primary" id="submitForm" style="background-color:#4cae4c" type="submit" data-text="Je confirme ma commande">Je confirme ma commande</button> <img src="/images/loader.gif" id="confirmLoader" style="display:none">
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
</div>
@endsection