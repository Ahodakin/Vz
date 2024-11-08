@extends('Backoffice.layouts.app')
@section("content")
<div class="page page-profile">
	<div class="pageheader">
        <h2>Statistiques des Dévis - Commandes - VAS générés <span></span></h2>
		<div class="page-bar">

			<ul class="page-breadcrumb">
				<li>
					<a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> MONASSURANCE.CI</a>
				</li>
				<li>
				<a href="#.">Statistiques</a>
				</li>
				<li>
				<a href="">Dévis - Commandes - VAS</a>
				</li>
			</ul>
			<div class="page-toolbar">
                <a role="button" tabindex="0" class="btn btn-lightred no-border pickDate">
                    <i class="fa fa-calendar"></i>&nbsp;&nbsp;<span></span>&nbsp;&nbsp;<i class="fa fa-angle-down"></i>
                </a>
            </div>
            <form method="get" id="custom_search" action="">
            <input type="hidden" value="<?= (isset($_GET['start']))?$_GET['start']:'' ?>" name="start" id="start">
            <input type="hidden" value="<?= (isset($_GET['start']))?$_GET['end']:'' ?>" name="end" id="end">
        </form>

		</div>
	</div>
	<!-- page content -->
	<div class="pagecontent">
		@if(\Illuminate\Support\Facades\Session::has('success'))
			<div class="text-center container w-420">
	            <div class="alert alert-success alert-dismissable">
	                	<h4><p align="center">{{\Illuminate\Support\Facades\Session::get('success')}}</p></h4>
	            </div>
	        </div>
	    @endif

	    @if(\Illuminate\Support\Facades\Session::has('error'))
			<div class="text-center container w-420">
	            <div class="alert alert-danger alert-dismissable">
	                <h4><p align="center">{{\Illuminate\Support\Facades\Session::get('error')}}</p></h4>
	            </div>
	        </div>
	    @endif
		<!-- row -->
				<div class="row">

					<!-- col -->
					<div class="col-md-3">

						<!-- tile -->
						<section class="tile tile-simple">

							<!-- tile body -->
							<div class="tile-body p-0">

								<div role="tabpanel">

									<!-- Nav tabs -->
									<ul class="nav nav-tabs tabs-dark" role="tablist">
										<li role="presentation" class="active"><a href="#stats" aria-controls="settingsTab" role="tab" data-toggle="tab">Stats</a></li>
									</ul>

									<!-- Tab panes -->
									<div class="tab-content">

										<div role="tabpanel" class="tab-pane active" id="stats">

											<div class="wrap-reset">
											<div class="row">
												<div class="card-container col-sm-12">
						                            <div class="card">
						                                <div class="front bg-greensea">

						                                    <!-- row -->
						                                    <div class="row">
						                                        <!-- col -->
						                                        <div class="col-xs-4">
						                                            <i class="fa fa-file-pdf-o fa-4x"></i>
						                                        </div>
						                                        <!-- /col -->
						                                        <!-- col -->
						                                        <div class="col-xs-8">
						                                            <p class="text-elg text-strong mb-0">
						                                            	@if(isset($_GET['start']) && isset($_GET['end']))
						                                            	{{getAllQuotation($_GET['start'], $_GET['end'])->count()}}
						                                            	@else
						                                            	{{getAllQuotation()->count()}}

						                                            	@endif
						                                            </p>
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
						                                            <a href="#Devis" aria-controls="settingsTab"><i class="fa fa-chain-broken fa-2x"></i> Détails</a>
						                                        </div>
						                                        <!-- /col -->
						                                    </div>
						                                    <!-- /row -->

						                                </div>
						                            </div>
						                        </div>
											</div>

											<div class="row">
												<div class="card-container col-sm-12">
						                            <div class="card">
						                                <div class="front bg-lightred">

						                                    <!-- row -->
						                                    <div class="row">
						                                        <!-- col -->
						                                        <div class="col-xs-4">
						                                            <i class="fa fa-usd fa-4x"></i>
						                                        </div>
						                                        <!-- /col -->
						                                        <!-- col -->
						                                        <div class="col-xs-8">
						                                            <p class="text-elg text-strong mb-0">
						                                            	@if(isset($_GET['start']) && isset($_GET['end']))
						                                            	{{getAllOrders($_GET['start'], $_GET['end'])->count()}}
						                                            	@else
						                                            	{{getAllOrders()->count()}}
						                                            	@endif
						                                            </p>
						                                            <span>Commandes</span>
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
						                                            <a href="#"><i class="fa fa-chain-broken fa-2x"></i> Détails</a>
						                                        </div>
						                                        <!-- /col -->
						                                    </div>
						                                    <!-- /row -->

						                                </div>
						                            </div>
						                        </div>
											</div>

											<div class="row">
												<div class="card-container col-sm-12">
						                            <div class="card">
						                                <div class="front bg-blue">

						                                    <!-- row -->
						                                    <div class="row">
						                                        <!-- col -->
						                                        <div class="col-xs-4">
						                                            <i class="fa fa-barcode fa-4x"></i>
						                                        </div>
						                                        <!-- /col -->
						                                        <!-- col -->
						                                        <div class="col-xs-8">
						                                            <p class="text-elg text-strong mb-0">
						                                            	@if(isset($_GET['start']) && isset($_GET['end']))
						                                            	{{sizeof(optionalProductSale($_GET['start'], $_GET['end']))}}
						                                            	@else
						                                            	{{sizeof(optionalProductSale())}}
						                                            	@endif
						                                            </p>
						                                            <span>VAS</span>
						                                        </div>
						                                        <!-- /col -->
						                                    </div>
						                                    <!-- /row -->

						                                </div>
						                                <div class="back bg-blue">

						                                    <!-- row -->
						                                    <div class="row">
						                                        
						                                        <!-- col -->
						                                        <div class="col-xs-12">
						                                            <a href="#"><i class="fa fa-chain-broken fa-2x"></i> Détails</a>
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
									</div>

								</div>

							</div>
							<!-- /tile body -->

						</section>
						<!-- /tile -->


						


					</div>
					<!-- /col -->

					<!-- col -->
					<div class="col-md-9">

						<!-- tile -->
						<section class="tile tile-simple">

							<!-- tile body -->
							<div class="tile-body p-0">

								<div role="tabpanel">

									<!-- Nav tabs -->
									<ul class="nav nav-tabs tabs-dark" role="tablist">
										<li role="presentation" class="active"><a href="#Devis" aria-controls="settingsTab" role="tab" data-toggle="tab">Devis</a></li>
										<li role="presentation"><a href="#commande" aria-controls="settingsTab" role="tab" data-toggle="tab">Commandes</a></li>
										<li role="presentation"><a href="#VAS" aria-controls="settingsTab" role="tab" data-toggle="tab">VAS</a></li>
									</ul>

									<!-- Tab panes -->
									<div class="tab-content">

										<div role="tabpanel" class="tab-pane active" id="Devis">

											<div class="wrap-reset">

												<div class="row">
												    <div class="col-md-6">
												        <table class="table table-no-border m-0">
												            <thead>
												                <tr>
												                    <th>#</th>
												                    <th>Nom du conseillé</th>
												                    <th>Dévis généré</th>
												                </tr>
												            </thead>
												            <tbody>
												            	<?php $sum=0; ?>
												            	@if(isset($_GET['start']) && isset($_GET['end']))
						                                           @foreach(getQuoteByAdvisorActor($_GET['start'], $_GET['end']) as $key => $a)
													            	<tr>
													            		<td>{{++$key}}</td>
													            		<td>{{$a->firstname . " ". $a->lastname}}</td>
													            		<td>{{$a->nb_dev}}</td>
													            		<?php $sum+=$a->nb_dev; ?>
													            	</tr>
													            	@endforeach 
						                                        @else					                                     
													            	@foreach(getQuoteByAdvisorActor() as $key => $a)
													            	<tr>
													            		<td>{{++$key}}</td>
													            		<td>{{$a->firstname . " ". $a->lastname}}</td>
													            		<td>{{$a->nb_dev}}</td>
													            		<?php $sum+=$a->nb_dev; ?>
													            	</tr>
													            	@endforeach
						                                        @endif
						                                        @if(isset($key))
												            	<tr style="background-color:#ccc">
												            		<td>{{++$key}}</td>
												            		<td>Prospects</td>
												            		<td>
												            		@if(isset($_GET['start']) && isset($_GET['end']))
												            		{{getAllQuotation($_GET['start'], $_GET['end'])->count()-$sum}}
												            		@else
												            		{{getAllQuotation()->count()-$sum}}

												            		@endif
												            		</td>
												            	</tr>
												            	@endif
												            </tbody>
												        </table>
												    </div>
												    <div class="col-md-6">
												        <table class="table table-no-border m-0">
												            <thead>
												                <tr>
												                    <th>#</th>
												                    <th>Formule</th>
												                    <th>Dévis généré</th>
												                </tr>
												            </thead>
												            <tbody>
												            @if(isset($_GET['start']) && isset($_GET['end']))
													            @foreach(getQuoteByAutoInsurType($_GET['start'], $_GET['end'])->get() as $key => $q)
													            	<tr>
													            		<td>{{++$key}}</td>
													            		<td>{{$q->guarante}}</td>
													            		<td>{{$q->quote_nb}}</td>
													            	</tr>
													            @endforeach
												            @else
												            	@foreach(getQuoteByAutoInsurType()->get() as $key => $q)
												            		<tr>
													            		<td>{{++$key}}</td>
													            		<td>{{$q->guarante}}</td>
													            		<td>{{$q->quote_nb}}</td>
													            	</tr>
													            @endforeach
												            @endif
												            </tbody>
												        </table>
												    </div>
												</div>

											</div>

										</div>
										<div role="tabpanel" class="tab-pane" id="commande">

											<div class="wrap-reset">

												<div class="row">
												    <div class="col-md-6">
												        <table class="table table-no-border m-0">
												            <thead>
												                <tr>
												                    <th>#</th>
												                    <th>Nom du conseillé</th>
												                    <th>Commande générée</th>
												                </tr>
												            </thead>
												            <tbody>
												            	<?php $sum=0; ?>
												            	

												            	@if(isset($_GET['start']) && isset($_GET['end']))
												            		@foreach(getOrderByAdvisorActor($_GET['start'],$_GET['end']) as $key => $a)
												            	<tr>
												            		<td>{{++$key}}</td>
												            		<td>{{$a->firstname . " ". $a->lastname}}</td>
												            		<td>{{$a->nb_dev}}</td>
												            		<?php $sum+=$a->nb_dev; ?>
												            	</tr>
												            	@endforeach
												            	@else
												            		@foreach(getOrderByAdvisorActor() as $key => $a)
												            		<tr>
												            			<td>{{++$key}}</td>
												            			<td>{{$a->firstname . " ". $a->lastname}}</td>
												            			<td>{{$a->nb_dev}}</td>
												            			<?php $sum+=$a->nb_dev; ?>
												            		</tr>
												            		@endforeach
												            	@endif
												            	@if(isset($key))
												            	<tr style="background-color:#ccc">
												            		<td>{{++$key}}</td>
												            		<td>Client</td>
												            		<td>
												            		@if(isset($_GET['start']) && isset($_GET['end']))
												            		{{getAllOrders($_GET['start'], $_GET['end'])->count()-$sum}}
												            		@else
												            		{{getAllOrders()->count()-$sum}}

												            		@endif
												            		</td>
												            	</tr>
												            	@endif
												            </tbody>
												        </table>
												    </div>
												    <div class="col-md-6">
												        <table class="table table-no-border m-0">
												            <thead>
												                <tr>
												                    <th>#</th>
												                    <th>Formule</th>
												                    <th>commandes</th>
												                </tr>
												            </thead>
												            <tbody>
												            @if(isset($_GET['start']) && isset($_GET['end']))
													            @foreach(getSaleByAutoInsurType($_GET['start'], $_GET['end'])->get() as $key => $q)
													            	<tr>
													            		<td>{{++$key}}</td>
													            		<td>{{$q->guarante}}</td>
													            		<td>{{$q->sales_nb}}</td>
													            	</tr>
													            @endforeach
												            @else
												            	@foreach(getSaleByAutoInsurType()->get() as $key => $q)
												            		<tr>
													            		<td>{{++$key}}</td>
													            		<td>{{$q->guarante}}</td>
													            		<td>{{$q->sales_nb}}</td>
													            	</tr>
													            @endforeach
												            @endif
												            </tbody>
												        </table>
												    </div>
												</div>

											</div>

										</div>
										<div role="tabpanel" class="tab-pane" id="VAS">

											<div class="wrap-reset">
												<div class="row">
												    <div class="col-md-6">
												        <table class="table table-no-border m-0">
												            <thead>
												                <tr>
												                    <th>#</th>
												                    <th>Nom du conseillé</th>
												                    <th>Service VAS vendu</th>
												                </tr>
												            </thead>
												            <tbody>
												            	<?php $sum=0; ?>
												            	

												            	@if(isset($_GET['start']) && isset($_GET['end']))
												            		@foreach(getVASByAdvisorActor($_GET['start'],$_GET['end']) as $key => $a)
												            	<tr>
												            		<td>{{++$key}}</td>
												            		<td>{{$a->firstname . " ". $a->lastname}}</td>
												            		<td>{{$a->nb_dev}}</td>
												            		<?php $sum+=$a->nb_dev; ?>
												            	</tr>
												            	@endforeach
												            	@else
												            		@foreach(getVASByAdvisorActor() as $key => $a)
												            		<tr>
												            			<td>{{++$key}}</td>
												            			<td>{{$a->firstname . " ". $a->lastname}}</td>
												            			<td>{{$a->nb_dev}}</td>
												            			<?php $sum+=$a->nb_dev; ?>
												            		</tr>
												            		@endforeach
												            	@endif
												            	@if(isset($key))
												            	<tr style="background-color:#ccc">
												            		<td>{{++$key}}</td>
												            		<td>Client</td>
												            		<td>
												            		@if(isset($_GET['start']) && isset($_GET['end']))
												            		{{sizeof(optionalProductSale($_GET['start'], $_GET['end']))-$sum}}
												            		@else
												            		{{sizeof(optionalProductSale())-$sum}}

												            		@endif
												            		</td>
												            	</tr>
												            	@endif
												            </tbody>
												        </table>
												    </div>
												</div>
												

											</div>

										</div>
									</div>

								</div>

							</div>
							<!-- /tile body -->

						</section>
						<!-- /tile -->

					</div>
					<!-- /col -->











				</div>
				<!-- /row -->
		<!-- /row -->



	</div>
	<!-- /page content -->

</div>

@endsection

