function myFunction(x,y,z,sid,mobile){
  //alert(y);
document.getElementById("loading"+z).style.display = 'block';
document.getElementById("chk"+z).style.display='none';
var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("loading"+z).style.display = 'none';
      //document.getElementById("chk"+z).style.display='block';
      
      var response = JSON.parse(event.target.responseText);
      if(response.message=="Bill Updated at Biller"){
        document.getElementById("chk_img"+z).style.display='block';
    }
    else{
      document.getElementById("chk"+z).style.display='block';
    }
    }
  };
  xhttp.open("POST", "status_check.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  var params = 'account='+x+'&tid='+y+'&sid='+sid+'&mobile=0&op_selector=88';
  xhttp.send(params);
}
