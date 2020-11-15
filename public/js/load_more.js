$(function() {
    $(".load").click(function(e)
    {
        e.preventDefault();
        $.ajax({
            url : '/load_more',
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