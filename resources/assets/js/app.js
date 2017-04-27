
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

hljs.initHighlightingOnLoad();

if ($('.alert')) {
    $('.alert').delay(5000).fadeOut();
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#back-to-top').on('click', function () {
    $('body,html').animate({
        scrollTop: 0
    }, 800);

    return false;
});

$(window).on('scroll', function () {
    var scrollPos = $(window).scrollTop();

    if (scrollPos > 50) {
        $('#back-to-top').fadeIn();
    } else {
        $('#back-to-top').fadeOut();
    }
});

/*

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});
*/
