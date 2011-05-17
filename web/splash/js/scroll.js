jQuery(function( $ ){
    /**
     * Most jQuery.serialScroll's settings, actually belong to jQuery.ScrollTo, check it's demo for an example of each option.
     * @see http://flesler.demos.com/jquery/scrollTo/
     * You can use EVERY single setting of jQuery.ScrollTo, in the settings hash you send to jQuery.serialScroll.
     */
    
    /**
     * The plugin binds 6 events to the container to allow external manipulation.
     * prev, next, goto, start, stop and notify
     * You use them like this: $(your_container).trigger('next'), $(your_container).trigger('goto', [5]) (0-based index).
     * If for some odd reason, the element already has any of these events bound, trigger it with the namespace.
     */     
    
    /**
     * IMPORTANT: this call to the plugin specifies ALL the settings (plus some of jQuery.ScrollTo)
     * This is done so you can see them. You DON'T need to specify the commented ones.
     * A 'target' is specified, that means that #screen is the context for target, prev, next and navigation.
     */
         /********************************Below is customized by Edi Mange for the SEA project******************************/	 
	 /******************************************************************************************************/
	 /**************************************Top Navigation**************************************************/
	 /******************************************************************************************************/
	
	/****************************************Go to about****************************************************/	
	$('#about').click(function(){

	$('#sections').trigger( 'goto', [ 0 ] );

	});
	/***********************************Go to contact **************************************/
	$('#contact').click(function(){

	$('#sections').trigger( 'goto', [ 1 ] );

	});
	/***********************************Go to partners **************************************/
	$('#partners').click(function(){

	$('#sections').trigger( 'goto', [ 2 ] );

	});
	/***********************************Go to course **************************************/
	$('#course').click(function(){

	$('#sections').trigger( 'goto', [ 3 ] );

	});

	 /******************************************************************************************************/
	 /********************************Go to next course examples********************************************/
	 /******************************************************************************************************/
	 
	 /***********************************Go to course examples page 2 **************************************/
	$('#goTo2').click(function(){

	$('#sections').trigger( 'goto', [ 4 ] );

	});
	/***********************************Go to course examples page 3 **************************************/
	$('#goTo3').click(function(){

	$('#sections').trigger( 'goto', [ 5 ] );

	});
	/***********************************Go to course examples page 4 **************************************/
	$('#goTo4').click(function(){

	$('#sections').trigger( 'goto', [ 6 ] );

	});
	/***********************************Go to course examples page 5 **************************************/
	$('#goTo5').click(function(){

	$('#sections').trigger( 'goto', [ 7 ] );

	});
	/***********************************Go to course examples page 6**************************************/
	$('#goTo6').click(function(){

	$('#sections').trigger( 'goto', [ 8 ] );

	});
	
	/******************************************************************************************************/
	/********************************Go back course examples********************************************/
	/******************************************************************************************************/
	
		 /***********************************Go back a course example page 1 **************************************/
	$('#goBack1').click(function(){

	$('#sections').trigger( 'goto', [ 3 ] );

	});
	/***********************************Go back a course example page 2 **************************************/
	$('#goBack2').click(function(){

	$('#sections').trigger( 'goto', [ 4 ] );

	});
	/***********************************Go back a course example page 3 **************************************/
	$('#goBack3').click(function(){

	$('#sections').trigger( 'goto', [ 5 ] );

	});
	/***********************************Go back a course example page 4 **************************************/
	$('#goBack4').click(function(){

	$('#sections').trigger( 'goto', [ 6 ] );

	});
	/***********************************Go back a course example page 5**************************************/
	$('#goBack5').click(function(){

	$('#sections').trigger( 'goto', [ 7 ] );

	});
	
	/******************************************************************************************************/
	/************************************Serial Scroll settings********************************************/
	/******************************************************************************************************/
	
    $('#screen').serialScroll({
        target:'#sections',
        items:'li', // Selector to the items ( relative to the matched elements, '#sections' in this case )
        prev:'img.prev',// Selector to the 'prev' button (absolute!, meaning it's relative to the document)
        next:'img.next',// Selector to the 'next' button (absolute too)
        axis:'xy',// The default is 'y' scroll on both ways
       // navigation:'#navigation li a',
        duration:700,// Length of the animation (if you scroll 2 axes and use queue, then each axis take half this time)
        force:true, // Force a scroll to the element specified by 'start' (some browsers don't reset on refreshes)
        
        //queue:false,// We scroll on both axes, scroll both at the same time.
        //event:'click',// On which event to react (click is the default, you probably won't need to specify it)
        //stop:false,// Each click will stop any previous animations of the target. (false by default)
        //lock:true, // Ignore events if already animating (true by default)        
        //start: 0, // On which element (index) to begin ( 0 is the default, redundant in this case )       
        //cycle:true,// Cycle endlessly ( constant velocity, true is the default )
        //step:1, // How many items to scroll each time ( 1 is the default, no need to specify )
        //jump:false, // If true, items become clickable (or w/e 'event' is, and when activated, the pane scrolls to them)
        //lazy:false,// (default) if true, the plugin looks for the items on each event(allows AJAX or JS content, or reordering)
        //interval:1000, // It's the number of milliseconds to automatically go to the next
        //constant:true, // constant speed
        ///******************End customization by Edi*******************************************/
        
        onBefore:function( e, elem, $pane, $items, pos ){
            /**
             * 'this' is the triggered element 
             * e is the event object
             * elem is the element we'll be scrolling to
             * $pane is the element being scrolled
             * $items is the items collection at this moment
             * pos is the position of elem in the collection
             * if it returns false, the event will be ignored
             */
             //those arguments with a $ are jqueryfied, elem isn't.
            e.preventDefault();
            if( this.blur )
                this.blur();
        },
        onAfter:function( elem ){
            //'this' is the element being scrolled ($pane) not jqueryfied
        }
    });
});
