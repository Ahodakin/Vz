@extends('Backoffice.layouts.app')
@section("content")
<div class="page page-ui-portlets">
    <div class="pageheader">
        <h2>Listes des utilisateurs <span></span></h2>
        <div class="page-bar">

            <ul class="page-breadcrumb">
                <li>
                    <a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> AROLI ASSURANCE</a>
                </li>
                <li>
                <a href="#.">Utilisateurs</a>
                </li>
            </ul>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button data-toggle="modal" data-target="#splashNew" data-options="splash-2 splash-ef-15" class="btn btn-success mb-10" ><i class="glyphicon glyphicon-check"></i> Nouveau</button>
        </div>
    </div>
    <!-- page content -->
    <div class="pagecontent">
        @if(\Illuminate\Support\Facades\Session::has('success'))
            <div class="text-center container w-420">
                <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><p align="center">{{\Illuminate\Support\Facades\Session::get('success')}}</p></h4>
                </div>
            </div>
        @endif

        @if(\Illuminate\Support\Facades\Session::has('error'))
            <div class="text-center container w-420">
                <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><p align="center">{{\Illuminate\Support\Facades\Session::get('error')}}</p></h4>
                </div>
            </div>
        @endif
    
        <!-- row -->
        <div class="row">

            <!-- col -->
            <div class="col-sm-12 portlets sortable">
            
                <!-- tile -->
                <section class="tile tile-simple">

                    <!-- tile body -->
                    <div class="tile-body p-0">

                        <div role="tabpanel">

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tabs-dark" role="tablist">
                                <li role="presentation" class="active"><a href="#admin" aria-controls="settingsTab" role="tab" data-toggle="tab">Administration</a></li>
                                <li role="presentation"><a href="#client" aria-controls="settingsTab" role="tab" data-toggle="tab">Client</a></li>
                                <li role="presentation"><a href="#prospect" aria-controls="settingsTab" role="tab" data-toggle="tab">Prospect</a></li>   
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                 <div role="tabpanel" class="tab-pane active" id="admin">

                                    <div class="wrap-reset">

                                     <div class="table-responsive">
                                            <table class="table table-custom" id="basic3">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Photo</th>
                                                    <th>Nom & Prénom(s)</th>
                                                    <th>Sexe</th>
                                                    <th>Email</th>
                                                    <th>Contact</th>
                                                    <th>Rôle</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($admin_aroli as $key=>$a)
                                                    <tr @if($a->status==0) class='bg-lightred'; @endif>
                                                        <td>{{++$key}}</td>
                                                        <td><img width="32x32" src="/back/assets/uploads/avatar/{{$a->avatar}}"</td>
                                                        <td>{{$a->firstname}} {{$a->lastname}}</td>
                                                        <td>{{$a->gender}}</td>
                                                        <td>{{$a->email}}</td>
                                                        <td>{{$a->contact}}</td>
                                                        <td width="20%"> 
                                                            @if(!empty($a->roles))
                                                                @foreach($a->roles as $v)
                                                                    <label class="label label-success">{{ $v->display_name }}</label>
                                                                @endforeach
                                                            @else
                                                                <span>Aucun rôle assigné</span>
                                                            @endif
                                                        </td>
                                                        
                                                        <td>

                                                        <button onclick="getUser({{$a->id}})" class="btn btn-primary" data-toggle="modal" data-target="#splash" data-options="splash-2 splash-ef-15"><i class="glyphicon glyphicon-edit"></i> </button>
                                                        <button onclick="deleteUser ('{{route('deleteUser', $a->id)}}')" class="btn btn-danger" ><i class="glyphicon glyphicon-trash"></i> </button>
                                                        <a href="{{route('userDetails', $a->id)}}" class="btn btn-default" ><i class="glyphicon glyphicon-plus"></i> </a>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>     

                                    </div>

                                </div>

                                <div role="tabpanel" class="tab-pane" id="client">

                                    <div class="wrap-reset">
                                        <div class="table-responsive">
                                            <table class="table table-custom" id="basic1">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Photo</th>
                                                    <th>Nom & Prénom(s)</th>
                                                    <th>Sexe</th>
                                                    <th>Email</th>
                                                    <th>Contact</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($clients as $key=>$c)
                                                    <tr  @if($c->status==0)
                                                        class='bg-lightred';
                                                        @endif>
                                                        <td>{{++$key}}</td>
                                                        <td><img width="32x32" src="/back/assets/uploads/avatar/{{$c->avatar}}"</td>
                                                        <td>{{$c->firstname}} {{$c->lastname}}</td>
                                                        <td>{{$c->gender}}</td>
                                                        <td>{{$c->email}}</td>
                                                        <td>{{$c->contact}}</td>
                                                        <td>

                                                         <button onclick="getUser({{$c->id}})" class="btn btn-primary" data-toggle="modal" data-target="#splash" data-options="splash-2 splash-ef-15"><i class="glyphicon glyphicon-edit"></i> </button>
                                                        <button onclick="deleteUser" class="btn btn-danger" ><i class="glyphicon glyphicon-trash"></i> </button>
                                                        <a href="" class="btn btn-default" ><i class="glyphicon glyphicon-plus"></i> </a>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>                                
                                    </div>

                                </div>
                                <div role="tabpanel" class="tab-pane" id="prospect">

                                    <div class="wrap-reset">
                                        <div class="table-responsive">
                                            <table class="table table-custom" id="basic2">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Photo</th>
                                                    <th>Nom & Prénom(s)</th>
                                                    <th>Sexe</th>
                                                    <th>Email</th>
                                                    <th>Contact</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($prospects as $key=>$p)
                                                    <tr @if($p->status==0)
                                                        class='bg-lightred';
                                                        @endif>
                                                        <td>{{++$key}}</td>
                                                        <td><img width="32x32" src="/back/assets/uploads/avatar/{{$p->avatar}}"</td>
                                                        <td>{{$p->firstname}} {{$p->lastname}}</td>
                                                        <td>{{$p->gender}}</td>
                                                        <td>{{$p->email}}</td>
                                                        <td>{{$p->contact}}</td>
                                                        <td>

                                                         <button onclick="" class="btn btn-primary" data-toggle="modal" data-target="#splash" data-options="splash-2 splash-ef-15"><i class="glyphicon glyphicon-edit"></i> </button>
                                                        <button onclick="deleteUser" class="btn btn-danger" ><i class="glyphicon glyphicon-trash"></i> </button>
                                                        <a href="" class="btn btn-default" ><i class="glyphicon glyphicon-plus"></i> </a>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
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
    </div>
</div>

@endsection


    <div class="modal splash fade" id="splash" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title custom-font">Modifier Utilisateurs</h3>
                </div>
                <form class="form-horizontal" method="post" action="{{route('user.edit')}}">
                <div class="modal-body">
                    {{csrf_field()}}
                    <input type="hidden" name="iduser" id="iduser" readonly>
                    <div class="form-group">
                        <label for="lastname" class="col-sm-2 control-label">Nom</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="User lastname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="firstname" class="col-sm-2 control-label">Prénom(s)</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="User firstname">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lastname" class="col-sm-2 control-label">Sexe</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="gender" id="gender">
                                <option value=""></option>
                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">Date de naissance</label>
                            <div class="input-group datepicker col-sm-8">
                                <input type="text" name="dob" id="dob" class="form-control">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </span>
                            </div>
                            @if ($errors->has('dob'))
                            <span class="help-block">
                                <strong>{{ $errors->first('dob') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="lastname" class="col-sm-2 control-label">Contact</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="contact" name="contact" placeholder="User phone">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="firstname" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" required class="form-control" id="email" name="email" placeholder="User email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="status" id="status">
                                <option value=""></option>
                                <option value="1">Actif</option>
                                <option value="0">Innactif</option>
                            </select>
                        </div>
                    </div>
                
                        
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-ef btn-ef-3 btn-ef-3c mb-10">Enregistrer
                    <i class="fa fa-arrow-right"></i></button>
                    <button type="reset" class="btn btn-danger btn-ef btn-ef-3 btn-ef-3c mb-10" data-dismiss="modal">Annuler</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal splash fade" id="splashNew" tabindex="-1" role="dialog" aria-labelledby="splashNew" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title custom-font">Nouveau Utilisateurs</h3>
                </div>
                <form class="form-horizontal" method="post" action="{{route('user.create')}}">
                <div class="modal-body">
                    {{csrf_field()}}
                    <input type="hidden" name="iduser" id="iduser" readonly>
                    <div class="form-group">
                        <label for="lastname" class="col-sm-2 control-label">Nom</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="lastname" placeholder="User lastname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="firstname" class="col-sm-2 control-label">Prénom(s)</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control"  name="firstname" placeholder="User firstname">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lastname" class="col-sm-2 control-label">Sexe</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="gender">
                                <option value=""></option>
                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                        <label class="col-sm-2 control-label">Date de naissance</label>
                            <div class="input-group datepicker col-sm-8">
                                <input type="text" name="dob" class="form-control">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </span>
                            </div>
                            @if ($errors->has('dob'))
                            <span class="help-block">
                                <strong>{{ $errors->first('dob') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="lastname" class="col-sm-2 control-label">Contact</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="contact" placeholder="User phone">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="firstname" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" required class="form-control" name="email" placeholder="User email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Mot de passe</label>
                        <div class="col-sm-10">
                            <input type="password" required class="form-control" name="password" placeholder="User password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="status" >
                                <option value=""></option>
                                <option value="1">Actif</option>
                                <option value="0">Innactif</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lastname" class="col-sm-2 control-label">Type de compte</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="usertype" >
                                <option value="99">Aroli</option>
                                <option value="0">Prospect</option>
                                <option value="1">Client</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                @foreach($roles as $r)
                            <div class="col-md-6">
                            <div class="checkbox">
                                <input type="checkbox"  id="{{$r->id}}" value="{{$r->id}}" name="roles[]">
                                <label for="{{$r->id}}">  {{$r->display_name}} </label>
                            </div>
                            </div>
                            @endforeach
                            </div>
                        </div>
                
                        
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-ef btn-ef-3 btn-ef-3c mb-10">Enregistrer
                    <i class="fa fa-arrow-right"></i></button>
                    <button type="reset" class="btn btn-danger btn-ef btn-ef-3 btn-ef-3c mb-10" data-dismiss="modal">Annuler</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function getUser (id_user) {
            $.get("/admin/getuser/"+id_user, function(d) {
                if(d!='0'){
                    $('#iduser').val(d.id);
                    $('#firstname').val(d.firstname);
                    $('#lastname').val(d.lastname);
                    $('#gender option[value='+d.gender+']').attr("selected", "selected");
                    $('#dob').val(formatdate(d.dob));
                    $('#contact').val(d.contact);
                    $('#email').val(d.email);
                    $('#status option[value='+d.status+']').attr("selected", "selected");

                }else
                {
                    $('#iduser').val("");
                    $('#firstname').val("");
                    $('#lastname').val("");
                    $('#gender option[value=""]').attr("selected", "selected");
                    $('#dob').val("");
                    $('#contact').val("");
                    $('#email').val("");
                    $('#status option[value=""]').attr("selected", "selected");
                }
            })
        }

        function formatdate(date){
            split = date.split('-');
            date = split[2]+'/'+split[1]+'/'+split[0];
            return date
        }

        function deleteUser (url) {
            swal({
                title:"Suppession d'utilisateur!",
                text: "Voulez vous vraiment supprimer cet utilisateur?",
                type: "warning",
                showCancelButton: true,
                //confirmButtonColor: "#",
                confirmButtonText: "Oui",
                cancelButtonText: "Non",
                closeOnConfirm: false
            }, function () {
                swal("Supprimé!", "", "success");
                $.ajax(
                {
                    type: "get",
                    url: url,
                    success: function(data){
                    }
                }
                )
                .done(function(data) {
                    swal("Succes!", "L'utilisateur a bien été supprimé!", "success");
                    setTimeout(function(){
                        window.location.reload()
                    }, 1000);
                })
                .error(function(data) {
                    swal("Oops", "Erreur interne!", "error");
                })
            });
        }
        $(window).load(function(){
        

        var table1 = $('#basic1').DataTable({
                "dom": 'Rlfrtip'
            });

        var table2 = $('#basic2').DataTable({
                "dom": 'Rlfrtip'
            });
        var table3 = $('#basic3').DataTable({
                "dom": 'Rlfrtip'
            });

            $('#basic-usage tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('row_selected') ) {
                    $(this).removeClass('row_selected');
                }
                else {
                    table.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                }
            });

        });
    </script>
{{-- @endsection --}}