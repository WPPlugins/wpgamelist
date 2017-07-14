<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// Setting up wordpress database queries and variables to be used throughout this file.
// This file controls all the behavior of the main page the user sees their games at.

/*
include_once( plugin_dir_path( __FILE__ ) . 'assets/unirest/src/Unirest.php');

for($i = 6700; $i <=13000; $i+=25){

// These code snippets use an open-source library. http://unirest.io/php
$response = Unirest\Request::get("https://igdbcom-internet-game-database-v1.p.mashape.com/companies/?fields=name&limit=50&offset=".$i,
  array(
    "X-Mashape-Key" => "o9lpK1W80jmshaYX8jiYzbBKF7uop1B2P5ujsnJ1oM7hmvfPfj"
  )
);

$igdb_array = json_decode($response -> raw_body,TRUE);

foreach($igdb_array as $key=>$item){
    $name = '{"matchingcompid": '.$item['id'].',"companyname": "'.$item['name'].'"}'.PHP_EOL;
    file_put_contents('names.txt', $name, FILE_APPEND);
}

}

*/
global $wpdb;
$table_name = filter_var($GLOBALS['a'], FILTER_SANITIZE_STRING);
$games_finished = $wpdb->query($wpdb->prepare("SELECT * FROM $table_name WHERE finished = %s", 'yes'));
$genre_count;
$count;
$table_name_options = $wpdb->prefix . 'wpgamelist_jre_user_options';
$options_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name_options WHERE ID = %d", 1));
$hide_edit_delete = $options_row[0]->hideeditdelete;
$games_on_page = intval($options_row[0]->gamesonpage);
$sort_option = filter_var($options_row[0]->sortoption, FILTER_SANITIZE_STRING);
$sort_id = ''; 
$count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
$persistent_count = 0;
$result = 0;
$temp = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY ID DESC LIMIT %d", 1));
$table_name_quotes = $wpdb->prefix . 'wpgamelist_jre_game_quotes';
$num_of_quotes = ($wpdb->get_var("SELECT COUNT(*) FROM $table_name_quotes")-1);
$quote_results = $wpdb->get_results("SELECT * FROM $table_name_quotes");
$num_of_quotes_game = ($wpdb->get_var("SELECT COUNT(*) FROM $table_name_quotes WHERE placement = 'game'")-1);
$quote_results_game = $wpdb->get_results("SELECT * FROM $table_name_quotes WHERE placement = 'game'");
$hidequotegame = $options_row[0]->hidequotegame;
if(!empty($temp)){
    $result = filter_var($temp[0]->ID, FILTER_SANITIZE_NUMBER_INT);
    if($result != false){
        //$count = $result;
        $persistent_count = $result;
    } else {
    //$count = null;
    $persistent_count = null;
    }
}
$sort_id = '';
$hide_edit_delete = $options_row[0]->hideeditdelete;

?>

<div class="wpgamelist_top_container">
    <div class="gfd"></div>
    <div class="wpgamelist-table-for-app"><?php echo $table_name; ?></div><p id="specialcaseforappid"></p>
<a id="hidden_link_for_styling" style="display:none"></a>
    <div class="wpgamelist_sort_box_top_container">
        <div class="wpgamelist_sort_box_container">
            <div id="wpgamelist_control_panel_tdiv">
                <div class="wpgamelist_control_links_and_sort">

                    <?php
                    $genre_count = wpgamelist_top_three_options($wpdb, $table_name, $count, $options_row);
                    wpgamelist_search_area($options_row);
                       
                    wpgamelist_stat_area($wpdb, $result, $games_finished, $count, $options_row, $genre_count);
                    //wpgamelist_total_pages_read($wpdb, $count, $table_name, $options_row);
                    //wpgamelist_missing_cats($wpdb, $count, $table_name, $genre_count, $options_row, $persistent_count);
                    ?> </div></div> <?php
                    if($options_row[0]->hidequotegame == null){
                        wpgamelist_quote_area($quote_results, $num_of_quotes, $quote_results_game, $num_of_quotes_game, $hidequotegame);
                    }
                   wpgamelist_sort_and_call_games($wpdb, $hide_edit_delete, $sort_id, $table_name, $count, $games_on_page, $sort_option);
                    
                    ?></div></div>

<?php
  function wpgamelist_top_three_options($wpdb, $table_name, $count, $options_row){
    $genre_count = 0;
                    if($options_row[0]->hideaddgame == null){
                    ?>
                        <input type="text" id="wpgamelist_game_title_search" name="isbn" />
                        <a class="wpgamelist_control_panel_button" id="wpgamelist_add_game_link" >Add a Game</a>
                    <?php
                    }
                   
                    if($options_row[0]->hidesortby == null){
                    ?>
                    <form id="wpgamelist_select_sort_form" method="post" action="ui.php">
                        <select id="wpgamelist_sort_select_box" name="cars">    
                            <option selected disabled>Sort By...</option>
                            <option value="default">Default</option>
                            <option value="alphabetically">Alphabetically</option>
                            <option value="year_finished">Year Finished</option>
                            <optgroup label="Genres"><?php
                                // Code below dynamically adds all the genres that exist into the "sort by" drop-down box, making sure that case of the text ins't an issue and that there aren't duplicate entries
                                  
                                $offset = 0;
                while($count > 0){
                        $new_array = array(); 
                        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY genre ASC LIMIT {$offset},%d", 100), ARRAY_A);
                          $genre_array = array();
                          foreach($results as $key=>$item ){
                            $broken_genre = rtrim($item['genre'], ',');
                            $broken_genre = str_replace(' ', '', $broken_genre);
                            $broken_genre = str_replace('(', ' (', $broken_genre);
                            $broken_genre = str_replace('ActionRPG', 'Action RPG', $broken_genre);
                            $broken_genre = str_replace('Turn-basedstrategy (TBS)', 'Turn-based strategy (TBS)', $broken_genre);
                            $broken_genre = str_replace('RealTimeStrategy (RTS)', 'Real Time Strategy (RTS)', $broken_genre);
                            $broken_genre = explode(',', $broken_genre);

                            foreach($broken_genre as $item2){
                                array_push($genre_array, $item2);
                            }
                            $genre_array = array_unique($genre_array);
                          }  
                          $genre_array = array_unique($genre_array);



                    foreach($genre_array as $b){
                            if(in_array(strtolower($b), array_map("strtolower", $new_array))){
                                            
                                            } else {
                                                    if($b['genre'] != null){
                                                        echo '<option value="cat'.esc_attr($b).'">'.esc_attr($b).'</option>';
                                                    $genre_count++;
                                                }
                                                    array_push($new_array,$b);
                                                    
                                            }
                    }
                        
                        $new_array = null;
                        unset($new_array);
                        $results = null;
                        unset($results);
                    $offset = $offset+100;
                    $count = $count-100;
                }
                                $count = $persistent_count;
                               ?>
                            </optgroup> 
                        </select>
                    <?php
                    }

                    if($options_row[0]->hidebackupdownload == null){
                    ?>
                    <a class="wpgamelist_control_panel_button" id="wpgamelist_upload_link" >Backup & Download Game Library</a>
                    </form><?php
                    }

return $genre_count;
}

function wpgamelist_search_area($options_row){
if($options_row[0]->hidesearch== null){
                    ?>
                    
                <div id="wpgamelist_search_tdiv">
                    <div>
                        <input id="wpgamelist_search_text" type="text" name="search_query" value="Search by title...">
                    </div>
                    <div id="wpgamelist_search_submit">
                        <input id="wpgamelist_search_sub_button" type="button" name="search_button" value="Search"></input>
                    </div>
                </div>

        <?php
                    }
}

function wpgamelist_stat_area($wpdb, $result, $games_finished, $count, $options_row, $genre_count){
    if($options_row[0]->hidestats == null){
                        ?>
                    <div class="wpgamelist_stats_tdiv">
                        <p class="wpgamelist_control_panel_stat">Total Games: <?php echo number_format($count);?></p>
                        <p class="wpgamelist_control_panel_stat">Total Genres: <?php echo number_format($genre_count);?></p>
                        <p class="wpgamelist_control_panel_stat">Finished: <?php echo number_format($games_finished);?></p>
                        <p class="wpgamelist_control_panel_stat">Library Completion: <?php if(($games_finished == 0) || ($count == 0)){echo '0%';} else {echo number_format((($games_finished/$count)*100), 2).'%';}?></p>               
                        <?php
        $games_finished=null; unset($games_finished); 
    }                  
}


function wpgamelist_quote_area($quote_results, $num_of_quotes, $quote_results_game, $num_of_quotes_game, $hidequotegame){

    $quote_num = rand(0,$num_of_quotes);
    $quote_actual = $quote_results[$quote_num]->quote;
    $pos = strpos($quote_actual,'" - ');
    $attribution = substr($quote_actual, $pos);
    $quote = substr($quote_actual, 0, $pos);
    echo '<p style="display:none;" class="wpgamelist-ui-quote-area"><span style="font-style:italic;">'.$quote.'</span><span style="font-weight:bold;">'.$attribution.'</span></p>';

    $quote_num2 = rand(0,$num_of_quotes_game);
    $quote_actual2 = $quote_results_game[$quote_num2]->quote;
    $pos2 = strpos($quote_actual2,'" - ');
    $attribution2 = substr($quote_actual2, $pos2);
    $quote2 = substr($quote_actual2, 0, $pos2);
    echo '<p style="display:none;" id="wpgamelist-ui-quote-area-hidden"><span style="font-style:italic;">'.$quote2.'</span><span style="font-weight:bold;">'.$attribution2.'</span></p>';    

    echo '<p id="wpgamelist-hidden-quote-indicator" style="display:none;">'.$hidequotegame.'</p>';
}

function wpgamelist_sort_and_call_games($wpdb, $hide_edit_delete, $sort_id, $table_name, $count, $games_on_page, $sort_option){
if(isset($_GET['search_query'])){

    $searchquery = filter_var($_GET['search_query'], FILTER_SANITIZE_STRING);
    $titlequery = filter_var($_GET['title_query'], FILTER_SANITIZE_STRING);
    if(isset($_GET['update_id'])){
        $updateid = filter_var($_GET['update_id'], FILTER_SANITIZE_STRING);
    }
    if(isset($_GET['page_control'])){
        $pagecontrol = filter_var($_GET['page_control'], FILTER_SANITIZE_NUMBER_INT);
    }

    $title_query = $titlequery;
                $my_query = '%'.$searchquery.'%';
                    $result = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE name LIKE '%s'", $my_query));
                    $search_count = $result;
                ?> <div id="wpgamelist-search-count"> <?php echo $search_count.' results found'; ?> </div> <?php
}

if(isset($_GET['update_id'])){
                $sort_id = filter_var($_GET['update_id'], FILTER_SANITIZE_STRING);
            } else if(isset($sortid)) {
                $sort_id = filter_var($_GET['update_id'], FILTER_SANITIZE_STRING);
            } else {
                
            }
            $genre_case;
            $genre_actual;
                if(substr($sort_id, 0, 3) == 'cat'){
                    $genre_actual = substr($sort_id, 3);
                    $genre_actual_for_echo = htmlspecialchars($genre_actual);
                    $sort_id = 'cat';
                    $my_query = "SELECT * FROM $table_name WHERE genre LIKE '%$genre_actual_for_echo%'"; ?> 
                    <p id="wpgamelist_cat_report"><?php echo $genre_actual; ?>: <?php  echo sizeof($wpdb->get_results($my_query, ARRAY_A)) ?> Entries Found</p> <?php
                }
            // Switch statement handles logic for which 'sort by' the user selected, creates a database query, and passes the query and the actual user selection to the wpgamelist_display_games function   
           
            $sorter = $sort_id;
        if(!isset($_GET['search_query'])){
            switch ($sorter) {
                case "alphabetically":
                    $my_query = "SELECT * FROM $table_name ORDER BY name ASC";
                    wpgamelist_display_games($wpdb, $count, $my_query, $sorter, $hide_edit_delete, $games_on_page, $table_name);
                    break;
                case "year_finished":
                    $my_query = "SELECT * FROM $table_name WHERE finished = 'yes' AND (yearfinished <> 0 OR yearfinished IS NULL) ORDER BY yearfinished ASC";
                    wpgamelist_display_games($wpdb, $count, $my_query, $sorter, $hide_edit_delete, $games_on_page, $table_name);
                    break;
                case "cat":
                    $my_query = "SELECT * FROM $table_name WHERE genre LIKE '%$genre_actual_for_echo%'";
                    //$my_query = "SELECT * FROM $table_name WHERE genre = "."'".htmlspecialchars($genre_actual)."'";
                    wpgamelist_display_games($wpdb, $count, $my_query, $sorter, $hide_edit_delete, $games_on_page, $table_name);
                    break;
                default:
                    if(empty($searchquery)){
                        $my_query = "SELECT * FROM $table_name";
                        wpgamelist_display_games($wpdb, $count, $my_query, $sorter, $hide_edit_delete, $games_on_page, $table_name);
                    }
            }//end switch 
        }      

             //Handles the search function. Creates a query, calls wpgamelist_display_games function
            if(!empty($searchquery)){
                $my_query = $searchquery;
                    $my_query = "SELECT * FROM $table_name WHERE name LIKE '%$my_query%'";
                    wpgamelist_display_games($wpdb, $count, $my_query, 'search_requested', $hide_edit_delete, $games_on_page, $table_name );
            }

}

function wpgamelist_display_games($wpdb, $count, $my_query, $sort_id, $hide_edit_delete, $games_on_page, $table_name){
    $start_with = 0;

    if(isset($_GET['page_control'])){
        $start_with = filter_var($_GET['page_control'], FILTER_SANITIZE_NUMBER_INT);
        $start_with = (intval($start_with) * intval($games_on_page)); 
    }
        
        $query = $my_query.' LIMIT '.$start_with.','.$games_on_page;
        $results = $wpdb->get_results($query, ARRAY_A);
    
 ?> 
                <div id="wpgamelist_main_display_tdiv"><?php
            if($results == null){
                ?><div id="wpgamelist-nogames-app-notice">
                    <p id="wpgamelist-nogames-app-notice-p">Uh-oh, no games! Well, since you're here, if you like to read a book occasionally, be sure to check out another plugin of mine, <a style="font-size:16px" target="_blank" href="https://wordpress.org/plugins/wpbooklist/"><span id="wpgamelist-mobile-app-span">WordPress Book List!</span></a> With WPBookList, you can add your entire library to your WordPress website for the whole internet to see! Check out the <a style="font-size:16px" target="_blank" href="http://www.jakerevans.com/library/">live demo right here</a>, or <a style="font-size:16px" target="_blank" href="https://wordpress.org/plugins/wpbooklist/">download the free version of WPBookList now!</a></p>
                    <p id="wpgamelist-nogames-app-notice-p">The Premium version of WPBooklist is <a style="font-size:16px;" href="https://www.jakerevans.com/shop/">avaliable here.</a></p>
                    <p style="font-size: 20px;font-weight: bold; font-style: italic; margin-bottom: 0;" id="wpgamelist-nogames-app-notice-p">Like WPGameList Do Ya?</p>
                    <p id="wpgamelist-nogames-app-notice-p">if you're just simply thrilled beyond belief with WPGameList, then please feel free to <a style="font-size:16px;" href="https://wordpress.org/support/plugin/wpgamelist/reviews/">leave a 5-star review here!</a></p>


                       <?php
            }
           foreach($results as $b){
                $column_control = 0;
               
                // Controls how many games are displayed per page. Changing the '12' value below will change how many games appear. 
                    $start_num = 0;
                    $end_num = 0;

                        // This if else statement controls the placement/logic of the image, the title, and the 'edit' and 'delete' links
                        if($b['cover'] == null){
                            ?><div class="wpgamelist_entry_div">
                                <p style="display:none;" id="wpgamelist-hidden-isbn<?php echo esc_attr($b['ID']) ?>"><?php echo $b['isbn']; ?></p>
                                <div class="wpgamelist_inner_main_display_div">
                                    <img class="wpgamelist-select-game-by-img-class" id="wpgamelist_cover_image" src="<?php echo plugins_url( '/assets/img/noimage.jpg', __FILE__ ); ?>"/>
                                    <span class="hidden_id_title"><?php echo $b['ID']; ?></span>
                                    <p style="opacity:0" class="wpgamelist_saved_title_link" id="wpgamelist_saved_title_link" ><?php echo htmlspecialchars_decode($b['name']); ?>
                                        <span class="hidden_id_title"><?php echo $b['ID']; ?></span>
                                    </p>
                                    <div class="wpgamelist_line_under_image"></div>
                                     <?php
                                     
                            if($hide_edit_delete != '0'){
                                ?>
                                    <a style="opacity:0"  class="wpgamelist_edit_entry_link" id="wpgamelist_edit_game_link">Edit
                                        <span class="hidden_id"><?php echo $b['ID']; ?></span>
                                    </a>
                                    <a style="opacity:0"  class="wpgamelist_delete_entry_link" id="wpgamelist_delete_game_link">Delete<span class="hidden_id"><?php echo $b['ID']; ?></span>
                                    </a>   
                                         <?php
                                    }                                
                                    ?>    
                                                    
                                 </div>
                            </div><?php
                            $column_control++;
                        } else {?>
                            <div class="wpgamelist_entry_div">
                                <p style="display:none;" id="wpgamelist-hidden-isbn<?php echo esc_attr($b['ID']) ?>"><?php echo $b['isbn']; ?></p>
                                <div class="wpgamelist_inner_main_display_div">
                                    <img class="wpgamelist-select-game-by-img-class" id="wpgamelist_cover_image" src=<?php echo '"'. $b['cover'].'"'; ?> />
                                    <span class="hidden_id_title"><?php echo $b['ID']; ?></span>
                                    <p style="opacity:0" class="wpgamelist_saved_title_link" id="wpgamelist_saved_title_link" ><?php echo stripslashes(htmlspecialchars_decode($b['name'])); ?>
                                        <span class="hidden_id_title"><?php echo $b['ID']; ?></span>
                                    </p>
                                    <div class="wpgamelist_line_under_image"></div>

                                 <?php
                        if($hide_edit_delete != '0'){
                                ?>      
                                    <a style="opacity:0" class="wpgamelist_edit_entry_link" id="wpgamelist_edit_game_link">Edit
                                        <span class="hidden_id"><?php echo $b['ID']; ?></span>
                                    </a>                
                                    <a style="opacity:0" class="wpgamelist_delete_entry_link" id="wpgamelist_delete_game_link">Delete<span class="hidden_id"><?php echo $b['ID']; ?></span>
                                    </a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div><?php
                            $column_control++;
                        }  
                    

            } 
            $results = null;
            unset($results); 
wpgamelist_page_control($games_on_page, $count, $table_name);

}

function wpgamelist_page_control($games_on_page, $count, $table_name){
 
    $page_num = $count/$games_on_page;
    $remainder = $count%$games_on_page;
    
    if(isset($_GET['page_control'])){
        $current_page = filter_var($_GET['page_control'], FILTER_SANITIZE_NUMBER_INT);
    } else {
        $current_page = null;
    }
    

       if($page_num >= 1){
        if($remainder == 0){
           $page_num--;
        }?>
        <div id="wpgamelist_page_control_div"><?php
        for($i = 0; $i <= $page_num; $i++){
            ?>
            <a class="wpgamelist_page_control_link_class" <?php if($current_page == $i){ echo 'id="wpgamelist-active-page"'; }else{echo 'id="wpgamelist_page_control_link_id"';}  ?> ><?php echo $i+1; ?></a><?php
        } 
    
    }

    ?>
      </div><?php
      }

?>