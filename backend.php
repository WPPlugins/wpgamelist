<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( is_user_logged_in() ) {
    
} else {
    exit;
}
function page_tabs($current = 'first') {
    $tabs = array(
        'first'   => __("General Settings", 'plugin-textdomain'),
        'second'  => __("StylePaks", 'plugin-textdomain'), 
        'third'  => __("WPGameList Premium", 'plugin-textdomain'),
        'fourth'  => __("Other Plugins", 'plugin-textdomain'),
        'fifth'  => __("Donate", 'plugin-textdomain'),
        'sixth'  => __("Review & Get Involved!", 'plugin-textdomain')
    );
    $html =  '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ($tab == $current) ? 'nav-tab-active' : '';
        $html .=  '<a class="nav-tab ' . $class . '" href="?page=WP-game-List-Options&tab=' . $tab . '">' . $name . '</a>';
    }
    $html .= '</h2>';
    echo $html;
}

// Code displayed before the tabs (outside)
// Tabs
$tab = (!empty($_GET['tab']))? esc_attr($_GET['tab']) : 'first';
page_tabs($tab);
// Grabbing the existing options from DB
global $wpdb;
$table_name2 = $wpdb->prefix . 'wpgamelist_jre_list_dynamic_db_names';
$db_row = $wpdb->get_results("SELECT * FROM $table_name2");
$table_name = $wpdb->prefix . 'wpgamelist_jre_user_options';
$check_table_name = 'wpgamelist_jre_list_dynamic_db_names';
$options_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE ID = %d", 1));


switch ($tab) {
    case "first":
?>
<div id="wpgamelist-top-backend-div">
<form class="wpgamelist-backend-form-style" id="wpgamelist-jre-display-options" action="">
<div id="wpgamelist-jre-backend-display-options">
  <p><span id="wpgamelist-display-title">Display Options</span></p>
  <table id="wpgamelist-jre-backend-options-table">
    <tbody>
      <tr>
        <td><label>Hide 'Add a Game'</label></td>
        <td><input type="checkbox" name="hide-add-a-game"<?php if($options_row[0]->hideaddgame != null){echo esc_attr('checked="checked"');}?> ></input></td>
        <td><label>Hide the Search area</label></td>
        <td><input type="checkbox" name="hide-search"<?php if($options_row[0]->hidesearch != null){echo esc_attr('checked="checked"');}?> ></input></td>
      </tr>
      <tr>
        <td><label>Hide the Statistics Area</label></td>
        <td><input type="checkbox" name="hide-stats-area"<?php if($options_row[0]->hidestats != null){echo esc_attr('checked="checked"');}?> ></input></td>
        <td><label>Hide the 'Edit' and 'Delete' options</label></td>
        <td><input type="checkbox" name="hide-edit-delete"<?php if($options_row[0]->hideeditdelete != null){echo esc_attr('checked="checked"');}?> ></input></td>
      </tr>
      <tr>
        <td><label>Hide the 'Sort By...' drop-down box</label></td>
        <td><input type="checkbox" name="hide-sort-by"<?php if($options_row[0]->hidesortby != null){echo esc_attr('checked="checked"');}?> ></input></td>
        <td><label>Hide 'Backup and Download Game List'</label></td>
        <td><input type="checkbox" name="hide-backup-download"<?php if($options_row[0]->hidebackupdownload != null){echo esc_attr('checked="checked"');}?> ></input></td>
      </tr>
      <tr>
    <td><label>Hide the Facebook Share Button</label></td>
    <td><input type="checkbox" name="hide-facebook"<?php if($options_row[0]->hidefacebook != null){echo esc_attr('checked="checked"');}?> ></input></td>
     <td><label>Hide the Facebook Messenger Button</label></td>
    <td><input type="checkbox" name="hide-messenger"<?php if($options_row[0]->hidemessenger != null){echo esc_attr('checked="checked"');}?> ></input></td>
</tr>
<tr>
    <td><label>Hide the Google+ Share Button</label></td>
    <td><input type="checkbox" name="hide-googleplus"<?php if($options_row[0]->hidegoogleplus != null){echo esc_attr('checked="checked"');}?> ></input></td>
    <td><label>Hide the Pinterest Share Button</label></td>
    <td><input type="checkbox" name="hide-pinterest"<?php if($options_row[0]->hidepinterest != null){echo esc_attr('checked="checked"');}?> ></input></td>
</tr>
<tr>
    <td><label>Hide the Email Share Button</label></td>
    <td><input type="checkbox" name="hide-email"<?php if($options_row[0]->hideemail != null){echo esc_attr('checked="checked"');}?> ></input></td>
    <td><label>Hide the Videos & Trailers</label></td>
    <td><input type="checkbox" name="hide-vids"<?php if($options_row[0]->hidevids != null){echo esc_attr('checked="checked"');}?> ></input></td>
</tr>
<tr>
     <td><label>Hide the Twitter Share Button</label></td>
    <td><input type="checkbox" name="hide-twitter"<?php if($options_row[0]->hidetwitter != null){echo esc_attr('checked="checked"');}?> ></input></td>
    <td><label>Hide the Screenshots</label></td>
    <td><input type="checkbox" name="hide-screenshots"<?php if($options_row[0]->hidescreenshots != null){echo esc_attr('checked="checked"');}?> ></input></td>
</tr>
<tr>
    <td><label>Hide the Game Notes</label></td>
    <td><input type="checkbox" name="hide-notes"<?php if($options_row[0]->hidenotes != null){echo esc_attr('checked="checked"');}?> ></input></td>
    <td><label>Hide the Game Description</label></td>
    <td><input type="checkbox" name="hide-description"<?php if($options_row[0]->hidedescription != null){echo esc_attr('checked="checked"');}?> ></input></td>
</tr>
<tr>
    <td><label>Hide the Bottom Purchase Links</label></td>
    <td><input type="checkbox" name="hide-bottom-purchase"<?php if($options_row[0]->hidebottompurchase != null){echo esc_attr('checked="checked"');}?> ></input></td>
</tr>
<tr>
<td><label>Set Games Per Page</label></td>
    <td><input class="wpgamelist-dynamic-input" id="wpgamelist-game-control" type="text" name="games-per-page" value="<?php echo esc_attr($options_row[0]->gamesonpage); ?>"></input></td>
</tr>
    </tbody>
  </table>
  <button id="wpgamelist-save-backend" name="save-backend" type="button">Save Changes</button>
</div>
</form> 

<form class="wpgamelist-backend-form-style" id="wpgamelist-dynamic-shortcode-db" action="">
  <div id="wpgamelist-dynamic-shortcode-div">
    <p id="wpgamelist-use-shortcodes">Use these Shortcodes below to display your different libraries, or create a new Library</p>
    <table>
    <tbody>
    <tr colspan="2"><td colspan="2"><p><span class="wpgamelist-jre-cover-shortcode-class">[wpgamelist_shortcode]</span> - (default shortcode for default library)</p></td></tr>
    <tbody>   
    <?php
    $counter = 0;
    
    foreach($db_row as $db){
      $counter++;
      ?><tr><td><p><?php if(($db->user_table_name != "") || ($db->user_table_name != null)){ echo esc_html('[' .'wpgamelist_shortcode table="'.$db->user_table_name.'"]');?></p></td><td><button id="<?php echo esc_attr($db->user_table_name.'_'.$counter);?>" class="wpgamelist_delete_custom_lib" type="button" >Delete Library</button></td></tr><?php }
    }
    
    ?>
    <tr><td><input type="text" value="Create a New Library Here..." class= "wpgamelist-dynamic-input" id="wpgamelist-dynamic-input-library" name="wpgamelist-dynamic-input"></input></td><td><button id="wpgamelist-dynamic-shortcode-button" type="button" disabled="true">Create New Game Library</button></td></tr>
    </tbody>
    </table>
  </div>
</form>

<form class="wpgamelist-backend-form-style">
<div id="wpgamelist-forward-creation-logo">
<div id="wpgamelist-visit-me">Visit Me At:</div>
<a target="_blank" id="wpgamelist-jakes-site" href="http://www.jakerevans.com"><img src="<?php echo plugins_url('/assets/img/JakesSite.png', __FILE__); ?>" /></a>
</div>
<p id="email-me">E-mail me with questions, issues, concerns, suggestions, or anything else at <a href="mailto:jake@jakerevans.com">Jake@Jakerevans.com</a></p>
</div>
</form>
<?php
break;
case "second":
?>
<form class="wpgamelist-backend-form-style" id="wpgamelist-jre-upload-stylepak-form" enctype="multipart/form-data" action="">
  <div id="wpgamelist-stylepak-top-backend-div">
    <div id="wpgamelist-jre-backend-display-options">
      <p><span id="wpgamelist-display-title">WPgameList StylePaks</span></p>
      <p style="font-style:italic;">What's a StylePak you ask? StylePaks are the best way to customize the look and feel of your WPgameList plugin! Simply head to <a href="https://www.jakerevans.com/shop/">JakeREvans.com</a>, select the StylePak you want, upload it here, and watch as your WPgameList plugin is automatically transformed!</br></br><a id="wpgamelist-stylepaks-purchase-button" href="https://www.jakerevans.com/shop/">Get Your StylePaks Here!</a></br></br></p>
      <select id="wpgamelist_select_stylepak_box" name="cars">    
            <option selected disabled>Select a StylePak...</option>
            <?php if($options_row[0]->stylepak == 'Default'){
              echo "<option selected='selected'>Default</option>";
            } else{ echo "<option>Default</option>"; }  ?>
            
            <?php 
              foreach(glob($_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/wpgamelist/stylepak-exports/*.*') as $filename){
                 $pos = strripos($filename, 'exports');
                 $filename = substr($filename,($pos+8));
                 $temp = str_replace('.css', '', $filename); 
                    ?><option id="<?php echo $filename; ?>" <?php if ($options_row[0]->stylepak == $temp){ echo 'selected="selected"'; } ?> value="<?php echo $filename; ?>"><?php echo $temp; ?></option><?php
                 
              } ?>
        </select>

    </div>
  </div>
  <div style="margin:10px; font-weight:bold; text-align: center; font-style:italic;"> Or </div>
  <input id="wpgamelist-add-new-stylepak-file" style="display:none;" type="file" id="files" name="files[]" multiple />
  <button style="margin-left: auto; margin-right: auto; display: block;" id="wpgamelist-add-new-stylepak-button" onclick="document.getElementById('wpgamelist-add-new-stylepak-file').click();" name="add-stylepak-file" type="button">Add a New StylePak</button>
</form>

<?php
break;


case "third":
?>
  <div id="wpgamelist-top-app-notice" class="wpgamelist-backend-form-style">
  <p id="wpgamelist-top-app-p"><span id="wpgamelist-display-title">Get WPGamelist Premium now and receive these features:</span></p>
  <div id="wpgamelist-premium-features-div1">
    <a href="https://www.jakerevans.com/product/wordpress-game-list-premium/" target="_blank"><img width="175" style="position:relative; float:left; left: 20px;" src="<?php echo plugins_url('/assets/img/wpgamelistpremium.png', __FILE__); ?>" /></a>
  </div>
  <div id="wpgamelist-premium-features-div2">
    <ul id="wpgamelist-premium-features-list">
      <li>- Add Xbox Gamertags to display your Xbox One Achievements</li>
      <li>- Display a continuously-updated news feed for nearly every title</li>
      <li>- Review stars to indicate your opinion of each title</li>
      <li>- List the Alternative Names for each title, including foreign languages (Japanese, Chinese, German, Russian, etc.)</li>
      <li>- ESRB Images are displayed per title</li>
      <li>- Additional Platform sorting options</li>
      <li>- Set the default sorting option site-wide</li>
      <li style="margin-left:170px;">- Display awesome, colorful backdrop images</li>
    </ul>
  </div>
  <div>    
  </div>
  <div id="wpgamelist-purchase-line"></div>
  <div id="wpgamelist-premium-features-div3">
    <p>Get all of the awesome functionality of the free version, plus the features listed above <a href="https://www.jakerevans.com/product/wordpress-game-list-premium/" target="_blank"> right now for <span id="wpgamelist-purchase-money">just $5 Dollars!</span></a> That's only 2 cups of coffee!</p>
  </div>
  <div id="wpgamelist-premium-features-div4">
    <a href="https://www.jakerevans.com/product/wordpress-game-list-premium/" target="_blank"><img style="width: 200px; margin:10px;" src="<?php echo plugins_url( '/assets/img/WPGamelistPremPurchase.png', __FILE__ ); ?>"/></a>

  </div>
</div>

<?php
break;
case "fourth":
?>
<div style="float:left" id="wpgamelist-top-app-notice-wpbooklistfree-advert" class="wpgamelist-backend-form-style-wpbooklistfree-advert">
      <p id="wpgamelist-top-app-p-others"><span id="wpgamelist-display-title">Like Books? Then Check Out WPBookList!</span><br><a href="https://wordpress.org/plugins/wpbooklist/" target="_blank"><img width="175" src="<?php echo plugins_url('/assets/img/WPBooklistIcon.png', __FILE__); ?>" /></a></p>
      <div id="wpgamelist-premium-features-div1">
      </div>
      <div id="wpgamelist-purchase-line-20"></div>
      <div id="wpgamelist-premium-features-div2">
        <p class="wpgamelist-how-work-other-plugs">How does WPBookList Work?</p>
        <p style="margin: 0px;">Simply plug in the ISBN number of your book and let WordPress Book List scour the internet for all information possible about the title, including:</p>
        <ul style="margin-top: 0px;" id="wpgamelist-premium-features-list">
          <li>- Cover Image & Amazon Reviews -</li>
          <li>- Editor's Descriptions -</li>
          <li>- Author, Publisher, and Publication dates -</li>
          <li>- Total Pages and Genres -</li>
          <li>- Year you read it, & whether it's signed or a first edition -</li>
        </ul>
        <div id="wpgamelist-free-wpbooklist-advert-button"><a href="https://wordpress.org/plugins/wpbooklist/">Try It Now!</a></div>
      </div>
      <div>        
      </div>
      <div id="wpgamelist-purchase-line-2"></div>
      <div id="wpgamelist-premium-features-div3">
        <p id="wpgamelist-top-app-p-others" class="wpgamelist-advert-wpbooklist-prem"><span id="wpgamelist-display-title">Tried It? Liked It? Want More? Then Get WPBookList Premium!</span><br><a href="https://www.jakerevans.com/product/wordpress-book-list-premium/" target="_blank"><img style="position: relative; top: 15px;" width="175" src="<?php echo plugins_url('/assets/img/WPBookListPremium.png', __FILE__); ?>" /></a></p>
      <div id="wpgamelist-premium-features-div1">
      </div>
      <div id="wpgamelist-purchase-line-20"></div>
        <p class="wpgamelist-how-work-other-plugs">With WPBookList Premium, You Can:</p>
        <ul id="wpgamelist-premium-features-list-2">
          <li>- Add your Amazon Affiliate ID to each book you display -</li>
          <li>- Import your entire Goodreads library -</li>
          <li>- Get access to the WPBookList Mobile App! -</li>
          <li>- Randomly display classic & famous literary quotes -</li>
          <li>- Rate each title and display the rating for all to see -</li>
          <li>- Display Amazon reviews based on country -</li>
          <li>- Set the default sorting option site-wide -</li>
        </ul>
        <p style="font-weight:bold;">Get all of the awesome functionality of the free version, plus the features listed above <a href="https://www.jakerevans.com/product/wordpress-book-list-premium/" target="_blank"> right now for <span id="wpgamelist-purchase-money">just $5 Dollars!</span></a> That's only 2 cups of coffee!</p>
        <div id="wpgamelist-free-wpbooklist-advert-button"><a href="https://www.jakerevans.com/product/wordpress-book-list-premium/">Get It Now!</a></div>
      </div>
      <div id="wpgamelist-premium-features-div4">
        <a href="https://www.jakerevans.com/product/wordpress-book-list-premium/" target="_blank"><img style="width: 200px; margin:10px;" src="<?php echo plugins_url( '/assets/img/WPBooklistPremPurchase.png', __FILE__ ); ?>"/></a>
        <a href="https://www.jakerevans.com/product/wordpress-book-list-premium/" target="_blank"><img style="width: 200px;" src="<?php echo plugins_url( '/assets/img/WPBookListUpgradeBadges.png', __FILE__ ); ?>"/></a>
      </div>
    </div>





      <div id="wpgamelist-top-app-notice-wpgamelistfree-advert" class="wpgamelist-backend-form-style-wpgamelistfree-advert">
      <p id="wpgamelist-top-app-p-others"><span id="wpgamelist-display-title">Like Movies & TV Shows? Then Check Out WPFilmList!</span><br><a href="https://wordpress.org/plugins/wpfilmlist/" target="_blank"><img style="width: 185px; margin-top: 10px;" width="185" src="<?php echo plugins_url('/assets/img/wpfilmlisticon.png', __FILE__); ?>" /></a></p>
      <div id="wpgamelist-premium-features-div1">
      </div>
      <div id="wpgamelist-purchase-line-20"></div>
      <div id="wpgamelist-premium-features-div2">
        <p class="wpgamelist-how-work-other-plugs">How does WPFilmList Work?</p>
        <p style="margin: 0px;">Simply plug in the name of your Movie or TV Show and let WordPress Film List scour the internet for all information possible about the title, including:</p>
        <ul style="margin-top: 0px;" id="wpgamelist-premium-features-list">
          <li>- Poster Images & Screenshots -</li>
          <li>- Trailers & Videos -</li>
          <li>- Summaries & Genres -</li>
          <li>- Release Dates & Runtimes -</li>
          <li>- Seasons, Budget & Revenues, and Links -</li>
        </ul>
        <div id="wpgamelist-free-wpgamelist-advert-button"><a href="https://wordpress.org/plugins/wpfilmlist/">Try It Now!</a></div>
      </div>
      <div>        
      </div>
      <div id="wpgamelist-purchase-line-2"></div>
      <div id="wpgamelist-premium-features-div3">
        <p id="wpgamelist-top-app-p-others" class="wpgamelist-advert-wpbooklist-prem"><span id="wpgamelist-display-title">Tried It? Liked It? Want More? Then Get WPFilmList Premium!</span><br><a href="https://www.jakerevans.com/product/wordpress-film-list-premium/" target="_blank"><img style="position: relative; top: 15px;" width="175" src="<?php echo plugins_url('/assets/img/wpfilmlistPremium.png', __FILE__); ?>" /></a></p>
      <div id="wpgamelist-premium-features-div1">
      </div>
      <div id="wpgamelist-purchase-line-20"></div>
        <p class="wpgamelist-how-work-other-plugs">With WPFilmList Premium, You Can:</p>
        <ul id="wpgamelist-premium-features-list-2">
          <li>- Add your Amazon Affiliate ID to each title you display -</li>
          <li>- Display famous and entertaining movie quotes -</li>
          <li>- Display Cast and Crew images and information for every entry -</li>
          <li>- Save time by Bulk-Editing all of your entries -</li>
          <li>- Rate each title with 1-5 review stars and display the rating for all to see -</li>
          <li>- Set the default sorting option site-wide -</li>
        </ul>
        <p style="font-weight:bold;">Get all of the awesome functionality of the free version, plus the features listed above <a href="https://www.jakerevans.com/product/wordpress-film-list-premium/" target="_blank"> right now for <span id="wpgamelist-purchase-money">just $5 Dollars!</span></a> That's only 2 cups of coffee!</p>
        <div id="wpgamelist-free-wpgamelist-advert-button"><a href="https://www.jakerevans.com/product/wordpress-film-list-premium/">Get It Now!</a></div>
      </div>
      <div id="wpgamelist-premium-features-div4">
        <a href="https://www.jakerevans.com/product/wordpress-film-list-premium/" target="_blank"><img style="width: 200px; margin:10px;" src="<?php echo plugins_url( '/assets/img/wpfilmlistPremPurchase.png', __FILE__ ); ?>"/></a>
      </div>
    </div>

<?php
break;

case "fifth":
?>
<div style="text-align:center;" class="wpgamelist-backend-form-style">
<p style="    border-top: 0px;
    border-right: 0px;
    border-left: 0px;
    border-bottom: 1px;
    border-style: solid;" id="wpgamelist-donate-title"><span id="wpgamelist-display-title">Donate to WordPress Game List</span></p>
<p>Development of WordPress Game List is fun, but hard work! Any and all donations are greatly appreciated!</p>
<p>Half of all donations go straight to educational charities in the US (and the other half pretty much ends up going to Starbucks...)</p>
<div id="money-links">
<form style="display:inline-block;" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="UWUNZ82VFCAWY">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
<a target="_blank" id="patreon-link" href="http://patreon.com/user?u=3614120"><img id="wpgamelist-patreon-img" src="<?php echo plugins_url( '/assets/img/patreon.png', __FILE__ ); ?>" /></a>
<a href='https://ko-fi.com/A8385C9' target='_blank'><img height='34' style='border:0px;height:34px;' src='<?php echo plugins_url( '/assets/img/kofi1.png', __FILE__ ); ?>' border='0' alt='Buy Me a Coffee at ko-fi.com' /></a>
<p>And be sure to <a target="_blank" href="https://wordpress.org/support/plugin/wpgamelist/reviews/">leave a 5-star review of WPGameList!</a></p>
</div>
</div>
<?php
break;
case "sixth":
?>
<div style="text-align:center;" class="wpgamelist-backend-form-style">
      <p style="border-top: 0px; border-right: 0px; border-left: 0px; border-bottom: 1px; border-style: solid;" id="wpgamelist-donate-title"><span id="wpgamelist-display-title">Happy with WPGameList? Have Suggestions to Make It Even Better?</span></p>
      <p></p>
      <p>If you're happy with WPGameList, It'd be absolutely fantastic if you could <a href="https://wordpress.org/support/plugin/wpgamelist/reviews/">leave a 5-star review!</a> It only takes a minute of your time, and it goes a long way towards more downloads and spreading the greatness that is WPGameList with as many people as possible!  </p>
      <div id="money-links">
      <a href="https://wordpress.org/support/plugin/wpgamelist/reviews/"><img width="500" src='<?php echo plugins_url( '/assets/img/review-screenshot.png', __FILE__ ); ?>' /></a>
      <a href=""><img  /></a>
      </div>

      <div id="wpgamelist-purchase-line-2"></div>
      <p id="wpgamelist-donate-title"><span id="wpgamelist-display-title">Let your voice be heard on the official WPGameList Trello Board!</span></p>
      <a target="_blank" href="https://trello.com/invite/b/0cd6goql/e44043ca6ff95f674710ab51db19c2e6/wpgamelist-backlog"><img style="margin-right: auto;margin-left: auto;display: block;" width="300" src='<?php echo plugins_url( '/assets/img/trello.png', __FILE__ ); ?>' /></a>
      <a target="_blank" href=""><img  /></a>
      <a href="https://trello.com/invite/b/0cd6goql/e44043ca6ff95f674710ab51db19c2e6/wpgamelist-backlog">Get Access to the WPGameList Trello Board!</a>
      </div>
      <form class="wpgamelist-backend-form-style">
      <div id="wpgamelist-forward-creation-logo">
      <div id="wpgamelist-visit-me">Visit Me At:</div>
      <a target="_blank" id="wpgamelist-jakes-site" href="http://www.jakerevans.com"><img src="<?php echo plugins_url('/assets/img/JakesSite.png', __FILE__); ?>" /></a>
      </div>
      <p id="email-me">E-mail me with questions, issues, concerns, suggestions, or anything else at <a href="mailto:jake@jakerevans.com">Jake@Jakerevans.com</a></p>
      </form>

<?php
default;


}
?>