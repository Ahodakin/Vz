@extends('app.pdf.auto._layout')
@section('content')
@include('app.pdf.auto._header')
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
        <td><strong>Valeur à neuf : </strong>{{number_format($prospect->vneuve)}} </td>
        <td><strong>Valeur venale : </strong>{{number_format($prospect->vvenale)}}</td>
        <td><strong>1ere mise circ. : </strong>{{date('d/m/Y', strtotime($prospect->firstrelease))}}</td>
        <td><strong>Couleur : </strong>{{getCarColor($prospect->color)}}</td>
      </tr>
    </table>
    @endif
  </div>

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

                 <div class="column">Cat. Socio. Pro ({{$data->RED_SP*100}}%)<br/>
                  @if($data->RED_SP==0)
                  Non
                  @else
                  {{number_format($data->ALL_REDUCTION_SP)}} FCFA
                  @endif
                 </div>
                 <div class="column">Durée de Cond.({{$data->RED_PC*100}}%)<br/>
                  @if($data->RED_PC==0)
                   Non
                  @else
                  {{number_format($data->ALL_REDUCTION_PC)}} FCFA
                  @endif
                 </div>
                 <div class="column">BNS ({{$data->RED_BNS*100}}%)<br/>
                  @if($data->RED_BNS==0)
                    Non
                  @else
                  {{number_format($data->ALL_REDUCTION_BNS)}} FCFA
                  @endif
                 </div>
                 <div class="column">Commerciale({{$data->RED_COM*100}}%) & Autres<br/>
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
  
</main>
@if(sizeof($data->servopt)>0)
<div class="page-break"></div>
@include('app.pdf.auto._header-services')
<main>
  <div id="details" class="clearfix">
    <div id="client">
      <div class="to">L'ASSUR&#201;:</div>
      <h2 class="name">{{$prospect->lastname}} {{$prospect->firstname}}</h2>
      <div class="address">{{$prospect->contact}}</div>
      @if(!is_numeric(intval(substr($prospect->email, 0,1))))
      <div class="email"><a href="mailto:{{$prospect->email}}">{{$prospect->email}}</a></div>
      @endif
    </div>
    <div id="invoice">
      <h1>{{ get_pdf_label($prospect->status) }} n°<u>{{$prospect->number_n}}</u></h1>
      <div class="date"><strong>Périodicité: </strong>{{$prospect->periode}}</div>
      <div class="date"><strong>Date de Prise d'effet:</strong> {{date('d/m/Y', strtotime($prospect->assurance_release_date))}}</div>
      <div class="date"><strong>Date d'écheance:</strong> {{date('d/m/Y', strtotime($prospect->assurance_release_date . "+$prospect->nbmois months -1 days")). " 23:59:59"}}</div>
    </div>
  </div>
  <div id="info_produit">
    @if($prospect->product_type==1)
    <div id="produit">CARACTERISTIQUES DU VEHICULE</div>
    <table border="0">
      <tr>
        <td><strong>Usage : </strong>{{$prospect->shortdesc}}</td>
        <td><strong>Zone : </strong>(Zone {{$prospect->parkingzone}}){{$prospect->city}}</td>
        <td><strong>N°Immatriculation : </strong>{{$prospect->matriculation}}</td>
        <td><strong>Energie : </strong>{{($prospect->energy=='D')?'Diesel':'Essence'}}</td>
      </tr>
      <tr>
        <td><strong>Marque : </strong>{{$prospect->title}}</td>
        <td><strong>Nombre de places : </strong>{{$prospect->placesnumber}}</td>
        <td><strong>1ere mise circ. : </strong>{{date('d/m/Y', strtotime($prospect->firstrelease))}}</td>
        <td><strong>Puissance : </strong>{{$prospect->power}} CV</td>
      </tr>
      <tr>
        <td><strong>Valeur à neuf : </strong>{{number_format($prospect->vneuve)}} </td>
        <td><strong>Valeur venale : </strong>{{number_format($prospect->vvenale)}}</td>
        <td colspan="2"></td>
      </tr>
    </table>
    @endif
  </div>

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
  <div id="notices">
    <div>STATUT COMMANDE:</div>
    <div class="notice">{{ get_commande_status_by_text($prospect->status) }}</div>
  </div>
</main>
@endif
@endsection

