$(document).ready(function(){
  $('#loginForm').submit(function(){
    $check = 0;
    $('.form-group').removeClass('has-error');

    if($('#txtUsername').val()==""){
      $('#txt1').addClass('has-error');
      $check++;
    }

    if($('#txtEmail').val()==""){
      $('#txt2').addClass('has-error');
      $check++;
    }

    if($('#txtPassword').val()==""){
      $('#txt3').addClass('has-error');
      $check++;
    }

    if(($('#txtPassword').val().length < 6) || ($('#txtPassword').val().length > 15)){
      $('#txt3').addClass('has-error');
      $check++;
    }

    if($check!=0){
      return false;
    }else{
      $.post("core/register.php", {
          username: $('#txtUsername').val(),
          password: $('#txtPassword').val(),
          email: $('#txtEmail').val()
          },
          function(result){
            if(result=='Y'){
              window.location = 'core/redirecuser.php';
            }else{
              // $('#txtUsername').val(result);
              alert(result);
            }
          }
      );  //End post
      return false;
    }

  });
});
