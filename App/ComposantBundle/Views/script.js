function formComposant(id_composant = 0) {
    if(!$.isNumeric(id_composant) || id_composant == 0) {
        id_composant = null;
    }
    $.ajax({
        type: "POST",
        url: "index.php?p=composant&a=get",
        data: {
            action: "getComposantModal",
            id: id_composant
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

    var tableComposants = $("#tableComposants").DataTable({
            language: {
                aria: {
                    sortAscending: ": trier par ordre croissant",
                    sortDescending: ": trier par ordre d\351croissant",
                },
                emptyTable: "Aucun composant n'a \351t\351 trouv\351",
                info: "Affichage de _START_ \340 _END_ sur _TOTAL_ composants",
                infoEmpty: "Aucune donn\351e n'a \351t\351 trouv\351e",
                infoFiltered: "(filtr\351 \340 partir de _MAX_ composants)",
                lengthMenu: "Afficher _MENU_",
                search: "Rechercher dans les composants :",
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
