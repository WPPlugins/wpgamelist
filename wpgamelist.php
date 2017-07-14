<?php
header("Access-Control-Allow-Origin: *");
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
Plugin Name: WordPress Game List - A Forward Creation
Plugin URI: https://www.jakerevans.com
Description: A plugin that displays your video games! Simply paste this shortcode on a page or post to get started: <strong>[wpgamelist_shortcode]</strong>.
Version: 1.8
Author: Jake Evans - Forward Creation
Author URI: https://www.jakerevans.com
License: GPL2
*/ 

add_shortcode('wpgamelist_shortcode', 'wpgamelist_jre_plugin_dynamic_shortcode_function');
register_activation_hook( __FILE__, 'wpgamelist_jre_create_tables' );
register_deactivation_hook( __FILE__, 'wpgamelist_jre_delete_tables' );
add_action( 'wp_footer', 'wpgamelist_homepage_pretties' );
add_action( 'wp_footer', 'wpgamelist_form_checks_javascript' );
add_action( 'wp_footer', 'wpgamelist_jre_sort_selection_javascript' );
add_action( 'wp_footer', 'wpgamelist_jre_search_javascript' );
add_action( 'wp_footer', 'wpgamelist_jre_page_control_javascript' );
add_filter('language_attributes', 'wpgamelist_jre_add_opengraph_nameser');
add_action( 'admin_menu', 'wpgamelist_jre_my_admin_menu' );
add_action('wp_enqueue_scripts', 'wpgamelist_jre_plugin_front_style' );
add_action('wp_enqueue_scripts', 'wpgamelist_jre_plugin_colorbox_style' );
add_action('wp_enqueue_scripts', 'wpgamelist_jre_plugin_colorbox_script' );
add_action('wp_enqueue_scripts', 'wpgamelist_jre_plugin_addthis_script' );
add_action('admin_enqueue_scripts', 'wpgamelist_jre_plugin_admin_style' );
add_action( 'in_admin_footer', 'wpgamelist_jre_admin_clear_javascript' );
add_action( 'in_admin_footer', 'wpgamelist_jre_display_options_javascript' );
add_action( 'init', 'wpgamelist_jre_register_table_name', 1 );
// Adding Ajax library
add_action( 'wp_head', 'wpgamelist_jre_add_ajax_library' );
//For loading in new game form
add_action( 'wp_footer', 'wpgamelist_jre_game_addition_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpgamelist_jre_game_addition_action', 'wpgamelist_jre_game_addition_action_callback' );
add_action( 'wp_ajax_nopriv_wpgamelist_jre_game_addition_action', 'wpgamelist_jre_game_addition_action_callback' );
// For searching & adding new games
add_action( 'wp_footer', 'wpgamelist_add_game_action_javascript' ); 
add_action( 'wp_ajax_wpgamelist_add_game_action', 'wpgamelist_add_game_action_callback' );
add_action( 'wp_ajax_nopriv_wpgamelist_add_game_action', 'wpgamelist_add_game_action_callback' );

//For showing spreadsheet form ui
add_action( 'wp_footer', 'wpgamelist_jre_upload_excel_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpgamelist_jre_create_upload_action', 'wpgamelist_jre_create_upload_action_callback' );
add_action( 'wp_ajax_nopriv_wpgamelist_jre_create_upload_action', 'wpgamelist_jre_create_upload_action_callback' );
//For creating spreadsheet
add_action( 'wp_footer', 'wpgamelist_jre_create_excel_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpgamelist_jre_create_excel_action', 'wpgamelist_jre_create_excel_action_callback' );
add_action( 'wp_ajax_nopriv_wpgamelist_jre_create_excel_action', 'wpgamelist_jre_create_excel_action_callback' );
// For saving/restoring spreadsheet
add_action( 'wp_footer', 'wpgamelist_create_spreadsheet_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpgamelist_create_spreadsheet_action', 'wpgamelist_create_spreadsheet_action_callback' );
add_action( 'wp_ajax_nopriv_wpgamelist_create_spreadsheet_action', 'wpgamelist_create_spreadsheet_action_callback' );
// For displaying game info in colorbox
add_action( 'wp_footer', 'wpgamelist_savedgame_action_javascript' );
add_action( 'wp_ajax_savedgame_action', 'wpgamelist_savedgame_action_callback' );
add_action( 'wp_ajax_nopriv_savedgame_action', 'wpgamelist_savedgame_action_callback' );
//For loading in game deletion form
add_action( 'wp_footer', 'wpgamelist_jre_game_delete_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpgamelist_jre_game_delete_action', 'wpgamelist_jre_game_delete_action_callback' );
add_action( 'wp_ajax_nopriv_wpgamelist_jre_game_delete_action', 'wpgamelist_jre_game_delete_action_callback' );
// For deleting an entry
add_action( 'wp_footer', 'wpgamelist_delete_entry_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpgamelist_delete_entry_action', 'wpgamelist_delete_entry_action_callback' );
add_action( 'wp_ajax_nopriv_wpgamelist_delete_entry_action', 'wpgamelist_delete_entry_action_callback' );
// For Editing a game
add_action( 'wp_footer', 'wpgamelist_game_edit_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpgamelist_game_edit_action', 'wpgamelist_game_edit_action_callback' );
add_action( 'wp_ajax_nopriv_wpgamelist_game_edit_action', 'wpgamelist_game_edit_action_callback' );
// For saving game edits to DB
add_action( 'wp_footer', 'wpgamelist_save_game_edit_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpgamelist_save_game_edit_action', 'wpgamelist_save_game_edit_action_callback' );
add_action( 'wp_ajax_nopriv_wpgamelist_save_game_edit_action', 'wpgamelist_save_game_edit_action_callback' );
// For setting display options
add_action( 'admin_footer', 'wpgamelist_display_options_action_javascript' );
add_action( 'wp_ajax_wpgamelist_display_options_action', 'wpgamelist_display_options_action_callback' );
add_action( 'wp_ajax_nopriv_wpgamelist_display_options_action', 'wpgamelist_display_options_action_callback' );
// For creating/deleting custom libraries
add_action( 'admin_footer', 'wpgamelist_new_lib_shortcode_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpgamelist_new_lib_shortcode_action', 'wpgamelist_new_lib_shortcode_action_callback' );
add_action( 'wp_ajax_nopriv_wpgamelist_new_lib_shortcode_action', 'wpgamelist_new_lib_shortcode_action_callback' );

//For uploading new stylepak file
add_action( 'admin_footer', 'wpgamelist_jre_stylepak_file_upload_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpgamelist_jre_stylepak_file_upload_action', 'wpgamelist_jre_stylepak_file_upload_action_callback' );
add_action( 'wp_ajax_nopriv_wpgamelist_jre_stylepak_file_upload_action', 'wpgamelist_jre_stylepak_file_upload_action_callback' );

//For setting stylepak file
add_action( 'admin_footer', 'wpgamelist_jre_stylepak_selection_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpgamelist_jre_stylepak_selection_action', 'wpgamelist_jre_stylepak_selection_action_callback' );
add_action( 'wp_ajax_nopriv_wpgamelist_jre_stylepak_selection_action', 'wpgamelist_jre_stylepak_selection_action_callback' );

//For dismissing notice
add_action( 'admin_footer', 'wpgamelist_jre_dismiss_notice_forever_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_wpgamelist_jre_dismiss_notice_forever_action', 'wpgamelist_jre_dismiss_notice_forever_action_callback' );
add_action( 'wp_ajax_nopriv_wpgamelist_jre_dismiss_notice_forever_action', 'wpgamelist_jre_dismiss_notice_forever_action_callback' );


//game and Open Graph nameservers
function wpgamelist_jre_add_opengraph_nameser( $output ) {
  return $output . '
  xmlns:og="https://opengraphprotocol.org/schema/"
  xmlns:fb="https://www.game.com/2008/fbml"';
}

function wpgamelist_jre_for_reviews_and_wpgamelist_admin_notice__success() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'wpgamelist_jre_user_options';
  $options_row = $wpdb->get_results("SELECT * FROM $table_name");
  $dismiss = $options_row[0]->admindismiss;
  if($dismiss == 1){
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php _e( "<span style='font-weight:bold; font-size: 15px; font-style:italic;'>Happy with WPGameList are ya?</span> Then you'll be thrilled with the <span style='font-weight:bold; font-size: 15px; font-style:italic;'><a href='https://www.jakerevans.com/product/wordpress-game-list-premium/'>Premium Version of WPGameList!</a></span> Display even more awesome info and media about each title! <a href='https://www.jakerevans.com/product/wordpress-game-list-premium/'>Try it today!</a> Also, if you're happy with WPGameList, then please consider <a href='https://wordpress.org/support/plugin/wpgamelist/reviews/'>leaving me a 5-star review</a>.<p><a href='https://www.jakerevans.com/shop/'>StylePaks</a> are now avaliable! Quickly and easily change the <a href='https://www.jakerevans.com/shop/'>look and feel of WPGameList Now!</a></p><p>-Jake</p><div id='wpgamelist-my-notice-dismiss-forever'>Dismiss Forever</div>", 'sample-text-domain' ); ?></p>
    </div>
    <?php
  }
}
add_action( 'admin_notices', 'wpgamelist_jre_for_reviews_and_wpgamelist_admin_notice__success' );

// Code for adding the CSS file
function wpgamelist_jre_plugin_front_style() {
    global $wpdb;
    $table_name_options = $wpdb->prefix . 'wpgamelist_jre_user_options';
    $options_results = $wpdb->get_row("SELECT * FROM $table_name_options");
    $stylepak = $options_results->stylepak;
    $uploads = wp_upload_dir();

    if($stylepak == 'Default'){
      wp_register_style( 'uigamelist', plugins_url('/css/uigamelist.css', __FILE__ ) );
      wp_enqueue_style('uigamelist');
    }

    if($stylepak == 'WPGameListStylePak1'){
      wp_register_style( 'WPGameListStylePak1', $uploads['baseurl'].'/wpgamelist/stylepak-exports/WPGameListStylePak1.css');
      wp_enqueue_style('WPGameListStylePak1');
    }

    if($stylepak == 'WPGameListStylePak2'){
      wp_register_style( 'WPGameListStylePak2', $uploads['baseurl'].'/wpgamelist/stylepak-exports/WPGameListStylePak2.css');
      wp_enqueue_style('WPGameListStylePak2');
    }
}  

// Code for adding the CSS file that is displayed if the admin is logged in
function wpgamelist_jre_plugin_admin_style() {
    if(current_user_can( 'administrator' )){
        wp_register_style( 'admingamelist', plugins_url('/css/admingamelist.css', __FILE__ ) );
        wp_enqueue_style('admingamelist');
    }
}

// Function to add table name to the global $wpdb
function wpgamelist_jre_register_table_name() {
    global $wpdb;
    $wpdb->wpgamelist_jre_saved_game_log = "{$wpdb->prefix}wpgamelist_jre_saved_game_log";
    $wpdb->wpgamelist_jre_user_options = "{$wpdb->prefix}wpgamelist_jre_user_options";
    $wpdb->wpgamelist_jre_list_dynamic_db_names = "{$wpdb->prefix}wpgamelist_jre_list_dynamic_db_names";
    $wpdb->wpgamelist_jre_saved_game_for_widget = "{$wpdb->prefix}wpgamelist_jre_saved_game_for_widget";
    $wpdb->wpgamelist_jre_list_platform_names = "{$wpdb->prefix}wpgamelist_jre_list_platform_names";
    $wpdb->wpgamelist_jre_list_company_names = "{$wpdb->prefix}wpgamelist_jre_list_company_names";
    $wpdb->wpgamelist_jre_list_genre_names = "{$wpdb->prefix}wpgamelist_jre_list_genre_names";
    $wpdb->wpgamelist_jre_game_quotes = "{$wpdb->prefix}wpgamelist_jre_game_quotes";
} 

// Code for adding the colorbox CSS file
function wpgamelist_jre_plugin_colorbox_style() {
    wp_register_style( 'colorboxcssforwpgamelist', plugins_url('/assets/css/colorbox.css', __FILE__ ) );
    wp_enqueue_style('colorboxcssforwpgamelist');
}

// Code for adding the colorbox js file
function wpgamelist_jre_plugin_colorbox_script() {
    wp_register_script( 'colorboxjsforwpgamelist', plugins_url('/assets/js/colorbox/jquery.colorbox.js?v=2.1.8', __FILE__ ), array('jquery'));
    wp_enqueue_script('colorboxjsforwpgamelist');
}

// Code for adding the addthis js file
function wpgamelist_jre_plugin_addthis_script() {
    wp_register_script( 'addthisjsforwpgamelist', plugins_url('/assets/js/addthis.js', __FILE__ ), array('jquery'));
    wp_enqueue_script('addthisjsforwpgamelist');
}



// Runs once upon plugin activation
function wpgamelist_jre_create_tables() {
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  global $wpdb;
  global $charset_collate;  
  // Call this manually as we may have missed the init hook
  wpgamelist_jre_register_table_name();
  //Creating the table
  $sql_create_table1 = "CREATE TABLE {$wpdb->wpgamelist_jre_saved_game_log} 
  (
        ID bigint(255) auto_increment,
        name varchar(255),
        developer varchar(255),
        publisher varchar(255),
        releasedate varchar(255),
        yearfinished bigint(255),
        finished varchar(255),
        cover varchar(255),
        genre varchar(255),
        storyline MEDIUMTEXT,
        summary MEDIUMTEXT, 
        notes MEDIUMTEXT,
        vids MEDIUMTEXT,
        screenshots MEDIUMTEXT,
        igdburl varchar(255),
        rating bigint(255),
        platform varchar(255),
        PRIMARY KEY  (ID),
          KEY name (name)
  ) $charset_collate; ";
  dbDelta( $sql_create_table1 );

  $sql_create_table_widget = "CREATE TABLE {$wpdb->wpgamelist_jre_saved_game_for_widget} 
  (
        ID bigint(255) auto_increment,
        name varchar(255),
        developer varchar(255),
        publisher varchar(255),
        releasedate varchar(255),
        yearfinished bigint(255),
        finished varchar(255),
        cover varchar(255),
        genre varchar(255),
        storyline MEDIUMTEXT,
        summary MEDIUMTEXT, 
        notes MEDIUMTEXT,
        vids MEDIUMTEXT,
        screenshots MEDIUMTEXT,
        igdburl varchar(255),
        rating bigint(255),
        platform varchar(255),
        PRIMARY KEY  (ID),
          KEY name (name)
  ) $charset_collate; ";
  dbDelta( $sql_create_table_widget );
    
  $sql_create_table2 = "CREATE TABLE {$wpdb->wpgamelist_jre_user_options} 
  (
        ID bigint(255) auto_increment,
        username varchar(255),
        amazonaff varchar(255) NOT NULL DEFAULT 'wpgamelistid-20',
        barnesaff varchar(255),
        itunesaff varchar(255) NOT NULL DEFAULT '1010lnPx',
        gameinfo varchar(255),
        twitterinfo varchar(255),
        goodreadsinfo varchar(255),
        hideaddgame bigint(255),
        hidestats bigint(255),
        hideeditdelete bigint(255),
        hidesortby bigint(255),
        hidesearch bigint(255),
        hidefacebook bigint(255),
        hidemessenger bigint(255),
        hidetwitter bigint(255),
        hidegoogleplus bigint(255),
        hidepinterest bigint(255),
        hideemail bigint(255),
        hidebackupdownload bigint(255),
        hidedescription bigint(255),
        hidevids bigint(255),
        hidenotes bigint(255),
        hidebottompurchase bigint(255),
        hidequotegame bigint(255),
        hidescreenshots bigint(255),
        sortoption varchar(255),
        gamesonpage bigint(255) NOT NULL DEFAULT 12,
        email varchar(255),
        accountcreation varchar(255),
        amazoncountryinfo varchar(255) NOT NULL DEFAULT 'US',
        stylepak varchar(255) NOT NULL DEFAULT 'Default',
        admindismiss bigint(255) NOT NULL DEFAULT 1,
        PRIMARY KEY  (ID),
          KEY username (username)
  ) $charset_collate; ";
  dbDelta( $sql_create_table2 );

  $sql_create_table3 = "CREATE TABLE {$wpdb->wpgamelist_jre_list_dynamic_db_names} 
  (
        ID bigint(255) auto_increment,
        user_table_name varchar(255) NOT NULL,
        PRIMARY KEY  (ID),
          KEY user_table_name (user_table_name)
  ) $charset_collate; ";
  dbDelta( $sql_create_table3 ); 

  $sql_create_table4 = "CREATE TABLE {$wpdb->wpgamelist_jre_list_platform_names} 
  (
        ID bigint(255) auto_increment,
        matchingid bigint(255),
        platformname varchar(255),
        PRIMARY KEY  (ID),
          KEY platformname (platformname)
  ) $charset_collate; ";
  dbDelta( $sql_create_table4 );

  $sql_create_table5 = "CREATE TABLE {$wpdb->wpgamelist_jre_list_company_names} 
  (
        ID bigint(255) auto_increment,
        matchingcompid bigint(255),
        companyname varchar(255),
        PRIMARY KEY  (ID),
          KEY companyname (companyname)
  ) $charset_collate; ";
  dbDelta( $sql_create_table5 ); 

  $sql_create_table6 = "CREATE TABLE {$wpdb->wpgamelist_jre_list_genre_names} 
  (
        ID bigint(255) auto_increment,
        matchinggenreid bigint(255),
        genrename varchar(255),
        PRIMARY KEY  (ID),
          KEY genrename (genrename)
  ) $charset_collate; ";
  dbDelta( $sql_create_table6 ); 

  $sql_create_table7 = "CREATE TABLE {$wpdb->wpgamelist_jre_game_quotes} 
  (
        ID bigint(255) auto_increment,
        placement varchar(255),
        quote varchar(255),
        PRIMARY KEY  (ID),
          KEY quote (quote)
  ) $charset_collate; ";
  dbDelta( $sql_create_table7 );

  $quote_string = '"With WPGameList Premium, you can add your Amazon Affiliate ID to each entry on your site! <a href="https://www.jakerevans.com/product/wordpress-game-list-premium/">Get WPGameList Premium now!</a>";"With WPGameList Premium, you can display your XBox Live Achievements! <a href="https://www.jakerevans.com/product/wordpress-game-list-premium/">Get WPGameList Premium now!</a>";"With WPGameList Premium, you can display awesome, colorful backdrop images. <a href="https://www.jakerevans.com/product/wordpress-game-list-premium/">Get WPGameList Premium now!</a>";<a href="https://www.jakerevans.com/product/wordpress-game-list-premium/">Get WPGameList Premium now!</a>;<a href="https://www.jakerevans.com/product/wordpress-game-list-premium/">Get WPGameList Premium now!</a>;With WPGameList Premium, you can display famous game quotes! <a href="https://www.jakerevans.com/product/wordpress-game-list-premium/">Get WPGameList Premium now!</a>;With WPGameList Premium, you can set the default sorting site-wide! <a href="https://www.jakerevans.com/product/wordpress-game-list-premium/">Get WPGameList Premium now!</a>;With WPGameList Premium, you can rate titles with 1-5 stars! <a href="https://www.jakerevans.com/product/wordpress-game-list-premium/">Get WPGameList Premium now!</a>;Like Books? Then <a href="https://wordpress.org/plugins/wpbooklist/">check out WPBookList now!</a>;Like Video Games? Then <a href="https://wordpress.org/plugins/wpgamelist/">check out WPGameList now!</a>;Display books on your site with your Amazon Affiliate ID! <a href="https://www.jakerevans.com/product/wordpress-book-list-premium/">Get WPBookList Premium now!</a>;Display video games on your site with your Amazon Affiliate ID! <a href="https://www.jakerevans.com/product/wordpress-game-list-premium/">Get WPGameList Premium now!</a>;Like Movies? Then <a href="https://wordpress.org/plugins/wpfilmlist/">check out WPFilmList now!</a>;Like TV? Then <a href="https://wordpress.org/plugins/wpfilmlist/">check out WPFilmList now!</a>;Display Movies on your site with your Amazon Affiliate ID! <a href="https://www.jakerevans.com/product/wordpress-film-list-premium/">Get WPFilmList Premium now!</a>;Display TV Shows on your site with your Amazon Affiliate ID! <a href="https://www.jakerevans.com/product/wordpress-film-list-premium/">Get WPFilmList Premium now!</a>';

  $quote_array = explode(';', $quote_string);
  $table_name = $wpdb->prefix . 'wpgamelist_jre_game_quotes';
  foreach($quote_array as $quote){
      $placement = 'game';
    if(strlen($quote) > 1){
      $wpdb->insert( $table_name, array('quote' => $quote, 'placement' => $placement)); 
    }
  }





  $table_name = $wpdb->prefix . 'wpgamelist_jre_user_options';
  $wpdb->insert( $table_name, array('ID' => 1)); 

  // Reading in platform names into database
  $file = fopen(plugin_dir_path( __FILE__ ).'assets/json/platform_list.json',"r");
    //Output a line of the file until the end is reached
    $line = fgets($file);
    while(!feof($file)){
        $string = str_replace('\n', '', $line);
        $string = rtrim($string, ',');
        $string = "[" . trim($string) . "]";
        $json = json_decode($string, true);
        $matchingid = (int)$json[0]['matchingid'];
        $platformname = $json[0]['platformname'];
        $table_name = $wpdb->prefix.'wpgamelist_jre_list_platform_names';
        $wpdb->insert( 
                $table_name, 
                array(
                      'matchingid' => $matchingid, 
                      'platformname' => $platformname,
                ),
                array(
                        '%d',
                        '%s'
                )   
        );
        $line = fgets($file);
    }
    fclose($file);

    // Reading in Company names to the database
    $file = fopen(plugin_dir_path( __FILE__ ).'assets/json/company_names_formatted_backup.json',"r");
    //Output a line of the file until the end is reached
    $line = fgets($file);
    while(!feof($file)){
        $string = str_replace('\n', '', $line);
        $string = rtrim($string, ',');
        $string = "[" . trim($string) . "]";
        $json = json_decode($string, true);
        $matchingcompid = (int)$json[0]['matchingcompid'];
        $companyname = $json[0]['companyname'];
        $table_name = $wpdb->prefix.'wpgamelist_jre_list_company_names';
        $wpdb->insert( 
                $table_name, 
                array(
                      'matchingcompid' => $matchingcompid, 
                      'companyname' => $companyname,
                ),
                array(
                        '%d',
                        '%s'
                )   
        );
        $line = fgets($file);
    }
    fclose($file);

    // Reading in genre names to the database
    $file = fopen(plugin_dir_path( __FILE__ ).'assets/json/genre_names.json',"r");
    //Output a line of the file until the end is reached
    $line = fgets($file);
    while(!feof($file)){
        $string = str_replace('\n', '', $line);
        $string = rtrim($string, ',');
        $string = "[" . trim($string) . "]";
        $json = json_decode($string, true);
        $matchinggenreid = (int)$json[0]['id'];
        $genrename = $json[0]['name'];
        $table_name = $wpdb->prefix.'wpgamelist_jre_list_genre_names';
        $wpdb->insert( 
                $table_name, 
                array(
                      'matchinggenreid' => $matchinggenreid, 
                      'genrename' => $genrename,
                ),
                array(
                        '%d',
                        '%s'
                )   
        );
        $line = fgets($file);
    }
    fclose($file);

}

// Code for deleting wpgamelist_jre_saved_text_log table upon deactivation of plugin
function wpgamelist_jre_delete_tables() {
    global $wpdb;
    $table1 = $wpdb->prefix."wpgamelist_jre_saved_game_log";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table1", $table1));
    
    $table2 = $wpdb->prefix."wpgamelist_jre_user_options";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table2", $table2));
    
    $table3 = $wpdb->prefix."wpgamelist_jre_list_dynamic_db_names";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table3", $table3));

    $table4 = $wpdb->prefix."wpgamelist_jre_saved_game_for_widget";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table4", $table4));

    $table5 = $wpdb->prefix."wpgamelist_jre_list_platform_names";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table5", $table5));

    $table6 = $wpdb->prefix."wpgamelist_jre_list_company_names";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table6", $table6));

    $table7 = $wpdb->prefix."wpgamelist_jre_list_genre_names";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table7", $table7));

    $table8 = $wpdb->prefix."wpfilmlist_jre_movie_quotes";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table8", $table8));

    
    
    $user_created_tables = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table3", $table3), $table3);
    foreach($user_created_tables as $utable){
      $table = $wpdb->prefix."wpgamelist_jre_".$utable->user_table_name;
      $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table", $table));
    }
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table3", $table3));
}

// Function to allow users to specify which table they want displayed by passing as an argument in the shortcode
function wpgamelist_jre_plugin_dynamic_shortcode_function($atts){
  global $wpdb;
  extract(shortcode_atts(array(
          'table' => $wpdb->prefix."saved_game_log",
  ), $atts));
  $which_table = $wpdb->prefix . 'wpgamelist_jre_'.$table;
  if($atts == null){
    $which_table = $wpdb->prefix.'wpgamelist_jre_saved_game_log';
  }
  $GLOBALS['a'] = $which_table;
  ob_start();
  include_once( plugin_dir_path( __FILE__ ) . 'ui.php');
}

function wpgamelist_jre_my_admin_menu() {
  add_menu_page( 'WP game List Options', 'WP Game List', 'manage_options', 'WP-game-List-Options', 'wpgamelist_jre_admin_page_function', plugins_url('/assets/img/wpgamelistdashboardicon.png', __FILE__ ), 6  );
}

function wpgamelist_jre_admin_page_function(){
  // calling file that handles all options page stuff
  include 'backend.php';
}

/*
 * Adds the WordPress Ajax Library to the frontend.
*/
function wpgamelist_jre_add_ajax_library() {
 
    $html = '<script type="text/javascript">';

    // checking $protocol in HTTP or HTTPS
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
        // this is HTTPS
        $protocol  = "https";
    } else {
        // this is HTTP
        $protocol  = "http";
    }
    $tempAjaxPath = admin_url( 'admin-ajax.php' );
    $goodAjaxUrl = $protocol.strchr($tempAjaxPath,':');

    $html .= 'var ajaxurl = "' . $goodAjaxUrl . '"';
    $html .= '</script>';
    echo $html;
    
} // End add_ajax_library

// Controls the fade-in and movement of the images and link elements upon page load
function wpgamelist_homepage_pretties(){?>
  <script type="text/javascript" >
  jQuery(document).ready(function() {
    setTimeout(function(){
      jQuery(".wpgamelist-select-game-by-img-class").animate({opacity:1})
    }, 1000);
    setTimeout(function(){
      jQuery(".wpgamelist_saved_title_link").animate({opacity:1})
    }, 1600);
    setTimeout(function(){
      jQuery(".wpgamelist_edit_entry_link").animate({opacity:1})
    }, 1600);
    setTimeout(function(){
      jQuery(".wpgamelist_delete_entry_link").animate({opacity:1})
    }, 1600);
  });
  </script>
  <?php
}  

function wpgamelist_form_checks_javascript(){ ?>
  <script type="text/javascript" >
  // Checks for the Edit game Form
  jQuery(document).on("change","#wpgamelist_finished_yes_edit", function(event){
    if (this.checked){
      jQuery(".wpgamelist_year_finished_text_edit_class").animate({opacity:1});
      jQuery(".wpgamelist_year_finished_label_edit_class").animate({opacity:1});
      jQuery("#wpgamelist_year_finished_edit").attr("disabled", false);
      jQuery(".wpgamelist_year_finished_text_edit_class").attr("disabled", false);
      jQuery("#wpgamelist_year_finished_edit").attr("value", '<?php echo esc_attr(date("Y")); ?>');
      jQuery("#wpgamelist_year_finished_edit").animate({opacity:1});
      jQuery('#wpgamelist_finished_no_edit').prop('checked', false);
    } else {
      jQuery("#wpgamelist_year_finished_edit").attr("value", '');
      jQuery(".wpgamelist_year_finished_text_edit_class").attr("disabled", true);
      jQuery(".wpgamelist_year_finished_text_edit_class").animate({opacity:0.5});
      jQuery(".wpgamelist_year_finished_label_edit_class").animate({opacity:0.5});
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  jQuery(document).on("change","#wpgamelist_finished_no_edit", function(event){
    if (this.checked) {
      jQuery(".wpgamelist_year_finished_text_edit_class").attr("disabled", true);
      jQuery(".wpgamelist_year_finished_text_edit_class").attr("value", '');
      jQuery(".wpgamelist_year_finished_text_edit_class").animate({opacity:0.5});
      jQuery(".wpgamelist_year_finished_label_edit_class").animate({opacity:0.5});
      jQuery('#wpgamelist_finished_yes_edit').prop('checked', false);
    }else {
      jQuery("#wpgamelist_year_finished_edit").animate({opacity:0.5});
      jQuery("#wpgamelist_year_finished_label_edit").animate({opacity:0.5});
    }
  });
  jQuery(document).on("change","#wpgamelist_game_signed_yes_edit", function(event){
    if (this.checked) {
      jQuery('#wpgamelist_game_signed_no_edit').prop('checked', false);
    }else {
      jQuery('#wpgamelist_game_signed_yes_edit').prop('checked', false);
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  jQuery(document).on("change","#wpgamelist_game_signed_no_edit", function(event){
    if (this.checked) {
      jQuery('#wpgamelist_game_signed_yes_edit').prop('checked', false);
    }else {
      jQuery('#wpgamelist_game_signed_no_edit').prop('checked', false);
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  jQuery(document).on("change","#wpgamelist_game_first_edition_yes_edit", function(event){
    if (this.checked) {
      jQuery('#wpgamelist_game_first_edition_no_edit').prop('checked', false);
    }else {
      jQuery('#wpgamelist_game_first_edition_yes_edit').prop('checked', false);
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  jQuery(document).on("change","#wpgamelist_game_first_edition_no_edit", function(event){
    if (this.checked) {
      jQuery('#wpgamelist_game_first_edition_yes_edit').prop('checked', false);
    }else {
      jQuery('#wpgamelist_game_first_edition_no_edit').prop('checked', false);
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  // Checks for the Add game Form
  jQuery(document).on("change"," #wpgamelist_finished_yes", function(event){
    if (this.checked) {
      jQuery(" #wpgamelist_year_finished").attr("disabled", false);
      jQuery(" #wpgamelist_year_finished").attr("value", '<?php echo esc_attr(date("Y")); ?>');
      jQuery(" #wpgamelist_year_finished").animate({opacity:1});
      jQuery(" #wpgamelist_year_finished_label").animate({opacity:1});
      jQuery(' #wpgamelist_finished_no').prop('checked', false);
    } else {
      jQuery(" #wpgamelist_year_finished").attr("disabled", true);
      jQuery(" #wpgamelist_year_finished").attr("value", '');
      jQuery(" #wpgamelist_year_finished").animate({opacity:0.5});
      jQuery(" #wpgamelist_year_finished_label").animate({opacity:0.5});
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  jQuery(document).on("change","#wpgamelist_finished_no", function(event){
    if (this.checked) {
      jQuery(" #wpgamelist_year_finished").animate({opacity:0.5});
      jQuery(" #wpgamelist_year_finished_label").animate({opacity:0.5});
      jQuery(" #wpgamelist_year_finished").attr("disabled", true);
      jQuery(" #wpgamelist_year_finished").attr("value", '');
      jQuery(' #wpgamelist_finished_yes').prop('checked', false);
    }else {
      jQuery(" #wpgamelist_year_finished").attr("value", '');
      jQuery(" #wpgamelist_year_finished").animate({opacity:0.5});
      jQuery(" #wpgamelist_year_finished_label").animate({opacity:0.5});
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  jQuery(document).on("change"," #wpgamelist_game_signed_yes", function(event){
    if (this.checked) {
      jQuery(' #wpgamelist_game_signed_no').prop('checked', false);
    }else {
      jQuery(' #wpgamelist_game_signed_yes').prop('checked', false);
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  jQuery(document).on("change","#wpgamelist_game_signed_no", function(event){
    if (this.checked) {
      jQuery(' #wpgamelist_game_signed_yes').prop('checked', false);
    }else {
      jQuery(' #wpgamelist_game_signed_no').prop('checked', false);
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  jQuery(document).on("change","#wpgamelist_game_first_edition_yes", function(event){
    if (this.checked) {
      jQuery(' #wpgamelist_game_first_edition_no').prop('checked', false);
    }else {
      jQuery(' #wpgamelist_game_first_edition_yes').prop('checked', false);
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  jQuery(document).on("change","#wpgamelist_game_first_edition_no", function(event){
    if (this.checked) {
      jQuery(' #wpgamelist_game_first_edition_yes').prop('checked', false);
    }else {
      jQuery(' #wpgamelist_game_first_edition_no').prop('checked', false);
    }
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  </script>
  <?php
}

// Handles the search functionality. If neither author nor title slection is checked, the search will execute for both title and author.
function wpgamelist_jre_search_javascript() { ?>
  <script type="text/javascript" >
  jQuery(document).ready(function() {
    jQuery('#wpgamelist_search_sub_button').click(function() {
      var str = jQuery('#wpgamelist_search_text').val();
      str = str.replace(/[^a-z0-9áéíóúñü \.,_-]/gim,"");
      str.trim();
      var str2 = document.getElementById("wpgamelist_game_title_search").checked;
      if(window.location.href.indexOf("?update") != -1){
        var currentUrl = window.location.href.substring(0, window.location.href.indexOf("?update"));
        window.location = currentUrl+"?update=wpgamelist_search_sub_button&search_query=" + str +"&title_query=" + str2;
      }else {
        window.location = window.location.href+"?update=wpgamelist_search_sub_button&search_query=" + str +"&title_query=" + str2;
      }
    });
    jQuery('#wpgamelist_search_text').one('click', function() {
      jQuery(this).val("");
    });
  });
  </script>
  <?php
}

function wpgamelist_jre_game_addition_action_javascript() { ?>
  <script type="text/javascript" >
  jQuery('#wpgamelist_game_title_search').on('input', function() {
    jQuery('#wpgamelist_add_game_link').css({'pointer-events':'all'});
  });


  jQuery(document).on("click","#wpgamelist_add_game_link", function(event){

    var control = 0;
    var game_title = jQuery('#wpgamelist_game_title_search').val();
    var data = {
      'action': 'wpgamelist_jre_game_addition_action',
      'security': '<?php echo wp_create_nonce( "wpgamelist-jre-ajax-nonce-addgame" ); ?>',
      'game_title': game_title
    };

    jQuery.post(ajaxurl, data, function(response) {
          jQuery.colorbox({
          open: true,
          scrolling: true,
          width:'70%',
          height:'70%',
          html: response,
          data: data,
          title: '<p id="wpgamelist-add-titles-button">Add Selected Games</p>',
          onClosed:function(){
              //Do something on close.
          }, 
      });
    });
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });

  </script> <?php
}

function wpgamelist_jre_game_addition_action_callback() {
  global $wpdb;
  check_ajax_referer( 'wpgamelist-jre-ajax-nonce-addgame', 'security' );
  $table_name_options = $wpdb->prefix . 'wpgamelist_jre_user_options';
  $options_results = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name_options", $table_name_options));
  $game_title = sanitize_text_field(htmlspecialchars((trim($_POST['game_title'])), ENT_QUOTES));
  $game_title = str_replace('&#039;','’', $game_title);
  $get_from_amazon = 'false';

  $postdata = http_build_query(
      array(
          'game_title' => $game_title,
          'associate_tag' => $options_results->amazonaff
      )
  );
  $opts = array('http' =>
      array(
          'method'  => 'POST',
          'header'  => 'Content-type: application/x-www-form-urlencoded',
          'content' => $postdata
      )
  );

  $context = stream_context_create($opts);


    include_once( plugin_dir_path( __FILE__ ) . 'assets/unirest/src/Unirest.php');
    // These code snippets use an open-source library. http://unirest.io/php
    $response = Unirest\Request::get("https://igdbcom-internet-game-database-v1.p.mashape.com/games/?fields=*&limit=50&offset=0&order=release_dates.date%3Adesc&search=".$game_title,
      array(
        "X-Mashape-Key" => "o9lpK1W80jmshaYX8jiYzbBKF7uop1B2P5ujsnJ1oM7hmvfPfj",
        "Accept" => "application/json"
      )
    );

    $igdb_array = json_decode($response -> raw_body,TRUE);


    if($igdb_array == null){
    // Create a stream
    $opts = array(
      'http'=>array(
        'method'=>"GET",
        'header'=>"X-Mashape-Key: o9lpK1W80jmshaYX8jiYzbBKF7uop1B2P5ujsnJ1oM7hmvfPfj"               
      )
    );
    $context = stream_context_create($opts);
    // Open the file using the HTTP headers set above
    $res = file_get_contents('https://igdbcom-internet-game-database-v1.p.mashape.com/games/?fields=*&limit=50&offset=0&order=release_dates.date%3Adesc&search='.urlencode($game_title), false, $context);
    $igdb_array = json_decode($res, true);  
    }


    

    echo '<div class="wpgamelist-image-selection-div">';
    echo '<div style="margin-left: auto; margin-right: auto; padding-bottom: 20px; padding-top: 20px;font-size: 22px;font-style: italic; min-width: 195px; max-width: 275px; -webkit-text-stroke-width: 1px; -moz-text-stroke-width: 1px; -ms-text-stroke-width: 1px; text-stroke-width: 1px; -webkit-text-stroke-color: black; color: #888; margin-bottom: 10px;" class="wpgamelist-image-selction-title" id="wpgamelist-title">Select One of the Titles Below:</div>';
    foreach($igdb_array as $key=>$item){
      $cover_url = 'http://res.cloudinary.com/igdb/image/upload/t_cover_big/'.$item['cover']['cloudinary_id'].'.png';
      if($item['cover']['cloudinary_id'] == ''){
        $cover_url = plugins_url( '/assets/img/noimage.jpg', __FILE__ );
      }
      $storyline = htmlentities($item['storyline']);
      $summary = htmlentities($item['summary']);
      $igdb_url = htmlentities($item['url']);
      $rating = htmlentities($item['rating']);
      $rating = substr($rating, 0, 5);

      foreach($item['videos'] as $key=>$item2 ){
        $embed_vids = $embed_vids.$item2['video_id'].',';
      }

      foreach($item['screenshots'] as $key=>$item3 ){
        $screenshots = $screenshots.$item3['cloudinary_id'].',';
      }   

      // Getting platforms
      $platform_array = array();
      foreach($item['release_dates'] as $key=>$item4 ){
        array_push($platform_array, $item4['platform']);
      }  
      $table_name = $wpdb->prefix."wpgamelist_jre_list_platform_names";
      $platform_array = array_unique($platform_array);
      $final_plat_array = array();
      foreach($platform_array as $indiv_plat){
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE matchingid = %d", $indiv_plat));
        array_push($final_plat_array, $results[0]->platformname);
      }
      $platform_string = implode(", ",$final_plat_array);

      // Getting genres
      $genre_array = array();
      foreach($item['genres'] as $key=>$item5 ){
        array_push($genre_array, $item5);
      }  
      $table_name = $wpdb->prefix."wpgamelist_jre_list_genre_names";
      $genre_array = array_unique($genre_array);
      $final_genre_array = array();
      foreach($genre_array as $indiv_genre){
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE matchinggenreid = %d", $indiv_genre));
        array_push($final_genre_array, $results[0]->genrename);
      }
      $genre_string = implode(", ",$final_genre_array);

      // Getting first release date
      $date = (int)$item['first_release_date'];
      $date = date('Ymd', $date/1000);
      $date = date('F jS, Y', strtotime($date));

      // Getting developer, publisher, genre
      $developer = (int)$item['developers'][0];
      $publishers = (int)$item['publishers'];
      $table_name = $wpdb->prefix."wpgamelist_jre_list_company_names";
      $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE matchingcompid = %d", $developer));
      $developer_name = $results[0]->companyname;
      $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE matchingcompid = %d", $publishers));
      $publisher_name = $results[0]->companyname;

      echo '<div class="wpgamelist_bulk_entry_div"> <div class="wpgamelist_inner_main_display_bulk_div wpgamelist_inner_main_display_div_for_search wpgamelist_search_colorbox"> <img class="wpgamelist-bulk-select-game-by-img-class" id="wpgamelist-select-by-image-'.$key.'" src="'.$cover_url.'"/><p style="opacity: 1; color: rgb(240, 90, 26);" class="wpgamelist_saved_title_link" id="wpgamelist_bulk_add_title_link">'.$item['name'].'</p><label class="wpgamelist-label-entry-search">Add Game</label><input id="wpgamelist-checkbox-bulk-add-id-'.$key.'" class="wpgamelist-checkbox-bulk-add-class" type="checkbox" data-cover="'.$cover_url.'" data-name="'.$item['name'].'" data-igdburl="'.$igdb_url.'" data-storyline="'.$storyline.'" data-summary="'.$summary.'" data-screenshots="'.$screenshots.'" data-platform="'.$platform_string.'" data-vids="'.$embed_vids.'" data-release="'.$date.'" data-rating="'.$rating.'" data-developer="'.$developer_name.'" data-genre="'.$genre_string.'" data-publisher="'.$publisher_name.'"</input></div></div>';
    
      $embed_vids = '';
      $screenshots = '';
    }
}

function wpgamelist_add_game_action_javascript() { ?>
  <script type="text/javascript" >
  jQuery('body').on('click', '#wpgamelist-add-titles-button', function () {
    boxes = jQuery('.wpgamelist-checkbox-bulk-add-class');
    reloadInt = 0;
    indexer = 0;
    boxes.each(function(){
      if(jQuery(this).prop('checked') == true){
        reloadInt = reloadInt+1;
      }
    });
    boxes.each(function(index){
      choosentitle = jQuery(this);
      if(jQuery(this).prop('checked') == true){
        var cover = choosentitle.attr('data-cover');
        var name = choosentitle.attr('data-name');
        var igdburl = choosentitle.attr('data-igdburl');
        var storyline = choosentitle.attr('data-storyline');
        var summary = choosentitle.attr('data-summary');
        var screenshots = choosentitle.attr('data-screenshots');
        var platform = choosentitle.attr('data-platform');
        var vids = choosentitle.attr('data-vids');
        var release = choosentitle.attr('data-release');
        var rating = choosentitle.attr('data-rating');
        var developer = choosentitle.attr('data-developer');
        var genre = choosentitle.attr('data-genre');
        var publisher = choosentitle.attr('data-publisher');
        var array = vids.split(',');
        for (index = 0; index < array.length; ++index) {
          vids = vids+',<iframe width="640" height="360" src="https://www.youtube.com/embed/'+array[index]+'" frameborder="0" allowfullscreen></iframe>';
        }

        var table = "<?php echo esc_html($GLOBALS['a']) ?>";
        var data = {
          'action': 'wpgamelist_add_game_action',
          'table': table,
          'cover': cover,
          'name': name,
          'igdburl': igdburl,
          'storyline': storyline,
          'summary': summary,
          'screenshots': screenshots,
          'platform': platform,
          'vids': vids,
          'release': release,
          'rating': rating,
          'developer': developer,
          'genre': genre,
          'publisher': publisher,
          'security': '<?php echo wp_create_nonce( "wpgamelist-jre-ajax-nonce-add" ); ?>'

        };
        indexer++;
        jQuery.post(ajaxurl, data, function(response) {
          if(reloadInt == indexer){
            document.location.reload();
          }
        });
      }
    });
  });
  </script> <?php
}

function wpgamelist_add_game_action_callback() {
  global $wpdb;
  check_ajax_referer( 'wpgamelist-jre-ajax-nonce-add', 'security' );
  $table = filter_var($_POST['table'], FILTER_SANITIZE_STRING);
  $cover = filter_var($_POST['cover'], FILTER_VALIDATE_URL);
  $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
  $igdburl = filter_var($_POST['igdburl'], FILTER_VALIDATE_URL);
  $storyline = filter_var($_POST['storyline'], FILTER_SANITIZE_STRING);
  $summary = filter_var($_POST['summary'], FILTER_SANITIZE_STRING);
  $screenshots = filter_var($_POST['screenshots'], FILTER_SANITIZE_STRING);
  $platform = filter_var($_POST['platform'], FILTER_SANITIZE_STRING);
  $vids = filter_var($_POST['vids'], FILTER_SANITIZE_STRING);
  $release = filter_var($_POST['release'], FILTER_SANITIZE_STRING);
  $rating = filter_var($_POST['rating'], FILTER_SANITIZE_STRING);
  $developer = filter_var($_POST['developer'], FILTER_SANITIZE_STRING);
  $genre = filter_var($_POST['genre'], FILTER_SANITIZE_STRING);
  $publisher = filter_var($_POST['publisher'], FILTER_SANITIZE_STRING);

  $finished = 'no';
  if($year_finished != ''){
    $finished = 'yes';
  } 
  // yes no if yearfinished issn't blaknk $finished

 // Inserting final values into the WordPress database
  $wpdb->insert( $table, array(
                      'name' => $name, 
                      'developer' => $developer,
                      'publisher' => $publisher,
                      'releasedate' => $release,
                      'yearfinished' => $year_finished,
                      'finished' => $finished,
                      'cover' => $cover,
                      'genre' => $genre,
                      'storyline' => $storyline,
                      'summary' => $summary,
                      'notes' => $notes,
                      'vids' => $vids,
                      'screenshots' => $screenshots,
                      'igdburl' => $igdburl,
                      'rating' => $rating,
                      'platform' => $platform
                      ),
                   array(
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s',
                          '%s'
                      )   
              );
  wp_die(); // this is required to terminate immediately and return a proper response
}

function wpgamelist_game_edit_action_javascript() { ?>
  <script type="text/javascript" >
  jQuery('.wpgamelist_edit_entry_link').click(function(){
    var title = jQuery(this).find("span");
    var currentTable = '<?php echo esc_html($GLOBALS["a"]); ?>';
    title = title.html();

    // If theme adds in extra html for whatever reason
    if((title.includes('<')) || (title.includes('>'))){
      title = jQuery(title).text();
    }

    var data = {
      'action': 'wpgamelist_game_edit_action',
      'title': title,
      'table': currentTable,
      'security': '<?php echo wp_create_nonce( "wpgamelist-jre-ajax-nonce-edit" ); ?>'
    };

    jQuery.post(ajaxurl, data, function(response) {
      jQuery.colorbox({
        open: true,
        scrolling: true,
        width:'50%',
        height:'80%',
        html: response,
        data: data,
        onClosed:function(){
            //Do something on close.
        },
        onComplete:function(){
          if(jQuery('#wpgamelist_finished_no_edit').checked){
            jQuery('.wpgamelist_year_finished_text_edit_class').attr('disabled', true);
            jQuery('.wpgamelist_year_finished_text_edit_class').attr('value', '');
          }
        }
        });
    });
  });
  </script> <?php
}

function wpgamelist_game_edit_action_callback() {
  check_ajax_referer( 'wpgamelist-jre-ajax-nonce-edit', 'security' );
  global $wpdb; // this is how you get access to the database
  include_once( plugin_dir_path( __FILE__ ) . 'editentry.php');

  $id = intval($_POST['title']);
  $table = sanitize_text_field($_POST['table']);
  $saved_game = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE ID = $id", $table));
  //$saved_game = json_encode($saved_game);

  //echo $saved_game;
  wpgamelist_jre_editentry($saved_game);
  wp_die(); // this is required to terminate immediately and return a proper response
}

function wpgamelist_jre_game_delete_action_javascript() { ?>
  <script type="text/javascript" >
  jQuery(document).on("click","#wpgamelist_delete_game_link", function(event){

    var id = jQuery(this).find("span");
    id = id.html();
    var data = {
      'action': 'wpgamelist_jre_game_delete_action',
      'security': '<?php echo wp_create_nonce( "wpgamelist-jre-ajax-nonce-deletegame" ); ?>',
      'id': id
    };

    jQuery.post(ajaxurl, data, function(response) {
          jQuery.colorbox({
          open: true,
          scrolling: true,
          width:'30%',
          height:'30%',
          html: response,
          data: data,
          onClosed:function(){
              //Do something on close.
          }, 
      });
    });
    event.preventDefault ? event.preventDefault() : event.returnValue = false;

  });
  </script> <?php
}

function wpgamelist_jre_game_delete_action_callback() {
  check_ajax_referer( 'wpgamelist-jre-ajax-nonce-deletegame', 'security' );
  global $wpdb;
  include_once( plugin_dir_path( __FILE__ ) . 'deleteentry.php');
  $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
  wpgamelist_jre_deleteentry($id);
  wp_die(); 
}

function wpgamelist_delete_entry_action_javascript() { ?>
  <script type="text/javascript" >
  jQuery(document).on("click","#wpgamelist_delete_game_submit_button", function(event){
      var form = jQuery('#wpgamelist_delete_game_form');
     // form = form.serialize();
      var deleteId = jQuery('#delete_id').val();
      var currentTable = '<?php echo esc_html($GLOBALS["a"]); ?>';
console.log(deleteId);
console.log(currentTable);
    var data = {
      'action': 'wpgamelist_delete_entry_action',
      'delete_id': deleteId,
      'table': currentTable,
      'security': '<?php echo wp_create_nonce( "wpgamelist-jre-ajax-nonce-delete" ); ?>'
    };

    jQuery.post(ajaxurl, data, function(response) {
      document.location.reload(true);
    });
  });
  </script> <?php
}

function wpgamelist_delete_entry_action_callback() {
  global $wpdb;
  check_ajax_referer( 'wpgamelist-jre-ajax-nonce-delete', 'security' );
  // Grabbing the ID of the game for deletion that is hidden in a span element. This ID was sent from wpgamelist.php.
  $id = intval(addslashes(($_POST['delete_id'])));
  $table_name = sanitize_text_field($_POST['table']);

  // Deleting row
  $wpdb->delete( $table_name, array( 'ID' => $id ) );

  // Dropping primary key in database to alter the IDs and the AUTO_INCREMENT value
  $wpdb->query($wpdb->prepare( "ALTER TABLE $table_name MODIFY ID BIGINT(255) NOT NULL", $table_name));

  $wpdb->query($wpdb->prepare( "ALTER TABLE $table_name DROP PRIMARY KEY", $table_name));

  // Adjusting ID values of remaining entries in database
  $my_query = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name", $table_name ));
  $title_count = $wpdb->num_rows;
  //Dont think we need this, don't think it matters, and it really sucks up resources when there are thousdans of games
 /* for ($x = $id; $x <= $title_count; $x++) {
    $data = array(
        'ID' => $id
    );
    $format = array( '%s'); 
    $id++;  
    $where = array( 'ID' => ($id) );
    $where_format = array( '%d' );
    $wpdb->update( $table_name, $data, $where, $format, $where_format );
  }  */
    
  // Adding primary key back to database 
  $wpdb->query($wpdb->prepare( "ALTER TABLE $table_name ADD PRIMARY KEY (`ID`)", $table_name));    

  $wpdb->query($wpdb->prepare( "ALTER TABLE $table_name MODIFY ID BIGINT(255) AUTO_INCREMENT", $table_name));

  // Setting the AUTO_INCREMENT value based on number of remaining entries
  $title_count++;
  $wpdb->query($wpdb->prepare( "ALTER TABLE $table_name AUTO_INCREMENT=$title_count", $table_name));
  wp_die(); // this is required to terminate immediately and return a proper response
}

// Handles the way things are displayed based on the sort selection the user makes
function wpgamelist_jre_sort_selection_javascript() { ?>
  <script type="text/javascript" >
  jQuery(document).ready(function() {
    jQuery('#wpgamelist_sort_select_box').change(function() {
      if(window.location.href.indexOf("?update") != -1){
        var currentUrl = window.location.href.substring(0, window.location.href.indexOf("?update"));
        window.location = currentUrl+"?update=control&update_id=" + encodeURIComponent(jQuery(this).val());
      }else {
        window.location = window.location.href+"?update=control&update_id=" + encodeURIComponent(jQuery(this).val());
      }
    });
    jQuery(document).on("change","#wpgamelist_sort_select_box", function(event){
      var sortSubmitUrl = window.location.href;
      var e = document.getElementById("wpgamelist_sort_select_box");
      var sortSelection = e.options[e.selectedIndex].text;
      // The ajax call that reloads the current page with the sort selection applied
      jQuery.ajax({
        type    : "POST",
        url     : sortSubmitUrl,
        data    : 'sortSelection='+sortSelection,
        success : function(data) {
        }
      });
      event.preventDefault ? event.preventDefault() : event.returnValue = false;
    });
  });
  </script>
  <?php
}

function wpgamelist_jre_upload_excel_action_javascript() { ?>
  <script type="text/javascript" >
  jQuery(document).on("click","#wpgamelist_upload_link", function(event){
    var uploadDir = '<?php $upload_path = wp_upload_dir(); $upload_path = $upload_path["basedir"]; echo $upload_path; ?>'

    var data = {
      'action': 'wpgamelist_jre_create_upload_action',
      'security': '<?php echo wp_create_nonce( "wpgamelist-jre-ajax-nonce-uploadexcel" ); ?>',
      'uploadDir': uploadDir
    };

    jQuery.post(ajaxurl, data, function(response) {
      jQuery.colorbox({
        open: true,
        scrolling: true,
        width:'50%',
        height:'50%',
        html: response,
        data: data,
        onClosed:function(){
            //Do something on close.
        },
        onComplete:function(){
          // Sets color of the link inside the fancybox to the default theme link color
          var color = jQuery('#wpgamelist_edit_game_link').css("color");
          jQuery(' a').css('color', color);
        }
        });
    });

    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });
  </script> <?php
}

function wpgamelist_jre_create_upload_action_callback() {
  check_ajax_referer( 'wpgamelist-jre-ajax-nonce-uploadexcel', 'security' );
  global $wpdb;
  $upload_path = filter_var($_POST['uploadDir'], FILTER_SANITIZE_STRING);
  include_once( plugin_dir_path( __FILE__ ) . 'uploadlist_ui.php');
  wpgamelist_jre_uploadlist_ui($upload_path);
  wp_die(); 
}

function wpgamelist_jre_create_excel_action_javascript() { ?>
  <script type="text/javascript" >

  jQuery(document).on("click","#wpgamelist_export_link", function(event){
    var table = "<?php echo esc_html($GLOBALS['a']); ?>";
    var link = jQuery(this).attr("href");
    var data = {
      'action': 'wpgamelist_jre_create_excel_action',
      'table':table,
      'link':link,
      'security': '<?php echo wp_create_nonce( "wpgamelist-jre-ajax-nonce-spreadtwo" ); ?>'
    };

    jQuery.post(ajaxurl, data, function(response) {
      console.log(response);
      
      var backupFilename = response;
      backupFilename = backupFilename.replace(" ", '_');
      window.location.replace('<?php $upload_path = wp_upload_dir();
  $upload_path = $upload_path["baseurl"]; echo esc_url($upload_path); ?>'+'/wpgamelist/backups/'+backupFilename);
          
      setTimeout(function(){
        document.location.reload(true)
      }, 3000);

      
    });
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
  });

  </script> <?php
}

function wpgamelist_jre_create_excel_action_callback() {
  global $wpdb; // this is how you get access to the database
  check_ajax_referer( 'wpgamelist-jre-ajax-nonce-spreadtwo', 'security' );
  $table_name = sanitize_text_field($_POST['table']);
  $count = $wpdb->query($wpdb->prepare("SELECT * FROM $table_name", $table_name));

  // Getting all entries from the database
  $my_query = $wpdb->get_results( "SELECT * FROM $table_name");
  $upload_path = wp_upload_dir();
  $upload_path = $upload_path['baseurl'];
  //$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
  if (!file_exists($upload_path.'/wpgamelist/backups')) {
      mkdir($upload_path.'/wpgamelist/backups', 0777, true);
  }
  // Including PHPExcel Library files
  include_once __DIR__ . '/PHPExcel/Classes/PHPExcel.php';
  include_once __DIR__ . '/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
  require_once __DIR__ . '/PHPExcel/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

  PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

  // Create new PHPExcel object
  $objPHPExcel = new PHPExcel();

  // Set properties
  $objPHPExcel->getProperties()->setCreator("WordPress game List");
  $objPHPExcel->getProperties()->setLastModifiedBy("Jake Evans");
  $objPHPExcel->getProperties()->setTitle("WordPress game List Library Export");
  $objPHPExcel->getProperties()->setSubject("WordPress game List Library Export");
  $objPHPExcel->getProperties()->setDescription("A WordPress game List Library Export");

  // Add default data (column Headings)
  $objPHPExcel->setActiveSheetIndex(0);
  $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'ID');
  $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Title');
  $objPHPExcel->getActiveSheet()->SetCellValue('C2', 'Developer');
  $objPHPExcel->getActiveSheet()->SetCellValue('D2', 'Publisher');
  $objPHPExcel->getActiveSheet()->SetCellValue('E2', 'Release Date');
  $objPHPExcel->getActiveSheet()->SetCellValue('F2', 'Finished Yes?');
  $objPHPExcel->getActiveSheet()->SetCellValue('G2', 'Year Finished');
  $objPHPExcel->getActiveSheet()->SetCellValue('H2', 'Cover Image');
  $objPHPExcel->getActiveSheet()->SetCellValue('I2', 'Genre');
  $objPHPExcel->getActiveSheet()->SetCellValue('J2', 'Storyline');
  $objPHPExcel->getActiveSheet()->SetCellValue('K2', 'Summary');
  $objPHPExcel->getActiveSheet()->SetCellValue('L2', 'Notes');
  $objPHPExcel->getActiveSheet()->SetCellValue('M2', 'Vids');
  $objPHPExcel->getActiveSheet()->SetCellValue('N2', 'Screenshots');
  $objPHPExcel->getActiveSheet()->SetCellValue('O2', 'IGDB Url');
  $objPHPExcel->getActiveSheet()->SetCellValue('P2', 'Rating');
  $objPHPExcel->getActiveSheet()->SetCellValue('Q2', 'Platform');

  // For loop that sets each cell value to it's appropriate value from the database
  for($i = 0; $i < $count; $i++){
      $objPHPExcel->getActiveSheet()->SetCellValue('A'.($i+3), $my_query[$i]->ID );
      $objPHPExcel->getActiveSheet()->SetCellValue('B'.($i+3), $my_query[$i]->name );
      $objPHPExcel->getActiveSheet()->SetCellValue('C'.($i+3), $my_query[$i]->developer );
      $objPHPExcel->getActiveSheet()->SetCellValue('D'.($i+3), $my_query[$i]->publisher );
      $objPHPExcel->getActiveSheet()->SetCellValue('E'.($i+3), $my_query[$i]->releasedate );
      $objPHPExcel->getActiveSheet()->SetCellValue('F'.($i+3), $my_query[$i]->finished );
      $objPHPExcel->getActiveSheet()->SetCellValue('G'.($i+3), $my_query[$i]->yearfinished );
      $objPHPExcel->getActiveSheet()->SetCellValue('H'.($i+3), $my_query[$i]->cover );
      $objPHPExcel->getActiveSheet()->SetCellValue('I'.($i+3), $my_query[$i]->genre );
      $objPHPExcel->getActiveSheet()->SetCellValue('J'.($i+3), $my_query[$i]->storyline );
      $objPHPExcel->getActiveSheet()->SetCellValue('K'.($i+3), $my_query[$i]->summary );
      $objPHPExcel->getActiveSheet()->SetCellValue('L'.($i+3), $my_query[$i]->notes );
      if($my_query[$i]->yearfinished == '0'){
          $my_query[$i]->yearfinished = 'N/A';
      } 
      $objPHPExcel->getActiveSheet()->SetCellValue('M'.($i+3), $my_query[$i]->vids );
      $objPHPExcel->getActiveSheet()->SetCellValue('N'.($i+3), $my_query[$i]->screenshots );
      $objPHPExcel->getActiveSheet()->SetCellValue('O'.($i+3), $my_query[$i]->igdburl );
      $objPHPExcel->getActiveSheet()->SetCellValue('P'.($i+3), $my_query[$i]->rating );
      $objPHPExcel->getActiveSheet()->SetCellValue('Q'.($i+3), $my_query[$i]->platform );      
  }

  // Worksheet Stylings array
  $styleArray1 = array(
      'font'  => array(
          'bold'  => true,
          'color' => array('rgb' => '349ed6'),
          'size'  => 18,
          'name'  => 'Verdana'
      ));

  // Applying that style array
  $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray1);

  // More cell formatting/styling
  $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
  $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'WordPress Game List');

  $styleArray2 = array(
      'font'  => array(
          'bold'  => true,
          'color' => array('rgb' => '000000'),
          'size'  => 12,
          'name'  => 'Verdana'
      ));

  // Formatting/styling the column headings
  foreach(range('a','z') as $letter) 
  { 
     $objPHPExcel->getActiveSheet()->getStyle($letter.'2')->applyFromArray($styleArray2);
     $objPHPExcel->getActiveSheet()->getStyle($letter.'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
     $objPHPExcel->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
  }  

  $objPHPExcel->getActiveSheet()->getStyle('D2:D256')->getNumberFormat()->setFormatCode('0');
  $objPHPExcel->getActiveSheet()->getStyle('D2:N256')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

  // Renaming, saving, writing out and actually creating the Excel document
  // Rename sheet
  $objPHPExcel->getActiveSheet()->setTitle('WordPress Game List');
      
  // Save Excel 2007 file
  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  //$objWriter->save(str_replace('.php', '.xlsx', __FILE__));

  // GEtting total number of currently stored backups
  $file_count = 1;
  $upload_path = wp_upload_dir();
  $upload_path = $upload_path['basedir'];
  foreach(glob($upload_path.'/wpgamelist/backups/*.*') as $filename){
      $file_count++;
  }

  if($file_count == 11){

      
      $file_to_create = glob( $upload_path.'/wpgamelist/backups/*.*' );
      array_multisort(array_map( 'filemtime', $file_to_create ),SORT_NUMERIC,SORT_DESC,$file_to_create);
      $file_count = $file_to_create[0];

      $file_count = substr($file_count, (strrpos($file_count, '_')+1), (strrpos($file_count, '.')) );
      

      
      $file_to_delete = glob( $upload_path.'/wpgamelist/backups/*.*' );
      array_multisort(array_map( 'filemtime', $file_to_delete ),SORT_NUMERIC,SORT_ASC,$file_to_delete);
      unlink($file_to_delete[0]);

      $file_count = intval($file_count)+1;
  }

  if (!file_exists($upload_path.'/wpgamelist/backups')) {
    mkdir($upload_path.'/wpgamelist/backups', 0777, true);
  }

  // Creating final filename and saving the spreadsheet
  $mydate=getdate(date("U"));
  $filename = "$mydate[weekday]_$mydate[month]_$mydate[mday]_$mydate[year]_".$file_count;
  $objWriter->save($upload_path.'/wpgamelist/backups/'.$filename.'.xlsx');


  $first_file;
  $file_control = 0;
  $files = glob($upload_path.'/wpgamelist/backups/*'); // get all file names




  // Response to ajax call
  echo $filename.'.xlsx';
  wp_die(); 
}

function wpgamelist_create_spreadsheet_action_javascript() { ?>
  <script type="text/javascript" >
  jQuery(document).on("change","#wpgamelist_select_backup_box", function(event){
      var e = document.getElementById("wpgamelist_select_backup_box");
      var backupSelection = 'backups/'+e.options[e.selectedIndex].text;
      backupSelection = backupSelection.replace(/ /g, "_")+'.xlsx';
      backupSelection = backupSelection.substring(backupSelection.lastIndexOf("/") + 1);
      console.log(backupSelection);
      var table = "<?php echo esc_html($GLOBALS['a']) ?>";

      var data = {
        'action': 'wpgamelist_create_spreadsheet_action',
        'table': table,
        'backupSelection': backupSelection,
        'security': '<?php echo wp_create_nonce( "wpgamelist-jre-ajax-nonce-createspread" ); ?>'

      };
      jQuery.post(ajaxurl, data, function(response) {
       document.location.reload(true);
      });
  });
  </script> <?php
}

function wpgamelist_create_spreadsheet_action_callback() {
  global $wpdb;
  check_ajax_referer( 'wpgamelist-jre-ajax-nonce-createspread', 'security' );
  include_once __DIR__ . '/PHPExcel/Classes/PHPExcel.php';
  include_once __DIR__ . '/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
  require_once __DIR__ . '/PHPExcel/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

  $table_name = sanitize_text_field($_POST['table']);
  $upload_path = wp_upload_dir();
  $upload_path = $upload_path['basedir'];
  // The particular backup the user selected from the drop-down menu
  $backupSelection = sanitize_text_field($_POST['backupSelection']);
  $fileType = 'Excel2007';
  $fileName = $upload_path.'/wpgamelist/backups/'.$backupSelection;
  
  $objReader = PHPExcel_IOFactory::createReader($fileType);
  $objPHPExcel = $objReader->load($fileName);

  //Get worksheet dimensions
  $sheet = $objPHPExcel->getSheet(0); 
  $highestRow = $sheet->getHighestRow(); 
  $highestColumn = 'Q';

  // Delete all data in DB
  $delete = $wpdb->query($wpdb->prepare("TRUNCATE TABLE $table_name", $table_name));
      
  //Loop through each row of the worksheet in turn
  for ($row = 3; $row <= $highestRow; $row++){ 
      //  Read a row of data into an array
      $row_data = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
      if($row_data[0][0] != "") {

        $data = array(
          'ID' => $row_data[0][0],
          'name' => $row_data[0][1],                  
          'developer' => $row_data[0][2],
          'publisher' => $row_data[0][3],
          'releasedate' => $row_data[0][4],
          'finished' => $row_data[0][5],
          'yearfinished' => $row_data[0][6], 
          'cover' => $row_data[0][7],
          'genre' => $row_data[0][8],
          'storyline' => $row_data[0][9],
          'summary' => $row_data[0][10],
          'notes' => $row_data[0][11],
          'vids' => $row_data[0][12],
          'screenshots' => $row_data[0][13],
          'igdburl' => $row_data[0][14],
          'rating' => $row_data[0][15],
          'platform' => $row_data[0][16]
      );  
      $wpdb->insert( $table_name, $data );
      }
  }
  $row_data = $sheet->rangeToArray('A3' . ':' . 'Y3', NULL, TRUE, FALSE);
  wp_die(); // this is required to terminate immediately and return a proper response

}

function wpgamelist_savedgame_action_javascript() { ?>
  <script type="text/javascript" >
  jQuery(document).ready(function($) {
      function wpgamelist_jre_initAddThis() {
      addthis.init()
    }

    // After the DOM has loaded...
    wpgamelist_jre_initAddThis();

    var color = jQuery('#hidden_link_for_styling').css("color");
    jQuery('.wpgamelist_saved_title_link, .wpgamelist_saved_title_link0, .wpgamelist_saved_title_link1, .wpgamelist_saved_title_link2,.wpgamelist_saved_title_link3').css('color', color);
    jQuery('.wpgamelist_saved_title_link, .wpgamelist_saved_title_link0, .wpgamelist_saved_title_link1, .wpgamelist_saved_title_link2,.wpgamelist_saved_title_link3').css('color', color);
    jQuery(".wpgamelist-select-game-by-img-class, .wpgamelist_saved_title_link").click(function(){

      if(jQuery(this).attr('id') == 'wpgamelist_cover_image'){
        var title_id = jQuery(this).next("span");
        var title = title_id.html();
      } else {
        var title_id = jQuery(this).find("span");
        var title = title_id.html();
      }

      var quote = jQuery('#wpgamelist-ui-quote-area-hidden').html();
      var show = jQuery('#wpgamelist-hidden-quote-indicator').html();
      if(show == 'hide'){
        quote = '';
      }
      console.log(quote);

      if((quote == null) && (jQuery(this).attr('data-quoteshow') == 'true')){
        quote = jQuery(this).attr('data-quote');
        quote = quote.replace(/####/g,'"');
        quote = quote.replace(/###/g,"'");
      }

      var table = '<?php echo esc_html($GLOBALS["a"]); ?>';
      var data = {
        'action': 'savedgame_action',
        'img_path': "<?php echo esc_url(plugins_url( '/assets/img/', __FILE__)) ?>",
        'wpgamelist-session': '<?php echo esc_html($GLOBALS["a"]); ?>',
        'title': title,
        'security': '<?php echo wp_create_nonce( "wpgamelist-jre-ajax-nonce-savedgame" ); ?>'
      };

      jQuery.post(ajaxurl, data, function(response) {
        console.log(response);
        jQuery.colorbox({
          title: quote,
          open: true,
          scrolling: true,
          width:'70%',
          height:'70%',
          html: response,
          data : data,
          onClosed:function(){
              //Do something on close.
          },
          onComplete:function(){
            addthis.toolbox(
              jQuery(".addthis_sharing_toolbox").get()
            );
            addthis.toolbox(
              jQuery(".addthis_sharing_toolbox").get()
            );
            addthis.counter(
              jQuery(".addthis_counter").get()
            );

          }
        });
      });
    });
  });

  // If clicking anywhere on the page, and if either the page info or category info popup is displayed, close one or both.
  jQuery(document).click(function() {
    if(((jQuery("#wpgamelist_missing_pages_dynamic").css('display')) == 'block') || (jQuery("#wpgamelist_missing_cat_dynamic").css('display'))){
      jQuery("#wpgamelist_missing_pages_dynamic").css({'display':'none'});
      jQuery("#wpgamelist_missing_cat_dynamic").css({'display':'none'});
    }
  });
  // If any clicks are registered INSIDE the page or category info popup, do NOT close the popup
  jQuery("#wpgamelist_missing_pages_dynamic, #wpgamelist_missing_cat_dynamic").click(function(e) {
    e.stopPropagation();
    return false;
  });
  //Display the page and category info popups on hover
  jQuery('#wpgamelist_missing_pages_id').hover(function(){
    jQuery('#wpgamelist_missing_pages_dynamic').css({'display':'block'});
  });
  jQuery('#wpgamelist_missing_cat_id').hover(function(){
    jQuery('#wpgamelist_missing_cat_dynamic').css({'display':'block'});
  });
  </script> <?php
}

function wpgamelist_savedgame_action_callback() {
  check_ajax_referer( 'wpgamelist-jre-ajax-nonce-savedgame', 'security' );
  global $wpdb; // this is how you get access to the database
  $table = $GLOBALS["a"];
  $title = sanitize_text_field($_POST['title']);
  $table_name = sanitize_text_field($_POST['wpgamelist-session']);
  if (!filter_var($_POST['img_path'], FILTER_VALIDATE_URL) === false) {
    // valid url
    $img_path = $_POST['img_path'];
  } else {
    return;
  }

  $table_name_options = $wpdb->prefix . 'wpgamelist_jre_user_options';
  $saved_game = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE ID = $title", $table_name));
  $options_results = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name_options", $table_name_options));
  //var_dump($saved_game);

  include_once( plugin_dir_path( __FILE__ ) . 'savedgameactions.php');
  wpgamelist_jre_savedgameactions($saved_game, $img_path, $options_results);
  wp_die(); // this is required to terminate immediately and return a proper response

}

function wpgamelist_save_game_edit_action_javascript() { ?>
  <script type="text/javascript" >
  jQuery(document).on("click","#wpgamelist_edit_game_submit_button", function(){
    var opt1 = jQuery('#wpgamelist_name_edit').val();
    var opt2 = jQuery('#wpgamelist_developer_edit').val();
    var opt3 = jQuery('#wpgamelist_publisher_edit').val();
    var opt4 = jQuery('#wpgamelist_release_edit').val();
    var opt5 = jQuery('#wpgamelist_finished_edit').val();
    var opt6 = jQuery('#wpgamelist_yearfinished_edit').val();
    var opt7 = jQuery('#wpgamelist_genre_edit').val();
    var opt8 = jQuery('#wpgamelist_storyline_edit').val();
    var opt9 = jQuery('#wpgamelist_summary_edit').val();
    var opt10 = jQuery('#wpgamelist_notes_edit').val();
    var opt11 = jQuery('#wpgamelist_rating_edit').val();
    var opt12 = jQuery('#wpgamelist_platform_edit').val();
    var opt13 = jQuery('[name=hidden_id_input]').val();
    var table = '<?php echo esc_html($GLOBALS["a"]); ?>';

    var optsArray = [
      opt1,opt2,opt3,opt4,opt5,opt6,opt7,opt8,opt9,opt10,opt11,opt12,opt13,table
    ];

    var data = {
      'action': 'wpgamelist_save_game_edit_action',
      'optsArray': optsArray,
      'table':table,
      'security': '<?php echo wp_create_nonce( "wpgamelist-jre-ajax-nonce-saveedit" ); ?>'
    };
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    jQuery.post(ajaxurl, data, function(response) {
      document.location.reload(true);
    });
  });
  </script> <?php
}

function wpgamelist_save_game_edit_action_callback() {
  global $wpdb; // this is how you get access to the database
  check_ajax_referer( 'wpgamelist-jre-ajax-nonce-saveedit', 'security' );
  $table_name = sanitize_text_field($_POST['table']);


    function wpgamelist_arrayMod($v){
    if($v == "false"){
      return 'NULL';
    } else if($v == 'true'){
      return 'yes';
    } else {
      return $v;
    }


  }

  $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  $optsArray = $_POST['optsArray'];
  $optsArray = array_map('wpgamelist_arrayMod', $optsArray);


  // Handling the input from the 'edit game' form 
  $name = htmlspecialchars($optsArray[0], ENT_QUOTES);
  $key_id = htmlspecialchars(addslashes($optsArray[12]));
  $developer = htmlspecialchars(addslashes($optsArray[1]));
  $publisher = htmlspecialchars(addslashes($optsArray[2]));
  $release = htmlspecialchars(addslashes($optsArray[3]));
  $finished = htmlspecialchars(addslashes($optsArray[4]));
  $yearfinished = htmlspecialchars(addslashes($optsArray[5]));
  $genre = htmlspecialchars(addslashes($optsArray[6]));
  $storyline = htmlspecialchars(addslashes($optsArray[7]));
  $summary = htmlspecialchars(addslashes($optsArray[8]));
  $notes = htmlspecialchars(addslashes($optsArray[9]));
  $rating = htmlspecialchars(addslashes($optsArray[10]));
  $platform = htmlspecialchars(addslashes($optsArray[11]));

  $saved_game = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE name = '%s'",$name ) );
  $id = $saved_game->ID;

      $data = array(
          'name' => $name,
          'developer' => $developer,
          'publisher' => $publisher,
          'releasedate' => $release,
          'yearfinished' => $yearfinished,
          'finished' => $finished,
          'genre' => $genre,
          'storyline' => $storyline,
          'summary' => $summary,
          'notes' => $notes,
          'rating' => $rating,
          'platform' => $platform
      );
      $format = array( '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s');
     
  $where = array( 'ID' => $key_id );
  $where_format = array( '%d' );
  $wpdb->update( $table_name, $data, $where, $format, $where_format );
 
  wp_die(); // this is required to terminate immediately and return a proper response
}

function wpgamelist_display_options_action_javascript() { ?>
  <script type="text/javascript" >
  jQuery('#wpgamelist-save-backend').click(function(){
    var opt1 = jQuery('[name=hide-add-a-game]').prop('checked');
    var opt2 = jQuery('[name= hide-search]').prop('checked');
    var opt3 = jQuery('[name=hide-stats-area]').prop('checked');
    var opt4 = jQuery('[name=hide-edit-delete]').prop('checked');
    var opt5 = jQuery('[name=hide-sort-by]').prop('checked');
    var opt6 = jQuery('[name=hide-backup-download]').prop('checked');
    var opt7 = jQuery('[name=hide-facebook]').prop('checked');
    var opt8 = jQuery('[name=hide-messenger]').prop('checked');
    var opt9 = jQuery('[name=hide-twitter]').prop('checked');
    var opt10 = jQuery('[name=hide-googleplus]').prop('checked');
    var opt11 = jQuery('[name=hide-pinterest]').prop('checked');
    var opt12 = jQuery('[name=hide-email]').prop('checked');
    var opt13 = jQuery('[name=hide-vids]').prop('checked');
    var opt14 = jQuery('[name=hide-description]').prop('checked');
    var opt15 = jQuery('[name=hide-screenshots]').prop('checked');
    var opt16 = jQuery('[name=hide-notes]').prop('checked');
    var opt17 = jQuery('[name=games-per-page]').val();
    var opt18 = jQuery('[name=hide-bottom-purchase]').prop('checked');
    // Avoiding the 'division by zero' error
    if(opt17 < 1){
      opt17 = 1;
    }

    var optsArray = [
      opt1,opt2,opt3,opt4,opt5,opt6,opt7,opt8,opt9,opt10,opt11,opt12,opt13,opt14,opt15,opt16,opt17,opt18
    ];

    var data = {
      'action': 'wpgamelist_display_options_action',
      'optsArray': optsArray,
      'security': '<?php echo wp_create_nonce( "wpgamelist-jre-ajax-nonce-displayops" ); ?>'
    };

    jQuery.post(ajaxurl, data, function(response) {
      document.location.reload(true);
    });
  });
  </script> <?php
}

function wpgamelist_jre_admin_clear_javascript(){
  ?>
  <script>
  jQuery(document).ready(function() {
    jQuery(".wpgamelist-dynamic-input").one("click", function(){
      jQuery(this).val("")
      jQuery(this).css({'color' : 'black'})
    });
    jQuery("#wpgamelist-feedback").one("click", function(){
      jQuery(this).val("")
    });
  });
  </script>
  <?php
}

function wpgamelist_jre_display_options_javascript(){
  ?>
  <script>
  jQuery(document).ready(function() {
    jQuery('#wpgamelist-game-control').change(function(){
      var value = jQuery('#wpgamelist-game-control').val();
      if((value == null) || (value == 0)){
        jQuery('#wpgamelist-save-backend').attr("disabled", "true");
      } else {
        jQuery('#wpgamelist-save-backend').removeAttr("disabled");
      }
    });
  });
  </script>
  <?php
}


function wpgamelist_display_options_action_callback() {
  global $wpdb; // this is how you get access to the database
  check_ajax_referer( 'wpgamelist-jre-ajax-nonce-displayops', 'security' );
  $table_name = $wpdb->prefix . 'wpgamelist_jre_user_options';
  function wpgamelist_arrayMod($v){
    if($v == "false"){
      return NULL;
    } else{
      return $v;
    }
  }
  $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  $opts_array = $_POST['optsArray'];
  $opts_array = array_map('wpgamelist_arrayMod', $opts_array);

  $hide_add =  $opts_array[0];
  $hide_search = $opts_array[1];
  $hide_stats = $opts_array[2];
  $hide_edit_delete = $opts_array[3];
  $hide_sort_by = $opts_array[4];
  $hide_backup_download = $opts_array[5];
  $hide_facebook = $opts_array[6];
  $hide_messenger = $opts_array[7];
  $hide_twitter = $opts_array[8];
  $hide_googleplus = $opts_array[9];
  $hide_pinterest = $opts_array[10];
  $hide_email = $opts_array[11];
  $hide_vids = $opts_array[12];
  $hide_description = $opts_array[13];
  $hide_screenshots = $opts_array[13];
  $hide_notes = $opts_array[15];
  $games_per_page = $opts_array[16];
  $hide_bottom_purchase = $opts_array[17];
   $data = array(
          'hideaddgame' => $hide_add,
          'hidesearch' => $hide_search,
          'hidestats' => $hide_stats,
          'hideeditdelete' => $hide_edit_delete,
          'hidesortby' => $hide_sort_by,
          'hidebackupdownload' => $hide_backup_download,
          'hidefacebook' => $hide_facebook,
          'hidemessenger' => $hide_messenger,
          'hidetwitter' => $hide_twitter,
          'hidegoogleplus' => $hide_googleplus,
          'hidepinterest' => $hide_pinterest,
          'hideemail' => $hide_email,
          'hidevids' => $hide_vids,
          'hidedescription' => $hide_description,
          'hidescreenshots' => $hide_screenshots,
          'hidenotes' => $hide_notes,
          'gamesonpage' => $games_per_page,
          'hidebottompurchase' => $hide_bottom_purchase
    );
  $format = array( '%d', '%d', '%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d');   
  $where = array( 'ID' => 1 );
  $where_format = array( '%d' );
  $wpdb->update( $table_name, $data, $where, $format, $where_format );
  wp_die(); // this is required to terminate immediately and return a proper response
}

function wpgamelist_new_lib_shortcode_action_javascript() { ?>
 <script type="text/javascript" >
  jQuery(".wpgamelist-dynamic-input").bind('input', function() { 
        currentVal = jQuery(".wpgamelist-dynamic-input").val();
        if((currentVal.length > 0) && (currentVal != 'Create a New Library Here...')){
          jQuery("#wpgamelist-dynamic-shortcode-button").attr('disabled', false);
        }
    });
  jQuery(document).on("click","#wpgamelist-dynamic-shortcode-button", function(event){
    var currentVal;
    currentVal = (jQuery("#wpgamelist-dynamic-input-library").val()).toLowerCase();
    console.log(currentVal);
    var data = {
      'action': 'wpgamelist_new_lib_shortcode_action',
      'currentval': currentVal,
      'security': '<?php echo wp_create_nonce( "wpgamelist-jre-ajax-nonce-newlib" ); ?>'
    };

    jQuery.post(ajaxurl, data, function(response) {
      document.location.reload(true);
    });
  });

  jQuery(document).on("click",".wpgamelist_delete_custom_lib", function(event){
    var table = jQuery(this).attr('id');
    console.log(table);
    var data = {
      'action': 'wpgamelist_new_lib_shortcode_action',
      'table': table,
      'security': '<?php echo wp_create_nonce( "wpgamelist-jre-ajax-nonce-newlib" ); ?>'
    };
    jQuery.post(ajaxurl, data, function(response) {
      document.location.reload(true);
    });
  });
  </script> <?php
}


function wpgamelist_new_lib_shortcode_action_callback() {
  // Grabbing the existing options from DB
  global $wpdb;
  check_ajax_referer( 'wpgamelist-jre-ajax-nonce-newlib', 'security' );
  $table_name_dynamic = $wpdb->prefix . 'wpgamelist_jre_list_dynamic_db_names';
  $db_name;

  function wpgamelist_clean($string) {
      $string = str_replace(' ', '_', $string); // Replaces all spaces with underscores.
      $string = str_replace('-', '_', $string);
      return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
  }
 
  // Create a new custom table
  if(isset($_POST['currentval'])){
      $db_name = sanitize_text_field($_POST['currentval']);
      error_log('table:'.$db_name);
      $db_name = wpgamelist_clean($db_name);
  }

  // Delete the table
  if(isset($_POST['table'])){ 
      $table = $wpdb->prefix."wpgamelist_jre_".sanitize_text_field($_POST['table']);
      $pos = strripos($table,"_");
      $table = substr($table, 0, $pos);
      echo $table;
      $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table", $table));

      $delete_from_list = sanitize_text_field($_POST['table']);
      $pos2 = strripos($delete_from_list,"_");
      $delete_id = substr($delete_from_list, ($pos2+1));
      $wpdb->delete( $table_name_dynamic, array( 'ID' => $delete_id ), array( '%d' ) );
         
      // Dropping primary key in database to alter the IDs and the AUTO_INCREMENT value
      $table_name_dynamic = str_replace('\'', '`', $table_name_dynamic);
      $wpdb->query($wpdb->prepare("ALTER TABLE %s MODIFY ID bigint(255) NOT NULL" , $table_name_dynamic));

      $query2 = $wpdb->prepare( "ALTER TABLE %s DROP PRIMARY KEY", $table_name_dynamic);
      $query2 = str_replace('\'', '`', $query2);
      $wpdb->query($wpdb->prepare($query2));

      // Adjusting ID values of remaining entries in database
      $my_query = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name_dynamic", $table_name_dynamic ));
      $title_count = $wpdb->num_rows;

      for ($x = $delete_id ; $x <= $title_count; $x++) {
        $data = array(
            'ID' => $delete_id 
        );
        $format = array( '%s'); 
        $delete_id ++;  
        $where = array( 'ID' => ($delete_id ) );
        $where_format = array( '%d' );
        $wpdb->update( $table_name_dynamic, $data, $where, $format, $where_format );
      }  
        
      // Adding primary key back to database 
      $query3 = $wpdb->prepare( "ALTER TABLE %s ADD PRIMARY KEY (`ID`)", $table_name_dynamic);
      $query3 = str_replace('\'', '`', $query3);
      $wpdb->query($wpdb->prepare($query3));    

      $query4 = $wpdb->prepare( "ALTER TABLE %s MODIFY ID bigint(255) AUTO_INCREMENT", $table_name_dynamic);
      $query4 = str_replace('\'', '`', $query4);
      $wpdb->query($wpdb->prepare($query4));

      // Setting the AUTO_INCREMENT value based on number of remaining entries
      $title_count++;
      $query5 = $wpdb->prepare( "ALTER TABLE %s AUTO_INCREMENT=%d", $table_name_dynamic,$title_count);
      $query5 = str_replace('\'', '`', $query5);
      $wpdb->query($wpdb->prepare($query5));
      
  }

  if(isset($db_name)){
      if(($db_name != "")  ||  ($db_name != null)){
          $wpdb->wpgamelist_jre_dynamic_db_name = "{$wpdb->prefix}wpgamelist_jre_{$db_name}";

          $sql_create_dynamic_table = "CREATE TABLE {$wpdb->wpgamelist_jre_dynamic_db_name}
        (
            ID bigint(255) auto_increment,
            name varchar(255),
            developer varchar(255),
            publisher varchar(255),
            releasedate varchar(255),
            yearfinished bigint(255),
            finished varchar(255),
            cover varchar(255),
            genre varchar(255),
            storyline MEDIUMTEXT,
            summary MEDIUMTEXT, 
            notes MEDIUMTEXT,
            vids MEDIUMTEXT,
            screenshots MEDIUMTEXT,
            igdburl varchar(255),
            rating bigint(255),
            platform varchar(255),
            PRIMARY KEY  (ID),
              KEY name (name)
        ) $charset_collate; ";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql_create_dynamic_table );
        $wpdb->insert( $table_name_dynamic, array('user_table_name' => $db_name ));
          
      }

  }
      
  wp_die(); // this is required to terminate immediately and return a proper response
}

// This function controls the functionality of the page links at the bottom of the page
function wpgamelist_jre_page_control_javascript() { ?>
  <script type="text/javascript" >
  jQuery(document).ready(function() {
    jQuery('.wpgamelist_page_control_link_class').click(function() {
      var table = "&wpgamelist-session="+"<?php echo esc_html($GLOBALS['a']); ?>";
      var currentUrl = window.location.href;
      if(currentUrl.indexOf("update_id") != -1){
        var startPos = (currentUrl.search("update_id"))+10;
        var sortId = currentUrl.slice(startPos);
        var currentStrippedUrl = currentUrl.substring(0, window.location.href.indexOf("?update"));
        var pagenum = parseInt(jQuery(this).html())-1;
        if(currentUrl.indexOf("search_query") != -1){ 
          var searchTerm = currentUrl.substring(window.location.href.indexOf("search_query"));
          window.location = currentStrippedUrl+"?update=control&sort_id=" + sortId +"&page_control=" + pagenum +"&update_id="+sortId+table + '&' + searchTerm;
        } else {
          window.location = currentStrippedUrl+"?update=control&sort_id=" + sortId +"&page_control=" + pagenum +"&update_id="+sortId+table;
        }
      } else {
        var currentStrippedUrl = currentUrl.substring(0, window.location.href.indexOf("?update"));
        if(currentUrl.indexOf("search_query") != -1){ 
          var searchTerm = currentUrl.substring(window.location.href.indexOf("search_query"));
          var pagenum = parseInt(jQuery(this).html())-1; 
          window.location = currentStrippedUrl+"?update=control&page_control=" + pagenum + '&' + searchTerm;
        } else {
          var pagenum = parseInt(jQuery(this).html())-1; 
          window.location = currentStrippedUrl+"?update=control&page_control=" + pagenum;
        }
      }
    });
  });
  </script>
  <?php
}

function wpgamelist_jre_stylepak_file_upload_action_javascript(){
?>
<script>
function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object
    theFile = files[0];
    // Open Our formData Object
    var formData = new FormData();
    formData.append('action', 'wpgamelist_jre_stylepak_file_upload_action');
    formData.append('my_uploaded_file', theFile);
    var nonce = '<?php echo wp_create_nonce( "from_wpgamelist_jre_stylepak_file_upload_action_javascript" );  ?>';
    formData.append('security', nonce);

    jQuery.ajax({
      url: ajaxurl,
      type: 'POST',
      data: formData,
      contentType:false,
      processData:false,
      success: function(response){
        document.location.reload();
      }
    }); 
    
    var working = jQuery('#wpgamelist-backend-stylepak-progress');
    var control = 0;
    wpgameliststylepakProgress(working);
    function wpgameliststylepakProgress(working){
      if(control < 10000){
        working.animate({opacity: '1'}, 1000);
        working.animate({opacity: '0'}, 1000);
        control = control+1;
        wpgameliststylepakProgress(working);
      }
    }
    
  }

  document.getElementById('wpgamelist-add-new-stylepak-file').addEventListener('change', handleFileSelect, false);
</script>
}
<?php
}

function wpgamelist_jre_stylepak_file_upload_action_callback() {
  global $wpdb; // this is how you get access to the database
  var_dump($_POST);
  $nonce = $_POST["_wpnonce"];
  check_ajax_referer( 'from_wpgamelist_jre_stylepak_file_upload_action_javascript', 'security' );
  $uploads = wp_upload_dir();
  if (!file_exists($uploads['basedir']."/wpgamelist")) {
    mkdir($uploads['basedir']."/wpgamelist", 0777, true);
  }

  if (!file_exists($uploads['basedir']."/wpgamelist/stylepak-exports")) {
    mkdir($uploads['basedir']."/wpgamelist/stylepak-exports", 0777, true);
  }

  if (!file_exists($uploads['baseurl']."/wpgamelist")) {
    mkdir($uploads['baseurl']."/wpgamelist", 0777, true);
  }

  if (!file_exists($uploads['baseurl']."/wpgamelist/stylepak-exports")) {
    mkdir($uploads['baseurl']."/wpgamelist/stylepak-exports", 0777, true);
  }

  move_uploaded_file ($_FILES['my_uploaded_file'] ['tmp_name'], $uploads['basedir']."/wpgamelist/stylepak-exports/{$_FILES['my_uploaded_file'] ['name']}");
  wp_die(); // this is required to terminate immediately and return a proper response


}

function wpgamelist_jre_stylepak_selection_action_javascript(){
?>
<script>

  jQuery("#wpgamelist_select_stylepak_box").change(function(){
    var fileSelect = jQuery("#wpgamelist_select_stylepak_box").val();

    var data = {
      'action': 'wpgamelist_jre_stylepak_selection_action',
      'security': '<?php echo wp_create_nonce( "wpgamelist-jre-ajax-nonce-stylepak" ); ?>',
      'stylepak': fileSelect
    };

    console.log(data);

    jQuery.post(ajaxurl, data, function(response) {   
      document.location.reload();
    });

  });

</script>
}
<?php
}

function wpgamelist_jre_stylepak_selection_action_callback(){
  global $wpdb; // this is how you get access to the database
  check_ajax_referer( 'wpgamelist-jre-ajax-nonce-stylepak', 'security' );
  $stylepak = $_POST["stylepak"];
  $stylepak = str_replace('.css', '', $stylepak);
  echo $stylepak;
  $table_name = $wpdb->prefix . 'wpgamelist_jre_user_options';
  $data = array(
    'stylepak' => $stylepak
  );
  $format = array( '%s');   
  $where = array( 'ID' => 1 );
  $where_format = array( '%d' );
  $wpdb->update( $table_name, $data, $where, $format, $where_format );
  wp_die(); // this is required to terminate immediately and return a proper response
}

function wpgamelist_jre_dismiss_notice_forever_action_javascript(){
?>
<script>

  jQuery("#wpgamelist-my-notice-dismiss-forever").click(function(){

    var data = {
      'action': 'wpgamelist_jre_dismiss_notice_forever_action',
      'security': '<?php echo wp_create_nonce( "wpgamelist_jre_dismiss_notice_forever_action" ); ?>',
    };

    jQuery.post(ajaxurl, data, function(response) {   
      document.location.reload();
    });
  });

  </script> <?php
}

function wpgamelist_jre_dismiss_notice_forever_action_callback(){
  global $wpdb; // this is how you get access to the database
  check_ajax_referer( 'wpgamelist_jre_dismiss_notice_forever_action', 'security' );
  $table_name = $wpdb->prefix . 'wpgamelist_jre_user_options';

  $data = array(
      'admindismiss' => 0
  );
  $where = array( 'ID' => 1 );
  $format = array( '%d');  
  $where_format = array( '%d' );
  $wpdb->update( $table_name, $data, $where, $format, $where_format );
  wp_die();
}

?>
