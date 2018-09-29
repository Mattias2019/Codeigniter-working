
var jq=$.noConflict();

jq(document).ready(function()
{
	

jq(".edit_tr").live('click',function()
{
var ID=jq(this).attr('id');

jq("#one_"+ID).hide();
jq("#two_"+ID).hide();
jq("#three_"+ID).hide();

jq("#six_"+ID).hide();
jq("#seven_"+ID).hide();
jq("#eight_"+ID).hide();
jq("#nine_"+ID).hide();


jq("#one_input_"+ID).show();
jq("#two_input_"+ID).show();
jq("#three_input_"+ID).show();

jq("#six_input_"+ID).show();
jq("#seven_input_"+ID).show();
jq("#eight_input_"+ID).show();
jq("#nine_input_"+ID).show();

}).live('change',function(e)
{
var ID=jq(this).attr('id');

var one_val=jq("#one_input_"+ID).val();
var two_val=jq("#two_input_"+ID).val();
var three_val=jq("#three_input_"+ID).val();

var six_val=jq("#six_input_"+ID).val();
var seven_val=jq("#seven_input_"+ID).val();
var eight_val=jq("#eight_input_"+ID).val();
var nine_val=jq("#nine_input_"+ID).val();


var dataString = 'id='+ ID +'&catname='+one_val+'&group='+two_val+'&des='+three_val+'&pg_ti='+six_val+'&meta_key='+seven_val+'&meta_des='+eight_val+'&act='+nine_val;


if(one_val.length != 0&& two_val.length!=0 && three_val.length!=0)
{

$.ajax({
type: "POST",
url: "https://consult24online.com/index.php/administration/skills/cate_edit",
data: dataString,
cache: false,
success: function(e)
{

jq("#one_"+ID).html(one_val);
jq("#two_"+ID).html(two_val);
jq("#three_"+ID).html(three_val);

jq("#six_"+ID).html(six_val);
jq("#seven_"+ID).html(seven_val);
jq("#eight_"+ID).html(eight_val);
jq("#nine_"+ID).html(nine_val);

e.stopImmediatePropagation();

}
});
}
else
{
alert('Enter something.');
}

});

// Edit input box click action
jq(".editbox").live("mouseup",function(e)
{
e.stopImmediatePropagation();
});

// Outside click action
jq(document).mouseup(function()
{

jq(".editbox").hide();
jq(".text").show();
});
			
			

});