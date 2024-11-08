@extends('Backoffice.layouts.app')

@section("content")
    <div class="page page-forms-wizard">

        <div class="pageheader">
            <h2>Créer un Dévis<span></span></h2>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                    <a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> AROLI ASSURANCE</a>
                    </li>
                    <li>
                        <a href="#">Créer un Dévis</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- page content -->
        <div class="pagecontent">
            <section class="tile tile-simple">
                <div class="tile-body p-0">
                    <div role="tabpanel">
                    <!-- Nav tabs -->
                        <ul class="nav nav-tabs tabs-dark" role="tablist">
                            <li role="presentation"><a href="{{ route('devis.creer') }}">Automobile</a></li>
                            <li role="presentation" class="active"><a href="#moto" aria-controls="settingsTab" role="tab" data-toggle="tab">Moto</a></li>
                            <li><a href="{{route('devis.voyage.creer')}}">Voyage</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="moto">
                                <div class="wrap-reset">
                                    <form method="post" action="{{route('devis.moto.post')}}" name="devis" class="quoteForm">
                                        <div id="rootwizard" class="tab-container tab-wizard">
                                            @if (session('error'))
                                                <div class="alert alert-danger">
                                                    {{ session('error') }}
                                                </div>
                                            @endif
                                            <ul class="nav nav-tabs nav-justified">
                                                <li><a href="#tab1" data-toggle="tab">Identité <span class="badge badge-default pull-right wizard-step">1</span></a></li>
                                                <li><a href="#tab2" data-toggle="tab">Assurance <span class="badge badge-default pull-right wizard-step">2</span></a></li>
                                                <li><a href="#tab3" data-toggle="tab">Information du Véhicule <span class="badge badge-default pull-right wizard-step">3</span></a></li>
                                                <li><a href="#tab4" data-toggle="tab">Profil de l'assuré <span class="badge badge-default pull-right wizard-step">4</span></a></li>
                                                <li><a href="#tab5" data-toggle="tab">Services optionnels <span class="badge badge-default pull-right wizard-step">5</span></a></li>     
                                            </ul>
                                            <div class="tab-content">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_form_type_" id="_form_type_" value="{{encrypt('AUTO')}}">
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
                                                        

                                                        <div id="formulae_section">
                                                            <div class="row" style="margin-bottom:10px">
                                                                <div class="col-md-6">
                                                                    <label class="control-label input-label" for="priseeffet">Date de prise d'effet du contrat souhaitée*</label>
                                                                    <div class="input-group datepicker w-330 mt-8" >
                                                                        <input type="text" data-parsley-group="block2" required name="priseeffet" id="priseeffet" class="form-control datepicker">
                                                                        <span class="input-group-addon">
                                                                            <span class="fa fa-calendar"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="control-label input-label" for="priseeffet">Périodicité*</label>
                                                                    <select class="form-control" data-parsley-group="block2" required id="periode" name="periode">
                                                                    @foreach($periodes as $p)
                                                                        @if($p->id==1)
                                                                        <option value="{{$p->id}}">{{$p->periode}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label class="control-label input-label" for="pref_comp">Avez vous une préférence pour une compagnie particulière?</label>
                                                                    <select class="form-control" name="pref_comp" id="pref_comp">
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

                                                                <div class="radio radio-primary radio-inline">
                                                                <input type="radio" id="guaranteetype" value="G" name="souscription">
                                                                <label for="guaranteetype"> Selectionner vos Garanties (Option avancée) </label>
                                                                </div>                   
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-12">                 
                                                                    <div id="div-garantie" style="display:none" class="col-md-6">
                                                                        <label class="control-label input-label" for="">Garanties*</label><br/>
                                                                        @foreach($guarantees as $g)
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
                                                                        <label class="control-label input-label" for="">Formule*</label><br/>
                                                                        <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="col-md-6">
                                                                            <div class="radio radio-primary">
                                                                                <input type="radio" id="tsimple" value="tsimple" name="formule" checked>
                                                                                <label for="tsimple" id="lb_tsimple"> <i title="L’assurance « au tiers » est la formule d’assurance auto la plus basique et la moins chère. Contrairement à la couverture optimale du contrat « tous risques », la formule « au tiers » ne dédommage que les préjudices physiques et matériels causés à un tiers en cas d’accident." class="tooltips">Tiers Simple </i></label>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                        

                                                                        
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

                                                            
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab3">
                                                    <div name="step3">
                                                        <div class="row">                                         
                                                            <div class="form-group col-md-11 {{ $errors->has('immat') ? ' has-error' : '' }}">
                                                                    <label for="energie">Immatriculation*</label>
                                                                        <input type="text" name="immat" id="immat" class="form-control" onkeyup ="this.value = this.value.toUpperCase();" required value="{{old('immat')}}" data-parsley-group="block3">
                                                                        @if ($errors->has('immat'))
                                                                            <span class="help-block ">
                                                                                <strong>{{ $errors->first('immat') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-6 {{ $errors->has('lastname_cg') ? ' has-error' : '' }}">
                                                                    <label for="name_cg">Nom sur carte grise* </label>
                                                                    <input type="text" value="{{ old('name_cg')}}" name="name_cg" id="name_cg" required data-parsley-group="block3" class="form-control">
                                                                    @if ($errors->has('name_cg'))
                                                                        <span class="help-block ">
                                                                            <strong>{{ $errors->first('name_cg') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div class="form-group col-md-6 {{ $errors->has('marque') ? ' has-error' : '' }}">
                                                                <label for="marque">Marque de la moto* </label>
                                                                <input type="text" placeholder="Selectionner la marque de votre moto" class="form-control" required data-parsley-group="block3" name="marque" id="marque">
                                                                @if ($errors->has('marque'))
                                                                    <span class="help-block ">
                                                                        <strong>{{ $errors->first('marque') }}</strong>
                                                                    </span>
                                                                @endif
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-4 {{ $errors->has('genre') ? ' has-error' : '' }}">
                                                                    <label for="genre">Genre du vehicule* </label>
                                                                    <select id="genre" name="genre" class="form-control" data-parsley-group="block3" required>
                                                                            @foreach($car_types as $type)
                                                                            <option value="{{ $type->id_type }}">{{ $type->car_type_desc }}</option>
                                                                            @endforeach 
                                                                    </select>
                                                                    @if ($errors->has('genre'))
                                                                        <span class="help-block ">
                                                                            <strong>{{ $errors->first('genre') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div class="form-group col-md-4 {{ $errors->has('category') ? ' has-error' : '' }}">
                                                                    <label for="category">Categorie / Usage du véhicule* </label>
                                                                    <select id="category" name="category" class="form-control" required data-parsley-group="block3">
                                                                            @foreach($categories as $cat)
                                                                            @if($cat->id==5)
                                                                            <option value="{{$cat->id}}" {{ (old("category") == $cat->id) ? "selected":""}}>({{$cat->id}}) {{$cat->shortdesc}}</option>
                                                                            @endif
                                                                            @endforeach 
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="control-label input-label" for="cylindree">Cylindrée (cm3)*</label>     
                                                                    <select class="form-control" name="cylindree" id="cylindree" required data-parsley-group="block3">
                                                                        <option value="1">0-50</option>
                                                                        <option value="2">51-99</option>
                                                                        <option value="3">100-175</option>
                                                                        <option value="4">176-350</option>
                                                                        <option value="5">Plus de 350</option>
                                                                    </select>  
                                                                </div> 
                                                            </div>
                                                            
                                                            <div class="row">  
                                                                <div class="form-group col-md-3 {{ $errors->has('cu') ? ' has-error' : '' }}" id="div_cu" style="display:none">
                                                                    <label for="cu">Charge utile: </label>
                                                                    <select class="form-control form-step1" name="cu" id="cu">

                                                                        <option></option>
                                                                        <?php for ($i=1; $i <=15 ; $i++) { ?>
                                                                        <option value="<?= $i ?>" {{ (old("cu") == $i) ? "selected":""}}><?= $i ?> T</option>  
                                                                        <?php } ?>
                                                                        <option value="13">Plus de 15</option>

                                                                    </select>
                                                                    @if ($errors->has('cu'))
                                                                        <span class="help-block ">
                                                                            <strong>{{ $errors->first('cu') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                
                                                            </div>
                                                        
                                                            

                                                            <div class="row">
                                                                <div class="form-group col-md-3 {{ $errors->has('dateMiseCirc') ? ' has-error' : '' }}">
                                                                    <label for="city">Date 1ère mise en circulation* </label>
                                                                    <div class='input-group datetimepicker_dateMiseCirc'>
                                                                        <input type='text' class="form-control dateMiseCirc" required data-parsley-group="block3" name="dateMiseCirc" id="dateMiseCirc" placeholder="JJ/MM/AAAA" />
                                                                        <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-3 {{ $errors->has('city') ? ' has-error' : '' }}">
                                                                    <label for="city">Zone de stationnement* </label>
                                                                    <select id="city" name="city" class="form-control" data-parsley-group="block3" required>
                                                                        @foreach($zones as $zone)
                                                                            <option value="{{$zone->id}}" {{ (old("city") == $zone->id) ? "selected":""}}>{{$zone->city}}</option>
                                                                        @endforeach  
                                                                    </select>
                                                                    @if ($errors->has('city'))
                                                                        <span class="help-block ">
                                                                            <strong>{{ $errors->first('city') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div class="form-group col-md-3 {{ $errors->has('nbplace') ? ' has-error' : '' }}">
                                                                    <label for="nbplace">Nombre de place* : </label>
                                                                    <input type="number" min="1" value="{{ old('nbplace')}}" name="nbplace" id="nbplace" class="form-control" data-parsley-group="block3" required>
                                                                    @if ($errors->has('nbplace'))
                                                                        <span class="help-block ">
                                                                            <strong>{{ $errors->first('nbplace') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                
                                                                <div class="form-group col-md-3 {{ $errors->has('nbplace') ? ' has-error' : '' }}">
                                                                    <label for="nbplace">Couleur*: </label>
                                                                    <select class="form-control" data-parsley-group="block3" required name="color" id="color" data-placeholder="Couleur du véhicule">
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
                                                                    @if ($errors->has('nbplace'))
                                                                        <span class="help-block ">
                                                                            <strong>{{ $errors->first('nbplace') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tab4">
                                                        <div name="step4">
                                                            <div class="row particulier_field">
                                                                <div class="form-group col-md-6 mb-0 {{ $errors->has('lastname') ? ' has-error' : '' }}">
                                                                    <label for="lastname">Nom*: </label>
                                                                    <input type="text" value="{{ old('lastname') }}" name="lastname" id="lastname" class="form-control" data-parsley-group="block4" required>
                                                                    @if ($errors->has('lastname'))
                                                                        <span class="help-block ">
                                                                            <strong>{{ $errors->first('lastname') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div class="form-group col-md-6 mb-0 {{ $errors->has('firstname') ? ' has-error' : '' }}">
                                                                    <label for="firstname">Prénoms*: </label>
                                                                    <input type="text" data-parsley-group="block4" value="{{ old('firstname') }}" name="firstname" id="firstname" class="form-control" required>
                                                                    @if ($errors->has('firstname'))
                                                                        <span class="help-block ">
                                                                            <strong>{{ $errors->first('firstname') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group entreprise_field" style="display:none">
                                                                <div class="col-md-6">
                                                                    <label class="control-label input-label" for="company_name">Nom de l'entreprise*</label>
                                                                    <input type="text" data-parsley-group="block4" class="form-control repeat" required data-parsley-group="block4"  name="company_name" id="company_name">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="control-label input-label" for="name_manager">Nom du gérant</label>
                                                                    <input type="text" class="form-control" name="manager_name" id="manager_name">
                                                                </div>
                                                            </div>
                                                            <br/>
                                                            <div class="row">
                                                                <div class="form-group col-md-6 mb-0 {{ $errors->has('email') ? ' has-error' : '' }}">
                                                                    <label for="email">E-mail: </label>
                                                                    <input type="email" value="{{ old('email') }}" name="email" id="email" class="form-control" >
                                                                    @if ($errors->has('email'))
                                                                        <span class="help-block ">
                                                                            <strong>{{ $errors->first('email') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div class="form-group col-md-6 mb-0 {{ $errors->has('phone') ? ' has-error' : '' }}">
                                                                    <label for="phone">Contact*: </label>
                                                                    <input type="text" name="phone" id="phone" class="form-control" value="{{old('phone')}}" required data-parsley-group="block4">
                                                                    @if ($errors->has('phone'))
                                                                        <span class="help-block ">
                                                                            <strong>{{ $errors->first('phone') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row particulier_field">
                                                                <div class="col-md-6 {{ $errors->has('gender') ? ' has-error' : '' }} " >
                                                                    <label class="control-label input-label" for="gender">Sexe*</label>
                                                                    <select data-parsley-group="block4" class="form-control"required  name="gender" id="gender">
                                                                        <option value="H">Homme</option>
                                                                        <option value="F">Femme</option>
                                                                    </select>
                                                                    @if ($errors->has('gender'))
                                                                        <span class="help-block ">
                                                                            <strong>{{ $errors->first('gender') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="control-label input-label" for="dob">Date de naissance</label>
                                                                    <div class="input-group datepicker w-330 mt-8" >
                                                                        <input type="text"  name="dob" id="dob" class="form-control">
                                                                        <span class="input-group-addon">
                                                                            <span class="fa fa-calendar"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        
                                                            <div class="row particulier_field">
                                                                <div class="form-group col-md-6 mb-0 {{ $errors->has('job') ? ' has-error' : '' }} ">
                                                                    <label for="job">Profession*: </label>
                                                                    <select id="job" name="job" data-parsley-group="block4" class="form-control" required>
                                                                            @foreach($jobs as $job)
                                                                                    <option value="{{$job->id}}" {{ (old("job") == $job->id) ? "selected":""}}>{{$job->jobtitle}}</option>
                                                                            @endforeach  
                                                                    </select>
                                                                    @if ($errors->has('job'))
                                                                        <span class="help-block ">
                                                                            <strong>{{ $errors->first('job') }}</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div class="form-group col-md-6 mb-0 {{ $errors->has('datePC') ? ' has-error' : '' }}">
                                                                    <label class="control-label input-label" for="datePC">Date de delivrance permis de conduire</label>
                                                                    <div class='input-group datetimepicker_datePC'>
                                                                        <input  type='text' class="form-control datePC" name="datePC" id="datePC" placeholder="JJ/MM/AAAA" />
                                                                        <span class="input-group-addon">
                                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                                        </span>
                                                                        @if ($errors->has('datePC'))
                                                                            <span class="help-block">
                                                                                <strong>{{ $errors->first('datePC') }}</strong>
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tab5">
                                                        <div name="step5">
                                                            <div class="row text-center">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <p class="text-center" style="font-size:16px;color:red">Je souhaites souscrire à ces services supplémentaires </p>
                                                                        @foreach($optional_services as $serv)
                                                                            <div class="col-md-6">
                                                                            <div class="checkbox checkbox-primary">
                                                                            <input type="checkbox" id="{{$serv->service}}" checked value="{{$serv->id}}" name="opt_serv[]">
                                                                            <label class="checkpopover" for="{{$serv->service}}"> {{$serv->service}} ( {{$serv->amount}} FCFA/mois ) </label>
                                                                            </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                    </div>
                                                    <br>
                                                    <ul class="pager wizard">

                                                        <li class="previous"><a class="btn btn-default">Précédent</a></li>
                                                        <li class="next"><a class="btn btn-default">Suivant</a></li>
                                                        <li class="next finish" style="display:none;"><button type="submit" class="btn btn-success">Générer dévis</button></li>
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
    $("#guaranteetype").click(function (e){        
                    $("#div-formule").hide();
                    $("#div-garantie").show();
                });

                 $("#formuletype").click(function (e){        
                    $("#div-garantie").hide();
                    $("#div-formule").show();
                });
$(window).load(function(){
  function getGuarantiesFormule (idcomp, formule) {
    $.get("/rest-api/v1/getguaranties/"+idcomp+"/"+formule, function(data) {
      if(data!=0){
        $("#info2").html("Les garanties de la compagnie selectionnée correspondant à cette formule sont : "+data)
      }
      else{
        $("#info2").html("")

      }
    })
  }

  function switchInfo(){
    if($('input[name=formule]:checked').val()=='tsimple'){
         $("#info1").html("L'assurance au tiers est la formule Auto la plus basique.");
         getGuarantiesFormule($("#pref_comp option:selected").val(), 'tsimple');
    } 
    else if($('input[name=formule]:checked').val()=='tcomplet'){
        $("#info1").html("Avec un niveau de protection correct, cette formule repond à la demande de nombreux automobiliste avec un meilleur rapport qualité prix.");
        getGuarantiesFormule($("#pref_comp option:selected").val(), 'tcomplet');
    }
    else if($('input[name=formule]:checked').val()=='tcol'){
        $("#info1").html("");
        getGuarantiesFormule($("#pref_comp option:selected").val(), 'tcol');
    }
    else if($('input[name=formule]:checked').val()=='trisque'){
        $("#info1").html("Circulez tranquille! Cette formule est la formule d'assurance la plus complète.");
        getGuarantiesFormule($("#pref_comp option:selected").val(), 'toutrisque');
    }
  }

  $("input[name=formule]").click(function (e){
    switchInfo();
  })

  $( "#pref_comp" ).change(function() {
  switchInfo();
  });

  $( "#periode" ).change(function() {
    if($(this).val()==2){
      $('.disable_mens').attr("disabled",true);
    }else{
      $('.disable_mens').removeAttr("disabled");
    }
  });

  $('#category').on('change', function() {
        if(this.value=="2" || this.value=="3" || this.value=="8")
          $('#div_cu').show()
        else
          $('#div_cu').hide()
    })

  $("input[name=souscription]").click(function (e){
    if($('input[name=souscription]:checked').val()=='G'){
         $("#info1").html("Vous avez selectionnez le type de souscription avancé. Cochez les garanties souhaitées.");
         $("#info2").html("");
    } 
    else if($('input[name=souscription]:checked').val()=='tsimple'){
        $("#info1").html("L'assurance au tiers est la formule Auto la plus basique.");
        $('#input[name=formule, value=tsimple]').prop('checked', true);
         getGuarantiesFormule($("#pref_comp option:selected").val(), 'tsimple');
    }
  })
  function check_immatriculation(mat){    
    $.get("/rest-api/v1/searchcar/"+mat, function(data) {
      if(data!=0){
        $("#immat-result").html("<img src='/images/available.png' />"); 
        $("#mat_help-block").html("Un véhicule a été trouvé"); 
        $( "#mat_help-block" ).prop( "style", "color:green" );
        var d = JSON.parse(data);
       console.log(d)
        $("#marque").val(d.make_id); 
        $("#genre").val(d.type_id);
        $("#name_cg").val(d.name_cg);
        $("#puissance").val(d.power);
        $("#category").prop("disabled",false);
        $("#category").val(d.category);
        if(d.charge_utile>0){
          $("#div_cu").show();
          $("#cu").val(d.charge_utile);
        }
        date_firstrelease = d.firstrelease.split("-");
        $("#dateMiseCirc").val(date_firstrelease[2]+"/"+ date_firstrelease[1] +"/"+ date_firstrelease[0]);

        $("#nbplace").val(d.placesnumber);
        $("#vneuve").val(d.vneuve);
        $("#vvenale").val(d.vvenale);
        $("#city").val(d.parkingzone);
        $("#ennergie").val(d.energy);
        $("#color").val(d.color);
        $("#genre").val(d.type_id);
      }
      else{
        $( "#mat_help-block" ).prop( "style", "color:red" );
        $("#immat-result").html("<img src='/images/not-available.png' />");
        $("#mat_help-block").html("Aucun véhicule ne correspond à ce numéro d'immatriculation"); 
        $("#marque").val("");
        $("#puissance").val("");
        $("#category").val("");
        $("#nbplace").val("");
        ("#vneuve").val("");
        $("#vvenale").val("");
        $("#city").val("");
        $("#cu").val("");
        $("#color").val("");
        $("#genre").val("");
      }
    });
    $("#searchmat").prop('disabled',false);
  }  
        
$('.datetimepicker_dateMiseCirc').datetimepicker({
            format: 'DD/MM/YYYY',
            viewMode: 'years',
            maxDate:moment()
          });

$('.datetimepicker_datePC').datetimepicker({
  format: 'DD/MM/YYYY',
    maxDate:moment(),
    viewMode: 'years'
});
  $("#searchmat").click(function (e){
    event.preventDefault();     
    $("#immat-result").html('<img src="/images/ajaxloader.gif" />');
    $("#searchmat").prop('disabled',true);
    x_timer = setTimeout(function(){
        var immat = $('#immat').val();
        check_immatriculation(immat);
    }, 1000);
    
  });

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
              if(index==1 && ($('#souscripteur_name').val()=='' || $('#phone_souscr').val()=='') && $('#souscripteur_name').is(':required')) return false
                
              return valid; 
          

      },

      onTabClick: function(tab, navigation, index) {

        var i = index+1;
          var valid = $(".quoteForm").parsley().validate('block' + i);
             if(index==1 && ($('#souscripteur_name').val()=='' || $('#phone_souscr').val()=='') && $('#souscripteur_name').is(':required')) return false
                
              return valid;

      }
   });

    $("#genre").change(function () {
      $("#category").val('')
      $("#category").children('option').hide();
      if($(this).val()==1){
        $("#category").attr('disabled',false)
        $("#category").children("option[value=" + 1 + "]").show()
        $("#category").children("option[value=" + 8 + "]").show()
        $("#category").children("option[value=" + 12 + "]").show()
      }
      else if($(this).val()==2){
        $("#category").attr('disabled',false)
        $("#category").children("option[value=" + 1 + "]").show()
        $("#category").children("option[value=" + 8 + "]").show()
        $("#category").children("option[value=" + 12 + "]").show()
      }
      else if($(this).val()==''){
        $("#category").attr('disabled',true)
      }
      else {
        $("#category").attr('disabled',false)
        $("#category").children("option[value=" + 2 + "]").show()
        $("#category").children("option[value=" + 3 + "]").show()
        $("#category").children("option[value=" + 8 + "]").show()
      }
      
  })  

function switchProprioVeh(){
    if($('input[name=proprio_veh]:checked').val()=='E'){
      $('.particulier_field').hide()
        $('.entreprise_field').show()
        $("#lastname").removeAttr("required");     
      $("#lastname").removeAttr("data-parsley-group"); 
      $("#firstname").removeAttr("required");     
      $("#firstname").removeAttr("data-parsley-group"); 
      $("#job").removeAttr("required");     
      $("#job").removeAttr("data-parsley-group"); 
      $("#datePC").removeAttr("required");     
      $("#datePC").removeAttr("data-parsley-group"); 

      $("#company_name").attr("required","true");     
      $("#company_name").attr("data-parsley-group","block4"); 
    }
    else{
      $('.particulier_field').show()
      $('.entreprise_field').hide()

      $("#lastname").attr("required","true");     
      $("#lastname").attr("data-parsley-group","block4"); 
      $("#firstname").attr("required","true");     
      $("#firstname").attr("data-parsley-group","block4"); 
      $("#job").attr("required","true");     
      $("#job").attr("data-parsley-group","block4"); 
      $("#datePC").attr("required","true");     
      $("#datePC").attr("data-parsley-group","block4"); 

      $("#company_name").removeAttr("required");     
      $("#company_name").removeAttr("data-parsley-group"); 
    }

    if($('input[name=proprio_veh]:checked').val()=='E' || $('input[name=proprio_veh]:checked').val()=='A'){
      $('.souscripteur_field').show()
      $("#souscripteur_name").attr("required","true");     
      $("#souscripteur_name").attr("data-parsley-group","block1");
      $("#phone_souscr").attr("required","true");     
      $("#phone_souscr").attr("data-parsley-group","block1");
    }else{
      $('.souscripteur_field').hide()
      $("#souscripteur_name").removeAttr("required");     
      $("#souscripteur_name").removeAttr("data-parsley-group");
      $("#phone_souscr").removeAttr("required");     
      $("#phone_souscr").removeAttr("data-parsley-group");

    }
     $('#rootwizard').bootstrapWizard('next')
}

$("input[name=proprio_veh]").click(function (e){
    switchProprioVeh();       
})

$('input[name=formule]').change(function(){
          if($('input[name=formule]:checked').val()=='tsimple'){
            $('.if_not_tiers_simple').hide();
            $("#vneuve").removeAttr("required");     
            $("#vneuve").removeAttr("data-parsley-group"); 
            $("#vvenale").removeAttr("required");     
            $("#vvenale").removeAttr("data-parsley-group"); 
          }else{
            $('.if_not_tiers_simple').show(); 
            $("#vneuve").attr("required", "true");     
            $("#vneuve").attr("data-parsley-group", "block2");     
            $("#vvenale").attr("required", "true");     
            $("#vvenale").attr("data-parsley-group", "block2");     
          }
        });

  $("input[name=name_cg]").keyup(function  () {
    if($('input[name=proprio_veh]:checked').val()=='E')
      $("#company_name").val($(this).val())
    else
      $("#lastname").val($(this).val())
  })
});
</script>
        <!--/ Page Specific Scripts -->
@stop

