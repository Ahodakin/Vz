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
                      <li class="active"><a href="#auto" aria-controls="settingsTab" role="tab" data-toggle="tab">Automobile</a></li>
                      <li><a href="{{route('devis.moto.creer')}}">Moto</a></li>
                      <li><a href="{{route('devis.voyage.creer')}}">Voyage</a></li>
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
                                          <a href="{{route('page.myspace.devis-auto')}}" class="btn btn-primary">Créer un nouveau devis Auto</a>
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



@section('header-script')
<link rel="stylesheet" href="{{asset('back/assets/js/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
@stop
     

@section('footer-script')
<script src="<?php echo asset('back/assets/js/vendor/parsley/parsley.min.js'); ?>"></script>
<script src="<?php echo asset('back/assets/js/vendor/form-wizard/jquery.bootstrap.wizard.min.js'); ?>"></script>
<script src="{{asset('back/assets/js/vendor/daterangepicker/moment.js')}}"></script>
<script src="{{asset('back/assets/js/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
@stop

@section('custom-script')
    <script>
      $(document).ready(function(){
        $("#priseeffet").inputmask("99/99/9999",{ "placeholder": "DD/MM/YYYY","alias": "date" });
        $("#dateMiseCirc").inputmask("99/99/9999",{ "placeholder": "DD/MM/YYYY","alias": "date" });
        $("#datePC").inputmask("99/99/9999",{ "placeholder": "DD/MM/YYYY","alias": "date" });

        $("#phone").inputmask("99 99 99 99",{ "placeholder": "** ** ** **","alias": "phone" });
        $("#phone_souscr").inputmask("99 99 99 99",{ "placeholder": "** ** ** **","alias": "phone" });
      });

      $("#guaranteetype").click(function (e){        
                      $("#div-formule").hide();
                      $("#div-garantie").show();
                });

                 $("#formuletype").click(function (e){        
                    $("#div-garantie").hide();
                    $("#div-formule").show();
                });
      $(window).load(function(){
        function getGuarantiesFormule (idcomp, formule) {
          $.get("/rest-api/v1/getguaranties/"+idcomp+"/"+formule, function(data) {
            if(data!=0){
              $("#info2").html("Les garanties de la compagnie selectionnée correspondant à cette formule sont : "+data)
            }
            else{
              $("#info2").html("")

            }
          })
        }

      function switchInfo(){
          if($('input[name=formule]:checked').val()=='tsimple'){
            html = "L'assurance au tiers simple est la formule Auto la plus basique et obligatoire.</br>";
            html += "<p>Elle renferme les garanties suivantes : </p>"
            html += "<p><strong>-La responsabilité civile : </strong>Elle ne couvre que les dommages matériels et corporels causés aux tiers, en cas d’accident dont vous êtes responsable. Elle ne couvre pas ceux que vous-même et votre véhicule subissez.</p>";
            html += "<p><strong>-Défense et recours : </strong>Cette garantie impose à votre assureur au titre de la défense, à pourvoir, à ses frais, à votre défense devant les juridictions compétentes si vous êtes poursuivi à la suite d’un sinistre couvert.<br/> Le recours oblige votre assureur à réclamer à la partie adverse la réparation des préjudices subis à l’occasion d’un accident dont vous êtes victime.</p>";
            html += "<p><strong>-La sécurité routière ou personne transportée : </strong> L’assureur accorde sa garantie pour uniquement à ceux que vous transportez dans votre véhicule à titre gratuit. </p>";
              
              $("#info1").html(html);
              getGuarantiesFormule($("#pref_comp option:selected").val(), 'tsimple');
          } 
      else if($('input[name=formule]:checked').val()=='tcomplet'){
        html = "Avec un niveau de protection correct, cette formule repond à la demande de nombreux automobiliste avec un meilleur rapport qualité prix.<br/>";
        html += "<p>En plus des garanties de la formule tiers simple, s’ajoutent les garanties:</p>";
        html += "<p><strong>-Bris de glaces : </strong>Elle couvre généralement le pare-brise, les vitres latérales et la lunette arrière.</p>";
        html += "<p><strong>-Incendie : </strong>Cette garantie couvre les dommages causés à votre véhicule à la suite d’un incendie. </p>";
        html += "<p><strong>-Vol et vol agression : </strong>Elle couvre les dommages résultant de la disparition ou de la détérioration du véhicule assuré à la suite d’un vol ou tentative de vol de celui-ci.</p>";
        html += "<p><strong>-Vol des accesoires : </strong>Elle couvre les équipements électroniques, pneumatiques et pièces de rechange dont le catalogue du constructeur prévoit la livraison en même que le véhicule. </p>";
        html += "<p><strong>-Recours anticipé : </strong>La garantie recours anticipé permet, si vous êtes victime d'un sinistre, à votre assureur de vous indemniser par anticipation dès que la compagnie adverse aura reconnu sa responsabilité.</p>";
          $("#info1").html(html);
          getGuarantiesFormule($("#pref_comp option:selected").val(), 'tcomplet');
      }
      else if($('input[name=formule]:checked').val()=='tcol'){
          $("#info1").html("");
          getGuarantiesFormule($("#pref_comp option:selected").val(), 'tcol');
      }
      else if($('input[name=formule]:checked').val()=='toutrisque'){
        html = "Circulez tranquille! Cette formule est la formule d'assurance la plus complète.<br/>";
        html += "<p>Cette formule d’assurance automobile est accordée aux véhicules dont l’âge est inférieur ou égal à <strong>3 ans</strong>. Le véhicule assuré bénéficie non seulement des formules tiers simple et tiers complet. </p>"
          html +="<p>Le véhicule assuré bénéficie d'une garantie contre les dommages résultant:</p>"
          html +="<p><strong>-De la collision avec un ou plusieurs véhicules</strong></p>"
          html +="<p><strong>-Du choc entre le véhicule assuré et un corps fixe ou mobile</strong></p>"
          html +="<p><strong>-Du renversement sans collision préalable</strong></p>"
          $("#info1").html(html);
          getGuarantiesFormule($("#pref_comp option:selected").val(), 'toutrisque');
      }
      }

      $("input[name=formule]").click(function (e){
        switchInfo();
      })

      $( "#pref_comp" ).change(function() {
      switchInfo();
      });

      $( "#periode" ).change(function() {
        if($(this).val()==2){
          $('.disable_mens').attr("disabled",true);
          $('#tsimple').prop("checked", true)
        }else{
          $('.disable_mens').removeAttr("disabled");
        }

      if($(this).val()==2 || $(this).val()==3 || $(this).val()==4){
        $('#trisque').attr("disabled",true);
        $('#tsimple').prop("checked", true)
      }
      });

      $('#category').on('change', function() {
          if(this.value=="2" || this.value=="3" || this.value=="8"){
            $('#div_cu').show()
            $("#cu").prop('required', true);
            $("#cu").attr("data-parsley-group","block2");
          }
          else{
            $('#div_cu').hide()
            $("#cu").prop('required', false);
            $("#cu").removeAttr("data-parsley-group"); 
          }
      })

      $("input[name=souscription]").click(function (e){
        if($('input[name=souscription]:checked').val()=='G'){
            $("#info1").html("Vous avez selectionnez le type de souscription avancé. Cochez les garanties souhaitées.");
            $("#info2").html("");
        } 
        else if($('input[name=souscription]:checked').val()=='tsimple'){
            $("#info1").html("L'assurance au tiers est la formule Auto la plus basique.");
            $('#input[name=formule, value=tsimple]').prop('checked', true);
            getGuarantiesFormule($("#pref_comp option:selected").val(), 'tsimple');
        }
      })
      function check_immatriculation(mat){    
        $.get("/rest-api/v1/searchcar/"+mat, function(data) {
          if(data!=0){
            $("#immat-result").html("<img src='/images/available.png' />"); 
            $("#mat_help-block").html("Un véhicule a été trouvé"); 
            $( "#mat_help-block" ).prop( "style", "color:green" );
            var d = JSON.parse(data);
          console.log(d)
            $("#marque").val(d.make_id); 
            $("#genre").val(d.type_id);
            $("#name_cg").val(d.name_cg);
            $("#puissance").val(d.power);
            $("#category").prop("disabled",false);
            $("#category").val(d.category);
            if(d.charge_utile>0){
              $("#div_cu").show();
              $("#cu").val(d.charge_utile);
            }
        date_firstrelease = d.firstrelease.split("-");
        $("#dateMiseCirc").val(date_firstrelease[2]+"/"+ date_firstrelease[1] +"/"+ date_firstrelease[0]);

        $("#nbplace").val(d.placesnumber);
        $("#vneuve").val(d.vneuve);
        $("#vvenale").val(d.vvenale);
        $("#city").val(d.parkingzone);
        $("#ennergie").val(d.energy);
        $("#color").val(d.color);
        $("#genre").val(d.type_id);
      }
      else{
        $( "#mat_help-block" ).prop( "style", "color:red" );
        $("#immat-result").html("<img src='/images/not-available.png' />");
        $("#mat_help-block").html("Aucun véhicule ne correspond à ce numéro d'immatriculation"); 
        $("#marque").val("");
        $("#puissance").val("");
        $("#category").val("");
        $("#nbplace").val("");
        ("#vneuve").val("");
        $("#vvenale").val("");
        $("#city").val("");
        $("#cu").val("");
        $("#color").val("");
        $("#genre").val("");
      }
        });
        $("#searchmat").prop('disabled',false);
      }  
            
      $('.datetimepicker_dateMiseCirc').datetimepicker({
                  format: 'DD/MM/YYYY',
                  viewMode: 'years',
                  maxDate:moment()
                });

      $('.datetimepicker_datePC').datetimepicker({
        format: 'DD/MM/YYYY',
          maxDate:moment(),
          viewMode: 'years'
      });
      $("#searchmat").click(function (e){
        event.preventDefault();     
        $("#immat-result").html('<img src="/images/ajaxloader.gif" />');
        $("#searchmat").prop('disabled',true);
        x_timer = setTimeout(function(){
            var immat = $('#immat').val();
            check_immatriculation(immat);
        }, 1000);
        
      });

      $('#rootwizard').bootstrapWizard({
          'tabClass': 'bwizard-steps',
          onTabShow: function(tab, navigation, index) {
              var $total = navigation.find('li').length;
              var $current = index+1;

              // If it's the last tab then hide the last button and show the finish instead
              if($current >= $total) {
                  $('#rootwizard').find('.pager .next').hide();
                  $('#rootwizard').find('.pager .finish').show();
                  $('#rootwizard').find('.pager .finish').removeClass('disabled');
              } else {
                  $('#rootwizard').find('.pager .next').show();
                  $('#rootwizard').find('.pager .finish').hide();
              }

          },
      onNext: function(tab, navigation, index) {
          var valid = $(".quoteForm").parsley().validate('block' + index);
              if(index==1 && ($('#souscripteur_name').val()=='' || $('#phone_souscr').val()=='') && $('#souscripteur_name').is(':required')) return false
                
              return valid; 
          

      },

      onTabClick: function(tab, navigation, index) {

        var i = index+1;
          var valid = $(".quoteForm").parsley().validate('block' + i);
             if(index==1 && ($('#souscripteur_name').val()=='' || $('#phone_souscr').val()=='') && $('#souscripteur_name').is(':required')) return false
                
              return valid;

      }
      });

        $("#genre").change(function () {
          $("#category").val('')
          $("#category").children('option').hide();
          if($(this).val()==1){
            $("#category").attr('disabled',false)
            $("#category").children("option[value=" + 1 + "]").show()
            $("#category").children("option[value=" + 8 + "]").show()
            $("#category").children("option[value=" + 12 + "]").show()
          }
          else if($(this).val()==2){
            $("#category").attr('disabled',false)
            $("#category").children("option[value=" + 1 + "]").show()
            $("#category").children("option[value=" + 8 + "]").show()
            $("#category").children("option[value=" + 12 + "]").show()
          }
          else if($(this).val()==''){
            $("#category").attr('disabled',true)
          }
      else {
        $("#category").attr('disabled',false)
        $("#category").children("option[value=" + 2 + "]").show()
        $("#category").children("option[value=" + 3 + "]").show()
        $("#category").children("option[value=" + 8 + "]").show()
      }
      
      })  

      function switchProprioVeh(){
          if($('input[name=proprio_veh]:checked').val()=='E'){
            $('.particulier_field').hide()
              $('.entreprise_field').show()
              $("#lastname").removeAttr("required");     
            $("#lastname").removeAttr("data-parsley-group"); 
            $("#firstname").removeAttr("required");     
            $("#firstname").removeAttr("data-parsley-group"); 
            $("#job").removeAttr("required");     
            $("#job").removeAttr("data-parsley-group"); 
            $("#datePC").removeAttr("required");     
            $("#datePC").removeAttr("data-parsley-group"); 

            $("#company_name").attr("required","true");     
            $("#company_name").attr("data-parsley-group","block4"); 
          }
      else{
        $('.particulier_field').show()
        $('.entreprise_field').hide()

        $("#lastname").attr("required","true");     
        $("#lastname").attr("data-parsley-group","block4"); 
        $("#firstname").attr("required","true");     
        $("#firstname").attr("data-parsley-group","block4"); 
        $("#job").attr("required","true");     
        $("#job").attr("data-parsley-group","block4"); 
        $("#datePC").attr("required","true");     
        $("#datePC").attr("data-parsley-group","block4"); 

        $("#company_name").removeAttr("required");     
        $("#company_name").removeAttr("data-parsley-group"); 
      }

        if($('input[name=proprio_veh]:checked').val()=='E' || $('input[name=proprio_veh]:checked').val()=='A'){
          $('.souscripteur_field').show()
          $("#souscripteur_name").attr("required","true");     
          $("#souscripteur_name").attr("data-parsley-group","block1");
          $("#phone_souscr").attr("required","true");     
          $("#phone_souscr").attr("data-parsley-group","block1");
        }else{
          $('.souscripteur_field').hide()
          $("#souscripteur_name").removeAttr("required");     
          $("#souscripteur_name").removeAttr("data-parsley-group");
          $("#phone_souscr").removeAttr("required");     
          $("#phone_souscr").removeAttr("data-parsley-group");

        }
        $('#rootwizard').bootstrapWizard('next')

      }

      $("input[name=proprio_veh]").click(function (e){
          switchProprioVeh();       
        
      })

      $('input[name=formule]').change(function(){
                if($('input[name=formule]:checked').val()=='tsimple'){
                  $('.if_not_tiers_simple').hide();
                  $("#vneuve").removeAttr("required");     
                  $("#vneuve").removeAttr("data-parsley-group"); 
                  $("#vvenale").removeAttr("required");     
                  $("#vvenale").removeAttr("data-parsley-group"); 
              }else{
                $('.if_not_tiers_simple').show(); 
                $("#vneuve").attr("required", "true");     
                $("#vneuve").attr("data-parsley-group", "block2");     
                $("#vvenale").attr("required", "true");     
                $("#vvenale").attr("data-parsley-group", "block2");     
              }
            });

        $("input[name=name_cg]").keyup(function  () {
          if($('input[name=proprio_veh]:checked').val()=='E')
            $("#company_name").val($(this).val())
          else
            $("#lastname").val($(this).val())
        })
      });
</script>
        <!--/ Page Specific Scripts -->
@stop

