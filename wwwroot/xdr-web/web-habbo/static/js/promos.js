$.fn.ooceHeroSlider = function (options) {
	//Defaults for the control	
	var defaults = { sldHt: 290, sldWd: 940, actBack: '#505050', pasBack: '#FFF', duration: 5000, speed: 1500, easing: "easeOutQuint" }
	var opts = $.extend(defaults, options);
	return this.each(function () {
		//Setting up the control with class and height and showing it
		$(this).addClass('occeHeroSlides').height(opts.sldHt).removeClass('cntOCCEModule');
		//Variables
		var posVis = 0, posPrimary = opts.sldWd, posSecondary = -opts.sldWd, slide = $('.occeHeroSlides ul li').length, ind = 'span.indicator', li = '.occeHeroSlides ul li', aS = 'activeSlide';
		//Positioning all of the slides for first run
		$(li).width(opts.sldWd).css({ 'left': posPrimary });
		$(li + ':nth-child(1)').css({ 'left': posVis }).addClass(aS);
		//Add a button for each slide in the slider
		for (var i = 0; i < slide; i++) {
			$('.occeHeroSlides').prepend('<span class="indicator' + ([i + 1]) + ' indicator"></span>');
			$(ind + ([i + 1]) + '').css({ 'background-color': opts.pasBack, 'position': 'absolute', 'top': (opts.sldHt - 26), 'display': 'inline-block', 'height': '15px', 'width': '15px', 'z-index': '10', 'cursor': 'pointer', 'border': '1px solid #C0C0C0' }).mouseenter(function () { window.clearInterval(slideTimer); });
			$(li + ':nth-child(' + ([i + 1]) + ')').addClass('.cntHeroSlide' + ([i + 1]) + '');
			if ($('html').attr('dir') == 'rtl') { $(ind + ([i + 1]) + '').css({ 'right': (opts.sldWd - (slide * 26) + ([i] * 26)) }); }
			else { $(ind + ([i + 1]) + '').css({ 'left': (opts.sldWd - (slide * 26) + ([i] * 26)) }); }
		}
		//Set the first button to active background
		$(ind + '1').css({ 'background-color': opts.actBack });
		//Code to fire when a button is "clicked"
		$(ind).each(function (n) {
			$(this).on('click', function () {
				var fC = $(this).attr('class'), cC = $(li + ':nth-child(' + (slide - n) + ')').css('left');
				$('.indicator').not(this).animate({ 'background-color': opts.pasBack });
				if (cC === posVis + "px" || fC == aS) {
					//stay in current state
				}
				else if (fC !== aS) {
					//load the selected slide based on the square that is clicked
					$(li).eq(slide - n - 1).animate({ 'left': posVis }, opts.speed, opts.easing).addClass(aS);
					$(li + ':gt(' + (slide - n - 1) + ')').not('.activeSlide').css({ 'left': posPrimary });
					$(li + ':lt(' + (slide - n - 1) + ')').not('.activeSlide').css({ 'left': posSecondary });
					$(li).removeClass(aS).eq(slide - n - 1).addClass(aS);
					$(li + ':gt(' + (slide - n - 1) + ')').animate({ 'left': posPrimary }, opts.speed, opts.easing);
					$(li + ':lt(' + (slide - n - 1) + ')').animate({ 'left': posSecondary }, opts.speed, opts.easing);
				}
				else {
					//Fail silently
				}
				$(ind).not(this).removeClass(aS);
				$(this).animate({ 'background-color': opts.actBack }).addClass(aS);
			});
		});
		//Timer for the control 
		var slideTimer;
		function startTimer() { var timerCount = 0; slideTimer = window.setInterval(function () { if (timerCount < (slide - 1)) { $(ind + (timerCount + 2)).click(); timerCount++; } else if ((timerCount + 1) === slide) { $(ind + '1').click(); stopTimer(); } else { } }, opts.duration); };
		function stopTimer() { window.clearInterval(slideTimer); }
		startTimer();
	});
};