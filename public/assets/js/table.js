// appel du plugin dataTables jQuery

  jQuery('.dataTable').DataTable({
    "language": {
        "sProcessing": "Traitement en cours...",
        "sSearch": "Rechercher&nbsp;:",
        "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
        "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
        "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
        "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        "sInfoPostFix": "",
        "sLoadingRecords": "Chargement en cours...",
        "sZeroRecords": "Aucun &eacute;l&eacute;ment trouv&eacute;",
        "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
        "oPaginate": {
            "sFirst": "Premier",
            "sPrevious": "&lt;",
            "sNext": ">",
            "sLast": "Dernier"
        },
        "oAria": {
            "sSortAscending": ": activer pour trier la colonne par ordre croissant",
            "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
        }
    },
    responsive: true,
    "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tout"]],
    "ordering": false
});

$("#multi-filter-select").DataTable({
    pageLength: 5,
    initComplete: function () {
      this.api()
        .columns()
        .every(function () {
          var column = this;
          var select = $(
            '<select class="form-select"><option value=""></option></select>'
          )
            .appendTo($(column.footer()).empty())
            .on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              column
                .search(val ? "^" + val + "$" : "", true, false)
                .draw();
            });

          column
            .data()
            .unique()
            .sort()
            .each(function (d, j) {
              select.append(
                '<option value="' + d + '">' + d + "</option>"
              );
            });
        });
    },
  });

/* 
jQuery('#example').DataTable({
    "dom": '<"dt-buttons"Bf><"clear">lirtp',
    "paging": false,
    "autoWidth": true,
    "columnDefs": [
        { "orderable": true, "targets": 5 }
    ],
    "buttons": [
        'colvis',
        'copyHtml5',
        'csvHtml5',
        'excelHtml5',
        'pdfHtml5',
        'print'
    ]
}); */

