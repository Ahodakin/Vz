@extends('Backoffice.layouts.app')

@section("content")
 @foreach($client as $client) 
    <div class="page page-shop-single-product">
        <div class="pageheader">

            <h2>Compte client</h2>

            <div class="page-bar">

                <ul class="page-breadcrumb">
                    <li>
                    <a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> AROLI ASSURANCE</a>
                    </li>
                    <li>
                        <a href="#">Clients</a>
                    </li>
                    <li>
                        <a href="#">{{$client->firstname}} {{$client->lastname}} </a>
                    </li>
                </ul>
                
            </div>
        </div>
        <div class="pagecontent">
            <div class="add-nav">
                <div class="nav-heading">
                    <h3>{{$client->firstname}} {{$client->lastname}}</h3>
                    <span class="controls pull-right">
                        <a href="javascript:;" class="btn btn-ef btn-ef-1 btn-ef-1-default btn-ef-1a btn-rounded-20 mr-5" data-toggle="modal" data-target="#modal_devis"><i class="fa fa-plus"></i> Nouveau devis</a>
                    </span>
                </div>
                <div role="tabpanel">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">Infos Perso</a></li>
                         <li role="presentation"><a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab">Devis/Commandes</a></li>
                         <li role="presentation"><a href="#notes" aria-controls="notes" role="tab" data-toggle="tab">Note</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="details">
                            <div class="row">
                                <!-- col -->
                                <div class="col-md-12">

                                    <!-- tile -->
                                    <section class="tile time-simple">

                                        <!-- tile body -->
                                        <div class="tile-body">


                                            <!-- row -->
                                            <div class="row">

                                                <div class="col-md-3" style="z-index:2">

                                                    <a href="javascript:;"  data-toggle="modal" data-target="#modal_client" class="btn btn-default btn-rounded-20 btn-xs pull-right"><i class="fa fa-pencil"></i></a>
                                                    <p class="text-uppercase text-strong mb-10 custom-font">{{ get_users_status($client->usertype) }}</p>
                                                    <ul class="list-unstyled text-default lt mb-20">
                                                        <li><strong class="inline-block w-xs">Nom:</strong> {{$client->lastname}}</li>
                                                        <li><strong class="inline-block w-xs">Prenoms:</strong> {{$client->firstname}}</li>
                                                        <li><strong class="inline-block w-xs">Contact:</strong> {{$client->contact}}</li>
                                                        <li><strong class="inline-block w-xs"> Email:</strong> <a href="javascript:;">{{$client->email}}</a></li>
                                                    </ul>
                                                </div>

                                                <!-- col -->
                                                <div class="col-md-8">
                                                
                                                    <!-- col -->
                                                    <div class="card-container col-lg-3 col-sm-6 col-sm-12">
                                                        <div class="card">
                                                            <div class="front bg-greensea">

                                                                <!-- row -->
                                                                <div class="row">
                                                                    <!-- col -->
                                                                    <div class="col-xs-4">
                                                                        <i class="fa fa-send fa-3x"></i>
                                                                    </div>
                                                                    <!-- /col -->
                                                                    <!-- col -->
                                                                    <div class="col-xs-8">
                                                                        <p class="text-elg text-strong mb-0">{{sizeof($devis)}}</p>
                                                                        <span>Dévis</span>
                                                                    </div>
                                                                    <!-- /col -->
                                                                </div>
                                                                <!-- /row -->

                                                            </div>
                                                            <div class="back bg-greensea">

                                                                <!-- row -->
                                                                <div class="row">
                                                                    
                                                                    <!-- col -->
                                                                    <div class="col-xs-12">
                                                                        <a href=#><i class="fa fa-chain-broken fa-2x"></i> Détails</a>
                                                                    </div>
                                                                    <!-- /col -->
                                                                </div>
                                                                <!-- /row -->

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /col -->
                                                    <!-- col -->
                                                    <div class="card-container col-lg-3 col-sm-6 col-sm-12">
                                                        <div class="card">
                                                            <div class="front bg-blue">

                                                                <!-- row -->
                                                                <div class="row">
                                                                    <!-- col -->
                                                                    <div class="col-xs-4">
                                                                        <i class="fa fa-shopping-cart fa-3x"></i>
                                                                    </div>
                                                                    <!-- /col -->
                                                                    <!-- col -->
                                                                    <div class="col-xs-8">
                                                                        <p class="text-elg text-strong mb-0">{{sizeof($commandes)}}</p>
                                                                        <span>Commande(s)</span>
                                                                    </div>
                                                                    <!-- /col -->
                                                                </div>
                                                                <!-- /row -->

                                                            </div>
                                                            <div class="back bg-lightred">

                                                                <!-- row -->
                                                                <div class="row">
                                                                    
                                                                    <!-- col -->
                                                                    <div class="col-xs-12">
                                                                        <a href=#><i class="fa fa-chain-broken fa-2x"></i> Détails</a>
                                                                    </div>
                                                                    <!-- /col -->
                                                                </div>
                                                                <!-- /row -->

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /col -->
                                                    <div class="card-container col-lg-3 col-sm-6 col-sm-12">
                                                        <div class="card">
                                                            <div class="front bg-lightred">

                                                                <!-- row -->
                                                                <div class="row">
                                                                    <!-- col -->
                                                                    <div class="col-xs-4">
                                                                        <i class="fa fa-file fa-3x"></i>
                                                                    </div>
                                                                    <!-- /col -->
                                                                    <!-- col -->
                                                                    <div class="col-xs-8">
                                                                        <p class="text-elg text-strong mb-0">{{sizeof($contrats)}}</p>
                                                                        <span>Contrat(s)</span>
                                                                    </div>
                                                                    <!-- /col -->
                                                                </div>
                                                                <!-- /row -->

                                                            </div>
                                                            <div class="back bg-lightred">

                                                                <!-- row -->
                                                                <div class="row">
                                                                    
                                                                    <!-- col -->
                                                                    <div class="col-xs-12">
                                                                        <a href=#><i class="fa fa-chain-broken fa-2x"></i> Détails</a>
                                                                    </div>
                                                                    <!-- /col -->
                                                                </div>
                                                                <!-- /row -->

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /col -->

                                                  
                                                </div>
                                                <!-- /col -->

                                            </div>
                                            <!-- /row -->


                                        </div>
                                        <!-- /tile body -->

                                    </section>
                                    <!-- /tile -->

                                </div>
                                <!-- /col -->
                            </div>
                            <!-- /row -->
                        </div>
                        <!-- tab in tabs -->
                                   
                                    
                                  
                        <div role="tabpanel" class="tab-pane" id="reviews">
                            <!-- row -->
                            <div class="row">
                                <!-- col -->
                                <div class="col-md-12">



                                    <!-- tile -->
                                    <section class="tile">

                                        <!-- tile header -->
                                        <div class="tile-header dvd dvd-btm">
                                            <h1 class="custom-font"> Mes commandes</h1>
                                        </div>
                                        <!-- /tile header -->

                                        <!-- tile body -->
                                        <div class="tile-body p-0">

                                            <div class="table-responsive">
                                                <table class="table table-hover table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>N COMMANDE</th>
                                                        <th>Type contrat</th>
                                                        <th>Valeur</th>
                                                        <th>Debut</th>
                                                        <th>Fin</th>
                                                        <th>Status</th>
                                                       <th>ACTION</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($commandes as $commande)
                                                        <tr>
                                                        <td><a href="javascript:;">{{ $commande->number_n}}</a></td>
                                                        <td>
                                                            @if($commande->product_type==1)
                                                            Auto
                                                            @elseif($commande->product_type==2)
                                                            Moto
                                                            @elseif($commande->product_type==3)
                                                            Habitation 
                                                            @endif
                                                        </td>
                                                        {{-- <td>{{ $commande->assuranceAutoInfo->guarante}}</td> --}}
                                                        <td>{{ $commande->guarante}}</td>
                                                        <td>{{ $commande->created_at}}</td>
                                                        <td>{{ $commande->updated_at}}</td>
                                                        <td>{!!get_commande_status($commande->status)!!}</td>
                                                        {{-- <td>
                                                            {{ dd($commande->qid, $commande->aid) }} <!-- Vérifiez les valeurs -->
                                                            <a href="{{route('devis.details',['id'=>$commande->qid,'aid'=>$prospect->assurance_infos_id])}}" class="btn btn-xs btn-default">
                                                                <i class="fa fa-search"></i> voir
                                                            </a>
                                                        </td> --}}
                                                        <td><a href="{{route('devis.details',['id'=>$commande->qid,'aid'=>$commande->aid])}}" class="btn btn-xs btn-default"><i class="fa fa-search"></i> voir</a></td>
                                                        </tr>
                                                    @endforeach  
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                        <!-- /tile body -->

                                    </section>
                                    <!-- /tile -->


                                </div>
                                <!-- /col -->
                            </div>
                            <!-- /row -->
                        </div>
                        <!-- tab in tabs -->                
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach 
@endsection


{{-- @section('custom-script') --}}
<div class="modal fade" id="modal_devis" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Créer un nouveau devis</h3>
            </div>
            <div class="modal-body">
                   <section class="tile">
                        <div class="tile-body">
                            <div class="tab-content">
                                <form method="post" action="{{--route('client.devis.creer')--}}"> 
                                    {{ csrf_field() }}
                                    <div class="tab-pane" id="tab1">
                                        <div id="step1">                               
                                            <div class="row">                                           
                                                <div class="form-group col-md-12">
                                                    <label for="energie">Immatriculation</label>
                                                    <input type="text" name="Immatriculation" id="Immatriculation" class="form-control" required>
                                                    <input type="hidden" name="uid" id="uid" class="form-control" value="{{$client->id}}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="marque">Marque: </label>
                                                    <select id="marque" name="marque" class="form-control" required>
                                                       @foreach($makes as $make)
                                                            <option value="{{$make->id}}">{{$make->code}}</option>
                                                        @endforeach  
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="modele">Modele: </label>
                                                    <select id="modele" name="model" class="form-control" required>
                                                        @foreach($makes as $make)
                                                            <option value="{{$make->id}}">{{$make->code}}</option>
                                                        @endforeach  
                                                    </select>  
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="form-group col-md-6">
                                                    <label for="pf">Puissance Fiscale: </label>
                                                    <input type="text" name="puissance_fiscale" id="pf" class="form-control"
                                                           required>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="energie">Energie </label>
                                                    <select id="energie" class="form-control" name="energie" required>
                                                        <option value="0">ESSENCE</option>
                                                        <option value="1">DIESEL</option>                                           
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="category">Categorie </label>
                                                    <select id="category" name="category" class="form-control" required>
                                                        @foreach($categories as $category)
                                                            <option value="{{$category->id}}">{{$category->categorie}}</option>
                                                        @endforeach  
                                                    </select>
                                                </div>                                                                                        
                                                <div class="form-group col-md-6">
                                                    <label for="place">Nombre de place : </label>
                                                    <input type="text" name="place" id="place" class="form-control"
                                                           required>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                            <div class="row">                                       
                                                <div class="form-group col-md-6">
                                                    <label for="valeur_neuve">Valeur Neuve </label>
                                                    <input type="number" name="valeur_neuve" id="valeur_neuve" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="valeur_venale">Valeur Venale : </label>
                                                    <input type="number" name="valeur_venale" id="valeur_venale" class="form-control"
                                                          required>
                                                </div>
                                            </div>                      
                                            <div class="row">                                        
                                                <div class="form-group col-md-12">
                                                    <label for="zone">Zone de stationnement </label>
                                                     <select id="zone" name="zone" class="form-control" required>
                                                        @foreach($zones as $zone)
                                                            <option value="{{$zone->id}}">{{$zone->city}}</option>
                                                        @endforeach  
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab3">

                                        <div id="step3">                                 
                                            <div class="row">
                                                <div class="form-group col-md-3 mb-0">
                                                   
                                                    <label class="checkbox checkbox-custom checkbox-custom-lg">
                                                        <input name="formule_type" class="formular" id="formule" type="radio" value="1" checked id="formule_div"><i></i> Formule
                                                    </label>
                                                </div>
                                                <div class="form-group col-md-3 mb-0">
                                                      <label class="checkbox checkbox-custom checkbox-custom-lg">
                                                        <input  name="formule_type" class="formular" id="garantie" type="radio" value="2" ><i></i> Garantie
                                                    </label>
                                                </div>
                                               
                                            </div>
                
                                         <div id="formulae_section">
                                            <h4 class="custom-font">Selectionner votre formule</h4>

                                            <div class="row">
                                                <div class="form-group col-md-6 mb-0" id="formule_div">
                                                    <label class="checkbox checkbox-custom">
                                                        <input name="formule" value="tsimple" type="radio"><i></i> Tiers simple
                                                    </label>
                                                    
                                                     <label class="checkbox checkbox-custom">
                                                        <input name="formule" value="tcol" type="radio"><i></i> Tiers collision
                                                    </label>
                                                    
                                                     <label class="checkbox checkbox-custom">
                                                        <input name="formule" value="tcomplet" type="radio"><i></i> Tiers complet
                                                    </label>
                                                    
                                                     <label class="checkbox checkbox-custom">
                                                        <input name="formule" value="toutrisque" type="radio"><i></i> Tout risque
                                                    </label>
                                                      
                                                </div>
                                                 <div class="form-group col-md-6 mb-0" id="garantie_div" style="display:none">
                                                    @foreach($guarantees as $guarantee)
                                                    <label class="checkbox checkbox-custom" >
                                                    <input name="garantie[]" type="checkbox" value="{{$guarantee->codeguar}}"><i></i>{{$guarantee->codeguar}}({{$guarantee->titleguar}})
                                                    </label>  
                                                    @endforeach  
                                                </div>
                                                <div class="form-group col-md-6 mb-0">
                                                    <label for="releasedate">Date de prise d'effet: </label>
                                                    <input type="date" name="releasedate" id="releasedate" class="form-control">
                                                    
                                                    <label for="periode">Périodicité: </label>
                                                    <select id="periode" name="periode" class="form-control" required>
                                                        @foreach($periodes as $periode)
                                                        <option value="{{$periode->id}}">{{$periode->periode}}</option>
                                                        @endforeach  
                                                    </select>
                                                </div>
                                            </div>
                                          </div>                                        
                                        </div>

                                    </div>
                                    <input class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" type='submit' name="go">
                                </form>
                            </div>
                        </div>
                        <!-- /tile body -->
                    </section>
                    <div class="message_div"></div>
            </div>
            <div class="modal-footer">
                <button id="vehicule_btn" class="btn btn-success btn-ef btn-ef-3 btn-ef-3c"><i class="fa fa-arrow-right"></i> Confirmer</button>
                <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Abandonner</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_client" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Modifier infos client</h3>
            </div>
            <div class="modal-body">
                <section class="tile">
                  <div class="tile-body">

                    <form method="post" action="{{route('devis.client.update')}}" role="form" id="form_client">
                      {{ csrf_field() }}


                      <div class="row">
                        <div class="form-group col-md-6 mb-0">
                            <label for="last_name">Nom*: </label>
                            <input type="hidden" value="{{$client->id}}" name="uid" id="uid" class="form-control">
                            <input type="text" value="{{$client->lastname}}" name="last_name" id="last_name" class="form-control" 
                            required>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <label for="first_name">Prénoms*: </label>
                            <input type="text" value="{{$client->firstname}}" name="first_name" id="first_name" class="form-control" 
                            required>
                        </div>
                      </div>
                      <div class="row">
                          <div class="form-group col-md-6 mb-0">
                              <label for="email">E-mail*: </label>
                              <input type="text" value="{{$client->email}}" name="email" id="email" class="form-control" 
                              required>
                          </div>
                          <div class="form-group col-md-6 mb-0">
                              <label for="contact">Contact*: </label>
                              <input type="text" value="{{$client->contact}}" name="contact" id="contact" class="form-control" 
                              required>
                          </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6 mb-0">
                            <label for="gender">Sexe: </label>
                            <select class="form-control" name="gender" id="gender">
                              <option value="H" {{($client->gender=="H")?'selected':''}}>Homme</option>
                              <option value="F" {{($client->gender=="F")?'selected':''}}>Femme</option>
                            </select>
                            
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <label for="first_name">Date de naissance: </label>
                            <div class="input-group datepicker">
                                <input type="text" class="form-control datepicker" value="{{ date('d/m/Y', strtotime($client->dob)) }}" name="dob" id="dob">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </span>
                            </div>
                            
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="form-group col-md-6 mb-0">
                            <label for="job">Profession: </label>
                            <select id="job_id" name="job_id" class="form-control">
                              <option value="{{ $client->job_id }}"></option>
                             @foreach($jobs as $job)
                             <option  value="{{$job->id}}" {{($client->job_id==$job->id)? 'selected':''}}>{{$job->jobtitle}}</option>
                             @endforeach  
                            </select>
                        </div>
                         <div class="form-group col-md-6 mb-0">
                            <label for="delivedate">Date de delivrance du permis: </label>
                            <div class="input-group datepicker">
                                <input type="text" class="form-control datepicker" value="{{ date('d/m/Y', strtotime($client->date_pc)) }}" name="date_pc" id="date_pc">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </span>
                            </div>
                        </div>
                      </div>
                      <button id="customer_btn" class="btn btn-success btn-ef btn-ef-3 btn-ef-3c"><i class="fa fa-arrow-right"></i> Enregistrer</button>
                    </form>

                  </div>
                  <!-- /tile body -->

                  </section>
            </div>
            <div class="modal-footer">
                
                <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Quitter</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(window).load(function(){
        $(".formular").click(function(){
                if($('input[type=radio][id=formule]').is(':checked'))
                {
                        $('#formule_div').css("display","block");
                        $('#garantie_div').css("display","none");
                }
                else
                {
                    $('#formule_div').css("display","none");
                    $('#garantie_div').css("display","block");
                } 
        });

        $("#customer_btn").click(function(){
    
        $.ajax({

        url: $('#form_client').attr('action'),
        type : $('#form_client').attr('method'),
        data : $('#form_client').serialize(),
        dataType:'html',
        success :function(html)
        {
            location.reload();
            },

            error: function(){
                alert("Une erreur s'est produite");
            }
        });
    });

        $("#guarante_btn").click(function(){
        var formule_type = $("#formule_type").val();
        var formule = $("#formule").val();
        var garantie = $("#garantie").val();
        var releasedate = $("#releasedate").val();
        var periode = $("#periode").val();
            $.ajax({
                url: $('#form_guarante').attr('action'),
                type : $('#form_guarante').attr('method'),
                data : $('#form_guarante').serialize(),
                dataType:'html',
                success :function(html)
                    {
                        if(html==1)
                        {
                            location.reload();
                        }
                        else if(html==2)
                        {
                            $('#assurance_message_div').html('<span class="alert alert-success">Une erreur est survenue</span>');                       
                        }
                        else
                        {
                            $('#assurance_message_div').html('<span class="alert alert-success">Une erreur est survenue</span>');
                        }
                    
                    },                        
                error: function(){
                    alert('erreur propore meme');
                }
            });              
        });

        $("#vehicule_btn").click(function(){
        var Immatriculation = $("#Immatriculation").val();
        var marque = $("#marque").val();
        var modele = $("#modele").val();
        var pf = $("#pf").val();
        var energie = $("#energie").val();
        var category = $("#category").val();
        var place = $("#place").val();
        var valeur_neuve = $("#valeur_neuve").val();
        var valeur_venale = $("#valeur_venale").val();
        var zone = $("#zone").val();
            $.ajax({
                    
                url: $('#form_vehicule').attr('action'),
                type : $('#form_vehicule').attr('method'),
                data : $('#form_vehicule').serialize(),
                dataType:'html',
                success :function(html)
                    {
                        
                        /*  if(html==1)
                        {
                            location.replace("partage.php");
                        }
                        else if(html==2)
                        {
                        $('#error1').css('display', 'none');
                            $('#error1').css('color', 'red');
                            $('#error1').html('Adresse e-mail déja utilisée'); 
                            $('#error1').fadeIn(2000);
                        }
                        else
                        {
                        $('#error1').html('Adresse incorrect');
                        }*/
                    
                    },
                    
                    error: function(){
                        alert('erreur propore meme');
                    }
            });
        });

        $("#customer_btn").click(function(){
                var last_name = $("#last_name").val();
                var first_name = $("#first_name").val();
                var email = $("#email").val();
                var contact = $("#contact").val();
                var job = $("#job").val();
                var delivedate = $("#delivedate").val(); 
                $.ajax({
                        url: $('#form_client').attr('action'),
                        type : $('#form_client').attr('method'),
                        data : $('#form_client').serialize(),
                        dataType:'html',
                        success :function(html)
                            {
                                
                                /*  if(html==1)
                                {
                                    location.replace("partage.php");
                                }
                                else if(html==2)
                                {
                                $('#error1').css('display', 'none');
                                    $('#error1').css('color', 'red');
                                    $('#error1').html('Adresse e-mail déja utilisée'); 
                                    $('#error1').fadeIn(2000);
                                }
                                else
                                {
                                $('#error1').html('Adresse incorrect');
                                }*/
                            
                            },
                            
                        error: function(){
                            alert('erreur propore meme');
                            }
                });
        });

        $(".del").click(function(){
            var href = $(this).attr("id");
            $('#id_div').val(href);
        });

        $("#del_btn").click(function(){
            var id = $("#id_div").val();
            var cause = $("#message").val();
            $.get(id, function(data)
                {                         
                $(".message_div").html('<span class="alert alert-success">Prospect supprimer avec succès</span>');                
                }
            ); 
        });
    });
</script>


{{-- @stop --}}

