<div class="container">

	<!-- TOP BAR -->
	<div class="top-bar clearfix">
		@if(\Illuminate\Support\Facades\Auth::guard('space_perso')->check())
		<ul style="float:left">
			<li class="dropdown-submenu">
				<a href class="dropdown-toggle" data-toggle="dropdown" style="font-weight:bold;color:#fff">
				<span>&nbsp;Bienvenue, {{\Illuminate\Support\Facades\Auth::guard('space_perso')->user()->name}}&nbsp;<i class="fa fa-caret-right" style="left:-15px; top:0px"></i></span>
				</a>
				<ul class="dropdown-menu" role="menu" style="margin-top:15px">

                    <li>
                        <a role="button" href="{{route('page.myspace')}}" tabindex="0">
                            Mon espace
                        </a>
                    </li>
                    <li>
                        <a role="button" href="{{route('logout')}}" tabindex="0">
                            Deconnexion
                        </a>
                    </li>
					{{-- @role("advisor","settingsmanager")
					<li class="{{($active=='auto')? 'active':''}}"><a href="{{route('spaceDashboard')}}"><i class="fa fa-lock"></i>&nbsp;Admin</a></li>
					@endrole  --}}
                 </ul>
             </li>
        </ul>

		@else
		<p ><a href="{{route('login')}}" style="font-weight:bold; color:white">&nbsp;J'accède à mon espace &nbsp;</a></p>
		@endif

		<ul class="top-utils">
			<li><i class="icon-telephone114"></i> (+225) 220 170 00</li>
			<li><i class="icon-icons74"></i> Abidjan - Cocody Angré 9e Tranche</li>
			<li><i class="icon-icons20"></i> 24H/24 - 7J/7</li>
		</ul>
	</div>
	<!-- / TOP BAR -->

	<!-- HEADER INNER -->
	<div class="header clearfix">

		<a href="/" class="logo"><img src="{{asset('images/logo.png')}}" alt=""></a>

		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#primary-nav" aria-expanded="false">
			<span class="sr-only">Mon menu</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>

		<!--<ul class="header-links" style="margin-top:5px">
			<li style="margin-left:0px"><a href="javascript:void(0);" class=""><i class="icon-telephone114"></i></a></li>
		</ul>-->
		<div class="search-btn">
			<a href="javascript:void(0);" class="search-trigger"><i class="icon-icons185"></i></a>
		</div>



		<div class="search-container">
			<i class="fa fa-times header-search-close"></i>
			<div class="search-overlay"></div>
			<div class="search">
				<div id="devis_police">
					<form method="POST" action="{{route('submit.search')}}" >
						{{csrf_field()}}
						<label>N° Dévis/Police:</label>
						<input type="text" placeholder="ARO/xxxxxxxx/xxxx" name="num_devis" id="search_devis">
						<button><i class="fa fa-search"></i></button>
					</form>
					<hr>
					<div class="text-center"><a href="javascript:;" id="btn_search_sin">Suivre ma déclaration de sinistre</a></div>
				</div>

				<div id="div_s_sin" style="display:none">
					<form method="POST" action="{{route('submit.search.sinistre')}}" >
						{{csrf_field()}}
						<label>N° Sinistre:</label>
						<input type="text" placeholder="SIN/xxxxxxxx/xxxx" name="num_sinistre" id="search_sinistre">
						<button><i class="fa fa-search"></i></button>
					</form>
					<hr>
					<div class="text-center"><a href="javascript:;" id="btn_search_dev">Rechercher votre devis/police</a></div>
				</div>
			</div>
		</div>

		<nav class="main-nav navbar-collapse collapse" id="primary-nav">
			<ul class="nav nav-pills">
				{{-- @auth --}}

				{{-- @endauth --}}


				<li class="{{($active=='auto')? 'active':''}}"><a href="{{route('page.auto')}}"><i class="fa fa-car"></i>&nbsp;Auto</a></li>
				{{--<li class="{{($active=='habitation')? 'active':''}}"><a href="{{route('page.habitation')}}"><i class="fa fa-home"></i>&nbsp;Habitation</a></li>--}}
				<li class="{{($active=='moto')? 'active':''}}"><a href="{{route('page.moto')}}"><i class="fa fa-motorcycle"></i>&nbsp; Moto</a></li>
				<li class="{{($active=='voyage')? 'active':''}}"><a href="{{ route('page.voyage') }}"><i class="fa fa-plane"></i>&nbsp;Voyage</a></li>
				<li class="{{($active=='sinistre')? 'active':''}}"><a href="{{route('page.sinistre')}}"><i class="fa fa-plus-square-o"></i>&nbsp;Sinistre</a></li>
				{{--<li><a href="#."><i class="fa fa-user"></i>&nbsp;Assure Tout</a></li>--}}
                @if(\Illuminate\Support\Facades\Auth::guard('space_perso')->check())
				<li class="{{($active=='myspace')? 'active':''}}"><a href="{{route('page.myspace')}}"><i class="fa fa-group"></i>&nbsp;Mon espace</a>
					<!--<ul class="dropdown-menu">
						<li><a href="#">Bon plan</a></li>
						<li><a href="{{route('logout')}}">Deconnexion</a></li>
					</ul>-->
				</li>
				@endif
				<!--<li><a href="#."><i class="fa fa-phone"></i>&nbsp;Déclarer Sinistre</a></li>-->
			</ul>

		</nav>

	</div><!-- / HEADER INNER -->

</div><!-- / CONTAINER -->
