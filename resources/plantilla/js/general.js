$(document).ready(function(){
  $('.fixed-action-btn').floatingActionButton();
  $('.sidenav').sidenav();
  $('.modal').modal({
   dismissible: false
  });
  $('select').formSelect();
  $('#dni, #celular').characterCounter();
  $('#textarea1').val();
  $('.tabs').tabs();
  $('.datepicker').datepicker();
  $('.timepicker').timepicker();
  $('.dropdown-trigger').dropdown({
   constrainWidth:false,
   coverTrigger:false
  });
  $('.tooltipped').tooltip();
});
