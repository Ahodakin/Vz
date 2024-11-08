@extends('Backoffice.layouts.app')
@section("content")
<div class="page page-dashboard">
    <style type="text/css">
        fieldset.dem-border {
          border: 1px solid #01a29c !important;
          padding: 0 1.4em 1.4em 1.4em !important;
          margin: 0 0 1.5em 0 !important;
          -webkit-box-shadow:  0px 0px 0px 0px #000;
          box-shadow:  0px 0px 0px 0px #000;
        }
    
        legend.dem-border {
          font-size: 1.2em !important;
          font-weight: 500 !important;
          text-align: left !important;
          width:auto;
          padding:0 10px;
          border-bottom:none;
          color: #01a29c
        }
    
        #stop-resume{
            display: block;
            padding: 10px;
            background-color: #f1f1f1;
            margin:10px;
            width: 70px;
            text-align: center;
            border:solid 1px white;
            text-transform: uppercase;
            font-family: sans-serif;
            text-decoration: none;
        }
        #stop-resume:active{
            background-color:white;
            border:solid 1px #f1f1f1;
            color:blue;
        }
    </style>
    <div class="pageheader">

        <h2>Tableau de bord <span>{{ (isset($_GET['start']) && isset($_GET['end']))? "Du ".date("d/m/Y",strtotime($_GET['start']))." au ".date("d/m/Y",strtotime($_GET['end'])):'' }}</span></h2>

        <div class="page-bar"  style="margin-bottom:20px">

            <ul class="page-breadcrumb">
                <li>
                    <a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> MONASSURANCE.CI</a>
                </li>
                <li>
                    <a href="{{route('spaceDashboard')}}">Tableau de bord {{ (isset($_GET['start']) && isset($_GET['end']))? "Du ".date("d/m/Y",strtotime($_GET['start']))." au ".date("d/m/Y",strtotime($_GET['end'])):'' }} </a>
                </li>
            </ul>
            <div class="page-toolbar">
                <a role="button" tabindex="0" class="btn btn-lightred no-border pickDate">
                    <i class="fa fa-calendar"></i>&nbsp;&nbsp;<span></span>&nbsp;&nbsp;<i class="fa fa-angle-down"></i>
                </a>
            </div>
        </div>
        
        <form method="get" id="custom_search" action="">
            <input type="hidden" value="<?= (isset($_GET['start']))?$_GET['start']:'' ?>" name="start" id="start">
            <input type="hidden" value="<?= (isset($_GET['start']))?$_GET['end']:'' ?>" name="end" id="end">
        </form>

    </div>
    @if(\Illuminate\Support\Facades\Session::has('error'))
            <div class="text-center container w-420">
                <div class="alert alert-danger alert-dismissable">
                    <h4><p align="center">{{\Illuminate\Support\Facades\Session::get('error')}}</p></h4>
                </div>
            </div>
        @endif

        @if(\Illuminate\Support\Facades\Session::has('success'))
            <div class="text-center container w-420">
                <div class="alert alert-success alert-dismissable">
                    <h4><p align="center">{{\Illuminate\Support\Facades\Session::get('success')}}</p></h4>
                </div>
            </div>
        @endif

    
    <fieldset class="dem-border">
        <legend class="dem-border">File active des commandes</legend>  
        <div class="row">
            <div class="col-md-12">
                <!-- cards row -->
                <div class="row">
                    <div class="col-md-2">
                       <a href="{{-- route('devis.editer') --}}"><section class="tile tile-simple">
                            <div class="tile-widget bg-blue text-center p-30">
                                <i class="fa fa-check fa-3x"></i>
                            </div>

                            <div class="tile-body text-center">

                                <h1 class="m-0">{{$confirm_1}}</h1>
                                <span class="text-muted">Nouveau dévis</span>

                            </div>
                        </section>  {{--</a> --}}
                    </div>

                    <div class="col-md-2">
                        <a href="{{--route('commande.a.traiter')--}}"><section class="tile tile-simple">
                            <!-- tile widget -->
                            <div class="tile-widget bg-orange text-center p-30">
                                <i class="fa  fa-refresh fa-3x"></i>
                            </div>
                            <!-- /tile widget -->

                            <!-- tile body -->
                            <div class="tile-body text-center">

                                <h1 class="m-0">{{$processiong_2}}</h1>
                                <span class="text-muted">en attente de traitement</span>

                            </div>
                            <!-- /tile body -->
                        </section></a> 
                    </div>

                    <div class="col-md-2">
                        <a href="{{--route('commande.a.livrer')--}}"><section class="tile tile-simple">
                            <!-- tile widget -->
                            <div class="tile-widget bg-drank text-center p-30">
                                <i class="fa fa-truck fa-3x"></i>
                            </div>
                            <!-- /tile widget -->

                            <!-- tile body -->
                            <div class="tile-body text-center">

                                <h1 class="m-0">{{$pending_3}}</h1>
                                <span class="text-muted">en attente de livraison</span>

                            </div>
                            <!-- /tile body -->
                        </section></a> 
                    </div>

                    <div class="col-md-2">
                        <a href="{{--route('commande.a.encaisser')--}}"><section class="tile tile-simple">
                            <!-- tile widget -->
                            <div class="tile-widget bg-slategray text-center p-30">
                                <i class="fa fa-dollar fa-3x"></i>
                            </div>
                            <!-- /tile widget -->

                            <!-- tile body -->
                            <div class="tile-body text-center">

                                <h1 class="m-0">{{$delivery_4}}</h1>
                                <span class="text-muted">livrées (à encaisser)</span>

                            </div>
                            <!-- /tile body -->
                        </section></a> 
                    </div>

                    <div class="col-md-2">
                        <a href="{{--route('commande.traitees')--}}"><section class="tile tile-simple">
                            <!-- tile widget -->
                            <div class="tile-widget bg-green text-center p-30">
                                <i class="fa fa-thumbs-o-up fa-3x"></i>
                            </div>
                            <!-- /tile widget -->

                            <!-- tile body -->
                            <div class="tile-body text-center">

                                <h1 class="m-0">{{$complete_5}}</h1>
                                <span class="text-muted">terminées</span>

                            </div>
                            <!-- /tile body -->
                        </section></a> 
                    </div>

                    <div class="col-md-2">
                        <a href="{{--route('devis.editer')--}}"><section class="tile tile-simple">
                            <!-- tile widget -->
                            <div class="tile-widget bg-lightred text-center p-30">
                                <i class="fa fa-times fa-3x"></i>
                            </div>
                            <!-- /tile widget -->

                            <!-- tile body -->
                            <div class="tile-body text-center">

                                <h1 class="m-0">{{$cancel_6}}</h1>
                                <span class="text-muted">annulées</span>

                            </div>
                            <!-- /tile body -->
                        </section></a> 
                    </div>
                    

                </div>
                <!-- /row -->
            </div>
        </div>
    </fieldset>
    <div class="row">
        <!-- col -->
        <div class="col-md-8">
            <section class="tile">

                <!-- tile header -->
                <div class="tile-header bg-greensea dvd dvd-btm">
                    <h1 class="custom-font"><strong>Statistiques </strong>des commandes</h1>
                    <ul class="controls">
                        
                        <li class="dropdown">

                            <a role="button" tabindex="0" class="dropdown-toggle settings" data-toggle="dropdown">
                                <i class="fa fa-cog"></i>
                                <i class="fa fa-spinner fa-spin"></i>
                            </a>

                            <ul class="dropdown-menu pull-right with-arrow animated littleFadeInUp">
                                <li>
                                    <a role="button" tabindex="0" class="tile-toggle">
                                        <span class="minimize"><i class="fa fa-angle-down"></i>&nbsp;&nbsp;&nbsp;Minimize</span>
                                        <span class="expand"><i class="fa fa-angle-up"></i>&nbsp;&nbsp;&nbsp;Expand</span>
                                    </a>
                                </li>
                                <li>
                                    <a role="button" tabindex="0" class="tile-refresh">
                                        <i class="fa fa-refresh"></i> Refresh
                                    </a>
                                </li>
                                <li>
                                    <a role="button" tabindex="0" class="tile-fullscreen">
                                        <i class="fa fa-expand"></i> Fullscreen
                                    </a>
                                </li>
                            </ul>

                        </li>
                        <li class="remove"><a role="button" tabindex="0" class="tile-close"><i class="fa fa-times"></i></a></li>
                    </ul>
                </div>
                <!-- /tile header -->

               
                <!-- /tile widget -->

                <!-- tile body -->
                <div class="tile-body">

                    <!-- row -->
                    <div class="row">


                        <!-- col -->
                        <div class="col-md-8 col-sm-12">

                            <h4 class="underline custom-font mb-20"><strong>Statistiques</strong> actuelles</h4>

                            <!-- row -->
                            <div class="row">
                                <!-- col -->
                                <div class="col-lg-4 text-center">
                                    <div class="easypiechart" data-percent="100" data-size="140" data-bar-color="#418bca" data-scale-color="false" data-line-cap="round" data-line-width="4" style="width: 140px; height: 140px;">

                                        <i class="fa fa-usd fa-4x text-blue" style="line-height: 140px;"></i>

                                    <canvas height="140" width="140"></canvas></div>
                                    <p class="text-uppercase text-elg mt-20 mb-0">
                                    <strong class="text-blue">
                                    @if(isset($_GET['start']) && isset($_GET['end']))
                                    {{getAllOrders($_GET['start'], $_GET['end'])->count()}}
                                    @else
                                    {{getAllOrders()->count()}}
                                    @endif
                                    </strong> <small class="text-lg text-light text-default lt">Commandes</small></p>
                                    <p class="text-light"><i class="text-warning"></i> Commandes vendues</p>
                                    
                                </div>
                                <div class="col-lg-4 text-center">
                                    <div class="easypiechart" data-percent="100" data-size="140" data-bar-color="#e05d6f" data-scale-color="false" data-line-cap="round" data-line-width="4" style="width: 140px; height: 140px;">

                                        <i class="fa fa-barcode fa-4x text-lightred" style="line-height: 140px;"></i>
                                        <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-lightred">
                                        
                                        @if(isset($_GET['start']) && isset($_GET['end']))
                                        {{sizeof(optionalProductSale($_GET['start'], $_GET['end']))}}
                                        @else
                                        {{sizeof(optionalProductSale())}}
                                        @endif
                                        </strong> <small class="text-lg text-light text-default lt">Services</small></p>
                                        <p class="text-light"><i class="text-warning"></i> Services facultatifs</p>
                                    <canvas height="140" width="140"></canvas></div>
                                </div>
                                <!-- /col -->
                                <!-- col -->
                                <div class="col-lg-4 text-center">
                                    <div class="easypiechart" data-percent="4006" data-size="140" data-bar-color="#16a085" data-scale-color="false" data-line-cap="round" data-line-width="4" style="width: 140px; height: 140px;">

                                        <i class="fa fa-file-pdf-o fa-4x text-greensea" style="line-height: 140px;"></i>
                                        <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-greensea">
                                        
                                        @if(isset($_GET['start']) && isset($_GET['end']))
                                        {{getAllQuotation($_GET['start'], $_GET['end'])->count()}}
                                        @else
                                        {{getAllQuotation()->count()}}

                                        @endif
                                        </strong> <small class="text-lg text-light text-default lt">Devis</small></p>
                                        <p class="text-light"><i class="text-warning"></i> Dévis générés</p>
                                    <canvas height="140" width="140"></canvas></div>
                                </div>
                                <!-- /col -->
                            </div>
                            <!-- /row -->

                        </div>
                        <!-- /col -->



                        <!-- col -->
                        <div class="col-md-4 col-sm-12">

                            <h4 class="underline custom-font"><strong>5 dernières </strong> Commandes</h4>
                            @if(isset($_GET['start']) && isset($_GET['end']))
                                @foreach(lastFiveOrders($_GET['start'], $_GET['end']) as $order)
                                    <div class="progress-list">
                                        <div class="details">
                                            <div class="title">{{ get_product_type($order->product_type) }}</div>
                                            <div class="description">{{ $order->number_n }} ( {{ dateAgo($order->created_at) }} )</div>
                                        </div>
                                        <div class="status pull-right">
                                            <span>{{get_commande_percentage($order->status)}}</span>%
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="progress-xs not-rounded progress">
                                          <div class="progress-bar progress-bar-@if($order->status==1 || $order->status==2)info @elseif($order->status==3 || $order->status==4)warning @elseif($order->status==5)success @else danger @endif" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: {{get_commande_percentage($order->status)}}%">
                                            <span class="sr-only">{{get_commande_percentage($order->status)}}%</span>
                                          </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                @foreach(lastFiveOrders() as $order)
                                    <div class="progress-list">
                                        <div class="details">
                                            <div class="title">{{ get_product_type($order->product_type) }}</div>
                                            <div class="description">{{ $order->number_n }} ( {{ dateAgo($order->created_at) }} )</div>
                                        </div>
                                        <div class="status pull-right">
                                            <span>{{get_commande_percentage($order->status)}}</span>%
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="progress-xs not-rounded progress">
                                          <div class="progress-bar progress-bar-@if($order->status==1 || $order->status==2)info @elseif($order->status==3 || $order->status==4)warning @elseif($order->status==5)success @else danger @endif" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: {{get_commande_percentage($order->status)}}%">
                                            <span class="sr-only">{{get_commande_percentage($order->status)}}%</span>
                                          </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            

                        </div>
                        <!-- /col -->




                    </div>
                    <!-- /row -->

                </div>
                <!-- /tile body -->

            </section>
        </div>
        @role('advisor')
        <div class="col-md-4">
            <!-- tile -->
            <section class="tile bg-lightred">

                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Alertes Relances </strong>clients</h1>
                    
                </div>
                <!-- /tile header -->
                    {{--<div id="mini-calendar"></div>--}}
                    <!-- tile footer -->
                    <div class="tile-footer">

                        <div class="owl-carousel" id="revive-carousel">
                            @if(isset($_GET['start']) && isset($_GET['end']))
                                @foreach(getAllReviveQuote($_GET['start'], $_GET['end']) as $rev)
                                     @if( (strtotime($rev->revive_date. "-3 days")) <= (strtotime(date("Y-m-d"))))
                                    <div>
                                        <p class="text-center text-strong"><i class="fa fa-user"></i> {{$rev->firstname ." ". $rev->lastname}}, <small class="text-thin">
                                        @if($rev->product_type==1)
                                        <a href="{{route('devis.details',['id'=>$rev->qid,'aid'=>$rev->assurance_infos_id])}}">
                                        {{$rev->number_n}}</a>
                                        @else
                                        <a href="{{route('devis.voyage.details',['id'=>$rev->qid,'aid'=>$rev->assurance_infos_id])}}">
                                        {{$rev->number_n}}</a>
                                        @endif
                                        , {{ date('d M Y', strtotime($rev->created_at)) }}</small></p>
                                        <p>
                                        <h5 class="mt-10 mb-0 text-strong">{!!$rev->advisor_note!!}</h5>
                                        <br>
                                            <small class="text-thin">
                                            @if(date('d/m/Y', strtotime($rev->revive_date)) == date('d/m/Y'))
                                                <b class="blinked">Relance prévue pour Aujourd'hui</b>
                                            @else
                                               Relance prévue pour {{ date('d/m/Y', strtotime($rev->revive_date)) }}
                                            @endif
                                            </small>
                                        </p>
                                    </div>
                                    @endif
                                @endforeach
                            @else
                                @foreach(getAllReviveQuote() as $rev)
                                        @if( (strtotime($rev->revive_date. "-3 days")) <= (strtotime(date("Y-m-d"))))
                                        <div>
                                            <p class="text-center text-strong">
                                                <i class="fa fa-user"></i> {{$rev->firstname ." ". $rev->lastname}}, 
                                                <small class="text-thin">
                                                    @if($rev->product_type==1)
                                                    <a href="{{route('devis.details',['id'=>$rev->qid,'aid'=>$rev->assurance_infos_id])}}">
                                                    {{$rev->number_n}}</a>
                                                    @else
                                                    <a href="{{route('devis.voyage.details',['id'=>$rev->qid,'aid'=>$rev->assurance_infos_id])}}">
                                                    {{$rev->number_n}}</a>
                                                    @endif
                                                , {{ date('d/m/Y', strtotime($rev->created_at)) }}</small></p>
                                            <p>
                                            <h5 class="mt-10 mb-0">{!!$rev->advisor_note!!}</h5>
                                            <br>
                                            <small class="text-thin"> 
                                            @if(date('d/m/Y', strtotime($rev->revive_date)) == date('d/m/Y'))
                                                <b class="blinked">Relance prévue pour Aujourd'hui</b>
                                            @else
                                               Relance prévue pour {{ date('d/m/Y', strtotime($rev->revive_date)) }}
                                            @endif
                                            </small>
                                            </p>
                                        </div>
                                        @endif
                                @endforeach
                            @endif
                            

                        </div>
                </div>
                <!-- /tile body -->

            </section>
            <!-- /tile -->
        </div>
        @endrole
        <!-- col -->
    </div>
    <!-- row -->
    @role('advisor')
    <div class="row">

        <!-- col -->
        <div class="col-md-4">
            <!-- tile -->
            <section class="tile widget-message">

                <!-- tile header -->
                <div class="tile-header bg-blue dvd dvd-btm">
                    <h1 class="custom-font"><strong>SMS </strong>Rapide</h1>
                    
                </div>
                <!-- /tile header -->
                <form method="post" action="{{ route('sendSMS') }}">
                {{csrf_field()}}
                <!-- tile widget -->
                <div class="tile-widget bg-blue">

                        <div class="form-group">
                            <input type="text" name="sender_id" class="form-control underline-input" placeholder="Choisir un SENDERID" value="220 170 00" readonly required>
                        </div>
                        <div class="form-group">
                            <select data-placeholder="Selectionner destinataire..." multiple="" tabindex="3" class="chosen-select input-underline" style="width: 100%;" name="contacts[]" required>
                                @foreach(getActiveAutoOrders() as $o )
                                @if( (strtotime($o->expired_date. "-7 days")) <= (strtotime(date("Y-m-d"))))
                                <option value="{{$o->contact}}"> {{$o->firstname ." ".$o->lastname}} - {{$o->contact}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>

                </div>
                <!-- /tile widget -->

                <!-- tile body -->
                <div class="tile-body p-0">

                    <textarea name="sms_note" id="sms_note">Bonjour cher client,</textarea name="">

                </div>
                <!-- /tile body -->

                <!-- tile footer -->
                <div class="tile-footer bg-blue text-right">

                    <button type="submit" class="btn btn-blue btn-ef btn-ef-7 btn-ef-7h" activate-button="success"><i class="fa fa-envelope"></i> Envoyer SMS</button>

                </div>
                <!-- /tile footer -->
                </form>

            </section>
            <!-- /tile -->
        </div>
        <!-- /col -->
        <!-- col -->
        <div class="col-md-4">
            <!-- tile -->
            <section class="tile widget-message">

                <!-- tile header -->
                <div class="tile-header bg-greensea dvd dvd-btm">
                    <h1 class="custom-font"><strong>Email </strong>Rapide</h1>
                </div>
                <!-- /tile header -->
                 <form method="post" action="{{ route('sendEmail') }}">
                {{csrf_field()}}
                <!-- tile widget -->
                <div class="tile-widget bg-greensea">

                        <div class="form-group">
                            <select data-placeholder="Selectionner destinataire..." multiple="" tabindex="3" class="chosen-select input-underline" style="width: 100%;" name="emails[]"> 
                                @foreach(getActiveAutoOrders() as $o )
                                @if( (strtotime($o->expired_date. "-7 days")) <= (strtotime(date("Y-m-d"))))
                                <option value="{{$o->email}}"> {{$o->firstname ." ".$o->lastname}} - {{$o->email}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" required name="objet" class="form-control underline-input" placeholder="Objet du mail">
                        </div>
                </div>
                <!-- /tile widget -->

                <!-- tile body -->
                <div class="tile-body p-0">
                    <textarea name="mail_note" id="mail_note" required>Bonjour cher client,</textarea>
                </div>
                <!-- /tile body -->

                <!-- tile footer -->
                <div class="tile-footer bg-greensea text-right">

                    <button type="submit" class="btn btn-greensea btn-ef btn-ef-7 btn-ef-7h" activate-button="success"><i class="fa fa-envelope"></i> Envoyer Mail</button>

                </div>
                <!-- /tile footer -->
                </form>
                

            </section>
            <!-- /tile -->
        </div>
        <!-- /col -->
        <div class="col-md-4">
            <!-- tile -->
            <section class="tile tile-simple bg-lightred" style="min-height: 190px; overflow: hidden;">

                <!-- tile header -->
                <div class="tile-header">
                    <h1 class="custom-font">Contrat Auto bientôt à expiration</h1>
                    <ul class="controls">
                        <li class="remove"><a role="button" tabindex="0" class="tile-close"><i class="fa fa-times"></i></a></li>
                    </ul>
                </div>
                <!-- /tile header -->

                <!-- tile body -->
                <div class="tile-body">

                    <div id="todo-carousel" class="owl-carousel">
                        @foreach(getActiveAutoOrders() as $o )
                            @if( (strtotime($o->expired_date. "-7 days")) <= (strtotime(date("Y-m-d"))))
                        <div>
                            <div class="progress-list">
                                <div class="details">
                                    <div class="title"><i class="fa fa-caret-right mr-5"></i> <span class="text-md">{{$o->firstname ." ".$o->lastname}} (#{{$o->number_n}})</span></div>
                                    <div class="description text-transparent-white text-lowercase">Expire le {{ date("d/m/Y", strtotime($o->expired_date." -1 days"))." 23:59:59" }}</div>
                                </div>
                                <div class="clearfix" style="height: 45px"></div>
                                <div class="progress transparent-black not-rounded mb-10">
                                  <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                    <i class="fa fa-phone"></i> <a href="javascript:;">{{$o->contact}}</a> | <i class="fa fa-envelope"></i> <a href="javascript:;">{{$o->email}}</a>
                                  </div>
                                </div>
                            </div>
                            <div class="pull-right">
                                {{$o->guarante}} | {{$o->compname}} | {{$o->lib_per}}
                            </div>
                            <p class="text-thin">Expire dans <strong>{{dateDiff(time(), strtotime($o->expired_date))["day"]}} jours</strong></p>
                        </div>
                            @endif
                        @endforeach

                    </div>

                </div>
                <!-- /tile body -->

            </section>
            <!-- /tile -->
            <section class="tile tile-simple">
                <!-- tile header -->
                <div class="tile-header bg-blue">
                    <h1 class="custom-font">Ventes par compagnie</h1>
                    <ul class="controls">
                        <li class="remove"><a role="button" tabindex="0" class="tile-close"><i class="fa fa-times"></i></a></li>
                    </ul>
                </div>
                <div class="tile-body">
                    <table class="table table-no-border m-0">
                        <tbody>
                            @if(isset($_GET['start']) && isset($_GET['end']))
                                @foreach(getSaleByCompany($_GET['start'], $_GET['end'])->get() as $key => $c)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $c->compname }}</td>
                                    <td>{{ $c->sales }}</td>
    
                                    <td>
                                        <div class="progress-xxs not-rounded mb-0 inline-block progress" style="width: 50px; margin-right: 5px">
                                            <div class="progress-bar progress-bar-greensea" role="progressbar" aria-valuenow="{{ $c->sales*100/(getAllProductContratContract($_GET['start'], $_GET['end'],1)->count()+getAllProductContratContract($_GET['start'], $_GET['end'],2)->count()+getAllProductContratContract($_GET['start'], $_GET['end'],3)->count()+getAllProductContratContract($_GET['start'], $_GET['end'],4)->count()) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $c->sales*100/(getAllProductContratContract($_GET['start'], $_GET['end'],1)->count()+getAllProductContratContract($_GET['start'], $_GET['end'],2)->count()+getAllProductContratContract($_GET['start'], $_GET['end'],3)->count()+getAllProductContratContract($_GET['start'], $_GET['end'],4)->count()) }}%;"></div>
                                        </div>
                                        <small>{{ round($c->sales*100/(getAllProductContratContract($_GET['start'], $_GET['end'],1)->count()+getAllProductContratContract($_GET['start'], $_GET['end'],2)->count()+getAllProductContratContract($_GET['start'], $_GET['end'],3)->count()+getAllProductContratContract($_GET['start'], $_GET['end'],4)->count()),2) }}%</small>
                                    </td>
    
                                </tr>
                                @endforeach
                            @else
                            @foreach(getSaleByCompany()->get() as $key => $c)
    
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $c->compname }}</td> 
                                <td>{{ $c->sales }}</td>  
                                <td>
                                    @php
                                        $totalContracts = getAllProductContratContract(null, null, 1)->count() + 
                                                          getAllProductContratContract(null, null, 2)->count() + 
                                                          getAllProductContratContract(null, null, 3)->count() + 
                                                          getAllProductContratContract(null, null, 4)->count();
                                    @endphp
                                
                                    @if ($totalContracts == 0)
                                        <!-- Insérer le contenu que vous souhaitez afficher si le total des contrats est 0 -->
                                    @else
                                        <div class="progress-bar progress-bar-greensea" role="progressbar"
                                             aria-valuenow="{{ $c->sales * 100 / $totalContracts }}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {{ $c->sales * 100 / $totalContracts }}%;">
                                        </div>
                                    @endif
                                </td>
                                     
                            </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </section> 
              
        </div>
        
    </div>
    @endrole

    <div class="row">
        <div class="col-md-4">
            <!-- tile -->
            <section class="tile">

                <!-- tile header -->
                <div class="tile-header bg-greensea dvd dvd-btm">
                    <h1 class="custom-font"><strong>Traitements </strong>des appels</h1>
                    <ul class="controls">
                        <li class="dropdown">

                            <a role="button" tabindex="0" class="dropdown-toggle settings" data-toggle="dropdown">
                                <i class="fa fa-cog"></i>
                                <i class="fa fa-spinner fa-spin"></i>
                            </a>

                            <ul class="dropdown-menu pull-right with-arrow animated littleFadeInUp">
                                <li>
                                    <a role="button" tabindex="0" class="tile-toggle">
                                        <span class="minimize"><i class="fa fa-angle-down"></i>&nbsp;&nbsp;&nbsp;Minimize</span>
                                        <span class="expand"><i class="fa fa-angle-up"></i>&nbsp;&nbsp;&nbsp;Expand</span>
                                    </a>
                                </li>
                                <li>
                                    <a role="button" tabindex="0" class="tile-refresh">
                                        <i class="fa fa-refresh"></i> Refresh
                                    </a>
                                </li>
                                <li>
                                    <a role="button" tabindex="0" class="tile-fullscreen">
                                        <i class="fa fa-expand"></i> Fullscreen
                                    </a>
                                </li>
                            </ul>

                        </li>
                        <li class="remove"><a role="button" tabindex="0" class="tile-close"><i class="fa fa-times"></i></a></li>
                    </ul>
                </div>
                <!-- /tile header -->

                <!-- tile widget -->
                <div class="tile-widget bg-greensea">
                    <div id="statistics-chart" style="height: 250px;"></div>
                </div>
                <!-- /tile widget -->
        </div>
        <div class="col-md-4">
            <section class="tile" fullscreen="isFullscreen02">

                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Je veux </strong>me faire appeller</h1>
                    <ul class="controls">
                        <li class="dropdown">

                            <a role="button" tabindex="0" class="dropdown-toggle settings" data-toggle="dropdown">
                                <i class="fa fa-cog"></i>
                                <i class="fa fa-spinner fa-spin"></i>
                            </a>

                            <ul class="dropdown-menu pull-right with-arrow animated littleFadeInUp">
                                <li>
                                    <a role="button" tabindex="0" class="tile-toggle">
                                        <span class="minimize"><i class="fa fa-angle-down"></i>&nbsp;&nbsp;&nbsp;Minimize</span>
                                        <span class="expand"><i class="fa fa-angle-up"></i>&nbsp;&nbsp;&nbsp;Expand</span>
                                    </a>
                                </li>
                                <li>
                                    <a role="button" tabindex="0" class="tile-refresh">
                                        <i class="fa fa-refresh"></i> Refresh
                                    </a>
                                </li>
                                <li>
                                    <a role="button" tabindex="0" class="tile-fullscreen">
                                        <i class="fa fa-expand"></i> Fullscreen
                                    </a>
                                </li>
                            </ul>

                        </li>
                        <li class="remove"><a role="button" tabindex="0" class="tile-close"><i class="fa fa-times"></i></a></li>
                    </ul>
                </div>
                <!-- /tile header -->

                <!-- tile widget -->
                <div class="tile-widget">
                    <div id="call-motif" style="height: 250px;"></div>
                </div>
                <!-- /tile widget -->

                <!-- tile body -->
                <div class="tile-body p-0">

                    <div class="panel-group icon-plus" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default panel-transparent">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                        <span><i class="fa fa-minus text-sm mr-5"></i> 5 derniers appels</span>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <table class="table table-no-border m-0">
                                        <tbody>
                                        
                                        @if(isset($_GET['start']) && isset($_GET['end']))
                                            
                                            @foreach(lastFiveCallMe($_GET['start'], $_GET['end']) as $key => $call)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $call->call_name }}</td>
                                                <td>{{ $call->call_phone }}</td>
                                                <td>
                                                @if($call->advisor_conclusion==1)
                                                <i class="label label-danger">Renouvellement</i>
                                                @elseif($call->advisor_conclusion==2)
                                                <i class="label label-warning">Nouveau devis</i>
                                                @else
                                                <i class="label label-info">Information</i>
                                                @endif
                                                </td>
                                                <td>({{ \Carbon\Carbon::parse($call->created_at)->diffForHumans() }})</td>
                                            </tr>
                                            @endforeach
                                        @else
                                            @foreach(lastFiveCallMe() as $key => $call)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $call->call_name }}</td>
                                                <td>{{ $call->call_phone }}</td>
                                                <td>
                                                @if($call->advisor_conclusion==1)
                                                <i class="label label-danger">Renouvellement</i>
                                                @elseif($call->advisor_conclusion==2)
                                                <i class="label label-warning">Nouveau devis</i>
                                                @else
                                                <i class="label label-info">Information</i>
                                                @endif
                                                </td>
                                                <td>({{ \Carbon\Carbon::parse($call->created_at)->diffForHumans() }})</td>
                                            </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /tile body -->

            </section>
        </div>
        <div class="col-md-4">
            <section class="tile" fullscreen="isFullscreen02">

                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Contrats </strong>d'assurance</h1>
                    <ul class="controls">
                        <li class="dropdown">

                            <a role="button" tabindex="0" class="dropdown-toggle settings" data-toggle="dropdown">
                                <i class="fa fa-cog"></i>
                                <i class="fa fa-spinner fa-spin"></i>
                            </a>

                            <ul class="dropdown-menu pull-right with-arrow animated littleFadeInUp">
                                <li>
                                    <a role="button" tabindex="0" class="tile-toggle">
                                        <span class="minimize"><i class="fa fa-angle-down"></i>&nbsp;&nbsp;&nbsp;Minimize</span>
                                        <span class="expand"><i class="fa fa-angle-up"></i>&nbsp;&nbsp;&nbsp;Expand</span>
                                    </a>
                                </li>
                                <li>
                                    <a role="button" tabindex="0" class="tile-refresh">
                                        <i class="fa fa-refresh"></i> Refresh
                                    </a>
                                </li>
                                <li>
                                    <a role="button" tabindex="0" class="tile-fullscreen">
                                        <i class="fa fa-expand"></i> Fullscreen
                                    </a>
                                </li>
                            </ul>

                        </li>
                        <li class="remove"><a role="button" tabindex="0" class="tile-close"><i class="fa fa-times"></i></a></li>
                    </ul>
                </div>
                <!-- /tile header -->

                <!-- tile widget -->
                <div class="tile-widget">
                    <div id="contract-product" style="height: 250px"></div>
                </div>
                <!-- /tile widget -->

                <!-- tile body -->
                <div class="tile-body p-0">

                    <div class="panel-group icon-plus" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default panel-transparent">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <span><i class="fa fa-minus text-sm mr-5"></i> 5 derniers contrats</span>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <table class="table table-no-border m-0">
                                        <tbody>
                                        @if(isset($_GET['start']) && isset($_GET['end']))
                                            @foreach(getAllOrders($_GET['start'], $_GET['end'])->limit(5)->get() as $key => $contrat)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $contrat->policy_number }}</td>
                                                
                                                <td>{{get_product_type($contrat->product_type)}}</td>
                                                <td>{{ dateAgo($contrat->created_at) }}</td>
                                            </tr>
                                            @endforeach
                                        @else
                                            @foreach(getAllOrders()->limit(5)->get() as $key => $contrat)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $contrat->policy_number}}</td>
                                                
                                                <td>{{get_product_type($contrat->product_type)}}</td>
                                                <td>{{ dateAgo($contrat->created_at) }}</td>
                                            </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /tile body -->

            </section>
        </div>
    </div>

    <div class="row">
        <!-- col -->
        <div class="col-md-8">
            <section class="tile">

                <!-- tile header -->
                <div class="tile-header bg-greensea dvd dvd-btm">
                    <h1 class="custom-font"><strong>Statistiques </strong>des livraisons</h1>
                    
                </div>
                <!-- /tile header -->

               
                <!-- /tile widget -->

                <!-- tile body -->
                <div class="tile-body">

                    <!-- row -->
                    <div class="row">


                        <!-- col -->
                        <div class="col-md-6 col-sm-12">

                            <h4 class="underline custom-font mb-20"><strong>Statistiques</strong> Livreurs</h4>

                            <!-- row -->
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-no-border m-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nom du livreur</th>
                                                <th>Livraison</th>
                                                <th>Ratio</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($_GET['start']) && isset($_GET['end']))
                                            <?php $sum=0; ?>
                                            @foreach(deliveryManStats($_GET['start'], $_GET['end']) as $key => $c)
                                                <?php $sum+=$c->nb; ?>
                                            @endforeach
                                            @foreach(deliveryManStats($_GET['start'], $_GET['end']) as $key => $c)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $c->firstname }} {{ $c->lastname }}</td>
                                                <td>{{ $c->nb }}</td>

                                                <td>
                                                    <div class="progress-xxs not-rounded mb-0 inline-block progress" style="width: 50px; margin-right: 5px">
                                                        <div class="progress-bar progress-bar-greensea" role="progressbar" aria-valuenow="{{ $c->nb*100/$sum }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $c->nb*100/$sum }}%;"></div>
                                                    </div>
                                                    <small>{{ round($c->nb*100/$sum,2) }}%</small>
                                                </td> 

                                            </tr>
                                            @endforeach
                                        @else
                                                <?php $sum=0; ?>
                                                @foreach(deliveryManStats() as $key => $c)
                                                    <?php $sum+=$c->nb; ?>
                                                @endforeach
                                            @foreach(deliveryManStats() as $key => $c)
                                                
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $c->firstname }} {{ $c->lastname }}</td>
                                                <td>{{ $c->nb }}</td>

                                                <td>
                                                    <div class="progress-xxs not-rounded mb-0 inline-block progress" style="width: 50px; margin-right: 5px">
                                                        <div class="progress-bar progress-bar-greensea" role="progressbar" aria-valuenow="{{ $c->nb*100/$sum }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $c->nb*100/$sum }}%;"></div>
                                                    </div>
                                                    <small>{{ round($c->nb*100/$sum,2) }}%</small>
                                                </td>  
                                            </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /row -->

                        </div>
                        <!-- /col -->



                        <!-- col -->
                        <div class="col-md-6 col-sm-12">

                            <h4 class="underline custom-font"><strong>Zones </strong> livraisons</h4>
                            
                            <!-- row -->
                            <div class="row">
                                <div id="pie-chart" style="height: 250px"></div>
                            </div>                       
                            <!-- /row -->

                            

                        </div>
                        <!-- /col -->




                    </div>
                    <!-- /row -->

                </div>
                <!-- /tile body -->

            </section>
        </div>
    </div>

   
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.pie.min.js"></script>

    <script>

        $(document).ready(function() {
            // Initialisation du graphique circulaire
            var data6 = [
                <?php if(isset($_GET['start']) && isset($_GET['end'])) { ?>
                    <?php foreach (deliveryZone($_GET['start'], $_GET['end']) as $zone) { ?>
                    { label: <?= json_encode($zone->commune) ?>, data: <?= $zone->nb ?> },
                    <?php } ?>
                <?php } else { ?>
                    <?php foreach (deliveryZone() as $zone) { ?>
                    { label: <?= json_encode($zone->commune) ?>, data: <?= $zone->nb ?> },
                    <?php } ?>
                <?php } ?>
            ];

            // Options du graphique
            var options6 = {
                series: {
                    pie: {
                        show: true,
                        innerRadius: 0,
                        stroke: {
                            width: 0
                        },
                        label: {
                            show: true,
                            threshold: 0.05 // Afficher les labels seulement si >5%
                        }
                    }
                },
                grid: {
                    hoverable: true, // Activer le hover pour les tooltips
                    clickable: true,
                    borderWidth: 0,
                    color: '#ccc'
                },
                tooltip: true,
                tooltipOpts: {
                    content: function(label, xval, yval, flotItem) {
                        return label + ": " + yval + " (" + Math.round(flotItem.series.percent) + "%)";
                    },
                    defaultTheme: false
                }
            };

            // Générer le graphique
            var plot6 = $.plot($("#pie-chart"), data6, options6);

            // Redimensionner le graphique automatiquement
            $(window).resize(function() {
                plot6.resize();
                plot6.setupGrid();
                plot6.draw();
            });

                //Initialize morris chart
    //Initialize morris chart
    Morris.Donut({
        element: 'call-motif',
        data: [

            {label: 'Renouvellement', value: <?= (isset($_GET['start']) && isset($_GET['end']))?getAllCallMeByCallReason($_GET['start'], $_GET['end'], 1)->count(): getAllCallMeByCallReason(null,null,1)->count() ?>, color: '#d9544f'},
            {label: 'Nouveau Dévis', value: <?= (isset($_GET['start']) && isset($_GET['end']))?getAllCallMeByCallReason($_GET['start'], $_GET['end'], 2)->count(): getAllCallMeByCallReason(null,null,2)->count() ?>, color: '#ffc100'},
            {label: 'Information', value: <?= (isset($_GET['start']) && isset($_GET['end']))?getAllCallMeByCallReason($_GET['start'], $_GET['end'], 3)->count(): getAllCallMeByCallReason(null,null,3)->count() ?>, color: '#00a3d8'}
        ],
        resize: true
    });

    //             Morris.Donut({
    //     element: 'call-motif',
    //     data: [

    //         {label: 'Renouvellement', value: <?= (isset($_GET['start']) && isset($_GET['end']))?getAllCallMeByCallReason($_GET['start'], $_GET['end'], 1)->count(): getAllCallMeByCallReason(null,null,1)->count() ?>, color: '#d9544f'},
    //         {label: 'Nouveau Dévis', value: <?= (isset($_GET['start']) && isset($_GET['end']))?getAllCallMeByCallReason($_GET['start'], $_GET['end'], 2)->count(): getAllCallMeByCallReason(null,null,2)->count() ?>, color: '#ffc100'},
    //         {label: 'Information', value: <?= (isset($_GET['start']) && isset($_GET['end']))?getAllCallMeByCallReason($_GET['start'], $_GET['end'], 3)->count(): getAllCallMeByCallReason(null,null,3)->count() ?>, color: '#00a3d8'}
    //     ],
    //     resize: true
    // });

            Morris.Donut({
                element: 'contract-product',
                data: [
                    {label: 'Automobile', value: <?= (isset($_GET['start']) && isset($_GET['end']))?getAllProductContratContract($_GET['start'], $_GET['end'],1)->count():getAllProductContratContract(null,null,1)->count() ?>, color: '#a40778'},
                    /*{label: 'Habitation', value: <?= (isset($_GET['start']) && isset($_GET['end']))?getAllProductContratContract($_GET['start'], $_GET['end'],2)->count():getAllProductContratContract(null,null,2)->count() ?>, color: '#ffc100'},*/
                    {label: 'Voyage', value: <?= (isset($_GET['start']) && isset($_GET['end']))?getAllProductContratContract($_GET['start'], $_GET['end'],3)->count():getAllProductContratContract(null,null,3)->count() ?>, color: '#00a3d8'},
                    /*{label: 'RC', value: <?= (isset($_GET['start']) && isset($_GET['end']))?getAllProductContratContract($_GET['start'], $_GET['end'],4)->count():getAllProductContratContract(null,null,4)->count() ?>, color: '#5cb85c'}*/
                ],
                resize: true
            });

                // Initialize Statistics chart
                var data = [
                        {
                            data: [
                            <?php foreach (getAdvisorUsers() as $key => $advisor) { ?>
                            [<?= ++$key ?>, <?= $advisor['nbre'] ?>], <?php if(++$key <= sizeof(getAdvisorUsers())) echo ','; ?>
                            <?php } ?>
                            ],
                            label: 'Nombre d\'appels',
                            bars: {
                                show: true,
                                barWidth: 0.6,
                                lineWidth: 0,
                                fillColor: { colors: [{ opacity: 0.3 }, { opacity: 0.8}] }
                            }
                        }];

                        var options = {
                            colors: ['#61c8b8'],
                            series: {
                                shadowSize: 0
                            },
                            legend: {
                                backgroundOpacity: 0,
                                margin: -7,
                                position: 'ne',
                                noColumns: 2
                            },
                            xaxis: {
                                tickLength: 0,
                                font: {
                                    color: '#fff'
                                },
                                position: 'bottom',
                                ticks: [
                                    <?php foreach (getAdvisorUsers() as $key => $advisor) { ?>
                                    [<?= ++$key ?>, "<?= $advisor['firstname'] ?>"], <?php if(++$key <= sizeof(getAdvisorUsers())) echo ','; ?>
                                    <?php } ?>
                                ]
                            },
                            yaxis: {
                                tickLength: 0,
                                font: {
                                    color: '#fff'
                                }
                            },
                            grid: {
                                borderWidth: {
                                    top: 0,
                                    right: 0,
                                    bottom: 1,
                                    left: 1
                                },
                                borderColor: 'rgba(255,255,255,.3)',
                                margin:0,
                                minBorderMargin:0,
                                labelMargin:20,
                                hoverable: true,
                                clickable: true,
                                mouseActiveRadius:6
                            },
                            tooltip: true,
                            tooltipOpts: {
                                content: '%s: %y',
                                defaultTheme: false,
                                shifts: {
                                    x: 0,
                                    y: 20
                                }
                            }
                        };

                        var plot = $.plot($("#statistics-chart"), data, options);

                        $(window).resize(function() {
                            // redraw the graph in the correctly sized div
                            plot.resize();
                            plot.setupGrid();
                            plot.draw();
                        });
        });
    </script>

@endsection