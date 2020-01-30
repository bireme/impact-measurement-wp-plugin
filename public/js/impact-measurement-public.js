(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(function() {

		// Suppressing the default validation bubbles
		document.querySelector( "form" )
	        .addEventListener( "invalid", function( event ) {
	            event.preventDefault();
	        }, true );
		
		$('#iconeFeedback').click(function(){
			$('#boxFeedback').toggleClass("boxFeedback");
		})
		$('#feedbackFechar').click(function(){
			$('#boxFeedback').removeClass("boxFeedback");
		})

		$('.star-rating').click(function(){
			var rating = $(this).data('rating');
			$('#rating').val(rating);
		})

		/* Add */
		$('.star1').mouseenter(function(){
			$(this).addClass("fas");
		})
		$('.star2').mouseenter(function(){
			$(this).addClass("fas");
			$(this).siblings(".star1").addClass("fas");
		})
		$('.star3').mouseenter(function(){
			$(this).addClass("fas");
			$(this).siblings(".star1, .star2").addClass("fas");
		})
		$('.star4').mouseenter(function(){
			$(this).addClass("fas");
			$(this).siblings(".star1, .star2, .star3").addClass("fas");
		})
		$('.star5').mouseenter(function(){
			$(this).addClass("fas");
			$(this).siblings(".star1, .star2, .star3, .star4").addClass("fas");
		})

		/* Remove */
		$('.star1').mouseleave(function(){
			$('.star1').removeClass("fas", "fa-star");
		})
		$('.star2').mouseleave(function(){
			$('.star1, .star2').removeClass("fas", "fa-star");
		})
		$('.star3').mouseleave(function(){
			$('.star1, .star2, .star3').removeClass("fas", "fa-star");
		})
		$('.star4').mouseleave(function(){
			$('.star1, .star2, .star3, .star4').removeClass("fas", "fa-star");
		})
		$('.star5').mouseleave(function(){
			$('.star1, .star2, .star3, .star4, .star5').removeClass("fas", "fa-star");
		})

		/* Click */
		$('.star1').click(function(){
			$(this).siblings(".star1, .star2, .star3, .star4, .star5").removeClass("fa-star, starClick");
			$(this).addClass("fa-star, starClick");
		})
		$('.star2').click(function(){
			$(this).siblings(".star1, .star2, .star3, .star4, .star5").removeClass("fa-star, starClick");
			$(this).addClass(" fa-star, starClick");
			$(this).siblings(".star1").addClass("fa-star, starClick");
		})
		$('.star3').click(function(){
			$(this).siblings(".star1, .star2, .star3, .star4, .star5").removeClass("fa-star, starClick");
			$(this).addClass(" fa-star, starClick");
			$(this).siblings(".star1, .star2").addClass("fa-star, starClick");
		})
		$('.star4').click(function(){
			$(this).siblings(".star1, .star2, .star3, .star4, .star5").removeClass("fa-star, starClick");
			$(this).addClass(" fa-star, starClick");
			$(this).siblings(".star1, .star2, .star3").addClass("fa-star, starClick");
		})
		$('.star5').click(function(){
			$(this).siblings(".star1, .star2, .star3, .star4, .star5").removeClass("fa-star, starClick");
			$(this).addClass(" fa-star, starClick");
			$(this).siblings(".star1, .star2, .star3, .star4").addClass("fa-star, starClick");
		})

	    $('div.rowQuestion input:radio, .star-rating').click(function(e) {
	    	// Check if all questions have been answered
	        var len = $('div.rowQuestion:not(:has(:radio:checked,:hidden[value!=""]))').length;
	        if ( len == 0 ) $('#formdata-submit').attr("disabled", false);
		});

		// Attach a submit handler to the form
	    $('#formdata-submit').click(function(e) {
	        // Stop form from submitting normally
	        e.preventDefault();

	        var url, datastring = [];
	     
	        // Get some values from elements on the page
	        $("#conteudoFeedback form").each(function(i){
	        	var $form = $( this );
	        	url = $form.attr("action");
	        	datastring[i] = $form.serialize();
			});

	        // Send the data using post
	        var posting = $.post( url, datastring.join('&') );
	     
	        // Put the results in a div
	        posting.done(function( data ) {
		        $(".im-questions").hide();
		        $(".im-formdata-submit").hide();

		        if ( data == 'True' ) {       
		            $(".feedback-message").find('.result-error').hide();
		        } else {
		            $(".feedback-message").find('.result-ok').hide();
		        }

		        $(".feedback-message").show();
	        });
	    });

	});

})( jQuery );
