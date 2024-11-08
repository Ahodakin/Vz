@extends('Backoffice.layouts.app')

@section("content")
  <div class="page page-shop-single-order">
      <div class="pageheader">
          <h2>Détails de la commande #{{$prospect->number_n}}</h2>
          <div class="page-bar">
              <ul class="page-breadcrumb">
                  <li>
                      <a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> MONASSURANCE.CI</a>
                  </li>
                  <li>
                      <a href="#">Commande</a>
                  </li>
                  <li>
                      <a href="">Détails</a>
                  </li>
              </ul>
          </div>
      </div>
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
  
        <div class="pagecontent">             
            <div class="add-nav">
                <div class="nav-heading">
                    <h3>N° COMMANDE : <strong class="text-greensea">{{$prospect->number_n}}</strong></h3><br/>
                    <h6>N° POLICE : <strong class="text-greensea">{{$prospect->policy_number}}</strong></h6>
                    <span class="controls pull-right">
                        {{-- @role("advisor") --}}
                        @if($prospect->status==1)
                        <a class="btn btn-ef btn-ef-1 btn-ef-1-default btn-ef-1a btn-rounded-20 validation_devis_btn" id="{{$prospect->qid}}" data-toggle="tooltip" title="Confirmer ce dévis"><i class="fa fa-check"></i> Confirmer ce dévis</a>
                        @endif
                        {{-- @endrole --}}

                        {{-- @role("operation") --}}
                            @if($prospect->status==2)
                                <a href="#" class="btn btn-ef btn-ef-1 btn-ef-1-default btn-ef-1a btn-rounded-20 finish_trait_btn" id="{{$prospect->qid}}" data-toggle="tooltip" title="Mettre en Livraison!">Mettre en livraison</a>
                            @endif
                        {{-- @endrole --}}

                          @if($prospect->status==3)

                            @if(!isOrderSetToDeliveryTour($prospect->qid))
                              {{-- @role("operation") --}}
                              <a href="{{ route('orders.waitingdelivery.list') }}" class="btn btn-ef btn-ef-1 btn-ef-1-default btn-ef-1a btn-rounded-20" ><i class="fa fa-truck"></i> Tournée de Livraison</a> 

                              <a href="#" class="btn btn-ef btn-ef-1 btn-ef-1-default btn-ef-1a btn-rounded-20 update_info_delivery" id="{{$prospect->qid}}" data-toggle="tooltip" title="Modifier N° Police/Adresse de Livraison">Modifier N° Police/Adresse de Livraison</a>
                              {{-- @endrole --}}
                            @else
                              @if(getDeliveryTourStatus($prospect->qid)->delivery_tour_status==1)
                                {{-- @role("deliveryman") --}}
                                <a href="{{ route('orders.waitingdelivery.list') }}" class="btn btn-ef btn-ef-1 btn-ef-1-default btn-ef-1a btn-rounded-20" ><i class="fa fa-eye"></i> Afficher la tournée</a>
                                {{-- @endrole --}}
                              @else
                                {{-- @role("operation") --}}
                                <a href="{{ route('orders.waitingdelivery.list') }}" class="btn btn-ef btn-ef-1 btn-ef-1-default btn-ef-1a btn-rounded-20"  ><i class="fa fa-play"></i> Lancer la tourner</a> 

                                <a href="#" class="btn btn-ef btn-ef-1 btn-ef-1-default btn-ef-1a btn-rounded-20 update_info_delivery" id="{{$prospect->qid}}" data-toggle="tooltip" title="Modifier N° Police/Adresse de Livraison">Modifier N° Police/Adresse de Livraison</a>
                                {{-- @endrole --}}
                              @endif
                            @endif
                          @endif

                        @if($prospect->status==4)
                        {{-- @role("operation") --}}

                        <a href="#" class="btn btn-ef btn-ef-1 btn-ef-1-default btn-ef-1a btn-rounded-20 update_info_delivery" id="{{$prospect->qid}}" data-toggle="tooltip" title="Modifier N° Police/Adresse de Livraison">Modifier N° Police/Adresse de Livraison</a>
                        {{-- @endrole --}}
                        {{-- @role("financial") --}}
                          <a href="#" class="btn btn-ef btn-ef-1 btn-ef-1-default btn-ef-1a btn-rounded-20 encaisse_and_close_btn" id="{{$prospect->qid}}" data-toggle="tooltip" title="Encaisser et Terminer commande"><i class="fa fa-euro"></i> Encaisser et conclure commande</a>
                        {{-- @endrole --}}
                        @endif

                        @if($prospect->status==5)
                        @role("financial")
                        <a href="" class="btn btn-ef btn-ef-1 btn-ef-1-primary btn-ef-1a btn-rounded-20"  data-toggle="tooltip" title="Afficher la tournée de livraison" ><i class="fa fa-truck"></i> Afficher la tournée de livraison</a>
                        @endrole
                        @role("operation")
                        <a href="javascript:;" data-toggle="modal" data-target="#modal_sinistre" class="btn btn-ef btn-ef-1 btn-ef-1-default btn-ef-1a btn-rounded-20 sinistre_btn" id="{{$prospect->qid}}" data-toggle="tooltip"><i class="fa fa-bolt"></i> Déclarer un sinistre</a>
                        {{-- <a href="javascript:;" data-toggle="modal" data-target="#modal_vehicule" class="btn btn-default btn-rounded-20 btn-xs pull-right"><i class="fa fa-pencil"></i></a> --}}
                        @endrole
                        @endif
                        
                        {{-- @role("advisor") --}}
                        @if($prospect->status<=1)
                          @if($prospect->priority==0)
                            <a class="btn btn-ef btn-ef-1 btn-ef-1-info btn-ef-1a btn-rounded-20 set_as_priority" id="{{$prospect->qid}}" data-toggle="tooltip" title="Mettre comme prioritaire"><i class="fa fa-key"></i> Mettre comme prioritaire</a>
                          @else
                            <a class="btn btn-ef btn-ef-1 btn-ef-1-info btn-ef-1a btn-rounded-20 set_as_not_priority" id="{{$prospect->qid}}" data-toggle="tooltip" title="Retirer la priorité"><i class="fa fa-key"></i> Retirer la priorité</a>
                          @endif
                        @endif
                        {{-- @endrole --}}

                         @if($prospect->status<=4)
                          <a class="btn btn-ef btn-ef-1 btn-ef-1-danger btn-ef-1a btn-rounded-20 cancel_devis_btn" id="{{$prospect->qid}}" data-toggle="tooltip" title="Annuler la commande"><i class="fa fa-trash"></i> Annuler</a>
                          <a class="btn btn-ef btn-ef-1 btn-ef-1-warning btn-ef-1a btn-rounded-20 revive_client_btn"   data-toggle="modal" data-target="#revive" data-options="splash-2 splash-ef-15"><i class="fa fa-calendar"></i> Relancer</a>
                        @endif

                  </span>
                </div>

                <div role="tabpanel">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">Commande</a></li>                                 
                    <li role="presentation" class=""><a href="#timeline" aria-controls="timeline" role="tab" data-toggle="tab">Timeline</a></li>                                 
                </ul>

                <div class="tab-content">
                    <!-- tab in tabs -->
                    <div role="tabpanel" class="tab-pane active" id="details">
                        <!-- row -->
                        <div class="row">
                            <!-- col -->
                            <div class="col-md-12">
                                <!-- tile -->
                              <div class="box">                        
                                
                                <section class="tile time-simple">                                    <!-- tile body -->
                                    <div class="tile-body">
                                        <!-- row -->
                                        <div class="row">
                                            <!-- col -->
                                            <div class="col-md-9">
                                                <p class="text-default lt">Date de la commande: {{date('d/m/Y H:i:s', strtotime($prospect->created_at))}}</p>
                                                <p class="text-uppercase text-strong mt-40 mb-0 custom-font">Status</p>
                                                <a href=""><h3 class="text-uppercase {{($prospect->status==-1)?'text-danger':'text-success'}} mt-0 mb-20">{{ get_commande_status_by_text($prospect->status) }}</h3></a>
                                            </div>
                                            <!-- /col -->

                                            <!-- col -->
                                            <div class="col-md-3" style="z-index:2">

                                                <a href="javascript:;"  data-toggle="modal" data-target="#modal_client" class="btn btn-default btn-rounded-20 btn-xs pull-right"><i class="fa fa-pencil"></i></a>
                                                <p class="text-uppercase text-strong mb-10 custom-font">{{ get_users_status($prospect->usertype) }}</p>
                                                <ul class="list-unstyled text-default lt mb-20">
                                                    @if($prospect->proprio_veh=="E")
                                                      {{$prospect->company_name}} <i>(Entreprise)</i>
                                                    @else
                                                    <li><strong class="inline-block w-xs">Nom:</strong> {{$prospect->user->lastname}}</li>
                                                    <li><strong class="inline-block w-xs">Prenoms:</strong> {{$prospect->user->firstname}}</li>
                                                    <li><strong class="inline-block w-xs">Sexe:</strong> {{$prospect->user->gender}}</li>
                                                    @endif
                                                    <li><strong class="inline-block w-xs">Contact:</strong> {{$prospect->user->contact}}</li>
                                                    @if(!is_numeric(intval(substr($prospect->email, 0,1))))
                                                    <li><strong class="inline-block w-xs"> Email:</strong> <a href="javascript:;">{{$prospect->user->email}}</a></li>
                                                    @endif

                                                    @if($prospect->proprio_veh=="P")
                                                    <li><strong class="inline-block w-xs"> Profession:</strong> <a href="javascript:;">{{$prospect->jobtitle}}</a> ({{$prospect->job_discount*100}}%)</li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <!-- /col -->
                                        </div>
                                        <!-- /row -->
                                        <!-- row -->
                                        <div class="row b-t pt-20">

                                            <!-- col -->
                                            <div class="col-md-3 b-r">
                                            
                                                @if($prospect->status<2)
                                                <a href="javascript:;" data-toggle="modal" data-target="#modal_vehicule" class="btn btn-default btn-rounded-20 btn-xs pull-right"><i class="fa fa-pencil"></i></a>
                                                @else
                                                
                                                  <a href="javascript:;" data-toggle="modal" data-target="#modal_vehicule" class="btn btn-default btn-rounded-20 btn-xs pull-right"><i class="fa fa-pencil"></i></a>
                                                
                                               @endif

                                                <p class="text-uppercase text-strong mb-10 custom-font">VEHICULE</p>
                                                <ul class="list-unstyled text-default lt mb-20">
                                                    <li><strong>Immatriculation:</strong> <a href="javascript:;">{{$prospect->autoInfo->matriculation}}</a></li>
                                                    <li><strong>Nom carte grise:</strong> <a href="javascript:;">{{$prospect->autoInfo->name_cg}}</a></li>
                                                    <li><strong>Marque:</strong> <a href="javascript:;">{{ optional($prospect->autoInfo->make)->title ?? 'Non spécifié' }}</a></li>
                                                    @if($prospect->category==5)
                                                      <li><strong>Cylindrée (Cm3):</strong> <a href="javascript:;">{{getCylindreeValueInRCTable($prospect->cylindree)}} Cm3</a></li>
                                                    @else
                                                    <li><strong>Puissance Fiscale:</strong> <a href="javascript:;">{{$prospect->power}} CV</a></li>
                                                    @endif
                                                    @if($prospect->charge_utile!=null)
                                                    <li><strong>Charge utile:</strong> <a href="javascript:;">{{$prospect->charge_utile}} T</a></li>
                                                    @endif
                                                    <li><strong>Energie:</strong> <a href="javascript:;">
                                                        @if($prospect->energy=='E')
                                                        ESSENCE
                                                        @else
                                                        DIESEL
                                                        @endif
                                                    </a></li>
                                                    <li><strong>Categorie:</strong> <a href="javascript:;">{{$prospect->autoInfo->category}}</a></li>
                                                    <li><strong>Nombre de Place:</strong> <a href="javascript:;">{{$prospect->autoInfo->placesnumber}}</a></li>
                                                    <li><strong>Valeur Neuve:</strong> <a href="javascript:;">{{number_format($prospect->autoInfo->vneuve)}} FCFA</a></li>
                                                    <li><strong>Valeur Venale:</strong> <a href="javascript:;">{{number_format($prospect->autoInfo->vvenale)}} FCFA</a></li>
                                                    <li><strong>Zone de stationnement:</strong> 
                                                        <a href="javascript:;">{{$prospect->autoInfo->city->city}} (Zone {{$prospect->autoInfo->city->zone}})</a>
                                                    </li>
                                                    
                                                    <li><strong>1ère mise en circulation:</strong> <a href="javascript:;">{{date("d/m/Y",strtotime($prospect->autoInfo->firstrelease))}}</a> </li>
                                                    <li><strong>Couleur:</strong> <a href="javascript:;">{{getCarColor($prospect->autoInfo->color)}}</a> </li>

                                                </ul>
                                            </div>
                                            <!-- col -->
                                            <div class="col-md-3 b-r">
                                                <p class="text-uppercase text-strong mb-10 custom-font">
                                                    ASSURANCE
                                                     @if($prospect->status<2) 
                                                    <a href="javascript:;" data-toggle="modal" data-target="#modal_assurance" class="btn btn-default btn-rounded-20 btn-xs pull-right"><i class="fa fa-pencil"></i></a>
                                                    @endif
                                                </p>
                                                <div class="col-md-12">
                                                    <ul class="list-unstyled text-default lt mb-20">

                                                      <li><strong>Type:</strong> <a href="javascript:;">
                                                         @if($prospect->subscription_type=='G')
                                                         Garantie
                                                         @else
                                                         Formule
                                                         @endif
                                                        </a>
                                                      </li>
                                                      <li><strong>Valeur:</strong> <a href="javascript:;">
                                                           {{$prospect->assuranceAutoInfo->guarante}}</a>
                                                      </li>
                                                      <li><strong>Prise d'effet:</strong> <a href="javascript:;">{{date('d/m/Y', strtotime($prospect->assurance_release_date))}}</a>
                                                      </li>
                                                      <li><strong>Périodicité:</strong> <a href="javascript:;">  {{ $prospect->assuranceAutoInfo->periode }} <a>
                                                      </li>
                                                      <li><strong>Echéance:</strong> <a href="javascript:;">
                                                        {{
                                                          date('d/m/Y', strtotime($prospect->assurance_release_date . "+$prospect->nbmois months -1 days")). " 23:59:59"
                                                          }}</a>
                                                      </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- col -->
                                            <div class="col-md-3 b-r">
                                            
                                               @if($prospect->status<2)
                                                <a href="javascript:;" data-toggle="modal" data-target="#modal_service" class="btn btn-default btn-rounded-20 btn-xs pull-right"><i class="fa fa-pencil"></i></a>
                                               @endif

                                                <p class="text-uppercase text-strong mb-10 custom-font">Services optionnels</p>
                                                <ul class="list-unstyled text-default lt mb-20">
                                                  <?php $t=0; ?>
                                                  @foreach($selected_serv as $s)
                                                    <?php $t+=$s->amount; ?>
                                                    <li><strong>{{$s->service}}:</strong> <a href="javascript:;">{{number_format($s->amount)}}FCFA x {{$prospect->nbmois}}Mois </a></li>
                                                  @endforeach
                                                  <hr>
                                                  <li><strong>Total:</strong> <a href="javascript:;" id="total_servfloor"><?=number_format($t*$prospect->nbmois)?> FCFA</a></li>
                                                    

                                                </ul>
                                            </div>
                                            <!-- /col -->
                                            <div class="col-md-3">
                                                <p class="text-uppercase text-strong mb-10 custom-font">REDUCTION EXCEPTIONNELLE (FCFA)</p>
                                                <!-- tile -->
                                                <section class="tile">
                                                    <div class="tile-body">

                                                        <form method="post" action="{{route('devis.reduction.update')}}" role="form">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" value="{{$prospect->qid}}" name="qid" id="qid" class="">
                                                            <div class="form-group">
                                                                <input type="number"  value="{{$prospect->reduction_commerciale}}" required  class="form-control" name="reduction" id="reduction" placeholder="Valeur de la reduction" {{($prospect->status<=1) ? '':'readonly' }} >
                                                                <input type="hidden" value="{{$prospect->assurance_auto_info_id}}" name="assur_auto_info_id" id="assur_auto_info_id" class="">
                                                            </div>
                                                             @if($prospect->status<=1)
                                                            <button type="submit" class="btn btn-rounded btn-success btn-sm">Appliquer la remise</button>
                                                            @endif
                                                        </form>
                                                        @if(session('message'))
                                                          <div class="alert alert-success">
                                                           Reduction modifié avec succes                    
                                                          </div>
                                                        @endif
                                                       @if(session('error'))
                                                       <div class="alert alert-success">
                                                           Mise à jour echoué                   
                                                       </div>
                                                       @endif
                                                    </div>
                                            </div>
                                        </div>
                                        <!-- /row -->
                                    </div>
                                    <!-- /tile body -->
                                    @if($prospect->priority==1)
                                    <div class="ribbon ribbon-top-left"><span>urgent</span></div>
                                    @endif
                                    @if($prospect->renew_order==1)
                                    <div class="ribbon ribbon-top-right"><span>Renouvelement</span></div>
                                    @endif
                                    @if(sizeof($revives)>0)
                                    <div class="ribbon ribbon-top-right"><span>relance</span></div>
                                    @if($prospect->renew_order==1)
                                    <div class="ribbon ribbon-bottom-right"><span>Renouvelement</span></div>
                                    @endif
                                    @endif

                                    
                                </section>
                                <!-- /tile -->
                              </div>

                                 <!-- tile -->
                                 <section class="tile tile-simple">

                                    <!-- tile body -->
                                    <div class="tile-body p-0">

                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Compagnie</th>
                                                        <th>Description</th>
                                                        <th>Prime</th>
                                                        <th>Livraison</th>
                                                        <th>Services</th>
                                                        <th>Total</th>
                                                        <th>Commander</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($quotations as $q)
                                                <tr class="{{ $prospect->id_comp == $q->idcomp ? 'active-row' : '' }}">
                                                    <style>
                                                        .active-row {
                                                        background-color: #5cb85c !important;
                                                        color: #fff !important;
                                                    }
                                                    </style>
                                                        <td><img width="20%" src="{{asset('images/assureurs/').'/'.$q->logo}}"></td>
                                                        <td>Garanties : {{ $q->formule_selected}}</td>
                                                        <td>{{number_format($q->TTC - $prospect->reduction_commerciale-$q->FG)}} FCFA</td>
                                                       
                                                        <td>
                                                          {{$q->FG}} FCFA
                                                        </td>
                                                        <td>
                                                          {{$t*$prospect->nbmois}} FCFA
                                                        </td>
                                                        <td style="font-size:16px; font-weight:bold">{{number_format($q->TTC - $prospect->reduction_commerciale + $t*$prospect->nbmois )}} FCFA</td>
                                                       
                                

                                                         <td>
                                                            @if($prospect->status<=2)
                                                                {{-- <button class="btn btn-default confirm_btn" id="{{$q->idcomp}}&{{$prospect->qid}}"> <i class="fa fa-shopping-cart"></i></button> --}}
                                                                {{-- <button class="btn btn-default confirm_btn" id="{{$q->idcomp}}&{{$prospect->qid}}" data-toggle="modal" data-target="#confirm_modal"><i class="fa fa-shopping-cart"></i></button> --}}
                                                                <button class="btn btn-default confirm_btn" 
                                                                        data-toggle="modal" 
                                                                        data-target="#confirm_modal" 
                                                                        id="{{$q->idcomp}}&{{$prospect->qid}}">
                                                                            <i class="fa fa-shopping-cart"></i>
                                                                    </button>
                                                   
                                                            @endif
                                                            {{-- @dd($q->idcomp, $prospect->id); --}}

                                                            <a target="_blank" href="{{ route('showDevisPDF', [$q->idcomp, $prospect->id]) }}" class="btn btn-primary">
                                                                <i class="fa fa-print"></i>
                                                            </a>
                                                            
                                                        </td>
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
            <div role="tabpanel" class="tab-pane" id="timeline">
              <!-- row -->
              <div class="row">
                  <!-- col -->
                  <div class="col-md-12">

                      <!-- tile -->
                      <section class="tile tile-simple no-bg">

                          <!-- tile body -->
                          <div class="tile-body streamline timeline p-0">

                              <ul>
                                  <li class="heading"><a href="javascript:;" class="btn btn-greensea b-0">Timeline</a></li>
                                  @foreach($order_status as $key => $status)
                                  @if(++$key%2==0)
                                  <li></li>
                                  <li class="timeline-post">
                                      <aside>
                                          <div class="thumb wh30 bg-lightred">
                                              <i class="fa fa-map-marker"></i>
                                          </div>
                                      </aside>
                                      <div class="post-container">
                                          <div class="panel panel-default b-0">
                                              <h3 class="custom-font text-danger">{{ get_commande_status_by_text($status->order_status) }}</h3>
                                              <span class="text-muted time"><i class="fa fa-clock-o"></i> {{dateAgo($status->created_at)}}</span>
                                              <p>Action effectuée par <b>{{$status->firstname.' '.$status->lastname}}</b> le <b>{{ date('d/m/Y', strtotime($status->created_at))}}</b> à <b>{{ date('H:i:s', strtotime($status->created_at))}}</b></p>
                                          </div>
                                      </div>
                                  </li>
                                  @else

                                    <li class="timeline-post">
                                        <aside>
                                            <div class="thumb wh30 bg-lightred">
                                                <i class="fa fa-map-marker"></i>
                                            </div>
                                        </aside>
                                        <div class="post-container">
                                            <div class="panel panel-default b-0">
                                                <h3 class="custom-font text-danger">{{ get_commande_status_by_text($status->order_status) }}</h3>
                                                <span class="text-muted time">
                                                    <i class="fa fa-clock-o"></i> 
                                                    {{ \Carbon\Carbon::parse($status->created_at)->diffForHumans() }}
                                                </span>
                                                
                                                <p>Action effectuée par <b>{{$status->firstname.' '.$status->lastname}}</b> le <b>{{ date('d/m/Y', strtotime($status->created_at))}}</b> à <b>{{ date('H:i:s', strtotime($status->created_at))}}</b></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li></li>
                                  @endif
                                  @endforeach

                              </ul>

                          </div>
                          <!-- /tile body -->

                      </section>
                      <!-- /tile -->

                  </div>
                  <!-- /col -->
              </div>
              <!-- /row -->
            </div>                   

        </div>
                </div>
            </div>
        </div>                   
  </div>

@endsection


<!-- Modal -->
<div class="modal fade" id="confirm_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Confirmation choix du dévis</h3>
            </div>
            <div class="modal-body">
               <form method="post" action="{{route('devis.vehicule.confirm')}}" id="form_confirm">
               {{ csrf_field() }}
                <input type="hidden" name="idcomp" id="idcomp_input" value="">
                <input type="hidden" name="qid" id="qid_input" value=""> 
              
                <div id="box_div"></div>
                <div class="confirmation_message_div"></div>
              </form>
            </div>
            <div class="modal-footer">
                <button id="confirm_save_btn" class="btn btn-success btn-ef btn-ef-3 btn-ef-3c"><i class="fa fa-arrow-right"></i> Oui je confirme</button>
                <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i>Non j'abandonne</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal_client" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Modifier infos client</h3>
            </div>
            <div class="modal-body">
                <section class="tile">
                    <div class="tile-body">
                        <form method="post" action="{{ route('devis.client.update') }}" role="form" id="form_client">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $prospect->qid ?? 'no-qid' }}" name="qid" id="qid" class="form-control">
                            <input type="hidden" value="{{ $prospect->uid ?? 'no-uid' }}" name="uid" id="uid" class="form-control">                            

                    <form method="post" action="{{route('devis.client.update')}}" role="form" id="form_client">
                      {{ csrf_field() }}

                      <div class="row">
                        <div class="form-group col-md-6 mb-0">
                            <label for="last_name">Nom*: </label>
                            <input type="hidden" value="{{$client->id}}" name="uid" id="uid" class="form-control">
                            <input type="text" value="{{$client->usulastname}}" name="last_name" id="last_name" class="form-control" 
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
<!-- Modal -->
<div class="modal fade" id="modal_assurance" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Modifier infos Assurance</h3>
            </div>
            <div class="modal-body">
                <section class="tile">

                    <!-- tile body -->
                    <div class="tile-body">


                        <form method="post" action="{{route('devis.garantie.update')}}" role="form" id="form_guarante">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{$prospect->qid}}" name="qid" id="qid" class="form-control">
                            <div class="row">
                            <div class="form-group col-md-3 mb-0">
                                    <label class="checkbox checkbox-custom checkbox-custom-lg">
                                    <input  name="formule_type" class="formular" id="garantie" type="radio" value="G" @if($prospect->subscription_type =='G') checked @endif><i></i> Garantie
                                    </label>
                                </div>
                                <div class="form-group col-md-3 mb-0">
                                    <input type="hidden" value="{{$prospect->assurance_auto_info_id}}" name="assurance_auto_info_id" id="assurance_auto_info_id" class="">
                                    <label class="checkbox checkbox-custom checkbox-custom-lg">
                                       <input name="formule_type" class="formular" id="formule" type="radio" value="F"  id="formule_div"  @if($prospect->subscription_type =='F') checked @endif ><i></i> Formule
                                   </label>
                               </div>
                               

                            </div>


                            <div id="formulae_section">
                                <h4 class="custom-font">Selectionner votre formule</h4>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-0" id="formule_div">
                                        <label class="checkbox checkbox-custom">
                                         <input name="formule" value="tsimple"  @if($prospect->subscription_type =='F' and $prospect->guarante=='tsimple') 
                                         checked
                                         @endif type="radio"><i></i> Tiers simple
                                        </label>
                                        <label class="checkbox checkbox-custom">
                                            <input name="formule" value="tcomplet" type="radio"  @if($prospect->subscription_type =='F' and $prospect->guarante=='tcomplet') 
                                            checked
                                            @endif {{($prospect->category==5) ? "disabled":"" }}><i></i> Tiers complet
                                        </label>
                                        <label class="checkbox checkbox-custom">
                                            <input name="formule" value="toutrisque" type="radio"  @if($prospect->subscription_type =='F' and $prospect->guarante=='toutrisque') 
                                            checked
                                            @endif {{($prospect->category==5) ? "disabled":"" }}><i></i> Tout risque
                                        </label>
                                    </div>

                                    <div class="form-group col-md-6 mb-0" id="garantie_div" style="display:none">
                                        @foreach($guarantees as $guarantee)
                                        <label class="checkbox checkbox-custom" >
                                          <input name="garantie[]" type="checkbox" value="{{$guarantee->codeguar}}"

                                          @if(is_array($guarantees_array) && in_array($guarantee->codeguar, $guarantees_array))
                                          checked
                                      @endif
                                      

                                          @if($guarantee->id==1)
                                            {{'checked onclick=return&nbsp;false'}}
                                          @endif

                                          ><i></i>{{$guarantee->codeguar}}({{$guarantee->titleguar}})
                                        </label>  
                                        @endforeach  
                                    </div>
                                    <div class="form-group col-md-6 mb-0">
                                        <label for="releasedate">Date de prise d'effet: </label>
                                          <div class="input-group dp_releasedate w-330 mt-8" >
                                            <input type="text" value="{{ date('d/m/Y', strtotime($prospect->assurance_release_date)) }}"  name="releasedate" id="releasedate" class="form-control dp_releasedate">
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar"></span>
                                            </span>
                                        </div>

                                        <label for="periode">Périodicité: </label>
                                        <select id="periode" name="periode" class="form-control" required>
                                         @foreach($periodes as $periode)
                                         <option value="{{$periode->id}}"  @if($prospect->pid ==$periode->id) selected @endif  >{{$periode->periode}}</option>
                                         @endforeach  
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <div class="modal-footer">
                          <button id="guarante_btn" class="btn btn-success btn-ef btn-ef-3 btn-ef-3c"><i class="fa fa-arrow-right"></i> Confirmer</button>
                          <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Abandonner</button>
                      </div>
                    </div>
                    <!-- /tile body -->

                </section>

                <div id="assurance_message_div"></div>
            </div>
     
         
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_vehicule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Modifier infos vehicule</h3>
            </div>
            <div class="modal-body">
                <section class="tile">
                    <!-- tile body -->
                    <div class="tile-body">
                        <form method="post" action="{{route('devis.vehicule.update')}}" role="form" id="form_vehicule">

                           {{ csrf_field() }}
                            {{-- <input type="hidden" value="{{$prospect->qid}}" name="qid" id="qid" class="form-control"> --}}
                            {{-- Ajoutez un dd juste avant la ligne du champ caché --}}
                            {{-- @php
                                dd($prospect->auto_info_id);
                            @endphp --}}

                            <input type="hidden" value="{{ $prospect->auto_info_id }}" name="aid" id="aid" class="form-control">
                            {{-- <input type="hidden" value="{{$client->id}}" name="uid" id="uid" class="form-control"> --}}

                           <div class="form-group">
                                <label for="energie">Immatriculation</label>
                                <input type="hidden" value="{{$prospect->auto_info_id}}" name="aid" id="aid" class="form-control">
                                <input type="text" value="{{$prospect->autoInfo->matriculation}}" name="Immatriculation" id="Immatriculation" class="form-control" required>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                <label for="marque">Marque: </label>
                                <select id="marque" name="marque" class="form-control" required>
                                     @foreach($makes as $make)

                                     <option value="{{$make->id}}" @if($prospect->makid ==$make->id) selected @endif >{{$make->title}} </option>  
                                     @endforeach  
                                 </select>
                                </div>

                                <div class="form-group col-md-6">
                                        <label for="firstrelease">Date de première circulation: </label>
                                        
                                          <div class="input-group dp_firstreleasedate w-330 mt-8" >
                                            <input type="text" value="{{ date('d/m/Y', strtotime($prospect->autoInfo->firstrelease)) }}"  name="firstrelease" id="firstrelease" class="form-control dp_firstreleasedate">
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar"></span>
                                            </span>
                                        </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="pf">Puissance Fiscale: </label>
                                    
                                    <select class="form-control" name="puissance_fiscale" id="pf">
                                      <option value="{{$prospect->power}}">{{$prospect->autoInfo->power}}</option>
                                      @for($i=1;$i<=12;$i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                      @endfor
                                        <option value="13">Plus de 12</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="energie">Energie </label>
                                    <select id="energie" class="form-control" name="energie" required>
                                        <option value="E"  @if($prospect->energy =='E') selected @endif>ESSENCE</option>
                                        <option value="D"  @if($prospect->energy =='D') selected @endif>DIESEL</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                  <div class="col-md-6">
                                    <label class="control-label input-label" for="genre">Genre du véhicule*</label>
                                    
                                    <select class="form-control" required data-parsley-group="block2" name="genre" id="genre">
                                        @if($prospect->category==5)
                                          <option value="7" selected>MOTO</option>
                                        @else
                                        @foreach($car_types as $type)
                                         <option value="{{ $type->id_type }}" {{($prospect->type_id==$type->id_type)?"selected":""}}>{{ $type->car_type_desc }}</option>
                                         @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="category">Categorie </label>
                                    <select id="category" name="category" class="form-control" required>
                                      @if($prospect->category==5)
                                        <option value="5">Categorie 5</option>
                                      @else
                                     @foreach($categories as $category)
                                     <option value="{{$category->id}}"  @if($prospect->autid ==$category->id) selected @endif>{{$category->categorie}}</option>
                                     @endforeach  
                                    @endif
                                    </select>
                                </div>
                                
                                
                            </div>

                            <div class="row">
                              <div class="col-md-6" id="div_cu" @if($prospect->charge_utile==null) style="display:none" @endif>
                                <label class="control-label input-label" for="cu">Charge Utile* (Tonne)</label>
                                <select class="form-control" name="cu" id="cu">
                                  <option></option>
                                  <?php for ($i=1; $i <=15 ; $i++) { ?>
                                  <option value="<?= $i ?>" {{($prospect->charge_utile==$i)?"selected":""}}><?= $i ?> T</option>  
                                  <?php } ?>
                                  <option value="16">Plus de 15</option>

                                </select>
                              </div>
                              <div class="form-group col-md-6" @if($prospect->category!=5) style="display:none" @endif>
                                  <label for="place">Cylindrée (Cm3) : </label>
                                  <select class="form-control" name="cylindree" id="cylindree">
                                  <option value="1" {{ ($prospect->cylindree==1)?'selected':'' }}>0-50</option>
                                  <option value="2" {{ ($prospect->cylindree==2)?'selected':'' }}>51-99</option>
                                  <option value="3" {{ ($prospect->cylindree==3)?'selected':'' }}>100-175</option>
                                  <option value="4" {{ ($prospect->cylindree==4)?'selected':'' }}>176-350</option>
                                  <option value="5" {{ ($prospect->cylindree==5)?'selected':'' }}>Plus de 350</option>
                                </select>
                              </div>
                              <div class="form-group col-md-6">
                                  <label for="place">Nombre de place : </label>
                                  <input type="number" min="1" name="place" id="place" class="form-control"
                                  required value="{{$prospect->autoInfo->placesnumber}}">
                              </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="valeur_neuve">Valeur Neuve </label>
                                    <input type="number" name="valeur_neuve" value="{{$prospect->autoInfo->vneuve}}" id="valeur_neuve" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="valeur_venale">Valeur Venale : </label>
                                    <input type="number" name="valeur_venale" value="{{$prospect->autoInfo->vvenale}}" id="valeur_venale" class="form-control"
                                    required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="zone">Zone de stationnement </label>
                                    <select id="zone" name="zone" class="form-control" required>
                                     @foreach($zones as $zone)
                                     <option value="{{$zone->id}}"  @if($prospect->cid ==$zone->id) selected @endif  >{{$zone->city}}</option>
                                     @endforeach  
                                    </select>
                                </div>
                                <div class="col-md-6">
                                  <label class="control-label input-label" for="color">Couleur du véhicule*</label> 
                                  <select class="form-control"  name="color" data-parsley-group="block2" id="color" data-placeholder="Couleur du véhicule">
                                    <option value="{{ $prospect->color }}">{{ getCarColor($prospect->autoInfo->color) }}</option>
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
                            </div><br>
                            <div class="modal-footer">
                                <button type="submit" id="vehicule_btn" class="btn btn-success btn-ef btn-ef-3 btn-ef-3c"><i class="fa fa-arrow-right"></i> Confirmer</button>
                                <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Abandonner</button>
                            </div>
                        </form>
                    </div>
                    <!-- /tile body -->
                </section>
                <div class="auto_message_div"></div>
            </div>
            
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal_service" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Modifier Services optionnels</h3>
            </div>
            <form method="post" action="{{route('devis.service.update')}}" id="form_service">
              <input type="hidden" value="{{$prospect->qid}}" name="qid" class="form-control">

              <div class="modal-body">
                  <section class="tile">
                      <!-- tile body -->
                      <div class="tile-body">
                         {{ csrf_field() }}
                          <fieldset>Service optionnel</fieldset>
                          <hr>

                              @foreach($optional_service as $s)
                                @foreach($selected_serv as $ss)
                                  @if($s->id==$ss->id)
                                  <label class="checkbox checkbox-custom" >
                                    <input name="service[]" {{ ($s->id==$ss->id) ? 'checked':''}}  type="checkbox" value="{{$s->id}}"
                                    ><i></i>{{$s->service}}
                                  </label>
                                  @elseif(sizeof($selected_serv)!=2)
                                  <label class="checkbox checkbox-custom" >
                                    <input name="service[]"  type="checkbox" value="{{$s->id}}"
                                    ><i></i>{{$s->service}}
                                  </label>
                                  @endif
                              @endforeach  
                              @if(sizeof($selected_serv)==0)
                                <label class="checkbox checkbox-custom" >
                                    <input name="service[]"  type="checkbox" value="{{$s->id}}"
                                    ><i></i>{{$s->service}}
                                  </label>
                              @endif
                           @endforeach  


                        
                      </div>
                      <!-- /tile body -->
                  </section>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-success btn-ef btn-ef-3 btn-ef-3c"><i class="fa fa-arrow-right"></i> Confirmer</button>
                  <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Abandonner</button>
              </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modal_sinistre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Déclaration de sinistre</h3>
            </div>
            <div class="modal-body">
                <section class="tile">
                    <div class="tile-body">
                        <form method="post" action="{{ route('commande.sinistre') }}" role="form" id="form_sinistre">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="date_sinistre">Date: </label>
                                    <input type="date" name="date_sinistre" id="date_sinistre" class="form-control">
                                    <input type="hidden" value="{{ $prospect->qid }}" name="quotation_id" id="quotation_id" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lieu_accident">Lieu exact: </label>
                                    <input type="text" name="lieu_accident" id="lieu_accident" class="form-control"> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="temoin_nom">Nom du témoin </label>
                                    <input type="text" name="temoin_nom" id="temoin_nom" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="temoin_adresse">Adresse du témoin </label>
                                    <input type="text" name="temoin_adresse" id="temoin_adresse" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="constat">Un constat a-t-il été établi? </label>
                                    <select class="form-control" name="constat" id="constat">
                                        <option value="1">Oui</option>
                                        <option value="0">Non</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="constat_maker">Par qui? </label>
                                    <input type="text" name="constat_maker" id="constat_maker" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="client_declaration">Circonstance de l'accident: </label>
                                    <textarea class="form-control" rows="6" name="client_declaration" id="client_declaration" placeholder="Décrivez les conditions du sinistre" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="sinistre_save_btn" class="btn btn-success"><i class="fa fa-arrow-right"></i> Confirmer</button>
                                <button class="btn btn-lightred" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Abandonner</button>
                            </div>
                        </form>
                    </div>
                </section>
                <div class="sinistre_message_div"></div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="confirm_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Confirmation choix du dévis</h3>
            </div>
            <div class="modal-body">
               <form method="post" action="{{route('devis.vehicule.confirm')}}" id="form_confirm">
               {{ csrf_field() }}
                <input type="hidden" name="idcomp" id="idcomp_input" value="">
                <input type="hidden" name="qid" id="qid_input" value=""> 
              
                <div id="box_div"></div>
                <div class="confirmation_message_div"></div>
              </form>
            </div>
            <div class="modal-footer">
                <button id="confirm_save_btn" class="btn btn-success btn-ef btn-ef-3 btn-ef-3c"><i class="fa fa-arrow-right"></i> Oui je confirme</button>
                <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i>Non j'abandonne</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="revive" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Relance client sur commande</h3>
            </div>
            <div class="modal-body">
              <div role="tabpannel">               
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#list-revives" aria-controls="list-revives" role="tab" data-toggle="tab">Liste</a></li>                                 
                    <li role="presentation" class=""><a href="#new-revive" aria-controls="new-revive" role="tab" data-toggle="tab">Nouveau</a></li>                                 
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="list-revives">
                      <table class="table table-hover table-striped">
                        <thead>
                          <th>#</th>
                          <th>Mail</th>
                          <th>Sms</th>
                          <th>Observation</th>
                          <th>Date de relance</th>
                          <th>Action</th>
                        </thead>
                        <tbody>
                          @foreach($revives as $k => $r)
                          <tr>
                            <td>{{++$k}}</td>
                            <td>{{($r->revive_by_mail==1)? "Oui":"Non"}}</td>
                            <td>{{($r->revive_by_sms==1)? "Oui":"Non"}}</td>
                            <td><i>{!! $r->advisor_note !!}</i></td>
                            <td>{{date('d/m/Y', strtotime($r->revive_date))}}</td>
                            <td>
                                <a href="" class="btn btn-info"><i class="fa fa-edit"></i></a>&nbsp;<a href="" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="new-revive">
                      <form class="form-horizontal" method="post" action="{{ route('createRevive') }}">
                        {{csrf_field()}}
                        <input type="hidden" value="{{ $prospect->qid }}" name="qid">
                        <div class="form-group">
                          <h4></h4>
                          <label class="checkbox checkbox-custom">
                              <input type="checkbox" checked disabled name="dash_notice" id="dash_notice"><i></i>
                              Alert sur dashboard
                          </label>
                          <label class="checkbox checkbox-custom">
                              <input type="checkbox" name="sms_notice" id="sms_notice"><i></i>
                              Notififier le client par SMS
                          </label>
                          <label class="checkbox checkbox-custom">
                              <input type="checkbox" name="email_notice" id="email_notice"><i></i>
                              Notififier le client par Email
                          </label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Date de relance*</label>
                            <div class="input-group datepicker w-360 mt-10">
                                <input type="text" class="form-control datepicker" required name="revivedate" id="revivedate">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Note/Observation</label>
                            <textarea class="form-control" placeholder="Ecrivez une note pour vous aidez à vous souvenir de la relance" required rows="3" name="obs_revive" id="obs_revive"></textarea>
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-success">Enregistrer</button>
                          <button type="reset" data-dismiss="modal" class="btn btn-danger">Annuler</button>
                        </div>
                      </form>
                    </div>
                </div>        
              </div>
               
            </div>
            <div class="modal-footer">
                <button class="btn btn-default btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i>Quitter</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="validation_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Confirmation</h3>
            </div>
            <div class="modal-body">
               <form method="post" action="{{route('devis.vehicule.validate')}}" id="form_validation">
               {{ csrf_field() }}
                <input type="hidden" name="status" id="status_input" value="">
                <input type="hidden" name="qid" id="qid_input_2" value="">
                <div id="box_div_2"></div>
                <div class="validation_message_div"></div>
              </form>
            </div>
            <div class="modal-footer">
                <button id="validation_save_btn" disabled class="btn btn-success btn-ef btn-ef-3 btn-ef-3c"><i class="fa fa-arrow-right"></i> Oui je confirme</button>
                <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i>Non j'abandonne</button>
            </div>
        </div>
    </div>
</div>


    <script>

      function formatMoney(num , localize,fixedDecimalLength){
        num=num+"";
        var str=num;
        var reg=new RegExp(/(\D*)(\d*(?:[\.|,]\d*)*)(\D*)/g)
        if(reg.test(num)){ 
          var pref=RegExp.$1;
          var suf=RegExp.$3;
          var part=RegExp.$2;
            if(fixedDecimalLength/1)part=(part/1).toFixed(fixedDecimalLength/1);
            if(localize)part=(part/1).toLocaleString();
          str= pref +part.match(/(\d{1,3}(?:[\.|,]\d*)?)(?=(\d{3}(?:[\.|,]\d*)?)*$)/g )+suf ;
        };
        return str;
      }

      $(".set_as_priority").click(function(e){
        e.preventDefault();
        var qid = $(this).attr("id");
        var url = "/admin/priority-order/"+qid
        swal({
              title:"Prioriser!",
              text: "Voulez vous vraiment Prioriser cette commande?",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#e05d6f",
              confirmButtonText: "Oui",
              cancelButtonText: "Non",
              closeOnConfirm: false
          }, function () {
              swal("Annulé!", "", "success");
              $.ajax(
              {
                  type: "get",
                  url: url,
                  success: function(data){
                  }
              }
              )
              .done(function(data) {
                  swal("Succes!", "La commande à bien été priorisée!", "success");
                  setTimeout(function(){
                      window.location.reload()
                  }, 1000);
              })
              .error(function(data) {
                  swal("Oops", "Erreur interne!", "error");
              })
          });
      });
    
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
                location.reload();
              else if(html==2)
                $('#assurance_message_div').html('<span class="alert alert-warning">Aucune modification</span>');
            },
    
            error: function(e){
                $('#assurance_message_div').html('<span class="alert alert-danger">Une erreur est survenue</span>');
                 console.log(e)
             }
        });
      });
    
      $("#vehicule_btn").click(function(){
        var Immatriculation = $("#Immatriculation").val();
        var marque = $("#marque").val();
        var firstrelease = $("#firstrelease").val();
        var pf = $("#pf").val();
        var energie = $("#energie").val();
        var genre = $("#genre").val();
        var category = $("#category").val();
        var cu = $("#cu").val();
        var place = $("#place").val();
        var valeur_neuve = $("#valeur_neuve").val();
        var valeur_venale = $("#valeur_venale").val();
        var zone = $("#zone").val();
        var color = $("#color").val();
        $.ajax({
    
           url: $('#form_vehicule').attr('action'),
           type : $('#form_vehicule').attr('method'),
           data : $('#form_vehicule').serialize(),
           dataType:'html',
           success :function(html)
           {
            if(html==1)
                location.reload();
            else
                $('.auto_message_div').html('<span class="alert alert-warning">Aucune modification</span>');
            },
    
              error: function(e){
                 $('.auto_message_div').html('<span class="alert alert-danger">Une erreur s est produite</span>');
             }
        });
      });
    
      $("#customer_btn").click(function(){
        var last_name = $("#last_name").val();
        var first_name = $("#first_name").val();
        var email = $("#email").val();
        var contact = $("#contact").val();
    
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

 
          $(".cancel_devis_btn").click(function(e) {
          e.preventDefault();
          var qid = $(this).attr("id");
          var url = "/admin/cancel-commande/" + qid;

          swal({
              title: "Annulation de la commande!",
              text: "Voulez-vous vraiment annuler cette commande?",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "POST", // Utilisez POST si cela correspond à votre route
                        url: url,
                        data: { _method: 'DELETE' }, // Ajoutez cette ligne si votre route attend une méthode DELETE
                        success: function(data) {
                            swal("Succès!", "La commande a bien été annulée!", "success");
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        },
                        error: function(data) {
                            swal("Oops", "Erreur interne!", "error");
                        }
                    });
                } else {
                    swal("Annulation!", "La commande n'a pas été annulée.", "info");
                }
            });
         });

    
    //   $(".set_as_priority").click(function(e){
    //     e.preventDefault();
    //     var qid = $(this).attr("id");
    //     var url = "/admin/priority-order/"+qid
    //     swal({
    //           title:"Prioriser!",
    //           text: "Voulez vous vraiment Prioriser cette commande?",
    //           type: "warning",
    //           showCancelButton: true,
    //           confirmButtonColor: "#e05d6f",
    //           confirmButtonText: "Oui",
    //           cancelButtonText: "Non",
    //           closeOnConfirm: false
    //       }, function () {
    //           swal("Annulé!", "", "success");
    //           $.ajax(
    //           {
    //               type: "get",
    //               url: url,
    //               success: function(data){
    //               }
    //           }
    //           )
    //           .done(function(data) {
    //               swal("Succes!", "La commande à bien été priorisée!", "success");
    //               setTimeout(function(){
    //                   window.location.reload()
    //               }, 1000);
    //           })
    //           .error(function(data) {
    //               swal("Oops", "Erreur interne!", "error");
    //           })
    //       });
    //   });
    
      $(".set_as_not_priority").click(function(e){
        e.preventDefault();
        var qid = $(this).attr("id");
        var url = "/admin/unpriority-order/"+qid
        swal({
              title:"Priorité!",
              text: "Voulez vous vraiment Retirer la priorité à cette commande?",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#e05d6f",
              confirmButtonText: "Oui",
              cancelButtonText: "Non",
              closeOnConfirm: false
          }, function () {
              swal("Annulé!", "", "success");
              $.ajax(
              {
                  type: "get",
                  url: url,
                  success: function(data){
                  }
              }
              )
              .done(function(data) {
                  swal("Succes!", "La commande n'est plus prioritaire!", "success");
                  setTimeout(function(){
                      window.location.reload()
                  }, 1000);
              })
              .error(function(data) {
                  swal("Oops", "Erreur interne!", "error");
              })
          });
      });
      $(".confirm_btn").click(function(){
          var id = $(this).attr("id");
          var res = id.split("&");
          
           $("#idcomp_input").val(res[0]);
           $("#qid_input").val(res[1]);
           $("#confirm_modal").modal({backdrop: 'static'});
    
           auto_id = $("#aid").val();
           user_id = $("#uid").val();
           assur_id = $("#assurance_auto_info_id").val();
           $.ajax({
            url: "/rest-api/v1/autoQuote/"+auto_id+"/"+user_id+"/"+assur_id,
            type: "get",
            data: $("#form_confirm").serialize(),
            success: function(data){
              var obj =JSON.parse(data)
              var c = obj[0];
              $('#box_div').html('')
              html = '<div class="row">';
              html +=     '<div class="col-md-12">';
              html +=         '<p style="color:#000">Le montant de votre assurance est de <b>'+formatMoney(Math.floor(c.TTC) - <?=$prospect->reduction_commerciale ?>)+' FCFA</b> avec la compagnie <img width="83x25" src="/images/assureurs/'+c.logo+'")}}"> </p>';
              html +=     '</div>';
              html +='</div>';
              html += '<div class="row">';
              html +=     '<div class="col-md-12">';
              html +=         '<table class="table">';
              html +=             '<tr>';
              html +=                 '<td>Montant Assurance '+c.desc_periode+'</td>';
              html +=                 '<td>:</td>';
              html +=                 '<td>'+formatMoney(Math.floor(c.TTC) - <?=$prospect->reduction_commerciale ?>)+'</td>';
              html +=             '</<tr>';
              html +=             '<tr>';
              html +=                 '<td>Services supplémentaire</td>';
              html +=                 '<td>:</td>';
              html +=                 '<td>'+formatMoney(Math.floor(c.som_serv))+'</td>';
              html +=             '</<tr>';
              html +=             '<tr>';
              html +=                 '<td>TOTAL</td>';
              html +=                 '<td>:</td>';
              html +=                 '<td>'+formatMoney(Math.floor(c.som_serv + c.TTC) - <?=$prospect->reduction_commerciale ?>)+'</td>';
              html +=             '</<tr>';
              html +=         '</table>';
              html +=     '</div>';
              html +='</div>';
                                        
                                      
    
              $('#box_div').append(html);
            }
          })
          .done(function() {
            $("#validation_save_btn").prop("disabled", false);  
          });
      });
    
      $(".validation_devis_btn").click(function(){
          var id = $(this).attr("id");    
          $("#status_input").val("2");
          $("#qid_input_2").val(id);
          $("#validation_modal").modal({backdrop: 'static'});
    
          auto_id = $("#aid").val();
          user_id = $("#uid").val();
          assur_id = $("#assurance_auto_info_id").val();
          $.ajax({
            url: "/rest-api/v1/autoQuote/"+auto_id+"/"+user_id+"/"+assur_id,
            type: "get",
            success: function(data){
            var obj =JSON.parse(data)
            var c = obj[0];
            $('#box_div_2').html('')
            html = '<div class="row">';
            html +=     '<div class="col-md-12 alert-danger alert-dismissable alert-danger text-center">';
            html +=       '<div id="required_msg"></div>';
            html +=     '</div>';
            html +='</div><br/>';
            html += '<div class="row">';
            html +=     '<div class="col-md-12">';
            html +=       '<div class="form-group">';
            html +=         '<label for="delivery_location" class="col-sm-4 control-label">Numéro de téléphone</label>';
            html +=         '<div class="col-sm-8">'
            html +=           '<input type="text" value="{{ addslashes($prospect->contact) }}" class="form-control delivery" required id="delivery_phone" name="delivery_phone" />'
            html +=         '</div>';
            html +=       '</div>';
            html +=     '</div>';
            html +='</div><br/>';
            html += '<div class="row">';
            html +=     '<div class="col-md-12">';
            html +=       '<div class="form-group">';
            html +=         '<label for="delivery_location" class="col-sm-4 control-label">Adresse de livraison</label>';
            html +=         '<div class="col-sm-8">'
            html +=           '<textarea class="form-control delivery" required id="delivery_location" name="delivery_location" row="4"><?=  str_replace(array("\n", "\r","\r\n"), " ",trim(addslashes($prospect->delivery_location))) ?></textarea>'
            html +=         '</div>';
            html +=       '</div>';
            html +=     '</div>';
            html +='</div><br/>';
    
            html += '<div class="row">';
            html +=     '<div class="col-md-12 text-center">';
            html +=       '<label class="checkbox checkbox-custom">';
            html +=       '<input name="espace_perso" id="espace_perso" type="checkbox"><i></i> Envoyer Accès de connexion Espace Perso';
            html +=       '</label>';
            html +=     '</div>'
            html += '</div>'
            html += '<div class="row">';
            html +=     '<div class="col-md-12">';
            html +=         '<table class="table">';
            html +=             '<tr>';
            html +=                 '<td>Montant Assurance '+c.desc_periode+'</td>';
            html +=                 '<td>:</td>';
            html +=                 '<td>'+formatMoney(Math.floor(c.TTC) - <?=$prospect->reduction_commerciale ?>)+'</td>';
            html +=             '</<tr>';
            html +=             '<tr>';
            html +=                 '<td>Services supplémentaire</td>';
            html +=                 '<td>:</td>';
            html +=                 '<td>'+formatMoney(Math.floor(c.som_serv))+'</td>';
            html +=             '</<tr>';
            html +=             '<tr>';
            html +=                 '<td>TOTAL</td>';
            html +=                 '<td>:</td>';
            html +=                 '<td>'+formatMoney(Math.floor(c.som_serv + c.TTC) - <?=$prospect->reduction_commerciale ?>)+'</td>';
            html +=             '</<tr>';
            html +=         '</table>';
            html +=     '</div>';
            html +='</div>';
    
    
            $('#box_div_2').append(html);
    
            //$("#validation_save_btn").attr("disabled", "true");
       
            }
          })
          .done(function() {
            $("#validation_save_btn").prop("disabled", false);
            
          });
      });
    
      $(".finish_trait_btn").click(function(){
          var id = $(this).attr("id");    
           $("#status_input").val("3");
           $("#qid_input_2").val(id);
           $("#validation_modal").modal({backdrop: 'static'});
          auto_id = $("#aid").val();
          user_id = $("#uid").val();
          assur_id = $("#assurance_auto_info_id").val();
          $.ajax({
            url: "/rest-api/v1/autoQuote/"+auto_id+"/"+user_id+"/"+assur_id,
            type: "get",
            success: function(data){
            var obj =JSON.parse(data)
            var c = obj[0];
            $('#box_div_2').html('')
            html = '<div class="row">';
            html +=     '<div class="col-md-12 alert-danger alert-dismissable alert-danger text-center">';
            html +=       '<div id="required_msg"></div>';
            html +=     '</div>';
            html +='</div><br/>';
            html += '<div class="row">';
            html +=     '<div class="col-md-12">';
            html +=       '<div class="form-group has-error">';
            html +=         '<label for="policy_number" class="col-sm-4 control-label">Numéro de police</label>';
            html +=         '<div class="col-sm-8">'
            html +=           '<input type="text" class="form-control delivery" value="<?= htmlentities(addslashes($prospect->policy_number)) ?>" required id="policy_number" name="policy_number" />'
            html +=         '</div>';
            html +=       '</div>';
            html +=     '</div>';
            html +='</div><br/>';
            html += '<div class="row">';
            html +=     '<div class="col-md-12">';
            html +=       '<div class="form-group">';
            html +=         '<label for="delivery_location" class="col-sm-4 control-label">Numéro de téléphone</label>';
            html +=         '<div class="col-sm-8">'
            html +=           '<input type="text" class="form-control delivery" value="<?= htmlentities(addslashes($prospect->phone_client)) ?>" required id="delivery_phone" name="delivery_phone" />'
            html +=         '</div>';
            html +=       '</div>';
            html +=     '</div>';
            html +='</div><br/>';
            html += '<div class="row">';
            html +=     '<div class="col-md-12">';
            html +=       '<div class="form-group">';
            html +=         '<label for="delivery_location" class="col-sm-4 control-label">Adresse de livraison</label>';
            html +=         '<div class="col-sm-8">'
            html +=           '<textarea class="form-control delivery" required id="delivery_location" name="delivery_location" row="4"> <?=  str_replace(array("\n", "\r","\r\n"), " ",trim(addslashes($prospect->delivery_location))) ?></textarea>'
            html +=         '</div>';
            html +=       '</div>';
            html +=     '</div>';
            html +='</div><br/>';
            html += '<div class="row">';
            html +=     '<div class="col-md-12">';
            html +=         '<table class="table">';
            html +=             '<tr>';
            html +=                 '<td>Montant Assurance '+c.desc_periode+'</td>';
            html +=                 '<td>:</td>';
            html +=                 '<td>'+formatMoney(Math.floor(c.TTC) - <?=$prospect->reduction_commerciale ?>)+'</td>';
            html +=             '</<tr>';
            html +=             '<tr>';
            html +=                 '<td>Services supplémentaire</td>';
            html +=                 '<td>:</td>';
            html +=                 '<td>'+formatMoney(Math.floor(c.som_serv))+'</td>';
            html +=             '</<tr>';
            html +=             '<tr>';
            html +=                 '<td>TOTAL</td>';
            html +=                 '<td>:</td>';
            html +=                 '<td>'+formatMoney(Math.floor(c.som_serv + c.TTC) - <?=$prospect->reduction_commerciale ?>)+'</td>';
            html +=             '</<tr>';
            html +=         '</table>';
            html +=     '</div>';
            html +='</div>';
    
    
            $('#box_div_2').append(html);
    
            
    
            }
          })
          .done(function() {
            $("#validation_save_btn").prop("disabled", false);
            
          });
      });
    
      $(".confirm_delivery_btn").click(function(){
          var id = $(this).attr("id");
           $("#status_input").val("4");
           $("#qid_input_2").val(id);
           $("#validation_modal").modal({backdrop: 'static'});
           auto_id = $("#aid").val();
           user_id = $("#uid").val();
           assur_id = $("#assurance_auto_info_id").val();
           $.ajax({
             url: "/rest-api/v1/autoQuote/"+auto_id+"/"+user_id+"/"+assur_id,
             type: "get",
             success: function(data){
             var obj =JSON.parse(data)
             var c = obj[0];
             $('#box_div_2').html('')
             html = '<div class="row">';
             html +=     '<div class="col-md-12 alert-danger alert-dismissable alert-danger text-center">';
             html +=       '<div id="required_msg"></div>';
             html +=     '</div>';
             html +='</div><br/>';
             html += '<div class="row">';
             html +=     '<div class="col-md-12">';
             html +=       '<div class="form-group has-error">';
             html +=         '<label for="policy_number" class="col-sm-4 control-label">Numéro de Police</label>';
             html +=         '<div class="col-sm-8">'
             html +=           '<input type="text" class="form-control delivery" value="<?= htmlentities(addslashes($prospect->policy_number)) ?>" required id="policy_number" name="policy_number" />'
             html +=         '</div>';
             html +=       '</div>';
             html +=     '</div>';
             html +='</div><br/>';
             html += '<div class="row">';
             html +=     '<div class="col-md-12">';
             html +=       '<div class="form-group">';
             html +=         '<label for="delivery_location" class="col-sm-4 control-label">Numéro de téléphone</label>';
             html +=         '<div class="col-sm-8">'
             html +=           '<input type="text" class="form-control delivery" required id="delivery_phone" name="delivery_phone" value="<?= htmlentities(addslashes($prospect->phone_client)) ?>" />'
             html +=         '</div>';
             html +=       '</div>';
             html +=     '</div>';
             html +='</div><br/>';
             html += '<div class="row">';
             html +=     '<div class="col-md-12">';
             html +=       '<div class="form-group">';
             html +=         '<label for="delivery_location" class="col-sm-4 control-label">Adresse de livraison</label>';
             html +=         '<div class="col-sm-8">'
             html +=           '<textarea class="form-control delivery" required id="delivery_location" name="delivery_location" row="4"><?=  str_replace(array("\n", "\r","\r\n"), " ",trim(addslashes($prospect->delivery_location))) ?></textarea>'
             html +=         '</div>';
             html +=       '</div>';
             html +=     '</div>';
             html +='</div><br/>';
             html += '<div class="row">';
             html +=     '<div class="col-md-12">';
             html +=         '<table class="table">';
             html +=             '<tr>';
             html +=                 '<td>Montant Assurance '+c.desc_periode+'</td>';
             html +=                 '<td>:</td>';
             html +=                 '<td>'+formatMoney(Math.floor(c.TTC) - <?=$prospect->reduction_commerciale ?>)+'</td>';
             html +=             '</<tr>';
             html +=             '<tr>';
             html +=                 '<td>Services supplémentaire</td>';
             html +=                 '<td>:</td>';
             html +=                 '<td>'+formatMoney(Math.floor(c.som_serv))+'</td>';
             html +=             '</<tr>';
             html +=             '<tr>';
             html +=                 '<td>TOTAL</td>';
             html +=                 '<td>:</td>';
             html +=                 '<td>'+formatMoney(Math.floor(c.som_serv + c.TTC) - <?=$prospect->reduction_commerciale ?>)+'</td>';
             html +=             '</<tr>';
             html +=         '</table>';
             html +=     '</div>';
             html +='</div>';
    
    
             $('#box_div_2').append(html);
    
             //$("#validation_save_btn").attr("disabled", "true"); 
             }
           })
            .done(function() {
              $("#validation_save_btn").prop("disabled", false);
              
            });
      });
    
    
    
      $(".encaisse_and_close_btn").click(function(){
          var id = $(this).attr("id");
           $("#status_input").val("5");
           $("#qid_input_2").val(id);
           $("#validation_modal").modal({backdrop: 'static'});
           auto_id = $("#aid").val();
           user_id = $("#uid").val();
           assur_id = $("#assurance_auto_info_id").val();
           $.ajax({
             url: "/rest-api/v1/autoQuote/"+auto_id+"/"+user_id+"/"+assur_id,
             type: "get",
             success: function(data){
             var obj =JSON.parse(data)
             var c = obj[0];
             $('#box_div_2').html('')
             html = '<div class="row">';
             html +=     '<div class="col-md-12 alert-danger alert-dismissable alert-danger text-center">';
             html +=       '<div id="required_msg"></div>';
             html +=     '</div>';
             html +='</div><br/>';
             
             html += '<div class="row">';
             html +=     '<div class="col-md-12">';
             html +=       '<div class="form-group has-error">';
             html +=         '<label for="policy_number" class="col-sm-4 control-label">Numéro de Police</label>';
             html +=         '<div class="col-sm-8">'
             html +=           '<input type="text" class="form-control delivery" value="<?= htmlentities(addslashes($prospect->policy_number)) ?>" required id="policy_number" name="policy_number" />'
             html +=         '</div>';
             html +=       '</div>';
             html +=     '</div>';
             html +='</div><br/>';
             html += '<div class="row">';
             html +=     '<div class="col-md-12">';
             html +=       '<div class="form-group">';
             html +=         '<label for="delivery_location" class="col-sm-4 control-label">Numéro de téléphone</label>';
             html +=         '<div class="col-sm-8">'
             html +=           '<input type="text" class="form-control delivery" readonly required id="delivery_phone" name="delivery_phone" value="<?= htmlentities(addslashes($prospect->phone_client)) ?>"/>'
             html +=         '</div>';
             html +=       '</div>';
             html +=     '</div>';
             html +='</div><br/>';
             html += '<div class="row">';
             html +=     '<div class="col-md-12">';
             html +=       '<div class="form-group">';
             html +=         '<label for="delivery_location" class="col-sm-4 control-label">Adresse de livraison</label>';
             html +=         '<div class="col-sm-8">'
             html +=           '<textarea class="form-control delivery" required readonly id="delivery_location" name="delivery_location" row="4"><?=  str_replace(array("\n", "\r","\r\n"), " ",trim(addslashes($prospect->delivery_location))) ?></textarea>'
             html +=         '</div>';
             html +=       '</div>';
             html +=     '</div>';
             html +='</div><br/>';
             html += '<div class="row">';
             html +=     '<div class="col-md-12">';
             html +=       '<div class="form-group has-error">';
             html +=         '<label for="delivery_location" class="col-sm-4 control-label">Montant Encaissé</label>';
             html +=         '<div class="col-sm-8">'
             html +=           '<input type="text" class="form-control delivery" required id="amount_inbox" name="amount_inbox" value="'+Math.floor(c.som_serv + c.TTC  - <?=$prospect->reduction_commerciale ?>)+'" />'
             html +=         '</div>';
             html +=       '</div>';
             html +=     '</div>';
             html +='</div><br/>';
             html += '<div class="row">';
             html +=     '<div class="col-md-12">';
             html +=         '<table class="table">';
             html +=             '<tr>';
             html +=                 '<td>Montant Assurance '+c.desc_periode+'</td>';
             html +=                 '<td>:</td>';
             html +=                 '<td>'+formatMoney(Math.floor(c.TTC) - <?=$prospect->reduction_commerciale ?>)+'</td>';
             html +=             '</<tr>';
             html +=             '<tr>';
             html +=                 '<td>Services supplémentaire</td>';
             html +=                 '<td>:</td>';
             html +=                 '<td>'+formatMoney(Math.floor(c.som_serv))+'</td>';
             html +=             '</<tr>';
             html +=             '<tr>';
             html +=                 '<td>TOTAL</td>';
             html +=                 '<td>:</td>';
             html +=                 '<td>'+formatMoney(Math.floor(c.som_serv + c.TTC) - <?=$prospect->reduction_commerciale ?>)+'</td>';
             html +=             '</<tr>';
             html +=         '</table>';
             html +=     '</div>';
             html +='</div>';
    
    
             $('#box_div_2').append(html);
             }
           })
            .done(function() {
              $("#validation_save_btn").prop("disabled", false);
              
            });
      });
    
      $(".sinistre_btn").click(function(){
        $("#modal_sinistre").modal({backdrop: 'static'});
      });
    
      $("#confirm_save_btn").click(function(e){
        e.preventDefault();
        $.ajax({
                 url: $('#form_confirm').attr('action'),
                 type : "POST",
                 data : $('#form_confirm').serialize(),
                 dataType:'html',
                 success :function(html)
                 {
                      if(html==1)
                      {
                        location.reload();  
                      } 
                      else
                      {
                          $('.confirmation_message_div').html("<p class='alert alert-danger'>Réessayer svp une erreure s'est produite</p>"); 
                      }
                  },
    
                    error: function(){
                       $('.confirmation_message_div').html("<p class='alert alert-danger'>Erreur interne du serveur</p>"); 
                   }
        });
      });
    
      $("#validation_save_btn").click(function(e){
          e.preventDefault();
          var valid = true;
            $('.delivery[required]').each(function(i, el){
              if(valid && $(el).val()=='' ) valid = false; 
            })
    
          if(valid){
            $.ajax({
                   url: $('#form_validation').attr('action'),
                   type : $('#form_validation').attr('method'),
                   data : $('#form_validation').serialize(),
                   dataType:'html',
                   success :function(html)
                   {
                    if(html==1)
                        {
                          location.reload();  
                        } 
                        else
                        {
                            $('.validation_message_div').html("<p class='alert alert-danger'>Réessayer svp une erreure s'est produite</p>");
                            
                        }
                    },
    
                      error: function(){
                         $('.validation_message_div').html("<p class='alert alert-danger'>Réessayer svp une erreure s'est produite</p>");
                     }
            });
          }
          else{
            $("#required_msg").html("<b>Tous les champs sont obligatoire</b>")
          }
      });
    
      $("#sinistre_save_btn").click(function(e){
        e.preventDefault();
        $.ajax({
                         url: $('#form_sinistre').attr('action'),
                         type : $('#form_sinistre').attr('method'),
                         data : $('#form_sinistre').serialize(),
                         dataType:'html',
                         success :function(html)
                         {
                             if(html==0)
                             {
                                 ("#modal_sinistre").html("<p class='alert alert-danger'>Une erreur s'est produite</p>");
                             }
                             else
                             {
                                 $("#modal_sinistre").modal("hide");
                              location.href="/admin/devis/"+html;
                             }
                          },
    
                            error: function(){
                                ("#modal_sinistre").html("<p class='alert alert-danger'>Une erreur s'est produite</p>");
                             
                           }
        });
      });
    
    
      $('#category').on('change', function() {
          if(this.value=="2" || this.value=="3" || this.value=="8"){
            $('#div_cu').show()
            $("#cu").prop('required', true);
          }
          else{
            $('#div_cu').hide()
            $("#cu").prop('required', false);
          }
      })
    
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
      $('.dp_releasedate').datetimepicker({
        format: 'DD/MM/YYYY',
        showTodayButton: true,
      });
    
      $('.dp_firstreleasedate').datetimepicker({
        format: 'DD/MM/YYYY',
        viewMode: 'years'
      });
    </script>




