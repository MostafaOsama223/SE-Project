/*globale console, alert*/
/*eslint-env browser*/

var user_in_reg, pass_in_reg, confirm_pass;
var fist_name ,last_name ,email;

function gotoLogin(){
  window.location.href = "../index.html";
}

function register() {
  //  "use strict";

  user_in_reg  = document.getElementById("username_in_reg");
  pass_in_reg  = document.getElementById("pass_in_reg");
  confirm_pass = document.getElementById("confirm_password");
  first_name   = document.getElementById("firstname");
  last_name   = document.getElementById("lastname");
  email        = document.getElementById("Email_Address");


if(pass_in_reg.value != confirm_pass.value)
  alert("You entered two different passwords, Try again!");
  //document.getElementById("alert2").innerHTML = "You entered two different passwords, Try again!";
else // alert("sucsses!");
{
    //alert();
    var req = new XMLHttpRequest();
    req.onreadystatechange = function(){
      //alert(req.status+"  "+req.readyState);
      if(req.status == 200 & req.readyState == 4){
        var res = req.responseText;
        switch(res){
          case 'this user_name is already existed':
          alert('this user_name is already existed');
          break;
          case 'New account is created successfully' :
          alert('New account is created successfully');
          window.location.href = "../index.html";
          break;
          case 'this email is already existed':
          alert('this email is already existed');
          break;
          case'Error:':
          alert('Error:');
          break;
          default:
          alert(res);
          break;
        }
      } else{
        console.log(req.status);
      }
    }
    req.open('POST',"../resources/checkUser.php",true);
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    req.send("user_in_reg=" + user_in_reg .value + "&pass_in_reg=" + pass_in_reg.value +"&first_name=" +first_name.value +"&last_name="+last_name.value +"&email="+email.value);

}

}
