function myFunction(){
let phn=document.getElementById('mobile');
let psw=document.getElementById('password');
let btn=document.getElementById('btn-submit');
let modal=document.getElementById('exampleModalCenter');
let alertText=document.getElementById('alertText');
var login_form = document.getElementById("login-form");
let validPHN=false;
let validPSW=false;
validate();

/*phn.addEventListener("focusin",(event)=>{
  phn.style.boxShadow= "0 0 10px red";
});
phn.addEventListener("focusout",(event)=>{
  phn.style.boxShadow= "0 0 0px red";
});

psw.addEventListener("focusin",(event)=>{
  psw.style.boxShadow= "0 0 10px red";
});

psw.addEventListener("focusout",(event)=>{
  psw.style.boxShadow= "0 0 0px red";
});*/

phn.addEventListener("input",(event)=>{
  if(phn.value.length==10){
    phn.style.boxShadow= "0 0 10px green";
    validPHN=true;
    validate();
  }
  else {
    validPHN=false;
    validate();
    phn.style.boxShadow= "0 0 10px red";
    btn.disabled=true;
    btn.style.backgroundColor="#dddddd";

  }
});

psw.addEventListener("input",(event)=>{
  if(psw.value.length>=6 && psw.value.length<=15){
    psw.style.boxShadow= "0 0 10px green";
    validPSW=true;
    validate();
  }
  else{
    validPSW=false;
    validate();
    psw.style.boxShadow= "0 0 10px red";
    btn.disabled=true;
    btn.style.backgroundColor="#dddddd";
  }
});
function validate(){
  if(validPSW && validPHN){
  btn.disabled=false;
  btn.style.backgroundColor="#4CAF50";
  btn.addEventListener("mouseover",(event)=>{
    btn.style.backgroundColor="GREEN";
  });
  btn.addEventListener("mouseout",(event)=>{
    btn.style.backgroundColor="#4CAF50";
  });
  btn.addEventListener("focusin",(event)=>{
    btn.style.border="2px black solid";
  });
  btn.addEventListener("focusout",(event)=>{
    btn.style.border="none";
  });
  }

  else if(!validPHN && !validPSW){
    btn.disabled=true;
    btn.style.backgroundColor="#dddddd";

  }

}



    login_form.addEventListener("submit", function (event) {
      btn.style.display="none";
        var XHR = new XMLHttpRequest();
        var form_data = new FormData(login_form);

        // On success
        XHR.addEventListener("load", login_success);

        // On error
        XHR.addEventListener("error", on_error);

        // Set up request
        XHR.open("POST", "api/login.php");

        // Form data is sent with request
        XHR.send(form_data);

        document.getElementById("loading").style.display = 'block';
        event.preventDefault();
    });






   //add code corresponding to login form as a part of your assignment

var login_success = function (event) {
    document.getElementById("loading").style.display = 'none';
    btn.style.display='block';

    var response = JSON.parse(event.target.responseText);
    if (response.success) {
      window.location.href = "bill.php";

        //alertText.innerHTML=response.message;
        //window.$("#exampleModalCenter").modal("show");


    } else {
      alertText.innerHTML=response.message;
        window.$("#exampleModalCenter").modal("show");
    }
};

//add function corresponding to login_success as a part of your assignment

var on_error = function (event) {
    document.getElementById("loading").style.display = 'none';
    alertText.innerHTML=response.message;

    window.$("#exampleModalCenter").modal("show");
};
}



/*if(phn.value.length==10){
  btn.disabled=false;
  phn.style.borderColor="green";
  phn.style.boxShadow= "0 0 10px green";
  btn.style.backgroundColor="green";
}
else{
  btn.disabled=true;
  btn.style.backgroundColor="#dddddd";
  phn.style.boxShadow= "0 0 10px red";

}
if(psw.value.length>=6 && psw.value.length<=20){
  psw.style.borderColor="green";
  psw.style.boxShadow= "0 0 10px green";
}
else{
  btn.disabled=true;
  btn.style.backgroundColor="#dddddd";
  psw.style.boxShadow="0 0 10px red";

}
}*/
