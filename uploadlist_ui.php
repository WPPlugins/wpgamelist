<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
check_ajax_referer( 'wpgamelist-jre-ajax-nonce-uploadexcel', 'security' ); // Nonce check

function wpgamelist_jre_uploadlist_ui($upload_path){
?>

<div class="wpgamelist_download_top_div">
    <div id="wpgamelist_backup_download">Backup & Download Library </br></div>
    <div class="wpgamelist_backup_restore_text">
        <p id="wpgamelist_download_id_p">Choose a backup to restore your Library from in the drop-down box below. Note that this will completely erase the current Library and replace it with the information contained within the backup. There is no undoing this action.</p>
        <a class="wpgamelist_backup_link" id="wpgamelist_export_link" href="">Create a Backup & Download Spreadsheet</a>
    </div>
    <!-- Creating the drop-down list of stored backups. The # of existing backups are used to create unique filenames -->
    <select id="wpgamelist_select_backup_box" name="cars">    
        <option selected disabled>Choose a Backup...</option><?php
        
        
        $file_to_create = glob( $upload_path.'/wpgamelist/backups/*.*' );
                error_log(print_r($file_to_create,true));

        array_multisort(array_map( 'filemtime', $file_to_create ),SORT_NUMERIC,SORT_ASC,$file_to_create);
            foreach($file_to_create as $filename){
                $filename = substr($filename,10);
                $filename = str_replace('_', " ", $filename);
                $filename = str_replace('.xlsx', "", $filename);
                $filename = trim(substr($filename, strrpos($filename, '/') + 1));
                ?><option id="<?php echo htmlspecialchars($filename); ?>" value="<?php echo htmlspecialchars($filename); ?>"><?php echo $filename; ?></option><?php
            } ?>
    </select>
    
</div>
<?php

}       
?>