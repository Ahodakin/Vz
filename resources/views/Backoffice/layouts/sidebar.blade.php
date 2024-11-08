<aside id="sidebar">
    <div id="sidebar-wrap">
        <div class="panel-group slim-scroll" role="tablist">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#sidebarNav">
                            Mon menu  <i class="fa fa-angle-up"></i>
                        </a>
                   </h4>
                </div>
                <div id="sidebarNav" class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body">
                        <ul id="navigation">
                            <li class=""><a  href="{{route('spaceDashboard')}}"><i class="fa fa-dashboard"></i> <span>Mon Tableau de Bord</span></a></li>
                            <li class=""><a  href="{{route('profilepage')}}"><i class="fa fa-user"></i> <span>Mon compte</span></a></li>

                            @role('settingsmanager')
                            <li class=""><a role="button" tabindex="0" href=""><i class="fa fa-cogs"></i> <span>Configuration</span></a>
                                <ul>
                                    <li><a href="{{route('guaranteePage')}}"><i class="fa fa-caret-right"></i> Garantie</a></li>
                                    <li><a href="{{route('categoryPage')}}"><i class="fa fa-caret-right"></i> Catégorie</a></li>
                                    <li><a href=""  role="button"><i class="fa fa-caret-right"></i> Tarif Reglementaire</a>
                                        <ul>
                                            <li><a href="{{route('configOtherReglementary')}}">Autres tarifs</a></li>
                                            {{--<li><a href="{{route('configRC')}}">Responsabilité civile</a></li>
                                            <li><a href="{{route('configDR')}}">Défence et recours</a></li>
                                            <li><a href="{{route('configRA')}}">Recours anticipé</a></li>--}}
                                        </ul>
                                    </li>           
                                    <li><a href="{{route('companyPage')}}"><i class="fa fa-caret-right"></i>Compagnie d'Assurance </a></li>
                                    <li><a href="{{route('configRate')}}"><i class="fa fa-caret-right"></i>Taux de reduction </a></li>
                                    <li><a href="{{route('configRevive')}}"><i class="fa fa-caret-right"></i>Relance </a></li>
                                    <li><a href="{{route('exportData')}}"><i class="fa fa-caret-right"></i>Export Data </a></li>
                                    @role('operation')
                                        <li><a href="{{route('deleteTrace')}}"><i class="fa fa-caret-right"></i>Supprimer trace </a></li>
                                    @endrole
                                </ul>
                            </li>
                            @endrole  
                            @role('usermanager') 
                            <li class=""><a tabindex="0" href="{{route('users.afficher')}}"><i class="fa fa-user"></i> <span>Gestion des utilisateurs</span></a></li>
                            @endrole
                            @role('advisor')
                            <li class="">
                                <a role="button" tabindex="0"><i class="fa fa-users"></i> <span>Gérer mes prospects</span> <span class="label label-danger pull-right">{{sizeof(newDevis())}}</span></a>
                                <ul>
                                    <li><a href="{{route('devis.creer')}}"><i class="fa fa-caret-right"></i> Créer un devis</a></li>
                                    <li><a href="{{route('devis.list')}}"><i class="fa fa-caret-right"></i> Mes dévis <span class="label label-danger pull-right">{{sizeof(newDevis())}}</span></a></li>
                                    <li><a href="{{route('devis.list.all')}}"><i class="fa fa-caret-right"></i> Toutes les propositions</a></li>
                                    <li><a href="{{route('prospect.send-sms')}}"><i class="fa fa-caret-right"></i> Envoyer sms</a></li>      
                                </ul>
                            </li>
                            <li class="">
                                <a role="button" tabindex="0"><i class="fa fa-users"></i> <span>Gérer mes clients</span> </a>
                                <ul>

                                    <li><a href="{{route('client.afficher')}}"><i class="fa fa-caret-right"></i> Gérer</a></li> 
                                    <li class=""><a  href="{{route('contrats')}}"><i class="fa fa-files-o"></i> <span>Mes contrats</span></a></li>
                                    <li class=""><a  href="{{route('espacePerso')}}"><i class="fa fa-user"></i> <span>Espaces Perso</span></a></li>
                                    
                                </ul>
                            </li>
                            <li class="">
                                <a href="{{ route('notiication.call')}}" tabindex="0"><i class="fa fa-phone"></i> <span>Call center</span></a>
                            </li>
                            @endrole

                            @role('operation')
                            <li class="">
                                <a href="javascript:;" tabindex="0"><i class="fa  fa-shopping-cart"></i> <span>Mes commandes</span> <span class="label label-danger pull-right"><span class="label label-danger pull-right">{{sizeof(newOrder()->get())}}</span>                                </span></a>
                                <ul>

                                    <li><a href="{{ route('orders.waitingdelivery.list') }}"><i class="fa fa-caret-right"></i> Mise en livraison <span class="label label-info pull-right">{{sizeof(waitingDelivery()->get())}}</span></a></li>                                                   
                                    <li><a href="{{ route('orders.list') }}"><i class="fa fa-caret-right"></i> Liste des commande</a></li>                                                   
                                </ul>
                            </li> 
                            @endrole

                            @role('claimsmanager')
                            <li class="">
                                <a href="javascript:;" tabindex="0"><i class="fa  fa-bolt"></i> <span>Mes sinistres</span> <span class="label label-danger pull-right">{{sizeof(activeSinistre())}}</span></a>
                                <ul>

                                    <li><a href="{{ route('sinistre.list') }}"><i class="fa fa-caret-right"></i> Gérer mes sinistres <span class="label label-danger pull-right">{{sizeof(activeSinistre())}}</span></a></li>                                                   
                                    <li><a href="{{ route('sinistre.new') }}"><i class="fa fa-caret-right"></i> Déclarer un sinistre </a></li>                                                   
                                </ul>
                            </li>
                            @endrole
                            @role('deliveryman')
                            <li class="">
                                <a href="{{route('delivery.list')}}" tabindex="0"><i class="fa fa-truck"></i> <span>Gérer mes livraisons</span> <span class="label label-danger pull-right">{{sizeof(getUserDeliveryTours())}}</span></a>
                            </li>
                            @endrole
                            @role('financial')
                            <li class="">
                                <a role="button" tabindex="0"><i class="fa fa-euro"></i> <span>Encaisser</span> <span class="label label-danger pull-right">{{sizeof(orderToTrait()->get())}}</span></a>
                                <ul>
                                    <li><a href="{{route('commande.a.encaisser')}}"><i class="fa fa-caret-right"></i> Commande à traiter <span class="label label-danger pull-right">{{sizeof(orderToTrait()->get())}}</span></a></li>
                                    <li><a href="{{route('delivery.tocash.list')}}"><i class="fa fa-caret-right"></i> Tournées de livraison <span class="label label-danger pull-right">{{sizeof(orderToTrait()->get())}}</span></a></li>
                                    <li><a href="{{route('commande.traitees')}}"><i class="fa fa-caret-right"></i> Commande Livrée payée </a></li>
                                    
                                </ul>
                            </li>
                            @endrole
                            @role('operation')
                            <li class="">
                                <a href="javascript:;" role="button" tabindex="0"><i class="fa fa-bar-chart-o"></i> <span>Statistiques</span></a>
                                <ul>
                                    <li><a href="{{ route('stats.devis') }}"><i class="fa fa-caret-right"></i> Dévis - Commandes - Contrats </a></li> 

                                    <li><a href="{{-- route('stats.devis') --}}"><i class="fa fa-caret-right"></i> Chiffre d'affaire (Bientôt) </a></li>                      
                                    <li><a href="{{-- route('stats.devis') --}}"><i class="fa fa-caret-right"></i> Vente HT (Bientôt) </a></li>                      
                                </ul>
                            </li>
                            @endrole
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>

                