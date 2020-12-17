<?php
    function university_files()
    {
        wp_enqueue_style("google-fonts", "//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i");
        wp_enqueue_style("font-awesome", "//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
        
        if(strstr($_SERVER["SERVER_NAME"], "fictional-university.local"))
        {
            wp_enqueue_script("university-js", "http://localhost:3000/bundled.js", NULL, '1.0', true);
        }
        else
        {
            wp_enqueue_script("vendor-js", get_theme_file_uri("/bundled-assets/vendors~scripts.8c97d901916ad616a264.js'1.0'", true));
            wp_enqueue_script("university-js", get_theme_file_uri("/bundled-assets/scripts.bc49dbb23afb98cfc0f7.js'1.0'", true));
            wp_enqueue_style("main-styles", get_theme_file_uri("/bundled-assets/styles.bc49dbb23afb98cfc0f7.css"));
        }
    }

    add_action("wp_enqueue_scripts", "university_files");

    function university_titles()
    {
        add_theme_support("title-tag");
    }

    add_action("after_setup_theme", "university_titles");

    function university_event_adjust_query($query)
    {
        if(!is_admin() AND is_post_type_archive("event") AND $query -> is_main_query())
        {
            $today = date("Ymd");
            $query -> set("post_type", "event");
            $query -> set("meta_key", "event_date");
            $query -> set("orderby", "meta_value_num");
            $query -> set("order", "ASC");
            $query -> set("meta_query", array(
                array(
                    "key" => "event_date",
                    "compare" => ">=",
                    "value" => $today,
                    "type" => "numeric"
                )
            ));
        }
    }

    add_action("pre_get_posts", "university_event_adjust_query");
?>