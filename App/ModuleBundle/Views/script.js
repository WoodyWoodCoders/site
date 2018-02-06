function formModule(id_module = 0) {
    if(!$.isNumeric(id_module) || id_module == 0) {
        id_module = null;
    }
    $.ajax({
        type: "POST",
        url: "index.php?p=module&a=get",
        data: {
            action: "getModuleModal",
            id: id_module
        },
        success: function(data) {
            data = $.parseJSON(data);
            if(checkIfNoError(data)) {
                setContentModal(data.content);
                $("#moduleComposants").select2({
                    width: "100%"
                });

                openModal();
            }
        }
    });
}

$(document).ready(function() {

    var tableModules = $("#tableModules").DataTable({
            language: {
                aria: {
                    sortAscending: ": trier par ordre croissant",
                    sortDescending: ": trier par ordre d\351croissant",
                },
                emptyTable: "Aucun module n'a \351t\351 trouv\351",
                info: "Affichage de _START_ \340 _END_ sur _TOTAL_ modules",
                infoEmpty: "Aucune donn\351e n'a \351t\351 trouv\351e",
                infoFiltered: "(filtr\351 \340 partir de _MAX_ modules)",
                lengthMenu: "Afficher _MENU_",
                search: "Rechercher dans les modules :",
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
