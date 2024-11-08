var sfw;
$(document).ready(function() {

	$("#phone").mask("99 99 99 99 99");
	$("#phone_souscr").mask("99 99 99 99 99");
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

	function formatMoney(num , localize,fixedDecimalLength){
		num=num+"";
		var str=num;
		var reg=new RegExp(/(\D*)(\d*(?:[\.|,]\d*)*)(\D*)/g)
		if(reg.test(num)){
	        var pref=RegExp.$1;
	        var suf=RegExp.$3;
	        var part=RegExp.$2;
	        if(fixedDecimalLength/1)part=(part/1).toFixed(fixedDecimalLength/1);
	        if(localize)part=(part/1).toLocaleString();
	        str= pref +part.match(/(\d{1,3}(?:[\.|,]\d*)?)(?=(\d{3}(?:[\.|,]\d*)?)*$)/g ).join('.')+suf ;
	    };
	    return str;
	}

	function check_immatriculation(mat){

	    $.get("/rest-api/v1/searchcar/"+mat, function(data) {
	        if(data!=0){
	            $("#immat-result").html("<img src='/images/available.png' />");
	            $("#mat_help-block").html("Un véhicule a été trouvé");
	            $( "#mat_help-block" ).prop( "style", "color:green" );
	           var d = JSON.parse(data);

	           $("#marque").val(d.make_id);
	           $('#marque')
			    .append($("<option/>") //add option tag in select
			        .val(d.make_id) //set value for option to post it
			        .text(d.title+" "+d.modtitle)) //set a text for show in select
			    .val(d.make_id) //select option of select2
			    .trigger("change"); //apply to select2

	           $("#genre").val(d.type_id);
	           $("#name_cg").val(d.name_cg);
	           $("#puissance").val(d.power);
	           if(d.energy=='E') $("#essence").prop( "checked", true ); else $( "#diesel" ).prop( "checked", true );
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
	           $("#color").val(d.color);
	        }
	        else{
	            $( "#mat_help-block" ).prop( "style", "color:red" );
	            $("#immat-result").html("<img src='/images/not-available.png' />");
	            $("#mat_help-block").html("Aucun véhicule ne correspond à ce numéro d'immatriculation");
	            $("#genre").val("");
	            $("#name_cg").val("");
	            $("#marque").val("");
	            $("#puissance").val("");
	            $("#essence").prop( "checked", true );
	            $("#category").val("");
	            $("#category").prop("disabled",true);
	            $("#dateMiseCirc").val("");
	            $("#nbplace").val("");
	            $("#vneuve").val("");
	            $("#vvenale").val("");
	            $("#city").val("");
	            $("#color").val("");
	           	$("#div_cu").hide();
	            $("#cu").val("");
	        }
	    });
	    $("#searchmat").prop('disabled',false);
	}

	function showAuthCar(){
		  	currentcar = document.getElementById('currentcar');
			yournewcar = document.getElementById('yournewcar');

			currentcar.style.display = "none";
			yournewcar.style.display = "block";
	}

	function getQuotation(url){
	    var t = $('#box_table').DataTable({
	        "dom": '<"bottom"p>',
	        "pageLength": 3,
	        "bSort" : true,
	        "aaSorting": [[ 1, "asc" ]],
	        "aoColumnDefs": [
	        { "sType": "numeric" }
	        ],
	        "oLanguage": {
	            "oPaginate": {
	                "sFirst": "Premier",
	                "sLast": "Dernier",
	                "sNext": "<i class='fa fa-arrow-circle-right'></i>",
	                "sPrevious": "<i class='fa fa-arrow-circle-left'></i>",
	                "sEmptyTable": "Aucun dévis ne correspond à vos critères"
	            }
	        }
	    });

	    $.ajax({
	      url: url,
	      cache: false,
	      type: "post",
	      data: $("#quoteForm").serialize(),
	      success: function(data){
	        var obj =JSON.parse(data)
	        var html = "";
	        var c = obj[0];
	        html = '<div class="row">';
	        html +=     '<div class="col-md-12">';
	        html +=         '<p style="font-size:19px; color:#000">Le montant de votre assurance AUTO est de <b>'+formatMoney(Math.ceil(c.TTC-c.FG))+' FCFA</b> avec la compagnie <img width="60" src="/images/assureurs/'+c.logo+'")}}"> </p>';
	        html +=     '</div>';
	        html +='</div>';
	        html += '<div class="row hidden-xs">';
	        html +=     '<div class="col-md-12">';
	        html +=         '<table class="table" style="width:100%" align="center">';
	        html +=             '<tr>';
	        html +=                 '<td>Montant Prime d\'assurance '+c.desc_periode+'</td>';
	        html +=                 '<td>:</td>';
	        html +=                 '<td>'+formatMoney(Math.ceil(c.TTC-c.FG))+'</td>';
	        html +=             '</<tr>';

	        html +=             '<tr>';
	        html +=                 '<td>Services supplémentaires ('+c.nbmois+' mois)</td>';
	        html +=                 '<td>:</td>';
	        html +=                 '<td>'+formatMoney(Math.ceil(c.som_serv))+'</td>';
	        html +=             '</<tr>';
	        html +=             '<tr>';
	        html +=                 '<td>Frais d\'ccesoire Courtier(FAC) </td>';
	        html +=                 '<td>:</td>';
	        html +=                 '<td>'+formatMoney(Math.ceil(c.FG))+'</td>';
	        html +=             '</<tr>';
	        html +=             '<tr>';
	        html +=                 '<td>TOTAL</td>';
	        html +=                 '<td>:</td>';
	        html +=                 '<td><h4>'+formatMoney(Math.ceil(c.som_serv + c.TTC))+' FCFA</h4></td>';
	        html +=             '</<tr>';
	        html +=         '</table>';
	        html +=     '</div>';
	        html +='</div>';
	        html += '<div class="row">';
	        html +=     '<div class="col-md-12">';
	        html +=             '<a href="/details/devis/'+c.id_quote+'/'+c.idcomp+'" style="background-color:#4cae4c;" data-text="Voir détails" class="btn btn-lg btn-success get-in-touch"><i class="fa fa-search"></i> Voir détails</a>  ';
	        html +=             '<a href="#" onclick="$(\''+'#box_div_table'+'\').show()" style="background-color:#0275d8;" data-text="Comparer plus d\'ofres" class="btn btn-lg btn-success get-in-touch hidden-xs"><i class="fa fa-plus"></i> Comparer plus d\'ofres</a>  ';
	        html +=     '</div>';
	        html +='</div>';

	        $('#box_div').append(html);
	        $.each(obj, function(i,c){
	            html1 =         '<img width="83x30" src="/images/assureurs/'+c.logo+'" />';
	            html2 =         '<span>'+c.formule_selected+'</span>';
	            html3 =         '<span>'+c.desc_periode+'</span>';
	            html4 =         '<span>'+formatMoney(Math.ceil(c.TTC-c.FG))+' FCFA</span>';
	            html5 =         '<span>'+formatMoney(Math.ceil(c.FG))+' FCFA</span>';
	            html6 =         '<span>'+formatMoney(Math.ceil(c.som_serv))+' FCFA</span>';
	            html7 =         '<span>'+formatMoney(Math.ceil(c.TTC+c.som_serv))+' FCFA</span>';
	            html8 =         '<a title="Voir détails" href="/details/devis/'+c.id_quote+'/'+c.idcomp+'" style="background-color:#4cae4c;" class="btn btn-success"><i class="fa fa-search"></i></a>  ';


	            t.row.add([html1,html4,html5,html6,html7,html8]).draw( false );
	        });

	      },
	      complete: function () {
	      	$(".loader_img").fadeOut();
	      	$("#box_div_table").fadeIn();
	      }
	    });
	}

	function getQuotationMoto(url){
	    var t = $('#box_table').DataTable({
	        "dom": '<"bottom"p>',
	        "pageLength": 3,
	        "bSort" : true,
	        "aaSorting": [[ 1, "asc" ]],
	        "aoColumnDefs": [
	        { "sType": "numeric" }
	        ],
	        "oLanguage": {
	            "oPaginate": {
	                "sFirst": "Premier",
	                "sLast": "Dernier",
	                "sNext": "<i class='fa fa-arrow-circle-right'></i>",
	                "sPrevious": "<i class='fa fa-arrow-circle-left'></i>",
	                "sEmptyTable": "Aucun dévis ne correspond à vos critères"
	            }
	        }
	    });

	    $.ajax({
	      url: url,
	      type: "post",
	      data: $("#quoteFormMoto").serialize(),
	      success: function(data){
	        var obj =JSON.parse(data)
	        var html = "";
	        var c = obj[0];
	        html = '<div class="row">';
	        html +=     '<div class="col-md-12">';
	        html +=         '<p style="font-size:19px; color:#000">Le montant de votre assurance MOTO est de <b>'+formatMoney(Math.ceil(c.TTC-c.FG))+' FCFA</b> avec la compagnie <img width="60" src="/images/assureurs/'+c.logo+'")}}"> </p>';
	        html +=     '</div>';
	        html +='</div>';
	        html += '<div class="row hidden-xs">';
	        html +=     '<div class="col-md-12">';
	        html +=         '<table class="table" style="width:100%" align="center">';
	        html +=             '<tr>';
	        html +=                 '<td>Montant Prime d\'assurance '+c.desc_periode+'</td>';
	        html +=                 '<td>:</td>';
	        html +=                 '<td>'+formatMoney(Math.ceil(c.TTC-c.FG))+'</td>';
	        html +=             '</<tr>';

	        html +=             '<tr>';
	        html +=                 '<td>Services supplémentaires ('+c.nbmois+' mois)</td>';
	        html +=                 '<td>:</td>';
	        html +=                 '<td>'+formatMoney(Math.ceil(c.som_serv))+'</td>';
	        html +=             '</<tr>';
	        html +=             '<tr>';
	        html +=                 '<td>Frais de Accesoire Courtier(FAC) </td>';
	        html +=                 '<td>:</td>';
	        html +=                 '<td>'+formatMoney(Math.ceil(c.FG))+'</td>';
	        html +=             '</<tr>';
	        html +=             '<tr>';
	        html +=                 '<td>TOTAL</td>';
	        html +=                 '<td>:</td>';
	        html +=                 '<td><h4>'+formatMoney(Math.ceil(c.som_serv + c.TTC))+' FCFA</h4></td>';
	        html +=             '</<tr>';
	        html +=         '</table>';
	        html +=     '</div>';
	        html +='</div>';
	        html += '<div class="row">';
	        html +=     '<div class="col-md-12">';
	        html +=             '<a href="/details/devis/'+c.id_quote+'/'+c.idcomp+'" style="background-color:#4cae4c;" data-text="Voir détails" class="btn btn-lg btn-success get-in-touch"><i class="fa fa-search"></i> Voir détails</a>  ';
	        html +=             '<a href="#" onclick="$(\''+'#box_div_table'+'\').show()" style="background-color:#0275d8;" data-text="Comparer plus d\'ofres" class="btn btn-lg btn-success get-in-touch hidden-xs"><i class="fa fa-plus"></i> Comparer plus d\'ofres</a>  ';
	        html +=     '</div>';
	        html +='</div>';

	        $('#box_div').append(html);
	        $.each(obj, function(i,c){
	            html1 =         '<img width="83x30" src="/images/assureurs/'+c.logo+'" />';
	            html2 =         '<span>'+c.formule_selected+'</span>';
	            html3 =         '<span>'+c.desc_periode+'</span>';
	            html4 =         '<span>'+formatMoney(Math.ceil(c.TTC-c.FG))+' FCFA</span>';
	            html5 =         '<span>'+formatMoney(Math.ceil(c.FG))+' FCFA</span>';
	            html6 =         '<span>'+formatMoney(Math.ceil(c.som_serv))+' FCFA</span>';
	            html7 =         '<span>'+formatMoney(Math.ceil(c.TTC+c.som_serv))+' FCFA</span>';
	            html8 =         '<a title="Voir détails" href="/details/devis/'+c.id_quote+'/'+c.idcomp+'" style="background-color:#4cae4c;" class="btn btn-success"><i class="fa fa-search"></i></a>  ';


	            t.row.add([html1,html4,html5,html6,html7,html8]).draw( false );
	        });


	      },
	      complete: function () {
	      	$(".loader_img").fadeOut();
	      	$("#box_div_table").fadeIn();
	      }
	    });
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

	$("#guaranteetype").click(function (e){
	    $("#div-formule").hide();
	    $("#div-garantie").show();
	});

	 $("#formuletype").click(function (e){
	    $("#div-garantie").hide();
	    $("#div-formule").show();
	});

	$("#searchmat").click(function (e){
	    e.preventDefault();

	    $("#immat-result").html('<img src="/images/ajaxloader.gif" />');
	    $("#searchmat").prop('disabled',true);
	    x_timer = setTimeout(function(){
	        var immat = $('#immat').val();
	        check_immatriculation(immat);
	    }, 1000);

	});

	$("#yourcar").change(function (e){
	    e.preventDefault();
	    var immat = $('#yourcar').val();
		check_immatriculation(immat);
		document.getElementById('immat').value = immat
		showAuthCar()

	});

	$("#quoteForm").submit(function (e){
	    e.preventDefault();

	    	$('.cd-testimonials-all').addClass('is-visible');
	    	$('body').css('overflow','hidden');
	        $("#loader_quote").fadeIn();
	        html='<table class="table" id="box_table">';
	        html+='<thead>';
	        html+='<tr><th>Compagnie</th><th>Prime</th><th>FAC</th><th>Services</th><th>Total</th> <th>Details</th></tr>';
	        html+='</thead>';
	        html+='<tbody id="box"></tbody>';
	        html+='</table>';

	        $('#box_div_table').html(html);

	        x_timer = setTimeout(function(){

	            getQuotation("/devis/auto/getquotation")
	        }, 2000);


	});

	$("#quoteFormMoto").submit(function (e){
	    e.preventDefault();

	    	$('.cd-testimonials-all').addClass('is-visible');
	    	$('body').css('overflow','hidden');
	        $("#loader_quote").fadeIn();
	        html='<table class="table" id="box_table">';
	        html+='<thead>';
	        html+='<tr><th>Compagnie</th><th>Prime</th><th>Livraison</th><th>Services</th><th>Total</th> <th>Details</th></tr>';
	        html+='</thead>';
	        html+='<tbody id="box"></tbody>';
	        html+='</table>';

	        $('#box_div_table').html(html);

	        x_timer = setTimeout(function(){
	            getQuotationMoto("/devis/moto/getquotation")
	        }, 2000);

	});


	$("#close-btn").click(function(){
	    $('#box_div').html("");
	    $( "#loader_quote" ).fadeOut();
	    $( "#box_div_table" ).hide();
	    $(".loader_img").fadeIn("slow");

	});


	  $('.carlist').select2({
	  	allowClear: true,
	  	theme: "classic",
	  	width: 'resolve',
	  	language: {
	  	  noResults: function(searchedTerm) {
 			return "<li class='select2-no-results'>"+"Aucun véhicule trouvé.<button data-toggle='modal' data-target='#modal-newcar' class='btn-success pull-right small_button' data-text='Ajouter' id='new_car_btn'>Ajouter</button></li>";	  	 }
	  	},
	  	escapeMarkup: function (markup) {
	        return markup;
	    }
	  });



	  	$(document).on('click', '#new_car_btn', function() {
	  		$('#new_make').val($('.select2-search__field').val());
	  		$('#new_make').focus();
	  	});


	  	$("#newmakecar").submit(function (e){
	  	    e.preventDefault();
	  	    $("#carLoader").fadeIn();

	  	    setTimeout(function() {
	  	    	$.ajax({
	  	    	  url: '/add/newmakecar',
	  	    	  type: "post",
	  	    	  data: $("#newmakecar").serialize(),
	  	    	  success: function(data){
	  	    	  	console.log(data)
	  	    	  	$("#car_error").fadeOut();
	  	    	  	if(data==0){
	  	    	  		$("#new_car_error").fadeIn();
	  	    	  	}else{
	  	    	  		d = JSON.parse(data);
	  	    	  		var o = $("<option/>", {value: d.id, text: d.title});
	  	    	  		$('.carlist').append(o);
	  	    	  		$('.carlist option[value="' + d.id + '"]').prop('selected',true);
	  	    	  		$('.carlist').trigger('change');
	  	    	  		$('#modal-newcar').modal('hide');
	  	    	  		$("#new_car_error").fadeOut();
	  	    	  	}

	  	    	  	$("#carLoader").fadeOut();

	  	    	  },
	  	    	  error : function (e) {
	  	    	  	console.log(e)
	  	    	  	$("#carLoader").fadeOut();
	  	    	  	$("#car_error").fadeIn();
	  	    	  }
	  	    	})
	  	    }, 2000);
	  	});



	  $('.yourcar').select2({
	    	allowClear: true,
	    	language: {
	    	  noResults: function() {
	    	    return "<a href='javascript:;' onclick='showAuthCar()'>Ajouter nouveau véhicule</a>";
	    	 }
	    	},
	    	escapeMarkup: function (markup) {
	          return markup;
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

	  new Cleave('.vvenale', {
	      numeral: true,
	      numeralThousandsGroupStyle: 'thousand'
	  });

	  new Cleave('.vneuve', {
	      numeral: true,
	      numeralThousandsGroupStyle: 'thousand'
	  });

	  new Cleave('.place', {
	      numeral: true,
	      numeralThousandsGroupStyle: 'thousand'
	  });

	  new Cleave('.date_priseeffet', {
	      date: true,
	      datePattern: ['d','m','Y']
	  });

	  new Cleave('.datePC', {
	      date: true,
	      datePattern: ['d','m','Y']
	  });

	  new Cleave('.dob', {
	      date: true,
	      datePattern: ['d','m','Y']
	  });

	  new Cleave('.dateMiseCirc', {
	      date: true,
	      datePattern: ['d','m','Y']
	  });
	function showAuthCar(){
			  	currentcar = document.getElementById('currentcar');
				yournewcar = document.getElementById('yournewcar');

				currentcar.style.display = "none";
				yournewcar.style.display = "block";
		}



		$(function () {
	        $('#datetimepicker_priseeffet').datetimepicker({
	        	format: 'DD/MM/YYYY',
	            showTodayButton: true,
	            widgetPositioning:{
	               horizontal: 'auto',
	               vertical:'bottom'
	            }
	        });


	        $('.datetimepicker_dob').datetimepicker({
	        	format: 'DD/MM/YYYY',
	            maxDate:moment(),
	            viewMode: 'years',
	            widgetPositioning:{
	               horizontal: 'auto',
	               vertical:'top'
	            }
	        });

	        $('.datetimepicker_datePC').datetimepicker({
	          format: 'DD/MM/YYYY',
	            maxDate:moment(),
	            viewMode: 'years'
	        });

	        $('.datetimepicker_dateMiseCirc').datetimepicker({
	          format: 'DD/MM/YYYY',
	          viewMode: 'years',
	          maxDate:moment()
	        });



	    });

	    function sleep(milliseconds) {
	      var start = new Date().getTime();
	      for (var i = 0; i < 1e7; i++) {
	        if ((new Date().getTime() - start) > milliseconds){
	          break;
	        }
	      }
	    }

	    sfw = $(".quoteForm").stepFormWizard({
        	theme: 'sky',
            markPrevSteps: true,
            height: 'auto',
            finishBtn: $('<button type="submit" id="getquoteBtn" data-delay="200" href="javascript:void(0);" style="background-color:#4cae4c;" class="btn sf-right btn-success get-in-touch cd-see-all"  data-text="COMPARER LES OFFRES"><i class="fa fa-check"></i> COMPARER LES OFFRES</button>'),
            onNext: function(i) {
                var valid = $(".quoteForm").parsley().validate('block' + i);

                sfw.refresh();
				return valid
            },
            onFinish: function(i) {
                var valid = $(".quoteForm").parsley().validate();
                // if use height: 'auto' call refresh metod after validation, because parsley can change content
                sfw.refresh();
                return valid;
            }
        });

        function showLoader () {
          var overlay = jQuery('<div id="overlay"> <img src="/images/preloader3.gif" /> </div>');
          overlay.appendTo(document.body)
        }

        function stopLoader () {
          $( "#overlay" ).remove();
          window.sfw.next()


        }

        function switchProprioVeh(){
            showLoader();
            if($('input[name=proprio_veh]:checked').val()=='E' ){

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
            	$("#company_name").attr("data-parsley-group","block3");
            }
            else{
              $('.particulier_field').show()
              $('.entreprise_field').hide()

              	$("#lastname").attr("required","true");
            	$("#lastname").attr("data-parsley-group","block3");
            	$("#firstname").attr("required","true");
            	$("#firstname").attr("data-parsley-group","block3");
            	$("#job").attr("required","true");
            	$("#job").attr("data-parsley-group","block3");
            	if($("#category").val()==5){
            	$("#datePC").attr("required","true");
            	$("#datePC").attr("data-parsley-group","block3");
            	}


            	$("#company_name").removeAttr("required");
            	$("#company_name").removeAttr("data-parsley-group");
            }

            if($('input[name=proprio_veh]:checked').val()=='E' || $('input[name=proprio_veh]:checked').val()=='A'){
            	$('.souscripteur_field').show()
            	$("#souscripteur_name").attr("required","true");
            	$("#souscripteur_name").attr("data-parsley-group","block0");
            	$("#phone_souscr").attr("required","true");
            	$("#phone_souscr").attr("data-parsley-group","block0");
            }else{
            	$('.souscripteur_field').hide()
            	$("#souscripteur_name").removeAttr("required");
            	$("#souscripteur_name").removeAttr("data-parsley-group");
            	$("#phone_souscr").removeAttr("required");
            	$("#phone_souscr").removeAttr("data-parsley-group");

            }


            setTimeout(function() {stopLoader()}, 1500);
        }

        $("input[name=proprio_veh]").click(function (e){
            switchProprioVeh();
        })

        $(".help_cg").click(function (e){
            img = $(this).attr('id')+'.png';
            $("#div_help_img").html("<img src='/images/cg/"+img+"'/>")
        })



        $("input[name=name_cg]").keyup(function  () {
          if($('input[name=proprio_veh]:checked').val()=='E')
            $("#company_name").val($(this).val())
          else
            $("#lastname").val($(this).val())
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

});




