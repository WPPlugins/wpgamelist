<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//check_ajax_referer( 'wpgamelist-jre-ajax-nonce-add', 'security' ); // Nonce check
?>

<!--Form for adding a new game-->
    <div class="wpgamelist_add_game_form_top_container" >
        <form id="wpgamelist_add_game_form" method="post" action="">
            <p style="display:none">
                <input type="text" id="wpgamelist_game_igdburl" name="igdburl" value="<?php echo $igdburl; ?>" />
            </p>
            <p style="display:none">
                <input type="text" id="wpgamelist_game_cover" name="cover" value="<?php echo $cover; ?>" />
            </p>
            <p style="display:none">
                <input type="text" id="wpgamelist_game_screenshots" name="screenshots" value="<?php echo $screenshots; ?>" />
            </p>
            <p style="display:none">
                <input type="text" id="wpgamelist_game_vids" name="vids" value="<?php echo $vids; ?>" />
            </p>
            <p>
                <label for="title">Title:</label>
                <input type="text" id="wpgamelist_game_title" name="title" value="<?php echo stripslashes($name); ?>" />
            </p>
            <p>
                <label for="title">Platform(s):</label>
                <input type="text" id="wpgamelist_game_platform" name="platform" value="<?php echo stripslashes($platform); ?>" />
            </p>
            <p>
                <label for="title">Genre:</label>
                <input type="text" id="wpgamelist_game_genre" name="genre" value="<?php echo stripslashes($genre); ?>" />
            </p>
            <p>
                <label for="title">Developed By:</label>
                <input type="text" id="wpgamelist_game_developer" name="developer" value="<?php echo $developer; ?>" />
            </p>
            <p>
                <label for="title">Published By:</label>
                <input type="text" id="wpgamelist_game_publisher" name="publisher" value="<?php echo $publsher; ?>" />
            </p>
            <p>
                <label for="title">Initial Release Date:</label>
                <input type="text" id="wpgamelist_game_release" name="release" value="<?php echo $release; ?>" />
            </p><p>
                <label for="title">Rating:</label>
                <input type="text" id="wpgamelist_game_rating" name="rating" value="<?php echo $rating; ?>" />
            </p>
            <?php if($storyline != ''){ ?>
            <p>
                <label for="notes">Storyline: </label>
                <textarea  id="wpgamelist_game_storyline" name="storyline"><?php echo stripslashes($storyline); ?></textarea>
            </p>
            <?php } ?>
            <p>
                <label for="notes">Summary: </label>
                <textarea  id="wpgamelist_game_summary" name="summary"><?php echo stripslashes($summary); ?></textarea>
            </p>
            <p>
                <label for="notes">Notes (optional): </label>
                <textarea  id="wpgamelist_game_notes" name="notes"></textarea>
            </p>
            <div id="form_movement">
                <p>
                    <table id="wpgamelist_signed_first_table">
                        <tr>
                            <td><label for="year_finished">Have You Finished This game?</label></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" id="wpgamelist_finished_yes" name="finished_yes" value="yes">Yes
                                &nbsp&nbsp&nbsp
                                <input type="checkbox" id="wpgamelist_finished_no" name="finished_no" value="no">Not Yet
                            </td>
                        </tr>
                    </table>
                </p>
                <p>
                    <label id="wpgamelist_year_finished_label" for="year_finished">Year This Game Was Finished: </label>
                    <input type="text" id="wpgamelist_year_finished" disabled="true" name="year_finished" value="" size="30" />
                </p>
                <p id="wpgamelist_add_game_submit">
                    <input type="button" value="Add game" id="wpgamelist_add_game_submit_button" />
                </p>
            </div>
        </form>
    </div>
