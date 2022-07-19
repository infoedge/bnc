$(document).ready(function(){
    $('input[name^="contbox"]').click(function() {
        var thebox = $(this).val();
        var inpName = "conttxt[" + thebox + "]";
        var hidName = "conttxt-s[" + thebox + "]";
        var nsvrcnt = parseInt($('#chgRegDtlsCnt').val());
        if ($(this).is(':checked')) {
            
            //alert("you have Checked:" + thebox);
            $('[id="'+ inpName+'"]').prop('disabled','' );
            $('#chgRegDtlsBtn').prop('disabled','');
            nsvrcnt+=1;
            $('#chgRegDtlsCnt').val(nsvrcnt.toString());
        } else {
            $('[id="'+ inpName+'"]').prop('disabled','disabled' );
            $('[id="'+ inpName+'"]').val($('[id="'+ hidName+'"]').val());
            nsvrcnt-=1;
            $('#chgRegDtlsCnt').val(nsvrcnt.toString());
            
            if($('#chgRegDtlsCnt').val()=="0"){
                $('#chgRegDtlsBtn').prop('disabled','disabled');
            }
        }
      });
      $('input[id^="nsvrbox"').click(function(){
        var thebox = $(this).val();
        var inpName = "nsvrtxt[" + thebox + "]";
        var hidName = "nsvrtxt-s[" + thebox + "]";
        var nsvrcnt = parseInt($('#chgNameSvrCnt').val());
        if ($(this).is(':checked')) {
            
            //alert("you have Checked:" + inpName);
            $('[id="'+ inpName+'"]').prop('disabled','' );
            $('#chgNameSvrBtn').prop('disabled','');
            nsvrcnt+=1;
            $('#chgNameSvrCnt').val(nsvrcnt.toString());
        } else {
            $('[id="'+ inpName+'"]').prop('disabled','disabled' );
            $('[id="'+ inpName+'"]').val($('[id="'+ hidName+'"]').val());
            nsvrcnt-=1;
            $('#chgNameSvrCnt').val(nsvrcnt.toString());
            
            if($('#chgNameSvrCnt').val()=="0"){
                $('#chgNameSvrBtn').prop('disabled','disabled');
            }
        }
      });
      $('input[id^="chkbox"]').click(function(){  
        var boxval= $(this).val();
        var inpvar  = "avalue-" + boxval ;
        var addValue = $('[id="' + inpvar + '"]').val();
        if ($(this).is(':checked')) {
            //alert('add Value = ' + addValue);
            var calcTot = (parseFloat($('#theCalcTotal').val()) + parseFloat(addValue)).toFixed(2)  ;
            //alert("You have added $" + calcTot);
            $('#theCalcTotal').val(calcTot.toString()) ;
            $('#calc_total').html(calcTot.toString());
        } else {
            var calcTot = (parseFloat($('#theCalcTotal').val()) - parseFloat(addValue)).toFixed(2)  ;
            //alert("You have added $" + calcTot);
            $('#theCalcTotal').val(calcTot.toString()) ;
            $('#calc_total').html(calcTot.toString());
        }
      });
    
});