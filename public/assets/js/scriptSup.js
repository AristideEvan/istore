//inclusion du token dans toutes les requetes ajax
jQuery.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    }
});

function confirmDelete(url, successCallback = null) {
    console.log("test "+url);
    swal({
      title: "Êtes-vous sûr ?",
      text: "Cette action est irréversible.",
      icon: "warning",
      buttons: {
        cancel: {
          text: "Annuler",
          visible: true,
          className: "btn btn-danger",
        },
        confirm: {
          text: "Oui, supprimer !",
          className: "btn btn-success",
        },
      },
    }).then((willDelete) => {
        if(willDelete){
            jQuery.ajax({
                url:url,
                type: 'POST',
                data: { _method: 'DELETE' },
                success: function(response){
                    swal("Supprimé !", response.message || "L'élément a été supprimé.", {
                        icon: "success",
                        buttons: {
                          confirm: {
                            className: "btn btn-success"
                          }
                        }
                    });
                    if (typeof successCallback === 'function') {
                        successCallback();
                    }
                },
                error: function(xhr){
                    swal("Erreur", "La suppression a échoué.", {
                        icon: "error",
                        buttons: {
                          confirm: {
                            className: "btn btn-danger"
                          }
                        }
                    });
                }
            })
        }
    });
}
      