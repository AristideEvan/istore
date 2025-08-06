/*!
* script js mise en place par SOMDA
*/

jQuery('select').select2({
    language: "fr",
    width: '100%'
});

$(".js-select2").select2({
    closeOnSelect : false,
    placeholder : "",
    allowHtml: true,
    allowClear: true,
    tags: true
});

/**
 * function pour le message de confirmation de la suppression
 * @param {*} href
 * @param {*} text
 */
function Supprimer(href,text){
    jQuery('#pourSupp').prop('action', href);
    jQuery('#nb').text(text);
    jQuery("#suppModal").modal();
    //console.log("yes");
}

/** fonction pour afficher des fenetres de type popup */
function popUp(chemin,id){
    console.log(chemin);
    jQuery('#envoi').load(chemin, function(){
      jQuery("#"+id).modal();
  });
}

/*  pour faire afficher le mot de passe */
jQuery(".toggle-password").click(function() {
    jQuery(this).toggleClass("fa-eye fa-eye-slash");
    var input = jQuery(jQuery(this).attr("toggle"));
    if (input.attr("type") == "password") {
    input.attr("type", "text");
    } else {
    input.attr("type", "password");
    }
});

//input mask pour créer un masque de saisie a revoir

$(document).ready(function() {
    jQuery('[data-mask]').inputmask();
  });

jQuery(".phone").inputmask({"mask": "(+226) 99-99-99-99"});
jQuery(".year").inputmask({"mask": "9999"});
jQuery(".anneeScol").inputmask({"mask": "9999-9999"});
jQuery(".moyenne").inputmask({"mask": "99.99"});
jQuery(".coefficient").inputmask({"mask": "99.9"});
//jQuery(".point").inputmask({"mask": "99999"});

$(function(){
	$('.sm,.ssm').prop("disabled",true);
	function count_checkbox_checked(){
		nchecked = 0;
		$('.parent,.sm').each(function(index){
			if($(this).prop('checked')){
				nchecked = nchecked + 1;
			}
		});
		$('input[name="nbmenu"]').val(nchecked);
	}
	$('#toutMenu').click(function(){
		if($(this).prop('checked')){
			$('.parent,.sm,.ssm').prop("checked",true);
			$('.sm,.ssm').prop("disabled",false);
		}else{
			$('.parent,.sm, .ssm').prop("checked",false);
			$('.sm,.ssm').prop("disabled",true);
		}
		count_checkbox_checked();
	});
	$('.parent,.sm').click(function(){
		if($(this).prop('checked')){
			$('.fils'+$(this).attr("value")).prop("disabled",false);
		}else{
			$('.fils'+$(this).attr("value")).prop("disabled",true);
			$('.fils'+$(this).attr("value")).prop("checked",false);
            $('.pfils'+$(this).attr("value")).prop("disabled",true);
			$('.pfils'+$(this).attr("value")).prop("checked",false);
		}
		count_checkbox_checked();
	});
    $('.sm').css('margin-left','20px');
    $('.ssm').css('margin-left','40px');
});

/* Fonction pour activer un element du ménu */
jQuery(document).ready(function() {
	var chemin=jQuery(location).attr("pathname");
	var indice=chemin.split('/');
	var tailleTab = indice.length;
	var elem=indice[1];
	//console.log();

	jQuery('#colapse-'+indice[tailleTab-2]).addClass('menu-is-opening menu-open');
	jQuery('#sousMenu'+indice[tailleTab-1]).addClass('lienActiver');
	//jQuery('#heading'+indice[tailleTab-2]).addClass('menuChoisi');
	//jQuery('#sousMenu'+indice[tailleTab-1]).parents('li').css('background-color', '#a1d69f');
  });

  function Collapser(id){
    var chaine=id.split('-');/* Pour recuperer le num du collapse */
    var ordre=chaine[1];/* Num du collapse */
    var classe=jQuery("#colapse-"+ordre).prop('class');
	jQuery('[id^="colapse-"]').each(function(){
		if($(this).prop('id')!='colapse-'+ordre){
			$(this).first().children('ul').css('display','none');
			$(this).removeClass('menu-is-opening menu-open');
		}
    });
}


function enleverBloc(id){
	$('#'+id).remove();
}

function calculNbPlat() {
	var nbrPartAttrib = 0;
    $('.calNbTotal').each(function(index){
        nbrPartAttrib =Number(nbrPartAttrib)+Number($(this).val());
    });

	$("#nombreT").val(nbrPartAttrib);
}

function enleverBlocMet(id){
	$('#'+id).remove();
	calculNbPlat();
}

function changerEtatCompte(href,text){
	jQuery('#changeEtat').prop('action', href);
	jQuery('#zoneMessage').text(text);
	jQuery("#changeEtatModal").modal();
}

function checkPrescription(id){
    if($('#'+id).prop('checked')){
        $('.checkPrescription').prop("checked",true);
    }else{
        $('.checkPrescription').prop("checked",false);
    }
}


function validerDate(debut,limit,niveau){
	var dateDebut=$('#'+debut);
	var dateLimit=$('#'+limit);
	if(dateDebut.val()!="" && dateLimit.val()!=""){
	  var partsDeb=dateDebut.val().split("-");
	  var date_debut=new Date(partsDeb[2],partsDeb[1]-1,partsDeb[0]);
	  var partsLimit=dateLimit.val().split("-");
	  var dateLimite=new Date(partsLimit[2],partsLimit[1]-1,partsLimit[0]);
	  //console.log(aujourd);
	  if(dateLimite<date_debut){
		if(Number(niveau)==1){
		  dateDebut.val("");
		}else{
		  dateLimit.val("");
		}
		  //popupAlert("La date de début ne peut être antérieure &agrave; date limite!");
		  $.rtnotify({
			  title: "",
			  message: "La date de début ne peut être antérieure &agrave; date limite!",
			  type: "error",
			  permanent: false,
			  timeout: 5,
			  fade: true,
			  width: 300
		  });
	  }
	}

}

function apercuDocument(chemin){
    PDFObject.embed(chemin, "#docZone");
    jQuery("#apercuDoc").modal("show");
}

function popUpFront(chemin,id){
    jQuery('#envoi').load(chemin, function(){
      jQuery("#"+id).modal("show");
  });
}

function toutCocher(id,classe){
    if($('#'+id).prop('checked')){
        $('.'+classe).prop("checked",true);
    }else{
        $('.'+classe).prop("checked",false);
    }
}

function popupAlert($message){
	console.log($message)
    jQuery('#zoneMessage').html($message);
    jQuery("#popupAlert").modal();
}


// definir la couleur de recommandation d'une serie en fonction de la moyenne
function couleur(moy, serie){
    if (moy <= 8.0) {
        $('#moy-serie-'+serie).css('background-color','red');
    }else{
        if (moy <= 10.0) {
            $('#moy-serie-'+serie).css('background-color','orange');
        } else {
            if (isNaN(moy)) {
                $('#moy-serie-'+serie).css('background-color','white');
            }else{
                $('#moy-serie-'+serie).css('background-color','#1d8348');
            }
        }
    }
}
