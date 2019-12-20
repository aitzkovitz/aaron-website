<?php
/**
 * Template Name: portfolio page
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package GTL_Portfolio_Theme
 * @since 1.0.0
 */

get_header(); ?>


<?php get_template_part('template-parts/banner');?>
           
    <div id="about-area" class="about-area pt-100">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-sm-12">
                            <div class="about-rightsidebar">
                                <h2><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-headline')); ?> <span><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-desc')); ?></span></h2>
                                <p><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-text')); ?></p>
                                <div class="about-bottom">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="lead"><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-skill1')); ?></div>
                                            <div class="progress">
                                               
                                                <div class="progress-bar wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.2s" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_html(get_theme_mod('lwp-portfolio-callout-skill-p1')); ?>%;">
                                                    <span><?php echo absint(get_theme_mod('lwp-portfolio-callout-skill-p1')); ?>%</span>
                                                </div>
                                            </div><div class="lead"><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-skill2')); ?></div>
                                            <div class="progress">
                                               
                                                <div class="progress-bar wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.2s" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_html(get_theme_mod('lwp-portfolio-callout-skill-p2')); ?>%;">
                                                    <span><?php echo absint(get_theme_mod('lwp-portfolio-callout-skill-p2')); ?>%</span>
                                                </div>
                                            </div>
                                            <div class="lead"><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-skill3')); ?></div>
                                            <div class="progress">
                                               
                                                <div class="progress-bar wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.2s" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_html(get_theme_mod('lwp-portfolio-callout-skill-p3')); ?>%;">
                                                    <span><?php echo absint(get_theme_mod('lwp-portfolio-callout-skill-p3')); ?>%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="all-progress">
                                                <div class="lead"><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-skill4')); ?></div>
                                                <div class="progress">
                                                   
                                                    <div class="progress-bar wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.2s" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_html(get_theme_mod('lwp-portfolio-callout-skill-p4')); ?>%;">
                                                        <span><?php echo absint(get_theme_mod('lwp-portfolio-callout-skill-p4')); ?>%</span>
                                                    </div>
                                                </div>
                                                <div class="lead"><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-skill5')); ?></div>
                                                <div class="progress">
                                                   
                                                    <div class="progress-bar wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.2s" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_html(get_theme_mod('lwp-portfolio-callout-skill-p5')); ?>%;">
                                                        <span><?php echo absint(get_theme_mod('lwp-portfolio-callout-skill-p5')); ?>%</span>
                                                    </div>
                                                </div>
                                                <div class="lead"><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-skill6')); ?></div>
                                                <div class="progress">
                                                   
                                                    <div class="progress-bar wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.2s" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_html(get_theme_mod('lwp-portfolio-callout-skill-p6')); ?>%;">
                                                        <span><?php echo absint(get_theme_mod('lwp-portfolio-callout-skill-p6')); ?>%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="about-img">
                                <img src="<?php echo esc_url(get_theme_mod('sec_image_1')); ?>" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        
        <div id="service-area" class="service-area pt-90 pb-70 gray-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="section-title">
                                <h2><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ser-head')); ?></h2>
                                <p><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ser-desc')); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12 text-center">
                            <div class="single-service white-bg">
                                <i class="<?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ser-icon1')); ?>"></i>
                                <h3><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ser-text1')); ?></h3>
                                <p><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ser-des1')); ?></p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 text-center">
                            <div class="single-service white-bg">
                                <i class="<?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ser-icon2')); ?>" style="font-size:24px"></i>
                                <h3><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ser-text2')); ?></h3>
                                <p><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ser-des2')); ?></p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 text-center">
                            <div class="single-service white-bg">
                                <i class="<?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ser-icon3')); ?>" style="font-size:24px"></i>
                                <h3><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ser-text3')); ?></h3>
                                <p><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ser-des3')); ?></p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 text-center">
                            <div class="single-service white-bg">
                                <i class="<?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ser-icon4')); ?>" style="font-size:24px"></i>
                                <h3><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ser-text4')); ?></h3>
                                <p><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ser-des4')); ?></p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 text-center">
                            <div class="single-service white-bg">
                                <i class="<?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ser-icon5')); ?>" style="font-size:24px"></i>
                                <h3><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ser-text5')); ?></h3>
                                <p><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ser-des5')); ?> </p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 text-center">
                            <div class="single-service white-bg">
                                <i class="<?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ser-icon6')); ?>" style="font-size:24px"></i>
                                <h3><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ser-text6')); ?></h3>
                                <p><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ser-des6')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- portfolio start -->
		<div class="portfolio-area pt-90">
			<div class="container">
                <div class="section-title text-center">
                    <h2><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-gal-head')); ?></h2>
                    <p><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-gal-desc')); ?></p>
                </div>
							
				<div class="row portfolio-style-2">
					
						<div class="col-md-4 col-sm-6 col-xs-12 grid-item cat1">
							<div class="portfolio">
								<div class="portfolio-img">
									<img src="<?php echo esc_url(get_theme_mod('work_image_1')); ?>" alt="" />
								</div>
																	
							</div>
						</div>					
						<div class="col-md-4 col-sm-6 col-xs-12 grid-item cat2 cat3">
							<div class="portfolio">
								<div class="portfolio-img">
									<img src="<?php echo esc_url(get_theme_mod('work_image_2')); ?>" alt="" />
								</div>
																
							</div>						
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12 grid-item cat1">
							<div class="portfolio">
								<div class="portfolio-img">
									<img src="<?php echo esc_url(get_theme_mod('work_image_3')); ?>" alt="" />
								</div>
																
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12 grid-item cat2">
							<div class="portfolio">
								<div class="portfolio-img">
									<img src="<?php echo esc_url(get_theme_mod('work_image_4')); ?>" alt="" />
								</div>
																
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12 grid-item cat1">
							<div class="portfolio">
								<div class="portfolio-img">
									<img src="<?php echo esc_url(get_theme_mod('work_image_5')); ?>" alt="" />
								</div>
															
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12 grid-item cat3">
							<div class="portfolio">
								<div class="portfolio-img">
									<img src="<?php echo esc_url(get_theme_mod('work_image_6')); ?>" alt="" />
								</div>
															
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12 grid-item cat2 cat3">
							<div class="portfolio">
								<div class="portfolio-img">
									<img src="<?php echo esc_url(get_theme_mod('work_image_7')); ?>" alt="" />
								</div>
															
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12 grid-item cat3">
							<div class="portfolio">
								<div class="portfolio-img">
									<img src="<?php echo esc_url(get_theme_mod('work_image_8')); ?>" alt="" />
								</div>
																
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12 grid-item cat1">
							<div class="portfolio">
								<div class="portfolio-img">
									<img src="<?php echo esc_url(get_theme_mod('work_image_9')); ?>" alt="" />
								</div>
																
							</div>
						
					</div>		
				</div>
				
			</div>
		</div>	
            
            <div class="project-count-area gray-bg ptb-100">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                        <div class="single-count">
                            <div class="count-icon">
                                <span class="icon-briefcase"></span>
                            </div>
                            <div class="count-title">
                                <h2 class="count"><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-val-desc1')); ?></h2>
                                <span><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-val-head1')); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="single-count">
                            <div class="count-icon">
                                <span class="icon-wine"></span>
                            </div>
                            <div class="count-title">
                                <h2 class="count"><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-val-desc2')); ?></h2>
                                <span><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-val-head2')); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="single-count">
                            <div class="count-icon">
                                <span class="icon-lightbulb"></span>
                            </div>
                            <div class="count-title">
                                <h2 class="count"><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-val-desc3')); ?></h2>
                                <span><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-val-head3')); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="single-count res-count">
                            <div class="count-icon">
                                <span class="icon-happy"></span>
                            </div>
                            <div class="count-title">
                                <h2 class="count"><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-val-desc4')); ?></h2>
                                <span><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-val-head4')); ?></span>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div id="team-area" class="team-area pt-90 pb-70">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="section-title">
                                <h2><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ot-head')); ?></h2>
                                <p><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-ot-desc')); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="team-wrapper">
                                <div class="team-member">
                                    <img src="<?php echo esc_url(get_theme_mod('team_image_1')); ?>" alt="" />
                                    
                                </div>
                                <div class="team-info text-center">
                                    <h3><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-p-head1')); ?></h3>
                                    <span><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-p-desc1')); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="team-wrapper">
                                <div class="team-member">
                                    <img src="<?php echo esc_url(get_theme_mod('team_image_2')); ?>" alt="" />
                                    
                                </div>
                                <div class="team-info text-center">
                                    <h3><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-p-head2')); ?></h3>
                                    <span><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-p-desc2')); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="team-wrapper">
                                <div class="team-member">
                                    <img src="<?php echo esc_url(get_theme_mod('team_image_3')); ?>" alt="" />
                                    
                                </div>
                                <div class="team-info text-center">
                                    <h3><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-p-head3')); ?></h3>
                                    <span><?php echo esc_html(get_theme_mod('lwp-portfolio-callout-p-desc3')); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
                            
            
    
 <?php get_footer(); ?>