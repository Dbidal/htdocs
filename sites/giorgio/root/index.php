<?php include preg_replace( "/(sites).*/", "", __DIR__ ) . "head.php"; ?>




<!-- top bar -->
	<style>
		@media(max-width:700px) {.head:not(#_) figure {display: none;}}
	</style>

	<div class="wp-block-group head" style="background:#20202f;position:sticky;top:0;z-index:4;max-width: 100%;padding:10px;">
		<div class="wp-block-group" style="max-width:500px;margin: 10px auto;">
			<figure class="wp-block-image alignleft" style="margin: 0;">
				<?php new Image( "https://htdocs.dgstesting.com/shared/images/giorgio/highres/9105738.png", "", array( "width" => 62, "height" => 63 ) ); ?>
			</figure>
			<p style="color:#ffffff;font-size:24px;margin:5px 0px 0px"><b>GIORGIO CONSTRUCTION&nbsp;INC.</b></p>
			<p style="color:#ffffff;margin:0;">SPECIALIZING IN WATERPROOFING</p>
		</div> 
	</div>




<!-- cover -->
	<div class="wp-block-group" style="background:#90b4c4;max-width: 100%;">

		<div style="background: linear-gradient(360deg, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 0) 80%);content: '';height: 100%;width: 100%;max-width: 100%;position: absolute;z-index: 1;"></div>
		<figure class="wp-block-image size-large" data-full-width="true" data-position-absolute="true"  data-parent-height="true">
			<?php new Image( "https://htdocs.dgstesting.com/shared/images/giorgio/highres/6677832.jpg" ); ?>
		</figure>

		<div class="wp-block-group" style="padding-top: calc( 7vw + 100px );padding-bottom: calc( 7vw + 100px );z-index: 1;">
			<figure class="wp-block-image aligncenter">
				<?php new Image( "https://htdocs.dgstesting.com/shared/images/giorgio/highres/9105738.png", "", array( "width" => 148, "height" => 150 ) ); ?>
			</figure>
			<h2 style="color:#ffffff;text-align:center;">GIORGIO CONSTRUCTION INC.</h2>
			<p style="color:#ffffff;margin-top:0;text-align:center;font-size: 20px;">SPECIALIZING IN WATERPROOFING</p>
		</div>

	</div>




<!-- first section - gallery -->
	<style>
		@media (max-width:780px) {
			.gallerycolumns {flex-wrap: wrap;}
			.gallerycolumns>div {flex-basis: 100% !important;margin-left: 0px !important;}
			.gallerycolumns>div:nth-child(1) {order: 2;}
			.gallerycolumns>div:nth-child(2) {order: 1;}
		}
	</style>

	<h2 style="margin-top:60px;">Contact Us Today!</h2>
	<p style="margin-bottom:10px;"><b>Email:</b> <?php echo $site->place( 0, "email", array( "link" =>  "mailto" ) ); ?></p>
	<p style="margin-top:10px;"><b>Phone:</b> <?php echo $site->place( 0, "telephone", array( "link" => "tel" ) ); ?></p>

	<div class="wp-block-columns gallerycolumns" data-unique-id="3p1u01rxn">

		<div class="hcube-block-column" style="flex-basis:50%;padding-top:60px;">
			<figure class="wp-block-gallery columns-3 is-cropped">
				<ul class="blocks-gallery-grid">
					<li class="blocks-gallery-item"><?php new Image( "https://htdocs.dgstesting.com/shared/images/giorgio/highres/3995109.jpg" ); ?></li>
					<li class="blocks-gallery-item"><?php new Image( "https://htdocs.dgstesting.com/shared/images/giorgio/highres/1020937.jpg" ); ?></li>
					<li class="blocks-gallery-item"><?php new Image( "https://htdocs.dgstesting.com/shared/images/giorgio/highres/4793430.jpg" ); ?></li>
					<li class="blocks-gallery-item"><?php new Image( "https://htdocs.dgstesting.com/shared/images/giorgio/highres/6303985.jpg" ); ?></li>
					<li class="blocks-gallery-item"><?php new Image( "https://htdocs.dgstesting.com/shared/images/giorgio/highres/9191844.jpg" ); ?></li>
					<li class="blocks-gallery-item"><?php new Image( "https://htdocs.dgstesting.com/shared/images/giorgio/highres/1119617.jpg" ); ?></li>
					<li class="blocks-gallery-item"><?php new Image( "https://htdocs.dgstesting.com/shared/images/giorgio/highres/1428771.jpg" ); ?></li>
					<li class="blocks-gallery-item"><?php new Image( "https://htdocs.dgstesting.com/shared/images/giorgio/highres/1558305.jpg" ); ?></li>
					<li class="blocks-gallery-item"><?php new Image( "https://htdocs.dgstesting.com/shared/images/giorgio/highres/2348286.jpg" ); ?></li>
				</ul>
			</figure>
		</div>

		<div class="hcube-block-column" style="flex-basis:60%;padding:40px 20px;">
			<h2>What We Do</h2>
			<ul>
				<li>Waterproofing &amp; Weeping Tile</li>
				<li>Battery Backup Sump Pump Systems</li>
				<li>Foundation Repair</li>
				<li>Bowed Wall Repair</li>
				<li>Parging, Stucco &amp; Epoxy</li>
				<li>Free Estimates</li>
				<li>Disaster Recovery &amp; Restoration</li>
				<li>Additions &amp; Renovations</li>
				<li>Concrete Work</li>
				<li>General Contracting</li>
			</ul>
			<h2 style="margin-top:40px;">About Us</h2>
			<p>We at Giorgio Construction Inc specialize in waterproofing services for both residential and commercial projects here in Thunder Bay, ON. We provide the highest quality materials and craftsmanship of waterproofing basements in the city. We use commercial grade products that can withhold colder and harsher weather conditions, all of which have been tested in the harshest conditions.<br><br>We provide sump pump systems, weeping tile installation, membrane application, wall straightening, drywell installation, epoxy injection, block repair, foundation repairs, plastering, and much more.<br><br>We offer the longest warranty in the city! No job is too big or small.<br><br>We use a commercial grade spray-on membrane that is superior to the more commonly used roll-on product (Blueskin) in that it has no seams that can deteriorate and leak over time.<br><br>Fully insured and bonded for both yours and our protection as well as fully cleared with <a href="http://www.wsib.on.ca/">Workplace Safety and Insurance Board (WSIB)</a></p>
		</div>

	</div>




<!-- second section - reviews -->
	<style>
		.reviews p {font-size: 14px;}
		.reviews blockquote {margin: 20px;border-left: 3px solid #000;    font-style: italic;margin-bottom:40px;}
		@media (max-width:850px) {
			.reviews > div {flex-wrap: wrap;}
			.reviews > div > div {flex-basis: 100% !important;margin-left: 0px !important;}
		}
	</style>

	<div class="wp-block-group" style="padding:60px 20px;width: 100%;max-width: 100%;background:#e8eaeb">
		<div>

			<h2>Testimonials</h2>
			<p style="">See what our valued customers think!</p>
			<div class="wp-block-group reviews">
				<div class="wp-block-columns">
				
					<div class="hcube-block-column" style="flex-basis:50%">
						<blockquote><p>I have had the opportunity to talk 3 or 4 times to Enzo prior to getting my job done . The ability to explain in detail what and why the job would entail. The jpb turned out great and we will hopfully be dry for spring. I would use giorgio construction anytime needed. Thanks Enzo Craig napper</p><cite>Craig</cite></blockquote>
						<blockquote><p>Enzo installed a sump pump and battery back-up system for me. He listened to what I wanted and needed, and offered me options. He was extremely knowledgeable, professional, hard working, and respectful. He cleaned up the mess after the job was finished, and his price was totally reasonable. Enzo even made a follow-up call to ensure that I was completely happy with the system. I would highly recommend Giorgio Construction.</p><cite>Heather</cite></blockquote>
						<blockquote><p>I was very impressed with this crew's work ethic and positive morale. They take their work seriously and are true craftsmen in a time when so many crews just want to do a quick job and move on. Enzo and his crew showed respect for me, my children, my house, and my yard -- before, during, and after the job. They met and exceeded my hopes and expectations in terms of quality of work and professional behaviour. This job was required because a previous contractor had done the job poorly; Enzo and his crew set my mind at ease by explaining to me what was done wrong and how they would fix it while still being professionally respectful towards the previous contractor. They communicated well with me throughout the process, and were able to work as a team with me and my partner as we progressed with our interior b asement renovations. I highly recommend Giorgo Construction and look forward to having them back for phase 2 of my foundation repair.</p><cite>Kathleen</cite></blockquote>
						<blockquote><p>This past spring found us with a water leak through the front corner of our 50+ year old home foundation. We did some research for possible solutions to address our problem and sourced out local companies to discuss waterproofing/repair techniques and costs. From the start, Giorgio Construction provided prompt professional service, with sound advice and feasible recommendations for our water problem. Throughout the excavation process, they kept us updated, highlighted areas of concern and provided pictures. Not only did they repair and patch the location of water intrusion, they thoroughly inspected the rest of the exposed foundation and took time to ensure all areas of concern were addressed. Once the work was completed, the clean-up and grading was conducted with the same attention to detail as the foundation repair---- even my flag pole and bushes were re-installed! Thanks again Giorgio Construction Inc!!!!!!</p><cite>Ellen and Gerald</cite></blockquote>
					</div>
					<div class="hcube-block-column" style="flex-basis:50%">
						<blockquote><p>We found Giorgio construction at the home show last year and explained our leak in the basement. We were given a competitive quote and had them repair the leak. They were fast, efficient and extremely effective at stopping water from entering our basement. I was very impressed that they protected my flower beds and cleaned up the area they worked on. We are extremely satisfied with their work. Try them, they will do a great job!</p><cite>Lauri</cite></blockquote>
						<blockquote><p>Enzo listened better than most, gave sound advice that included options, completed work in a timely manor and was mindful of order and safety. The work he and his team completed was well done and his prices were on point. We would highly recommend Giorgio Construction.</p><cite>Anonymous</cite></blockquote>
						<blockquote><p>Lee This spring I had a bit of water seep into a corner in my basement. I assumed it was a problem with my weeping tiles being plugged. I had them flushed through my sump pump line and proceeded trying to find a contractor to come in an repair the water damage. This became a very lengthy process. Before I found a contractor, I ended up having more water seep in. I was sick, I thought for sure it meant I was going to need new weeping tile. (Even though some weeping tile had been replaced in 2007 by previous owners) Now the hunt began; try to find a reputable company! One company quoted very high and could not do the job until next year. (would not even take the time to come out to do an assessment and estimate) I stumbled on Giorgio Construction and gave them a call for an estimate. Enzo was there promptly and was very kind and patient. I hadn't even owned the house for a year. I was beside myself with worry. Enzo was not quick to jump to the conclusion that I needed new weeping tile. He decided first he should take a look at my storm sewer; and low and behold--it was plugged! He said to call the city and have them unplug it. Enzo explained the workings of my system and why it plugged. Because of his being so thorough and compassionate about the tough situation I was in, I now was able to go through insurance to repair the damage done. I did not need new weeping tile! I emailed Enzo right away to thank him for his thoroughness. He had really saved the day! The following week Enzo called to see how I was managing with everything, and again was very patient in answering any questions I had. One can tell that his business will do well. He seems to honestly care about not only his customers, but his potential customers. He could have easily told me I needed new weeping tile, and walked away with another job for his crew, as I am sure many companies would. If any future issues arise, I would not hesitate to get Giorgio Construction in to do the work.</p><cite>Anonymous</cite></blockquote>
						<blockquote><p>We have used Giorgio Construction twice now for issues with two separate basements. They took care of foundation repair as well as basement insulation and installed weeping tile and sump pumps. Their work is top notch and our basements went from cold and wet to warm and dry almost over night. They stand behind their work 100%, provide professional and timely service and educate their clients on the problem and the fixes. Enzo and his staff not only do great work but they are friendly and really do care about the well being of the people for whom he works. Many Thanks for the great service!</p><cite>Adam and Amanda Kates</cite></blockquote>
					</div>

				</div>
			</div>

		</div>
	</div>




<!-- footer -->
	<?php include "../blocks/footer.php"; ?>




<?php include preg_replace( "/(sites).*/", "", __DIR__ ) . "foot.php"; ?>
