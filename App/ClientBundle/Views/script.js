function formClient(id_client = 0) {
    if(!$.isNumeric(id_client) || id_client == 0) {
        id_client = null;
    }
    $.ajax({
        type: "POST",
        url: "index.php?p=client&a=get",
        data: {
            action: "getClientModal",
            id: id_client
        },
        success: function(data) {
            data = $.parseJSON(data);
            if(checkIfNoError(data)) {
                setContentModal(data.content);
                openModal();
            }
        }
    });
}

$(document).ready(function() {

    var tableClients = $("#tableClients").DataTable({
            language: {
                aria: {
                    sortAscending: ": trier par ordre croissant",
                    sortDescending: ": trier par ordre d\351croissant",
                },
                emptyTable: "Aucun client n'a \351t\351 trouv\351",
                info: "Affichage de _START_ \340 _END_ sur _TOTAL_ clients",
                infoEmpty: "Aucune donn\351e n'a \351t\351 trouv\351e",
                infoFiltered: "(filtr\351 \340 partir de _MAX_ clients)",
                lengthMenu: "Afficher _MENU_",
                search: "Rechercher dans les clients :",
                zeroRecords: "Aucun \351l\351ment correspondant \340 la recherche n'a \351t\351 trouv\351",
                paginate: {
                    previous: "Pr\351c\351dent",
                    next: "Suivant",
                    last: "Dernier",
                    first: "Premier"
                }
            },
            bStateSave: !0,
            lengthMenu: [
                [5, 10, 15, 20, -1],
                ["par 5", "par 10", "par 15", "par 20", "tout"]
            ],
            // columnDefs: [{
            //     orderable: !1,
            //     targets: [0]
            // }, {
            //     searchable: !1,
            //     targets: [0]
            // }],
            order: [
                [1, "asc"]
            ]
        });
} );
