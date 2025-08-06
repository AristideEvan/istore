
//inclusion du token dans toutes les requetes ajax
jQuery.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    }
});

/* Message de notification Rouge*/
function Notification(message){
    jQuery.rtnotify({
      title: "",
      message: message,
      type: "error",
      permanent: false,
      timeout: 30,
      fade: true,
      width: 300
  });
}

/* Message de notification Vert*/
function NotificationSucces(message){
    jQuery.rtnotify({
      title: "",
      message: message,
      type: "success",
      permanent: false,
      timeout: 3,
      fade: true,
      width: 300
  });
}

/**
 * fonction de récuperation des informations dans la BD en ajax
 * @param {*} url chemin du controller
 * @param {*} id valeur initiale
 * @param {*} affiche zone d'affichage du resultat
 */

function getDonnees(url,id,affiche){
    var chemin;
    if (!isNaN(id)) {/* Si c'est un nombre */
        chemin="/"+url+"/"+id;
    } else {
        var valeur_id=jQuery("#"+id).val();
        chemin="/"+url+"/"+valeur_id;
    }
    console.log("Le chemin: ",chemin);
    if(valeur_id!=''){
        jQuery.ajax({
            type:"GET",
            url:chemin,
            data:"",
            dataType: "html",
            beforeSend: function () {
                jQuery("#"+affiche).css('text-align','center');
                jQuery("#"+affiche).html('<img src="/images/Preloader_11.gif">');
                
            },
            complete: function () {
                jQuery("#"+affiche).css('text-align','');
            },
            success: function(server_response){
                jQuery("#"+affiche).html(server_response).show();
                console.log(server_response);
            },
            error: function(server_response){
                alert("je suis là");
                Notification('Aucune donnée selectionnée');
            }
        });
    }
}


function saisirDonneeInd(url,structure_id,thematique_id,annee,affiche){
    var annee_select=jQuery("#"+annee).val();
    var structure_select=jQuery("#"+structure_id).val();
    var thematique_select=jQuery("#"+thematique_id).val();
    
   
    if(structure_select!="" && annee_select!="" && thematique_select!=""){
        var chemin="/"+url+"/"+structure_select+"/"+thematique_select+"/"+annee_select;
        console.log(chemin);
        jQuery.ajax({
            type:"GET",
            url:chemin,
            data:"",
            dataType: "html",
            beforeSend: function () {
                jQuery("#"+affiche).css('text-align','center');
                jQuery("#"+affiche).html('<img src="/images/Preloader_11.gif">');
            },
            complete: function () {
                jQuery("#"+affiche).css('text-align','');
            },
            success: function(server_response){
                jQuery("#"+affiche).html(server_response).show();
            },
            error: function(server_response){
                Notification('Aucune donnée selectionnée');
            }
        });
    }
}

function getListeLocalite(url,affiche){
    
    var idregion=jQuery('#region').val();
    var idprovince=jQuery('#province').val();
    var idcommune=jQuery('#commune').val();
    var where=null;
    if(Number(idregion)!=0){
        where = "idreg="+idregion
    }
    if(Number(idprovince)!=0){
        where = "idprov="+idprovince
    }

    if(Number(idcommune)!=0){
        where = "idcom="+idcommune
    }
    
    if(Number(idregion)==0){
        Notification('Veuillez sélectionner un élément');
    }else{
        //var chemin="/"+url+"/"+idregion+"/"+idprovince;
        var chemin="/"+url+"/"+where;
        console.log(chemin);
        jQuery.ajax({
            type:"GET",
            url:chemin,
            data:"",
            dataType: "html",
            beforeSend: function () {
                jQuery("#"+affiche).css('text-align','center');
                jQuery("#"+affiche).html('<img src="/images/Preloader_11.gif">');
            },
            complete: function () {
                jQuery("#"+affiche).css('text-align','');
            },
            success: function(server_response){
                jQuery("#"+affiche).html(server_response).show();
            },
            error: function(server_response){
                Notification('Une erreur est survenue!');
            }
        });
    }
}

function envoyerForm(idForm,affiche){
    var form_url = $("#"+idForm).attr("action"); //récupérer l'URL du formulaire
    var form_method = $("#"+idForm).attr("method"); //récupérer la méthode GET/POST du formulaire
    var form_data = $("#"+idForm).serialize(); //Encoder les éléments du formulaire pour la soumission
    console.log(form_url);    
    $.ajax({
        url : form_url,
        type: form_method,
        data : form_data,
        beforeSend: function () {
            jQuery("#"+affiche).css('text-align','center');
            jQuery("#"+affiche).html('<img src="/images/Preloader_11.gif">');
        },
        complete: function () {
            jQuery("#"+affiche).css('text-align','');
        },
        success: function(server_response){
            jQuery("#"+affiche).html(server_response).show();
        },
        error: function(server_response){
            //Notification(server_response,'error');
            Notification('Une erreur est survenue!');
        }
    });
    //Notification('Veuillez renseigner tous les champs obligatoire','error');      
}

function setVisible(id) {
    console.log(id);
    jQuery.ajax({
        type:"GET",
        url:id,
        data:"",
        dataType: "html",
        error: function(server_response){
            Notification('Une erreur est survenue!');
        }
    });
} 

function getForme(url,id,zone) {
    var val=jQuery('#'+id).val();
    var nbr=Number(val)+1;
        chemin="/"+url+'/'+val;
        console.log(chemin);
        jQuery.ajax({
            type:"GET",
            url:chemin,
            data:"",
            dataType: "html",
            success: function(server_response){
                jQuery("#"+zone).append(server_response).show();
                jQuery('#'+id).val(nbr);
            },
            error: function(server_response){
                Notification('Une erreur est survenue!');
            }
        });
    /* }else{
        
    } */
    
} 

function saveCapacite(id){
    var chemin;
    var capacite=jQuery("#"+id).val();
    var idconcours = jQuery("#concours").val();
    chemin="/saveCapacite/"+id+"/"+capacite+"/"+idconcours;
    console.log(id);
    if(idconcours){
        if(Number(capacite)!=0 ){
            jQuery.ajax({
                type:"GET",
                url:chemin,
                data:"",
                dataType: "html",
                error: function(server_response){
                    Notification('Erreur lors de l\'enregistrement');
                }
            });
        }
    }else{
        Notification('Sélectionner le concours capacité non enregistrée');
    }
}


function sendToServer(id)
{
    var chemin;
    //console.log(id);
    chemin=id;
    jQuery.ajax({
        type:"GET",
        url:chemin,
        data:"",
        dataType: "html",
        beforeSend: function () {
            jQuery("#loader").modal();
           // jQuery("#"+affiche).html('<img src="/images/Preloader_11.gif">');
        },
        complete: function () {
            jQuery("#loader").modal("hide");
        },
        success: function(server_response){
           notificationPers("Opération éffectuée avec succès",5,"success");
           location.reload();
        },
        error: function(server_response){
            Notification('Erreur lors du traitement des données '+server_response);
        }
    });
}


function notificationPers(message,duree,type){
    jQuery.rtnotify({
        title: "",
        message: message,
        type: type,
        permanent: false,
        timeout: duree,
        fade: true,
        width: 300
    });
}


    
//     $(document).on('click', '.btn-enregistrer', function () {
//     let id = $(this).data('id');
//     let form = $('.form-indicateur[data-id="' + id + '"]');
//     let button = $(this);

//     $.ajax({
//         type: "POST",
//         url: "{{ route('enregistrerIndividuel') }}",
//         data: form.serialize(),
//         headers: {
//             'X-CSRF-TOKEN': $('input[name="_token"]').val()
//         },
//         success: function (response) {
//             button.removeClass('btn-success').addClass('btn-secondary');
//             button.text('Validé ✅');
//             button.prop('disabled', true); // facultatif pour désactiver le bouton
//         },
//         error: function (xhr) {
//             let erreur = xhr.responseJSON?.message || 'Erreur lors de l\'enregistrement';
//             alert(erreur);
//         }
//     });
// });
