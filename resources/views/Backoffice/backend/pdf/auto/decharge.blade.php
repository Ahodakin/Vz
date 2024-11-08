{{-- @extends('app.pdf.auto._layout-decharge') --}}
{{-- @section('content') --}}

<header class="clearfix">
  <div id="logo">
    <img src="images/logo-1.png">
  </div>
  
</header>
<main>
  
  <div id="info_produit">
    <div id="produit">ATTESTATION DE RECEPTION DE FONDS</div>

  </div>

  <div>
    <p align="justify" style="font-size:16px">Je soussigné <b>le service FINANCE  {{-- $financial->firstname }} {{ $financial->lastname --}}</b> reconnait avoir reçu la somme de <b>{{ number_format($signature->amount_inbox) }} FCFA</b> de la part du <b>service de LIVRAISON{{-- $deliveryman->firstname }} {{ $deliveryman->lastname --}}</b> sur la tournée de livraison <b>{{ $signature->title}} - #{{ $signature->tour_number }}</b>. </p>
    <br/>
    <br/>
    <table border="0" width="100%" >
      <thead>
        <tr>
          <td>#</td>
          <td>Client</td>
          <td>Commande</td>
          <td>Montant</td>
        </tr>
      </thead>
      <tbody >
        @foreach($allOrders as $k=>$o)
        <tr>
          <td class="bg-white">{{ ++$k }}</td>
          <td class="bg-white">{{ $o->firstname ." ". $o->lastname}}</td>
          <td class="bg-white">{{ $o->number_n }}</td>
          <td class="bg-white">{{ number_format($o->inbox_amount) }} FCFA</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <br/>
    <br/>
    <table border="0" width="100%" >
      <tr >
        <td align="right" style="background-color:#fff">
          Fait à abidjan le, {{date('d/m/Y',strtotime($signature->created_at))}} à {{date('H',strtotime($signature->created_at))}}H{{date('i',strtotime($signature->created_at))}}
        </td>
      </tr>
    </table>

     <br/>
    <br/>
    <table border="0" width="100%" >
      <tr align="center">
        <td>
        <div class="row text-center">

           <div class="column"><u>Gestionnaire financier</u><br/><br/><br/><br/><br/><br/><br/><br/></div>
           <div class="column"><u>Livreur</u><br/><br/><br/><br/><br/><br/><br/><br/></div>
           <div class="column"><u>Gestionnaire d'exploitation</u><br/><br/><br/><br/><br/><br/><br/><br/></div>
         </div>
        </td>
        
      </tr>
    </table>
  </div>
</main>
<footer>
&copy; MonASSURANCE.ci
</footer>
{{-- @endsection --}}

