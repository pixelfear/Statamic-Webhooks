jQuery(document).ready(function()
{
	$('.webhooks').click(function(e){
		e.preventDefault();
		var webhookURL = $(this).attr('href');

		$.get( webhookURL, function( data ) {
			console.log(data);
			$.each(data, function(key, value){
				alertify.log(value);
			});
		});
	});
});