var sfw;
$(document).ready(function() {
	$("#phone").mask("99 99 99 99 99");
	$("#phone_souscr").mask("99 99 99 99 99");
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

	function getQuotation(url){
	    var t = $('#box_table').DataTable({
	        "dom": '<"bottom"p>',
	        "pageLength": 3,
	        "bSort" : true,
	        "aaSorting": [[ 2, "asc" ]],
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
	      data: $("#quoteFormVoyage").serialize(),
	      success: function(data){

	      	var obj =JSON.parse(data)
	      	var html = "";
	      	var c = obj[0];
	      	html = '<div class="row">';
	      	html +=     '<div class="col-md-12">';
	      	html +=         '<p style="font-size:19px; color:#000">Le montant de votre assurance VOYAGE est de <b>'+formatMoney(Math.ceil(c.PRIME))+' FCFA</b> avec la compagnie <img width="60" src="/images/assureurs/'+c.logo+'")}}"> </p>';
	      	html +=     '</div>';
	      	html +='</div>';
	      	html += '<div class="row">';
	      	html +=     '<div class="col-md-12">';
	      	html +=         '<table style="width:100%" align="center"><tr><td>Destination</td><td>Age</td><td>Durée</td></tr>';
	      	html +=         '<tr><td>'+c.PROSPECT.pays_name+'('+c.PROSPECT.pays_zone+')</td><td>'+c.ASSURANCE.AGE+' an(s)</td><td>'+c.ASSURANCE.DUREE+' Jour(s)</td></tr></table>';
	      	html +=     '</div>';
	      	html +='</div>';

	      	html += '<div class="row hidden-xs">';
	      	html +=     '<div class="col-md-12">';
	      	html +=         '<table class="table" style="width:100%" align="center">';
	      	html +=             '<tr>';
	      	html +=                 '<td>Montant Prime d\'assurance</td>';
	      	html +=                 '<td>:</td>';
	      	html +=                 '<td>'+formatMoney(Math.ceil(c.PRIME))+'</td>';
	      	html +=             '</<tr>';

	      	html +=             '<tr>';
	      	html +=                 '<td>Services supplémentaires</td>';
	      	html +=                 '<td>:</td>';
	      	html +=                 '<td>'+formatMoney(Math.ceil(c.AMOUNT_SERVICES))+'</td>';
	      	html +=             '</<tr>';
	      	html +=             '<tr>';
	      	html +=                 '<td>Frais de livraison) </td>';
	      	html +=                 '<td>:</td>';
	      	html +=                 '<td>'+formatMoney(Math.ceil(c.FG))+'</td>';
	      	html +=             '</<tr>';
	      	html +=             '<tr>';
	      	html +=                 '<td>TOTAL</td>';
	      	html +=                 '<td>:</td>';
	      	html +=                 '<td><h4>'+formatMoney(Math.ceil(c.AMOUNT_SERVICES + c.PRIME + c.FG))+' FCFA</h4></td>';
	      	html +=             '</<tr>';
	      	html +=         '</table>';
	      	html +=     '</div>';
	      	html +='</div>';
	      	html += '<div class="row">';
	      	html +=     '<div class="col-md-12">';
	      	html +=             '<a href="/voyage/details/devis/'+c.id_quote+'/'+c.idcomp+'" style="background-color:#4cae4c;" data-text="Voir détails" class="btn btn-lg btn-success get-in-touch"><i class="fa fa-search"></i> Voir détails</a>  ';
	      	html +=             '<a href="#" onclick="$(\''+'#box_div_table'+'\').show()" style="background-color:#0275d8;" data-text="Comparer plus d\'ofres" class="btn btn-lg btn-success get-in-touch hidden-xs"><i class="fa fa-plus"></i> Comparer plus d\'ofres</a>  ';
	      	html +=     '</div>';
	      	html +='</div>';


	        $('#box_div').append(html);
	        $.each(obj, function(i,c){
	            html1 =         '<img width="83x30" src="/images/assureurs/'+c.logo+'" />';
	            html2 =         '<span>'+c.ASSURANCE.DUREE+'</span>';
	            html4 =         '<span>'+formatMoney(Math.ceil(c.PRIME))+' FCFA</span>';
	            html5 =         '<span>'+formatMoney(Math.ceil(c.FG))+' FCFA</span>';
	            html6 =         '<span>'+formatMoney(Math.ceil(c.AMOUNT_SERVICES))+' FCFA</span>';
	            html7 =         '<span>'+formatMoney(Math.ceil(c.PRIME+c.AMOUNT_SERVICES+c.FG))+' FCFA</span>';
	            html8 =         '<a title="Voir détails" href="/voyage/details/devis/'+c.id_quote+'/'+c.idcomp+'" style="background-color:#4cae4c;" class="btn btn-success"><i class="fa fa-search"></i></a>  ';


	            t.row.add([html1,html2,html4,html5,html6,html7,html8]).draw( false );
	        });
	      },
	      complete: function () {
	      	$(".loader_img").fadeOut();
	      	$("#box_div_table").fadeIn();
	      }
	    });
	}

	$("#quoteFormVoyage").submit(function (e){
	    e.preventDefault();
	    //validate fields
        var fail = false;
        var fail_log = '';
        $("#quoteFormVoyage").find( 'select, textarea, input' ).each(function(){
        	if( ! $( this ).prop( 'required' )){

		       } else {
		           if ( ! $( this ).val() ) {
		               fail = true;
		               name = $( this ).attr( 'label' );
		               fail_log += name + " est obligatoire \n";
		           }

		       }
        });
        if ( ! fail ) {
            //process form here.
	    	$('.cd-testimonials-all').addClass('is-visible');
	    	$('body').css('overflow','hidden');
	        $("#loader_quote").fadeIn();
	        html='<table class="table" id="box_table">';
	        html+='<thead>';
	        html+='<tr><th>Compagnie</th><th>Durée(Jours)</th><th>Prime</th><th>FAC</th><th>Services</th><th>Total</th> <th>Details</th></tr>';
	        html+='</thead>';
	        html+='<tbody id="box"></tbody>';
	        html+='</table>';

	        $('#box_div_table').html(html);

	        x_timer = setTimeout(function(){
	            getQuotation("/devis/voyage/getquotation")
	        }, 3000);
	      }else{
	      	alert( fail_log );
	      }

	});

	$("#close-btn").click(function(){
	    $('#box_div').html("");
	    $( "#loader_quote" ).fadeOut();
	    $( "#box_div_table" ).hide();
	    $(".loader_img").fadeIn("slow");

	});

	function showLoader () {
          var overlay = jQuery('<div id="overlay"> <img src="/images/travel-loader.gif" /> </div>');
          overlay.appendTo(document.body)
        }

        function stopLoader () {
          $( "#overlay" ).remove();
          window.sfw.next()


        }

        function switchProprioVeh(){
            showLoader();

            if($('input[name=proprio_veh]:checked').val()=='E' || $('input[name=proprio_veh]:checked').val()=='A'){
            	$('.souscripteur_field').show()
            	$("#souscripteur_name").attr("required","true");
            	$("#souscripteur_name").attr("data-parsley-group","block0");
            	$("#email_sousc").attr("required","true");
            	$("#email_sousc").attr("data-parsley-group","block0");
            	$("#phone_souscr").attr("required","true");
            	$("#phone_souscr").attr("data-parsley-group","block0");
            	$('#label_email').html("Adresse email de l'assuré");
            	$("#email").removeAttr("required");
            	$("#email").removeAttr("data-parsley-group");
            }else{
            	$('.souscripteur_field').hide()
            	$("#souscripteur_name").removeAttr("required");
            	$("#souscripteur_name").removeAttr("data-parsley-group");
            	$("#email_sousc").removeAttr("required");
            	$("#email_sousc").removeAttr("data-parsley-group");
            	$("#phone_souscr").removeAttr("required");
            	$("#phone_souscr").removeAttr("data-parsley-group");
            	$('#label_email').html("Adresse email de l'assuré*");
            	$("#email").attr("required","true");
            	$("#email").attr("data-parsley-group","block1");

            }
            setTimeout(function() {stopLoader()}, 1500);
        }

        $("input[name=proprio_veh]").click(function (e){
            switchProprioVeh();
        })

});




