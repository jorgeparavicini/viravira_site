<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Spa | Hotel Vira Vira</title>

	<meta name="description"
	      content="Hotel Vira Vira give life to a new way of enjoying holidays, combined with adventure.
         In a unique and privileged location close to Pucon.">

	<link rel="manifest" href="/site.webmanifest">
	<link rel="apple-touch-icon" href="/img/icon.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#fafafa">

	<link rel="stylesheet" href="/css/main.css">
	<link rel="stylesheet" href="/css/spa.css">
</head>

<body>

<?php
include($_SERVER['DOCUMENT_ROOT'] . "/html/header.html");
?>

<section id="wellness">
	<div>
		<h2>Wellness</h2>
		<p>
			We offer a wide variety of wonderful massage therapies in quiet and beautifully designed environments. Treat
			yourself to a moment of silence surrounded by the beauty of nature. Or relax in one of our hot tubs – an
			unforgettable experience by night when the southern cross is just above you.
		</p>
	</div>
</section>
<section id="gallery">
	<div class="slider">
		<div class="slide_viewer">
			<div class="slide_group">
				<img src="/img/spa1.jpg" class="slide" alt="Spa 1">
				<img src="/img/spa2.jpg" class="slide" alt="Spa 2">
				<img src="/img/spa3.jpg" class="slide" alt="Spa 3">
				<img src="/img/spa4.jpg" class="slide" alt="Spa 4">
			</div>
		</div>
	</div>
	<div class="slide_buttons">
	</div>
	<div class="directional_nav">
		<div class="previous_btn" title="Previous">
			<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
			     y="0px" width="65px" height="65px" viewBox="-11 -11.5 65 66">
				<g>
					<g>
						<path fill="#000000" d="M-10.5,22.118C-10.5,4.132,4.133-10.5,22.118-10.5S54.736,4.132,54.736,22.118
			c0,17.985-14.633,32.618-32.618,32.618S-10.5,40.103-10.5,22.118z M-8.288,22.118c0,16.766,13.639,30.406,30.406,30.406 c16.765,0,30.405-13.641,30.405-30.406c0-16.766-13.641-30.406-30.405-30.406C5.35-8.288-8.288,5.352-8.288,22.118z"/>
						<path fill="#000000"
						      d="M25.43,33.243L14.628,22.429c-0.433-0.432-0.433-1.132,0-1.564L25.43,10.051c0.432-0.432,1.132-0.432,1.563,0	c0.431,0.431,0.431,1.132,0,1.564L16.972,21.647l10.021,10.035c0.432,0.433,0.432,1.134,0,1.564	c-0.215,0.218-0.498,0.323-0.78,0.323C25.929,33.569,25.646,33.464,25.43,33.243z"/>
					</g>
				</g>
			</svg>
		</div>
		<div class="next_btn" title="Next">
			<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
			     y="0px" width="65px" height="65px" viewBox="-11 -11.5 65 66">
				<g>
					<g>
						<path fill="#000000"
						      d="M22.118,54.736C4.132,54.736-10.5,40.103-10.5,22.118C-10.5,4.132,4.132-10.5,22.118-10.5	c17.985,0,32.618,14.632,32.618,32.618C54.736,40.103,40.103,54.736,22.118,54.736z M22.118-8.288	c-16.765,0-30.406,13.64-30.406,30.406c0,16.766,13.641,30.406,30.406,30.406c16.768,0,30.406-13.641,30.406-30.406 C52.524,5.352,38.885-8.288,22.118-8.288z"/>
						<path fill="#000000"
						      d="M18.022,33.569c 0.282,0-0.566-0.105-0.781-0.323c-0.432-0.431-0.432-1.132,0-1.564l10.022-10.035 			L17.241,11.615c 0.431-0.432-0.431-1.133,0-1.564c0.432-0.432,1.132-0.432,1.564,0l10.803,10.814c0.433,0.432,0.433,1.132,0,1.564 L18.805,33.243C18.59,33.464,18.306,33.569,18.022,33.569z"/>
					</g>
				</g>
			</svg>
		</div>
	</div>

</section>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script>
    $('.slider').each(function() {
        let $this = $(this);
        let $group = $this.find('.slide_group');
        let $slides = $this.find('.slide');
        let bulletArray = [];
        let currentIndex = 0;
        let timeout;

        function move(newIndex) {
            let animateLeft, slideLeft;

            advance();

            if ($group.is(':animated') || currentIndex === newIndex) {
                return;
            }

            bulletArray[currentIndex].removeClass('active');
            bulletArray[newIndex].addClass('active');

            if (newIndex > currentIndex) {
                slideLeft = '100%';
                animateLeft = '-100%';
            } else {
                slideLeft = '-100%';
                animateLeft = '100%';
            }

            $slides.eq(newIndex).css({
                display: 'block',
                left: slideLeft
            });
            $group.animate({
                left: animateLeft
            }, function() {
                $slides.eq(currentIndex).css({
                    display: 'none'
                });
                $slides.eq(newIndex).css({
                    left: 0
                });
                $group.css({
                    left: 0
                });
                currentIndex = newIndex;
            });
        }

        function advance() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                if (currentIndex < ($slides.length - 1)) {
                    move(currentIndex + 1);
                } else {
                    move(0);
                }
            }, 4000);
        }

        $('.next_btn').on('click', function() {
            if (currentIndex < ($slides.length - 1)) {
                move(currentIndex + 1);
            } else {
                move(0);
            }
        });

        $('.previous_btn').on('click', function() {
            if (currentIndex !== 0) {
                move(currentIndex - 1);
            } else {
                move(3);
            }
        });

        $.each($slides, function(index) {
            let $button = $('<a class="slide_btn">&bull;</a>');

            if (index === currentIndex) {
                $button.addClass('active');
            }
            $button.on('click', function() {
                move(index);
            }).appendTo('.slide_buttons');
            bulletArray.push($button);
        });

        advance();
    });
</script>
</body>