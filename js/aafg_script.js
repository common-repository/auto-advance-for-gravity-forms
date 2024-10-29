jQuery(document).bind('gform_post_render', function(){ 
	perform_hiding_operations();
});

function perform_hiding_operations() {
	
	jQuery('.gform_wrapper').addClass('mpaa-gform-loaded')
	
}


jQuery( document ).ready( function($) {
	
	var click_perform = true;
	
	jQuery(document).on('click', ".trigger-next-zzd input[type='radio']", function() {
	   var $this = jQuery(this);
	   setTimeout(function() {
		   
			if(click_perform) {
				$this.trigger('change');
			}
			click_perform = true;
	   }, 100);
	   
   });


	jQuery(document).on ('change', ".trigger-next-zzd input[type='radio'], .trigger-next-zzd select", function() {
		
		var $this = jQuery(this);
		click_perform = false;
		
		setTimeout( function() {				
			$this.parents('form').trigger('submit', [true]);
		}, 200 );
   });
	
	
});











