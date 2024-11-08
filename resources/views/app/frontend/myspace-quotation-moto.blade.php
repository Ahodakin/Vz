@extends('layouts.frontend.master')

@section("title")
www.monassurance.ci :: Votre Dévis Moto
@endsection

@section("custom-styles")

<link rel="stylesheet" href="{{asset('css/custom.css')}}">
<link rel="stylesheet" href="<?php echo asset('js/datatables/css/jquery.dataTables.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('js/datatables/datatables.bootstrap.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('js/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('js/datatables/extensions/Responsive/css/dataTables.responsive.css')?>">
<link rel="stylesheet" href="<?php echo asset('js/datatables/extensions/ColVis/css/dataTables.colVis.min.css')?>">
<link rel="stylesheet" href="<?php echo asset('js/datatables/extensions/TableTools/css/dataTables.tableTools.min.css')?>">
<!-- Step Form Wizard plugin -->
 <link rel="stylesheet" href="{{asset('css/step-form-wizard/css/step-form-wizard-all.css')}}" type="text/css" media="screen, projection">
<link rel="stylesheet" href="{{asset('js/mcustom-scrollbar/jquery.mCustomScrollbar.min.css')}}">
<link rel="stylesheet" href="{{asset('js/parsley/parsley.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('css/radio_boxed.css')}}" type="text/css">
<style type="text/css">

fieldset{
  padding: 25px;
}
.small_button{
  padding: 8px 20px;
  font-size: 12px;
  line-height: 10px;
  height: 25px;
  margin-bottom: 2px;
}
.select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 34px;
    user-select: none;
    -webkit-user-select: none; }

/* line 131 */
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 32px; }

/* line 139 */
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 32px;
    position: absolute;
    top: 1px;
    right: 1px;
    width: 20px; }
body{
  font-size: 14px
}
label{
  font-weight: 100;
  font-size: 14px
}

input[type="text"], input[type="email"], input[type="number"], input[type="password"] {
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 8px;
    width: 100%;
    padding: 0 25px;
    height: 35px;
    font-family: "Open Sans",sans-serif;
}

select .carlist{
  height: 35px;
}
.select2{
    width: 100%;
}

.help_button{
  background-color: #46b8da;
  color:#fff;
  cursor: pointer;
}

.mr25{
  margin-right: 25px
}

.ml25{
  margin-left: 25px
}

#overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #fff;
    filter:alpha(opacity=70);
    -moz-opacity:0.7;
    -khtml-opacity: 0.7;
    opacity: 0.7;
    z-index: 10000;
}

#overlay img{
  margin: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.top_box{
  margin-top: 100px;
}
@media (max-width: 590px) {
  .btn.get-in-touch-overlay {font-size: 0;padding: 16px 0 11px 41px;position: relative;}
  .btn.get-in-touch-overlay i{ border:0; padding:17px 10px;}
}

</style>
@endsection

@section("custom-scripts")

<script src="<?php echo asset('js/datatables/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo asset('js/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js'); ?>"></script>
<script src="<?php echo asset('js/datatables/extensions/Responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo asset('js/datatables/extensions/ColVis/js/dataTables.colVis.min.js'); ?>"></script>
<script src="<?php echo asset('js/datatables/extensions/TableTools/js/dataTables.tableTools.min.js'); ?>"></script>
<script src="<?php echo asset('js/datatables/extensions/dataTables.bootstrap.js'); ?>"></script>
<script src="{{asset('css/step-form-wizard/js/step-form-wizard.js')}}"></script>
<!-- nicer scroll in steps -->

<script src="{{asset('js/mcustom-scrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>

<!-- validation library http://parsleyjs.org/ -->

<script src="{{asset('js/parsley/parsley.min.js')}}"></script>
<script src="{{asset('js/parsley/fr.js')}}"></script>
<script src="{{asset('js/cleave.js/dist/cleave.min.js')}}"></script>
<script src="{{asset('js/cleave.js/dist/addons/cleave-phone.ci.js')}}"></script>
<script type="text/javascript" src="{{asset('js/custom-auto-quote.js')}}"></script>

<script type="text/javascript">
$(document).ready(function() {

  $("input[name=proprio_veh]").click(function (e){
      if($('input[name=proprio_veh]:checked').val()=='P'){
        $("#phone").val( $("#phone_sousc").val() );
        $("#phone").prop( "readonly", "true" );
      }  else{
        $("#phone").val("");
        $("#phone").removeAttr("readonly");
        search_immatriculation(0)
      }

      if($('input[name=proprio_veh]:checked').val()=='P'){
       $(".proprio_veh_P").show()
       $(".proprio_veh_E").hide()
       $(".proprio_veh_A").hide()
      }
      else if($('input[name=proprio_veh]:checked').val()=='A'){
        $(".proprio_veh_A").show()
        $(".proprio_veh_P").hide()
        $(".proprio_veh_E").hide()
      }else{
        $(".proprio_veh_E").show()
        $(".proprio_veh_A").hide()
        $(".proprio_veh_P").hide()
      }
  });

    $(".label_radio_box").on("click",function(){
      var immat = $(this).attr('data-immat');
      search_immatriculation(immat)
    });

  function search_immatriculation(mat){

      $.get("/rest-api/v1/searchmoto/"+mat, function(data) {
          if(data!=0){
             var d = JSON.parse(data);
             $("#immat").val(mat);
             $('#marque').val(d.code)

             var first_caractere_email = parseInt(d.email.substr(0,1));


             $("#cylindree").val(d.cylindree);
             $("#name_cg").val(d.name_cg);
             $("#puissance").val(d.power);
             if(d.energy=='E') $("#essence").prop( "checked", true ); else $( "#diesel" ).prop( "checked", true );
             if(d.charge_utile>0){
              $("#div_cu").show();
              $("#cu").val(d.charge_utile);
             }
             date_firstrelease = d.firstrelease.split("-");
             if(d.firstrelease != null) $("#dateMiseCirc").val(date_firstrelease[2]+"/"+ date_firstrelease[1] +"/"+ date_firstrelease[0]);
             $("#nbplace").val(d.placesnumber);
             $("#vneuve").val(d.vneuve);
             $("#vvenale").val(d.vvenale);
             $("#city").val(d.parkingzone);
             $("#color").val(d.color);
             $('#modal-selectcar').modal('hide');

             //client infos
             $('#firstname').val(d.firstname)
             $('#lastname').val(d.lastname)
             if(d.dob != null) $('#dob').val(d.dob.split('-')[2]+'/'+d.dob.split('-')[1]+'/'+d.dob.split('-')[0])

             $('#email').val(d.email);
             if(!isNaN(first_caractere_email)){
                $('#email').prop('type','hidden')
                $('#label_email').hide()
                $('#email').prop('readonly','true')
             }

             $('#phone').val(d.contact)
             $('#phone').prop( "readonly", "true" );
             $('#job').val(d.job_id)
             $('#job').attr( "readonly", "readonly" );
             if(d.date_pc != null) $('#datePC').val(d.date_pc.split('-')[2]+'/'+d.date_pc.split('-')[1]+'/'+d.date_pc.split('-')[0])

              //entreprise
              $('#company_name').val(d.company_name);
              $('#manager_name').val(d.manager_name);
          }
          else{
              $("#genre").val("");
              $("#cylindree").val("");
              $("#name_cg").val("");
              $("#marque").val("");
              $("#puissance").val("");
              $("#essence").prop( "checked", true );

              $("#dateMiseCirc").val("");
              $("#nbplace").val("");
              $("#vneuve").val("");
              $("#vvenale").val("");
              $("#city").val("");
              $("#color").val("");
              $("#div_cu").hide();
              $("#cu").val("");

              $('#firstname').val("")
             $('#lastname').val("")
             $('#dob').val("")
             $('#email').val("")
             $('#email').prop('type','email')
             $('#label_email').show()
            $('#email').removeAttr('readonly')
             $('#phone').val("")
             $('#phone').removeAttr("readonly")
             $('#job').val("")
             $('#job').removeAttr("readonly")
             $('#datePC').val("")

             $('#company_name').val("");
              $('#manager_name').val("");
          }
      });
  }
});
</script>
<!-- Modal -->
<div class="modal fade" id="modal-newcar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter la marque de votre véhicule </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form">
             <form  method="post" action="{{route('auto-quote.createNewCarMake')}}" id="newmakecar">
              <div class="alert alert-danger" style="display:none" id="new_car_error">Saisissez la marque de votre véhicule</div>
              <div class="alert alert-danger" style="display:none" id="car_error">Une erreur s'est produit. Contactez l'administrateur</div>
                {{csrf_field()}}
                <label>Marque du vehicule</label>
                <input type="text" data-delay="300" required placeholder="Marque du véhicule" name="new_make" id="new_make" class="input" >

                <br/>
                <br/>
                <button class="btn btn-primary" type="submit" data-text="Valider">Enregistrer</button> <img src="/images/loader.gif" id="carLoader" style="display:none">
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

<div class="modal fade" id="modal-help" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 mb15">
            <div class="help-widget">
              <h5>Besoin d'aide ?</h5>
              <p>Appelez nous maintenant au <b>(+225) 220 170 00</b> pour nous poser toutes vos préoccupations. </p>
              <a href="#" class="btn btn-primary btn-white get-in-touch" data-text="FAQ"><i class="fa fa-question"></i>FAQ</a>
            </div>

            <a href="#."  data-toggle="modal" data-target="#call-me" data-dismiss="modal" class="company-presentation-link" style="color:#fff"><i class="fa fa-phone"></i> ou Faite vous appeler pas nos conseillers clients</a>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-text="Quitter" data-dismiss="modal">Quitter</button>
    </div>
  </div>
</div>
</div>
<div class="modal fade" id="modal-help-cg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 mb15">
            <div class="help-widget">
              <h5>Besoin d'aide ?</h5>
              <p>Appelez nous maintenant au <b>(+225) 220 170 00</b>. </p>
              <div id="div_help_img"></div>
            </div>

            <a href="#."  data-toggle="modal" data-target="#call-me" data-dismiss="modal" class="company-presentation-link" style="color:#fff"><i class="fa fa-phone"></i> ou Faite vous appeler pas nos conseillers clients</a>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-text="Quitter" data-dismiss="modal">Quitter</button>
    </div>
  </div>
</div>
</div>
<div class="modal fade" id="modal-selectcar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Choississez votre véhicule </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="selectcar_div">
        <section>
        @foreach($cars as $k=>$c)
        <div class="col-md-4 proprio_veh_{{ $c->proprio_veh }}">
          <input type="radio" id="control_{{$k}}" name="select" value="{{$c->id}}" >
          <label for="control_{{$k}}" class="label_radio_box" data-immat="{{ $c->matriculation }}">
            <h2>{{ $c->marque }} - << {{ $c->matriculation }} >></h2>
            <p>{{ $c->categorie }} - {{ $c->shortdesc }}</p>
            <p>Genre : {{ $c->car_type_code }}</p>
            <p>Nom sur carte grise : {{ $c->name_cg }}</p>
            @if($c->proprio_veh == "E")
            <p>Entreprise : {{ $c->company_name }}</p>
            <p>Nom du Gérant : {{ $c->manager_name }}</p>
            @endif
            @if($c->power!=0)
            <p>Puissance fiscale : {{ $c->power }} CV</p>
            @endif
            <p>Energie : {{ ($c->energy=="E")?'Essence':'Diesel' }}</p>
            @if($c->charge_utile!=null)
            <p>Charge utile : {{ $c->charge_utile }} T</p>
            @endif
            @if($c->category==5)
            <p>Cylindrée : {{ getCylindree($c->cylindree) }} cm3</p>
            @endif
            <p>Première mise en circulation : {{ date("d/m/Y", strtotime($c->firstrelease)) }}</p>
            <p>Nombre de place : {{ $c->placesnumber }}</p>
            <p>Couleur : {{ getCarColor($c->color) }} </p>
            @if($c->vneuve!==0.0)
              <p>Valeur neuve :  {{ $c->vneuve }}</p>
              <p>Valeur vénale :  {{ $c->vvenale }}</p>
            @endif
          </label>
        </div>
        @endforeach
        </section>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-text="Quitter" data-dismiss="modal">Quitter</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')

<section class="subpage-header">
  <div class="container">
    <div class="site-title clearfix">
      <h2>Devis MOTO</h2>
      <ul class="breadcrumbs">
        <li><a href="/">Accueil</a></li>
        <li><a href="{{route('page.moto')}}">Moto</a></li>
        <li>Dévis Moto</li>
      </ul>
    </div>
  </div>
</section>


<section>
  <div class="container">

    <div class="row" id="quote_fieldset">
      <div class="col-md-12">
        <form class="form-horizontal form-validation quoteForm" id="quoteFormMoto" method="post">
          <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
          <input type="hidden" name="_form_type_" id="_token" value="{{encrypt('AUTO')}}">
            <fieldset>
              <legend>Vous êtes</legend>
              <div class="row" id="div_proprio_veh">
                <div class="col-md-12 text-center">
                    <label class="control-label input-label" for="proprio_veh">Je souhaite avoir un dévis pour :</label><br/><br/>
                    <div class="radio radio-primary radio-inline mr25">
                      <input type="radio" id="particulier" data-parsley-group="block0"  value="P" name="proprio_veh">
                      <label for="particulier"> Moi même </label>
                    </div>
                   <div class="radio radio-primary radio-inline mr25">
                      <input type="radio" id="autre" data-parsley-group="block0"  value="A" name="proprio_veh">
                      <label for="autre"> Quelqu'un d'autre </label>
                    </div>
                    <div class="radio radio-primary radio-inline ml25">
                      <input type="radio" id="entreprise" data-parsley-group="block0" value="E" name="proprio_veh">
                      <label for="entreprise"> Une entreprise </label>
                    </div>
                </div>
              </div>
                <div class="souscripteur_field" style="display:none; border:#ff0000 solid 1px; padding:15px;margin:10px" >
                  <div class="form-group">
                    <div class="col-md-6">
                      <label class="control-label input-label" for="souscripteur_name">Votre nom*</label>
                      <input type="text" data-parsley-group="block0" class="form-control" required  name="souscripteur_name" id="souscripteur_name" readonly value="{{\Illuminate\Support\Facades\Auth::guard('space_perso')->user()->name }}" placeholder="Nom et prénom de la personne qui effectue le dévis">
                    </div>
                     <div class="col-md-6">
                       <label class="control-label input-label" for="phone_souscr">Votre Numéro de téléphone*</label>
                       <input readonly data-parsley-group="block0" value="{{\Illuminate\Support\Facades\Auth::guard('space_perso')->user()->phone_number }}" placeholder="Ex: 01020304" type="text" class="form-control" required name="phone_souscr" id="phone_souscr">
                     </div>
                  </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Votre assurance</legend>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info alert-dismissable">Selectionnez et définissez la formule d'assurance automobile qui vous convient.</div>
                    </div>
                </div>
                      <div class="row">
                          <div class="col-md-6">
                                      <label class="control-label input-label" for="priseeffet">Date de prise d'effet du contrat souhaitée*</label>
                                      <div class='input-group' id='datetimepicker_priseeffet'>
                                          <input data-parsley-group="block1" type='text' class="form-control date_priseeffet" placeholder="DD/MM/YYYY" required name="priseeffet" id="priseeffet" />
                                          <span class="input-group-addon">
                                              <span class="glyphicon glyphicon-calendar"></span>
                                          </span>
                                    </div>
                          </div>
                          <div class="col-md-6">
                              <label class="control-label input-label" for="priseeffet">Périodicité/Durée du contrat*</label>
                              <select data-parsley-group="block1" class="form-control" required id="periode" name="periode">
                              @foreach($periode as $p)
                                <option value="{{$p->id}}">{{$p->periode}}</option>
                              @endforeach
                              </select>
                          </div>
                        </div>
                      <div class="row">
                        <div class="col-md-12">
                            <label class="control-label input-label" for="pref_comp">Avez vous une préférence pour une compagnie particulière?</label>
                            <select data-parsley-group="block1" class="form-control" name="pref_comp" id="pref_comp">
                              <option value="0">NON</option>
                              @foreach($companies as $c)
                              <option value="{{$c->id}}">{{$c->compname}}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>
                      <div class="col-md-12 text-center" style="margin-bottom:15px; margin-top:15px">
                        <label class="control-label input-label" for="">Type de souscription*</label><br/>

                        <div class="radio radio-primary radio-inline">
                          <input type="radio" id="formuletype" value="F" name="souscription" checked>
                          <label for="formuletype"> Choisir une Formule prédéfinie </label>
                        </div>

                        <div class="radio radio-primary radio-inline" style="display:none">
                          <input type="radio" disabled id="guaranteetype" value="G" name="souscription">
                          <label for="guaranteetype"> Selectionner vos Garanties (Option avancée) </label>
                        </div>
                      </div>

                      <div class="row">
                          <div class="col-md-12">
                              <div id="div-garantie" style="display:none" class="col-md-6">
                                  <label class="control-label input-label" for="">Garanties*</label><br/>
                                  @foreach($guarantee as $g)
                                    <div class="col-md-6">
                                    <div class="checkbox checkbox-primary">
                                      <input type="checkbox"  id="{{$g->codeguar}}" value="{{$g->codeguar}}" name="guarantee[]"
                                      @if($g->id==1)
                                        {{'checked onclick=return&nbsp;false'}}
                                      @endif
                                       >
                                      <label class="checkpopover" for="{{$g->codeguar}}"> <i title="{{$g->description}}" class="tooltips"> {{$g->titleguar}} </i></label>
                                    </div>
                                    </div>
                                  @endforeach
                              </div>
                              <div id="div-formule"  class="col-md-6">
                                <label class="control-label input-label" for="">Formule d'assurance*</label><br/>
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="col-md-6">
                                      <div class="radio radio-primary">
                                        <input type="radio" id="tsimple" value="tsimple" name="formule" checked>
                                        <label for="tsimple" id="lb_tsimple"> <i title="L’assurance « au tiers » est la formule d’assurance auto la plus basique et la moins chère. Contrairement à la couverture optimale du contrat « tous risques », la formule « au tiers » ne dédommage que les préjudices physiques et matériels causés à un tiers en cas d’accident." class="tooltips">Tiers Simple </i></label>
                                      </div>
                                    </div>
                                  </div>
                                </div><br/>



                              </div>
                              <div class="col-md-6">
                              <br/>
                                  <div class="alert alert-info alert-dismissable" id="info">


                                       <img src="{{asset('images/help.png')}}" width="24x24"> <strong id="info1">
                                         L'assurance au tiers est la formule Auto la plus basique.</strong> <br/>
                                         <strong id="info2">Les garanties peuvent varier d'une compagnie à une autre!</strong>


                                  </div>
                              </div>
                          </div>
                      </div>

            </fieldset>
            <fieldset>
                            <legend>Votre Moto</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info alert-dismissable">Les informations concernant votre Moto sont marquées sur votre <b>Carte grise</b>. Veuillez vous en servir pour pouvoir renseigner ces champs.</div>
                                </div>
                            </div>

                            <div class="row">
                              <div class="col-md-12 text-center">
                                <a href="#" data-toggle="modal" data-target="#modal-selectcar" class="btn btn-primary get-in-touch" data-text="Utiliser une moto existante"><i class="fa fa-moto"></i>Utiliser une moto existante</a>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-12">
                                    <label class="control-label input-label" for="immat">Numéro d'immatriculation*</label>
                                <div class="input-group">
                                    <span data-toggle="modal" data-target="#modal-help-cg" id="cg_immat" class="input-group-addon help_button help_cg"><i class="fa fa-question"></i></span>
                                    <input type="text" placeholder="Ex: 1234AB01" onkeyup ="this.value = this.value.toUpperCase();" class="form-control" required data-parsley-group="block2" name="immat" id="immat">


                                  </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                    <label class="control-label input-label" for="lastname_cg">Nom sur la carte grise*</label>

                                    <div class="input-group">
                                      <span data-toggle="modal" data-target="#modal-help-cg" id="cg_nom" class="input-group-addon help_button help_cg"><i class="fa fa-question"></i></span>
                                      <input type="text" placeholder="Entrez le nom figurant sur la carte grise"  class="form-control" required  data-parsley-group="block2" name="name_cg" id="name_cg">
                                    </div>
                              </div>
                              <div class="col-md-6">
                                <label class="control-label input-label" for="marque">Marque*</label>
                                <div class="input-group">
                                    <span data-toggle="modal" data-target="#modal-help-cg" id="cg_marque" class="input-group-addon help_button help_cg"><i class="fa fa-question"></i></span>
                                  <input type="text" placeholder="Selectionner la marque de votre véhicule" class="form-control" required data-parsley-group="block2" name="marque" id="marque">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-4">
                                  <label class="control-label input-label" for="genre">Genre du véhicule*</label>
                                  <div class="input-group">
                                    <span data-toggle="modal" data-target="#modal-help-cg" id="cg_genre" class="input-group-addon help_button help_cg"><i class="fa fa-question"></i></span>
                                  <select class="form-control" readonly required data-parsley-group="block2" name="genre" id="genre">
                                      @foreach($car_types as $type)
                                       <option value="{{ $type->id_type }}">{{ $type->car_type_desc }}</option>
                                       @endforeach

                                  </select>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                <label class="control-label input-label" for="category">Catégorie/Usage du véviucle*</label>
                                <div class="input-group">
                                    <span data-toggle="modal" data-target="#modal-help-cg" id="cg_usage" class="input-group-addon help_button help_cg"><i class="fa fa-question"></i></span>
                                <select class="form-control" disabled data-placeholder="Entrer une catégorie/usage" required data-parsley-group="block2" readonly name="category" id="category">
                                  @foreach($categories as $cat)
                                  @if($cat->id==5)
                                  <option value="{{$cat->id}}">({{$cat->id}}) {{$cat->shortdesc}}</option>
                                  @endif
                                  @endforeach
                                </select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <label class="control-label input-label" for="cylindree">Cylindrée (cm3)*</label>
                                <div class="input-group">
                                    <span data-toggle="modal" data-target="#modal-help-cg" id="cg_cylindre" class="input-group-addon help_button help_cg"><i class="fa fa-question"></i></span>
                                <select class="form-control" name="cylindree" id="cylindree">
                                  <option value="1">0-50</option>
                                  <option value="2">51-99</option>
                                  <option value="3">100-175</option>
                                  <option value="4">176-350</option>
                                  <option value="5">Plus de 350</option>
                                </select>
                                </div>
                              </div>
                            </div>


                            <div class="row if_not_tiers_simple" style="display:none">
                              <div class="col-md-6">
                                <label class="control-label input-label" for="vneuve">Prix à neuf*</label>
                                <div class="input-group">
                                <span data-toggle="modal" data-target="#modal-help" class="input-group-addon help_button"><i class="fa fa-question"></i></span>
                                <input type="text" class="form-control vneuve" name="vneuve" id="vneuve"  aria-describedby="addon_vneuve">
                                <span class="input-group-addon" id="addon_vneuve">FCFA</span>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <label class="control-label input-label" for="vvenale">Prix estimé de la vente*</label>
                                <div class="input-group">
                                <span data-toggle="modal" data-target="#modal-help" class="input-group-addon help_button"><i class="fa fa-question"></i></span>
                                <input type="text" class="form-control vvenale" name="vvenale" id="vvenale" aria-describedby="addon_venale">
                                <span class="input-group-addon" id="addon_venale">FCFA</span>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-3">
                                <label class="control-label input-label" for="misecircMonth">Date 1ère mise en circulation* </label>

                                  <div class='input-group datetimepicker_dateMiseCirc'>
                                      <span data-toggle="modal" data-target="#modal-help-cg" id="cg_mise_circ" class="input-group-addon help_button help_cg"><i class="fa fa-question"></i></span>
                                      <input data-parsley-group="block2" type='text' class="form-control dateMiseCirc" required name="dateMiseCirc" id="dateMiseCirc" placeholder="JJ/MM/AAAA" />
                                      <span class="input-group-addon">
                                          <span class="glyphicon glyphicon-calendar"></span>
                                      </span>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <label class="control-label input-label" for="nbplace">Nombre de place assise*</label>
                                <div class='input-group'>
                                      <span data-toggle="modal" data-target="#modal-help-cg" id="cg_place" class="input-group-addon help_button help_cg"><i class="fa fa-question"></i></span>
                                <input type="text"  required data-parsley-group="block2" data-parsley-type="number" class="form-control place" name="nbplace" id="nbplace">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <label class="control-label input-label" for="city">Ville/Zone de stationnement*</label>
                                <select class="form-control" required name="city" data-parsley-group="block2" id="city" placeholder="Zone de stationnement">
                                  @foreach($zones as $z)
                                  <option value="{{$z->id}}">{{$z->city}}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="col-md-3">
                                <label class="control-label input-label" for="color">Couleur de la moto*</label>
                                <div class='input-group'>
                                      <span data-toggle="modal" data-target="#modal-help-cg" id="cg_place" class="input-group-addon help_button help_cg"><i class="fa fa-question"></i></span>
                                <select class="form-control" required name="color" data-parsley-group="block2" id="color" data-placeholder="Couleur du véhicule">
                                  <option></option>
                                  <option value="1">Blanc</option>
                                  <option value="2">Bleu</option>
                                  <option value="3">Gris</option>
                                  <option value="4">Jaune</option>
                                  <option value="5">Maron</option>
                                  <option value="6">Noir</option>
                                  <option value="7">Orange</option>
                                  <option value="8">Rouge</option>
                                  <option value="9">Vert</option>
                                  <option value="10">Violet</option>
                                  <option value="11">Autres</option>
                                </select>
                                </div>
                              </div>
                            </div>
                            <br/>
                        </fieldset>
                        <fieldset>
                            <legend>Profil de l'assuré</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info alert-dismissable">Ces informations nous permettront de vous identifier et editer votre police d'assurance.</div>
                                </div>
                            </div>
                            <div class="form-group particulier_field">
                              <div class="col-md-6">
                                <label class="control-label input-label" for="lastname">Nom*</label>
                                <input type="text" data-parsley-group="block3" class="form-control repeat" required  name="lastname" id="lastname">
                              </div>
                              <div class="col-md-6">
                                <label class="control-label input-label" for="firstname">Prénom*</label>
                                <input type="text" class="form-control" required name="firstname" id="firstname">
                              </div>
                            </div>
                            <div class="form-group entreprise_field" style="display:none">
                              <div class="col-md-6">
                                <label class="control-label input-label" for="company_name">Nom de l'entreprise*</label>
                                <input type="text" data-parsley-group="block3" class="form-control repeat" required  name="company_name" id="company_name">
                              </div>
                              <div class="col-md-6">
                                <label class="control-label input-label" for="name_manager">Nom du gérant</label>
                                <input type="text" class="form-control" name="manager_name" id="manager_name">
                              </div>
                            </div>
                            <div class="form-group particulier_field">
                              <div class="col-md-6">
                                <label class="control-label input-label" for="gender">Sexe*</label>

                                <select data-parsley-group="block3" class="form-control" required  name="gender" id="gender">
                                  <option value="H">Homme</option>
                                  <option value="M">Femme</option>
                                </select>
                              </div>
                              <div class="col-md-6">
                                <label class="control-label input-label" for="dob">Date de naissance</label>
                                <div class='input-group datetimepicker_dob'>
                                  <input type="text" class="form-control dob" name="dob" id="dob" placeholder="JJ/MM/AAAA">
                                  <span class="input-group-addon">
                                          <span class="glyphicon glyphicon-calendar"></span>
                                      </span>

                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-md-6">
                                <label class="control-label input-label" id="label_email" for="email">Adresse email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="exemple@email.com">
                              </div>
                               <div class="col-md-6">
                                 <label class="control-label input-label" for="phone">Numéro de téléphone*</label>
                                 <input data-parsley-group="block3" placeholder="Ex: 01020304" type="text" class="form-control" required name="phone" id="phone">
                               </div>
                            </div>
                            <div class="form-group particulier_field">
                              <div class="col-md-6">
                                <label class="control-label input-label" for="job">Profession / Catégorie socio professionnelle*</label>
                                <select data-parsley-group="block3" class="form-control" data-placeholder="Catégorie socio professionnelle" name="job" required id="job">
                                  <option></option>
                                  @foreach($jobs as $j)
                                  <option value="{{$j->id}}">{{$j->jobtitle}}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="col-md-6">
                                <label class="control-label input-label" for="datePC">Date de delivrance permis de conduire</label>
                                  <div class='input-group datetimepicker_datePC'>
                                      <input  type='text' class="form-control datePC" name="datePC" id="datePC" placeholder="JJ/MM/AAAA" />
                                      <span class="input-group-addon">
                                          <span class="glyphicon glyphicon-calendar"></span>
                                      </span>
                                </div>

                              </div>
                            </div>
                        </fieldset>


                        <fieldset>
                            <legend>Services optionnels</legend>
                            <div class="row text-center">
                                <div class="col-md-12">
                                  <div class="form-group">
                                <p class="text-center" style="font-size:16px;color:red">Je souhaite aussi souscrire à ces services supplémentaires </p>
                                @foreach($optional_service as $serv)
                                  <div class="col-md-6">
                                  <div class="checkbox checkbox-primary">
                                    <input type="checkbox" id="{{$serv->service}}" value="{{$serv->id}}" name="opt_serv[]">
                                    <label class="checkpopover" for="{{$serv->service}}"><i title="{{--$serv->description--}}" class="tooltips"> {{$serv->service}} ( {{$serv->amount}} FCFA/mois ) </i></label>
                                  </div>
                                  <br/>
                                  <div>
                                    {!!$serv->description!!}
                                  </div>
                                  </div>
                                @endforeach
                              </div>
                                </div>
                            </div>

                        </fieldset>
                        <div id="loader_quote" class="cd-testimonials-all">
                          <div class="cd-testimonials-all-wrapper" id="div_center" >
                            <div class="position-center-center text-center">
                              <div id="loader_img" class="text-center top_box">
                                <div style="margin-top:400px">
                                  <h5 class="loader_img">Plus que quelque instant...</h5>
                                  <img class="loader_img" src="{{asset('images/preloader.gif')}}" alt="" />
                                </div>
                                <div id="box_div" class="" style="margin-top: 400px;"></div>
                                <div id="box_div_table" class="table-responsive" style="display:none;margin-top: 30px;"></div>
                              </div>

                            </div>
                          </div>
                          <a href="javascript:void(0);" class="close-btn" id="close-btn">Close</a>
                        </div>
        </form>

      </div>
    </div>
  </div>
</section>


@endsection

