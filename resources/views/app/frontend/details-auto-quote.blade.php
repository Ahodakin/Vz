@extends('layouts.frontend.master')

@section("title")
www.monassurance.ci ::  Détails de Votre dévis Automobile.
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
new Cleave('.delivery_phone', {
            phone: true,
            phoneRegionCode: 'CI'
        });
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
			      		window.location.href = "/devis/automobile/congrate/"+id_quote		      		
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
			<h2>Automobile</h2>
			<ul class="breadcrumbs">
				<li><a href="/">Accueil</a></li>
				<li>Automobile</li>
			</ul>
		</div>
    <a href="{{route('page.quote.auto')}}" class="btn btn-default get-in-touch" data-text="Comparer dévis"><i class="fa fa-plus"></i>Nouveau dévis</a>
    <a href="{{route('showDevisAllResult', $prospect->qid)}}" style="margin-right:15px" class="btn btn-primary get-in-touch" data-text="Retour sur les offres"><i class="fa fa-arrow-left"></i>Retour sur les offres</a>
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
    <div>Date commande: {{date('d/m/Y H:i:s', strtotime($prospect->created_at))}}</div>
  </div>
</header>
<main>
  <div id="details" class="clearfix">
    <div id="client">
      <div class="to">L'ASSUR&#201;:</div>
      <h2 class="name">
        @if($prospect->proprio_veh=="E")
        {{$prospect->company_name}} <i>(Entreprise)</i>
        @else
        {{$prospect->lastname}} {{$prospect->firstname}}
        @endif
      </h2>
      @if($prospect->status==0)
      <div class="address">{{$prospect->contact}}</div>
      @if(!is_numeric(intval(substr($prospect->email, 0,1))))
      <div class="email"><a href="mailto:{{$prospect->email}}">{{$prospect->email}}</a></div>
      @endif
      <div class="address">
      @if($prospect->proprio_veh=="P")
         <b>Profession :</b> {{$prospect->jobtitle}}  
        @endif
      </div>
      @endif
    </div>
    <div id="invoice">
      <h1>{{ get_pdf_label($prospect->status) }} n°<u>{{$prospect->number_n}}</u></h1>
      <div class="date"><strong>Périodicité: </strong>{{$prospect->periode}}</div>
      <div class="date"><strong>Date de Prise d'effet:</strong> {{date('d/m/Y', strtotime($prospect->assurance_release_date))}}</div>
      <div class="date"><strong>Date d'écheance:</strong> {{date('d/m/Y', strtotime($prospect->assurance_release_date . "+$prospect->nbmois months -1 days")). " 23:59:59"}}</div>
    </div>
  </div>
  <div id="notices">
    <div>STATUT COMMANDE:</div>
    <div class="notice">{{ get_commande_status_by_text($prospect->status) }}</div>
  </div>
  <div id="info_produit">
  	@if($prospect->product_type==1)
  	<div id="produit">CARACTERISTIQUES DU VEHICULE</div>
  	<table border="0">
  		<tr>
  			<td><strong>Usage : </strong>{{$prospect->shortdesc}}</td>
  			<td><strong>Zone : </strong>(Zone {{$prospect->zone}}){{$prospect->city}}</td>
  			<td><strong>N°Immatriculation : </strong>{{$prospect->matriculation}}</td>
  			<td><strong>Energie : </strong>{{($prospect->energy=='D')?'Diesel':'Essence'}}</td>
  		</tr>
  		<tr>
  			<td><strong>Marque : </strong>{{$prospect->title}}</td>
  			<td><strong>Nombre de places : </strong>{{$prospect->placesnumber}}</td>
  			<td><strong>Puissance : </strong>{{$prospect->power}} CV</td>
        @if($prospect->charge_utile!=null)
          <td><strong>Charge Utile : </strong>{{$prospect->charge_utile}} T</td>
        @else
          <td></td>
        @endif
  		</tr>
  		<tr>
  			<td><strong>Valeur à neuf : </strong>{{(number_format($prospect->vneuve)=="0")?"-":number_format($prospect->vneuve)}} </td>
  			<td><strong>Valeur venale : </strong>{{(number_format($prospect->vvenale)=="0")?"-":number_format($prospect->vvenale)}}</td>
        <td><strong>1ere mise circ. : </strong>{{date('d/m/Y', strtotime($prospect->firstrelease))}}</td>
  			<td><strong>Couleur : </strong>{{getCarColor($prospect->color)}}</td>
  		</tr>
  	</table>
  	@endif
  </div>
  
  <div style="font-size:1.2em;font-weight:bold" class="text-center">VOTRE PROPOSITION</div>
  <table border="0" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <th class="no">#</th>
        <th class="desc">GARANTIE</th>
        <th class="desc">SOMME GARANTIE</th>
        <th class="desc">FRANCHISE</th>
        <th class="unit">PRIME ANNUELLE</th>
        <th class="total">PRIME PERIODIQUE</th>
      </tr>
    </thead>
    <tbody>
      <?php $i=1; ?>
      @foreach($garantees as $key=>$g)
        @if(in_array($g->codeguar, explode(",", substr($data->formule_selected, 1, -1))))
      <tr>
        <td class="no" align="center"><?= $i++ ?></td>
        <td class="desc"><h3 style="font-size: 1.2em;">{{$g->titleguar}}</h3></td>
        <td class="desc">
          @if($g->codeguar=="RC")
            {{number_format(3500000000)}} FCFA
          @elseif($g->codeguar=="SECU_ROU")
            -
          @else
            {{$comp_gar[$g->codeguar]["cat".$prospect->autid]["sommegarantie"]}}
          @endif
        </td>
        <td class="desc">
          @if($g->codeguar=="RC")
            -
          @elseif($g->codeguar=="SECU_ROU")
            -
          @else
            {{$comp_gar[$g->codeguar]["cat".$prospect->autid]["franchise"]}}
          @endif
        </td>
        <td class="unit">
          @if($g->codeguar=='RC')
            {{number_format($data->RC)}}
          @elseif($g->codeguar=='DR')
            {{number_format($data->DR)}}
          @elseif($g->codeguar=='RA')
            {{number_format($data->RA)}}
          @elseif($g->codeguar=='IC')
            {{number_format($data->IC)}}
          @elseif($g->codeguar=='VAND')
            {{number_format($data->VAND)}}
          @elseif($g->codeguar=='INC')
            {{number_format($data->INC)}}
          @elseif($g->codeguar=='BG')
            {{number_format($data->BG)}}
          @elseif($g->codeguar=='VOL')
            {{number_format($data->VOL)}}
          @elseif($g->codeguar=='VAG')
            {{number_format($data->VAG)}}
          @elseif($g->codeguar=='VOLACC')
            {{number_format($data->VOLACC)}}
          @elseif($g->codeguar=='DOMVEH')
            {{number_format($data->DOMVEH)}}
          @elseif($g->codeguar=='DOMCOL')
            {{number_format($data->DOMCOL)}}
          @elseif($g->codeguar=='SECU_ROU')
            {{number_format($data->SECU_ROU)}}
          @endif
        </td>
        <td class="total">
          @if($g->codeguar=='RC')
            {{number_format($data->RC_frac)}}
          @elseif($g->codeguar=='DR')
            {{number_format($data->DR_reduite*$data->periode)}}
          @elseif($g->codeguar=='RA')
            {{number_format($data->RA_reduite*$data->periode)}}
          @elseif($g->codeguar=='IC')
            {{number_format($data->IC_reduite*$data->periode)}}
          @elseif($g->codeguar=='VAND')
            {{number_format($data->VAND_reduite*$data->periode)}}
          @elseif($g->codeguar=='INC')
            {{number_format($data->INC_reduite*$data->periode)}}
          @elseif($g->codeguar=='BG')
            {{number_format($data->BG_reduite*$data->periode)}}
          @elseif($g->codeguar=='VOL')
            {{number_format($data->VOL_reduite*$data->periode)}}
          @elseif($g->codeguar=='VAG')
            {{number_format($data->VAG_reduite*$data->periode)}}
          @elseif($g->codeguar=='VOLACC')
            {{number_format($data->VOLACC_reduite*$data->periode)}}
          @elseif($g->codeguar=='DOMVEH')
            {{number_format($data->DOMVEH_reduite*$data->periode)}}
          @elseif($g->codeguar=='DOMCOL')
            {{number_format($data->DOMCOL_reduite*$data->periode)}}
          @elseif($g->codeguar=='SECU_ROU')
            {{number_format($data->SECU_ROU_reduite*$data->periode)}}
          @endif
        </td>
      </tr>
       @endif
      @endforeach
          
      <tr>
        <td colspan="6">
          <div class="text-center">REDUCTION</div>
        </td>
      </tr>
      <tr>
        <td colspan="6">
          <div class="row text-center">

                 <div class="col-md-3">Cat. Socio. Pro ({{$data->RED_SP*100}}%)<br/>
                 @if($data->RED_SP==0)
                 Non
                 @else
                 {{number_format($data->ALL_REDUCTION_SP)}} FCFA
                 @endif
                 </div>
                 <div class="col-md-3">Durée de Cond.({{$data->RED_PC*100}}%)<br/>
                 @if($data->RED_PC==0)
                  Non
                 @else
                 {{number_format($data->ALL_REDUCTION_PC)}} FCFA
                 @endif
                 </div>
                 <div class="col-md-3">BNS ({{$data->RED_BNS*100}}%)<br/>
                  @if($data->RED_BNS==0)
                    Non
                  @else
                  {{number_format($data->ALL_REDUCTION_BNS)}} FCFA
                  @endif
                  </div>
                 <div class="col-md-3">Commerciale({{$data->RED_COM*100}}%) & Autres<br/>
                 @if($data->RED_COM==0)
                 Non
                 @else
                 {{number_format($data->ALL_REDUCTION_COM)}} + {{number_format($prospect->reduction_commerciale)}} FCFA
                 @endif
                 </div>
               </div>
        </td>
      </tr>
    </tbody>
    <tfoot>
      
      <tr>
        <td colspan="3"></td>
        <td colspan="2">PRIME NET</td>
        <td>{{number_format($data->PNF)}}</td>
      </tr>
      <tr>
        <td colspan="3"></td>
        <td colspan="2">ACCESSOIRE</td>
        <td>{{number_format($data->ACC)}}</td>
      </tr>
      <tr>
        <td colspan="3"></td>
        <td colspan="2">TAXE</td>
        <td>{{number_format($data->TAXE)}}</td>
      </tr>

      <tr>
        <td colspan="3"></td>
        <td colspan="2">FGA</td>
        <td>{{number_format($data->FGA)}}</td>
      </tr>
      <tr>
        <td colspan="3"></td>
        <td colspan="2">CEDEAO</td>
        <td>{{number_format($data->CEDEAO)}}</td>
      </tr>

      
      <tr>
        <td colspan="3"></td>
        <td colspan="2"><b>PRIME TTC</b></td>
        <td><b>{{number_format(($data->TTC-$data->FG))}}</b></td>
      </tr>

      
      
      <tr>
        <td colspan="3"></td>
        <td colspan="2"><b>FRAIS DE LIVRAISON</b></td>
        <td><b>{{number_format(($data->FG))}}</b></td>
      </tr>
      <tr>
        <td colspan="3"></td>
        <td colspan="2">TOTAL A PAYER</td>
        <td><?php echo number_format($data->TTC-$prospect->reduction_commerciale); ?></td>
      </tr>
      
    </tfoot>
  </table>
  @if(sizeof($data->servopt)>0)
  <hr>
  <div style="font-size:1.2em;font-weight:bold" class="text-center">SERVICES OPTIONNELS</div>
  <table border="0" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <th class="no">#</th>
        <th class="desc">SERVICES</th>
        <th class="desc">NOMBRE DE MOIS</th>
        <th class="unit">PRIX UNITAIRE</th>
        <th class="total">PRIX</th>
      </tr>
    </thead>
    <tbody>
      <?php $i=1; ?>
          @foreach($data->servopt as $s)         
          <tr >
            <td class="no"><?= $i++ ?></td>
            <td class="desc"><h3 style="font-size: 1.2em;">{{$s->service}}</h3></td>
            <td class="desc">{{$prospect->nbmois}}</td>
            <td class="unit">{{number_format($s->amount)}}</td>
            <td class="total">{{number_format($s->amount*$prospect->nbmois)}}</td>
          </tr>
          @endforeach
    </tbody>
    <tfoot>
     {{-- <tr>
        <td colspan="3"></td>
        <td colspan="2">TAXE (18,6%)</td>
        <td>{{number_format($data->som_serv*18/100)}}</td>
      </tr>--}}
      
      <tr>
        <td colspan="3"></td>
        <td>NET à payer</td>
        <td><?php echo number_format($data->som_serv); ?></td>
      </tr>
      
    </tfoot>
  </table>
  @endif

  
</main>
@if($prospect->status==0)
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
       
        <a href="{{ route('showDevisPDF',[$data->idcomp,$prospect->qid]) }}" target="_BLANK" data-text="Telecharger la proformat" style="background-color:#01a29c; " class="btn btn-primary get-in-touch"><i class="fa fa-print"></i> Telecharger la proformat</a>  
        @if(sizeof($data->servopt)>0)
        <a role="button" target="_BLANK" href="{{ route('showContratPDF', [$data->idcomp,$prospect->qid]) }}" data-text="Telecharger le contrat de prestation de service"   style="background-color:#01a29c" class="btn btn-primary get-in-touch"><i class="fa fa-download"></i> Telecharger le contrat de prestation de service</a>  
        @endif
        @if($prospect->status==0)
        <button type="button"  data-toggle="modal" data-text="Confirmer la commande" id="confirmBtn" disabled data-target="#confirmModal" style="background-color:#4cae4c;" class="btn btn-primary get-in-touch"> <i class="fa fa-check"></i> Confirmer la commande</button>  
        </div>
        @endif
    </div>
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
	              <p>Type Assurance : AUTOMOBILE</p>
	              <p>Périodicité : {{$prospect->nbmois}} mois</p>
	              <p>Période : Du {{date('d/m/Y', strtotime($prospect->assurance_release_date))}} au {{date('d/m/Y', strtotime($prospect->assurance_release_date . "+$prospect->nbmois months -1 days")). " 23:59:59"}}</p>
	              <p>Coût assurance : <?php echo number_format($data->TTC-$data->FG-$prospect->reduction_commerciale); ?> FCFA</p>
                <p>Frais Accesoire Courtier : <?php echo number_format($data->FG); ?> FCFA</p>

	              <p>Services Addit. : <?php echo number_format($data->som_serv); ?> FCFA</p>
	              <p class="tt">TOTAL : <?php echo number_format($data->som_serv+$data->TTC-$prospect->reduction_commerciale); ?> FCFA</p>

	            </div>
	        
	        	<a href="#." class="company-presentation-link" style="color:#fff"><i class="fa fa-phone"></i> Appelez nous au (+225) 220 170 00</a>
	      </div>
	      <div class="col-md-6">
	        <div class="form">
	          <form  method="post" action="{{route('confirm.auto.quotation')}}" id="confirmForm" onSubmit="return false">
	          {{csrf_field()}}
	          	<div id="msg"></div>
	          	<input type="hidden" value="{{$prospect->qid}}" name="qid">
	          	<input type="hidden" value="{{$data->idcomp}}" name="comp_id">
	            <input type="text" required placeholder="Votre numéro de téléphone" name="delivery_phone" value="{{$prospect->contact}}" id="delivery_phone" class="input delivery_phone" >

	            <textarea class="my-textarea" rows="5" required name="delivery_location" placeholder="Votre adresse de livraison ou situation géographique"></textarea>
              <textarea name="hide_msg" id="hide_msg" readonly style="display:none">COMMANDE #{{$prospect->number_n}}
TYPE D'ASSURANCE : AUTOMOBILE
PERIODICITE : {{$prospect->nbmois}} MOIS
PERIODE : Du {{date('d/m/Y', strtotime($prospect->assurance_release_date))}} au {{date('d/m/Y', strtotime($prospect->assurance_release_date . "+$prospect->nbmois months -1 days")). " 23:59:59"}}
PRIME D'ASSURANCE : <?php echo number_format($data->TTC-$data->FG-$prospect->reduction_commerciale); ?> FCFA
ACCESSOIRE COURTIER : <?php echo number_format($data->FG); ?> FCFA
SERVICES ADDIT. : <?php echo number_format($data->som_serv); ?> FCFA
TOTAL : <?php echo number_format($data->som_serv+$data->TTC-$prospect->reduction_commerciale); ?> FCFA
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