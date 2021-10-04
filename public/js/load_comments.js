$(function() {

    let page = 1;

    $(".load-comments").click(function(e)
    {
        e.preventDefault();
        page++;

        $.ajax({
            url : '/load_comments/' + page,
            method: 'GET',
            dataType: 'html',
            success : function(code_html, statut)
            {
                if(code_html < 4) {
                    $('.load-comments').hide();
                } else {
                    $(code_html).appendTo(".comment-list");
                }
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