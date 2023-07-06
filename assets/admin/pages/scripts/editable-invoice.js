$(document).ready(function(){
    var i=1;


	$(document).on('keyup change','#table_1 tbody', function() {
		calc();
	});
	$(document).on('keyup change','#tax', function() {
		calc_total();
	});
	

});

function calc()
{
	$('#table_1 tbody tr').each(function(i, element) {
		var html = $(this).html();
		if(html!='')
		{
			var qty = $(this).find('.qty').val();
			var price = $(this).find('.price').val();
			var remise = $(this).find('.remise').val();
			var tva_prod = $(this).find('.tva_prod').val();
			var HT = (qty*price-remise);
			var TVA = (HT * tva_prod);
			var TTC = (HT+TVA);
			$(this).find('.HT').html((HT).toFixed(2));
			$(this).find('.TVA').html((TVA).toFixed(2));
			$(this).find('.TTC').html((TTC).toFixed(2));


			
			calc_total();
		}
    });
}

function calc_total()
{
	total=0;
	totaltva = 0;
	totalttc = 0;
	$('.HT').each(function() {
        total += parseFloat($(this).text());
    });
	$('.TVA').each(function() {
        totaltva += parseFloat($(this).text());

    });
	$('.TTC').each(function() {
        totalttc += parseFloat($(this).text());

    });
	$('#TOTALHT').html((total).toFixed(2));
	$('#TOTALHT_R').html((total).toFixed(2));
	$('#TOTALTVA').html((totaltva).toFixed(2));
	$('#TOTALTTC').html((totalttc).toFixed(2));
	$('#REMISE_ht').html((0).toFixed(2));
}