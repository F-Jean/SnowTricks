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
                if(code_html == "") {
                    $('.load').hide();
                } else {
                    $(code_html).appendTo(".trick-list");
                }
            },
            error: function(resultat, statut, erreur)
            {

            },
            complete : function(resultat, statut)
            {

            }
        });

        if (page >= 3) {
            $('.btn-go-up').show();
        }
    });

    // Button to go back up the page
    const btn = document.querySelector('.btn-go-up');

    $('.btn-go-up').hide();
    btn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            left: 0,
            behavior: "smooth"
        })
    })
});
