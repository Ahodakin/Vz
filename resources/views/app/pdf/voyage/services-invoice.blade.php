@extends('app.pdf.auto._layout-services')
@section('content')
<main>
  <div id="details" class="clearfix">
    <div id="client">
      <div class="to">L'ASSUR&#201;:</div>
      <h2 class="name">{{$prospect->lastname}} {{$prospect->firstname}}</h2>
      <div class="address">{{$prospect->contact}}</div>
      <div class="email"><a href="mailto:{{$prospect->email}}">{{$prospect->email}}</a></div>
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
  			<td><strong>Marque : </strong>{{$prospect->title}} {{$prospect->code}}</td>
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
        <th class="desc">QUANTITE</th>
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
            <td class="desc">1</td>
            <td class="unit">{{number_format($s->amount)}}</td>
            <td class="total">{{number_format($s->amount)}}</td>
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
@endsection

