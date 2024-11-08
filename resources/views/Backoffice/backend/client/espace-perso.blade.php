@extends('Backoffice.layouts.app')

@section("content")
<div class="page page-tables-datatables">

    <div class="pageheader">
       
        <h2>Espaces Perso<span></h2>

        <div class="page-bar">

            <ul class="page-breadcrumb">
                <li>
            <a href="{{route('spaceDashboard')}}"><i class="fa fa-home"></i> AROLI ASSURANCE</a>
                </li>
                <li>
                    <a href="#">Espaces perso</a>
                </li>
            </ul>

        </div>

    </div>

    <!-- row -->
    <div class="row">
        <!-- col -->
        <div class="col-md-12">
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

         

            <!-- tile -->
            <section class="tile">

                <!-- tile header -->
                <div class="tile-header dvd dvd-btm">
                    <h1 class="custom-font"><strong>Tous les espaces persos</strong></h1>
                </div>
                <!-- /tile header -->

                <!-- tile body -->
                <div class="tile-body">
                    <a href="#" style="margin-bottom:15px" data-toggle="modal" data-target="#newModal" class="btn btn-success" data-options="splash-2 splash-ef-15"> <i class="fa fa-plus"></i> Nouveau</a>

                    <table class="table table-custom" id="advanced-usage">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
							<th>Contact/Login</th>
                            <th>Date enregistrement</th>
							<th>Action</th>
                        </tr>
                        </thead>
						 <tbody>
                         @foreach($users_space as $k=>$user)
                            <tr>
                                <td>{{ ++$k }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td>{{ date('d/m/Y h:i:s', strtotime($user->created_at)) }}</td>
                                <td>
                                    <a href="#" id="{{ $user->id }}" data-login="{{ $user->phone_number }}" class="btn btn-info btn_reset"> <i class="fa fa-key"></i> </a>  
                                    <a href="#" id="{{ $user->id }}" onClick="deletePersoSpace('{{ $user->phone_number }}')" class="btn btn-danger"> <i class="fa fa-times"></i></a>  
                                </td>
                            </tr>
						  @endforeach
						 </tbody>
                    </table>
                </div>

            </section>
            <!-- /tile -->

        </div>
        <!-- /col -->
    </div>
    <!-- /row -->

</div>
@endsection
                
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Reinitialiser mot de passe</h3>
            </div>
            <form method="post" action="{{ route('espace-perso.resetPassword') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" name="id_space" id="id_space" value="" readonly>
                    <div class="form-group">
                        <label for="message">Login: </label>
                        <input type="text" name="login" id="login" value="" readonly class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-ef btn-ef-3 btn-ef-3c">
                        <i class="fa fa-arrow-right"></i> Réinitialiser
                    </button>
                    <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal">
                        <i class="fa fa-arrow-left"></i> Abandonner
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title custom-font">Créer nouveau espace perso</h3>
            </div>
            <form method="post" action="{{ route('createEspacePerso') }}" >
                {{csrf_field()}}
                <div class="modal-body">
                   <div class="form-group">
                        <label for="message">Nom: </label>
                        <input type="text" name="account_name" id="account_name" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="message">Numéro de téléphone: </label>
                        <input type="text" required name="num_phone" id="num_phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="message">Mot de passe par defaut: </label>
                        <input type="text" required name="default_password" placeholder="Mot de passe par defaut" id="default_password" value="1234" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-ef btn-ef-3 btn-ef-3c"><i class="fa fa-arrow-right"></i> Enregistrer</button>
                    <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Quitter</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<script>
    $(document).ready(function() {
        $("#num_phone").inputmask("99 99 99 99 99", { "placeholder": "** ** ** **", "alias": "phone" });
        var table4 = $('#advanced-usage').DataTable();
    
        $('.btn_reset').click(function() {
            var id = $(this).attr('id');
            var login = $(this).attr('data-login');
            $('#id_space').val(id);
            $('#login').val(login);
            $('#myModal').modal('show');
        });
    });
    
    function deletePersoSpace(phone_number) {
        var url = "/admin/espace-perso/delete/" + phone_number;
        swal({
            title: "Suppression d'espace personnel!",
            text: "Voulez-vous vraiment supprimer cet espace?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#e05d6f",
            confirmButtonText: "Oui",
            cancelButtonText: "Non",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                type: "get",
                url: url,
                success: function(data) {
                    swal("Supprimé!", "", "success");
                }
            })
            .done(function(data) {
                if (data == 'success') {
                    swal("Succès!", "L'espace a bien été supprimé!", "success");
                    $("#advanced-usage").load(window.location.href + " #advanced-usage");
                } else {
                    swal("Échec!", "La suppression a échoué!", "warning");
                }
            })
            .fail(function(data) {
                swal("Oops", "Erreur interne! Contacter le webmaster.\r\n" + data, "error");
            });
        });
    }

    $(document).ready(function() {
    // Sélectionne tous les boutons avec la classe .btn_reset
    $('.btn_reset').on('click', function(event) {
        event.preventDefault(); // Empêche le lien de changer de page

        // Récupère les attributs data et id
        var userId = $(this).attr('id');
        var userLogin = $(this).data('login');

        // Remplit les champs dans la modale
        $('#id_space').val(userId);
        $('#login').val(userLogin);

        // Affiche la modale
        $('#myModal').modal('show');
    });
});



    </script>
    

