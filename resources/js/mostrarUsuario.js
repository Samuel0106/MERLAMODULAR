$('.mostrar-usuario').click(function () {

    let id = $(this).parent().attr('data-id');

    window.location.href = `/dcj/users/${id}`;
    
});