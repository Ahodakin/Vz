@extends('app.pdf.voyage._layout')
@section('content')
@include('app.pdf.voyage._header')
<main>
 <div id="details" class="clearfix">
    <div id="client">
      <div class="to">L'ASSUR&#201;:</div>
      <h2 class="name">
        {{$prospect->lastname}} {{$prospect->firstname}}
      </h2>
      @if($prospect->status==0)
      <div class="address">{{$prospect->contact}}</div>
      <div class="email"><a href="mailto:{{$prospect->email}}">{{$prospect->email}}</a></div>
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
    <table border="0">
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
@endsection

