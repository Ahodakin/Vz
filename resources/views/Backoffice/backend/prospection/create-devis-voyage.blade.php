@extends('Backoffice.layouts.app')

@section("content")
    <div class="page page-forms-wizard">

        <div class="pageheader">

            <h2>Créer un Dévis Voyage<span></span></h2>

            <div class="page-bar">

                <ul class="page-breadcrumb">
                    <li>
                    <a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> AROLI ASSURANCE</a>
                    </li>
                    <li>
                        <a href="#">Créer un Dévis Voyage</a>
                    </li>  
                </ul>
             
            </div>

        </div>

        <!-- page content -->
        <div class="pagecontent">
            <!-- tile -->
                <section class="tile tile-simple">

                    <!-- tile body -->
                    <div class="tile-body p-0">

                        <div role="tabpanel">

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tabs-dark" role="tablist">
                                <li><a href="{{ route('devis.creer') }}">Automobile</a></li>
                                <li><a href="{{route('devis.moto.creer')}}">Moto</a></li>
                                <li role="presentation" class="active"><a href="#voyage" aria-controls="settingsTab" role="tab" data-toggle="tab">Voyage</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane active" id="voyage">

                                    <div class="wrap-reset">
                
                                        <form method="post" action="" name="devis" class="form-horizontal quoteForm">
                                        <div id="rootwizard" class="tab-container tab-wizard">
                                            @if (session('error'))
                                                <div class="alert alert-danger">
                                                {{ session('error') }}
                                                </div>
                                            @endif
                                            <ul class="nav nav-tabs nav-justified">
                                                <li><a href="#tab1" data-toggle="tab">Identité <span class="badge badge-default pull-right wizard-step">1</span></a></li>
                                                <li><a href="#tab2" data-toggle="tab">Profil de l'assuré <span class="badge badge-primary pull-right wizard-step">2</span></a></li>
                                                <li><a href="#tab3" data-toggle="tab">Assurance Voyage<span class="badge badge-primary pull-right wizard-step">3</span></a></li>
                                                @if(sizeof($optional_service)>0)
                                                <li><a href="#tab4" data-toggle="tab">Services optionnels<span class="badge badge-primary pull-right wizard-step">4</span></a></li>
                                                @endif
                                                
                                            </ul>
                                            <div class="tab-content">
                                                
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_form_type_" id="_token" value="{{encrypt('VOYAGE')}}">
                                                <div class="tab-pane" id="tab1">
                                                    <div name="step1">
                                                    <h3>Vous êtes</h3>
                                                    <div class="row" id="div_proprio_veh">
                                                        <div class="col-md-12 text-center">
                                                            <div class="form-group">
                                                                <label for="gender">Pour qui est fait le dévis :</label><br>
                                                                <label class="checkbox-inline checkbox-custom">
                                                                    <input id="particulier" name="proprio_veh" required value="P" data-parsley-group="block1" type="radio" ><i></i> Lui même
                                                                </label>
                                                                <label class="checkbox-inline checkbox-custom">
                                                                    <input id="particulier" name="proprio_veh" required value="A" data-parsley-group="block1" type="radio" ><i></i> Quelqu'un d'autre
                                                                </label>
                                                                <label class="checkbox-inline checkbox-custom">
                                                                    <input d="entreprise" data-parsley-group="block1" name="proprio_veh"  value="E" type="radio"><i></i> Une Entreprise
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="souscripteur_field" style="display:none; padding:15px;margin:10px" >
                                                        <div class="form-group">
                                                        <div class="col-md-6">
                                                            <label class="control-label input-label" for="souscripteur_name">Votre nom*</label>
                                                            <input type="text" data-parsley-group="block1" class="form-control" required  name="souscripteur_name" id="souscripteur_name" placeholder="Nom et prénom de la personne qui effectue le dévis">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="control-label input-label" for="phone_souscr">Votre Numéro de téléphone*</label>
                                                            <input data-parsley-group="block1" placeholder="Ex: 01020304" type="text" class="form-control" required name="phone_souscr" id="phone_souscr"> 
                                                        </div> 
                                                        </div>
                                                    </div>

                                                    </div>
                                                    
                                                </div>
                                                <div class="tab-pane" id="tab2">
                                                    <div id="step2">

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="alert alert-info alert-dismissable">Ces informations nous permetront de vous identifier et editer votre police d'assurance.</div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-6">
                                                        <label class="control-label input-label" for="lastname">Nom*</label>
                                                        <input type="text" required data-parsley-group="block2" class="form-control"required  name="lastname" id="lastname">
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label class="control-label input-label" for="firstname">Prénom*</label>
                                                        <input type="text" class="form-control" data-parsley-group="block2" required name="firstname" id="firstname">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-md-6">
                                                        <label class="control-label input-label" for="gender">Sexe*</label>
                                                        
                                                        <select required data-parsley-group="block2" class="form-control" required  name="gender" id="gender">
                                                            <option value="H">Homme</option>
                                                            <option value="M">Femme</option>
                                                        </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label class="control-label input-label" for="dob">Date de naissance*</label>
                                                        <div class='input-group datetimepicker_dob'>
                                                            <input type="text" class="form-control dob" required data-parsley-group="block2" name="dob" id="dob" placeholder="JJ/MM/AAAA">
                                                            <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>

                                                        </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-md-6">
                                                        <label class="control-label  input-label" id="label_email" for="email">Adresse email*</label>
                                                        <input placeholder="Ex: votreemail@email.com" data-parsley-group="block2" type="email" class="form-control" required name="email" id="email">
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label class="control-label input-label" for="phone">Numéro de téléphone*</label>
                                                        <input placeholder="Ex: 01020304" data-parsley-group="block2" type="text" class="form-control phone-ci" required name="phone" id="phone"> 
                                                        </div> 
                                                    </div>
                                                    
                                                    </div>
                                                    
                                                </div>
                                                
                                                <div class="tab-pane" id="tab3">

                                                    <div id="step3">                        
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
                                                                    <select class="form-control country" required data-parsley-group="bloc32" name="destination" id="destination" data-placeholder="Selectionner le pays de destination" style="width:100%;">
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
                                                                    <input data-parsley-group="block3" type='text' class="form-control date_departure" placeholder="DD/MM/YYYY" required name="date_departure" id="date_departure" />
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 ret">
                                                                    <label class="control-label input-label" for="date_arrival">Date de retour*</label>
                                                                    <div class='input-group datetimepicker_arrival'>
                                                                        <input data-parsley-group="block3" type='text' class="form-control date_arrival" placeholder="DD/MM/YYYY" required name="date_arrival" id="date_arrival" />
                                                                        <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                        </span>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="col-md-2">
                                                                <label class="control-label input-label" for="arrival">Durée(Jours)</label>
                                                                <input type="text" id="duree" readonly class="form-control">
                                                            </div> --}}
                                                        </div>
                                                        <div class="row" style="margin-bottom:25px">
                                                            <div class="col-md-4">
                                                                    <label class="control-label input-label" for="current_addr">Adresse actuelle</label>
                                                                    <textarea class="form-control" rows="3" name="current_addr" id="current_addr" placeholder="Entrez votre adresse actuelle"></textarea>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="control-label input-label" for="dest_addr">Adresse de destination*</label>
                                                                <textarea class="form-control" data-parsley-group="block3" required rows="3" name="dest_addr" id="dest_addr" placeholder="Entrez votre adresse de destination"></textarea>

                                                            </div>
                                                        </div>

                                                            <div class="row" style="margin-bottom:25px">
                                                            <div class="col-md-4">
                                                                    <label class="control-label input-label" for="nationality">Votre nationnalité*</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                                                                    <select class="form-control country" required data-parsley-group="block3" name="nationality" id="nationality" data-placeholder="Selectionner votre nationnalité" style="width:100%;">
                                                                        <option></option>
                                                                        @foreach($pays as $p)
                                                                        <option value="{{$p->pays_id}}"  {{ ($p->pays_code=="ci")?'selected':'' }}>{{$p->pays_name}}</option>           
                                                                        @endforeach
                                                                    </select>
                                                                    </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="control-label input-label" for="num_passport">N° passeport*</label>
                                                                <input type="text" data-parsley-group="block3" required class="form-control" name="num_passport" id="num_passport" placeholder="Entrez votre N° passeport">

                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="control-label input-label" for="expire_passport">Date d'expiration passeport*</label>
                                                                

                                                                <div class='input-group expire_passport'>
                                                                        <input type="text" data-parsley-group="block3" required class="form-control expire_passport" name="expire_passport" id="expire_passport" placeholder="Date d'expiration passeport">
                                                                        <span class="input-group-addon ">
                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                        </span>
                                                                </div>

                                                            </div>
                                                            </div>
                                                        <div class="row" style="margin-bottom:25px">
                                                            <div class="col-md-12">
                                                                <label class="control-label input-label" for="pref_comp">Avez vous une préfenrence pour une compagnie particulière?</label>
                                                                <select required data-parsley-group="block2" class="form-control" name="pref_comp" id="pref_comp">
                                                                <option value="0">NON</option>
                                                                @foreach($companies as $c)
                                                                <option value="{{$c->id}}">{{$c->compname}}</option>
                                                                @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        
                                                        
                                                    </div>
                                                </div>
                                                @if(sizeof($optional_service)>0)
                                                <div class="tab-pane" id="tab3">

                                                    <div id="step3"> 

                                                    </div>
                                                </div>
                                                @endif
                                                {{-- <br> --}}
                                                <ul class="pager wizard">

                                                    <li class="previous"><a class="btn btn-default">Précédent</a></li>
                                                    <li class="next"><a class="btn btn-default">Suivant</a></li>
                                                    <li class="next finish" style="display:none;"><button type="submit" class="btn btn-success">Générer dévis</button></li>
                                                </ul>

                                            </div>
                                        </div>
                                        </form>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- /tile body -->

                </section>
            <!-- /tile --> 
        </div>
        <!-- /page content -->
    </div>
@endsection



@section('header-script')
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
@stop
      

@section('footer-script')
<script src="<?php echo asset('back/assets/js/vendor/parsley/parsley.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/form-wizard/jquery.bootstrap.wizard.min.js'); ?>"></script>
<script src="{{asset('back/assets/js/vendor/daterangepicker/moment.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
@stop

@section('custom-script')
    <script>
$(window).load(function(){

$('#rootwizard').bootstrapWizard({
    'tabClass': 'bwizard-steps',
    onTabShow: function(tab, navigation, index) {
        var $total = navigation.find('li').length;
        var $current = index+1;

        // If it's the last tab then hide the last button and show the finish instead
        if($current >= $total) {
            $('#rootwizard').find('.pager .next').hide();
            $('#rootwizard').find('.pager .finish').show();
            $('#rootwizard').find('.pager .finish').removeClass('disabled');
        } else {
            $('#rootwizard').find('.pager .next').show();
            $('#rootwizard').find('.pager .finish').hide();
        }

    },
    onNext: function(tab, navigation, index) {

        var valid = $(".quoteForm").parsley().validate('block' + index);

            return valid;
        

    },

    onTabClick: function(tab, navigation, index) {

      var valid = $(".quoteForm").parsley().validate('block' + index);

            return valid;

    }
 });

$('.datetimepicker_dob').datetimepicker({
  format: 'DD/MM/YYYY',
  viewMode: 'years',
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



$(".phone-ci").inputmask("99999999",{ "placeholder": "XXXXXXXX","alias": "phone" });
});

function switchProprioVeh(){
    if($('input[name=proprio_veh]:checked').val()=='E' || $('input[name=proprio_veh]:checked').val()=='A'){
      $('.souscripteur_field').show()
      $("#souscripteur_name").attr("required","true");     
      $("#souscripteur_name").attr("data-parsley-group","block1");
      $("#email_sousc").attr("required","true");     
      $("#email_sousc").attr("data-parsley-group","block1");
      $("#phone_souscr").attr("required","true");     
      $("#phone_souscr").attr("data-parsley-group","block1");
      $('#label_email').html("Adresse email de l'assuré"); 
      $("#email").removeAttr("required");     
      $("#email").removeAttr("data-parsley-group"); 
    }else{
      $('.souscripteur_field').hide()
      $("#souscripteur_name").removeAttr("required");     
      $("#souscripteur_name").removeAttr("data-parsley-group");
      $("#email_sousc").removeAttr("required");     
      $("#email_sousc").removeAttr("data-parsley-group");
      $("#phone_souscr").removeAttr("required");     
      $("#phone_souscr").removeAttr("data-parsley-group");
      $('#label_email').html("Adresse email de l'assuré*");
      $("#email").attr("required","true");     
      $("#email").attr("data-parsley-group","block2"); 

    }
     $('#rootwizard').bootstrapWizard('next')
}

$("input[name=proprio_veh]").click(function (e){
    switchProprioVeh();       
   
})
</script>
        <!--/ Page Specific Scripts -->
@stop 

