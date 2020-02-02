// setup an "add a tag" link
var $addPlaceLink = $('<a href="#" class="btn btn-primary add_tag_link">Ajouter des places</a>');
var $newLinkLi = $('<li></li>').append($addPlaceLink);

$(document).ready(function () {

    // Get the ul that holds the collection of tags
    var $collectionHolder = $('ul.places');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have, use that as the new
    // index when inserting a new item
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    addPlaceFormWithoutRemove($collectionHolder, $newLinkLi);

    $addPlaceLink.on('click', function (e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see code block below)
        addPlaceFormWithRemove($collectionHolder, $newLinkLi);
    });
});

function addPlaceFormWithRemove($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a place" link li
    var $newFormLi = $('<li></li>').append(newForm);

    // also add a remove button, just for this example
    $newFormLi.append('<a href="#" class="btn btn-warning remove-place pull-right">x</a>');
    $newFormLi.append('<br/>');
    $newFormLi.append('<br/>');

    $newLinkLi.before($newFormLi);

    // handle the removal, just for this example
    $('.remove-place').click(function (e) {
        e.preventDefault();

        $(this).parent().remove();

        return false;
    });
}

function addPlaceFormWithoutRemove($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a place" link li
    var $newFormLi = $('<li></li>').append(newForm);

    $newLinkLi.before($newFormLi);
}