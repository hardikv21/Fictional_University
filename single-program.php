<?php
    get_header();
    while(have_posts())
    {
        the_post();
?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php
        echo get_theme_file_uri("images/ocean.jpg");
    ?>);"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php
            the_title();    
        ?></h1>
        <div class="page-banner__intro">
            <p>Learn how the school of your dreams got started.</p>
        </div>
    </div>  
</div>

<div class="container container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
            <a class="metabox__blog-home-link" href="<?php
                echo get_post_type_archive_link("program");
            ?>">
                <i class="fa fa-home" aria-hidden="true"></i> Back to Programs
            </a> <span class="metabox__main">
                Published by <?php
                    the_author_posts_link();
                ?>
            </span>
        </p>
    </div>
    <div class="generic-content">
        <?php
            the_content();
        ?>
    </div>
    <?php
        $today = date("Ymd"); 
        $eventsQuery = new WP_Query(array(
            "posts_per_page" => 2,
            "post_type" => "event",
            "meta_key" => "event_date",
            "orderby" => "meta_value_num",
            "order" => "ASC",
            "meta_query" => array(
                array(
                    "key" => "event_date",
                    "compare" => ">=",
                    "value" => $today,
                    "type" => "numeric"
                ),
                array(
                    "key" => "related_programs",
                    "compare" => "LIKE",
                    "value" => '"' . get_the_ID() . '"'
                )
            )
        ));
        if($eventsQuery -> have_posts())
        { 
    ?>
            <hr class="section-break">
            <h2 class="headline headline--medium">Upcoming Events</h2>
        <?php
            while($eventsQuery -> have_posts())
            {
                $eventsQuery -> the_post();
        ?>
            <div class="event-summary">
                <a class="event-summary__date t-center" href="<?php
                    the_permalink();
                ?>">
                    <span class="event-summary__month"><?php
                        $date = new DateTime(get_field("event_date"));
                        echo $date -> format("M");
                    ?></span>
                    <span class="event-summary__day"><?php
                        echo $date -> format("j");
                    ?></span>
                </a>
                <div class="event-summary__content">
                    <h5 class="event-summary__title headline headline--tiny">
                        <a href="<?php
                            the_permalink();
                        ?>"><?php
                            the_title();
                        ?></a>
                    </h5>
                    <p>
                        <?php
                            if(has_excerpt())
                            {
                                echo get_the_excerpt();
                            }
                            else
                            {
                                echo wp_trim_words(get_the_content(), 21);
                            }
                        ?> <a href="<?php
                            the_permalink();
                        ?>" class="nu gray">Learn more</a>
                    </p>
                </div>
            </div>
        <?php
            }
        }
        wp_reset_postdata();
        ?>
</div>

<?php
    }
    get_footer();
?>