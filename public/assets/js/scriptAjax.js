
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
    console.log(chemin+" id "+id+" valeur "+ jQuery("#region").val());
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

function getCandidat(affichage)
{
    var chemin;
    var examen=jQuery("#examen").val();
    var session = jQuery("#session").val();
    var numeroPV = jQuery("#numeroPV").val();
    var dateNaissance = jQuery("#dateNaissance").val();
    chemin="/getCandidat/"+examen+"/"+session+"/"+numeroPV+"/"+dateNaissance;
    if(examen!="" && session!="" && numeroPV!=""){
        jQuery.ajax({
            type:"GET",
            url:chemin,
            data:"",
            dataType: "html",
            success: function(server_response){
                jQuery("#"+affichage).html(server_response).show();
            },
            error: function(server_response){
                Notification('Erreur lors de la récupération des données');
            }
        });
    }else{
        Notification("Sélectionner l'examen, la session puis saisir le numeroPV");
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

function getNoteExamen(id,affiche){
    
    var numPV = jQuery('#'+id).val();
    var session = jQuery('#session').val();
    var chemin="/getNoteExamen/"+numPV+"/"+session;
    console.log(chemin);
    if(Number(numPV)!=0){
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



function getDonneesSaisir(url,idLoc,idThematique,anneeCollect,affiche,rub, srub){
        var chemin;
        var localite = jQuery('#'+idLoc).val();
        var thematique = jQuery('#'+idThematique).val();
        var annee = jQuery('#'+anneeCollect).val();
        var rb =jQuery('#'+rub).val();
        var srb =jQuery('#'+srub).val();
        var urlAnnuler= "/saisieValeurIndicateurLocalite/" + rb + "/" + srb;
        if(localite!='' && thematique!='' && annee!=''){
                chemin = "/"+url +'/'+localite +'/'+ thematique +'/'+annee;
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
                    jQuery("#retour").html(`<a href="${urlAnnuler}" class="btn btn-secondary">Annuler</a>`).show();
                },
                error: function(server_response){
                    Notification('Aucune donnée selectionnée');
                }
            });
        }
    } 

    //enregistrement individuel
    function enregIndiv(id){       
        var value = $("#valeur_"+id).val();
        var localite_id = $("#localite_"+id).val();
        var indicateur_id = $("#indicateur_"+id).val();
        var anneeCollect = $("#anneeCollect_"+id).val();
        var chemin;
         
        if(localite_id!='' && indicateur_id!='' && value!=''){  
           chemin = "/saisieValeurIndicateurLocaliteIndivuelle";
            jQuery.ajax({
                type:"POST",
                url:chemin,
                data: { 
                        'valeur': value,
                        'localite_id' : localite_id,
                        'indicateur_id' : indicateur_id,
                        'anneeCollect' : anneeCollect,
                 },
                
                beforeSend: function () {
                    jQuery("#td_enreg_"+id).html('');
                },
                success: function( ){
                },
                complete: function () {
                    jQuery("#td_enreg_"+id).html('<i style="color:green;" class="fa fa-check-circle fa-lg" aria-hidden="true"></i>');
                },
                error: function(xhr){
                    console.log(xhr.responseText);  // ← affiche le message d’erreur
                    //Notification('Aucune donnée selectionnée');
                }
            });
        } 
    }
    
    //affiche les infos du fournisseur
    function getInfoFournisseur(fournisseur_id){
            const fournisseurId = $("#"+fournisseur_id).val();
            var chemin = "/getFournisseurById/"+fournisseurId;
            console.log(chemin);
            if (fournisseurId) {
                $.ajax({
                    url: chemin,
                    type: 'GET',
                    success: function(data) {
                        $('#telephoneFournisseur').val(data.telephone);
                        $('#numeroIdentifiant').val(data.numero);
                    }
                });
            }
    }

     //affiche les infos du magasin
    function getInfoMagasin(magasin_id){
            const magasinId = $("#"+magasin_id).val();
            var chemin = "/getMagasinById/"+magasinId;
            console.log(chemin);
            if (magasinId) {
                $.ajax({
                    url: chemin,
                    type: 'GET',
                    success: function(data) {
                        $('#capacite').val(data.capacite);
                    }
                });
            }
    }

    //afficher les infos articles en fonction du type article
    function getInfosArticle(typeArticle_id){
        var chemin;
        var typeArticleId = jQuery('#'+typeArticle_id).val();
        chemin = "/getTypeArticleById/"+typeArticleId;
        console.log(chemin);
        if(typeArticleId){
            jQuery.ajax({
                type:"GET",
                url:chemin,
                success: function(data) {
                    console.log(data);
                    $('#article_id').html(data);    
                    },
                error: function(server_response){
                    Notification('Aucune donnée selectionnée');
                }
            });
        }
    } 

    //afficher la quantité du stock en fonction de l'article choisi
    function getInfoQte(article_id){
        const articleId = jQuery("#"+article_id).val();
            var chemin = "/getQteRestantById/"+articleId;
            console.log(chemin);
            if (articleId) {
                $.ajax({
                    url: chemin,
                    type: 'GET',
                    success: function(data) {
                        $('#qteRestant').val(data.quantiteRest);
                        $('#prixUnitaire').val(data.prixUnit);

                    }
                });
            }
    }

    //afficher le stock en fonction du nom du magasin
    
    function getInfoStock(magasin_id){
        var magasinId= $("#"+magasin_id).val();
        var chemin ="/getInfoMagasinById/"+magasinId;
        console.log(chemin);
        if (magasinId) {
                $.ajax({
                    url: chemin,
                    type: 'GET',
                    success: function(data) {
                    //console.log(data)
                    if (Array.isArray(data)){
                        $('#stockBody').html('');
                        var table=$('#example').DataTable();
                        table.destroy();
                        for(const produit of data){

                            $('#stockBody').append('<tr>'+
                                                        '<td>'+ produit.libelleTypeArticle +'</td>'+
                                                        '<td>'+ produit.libelleArticle +'</td>'+
                                                        '<td>'+ produit.qteRestant +'</td>'+
                                                    '</tr>');
                            console.log(produit)
                        }
                        $('#example').DataTable();  
                    }              
            },     
            });
        } else{
        $('#stockBody').html('');
        }       
    }

    //ajouter une ligne article

    function getArticleForm(idForm,form_url, affiche){
        var valeurs = $('select[name="'+idForm+'"]').map(function() {
            return $(this).val();
        }).get();

        $.ajax({
            url : form_url+"/"+valeurs,
            type: 'GET',
            data : valeurs,
            success: function(server_response){
                jQuery("#"+affiche).append(server_response).show();
            },
            error: function(server_response){
                //Notification('Une erreure est survenue!!','error');
            }
        });
       // Notification('Veuillez renseigner tous les champs obligatoire','error');      
    }

    