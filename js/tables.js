$.fn.dataTable.moment('DD/MM/YYYY HH:mm:ss');//('d/m/YYYY hh:mm:ss tt');
// Datatables


$(document).ready(() => {
    setTimeout(function () {
        $("#example").DataTable({
            "order": [[0, "desc"]],
            responsive: true,
            "columnDefs": [{
                "targets": 0,
                "render": function (data, type, row, meta) {
                    return moment(data, 'YYYY/MM/DD HH:mm:ss ').format('DD/MM/YYYY HH:mm:ss');
                }
            }],
            "language": {
                "search": "Rechercher :",
                "info": "_START_ à _END_ sur _TOTAL_ lignes",
                "lengthMenu": "Lignes : _MENU_",
                "paginate": {
                    "previous": "Précédent",
                    "next": "Suivant",
                    "first": "Premier",
                    "last": "Dernier",
                }
            }
        });
        $("#example2").DataTable({
            responsive: true,
            "language": {
                "search": "Rechercher :",
                "info": "_START_ à _END_ sur _TOTAL_ lignes",
                "lengthMenu": "Lignes : _MENU_",
                "paginate": {
                    "previous": "Précédent",
                    "next": "Suivant",
                    "first": "Premier",
                    "last": "Dernier",
                }
            }
        });
        $("#example3").DataTable({
            responsive: true,
            "language": {
                "info": "_START_ à _END_ sur _TOTAL_ lignes",
                "search": "Recherche :",
                "lengthMenu": "Lignes : _MENU_",
                "paginate": {
                    "previous": "Précédent",
                    "next": "Suivant",
                    "first": "Premier",
                    "last": "Dernier",
                }
            }
        });

        $("#example").show();
    }, 2000)
});
