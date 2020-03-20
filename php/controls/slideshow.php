<?php

function createSlideshow(array $images, $name = "gallery", $id = null)
{
    ?>
	<section <?php if ($id !== null) echo "id=\"{$id}\""?> class="slideshow">
		<div class="slider">
			<div class="slide_viewer">
				<div class="slide_group">
                    <?php
                    $count = 0;
                    foreach ($images as $image) {
                        ?>
						<img src="<?php echo $image ?>"
						     alt="<?php echo "{$name} {$count}" ?>"
						     class="slide" />
                        <?php
                        $count++;
                    }
                    ?>
				</div>
			</div>
		</div>
		<div class="directional_nav">
			<div class="previous_btn" title="Previous">
				<svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Capa_1" x="0px" y="0px"
				     viewBox="0 0 477.175 477.175" xml:space="preserve"
				     width="512px" height="512px">
				<g>
					<g>
						<path d="M145.188,238.575l215.5-215.5c5.3-5.3,5.3-13.8,0-19.1s-13.8-5.3-19.1,0l-225.1,225.1c-5.3,5.3-5.3,13.8,0,19.1l225.1,225   c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4c5.3-5.3,5.3-13.8,0-19.1L145.188,238.575z"
						      class="active-path" fill="#424241"/>
					</g>
				</g>
			</svg>
			</div>
			<div class="slide_buttons">
			</div>
			<div class="next_btn" title="Next">
				<svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Capa_1" x="0px" y="0px"
				     viewBox="0 0 477.175 477.175" xml:space="preserve"
				     width="512px" height="512px">
				<g>
					<g>
						<path d="M360.731,229.075l-225.1-225.1c-5.3-5.3-13.8-5.3-19.1,0s-5.3,13.8,0,19.1l215.5,215.5l-215.5,215.5   c-5.3,5.3-5.3,13.8,0,19.1c2.6,2.6,6.1,4,9.5,4c3.4,0,6.9-1.3,9.5-4l225.1-225.1C365.931,242.875,365.931,234.275,360.731,229.075z   "
						      class="active-path" fill="#424241"/>
					</g>
				</g>
			</svg>
			</div>
		</div>
	</section>
    <?php
}

?>