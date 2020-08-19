/*globale console, alert*/
/*eslint-env browser*/

var
    user,
    pass;



function change() {
    // "use strict"
    user = document.getElementById("username");
    pass = document.getElementById("pass");
    var req = new XMLHttpRequest();
    req.onreadystatechange = function(){
        if(req.status == 200 & req.readyState == 4){
          //alert(req.status+"  "+req.readyState);
            var res = req.responseText;
            switch(res){
                case 'login success':
                    alert('login successs');
                    window.location.href = './resources/svgTool.html';
                    break;
                default:
                    alert(res);
                    break;
            }
        } else{
            console.log(req.status);
        }
    }

    req.open('POST',"./resources/checkUser.php",true);
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    req.send("user=" + user.value + "&pass=" + pass.value );
}
