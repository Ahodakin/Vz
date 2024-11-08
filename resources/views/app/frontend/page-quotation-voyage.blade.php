@extends('layouts.frontend.master')

@section("title")
www.monassurance.ci :: Votre Dévis Voyage 
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

.top_box{
  margin-top: 100px;
}
@media (max-width: 590px) {
  .btn.get-in-touch-overlay {font-size: 0;padding: 16px 0 11px 41px;position: relative;}
  .btn.get-in-touch-overlay i{ border:0; padding:17px 10px;}
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
<script type="text/javascript" src="{{asset('js/custom-voyage-quote.js')}}"></script>
<script type="text/javascript">
function showAuthCar(){
		  	currentcar = document.getElementById('currentcar');
			yournewcar = document.getElementById('yournewcar');

			currentcar.style.display = "none";
			yournewcar.style.display = "block";
	}

	$(function () {
        $('#datetimepicker_priseeffet').datetimepicker({
        	format: 'DD/MM/YYYY',
            showTodayButton: true,
            minDate:moment(),
            useCurrent:true
        });

        new Cleave('.dob', {
            date: true,
            datePattern: ['d','m','Y']
        });
        new Cleave('.date_departure', {
            date: true,
            datePattern: ['d','m','Y']
        });
        new Cleave('.date_arrival', {
            date: true,
            datePattern: ['d','m','Y']
        });

        new Cleave('.phone-ci', {
            phone: true,
            phoneRegionCode: 'CI'
        });

        $('.datetimepicker_dob').datetimepicker({
          format: 'DD/MM/YYYY',
          viewMode: 'years',
          useCurrent: false,
          maxDate:moment(),
            widgetPositioning:{
               horizontal: 'auto',
               vertical:'top'
            }
        });

        $('.datetimepicker_departure').datetimepicker({
          format: 'DD/MM/YYYY',
          minDate:moment(),
          widgetPositioning:{
               horizontal: 'auto',
               vertical:'bottom'
            }

        });
        $('.datetimepicker_arrival').datetimepicker({
          format: 'DD/MM/YYYY',
          useCurrent: false,
          widgetPositioning:{
                horizontal: 'auto',
                vertical:'bottom'
             }
        });

        $('.expire_passport').datetimepicker({
          format: 'DD/MM/YYYY',
          useCurrent: false,
          widgetPositioning:{
                horizontal: 'auto',
                vertical:'top'
             }
        });


        $(".datetimepicker_departure").on("dp.change", function (e) {
           $('.datetimepicker_arrival').data("DateTimePicker").minDate(e.date);
        });
        $(".datetimepicker_arrival").on("dp.change", function (e) {
           $('.datetimepicker_departure').data("DateTimePicker").maxDate(e.date);
        });

            $('.country').select2({
              allowClear: true,
              theme: "classic",
              width: 'resolve',
              language: {
                noResults: function(searchedTerm) {
              return "Aucun résultat";       }
              },
              escapeMarkup: function (markup) {
                  return markup;
              }
            });

    });
  
</script>

<script>
    var sfw;
    $(document).ready(function () {
        sfw = $("#quoteFormVoyage").stepFormWizard({
        	theme: 'sky',
            markPrevSteps: true,
            height: 'auto',
            finishBtn: $('<button type="submit" id="getquoteBtn" data-delay="200" href="javascript:void(0);" style="background-color:#4cae4c;" class="btn sf-right btn-success get-in-touch cd-see-all"  data-text="COMPARER LES OFFRES"><i class="fa fa-check"></i> COMPARER LES OFFRES</button>'),
            onNext: function(i) {
                var valid = $("#quoteFormVoyage").parsley().validate('block' + i);
                sfw.refresh();
                return valid;
            },
            onFinish: function(i) {
                var valid = $("#quoteFormVoyage").parsley().validate();
                // if use height: 'auto' call refresh metod after validation, because parsley can change content
                sfw.refresh();
                return valid;
            }
        });
    })
    

    
</script>


<div class="modal fade" id="modal-help" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title alert alert-info" id="help_input">  </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-text="Quitter" data-dismiss="modal">Quitter</button>
    </div>
  </div>
</div>
@endsection 

@section('content')

<section class="subpage-header">
	<div class="container">
		<div class="site-title clearfix">
			<h2>Devis Voyage</h2>
			<ul class="breadcrumbs">
				<li><a href="/">Accueil</a></li>
				<li><a href="{{route('page.voyage')}}">Voyage</a></li>
				<li>Dévis voyage</li>
			</ul>
		</div>
		{{--<a href="#" class="btn btn-primary get-in-touch" data-text="Mon espace perso"><i class="fa fa-user"></i>Mon espace perso</a>--}}
	</div>
</section>

<div class="container">
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12 animate fadeInLeft">
				<form class="form-horizontal form-validation" id="quoteFormVoyage" method="post">
					<input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
          <input type="hidden" name="_form_type_" id="_token" value="{{encrypt('VOYAGE')}}">
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
                            <legend>Profil de l'assuré</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info alert-dismissable">Ces informations nous permetront de vous identifier et editer votre police d'assurance.</div>
                                </div>
                            </div>
                            <div class="form-group">
                              <div class="col-md-6">
                                <label class="control-label input-label" for="lastname">Nom*</label>
                                <input type="text" data-parsley-group="block1" class="form-control"required  name="lastname" id="lastname">
                              </div>
                              <div class="col-md-6">
                                <label class="control-label input-label" for="firstname">Prénom*</label>
                                <input type="text" class="form-control" data-parsley-group="block1" required name="firstname" id="firstname">
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-md-6">
                                <label class="control-label input-label" for="gender">Sexe*</label>
                               
                                <select data-parsley-group="block1" class="form-control" required  name="gender" id="gender">
                                	<option value="H">Homme</option>
                                	<option value="M">Femme</option>
                                </select>
                              </div>
                              <div class="col-md-6">
                                <label class="control-label input-label" for="dob">Date de naissance*</label>
                                <div class='input-group datetimepicker_dob'>
                                  <input type="text" class="form-control dob" required data-parsley-group="block1" name="dob" id="dob" placeholder="JJ/MM/AAAA">
                                  <span class="input-group-addon">
                                          <span class="glyphicon glyphicon-calendar"></span>
                                      </span>

                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-md-6">
                                <label class="control-label  input-label" for="email" id="label_email">Adresse email*</label>
                                <input placeholder="Ex: votreemail@email.com" data-parsley-group="block1" type="email" class="form-control" required name="email" id="email">
                              </div>
                               <div class="col-md-6">
                                 <label class="control-label input-label" for="phone">Numéro de téléphone*</label>
                                 <input placeholder="Ex: 01020304" data-parsley-group="block1" type="text" class="form-control phone-ci" required name="phone" id="phone"> 
                               </div> 
                            </div>
                        </fieldset>
                        <fieldset style="position:relative">
                            <legend>Votre assurance</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info alert-dismissable">Selectionner et définisser la formule d'assurance voyage qui vous convient.</div>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom:25px">
                                <div class="col-md-4">
                                      <label class="control-label input-label" for="destination">Pays de destination*</label>
                                      <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                        <select label="Le Pays de destination" class="form-control country" required data-parsley-group="block2" name="destination" id="destination" data-placeholder="Selectionner le pays de destination" style="width:100%;">
                                          <option></option>
                                          @foreach($pays as $p)
                                          <option value="{{$p->pays_id}}">{{$p->pays_name}}</option>           
                                          @endforeach
                                        </select>
                                      </div>
                                </div>
                                <div class="col-md-4 dep">
                                    <label class="control-label input-label" for="date_departure">Date de depart*</label>
                                    <div class='input-group datetimepicker_departure'>
                                        <input label="La Date de depart" data-parsley-group="block2" type='text' class="form-control date_departure" placeholder="DD/MM/YYYY" required name="date_departure" id="date_departure" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                  </div>
                                </div>
                                <div class="col-md-4 ret">
                                      <label class="control-label input-label" for="date_arrival">Date de retour*</label>
                                      <div class='input-group datetimepicker_arrival'>
                                          <input label="La Date de retour" data-parsley-group="block2" type='text' class="form-control date_arrival" placeholder="DD/MM/YYYY" required name="date_arrival" id="date_arrival" />
                                          <span class="input-group-addon">
                                              <span class="glyphicon glyphicon-calendar"></span>
                                          </span>
                                    </div>
                                </div>
                                {{--<div class="col-md-2">
                                    <label class="control-label input-label" for="arrival">Durée(Jours)</label>
                                    <input type="text" id="duree" readonly class="form-control">
                                </div>--}}
                            </div>
                            <div class="row" style="margin-bottom:25px">
                                <div class="col-md-4">
                                      <label class="control-label input-label" for="current_addr">Adresse actuelle</label>
                                      <textarea class="form-control" rows="3" name="current_addr" id="current_addr" placeholder="Entrez votre adresse actuelle"></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label input-label" for="dest_addr">Adresse de destination*</label>
                                    <textarea label="L'Adresse de destination" class="form-control" required data-parsley-group="block2" rows="3" name="dest_addr" id="dest_addr" placeholder="Entrez votre adresse de destination"></textarea>

                                </div>
                              </div>

                              <div class="row" style="margin-bottom:25px">
                                <div class="col-md-4">
                                      <label class="control-label input-label" for="nationality">Votre nationnalité*</label>
                                      <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                                        <select label="La nationnalité" class="form-control country" required data-parsley-group="block2" name="nationality" id="nationality" data-placeholder="Selectionner votre nationnalité" style="width:100%;">
                                          <option></option>
                                          @foreach($pays as $p)
                                          <option value="{{$p->pays_id}}"  {{ ($p->pays_code=="ci")?'selected':'' }}>{{$p->pays_name}}</option>           
                                          @endforeach
                                        </select>
                                      </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label input-label" for="num_passport">N° passeport*</label>
                                    <input label="Le N° passeport" type="text" data-parsley-group="block2" required class="form-control" name="num_passport" id="num_passport" placeholder="Entrez votre N° passeport">

                                </div>
                                <div class="col-md-4">
                                    <label class="control-label input-label" for="expire_passport">Date d'expiration passeport*</label>
                                    

                                    <div class='input-group expire_passport'>
                                          <input label="La Date d'expiration passeport" type="text" data-parsley-group="block2" required class="form-control expire_passport" name="expire_passport" id="expire_passport" placeholder="Date d'expiration passeport">
                                          <span class="input-group-addon ">
                                              <span class="glyphicon glyphicon-calendar"></span>
                                          </span>
                                    </div>

                                </div>
                              </div>
                            <div class="row" style="margin-bottom:25px">
                              <div class="col-md-12">
                                  <label class="control-label input-label" for="pref_comp">Avez vous une préfenrence pour une compagnie particulière?</label>
                                  <select data-parsley-group="block1" class="form-control" name="pref_comp" id="pref_comp">
                                    <option value="0">NON</option>
                                    @foreach($companies as $c)
                                    <option value="{{$c->id}}">{{$c->compname}}</option>
                                    @endforeach
                                  </select>
                              </div>
                            </div>
                            
                                  
                            
                        </fieldset>
                        @if(sizeof($optional_service)>0)
                        <fieldset>
                            <legend>Services optionnels</legend>
                            <div class="row text-center">
                                <div class="col-md-12">
                                  <div class="form-group">
                                  
                                <p class="text-center" style="font-size:16px;color:red">Je souhaites aussi souscrire à ces services supplémentaires </p>
                                @foreach($optional_service as $serv)
                                  <div class="col-md-6">
                                  <div class="checkbox checkbox-primary">
                                    <input type="checkbox" id="{{$serv->service}}" checked value="{{$serv->id}}" name="opt_serv[]">
                                    <label class="checkpopover" for="{{$serv->service}}"><i title="{{$serv->description}}" class="tooltips"> {{$serv->service}} ( {{$serv->amount}} FCFA/an ) </i></label>
                                  </div>
                                  </div>
                                @endforeach
                              </div>
                                </div>
                            </div>
                            
                        </fieldset>
                        @endif

                        <div id="loader_quote" class="cd-testimonials-all">
                          <div class="cd-testimonials-all-wrapper" id="div_center" >
                            <div class="position-center-center text-center">
                              <div id="loader_img" class="text-center top_box">
                                <div style="margin-top:400px">
                                  <h5 class="loader_img">Plus que quelque instant...</h5>
                                  <img class="loader_img" src="{{asset('images/travel-loader.gif')}}" alt="" />
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
</div>

@endsection

