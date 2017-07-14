<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
check_ajax_referer( 'wpgamelist-jre-ajax-nonce-edit', 'security' );

function wpgamelist_jre_editentry($saved_game){
    $name = filter_var($saved_game->name, FILTER_SANITIZE_STRING);
    $developer = filter_var($saved_game->developer, FILTER_SANITIZE_STRING);
    $platform = filter_var($saved_game->platform, FILTER_SANITIZE_STRING);
    $genre = filter_var($saved_game->genre, FILTER_SANITIZE_STRING);
    $publisher = filter_var($saved_game->publisher, FILTER_SANITIZE_STRING);
    $release = filter_var($saved_game->releasedate, FILTER_SANITIZE_STRING);
    $storyline = filter_var($saved_game->summary, FILTER_SANITIZE_STRING);
    $notes = filter_var($saved_game->notes, FILTER_SANITIZE_STRING);
    $summary = filter_var($saved_game->summary, FILTER_SANITIZE_STRING);
    $finished = filter_var($saved_game->finished, FILTER_SANITIZE_STRING);
    $yearfinished = filter_var($saved_game->yearfinished, FILTER_SANITIZE_STRING);
    $cover = filter_var($saved_game->cover, FILTER_SANITIZE_STRING);
    $vids = filter_var($saved_game->vids, FILTER_SANITIZE_STRING);
    $rating = filter_var($saved_game->rating, FILTER_SANITIZE_NUMBER_INT);
    $igdburl = filter_var($saved_game->igdburl, FILTER_SANITIZE_STRING);
    $id = filter_var($saved_game->ID, FILTER_SANITIZE_NUMBER_INT);
    ?>

    <!--Form for editing saved game-->
    <div class="wpgamelist_edit_game_form_top_container">
        <form id="wpgamelist_edit_game_form" method="post" action="">
            <p>
                <label for="name">Title: </label>
                <input type="text" id="wpgamelist_name_edit" name="name" size="30" value="<?php echo htmlspecialchars_decode($name) ?>" />
            </p>
            <p>
                <label for="developer">Developer: </label>
                <input type="text" id="wpgamelist_developer_edit" name="developer" size="30" value="<?php echo htmlspecialchars($developer); ?>"/>
            </p>
            <p>
                <label for="pages">Publisher: </label>
                <input type="text" id="wpgamelist_publisher_edit" name="publisher" size="30" value="<?php echo htmlspecialchars( $publisher ) ?>"/>
            </p>
            <p>
                <label for="pubdate">Initial Release Date: </label>
                <input type="text" id="wpgamelist_release_edit" name="release" size="30" value="<?php echo htmlspecialchars( $release ) ?>"/>
            </p>
            <p>
                <label for="publisher">Finished: </label>
                <input style="text-transform:capitalize;" type="text" id="wpgamelist_finished_edit" name="finished" size="30" value="<?php echo htmlspecialchars_decode( $finished ) ?>"/>
            </p>
            <p>
                <label for="category">Year Finished: </label>
                <input type="text" id="wpgamelist_yearfinished_edit" name="yearfinished" size="30" value="<?php if($finished == 'no'){ echo 'N/A';} else { echo htmlspecialchars($yearfinished); } ?>"/>
            </p>
            <p>
                <label for="description">Genre: </label>
                <input type="text" id="wpgamelist_genre_edit" name="genre" rows="3" size="30" value="<?php echo htmlspecialchars($genre)  ?>" />
            </p>
            <p>
                <label for="storyline">Storyline: </label>
                <textarea id="wpgamelist_storyline_edit" name="storyline" rows="3" size="30" value="<?php echo htmlspecialchars($storyline) ?>"><?php echo stripslashes(htmlspecialchars_decode(strip_tags($storyline))); ?></textarea>
            </p>
            <p>
                <label for="summary">Summary: </label>
                <textarea id="wpgamelist_summary_edit" name="summary" rows="3" size="30" value="<?php echo htmlspecialchars($summary) ?>"><?php echo stripslashes(htmlspecialchars_decode(strip_tags($summary))); ?></textarea>
            </p>
            <p>
                <label for="notes">Notes: </label>
                <textarea id="wpgamelist_notes_edit" name="notes" rows="3" size="30" value="<?php echo htmlspecialchars($notes) ?>"><?php echo htmlspecialchars_decode(strip_tags($notes)); ?></textarea>
            </p>
            <p>
                <label for="rating">Rating: </label>
                <input type="text" id="wpgamelist_rating_edit" name="rating" rows="3" size="30" value="<?php echo htmlspecialchars($rating) ?>"/>
            </p>
            <p>
                <label for="platform">Platform: </label>
                <input type="text" id="wpgamelist_platform_edit" name="platform" rows="3" size="30" value="<?php echo htmlspecialchars($platform) ?>"/>
            </p>
                <!--Styling for <p>'s' below is to pass around the particular game's ISBN and ID -->
                <p style="display:none;">
                    <input style="display:none;" type="text"  name="hidden_id_input" value="<?php echo htmlspecialchars( $id ) ?>"/>
                </p>
                <input type="button" value="Edit game" id="wpgamelist_edit_game_submit_button" />
        </form>
    </div>
    <?php
}
?>