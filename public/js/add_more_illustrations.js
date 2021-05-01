// ADD MORE ILLUSTRATIONS

jQuery(document).ready(function() {
    // Get the ul that holds the collection of illustrations & videos
    var $illustrationsCollectionHolder = $('ul.illustrations');
    var $videosCollectionHolder = $('ul.videos');
    // count the current form inputs we have, use that as the new
    // index when inserting a new item
    $illustrationsCollectionHolder.data('index', $illustrationsCollectionHolder.find('input').length);
    $videosCollectionHolder.data('index', $videosCollectionHolder.find('input').length);

    $('body').on('click', '.add_item_link', function(e) {
        var $collectionHolderClass = $(e.currentTarget).data('collectionHolderClass');
        // add a new illustration form
        addFormToCollection($collectionHolderClass);
    });
});

function addFormToCollection($collectionHolderClass) {
    // Get the ul that holds the collection of illustrations
    var $collectionHolder = $('.' + $collectionHolderClass);

    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your illustrations field in TrickType
    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add an illustration" link li
    var $newFormLi = $('<li></li>').append(newForm);
    // Add the new form at the end of the list
    $collectionHolder.append($newFormLi);
}

// DELETE ILLUSTRATIONS & VIDEOS BUTTON IN ADDTRICK.HTML

$("body").on("click", ".delete_btn", function(e) {
    $(e.currentTarget).closest("li").remove();
    $("#media-container").parent().remove();
});

// DISPLAY ILLUSTRATION AFTER SELECT