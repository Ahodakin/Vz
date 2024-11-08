<!-- =================================================
================= RIGHTBAR Content ===================
================================================== -->
<style type="text/css">
    .form-horizontal .form-group{
        margin-right: 10px;
        margin-left: 10px;
    }
</style>
<aside id="rightbar">
    <div role="tabpanel">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#users" aria-controls="users" role="tab" data-toggle="tab"><i class="fa fa-users"></i></a></li>
            @role("advisor")
            <li role="presentation" class=""><a href="#call-center" aria-controls="call-center" role="tab" data-toggle="tab"><i class="fa fa-phone"></i></a></li>
            @endrole
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="users">
                <h6><strong>Utilisateurs</strong> en ligne</h6>
            
                <ul>
                @foreach ((new \App\Http\Controllers\Backoffice\AdminController)->getOnlineUsers() as $user) 
                    <li class="online">
                        <div class="media">
                            <a class="pull-left thumb thumb-sm" role="button" tabindex="0">
                                <img class="media-object img-circle" src="/back/assets/uploads/avatar/{{$user->avatar}}" alt>
                            </a>
                            <div class="media-body">
                                <span class="media-heading">{{$user->firstname}} <strong>{{$user->lastname}}</strong></span>
                                <small><i class="fa fa-clock-o"></i> En ligne</small>
                                <span class="badge badge-outline status"></span>
                            </div>
                        </div>
                    </li>
                @endforeach
                </ul>
            </div>
            @role("advisor")   
            <div role="tabpanel" class="tab-pane" id="call-center">

                <h6><strong>Call</strong> center</h6>
                <form class="form-horizontal" method="post" action="">
                    
                </form>
            </div>
            @endrole
        </div>
    </div>

</aside>
<!--/ RIGHTBAR Content -->