<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js"></script>
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
	<style>
		.image-wrapper {
		    position: relative;
		    width: 160px;
		    height: 60px;
		    line-height: 60px;
		    text-align: center;
		}
		.image-wrapper span {
		    position: absolute;
		    left: 0;
		    top: 0;
		    /*padding: 10px;*/
		    width: 218px;
		    color: #FFF;
		    /*margin: 5px;*/
		    text-align: center
		}
		.replay {
			position: fixed;
			bottom: -10px;
			right: 80px;
			overflow: hidden;
		}
		.play {
			position: fixed;
			bottom: -30px;
			right: 450px;
			overflow: hidden;
		}
		.record {
			position: fixed;
			bottom: -70px;
			right: 280px;
			overflow: hidden;
		}
		div.red svg:hover {
			-webkit-filter: drop-shadow( 0px 0px 10px red );
            filter: drop-shadow( 0px 0px 10px red );
		}
		div.blue svg:hover {
			-webkit-filter: drop-shadow( 0px 0px 10px blue );
            filter: drop-shadow( 0px 0px 10px blue );
		}


		div.test {
			width: 120px;
			height: 60px;
			line-height: 60px;

			text-align: center;
			background: url({{ asset('img/testAnimate/board.svg') }});
		}
		span.test {
			display: inline-block;
			vertical-align: middle;
			line-height: normal;
			font-weight: 600;
			font-family: Cambria;
			font-size: 1.7em;
			color: white
		}
	</style>
</head>
<body style="background: url({{ asset('img/testAnimate/bg.svg') }}) no-repeat center bottom fixed; background-size: cover;">
	<span style="padding: 25px; text-align: center; color: white; background: url({{ asset('img/testAnimate/board.svg') }});">Anh</span>
	{{-- <div style="width: 100%; text-align: center;">
		<img src="{{ asset('img/testAnimate/tree.svg') }}" style="width: 80%;">
	</div> --}}

	<div class="image-wrapper" style="vertical-align: middle;">
		<span style="display: inline-block;vertical-align: middle;line-height: normal;width: 100%">Anh</span>
	</div>

	<div class="test">
		<span class="test">Anh</span>
	</div>

	<div class="play blue">
		<img class="fillable" src="{{ asset('img/testAnimate/play.svg') }}" alt="">
	</div>
	<div class="replay red">
		<img class="fillable" src="{{ asset('img/testAnimate/replay.svg') }}" alt="">
	</div>
	<div class="record blue">
		<img class="fillable" src="{{ asset('img/testAnimate/record.svg') }}" alt="">
	</div>

	<script>
		jQuery('img.fillable').each(function() {
			var $img = jQuery(this);
			var imgID = $img.attr('id');
			var imgClass = $img.attr('class');
			var imgURL = $img.attr('src');

			jQuery.get(imgURL, function(data) {
			// Get the SVG tag, ignore the rest
			var $svg = jQuery(data).find('svg');

			// Add replaced image's ID to the new SVG
			if(typeof imgID !== 'undefined') {
				$svg = $svg.attr('id', imgID);
			}
			// Add replaced image's classes to the new SVG
			if(typeof imgClass !== 'undefined') {
				$svg = $svg.attr('class', imgClass+' replaced-svg');
			}

			// Remove any invalid XML tags as per http://validator.w3.org
			$svg = $svg.removeAttr('xmlns:a');

			// Replace image with new SVG
			$img.replaceWith($svg);

			}, 'xml');

		});
	</script>
</body>
</html>