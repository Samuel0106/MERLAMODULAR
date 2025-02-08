$(document).ready(function() {

    $('.translate-table').DataTable({
        responsive: true,
        autoWidth: false,
        lengthMenu: [[25, 50, -1], [25, 50, "Todos"]],
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar: ",
            "paginate": {
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });

});