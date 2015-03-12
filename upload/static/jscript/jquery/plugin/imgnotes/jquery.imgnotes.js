/**
 * imgnotes jQuery plugin
 * version 0.1
 *
 * Copyright (c) 2008 Dr. Tarique Sani <tarique@sanisoft.com>
 *
 * Dual licensed under the MIT (MIT-LICENSE.txt) 
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * @URL      http://www.sanisoft.com/blog/2008/05/26/img-notes-jquery-plugin/
 * @Example  example.html
 *
 **/

//Wrap in a closure
(function($) {

	$.fn.imgNotes = function(n) {		
		
		if(undefined != n){
			notes = n;
		} 

		image = this;

		imgOffset = $(image).offset();
	
		$(notes).each(function(){
			appendnote(this);
		});	
	
		
		$(image).hover(
			function(){
				$('.note').show();				
			},
			function(){
				$('.note').hide();
			}
		);
		

		addnoteevents();
		
		$(window).resize(function () {
			$('.note').remove();

			imgOffset = $(image).offset();

			$(notes).each(function(){
				appendnote(this);				
			});

			addnoteevents();

		});
	} 
	
	function addnoteevents() {				
		$('.note').hover(
			function(){				
				$('.note').show();				
				$(this).next('.notep').show();
				$(this).next('.notep').css("z-index", 10000);
			},
			function(){
				$('.note').show();				
				$(this).next('.notep').hide();
				$(this).next('.notep').css("z-index", 0);
			}
		);
	}


	function appendnote(note_data){
		
		note_left  = parseInt(imgOffset.left) + parseInt(note_data.x1);
		note_top   = parseInt(imgOffset.top) + parseInt(note_data.y1);
		note_p_top = note_top + parseInt(note_data.height)+5;
						
		note_area_div = $("<div id='js_note_" + note_data.note_id + "' class='note'></div>").css({ left: note_left + 'px', top: note_top + 'px', width: note_data.width + 'px', height: note_data.height + 'px' });
		
		note_text_div = $('<div class="notep" >'+note_data.note+'</div>').css({ left: note_left + 'px', top: note_p_top + 'px'});
		
		$('body').append(note_area_div);
		$('body').append(note_text_div);		
	}

// End the closure
})(jQuery);