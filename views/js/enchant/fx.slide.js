(function($) {
  
  $.ec.slide = function(o) {

    return this.queue(function() {

      // Create element
      var el = $(this), props = ['position','top','left'];
      
      // Set options
      var mode = $.ec.setMode(el, o.options.mode || 'show'); // Set Mode
      var direction = o.options.direction || 'left'; // Default Direction
      
      // Adjust
      $.ec.save(el, props); el.show(); // Save & Show
      $.ec.createWrapper(el).css({overflow:'hidden'}); // Create Wrapper
      var ref = (direction == 'up' || direction == 'down') ? 'top' : 'left';
      var motion = (direction == 'up' || direction == 'left') ? 'pos' : 'neg';
      var distance = o.options.distance || (ref == 'top' ? el.outerHeight({margin:true}) : el.outerWidth({margin:true}));
      if (mode == 'show') el.css(ref, motion == 'pos' ? -distance : distance); // Shift
      
      // Animation
      var animation = {};
      animation[ref] = (mode == 'show' ? (motion == 'pos' ? '+=' : '-=') : (motion == 'pos' ? '-=' : '+=')) + distance;
      
      // Animate
      el.animate(animation, { queue: false, duration: o.duration, easing: o.options.easing, complete: function() {
        if(mode == 'hide') el.hide(); // Hide
        $.ec.restore(el, props); $.ec.removeWrapper(el); // Restore
        if(o.callback) o.callback.apply(this, arguments); // Callback
        el.dequeue();
      }});
      
    });
    
  };
  
})(jQuery);