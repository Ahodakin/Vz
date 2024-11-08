<header class="clearfix">
  <div id="logo">
    <img src="images/assureurs/{{$data->logo}}">
  </div>
  <div id="company">
    <h2 class="name">{{$data->companyname}}</h2>
    <div>{{$data->compphone}}</div>
    <div>Date commande: {{date('d/m/Y H:i:s', strtotime($prospect->created_at))}}</div>
  </div>
</header>