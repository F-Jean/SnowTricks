$(function() {

    let page = 1;

    $(".comment-load-more").click(function(e)
    {
        e.preventDefault();
        page++;

        $.ajax({
            url : '/comment_load_more/' + page,
            method: 'GET',
            dataType: 'html',
            success : function(code_html, statut)
            {
                $(code_html).appendTo(".comment-list");
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