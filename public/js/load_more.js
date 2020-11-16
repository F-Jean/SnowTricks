$(function() {

    let page = 1;

    $(".load").click(function(e)
    {
        e.preventDefault();
        page++;

        $.ajax({
            url : '/load_more/' + page,
            method: 'GET',
            dataType: 'html',
            success : function(code_html, statut)
            {
                $(code_html).appendTo(".trick-list");
            },
            error: function(resultat, statut, erreur)
            {

            },
            complete : function(resultat, statut)
            {

            }
        });
    });
});