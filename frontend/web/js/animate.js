$( document ).ready( function(){
    /* $("#submitBtn").prop("value", "");*/
    // $('#auth_code').hide();
    $('input[type=radio][id="trxOptn"]').change(function() { 
        var radioSel= $('input[id="trxOptn"]:checked').val();
        if(radioSel ==1) {
            $("#domain").prop('placeholder','Enter upto 50 comma seperated possible domains. e.g. xyz.com, abc.org');
            $("#submitBtn").prop("value", "Check Domain Avaiability");
            // $('#auth_code').hide();
        } else if(radioSel ==2 ) {
            $("#domain").prop('placeholder','Enter comma seperated keywords for your domain e.g. space, cat, geranium');
            $("#submitBtn").prop("value", "Search for a Domain");
            // $('#auth_code').hide();
        } else if(radioSel ==6) {
            $("#domain").prop('placeholder','Enter a valid domain. e.g. abcxyz.com');
            $("#submitBtn").prop("value", "Show Domain Details");
            // $('#auth_code').hide();
            
        }  else if(radioSel ==7) {
            $("#domain").prop('placeholder','Enter a valid domain. e.g. abcxyz.com');
            $("#submitBtn").prop("value", "Transfer a Domain In");
            // $('#auth_code').show();
            
            
        }

    }); 
    $('#submitBtn').click(function(){
        var myAuthCode = $('#eppcode').val();
        var radioSel= $('input[name="trxOptn"]:checked').val();
        var mydomain=$('#domain').val();
        if( radioSel==7 && !($mydomain) && !(myAuthCode) ){
            alert("There must be a domain and a value for EPP Code");
            $("#confirmDomain").prop('checked',true);
            $("#submitBtn").prop("value", "Transfer a Domain In");
            $('#domain').focus();
        }else if (!mydomain && radioSel==6   ){
            alert("There must be a valid domain indicated");
            $("#submitBtn").prop("value", "Show Domain Details");
            $("#showDomain").prop('checked',true);
            $('#domain').focus();
        }else if (!mydomain && radioSel==2   ){
            alert("There must be some keywords indicated");
            $("#search").prop('checked',true);
            $("#submitBtn").prop("value", "Search for a Domain");
            $('#domain').focus();
        }else if (!mydomain && radioSel==1   ){
            alert("There must be some valid domains indicated");
            $("#submitBtn").prop("value", "Check Domain Avaiability");
            $("#confirmDomain").prop('checked',true);
            $('#domain').focus();
        }

    });   
});