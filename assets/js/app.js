/*
* Welcome to your app's main JavaScript file!
*
* We recommend including the built version of this JavaScript file
* (and its CSS file) in your base layout (base.html.twig).
*/

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

import 'select2'; // globally assign select2 fn to $ element
import 'select2/dist/css/select2.css'; // optional if you have css loader

$(() => {
    let select_element = $('.select2');
    select_element.select2();

    select_element.select2({
        maximumSelectionLength: select_element.data('max-count'),
        tags: true
    });
});

require('bootstrap/dist/js/bootstrap.bundle');

// console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

$(document).ready(function () {
    $('[data-toggle="popover"]').popover();
});

/* Querys pour la map */
var map = document.querySelector('#map');
var paths = document.querySelectorAll('.map__image a');
var links = document.querySelectorAll('.map__list a');


// Polyfill pour foreach dispo tout navigateur pour nodelist (d'habitude pour tableaux uniquement)
if (NodeList.prototype.forEach === undefined) {
    NodeList.prototype.forEach = function (callback) {
        [].forEach.call(this, callback);
    }
}

var activeArea = function (id) {

    map.querySelectorAll('.is-active').forEach(function (item) {
        item.classList.remove('is-active');
    });
    if (id !== undefined) {
        document.querySelector('#list-' + id).classList.add('is-active');
        document.querySelector('#region-' + id).classList.add('is-active');
    }

};

paths.forEach(function (path) {
    path.addEventListener('mouseenter', function () {
        var id = this.id.replace('region-', '');
        activeArea(id);
    });
});

links.forEach(function (link) {
    link.addEventListener('mouseenter', function () {
        var id = this.id.replace('list-', '');
        activeArea(id);
    });
});

map.addEventListener('mouseover', function () {
    activeArea();
});