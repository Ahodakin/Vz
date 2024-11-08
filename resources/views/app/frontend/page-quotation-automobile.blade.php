@extends('layouts.frontend.master')

@section("title")
www.monassurance.ci :: Comparer vos dévis d'assurance Auto
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
              <p>Appelez nous maintenant au <b>(+225) 220 170 00</b> pour nous posez toutes vos préoccupations. </p>
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
@endsection 

@section('content')

<section class="subpage-header">
	<div class="container">
		<div class="site-title clearfix">
			<h2>Devis Automobile</h2>
			<ul class="breadcrumbs">
				<li><a href="/">Accueil</a></li>
				<li><a href="{{route('page.auto')}}">Automobile</a></li>
				<li>Dévis Automobile</li>
			</ul>
		</div>
		<a href="{{ route('page.myspace') }}" class="btn btn-primary get-in-touch" data-text="Mon espace perso"><i class="fa fa-user"></i>Mon espace perso</a>
	</div>
</section>


<section>
	<div class="container">
    
		<div class="row" id="quote_fieldset">
			<div class="col-md-12">
				<form class="form-horizontal form-validation quoteForm" id="quoteForm" method="post">
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
                      <input type="text" data-parsley-group="block0" class="form-control" required  name="souscripteur_name" id="souscripteur_name" placeholder="Nom et prénom de la personne qui effectue le dévis">
                    </div>
                     <div class="col-md-6">
                       <label class="control-label input-label" for="phone_souscr">Votre Numéro de téléphone*</label>
                       <input data-parsley-group="block0" placeholder="Ex: 01020304" type="text" class="form-control" required name="phone_souscr" id="phone_souscr"> 
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
                                    <div class="col-md-6">
                                      <div class="radio radio-primary">
                                        <input type="radio" class="disable_mens" id="tcomplet" value="tcomplet" name="formule">
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
                                        <input type="radio" class="disable_mens" id="trisque" value="toutrisque" name="formule">
                                        <label for="trisque" id="lb_trisque"><i title="L’assurance « tous risques » est la formule d’assurance voiture la plus complète, mais aussi la plus chère. Elle s’adresse aux automobilistes qui souhaitent circuler l’esprit tranquille, en étant certains de bénéficier de la meilleure couverture possible contre les risques." class="tooltips"> Tous risques </i></label>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                

                                
                              </div>   
                              <div class="col-md-6">
                              <br/>
                                  <div class="alert alert-info alert-dismissable hidden-xs" id="info">
                                  
                                     
                                       <img src="{{asset('images/help.png')}}" width="24x24"> 
                                       <div id="info1">
                                         L'assurance au tiers simple est la formule Auto la plus basique et obligatoire.<br/>
                                         <p>Elle renferme les garanties suivantes : </p>
                                         <p><strong>-La responsabilité civile : </strong>Elle ne couvre que les dommages matériels et corporels causés aux tiers, en cas d’accident dont vous êtes responsable. Elle ne couvre pas ceux que vous-même et votre véhicule subissez.</p>
                                          <p><strong>-Défense et recours : </strong>Cette garantie impose à votre assureur au titre de la défense, à pourvoir, à ses frais, à votre défense devant les juridictions compétentes si vous êtes poursuivi à la suite d’un sinistre couvert.<br/> Le recours oblige votre assureur à réclamer à la partie adverse la réparation des préjudices subis à l’occasion d’un accident dont vous êtes victime. 
                                          </p>
                                          <p><strong>-La sécurité routière ou personne transportée : </strong> L’assureur accorde sa garantie pour uniquement à ceux que vous transportez dans votre véhicule à titre gratuit. 
                                          </p>
                                        </div>
                                         <strong id="info2">Les garanties peuvent varier d'une compagnie à une autre!</strong>
                                      

                                      
                                      
                                      
                                        
                                  </div>
                              </div>                
                          </div>
                      </div>
                
            </fieldset>
						<fieldset>
                            <legend>Votre véhicule</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info alert-dismissable">Les informations concernant votre véhicule sont marquées sur votre <b>Carte grise</b>. Veuillez vous en servir pour pouvoir renseigner ces champs.</div>
                                </div>
                            </div>
                            
                            <div class="row"> 
                              <div class="col-md-12">                        
                                <div class="input-group">
                                    <label class="control-label input-label" for="immat">Numéro d'immatriculation*</label>
                                    <input type="text" placeholder="Ex: 1234AB01" onkeyup ="this.value = this.value.toUpperCase();" required data-parsley-group="block2" name="immat" id="immat"> 
                                     <span class="input-group-btn" style="top: 7px;">
                                        <button id="searchmat" class ="btn_dem btn-info" type="button">
                                           <i class="fa fa-search fa-3"></i></button>
                                     </span>  

                                  </div><!-- /input-group -->
                                  <span id="immat-result" style="position:relative;top:-38px;float:right;margin-right: 50px;"></span>
                                     <span class="help-block" style="color:green"><strong id="mat_help-block"></strong></span>
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
                                  <select class="form-control carlist" required data-parsley-group="block2" name="marque" id="marque" data-placeholder="Selectionner la marque de votre véhicule" style="width:100%;">
                                    <option></option>
                                    @foreach($makes as $make)
                                    <option value="{{$make->id}}">{{$make->title}}</option>           
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">                         
                              <div class="col-md-6">
                                  <label class="control-label input-label" for="genre">Genre du véhicule*</label>
                                  <div class="input-group">
                                    <span data-toggle="modal" data-target="#modal-help-cg" id="cg_genre" class="input-group-addon help_button help_cg"><i class="fa fa-question"></i></span>
                                  <select class="form-control" required data-parsley-group="block2" name="genre" id="genre">
                                      <option></option>
                                      @foreach($car_types as $type)
                                       <option value="{{ $type->id_type }}">{{ $type->car_type_desc }}</option>
                                       @endforeach
                                    
                                  </select>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                <label class="control-label input-label" for="category">Catégorie/Usage du véhiucle*</label>
                                <div class="input-group">
                                    <span data-toggle="modal" data-target="#modal-help-cg" id="cg_usage" class="input-group-addon help_button help_cg"><i class="fa fa-question"></i></span>
                                <select class="form-control" disabled data-placeholder="Entrer une catégorie/usage" required data-parsley-group="block2" name="category" id="category">
                                  <option></option>
                                  @foreach($categories as $cat)
                                  @if($cat->id!=5)
                                  <option value="{{$cat->id}}">({{$cat->id}}) {{$cat->shortdesc}}</option>
                                  @endif
                                  @endforeach
                                </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">                       
                              <div class="col-md-3">
                                <label class="control-label input-label" for="puissance">Puissance fiscale*</label>
                                <div class="input-group">
                                    <span data-toggle="modal" data-target="#modal-help-cg" id="cg_pf" class="input-group-addon help_button help_cg"><i class="fa fa-question"></i></span>
                                <select class="form-control" data-placeholder="Puissance fiscale (CV)" required data-parsley-group="block2" name="puissance" id="puissance">
                                  <option></option>
                                  <?php for ($i=1; $i <=12 ; $i++) { ?>
                                  <option value="<?= $i ?>"><?= $i ?> CV</option>  
                                  <?php } ?>
                                  <option value="13">Plus de 12</option>

                                </select> 
                                </div>      
                              </div>
                              <div class="col-md-3" id="div_cu" style="display:none">
                                <label class="control-label input-label" for="cu">Charge Utile* (Tonne)</label>
                                <div class="input-group">
                                    <span data-toggle="modal" data-target="#modal-help-cg" id="cg_cu" class="input-group-addon help_button help_cg"><i class="fa fa-question"></i></span>
                                <select class="form-control" name="cu" id="cu">
                                  <option></option>
                                  <?php for ($i=1; $i <=15 ; $i++) { ?>
                                  <option value="<?= $i ?>"><?= $i-1 . " - ".$i ?> T</option>  
                                  <?php } ?>
                                  <option value="16">Plus de 15</option>

                                </select>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <label class="control-label input-label" for="ennergie">Energie*</label><br/>
                                <div class="radio radio-primary radio-inline">
                                  <input type="radio" id="essence" required  value="E" name="ennergie" checked>
                                  <label for="essence"> Essence </label>
                                </div>
                                <div class="radio radio-primary radio-inline">
                                  <input type="radio" id="diesel" required value="D" name="ennergie">
                                  <label for="diesel"> Diesel </label>
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
                                <label class="control-label input-label" for="color">Couleur du véhicule*</label> 
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
                                    <div class="alert alert-info alert-dismissable">Ces informations nous permetront de vous identifier et editer votre police d'assurance.</div>
                                </div>
                            </div>
                            <div class="form-group particulier_field">
                              <div class="col-md-6">
                                <label class="control-label input-label" for="lastname">Nom*</label>
                                <input type="text" data-parsley-group="block3" class="form-control repeat" required  name="lastname" id="lastname" placeholder="Nom de l'assuré">
                              </div>
                              <div class="col-md-6">
                                <label class="control-label input-label" for="firstname">Prénom*</label>
                                <input type="text" class="form-control" required name="firstname" id="firstname" placeholder="Prénom(s) de l'assuré">
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
                                  <input type="text" class="form-control dob" value="" name="dob" id="dob" placeholder="JJ/MM/AAAA">
                                  <span class="input-group-addon">
                                          <span class="glyphicon glyphicon-calendar"></span>
                                      </span>

                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-md-6 email_assure">
                                <label class="control-label input-label" for="email" id="label_email">Adresse email de l'assuré</label>
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
                                <label class="control-label input-label" for="datePC">Date de delivrance permis de conduire*</label>
                                  <div class='input-group datetimepicker_datePC'>
                                      <input data-parsley-group="block3" type='text' class="form-control datePC" required name="datePC" id="datePC" placeholder="JJ/MM/AAAA" />
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

