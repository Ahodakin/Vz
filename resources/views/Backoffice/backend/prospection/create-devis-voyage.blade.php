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
      <!-- tile -->
      <section class="tile tile-simple">

          <!-- tile body -->
          <div class="tile-body p-0">

              <div role="tabpanel">

                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs tabs-dark" role="tablist">
                      <li role="presentation" ><a href="#auto" aria-controls="settingsTab" role="tab" data-toggle="tab">Automobile</a></li>
                      <li><a href="{{route('devis.moto.creer')}}">Moto</a></li>
                      <li class="active"><a href="{{route('devis.voyage.creer')}}">Voyage</a></li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">

                      <div role="tabpanel" class="tab-pane active" id="auto">

                          <div class="wrap-reset">
      
                            <form method="post" action="{{route('devis.auto.post')}}" name="devis" class="quoteForm">
                              <div id="rootwizard" class="tab-container tab-wizard">
                                  @if (session('error'))
                                    <div class="alert alert-danger">
                                       {{ session('error') }}
                                    </div>
                                  @endif
                                
                                  <div class="tab-content">
                                       
                                          {{ csrf_field() }}
                                          <input type="hidden" name="_form_type_" id="_form_type_" value="{{encrypt('AUTO')}}">
                                      <div class="tab-pane" id="tab1">
                                       
                                        
                                      </div>
                                      
                                      <div class="tab-pane" id="tab2">

                                          <div id="step2">                        
                                              

                                            
                                          </div>
                                      </div>
                                      <div class="tab-pane" id="tab3">

                                      </div>
          
                                      
                                      
                                      <ul class="pager wizard">
                                        <div class="text-center">
                                          <a href="{{route('page.myspace.devis-voyage')}}" class="btn btn-primary">Créer un nouveau devis Voyage</a>
                                        </div>
                                          

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

