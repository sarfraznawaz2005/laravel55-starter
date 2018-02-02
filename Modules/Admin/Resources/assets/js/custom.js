/**
 * Created by Sarfraz on 10/18/2016.
 *
 * Custom Javascript for the app.
 *
 */

$(function () {

    // to toggle admin sidebar
    $('.navbar-toggle-sidebar').click(function () {
        $('.navbar-nav').toggleClass('slide-in');
        $('.side-body').toggleClass('body-slide-in');
    });

});

