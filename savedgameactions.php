<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//check_ajax_referer( 'wpgamelist-jre-ajax-nonce-savedgame', 'security' );

function wpgamelist_jre_savedgameactions($saved_game, $img_path, $options_results){
    
    $name = filter_var($saved_game->name, FILTER_SANITIZE_STRING);
    $amazonaff = filter_var($options_results->amazonaff, FILTER_SANITIZE_STRING);
    $path = $img_path;
    $hidefacebook = filter_var($options_results->hidefacebook, FILTER_SANITIZE_NUMBER_INT);
    $hidescreenshots = filter_var($options_results->hidescreenshots, FILTER_SANITIZE_NUMBER_INT);
    $hidevids = filter_var($options_results->hidevids, FILTER_SANITIZE_NUMBER_INT);
    $hidetwitter = filter_var($options_results->hidetwitter, FILTER_SANITIZE_NUMBER_INT);
    $hidegoogleplus = filter_var($options_results->hidegoogleplus, FILTER_SANITIZE_NUMBER_INT);
    $hidemessenger = filter_var($options_results->hidemessenger, FILTER_SANITIZE_NUMBER_INT);
    $hidepinterest = filter_var($options_results->hidepinterest, FILTER_SANITIZE_NUMBER_INT);
    $hideemail = filter_var($options_results->hideemail, FILTER_SANITIZE_NUMBER_INT);
    $hideamazonreview = filter_var($options_results->hideamazonreview, FILTER_SANITIZE_NUMBER_INT);
    $hidedescription = filter_var($options_results->hidedescription, FILTER_SANITIZE_NUMBER_INT);
    $hidenotes = filter_var($options_results->hidenotes, FILTER_SANITIZE_NUMBER_INT);
    $hidebottompurchase = filter_var($options_results->hidebottompurchase, FILTER_SANITIZE_NUMBER_INT);
    $hideratingbackend = filter_var($options_results->hidereviewgame, FILTER_SANITIZE_NUMBER_INT);
    $storyline = filter_var($saved_game->storyline, FILTER_SANITIZE_URL);  
    $igdburl = filter_var($saved_game->igdburl, FILTER_SANITIZE_URL);  
    $coverimage = filter_var($saved_game->cover, FILTER_SANITIZE_URL);  
    $summary = filter_var($saved_game->summary, FILTER_SANITIZE_STRING); 
    $platforms = filter_var($saved_game->platform, FILTER_SANITIZE_STRING);  
    $vids = filter_var($saved_game->vids, FILTER_SANITIZE_STRING);
    $screenshots = filter_var($saved_game->screenshots, FILTER_SANITIZE_STRING);
    $publisher = filter_var($saved_game->publisher, FILTER_SANITIZE_STRING); 
    $genre = filter_var($saved_game->genre, FILTER_SANITIZE_STRING); 
    $developer = filter_var($saved_game->developer, FILTER_SANITIZE_STRING); 
    $release = filter_var($saved_game->releasedate, FILTER_SANITIZE_STRING);
    $finished = filter_var($saved_game->finished, FILTER_SANITIZE_STRING);  
    $yearfinished = filter_var($saved_game->yearfinished, FILTER_SANITIZE_NUMBER_INT);
    $notes = filter_var($saved_game->notes, FILTER_SANITIZE_STRING); 
    $rating = filter_var($saved_game->rating, FILTER_SANITIZE_NUMBER_INT);
    $tempname = str_replace(' ', '+', $name);
    $tempname = str_replace('\'', '+', $tempname);
    $tempname = str_replace(':', '', $tempname);
    $gamestopurl = 'http://www.gamestop.com/browse?nav=16k-3-'.$tempname;
    $amazonurl = 'https://www.amazon.com/s/ref=nb_sb_noss?url=search-alias%3Dvideogames&tag=wpbooklistid-20&field-keywords='.$tempname;
    $bestbuyurl = 'http://www.bestbuy.com/site/searchpage.jsp?st='.$tempname.'&_dyncharset=UTF-8&id=pcat17071&type=page&sc=Global&cp=1&nrp=&sp=&qp=&list=n&af=true&iht=y&usc=All+Categories&ks=960&keys=keys';
    $steamurl = 'http://store.steampowered.com/search/?snr=1_7_7_151_12&term='.$tempname;
    $ebayurl = 'http://www.ebay.com/sch/Video-Games-Consoles/1249/i.html?_from=R40&_nkw='.$tempname;
    $vids = rtrim($vids, ',');
    $vids = explode(',', $vids);
    $screenshots = rtrim($screenshots, ',');
    $screenshots = explode(',', $screenshots);

    //var_dump($saved_game);

    $postdata = http_build_query(
        array(
            'associate_tag' => 'wpbooklistid-20',
            'title' => $name
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
        // Begin Amazon Data Grab Use file_get_contents if we can
      if (ini_get("allow_url_fopen") == 1) {
        $result = file_get_contents('https://jakerevans.com/awsapiconfiggames.php', false, $context);
        $xml = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);
        $json = json_encode($xml);
        $amazon_array = json_decode($json,TRUE);
      } else {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $url = 'https://jakerevans.com/awsapiconfiggames.php';
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = array('title' => $name, 'associate_tag' => $options_results->amazonaff);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        curl_close($ch);
        $xml = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);
        $json = json_encode($xml);
        $amazon_array = json_decode($json,TRUE);
      }
      $link = $amazon_array['Items']['Item'][0]["DetailPageURL"];




    ?>
    <div id="wpgamelist_top_top_div">
    <div id="wpgamelist_top_display_container">
        <table>
            <tbody>
                <tr>
                    <td id="wpgamelist_image_saved_border">
                        <div id="wpgamelist_display_image_container"><?php
                            // Determine which image to use (if one was found in the API calls, or if we resort to default 'not avaliable' image)
                            if($coverimage == null){
                            ?><img id="wpgamelist_cover_image_popup" src="<?php echo $path.'image_unavaliable.png'; ?>" /> <?php
                            } else {
                                ?><img id="wpgamelist_cover_image_popup" src="<?php echo $coverimage?>" /> <?php
                            }?>
      
                            <input type="submit" id="wpgamelist_desc_button" value="Description, Notes & Reviews"></input>


                 <?php 
                 $description = $gamedescription;

            ?>
            <?php if( ($hideratingbackend == null) && ($gamerating != 0)){ ?>
            <p id="wpgamelist-share-text">My Rating</p>
            <div class="wpgamelist-line-7"></div>
            <?php if($gamerating == 5){
                    ?>
                    <img style="width: 50px;" src="<?php echo plugins_url('/assets/img/5star.png', __FILE__); ?>" />
                    <?php
                  }    
            ?>
            <?php if($gamerating == 4){
                    ?>
                    <img style="width: 50px;" src="<?php echo plugins_url('/assets/img/4star.png', __FILE__); ?>" />
                    <?php
                  }    
            ?>
            <?php if($gamerating == 3){
                    ?>
                    <img style="width: 50px;" src="<?php echo plugins_url('/assets/img/3star.png', __FILE__); ?>" />
                    <?php
                  }    
            ?>
            <?php if($gamerating == 2){
                    ?>
                    <img style="width: 50px;" src="<?php echo plugins_url('/assets/img/2star.png', __FILE__); ?>" />
                    <?php
                  }    
            ?>
            <?php if($gamerating == 1){
                    ?>
                    <img style="width: 50px;" src="<?php echo plugins_url('/assets/img/1star.png', __FILE__); ?>" />
                    <?php
                  }    
            ?>




            <?php
            } 
  
           if( 
            ($hidefacebook == null) ||
            ($hidetwitter == null) || 
            ($hidegoogleplus == null) ||
            ($hidemessenger == null) || 
            ($hidepinterest == null) || 
            ($hideemail == null)){ ?>
                <p id="wpgamelist-share-text">Share This game</p>
                <div class="wpgamelist-line-4"></div>
                <?php if($hidefacebook == null){ ?>
                <div class="addthis_sharing_toolbox addthis_default_style" style="cursor:pointer"><a style="cursor:pointer;" href="" addthis:title="<?php echo $name;?>" addthis:description="<?php echo $description;?>"addthis:url="" class="addthis_button_facebook"> </a></div> <?php } ?>
                  <?php if($hidetwitter == null){ ?>
                <div class="addthis_sharing_toolbox addthis_default_style"><a href="" addthis:title="<?php echo $name;?>" addthis:description="<?php echo $summary;?>"addthis:url="" class="addthis_button_twitter"> </a></div> <?php } ?>
                <?php if($hidegoogleplus == null){ ?>
        <div class="addthis_sharing_toolbox addthis_default_style"><a href="" addthis:title="<?php echo $name;?>" addthis:description="<?php echo $summary;?>"addthis:url="" class="addthis_button_google_plusone_share"> </a></div><?php } ?>
        <?php if($hidepinterest == null){ ?>
        <div class="addthis_sharing_toolbox addthis_default_style"><a href="" addthis:title="<?php echo $name;?>" addthis:description="<?php echo $summary;?>"addthis:url="" class="addthis_button_pinterest_share"> </a></div><?php } ?>
        <?php if($hidemessenger == null){ ?>
        <div class="addthis_sharing_toolbox addthis_default_style"><a href="" addthis:title="<?php echo $name;?>" addthis:description="<?php echo $summary;?>" addthis:url="" class="addthis_button_messenger"> </a></div><?php } ?>
        <?php if($hideemail == null){ ?>
        <div class="addthis_sharing_toolbox addthis_default_style"><a href="" addthis:title="<?php echo $name;?>" addthis:description="<?php echo $summary;?>" addthis:url="" class="addthis_button_gmail"> </a></div><?php } ?>


                <?php
            }
            ?>
            </div>
                        </div>
                    </td>
                  
                            </table>
                            
                        </div>
                    </td>
                </tr>
            </tbody>
            <a name="desc_scroll"></a>
        </table>
     
                        <div  id="wpgamelist_display_table">
                            <!-- Table to display game info on the right-hand side of UI, with controls for null/empty values-->
                            <table id="wpgamelist_display_table_2">
                                <tr>
                                    <td id="wpgamelist_title"><?php echo stripslashes(htmlspecialchars_decode($name)); ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <span id="wpgamelist_bold">Initial Release Date:</span> <?php echo $release; ?>
                                    </td>   
                                </tr>
                                <tr>
                                </tr>
                                <tr>
                                    <td><?php 
                                        if($genre == null){
                                            ?><span id="wpgamelist_bold"><?php echo'Genre: ' ?></span><?php echo 'Not Avaliable';
                                        } else {
                                            ?><span id="wpgamelist_bold"><?php echo'Genre: ' ?></span><?php echo $genre;
                                        } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php 
                                        if($platforms == null){
                                            ?><span id="wpgamelist_bold"><?php echo'Platform(s): ' ?></span><?php echo 'Not Avaliable';
                                        } else {
                                            ?><span id="wpgamelist_bold"><?php echo'Platform(s): ' ?></span><?php echo $platforms;  
                                        }?>
                                    </td>   
                                </tr>
                                <tr>
                                    <td><?php 
                                        if($developer == null){
                                            ?><span id="wpgamelist_bold"><?php echo'Developer: ' ?></span><?php echo 'Not Avaliable';
                                        } else {
                                            ?><span id="wpgamelist_bold"><?php echo'Developer: ' ?></span><?php echo $developer;   
                                        }?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php 
                                        if($publisher == null){
                                            ?><span id="wpgamelist_bold"><?php echo'Publisher:   ' ?></span><?php echo 'Not Avaliable';
                                        } else {
                                            ?><span id="wpgamelist_bold"><?php echo'Publisher:   ' ?></span><?php echo $publisher;   
                                        }?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php 
                                        if(($rating == null) || ($rating == 0)  ){
                                            ?><span id="wpgamelist_bold"><?php echo'Rating:   ' ?></span><?php echo 'Not Avaliable';
                                        } else {
                                            ?><span id="wpgamelist_bold"><?php echo'Rating:   ' ?></span><?php echo $rating;   
                                        }?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php   
                                        if(($finished == 'Yes') || ($finished == 'Yes')){
                                            if($yearfinished == 0){
                                                ?><span id="wpgamelist_bold"><?php echo'Finished?: ' ?></span><?php echo 'Yes';   
                                            } else {
                                                ?><span id="wpgamelist_bold"><?php echo'Finished? ' ?></span><?php echo 'Yes, in '.$yearfinished;   
                                            }
                                        } else {
                                            ?><span id="wpgamelist_bold"><?php echo'Finished? ' ?></span><?php echo 'Not Yet';  
                                            
                                        }?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php 
                                        if($igdburl == null){
                                            ?><span id="wpgamelist_bold"><?php echo'IGDB Url:   ' ?></span><?php echo 'Not Avaliable';
                                        } else {
                                            ?><span id="wpgamelist_bold"><?php echo'IGDB Url:   ' ?></span><?php echo '<a target="_blank" href="'.$igdburl.'">Click here</a>';   
                                        }?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="wpgamelist-line-2"></div></td>
                                </tr>
                                <tr>
                                    <td class="wpgamelist-purchase-title" colspan="2">Purchase This Game At:</td>
                                </tr>
                                <tr>
                                    <td><div class="wpgamelist-line"></div></td>
                                </tr>
                                <tr>
                                    <td> 
                                        <a class="wpgamelist-purchase-img" href="<?php echo $gamestopurl;?>" target="_blank"><img src="<?php echo $path.'gamestop.png'; ?>" /></a> 
                    <a class="wpgamelist-purchase-img" target="_blank" href="<?php echo $link;?>"><img src="<?php echo $path.'amazon.png'; ?>" /></a>
                    <a class="wpgamelist-purchase-img" target="_blank" href="<?php echo $bestbuyurl; ?>"><img src="<?php echo $path.'bestbuy.png'; ?>" /></a>
                    <a class="wpgamelist-purchase-img itunes-adjust" target="_blank" href="<?php echo $steamurl; ?>"><img src="<?php echo $path.'steam.png'; ?>" /></a>
                    <a class="wpgamelist-purchase-img itunes-adjust" target="_blank" href="<?php echo $ebayurl; ?>"><img src="<?php echo $path.'ebay.png'; ?>" /></a>
                    <a style="display:none;" href="http://www.ulrichmierendorff.com/"></a>
                                    </td>   
                                </tr>
    </table>
    </div>
         </div>         
                    <?php
                    ?>

        <div id="wpgamelist_desc_id">
            <?php if(($hideamazonreview == null) && ($customerreview != null)){ ?>
            <p style="margin-top:40px;" class="wpgamelist_description_p">Amazon Reviews:</p> 
            <p class="wpgamelist_desc_p_class"><iframe id="wpgamelist-review-iframe" src="<?php echo $customerreview; ?>"></iframe></p> <?php } ?>

    <?php
    if($hidedescription == null){ ?>
         <p class="wpgamelist_description_p">Summary</p> <?php
            if($summary == null){
                ?> <p class="wpgamelist_desc_p_class"> <?php echo 'Not Avaliable'; ?> </p> <?php
            } else {
                ?> <div class="wpgamelist_desc_p_class"> <?php echo htmlspecialchars_decode(stripslashes($summary)); ?></div> <?php
            } }?>

     <?php if($hidevids == null){ ?>
         <p style="margin-top:20px;" class="wpgamelist_description_p">Videos & Trailers</p> <?php
            if($vids == null){
                ?> <p class="wpgamelist_desc_p_class"> <?php echo 'None Avaliable'; ?> </p> <?php
            } else {
                ?> <p class="wpgamelist_desc_p_class"> <?php
                foreach($vids as $key=>$vid){ ?>  <?php echo '<iframe style="margin:10px;" src="https://www.youtube.com/embed/'.$vid.'" frameborder="0" allowfullscreen></iframe>';
                } ?>
                </p>
                <?php
            } 
        } ?> 

        <?php if($hidescreenshots == null){ ?>
         <p style="margin-top:20px;" class="wpgamelist_description_p">Screenshots</p> <?php
            if((sizeof($screenshots) <= 1) && ($screenshots[0] == '') || ($screenshots == null)){
                ?> <p class="wpgamelist_desc_p_class"> <?php echo 'None Avaliable'; ?> </p> <?php
            } else {
                ?> <div class="wpgamelist_desc_p_class wpgamelist_screenshots_div"><?php
                foreach($screenshots as $key=>$shot){ echo '<div class="wpgamelist-indiv-screenshot-div">'; ?> <?php  echo '<img class="wpgamelist-screenshots-class" src="https://images.igdb.com/igdb/image/upload/t_screenshot_huge/'.$screenshots[$key].'.jpg" /></div>'; } 
                    ?>
                </div>
                <?php
            } 
        } ?>       

     <?php if($hidenotes == null){ ?>
         <p style="margin-top:20px;" class="wpgamelist_description_p">Notes:</p> <?php
            if($notes == null){
                ?> <p class="wpgamelist_desc_p_class"> <?php echo 'None Provided'; ?> </p> <?php
            } else {
                ?> <p class="wpgamelist_desc_p_class"> <?php echo htmlspecialchars_decode(stripslashes($notes)); ?></p> <?php
            } 
        } ?> 
        <?php if ($hidebottompurchase != null){echo '<div style="display:none;" >';}?>
            <div class="wpgamelist-line-5"></div>
            <p class="wpgamelist-purchase-title">
                Purchase This game At:
            </p>
            <div class="wpgamelist-line-6"></div>
         <a class="wpgamelist-purchase-img" href="<?php echo $gamestopurl;?>" target="_blank"><img src="<?php echo $path.'gamestop.png'; ?>" /></a> 
                    <a class="wpgamelist-purchase-img" target="_blank" href="<?php echo $link;?>"><img src="<?php echo $path.'amazon.png'; ?>" /></a>
                    <a class="wpgamelist-purchase-img" target="_blank" href="<?php echo $bestbuyurl; ?>"><img src="<?php echo $path.'bestbuy.png'; ?>" /></a>
                    <a class="wpgamelist-purchase-img itunes-adjust" target="_blank" href="<?php echo $steamurl; ?>"><img src="<?php echo $path.'steam.png'; ?>" /></a>
                    <a class="wpgamelist-purchase-img itunes-adjust" target="_blank" href="<?php echo $ebayurl; ?>"><img src="<?php echo $path.'ebay.png'; ?>" /></a>
                    <a style="display:none;" href="http://www.ulrichmierendorff.com/"></a>
    <?php if ($hidebottompurchase == null){echo '</div>';}?>
    </div>
    <?php

}

?>