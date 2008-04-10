(function($) {
  
  $.ec.explode = function(o) {

    return this.queue(function() {

		var rows = o.options.pieces ? Math.round(Math.sqrt(o.options.pieces)) : 3;
		var cells = o.options.pieces ? Math.round(Math.sqrt(o.options.pieces)) : 3;
		
		var el = $(this).show().css('visibility', 'hidden');
		var offset = el.offset();
		var width = el.outerWidth();
		var height = el.outerHeight();

		for(var i=0;i<rows;i++) { // =
			for(var j=0;j<cells;j++) { // ||
				el
					.clone()
					.appendTo('body')
					.wrap('<div></div>')
					.css({
						position: 'absolute',
						visibility: 'visible',
						left: -j*(width/cells),
						top: -i*(height/rows)
					})
					.parent()
					.addClass('ec-explode')
					.css({
						position: 'absolute',
						overflow: 'hidden',
						width: width/cells,
						height: height/rows,
						left: offset.left + j*(width/cells) + (o.options.mode == 'show' ? (j-Math.floor(cells/2))*(width/cells) : 0),
						top: offset.top + i*(height/rows) + (o.options.mode == 'show' ? (i-Math.floor(rows/2))*(height/rows) : 0),
						opacity: o.options.mode == 'show' ? 0 : 1
					}).animate({
						left: offset.left + j*(width/cells) + (o.options.mode == 'show' ? 0 : (j-Math.floor(cells/2))*(width/cells)),
						top: offset.top + i*(height/rows) + (o.options.mode == 'show' ? 0 : (i-Math.floor(rows/2))*(height/rows)),
						opacity: o.options.mode == 'show' ? 1 : 0
					}, o.duration || 500);
			}
		}

		// Set a timeout, to call the callback approx. when the other animations have finished
		setTimeout(function() {
			
			o.options.mode == 'show' ? el.css({ visibility: 'visible' }) : el.css({ visibility: 'visible' }).hide();
        	if(o.callback) o.callback.apply(el[0]); // Callback
        	el.dequeue();
        	
        	$('.ec-explode').remove();
			
		}, o.duration || 500);
		
      
    });
    
  };
  
})(jQuery);