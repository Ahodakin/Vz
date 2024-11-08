@extends('Backoffice.layouts.app')
@section("content")
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<div class="page page-profile">
		<style type="text/css">
			.image-preview-input {
				position: relative;
				overflow: hidden;
				margin: 0px;    
				color: #333;
				background-color: #fff;
				border-color: #ccc;    
			}
			.image-preview-input input[type=file] {
				position: absolute;
				top: 0;
				right: 0;
				margin: 0;
				padding: 0;
				font-size: 20px;
				cursor: pointer;
				opacity: 0;
				filter: alpha(opacity=0);
			}
			.image-preview-input-title {
				margin-left:2px;
			}
		</style>
		<div class="pageheader">
			<h2>Mon compte <span></span></h2>
			<div class="page-bar">

				<ul class="page-breadcrumb">
					<li>
						<a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> MONASSURANCE.CI</a>
					</li>
					<li>
					<a href="#">Mon compte</a>
					</li>
					<li>
					<a href="{{route('profilepage')}}">Mon profil</a>
					</li>
				</ul>

			</div>
		</div>
		<!-- page content -->
		<div class="pagecontent">
			@if ($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
			@if(\Illuminate\Support\Facades\Session::has('error'))
				<br/>
				<div class="alert alert-danger alert-dismissable">
					<p align="center">{{ \Illuminate\Support\Facades\Session::get('error') }}</p>
				</div>
			@endif
			@if(\Illuminate\Support\Facades\Session::has('success'))
				<br/>
				<div class="alert alert-success alert-dismissable">
					<p align="center">{{ \Illuminate\Support\Facades\Session::get('success') }}</p>
				</div>
			@endif
			<!-- row -->
			<div class="row">
				<!-- col -->
				<div class="col-md-4">
					<!-- tile -->
					<section class="tile tile-simple">

						<div class="tile-widget p-30 text-center">
							
							<div class="thumb thumb-xl" style="width: 130px; height: 150px; overflow: hidden; border-radius: 50%;">
								<img class="img-circle" src="{{ asset('/back/assets/uploads/avatar/' . $currentUser->avatar) }}" alt="">
							</div>
							<h4 class="mb-0"><strong>{{ $currentUser->firstname }}</strong>{{ $currentUser->lastname }}</h4>
							<span class="text-muted">Administrateur</span>
							
							{{-- <div class="mt-10">
								<button class="btn btn-rounded-20 btn-sm btn-greensea">Follow</button>
								<button class="btn btn-rounded-20 btn-sm btn-lightred">Message</button>
							</div>		 --}}
						</div>

						<div class="tile-body text-center bg-blue p-0">

							<ul class="list-inline tbox m-0">
								<li class="tcol p-10">
									<h2 class="m-0">56</h2>
									<span class="text-transparent-white">Dévis</span>
								</li>
								<li class="tcol bg-blue dker p-10">
									<h2 class="m-0">14</h2>
									<span class="text-transparent-white">Polices</span>
								</li>
								<li class="tcol p-10">
									<h2 class="m-0">2</h2>
									<span class="text-transparent-white">Sinistres</span>
								</li>
							</ul>
						</div>
					</section>
				</div>
				<!-- /col -->

				<!-- col -->
				<div class="col-md-8">

					<!-- tile -->
					<section class="tile tile-simple">

						<!-- tile body -->
						<div class="tile-body p-0">

							<div role="tabpanel">

								<!-- Nav tabs -->
								<ul class="nav nav-tabs tabs-dark" role="tablist">
									<li role="presentation" class="active"><a href="#PersoTab" aria-controls="settingsTab" role="tab" data-toggle="tab">Information personnel</a></li>
									<li role="presentation"><a href="#PasswordTab" aria-controls="settingsTab" role="tab" data-toggle="tab">Mot de passe</a></li>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">

									<div role="tabpanel" class="tab-pane active" id="PersoTab">

										<div class="wrap-reset">

											<form class="profile-settings" enctype="multipart/form-data" action="{{route('editProfile')}}" method="post">
												<input type="hidden" class="form-control" value="{{csrf_token()}}" name="_token" id="_token">
												<div class="row">
													<div class="form-group col-md-12 legend">
														<h4><strong>Paramètres</strong> de profil</h4>
														<p>Configuration de mes information de profil</p>
													</div>
												</div>
												<div class="row">    
													<div class="col-xs-12 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">  
														<!-- image-preview-filename input [CUT FROM HERE]-->
														<div class="input-group image-preview">
															<input type="text" value="{{ $currentUser->avatar }}" class="form-control image-preview-filename" disabled="disabled"> <!-- don't give a name === doesn't send on POST/GET -->
															<span class="input-group-btn">
																<!-- image-preview-clear button -->
																<button type="button" class="btn btn-default image-preview-clear" style="display:none;">
																	<span class="glyphicon glyphicon-remove"></span> Clear
																</button>
																<!-- image-preview-input -->
																<div class="btn btn-default image-preview-input">
																	<span class="glyphicon glyphicon-folder-open"></span>
																	<span class="image-preview-input-title">Browse</span>
																	<input type="file" accept="image/png, image/jpeg, image/gif" name="avatar"/> <!-- rename it -->
																</div>
															</span>
														</div><!-- /input-group image-preview [TO HERE]--> 
													</div>
												</div>

												<div class="row">

													<div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }} col-sm-6">
														<label for="first-name">Nom</label>
														<input type="text" class="form-control" id="lastname"  name="lastname" value="{{ $currentUser->lastname }}">
														@if ($errors->has('lastname'))
															<span class="help-block">
																<strong>{{--{{ $errors->first('lastname') }}--}}</strong>
															</span>
														@endif
													</div>

													<div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }} col-sm-6">
														<label for="last-name">Prénoms</label>
														<input type="text" class="form-control" id="firstname" name="firstname" value="{{ $currentUser->firstname }}">
														@if ($errors->has('firstname'))
															<span class="help-block">
																<strong></strong>
															</span>
														@endif
													</div>

												</div>
												<div class="row">

													<div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }} col-sm-6">
														<label for="gender">Sexe</label><br/>
														<label class="checkbox-inline checkbox-custom">
															<input name="gender" value="M" type="radio"  {{ $currentUser->gender == 'M' ? 'checked' : '' }}><i></i> Masculin
														</label>
														<label class="checkbox-inline checkbox-custom">
															<input name="gender" value="F"  type="radio" {{ $currentUser->gender == 'F' ? 'checked' : '' }}><i></i> Féminin
														</label>
														@if ($errors->has('gender'))
															<span class="help-block">
																<strong></strong>
															</span>
														@endif
													</div>
													<div class="form-group col-sm-6">
														<label>Date de naissance</label>
														<div class="input-group datepicker w-330 mt-8">
															<input type="text" name="dob" value="{{ old('dob', date('d/m/Y', strtotime($currentUser->dob))) }}" class="form-control" placeholder="Date de naissance" required>
															<span class="input-group-addon">
																<span class="fa fa-calendar"></span>
															</span>
														</div>
														
															@if ($errors->has('dob'))
																<span class="help-block">
																	<strong></strong>
																</span>
															@endif
													</div>

												</div>
												

												<div class="row">

													<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} col-sm-6">
														<label for="email">E-mail</label>
														<input type="email" class="form-control" id="email" name="email" value="{{ $currentUser->email }}" readonly>
														@if ($errors->has('email'))
															<span class="help-block">
																<strong></strong>
															</span>
														@endif
													</div>

													<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }} col-sm-6">
														<label for="phone">Contact</label>
														<input type="text" class="form-control" id="phone" name="phone" value="{{ $currentUser->contact }}">
														@if ($errors->has('phone'))
															<span class="help-block">
																<strong></strong>
															</span>
														@endif
													</div>

												</div>

												<div class="row">
													<div class="form-group">
														<div class="col-sm-offset-2 col-sm-10">
															<button type="submit" class="btn btn-rounded btn-primary btn-sm">Modifier</button>
															<button type="reset" class="btn btn-rounded btn-danger btn-sm">Annuler</button>
														</div>
													</div>
												</div>

											</form>

										</div>

									</div>
									<div role="tabpanel" class="tab-pane" id="PasswordTab">


										<div class="wrap-reset">
											<form class="profile-settings" method="post" action="{{ route('editPassword') }}">
												@csrf <!-- Utilisation de la directive csrf pour le token -->
												<div class="row">
													<div class="form-group col-md-12 legend">
														<h4><strong>Paramètres</strong> de sécurité</h4>
														<p>Protéger votre compte</p>
													</div>
												</div>
										
												<div class="row">
													<div class="form-group col-sm-6">
														<label for="email">E-mail</label>
														<input type="email" class="form-control" id="email" name="email" value="{{ $currentUser->email }}" required readonly>
													</div>
										
													<div class="form-group col-sm-6{{ $errors->has('currentpassword') ? ' has-error' : '' }}">
														<label for="currentpassword">Mot de passe actuel</label>
														<input type="password" class="form-control" id="currentpassword" name="currentpassword" required>
														@if ($errors->has('currentpassword'))
															<span class="help-block">
																<strong>{{ $errors->first('currentpassword') }}</strong>
															</span>
														@endif
													</div>
												</div>
												<div class="row">
													<div class="form-group col-sm-6">
														<label for="newpassword">Nouveau mot de passe</label>
														<input type="password" class="form-control" id="newpassword" required name="newpassword">
													</div>
												
													<div class="form-group col-sm-6">
														<label for="newpassword_confirmation">Retaper nouveau mot de passe</label>
														<input type="password" class="form-control" id="newpassword_confirmation" required name="newpassword_confirmation">
														@if ($errors->has('newpassword_confirmation'))
															<span class="help-block">
																<strong>{{ $errors->first('newpassword_confirmation') }}</strong>
															</span>
														@endif
													</div>
												</div>
												
										
												<div class="row">
													<div class="form-group">
														<div class="col-sm-offset-2 col-sm-10">
															<button type="submit" class="btn btn-rounded btn-primary btn-sm">Modifier</button>
															<button type="reset" class="btn btn-rounded btn-danger btn-sm">Annuler</button>
														</div>
													</div>
												</div>
											</form>
										</div>
									</div>
									
									
								</div>

							</div>

						</div>
					</section>
				</div>
			</div>
		</div>

	</div>
	
@endsection




