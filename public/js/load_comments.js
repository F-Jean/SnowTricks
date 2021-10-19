$(function() {

    let page = 1;

    $(".load-comments").click(function(e)
    {
        e.preventDefault();
        page++;

        const trickId = $('.comments-list').data('trick');


        $.ajax({
            url : '/load_comments/' + trickId + '/' + page,
            method: 'GET',
            dataType: 'html',
            success : function(code_html, statut)
            {
                if(code_html == "") {
                    $('.load-comments').hide();
                } else {
                    $(code_html).appendTo(".comments-list");
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