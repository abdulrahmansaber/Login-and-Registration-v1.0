$(function () {

  $('*[unselectable=on]').mousedown(function(event) {
    event.preventDefault();
    return false;
  });

});
