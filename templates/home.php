<?php
/*
Template Name: Home
*/

/**
 * @package WordPress_Theme
 */

get_header();

?>

<div class="container">

		<div class="jumbotron">
			<h1>Hello, world!</h1>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			<p><a class="btn btn-primary btn-lg" href="/sample-page/" role="button">Learn more</a></p>
		</div>

		<ol class="breadcrumb">
		  <li><a href="#">Home</a></li>
		  <li><a href="#">Library</a></li>
		  <li class="active">Data</li>
		</ol>

		<div class="well">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</p>
		</div>

		<div>

			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a></li>
				<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Profile</a></li>
				<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Messages</a></li>
				<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Settings</a></li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="home">
					<div>
						<?php
							// Start the Loop.
							while ( have_posts() ) : the_post();
								// Include the page content template.
								get_template_part( 'template-parts/content', 'innerpage' );
								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) {
									comments_template();
								}
							endwhile;
						?>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="profile">

				</div>
				<div role="tabpanel" class="tab-pane" id="messages">

				</div>
				<div role="tabpanel" class="tab-pane" id="settings">

				</div>
			</div>

		</div>

		<nav>
		  <ul class="pagination">
		    <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
		    <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
		    <li><a href="#">2</a></li>
		    <li><a href="#">3</a></li>
		    <li><a href="#">4</a></li>
		  </ul>
		</nav>

</div><!-- //container -->

<?php

get_footer();
