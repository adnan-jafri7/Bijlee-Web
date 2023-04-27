function fetch(){
    let btn_fetch=document.getElementById("btn-fetch");
    let fetch_form=document.getElementById("fetch-form");
    let btn_pay_bill=document.getElementById("btn-pay-bill");
    let btn_cancel=document.getElementById("btn-cancel");
    let account=document.getElementById("account");
    let modal=document.getElementById("myModal");
    let mobile=document.getElementById("mobile");
    let customerName=document.getElementById("customerName");
    let billDate=document.getElementById("billDate");
    let dueDate=document.getElementById("dueDate");
    let amount=document.getElementById("amount");
    let sid=document.getElementById("sid").value;
    let bill_number="";
    let min_amount="";
    let operator="";
    let biller_id=document.getElementById("op_selector");
    let bill_fetched_data=document.getElementsByClassName("bill_fetched_data");
    let form_container=document.getElementsByClassName("form-container");
    var biller_id_value = biller_id.options[biller_id.selectedIndex].value;
    let loading=document.getElementById("loading");
    let validACC=false;
    let validOPR=false;

    btn_fetch.disabled=true;
    btn_fetch.style.backgroundColor="#dddddd";

    account.addEventListener("input",(event)=>{
      if(account.value.length>7){
        account.style.boxShadow="0 0 10px green";
        btn_fetch.disabled=false;
        btn_fetch.style.backgroundColor="#0dbf3d"
}
else {
        account.style.boxShadow="0 0 10px red";
        btn_fetch.disabled=true;
        btn_fetch.style.backgroundColor="#dddddd";


  }
    });
    biller_id.addEventListener("change",(event)=>{
      biller_id_value = biller_id.options[biller_id.selectedIndex].value;
      if(biller_id_value==0){
        biller_id.style.boxShadow="0 0 10px red";
      }
      else{
        biller_id.style.boxShadow="0 0 10px green";
      }
    });


    fetch_form.addEventListener("submit",function (event){
            if(biller_id_value==0){
              alert("Please sleect operator");
              biller_id.style.boxShadow="0 0 10px red";
            }
            else if(account.value.length<8){
              alert("Please enter correct account no");
              biller_id.style.boxShadow="0 0 10px red";
            }
            else{
            btn_fetch.style.display='none';
            loading.style.display='flex';
            var XHR = new XMLHttpRequest();
            var form_data = new FormData(fetch_form);
            

            // On success
            XHR.addEventListener("load", login_success);

            // On error
            XHR.addEventListener("error", on_error);

            // Set up request
            XHR.open("POST", "api/bbps_fetch3.php");

            // Form data is sent with request
            XHR.send(form_data);
            event.preventDefault();

            }
      });
      var login_success = function (event) {
        btn_fetch.style.display='block';
            loading.style.display='none';
          var response = JSON.parse(event.target.responseText);
          if(!response.success || response.status=="Failed"){
            modal.style.display='flex';
            document.getElementById("title-process").innerHTML=response.message
            document.getElementById("title-process").style.color="RED"
            document.getElementById("note-process").innerHTML=""
            document.getElementById("loading-pay").src="img/wrong.gif"
            document.getElementById("modal-close").style.display="block"
          }
          else{
            loading.style.display='none';
          btn_fetch.style.display='none';
          document.getElementById('bill-fetched-data').style.display='flex';
          document.getElementById('customerName').innerHTML=response.customer_name;
          customerName=response.customer_name;
          document.getElementById('dueDate').innerHTML=response.due_date;
          dueDate=response.due_date
          document.getElementById('billDate').innerHTML=response.bill_date;
          billDate=response.bill_date;
          document.getElementById('amount').value=response.amount;
          amount=response.amount;
          operator=response.provider;
          bill_number=response.bill_number
          min_amount=(amount*25)/100
          document.getElementById("note").innerHTML='Minimum Amount Allowed: &#x20B9;'+min_amount
          window.scrollTo(0, document.body.scrollHeight);

        }
      };
        document.getElementById("amount").addEventListener("input",(event)=>{          
          amount=document.getElementById("amount").value
          
        })
        document.getElementById("modal-close").addEventListener("click",(event)=>{
              modal.style.display='none'
            })
      var on_error = function (event) {
        modal.style.display='none';
        btn_fetch.style.display='block';
            loading.style.display='none';
          alert(response.message);
      };
      btn_cancel.addEventListener("click",(event)=>{
        document.getElementById('bill-fetched-data').style.display='none';
        btn_fetch.style.display='block';
      });
      btn_pay_bill.addEventListener("click",(event)=>{
        if(amount<min_amount){
            alert("Amount can't be lower than Minimum Amount.")
        }
        else{
        let text="Are you sure you want to pay the bill?"
        if(confirm(text)==true){
        //alert(modal)
        modal.style.display='flex';
        var XHR = new XMLHttpRequest();
         // On success
         XHR.addEventListener("load", pay_success);

         // On error
         XHR.addEventListener("error", on_error);

         // Set up request
         XHR.open("POST", "api/pay_bill.php");
         XHR.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );
         
         XHR.send("provider="+operator+"&due_amount="+amount+"&due_date="+dueDate+"&customer_name="+customerName+"&bill_date="+billDate+"&cus_mobile="+mobile.value+"&sid="+sid+"&bill_number="+bill_number+"&account="+account.value);
         event.preventDefault();
        }
        
        else{}
      }
        
      });
      var pay_success = function (event) {
         
          var response = JSON.parse(event.target.responseText);
          if(!response.success || response.status=="Failed"){
            document.getElementById("title-process").innerHTML="Something Went Wrong."
            document.getElementById("title-process").style.color="RED"
            document.getElementById("note-process").innerHTML="Please try again...."
            document.getElementById("loading-pay").src="img/wrong.gif"
            document.getElementById("modal-close").style.display="flex"
          
          }
          else if(response.success){
            let Tid=response.Tid
            document.getElementById("title-process").innerHTML="Bill Payment Successful."
            document.getElementById("title-process").style.color="#4CAF50"
            document.getElementById("note-process").innerHTML="Redirecting to Payment Receipt...."
            document.getElementById("loading-pay").src="check.svg"
            //alert(Tid)
            window.open(`/bijlee/bill-receipt.php?tid=${Tid}`)
            location.reload()          

        }
      };


}


