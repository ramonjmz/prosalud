$(function() {
  	
$('.dropdown-toggle').dropdown()

$('.carousel').carousel()

$('.typeahead').typeahead()

window.customInitFunctions && $.map(window.customInitFunctions, function(item, index){
item();
});
});

function imprSelec(muestra)
{

	var ficha=document.getElementById(muestra);
	var ventimp=window.open('','printwin','');
	ventimp.document.write("<link  href='/css/bootstrap.css' media='print' rel='stylesheet' type='text/css' />	");
	ventimp.document.write("<link href='/css/bootstrap-responsive.css' media='screen' rel='stylesheet' type='text/css' />");
	ventimp.document.write("<link href='/css/style.css' media='screen' rel='stylesheet' type='text/css' />");
	ventimp.document.write(ficha.innerHTML);
	ventimp.document.close();
	ventimp.print();
	ventimp.close();
}