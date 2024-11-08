<section id="header">
    <header class="clearfix">
        <div class="branding">
            <a class="brand" href="{{route('spaceDashboard')}}">
                <span style="color:#e05d6f">MON</span><span>ASSURANCE<span style="color:#e05d6f">.CI</span></span>
            </a>
            <a role="button" tabindex="0" class="offcanvas-toggle visible-xs-inline"><i class="fa fa-bars"></i></a>
        </div>
        
        <!-- Left-side navigation -->
        <ul class="nav-left pull-left list-unstyled list-inline">
            <li class="sidebar-collapse divided-right">
                <a role="button" tabindex="0" class="collapse-sidebar">
                    <i class="fa fa-outdent"></i>
                </a>
            </li>
            @include('Backoffice.layouts.color')
        </ul>
        @role("advisor")
        <!-- Left-side navigation end -->
        <div class="search" id="main-search">
            <input type="text" class="form-control underline-input" placeholder="Rechercher dévis...">
        </div>
        <!-- Right-side navigation -->
        @endrole 
        <ul class="nav-right pull-right list-inline">
            @role("advisor")
            <li class="dropdown messages">
                <a href class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-file-o"></i>
                    <span class="badge bg-lightred">{{sizeof(newProposition())}}</span>
                </a>
                <div class="dropdown-menu pull-right with-arrow panel panel-default animated littleFadeInDown" role="menu">
                    <div class="panel-heading">
                        <strong>{{sizeof(newProposition())}}</strong> nouvelle(s) simulation de dévis
                    </div>
                    <ul class="list-group">
                        @foreach(newProposition() as $d)

                        <li class="list-group-item" style="margin-left:10px">
                            @if($d->product_type==1)
                            <a role="button" href="{{route('devis.details',['id'=>$d->qid,'aid'=>$d->aid])}}" tabindex="0" class="media"> 
                            @elseif($d->product_type==3) 
                            <a role="button" href="{{route('devis.voyage.details',['id'=>$d->qid,'aid'=>$d->aid])}}" tabindex="0" class="media"> 
                            @else
                            <a role="button" href="#" tabindex="0" class="media"> 
                            @endif
                                                               
                                <div class="media-body">
                                    <span class="block">
                                    @if($d->product_type==1)
                                    [AUTO]
                                    @elseif($d->product_type==3) 
                                    [VOYAGE]
                                    @endif
                                    {{$d->number_n}}
                                    </span>
                                    <small class="text-muted">{{dateAgo($d->date_created)}}</small>
                                </div>
                            </a>
                        </li>
                     @endforeach
                    </ul>
                    <div class="panel-footer">
                        <a role="button" tabindex="0">Voir toutes les propositions <i class="pull-right fa fa-angle-right"></i></a>
                    </div>
                </div>
            </li>
            <li class="dropdown users">
    
                <a href class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-barcode"></i>
                    <span class="badge bg-lightred">{{sizeof(newDevis())}}</span>
                </a>
                <div class="dropdown-menu pull-right with-arrow panel panel-default animated littleFadeInUp" role="menu">
                    <div class="panel-heading">
                        Vous avez <strong>{{sizeof(newDevis())}}</strong> nouveau dévis
                    </div>
                    <ul class="list-group"> 
                       
                        <ul class="list-group">
                                
                            @foreach(newDevis() as $d)

                                <li class="list-group-item" style="margin-left:10px">
                                    
                                    @if($d->product_type==1)
                                    <a role="button" href="" tabindex="0" class="media"> 
                                    @elseif($d->product_type==3) 
                                    <a role="button" href="{{route('devis.voyage.details',['id'=>$d->id,'aid'=>$d->aid])}}" tabindex="0" class="media"> 
                                    @else
                                    <a role="button" href="#" tabindex="0" class="media"> 
                                    @endif                                 
                                        <div class="media-body">
                                            <span class="block">
                                            @if($d->product_type==1)
                                            [AUTO]
                                            @elseif($d->product_type==3) 
                                            [VOYAGE]
                                            @endif
                                            {{$d->number_n}}
                                            </span>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($d->created_at)->diffForHumans() }}</small>

                                        </div>
                                    </a>
                                </li>
                          @endforeach
                            </ul>
                    <div class="panel-footer">
                        <a role="button" tabindex="0">Voir toutes les demandes de dévis<i class="fa fa-angle-right pull-right"></i></a>
                    </div>
                </div>
            </li>
    
            <li class="dropdown notifications">
    
                <a href class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell"></i>
                    <span class="badge bg-lightred">{{sizeof(newCallAlert())}}</span>
                </a>
                <div class="dropdown-menu pull-right with-arrow panel panel-default animated littleFadeInLeft">
                    <div class="panel-heading">
                        Vous avez <strong>{{sizeof(newCallAlert())}}</strong> nouvelles demandes d'appels
                    </div>
    
                    <ul class="list-group">
                        @foreach(newCallAlert() as $d)
                            <li class="list-group-item" style="margin-left:10px">
                                <a role="button" href="{{ route('single.notiication.call',$d->call_id) }}" tabindex="0" class="media">                                    
                                    <div class="media-body">
                                        <span class="block">
                                        {{$d->call_name}} veut se faire appeler au {{$d->call_phone}}
                                        </span>
                                        <small class="text-muted">{{dateAgo($d->created_at)}}</small>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
    
                    <div class="panel-footer">
                        <a role="button" href="{{ route('notiication.call') }}" tabindex="0">Voir toutes les demandes <i class="fa fa-angle-right pull-right"></i></a>
                    </div>
                </div>
    
            </li>
            @endrole
            <li class="dropdown nav-profile">
    
                <a href class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ asset('/back/assets/uploads/avatar/' . auth()->user()->avatar) }}" alt="" class="img-circle size-30x30">
                    <span><i class="fa fa-angle-down"></i></span>
                </a>
    
                <ul class="dropdown-menu animated littleFadeInRight" role="menu">
    
                    <li>
                        <a role="button" href="{{route('profilepage')}}" tabindex="0">
                            <i class="fa fa-user"></i>Mon profile
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a role="button" href="{{route('showspaceLocked')}}" tabindex="0">
                            <i class="fa fa-lock"></i>Vérouiller
                        </a>
                    </li>
                    
                    <li>
                        <a role="button" href="{{ route('logout') }}" tabindex="0">
                            <i class="fa fa-sign-out"></i>Me déconnecter
                        </a>     
                    </li>
    
                </ul>
    
            </li>
    
            <li class="toggle-right-sidebar">
                <a role="button" tabindex="0">
                    <i class="fa fa-comments"></i>
                </a>
            </li>
        </ul>

    </header>
    
</section>