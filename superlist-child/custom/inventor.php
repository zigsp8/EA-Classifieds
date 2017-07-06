<?php
/* inventor & listing custom programing. */

add_action('inventor_listing_content', 'reach_listing_archive_extra', 10, 2);
function reach_listing_archive_extra( $listing_id, $display = null) {
   if ( $display == 'row' ) {
    $jobtype = get_post_meta( $listing_id, 'listing_parttime', true );
    if ($jobtype) {
        echo "<dt></dt><dd>".$jobtype."</dd>";
    }
    $company= get_post_meta( $listing_id, 'listing_company', true );
    if ($company) {
        echo "<dt></dt><dd>".$company."</dd>";
    }
  }
}

add_filter( 'inventor_filter_sort_by_choices', function( $choices ) {
    if( array_key_exists( 'price', $choices ) ) {
        unset( $choices['price'] );
    }
    return $choices;
}, 11 );

// use a different default image (based on listing type)
add_filter ('inventor_listing_featured_image', 'ea_class_defimg', 10, 2);
function ea_class_defimg($str_imgurl, $int_listingID) {
  $pos = strpos($str_imgurl,'/wp-content/plugins/inventor/assets/img/default-item.png' );
  if ($pos !== false) {
    $posttype = get_post_type($int_listingID);
    $str_imgurl = reach_get_post_type_image($post_type);
  }
 return $str_imgurl;
}

// put featured image at bottom of listing
//add_action('inventor_after_listing_detail', 'reach_listing_thumb', 10, 1); - calling directly now.
function reach_listing_thumb( $int_listing_id) {
  if ( has_post_thumbnail($int_listing_id) ) {
    //echo '<div class="listing-detail-section" id="listing-detail-section-thumb">';
    echo '<div class="listing-detail-thumb">';
    $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($int_listing_id), 'large' );
    echo '<a href="'.esc_url($large_image_url[0]).'">' ;
    echo get_the_post_thumbnail($int_listing_id, 'medium', ['class' => 'alignleft', 'title' => 'Featured image']);
    echo '</a>';
    echo '</div>';
    //echo '</div>';
  }

}
// add real estate agent (author) to bottom of display listing
//add_action('inventor_after_listing_detail', 'reach_listing_author', 10, 1);
function reach_listing_author ($int_listing_id) {

   if (get_post_type($int_listing_id) == 'realestate')  {
      if (get_post_meta($int_listing_id, INVENTOR_LISTING_PREFIX.'show_author_info', true) == 'on') {
        //echo "Post id: ".$int_listing_id."<br>";
        $authorID = get_the_author_meta( 'ID' );
        $user_stuff = get_user_meta($authorID);
        //echo "user ID:  ".$authorID."<br>";
        //echo "<pre>"; var_dump($user_stuff); echo "</pre>";
        echo '<div class="author">';
          echo '<div class="row">';
            echo '<div class="col-md-3">';
            if ($user_stuff["user_general_image"]  || $user_stuff["nickname"] ) {
              if ($user_stuff["user_general_image"]) {
                 echo '<div class="mug">';
                    echo '<img src="'.$user_stuff["user_general_image"][0].'" class="listing-author-image" >';
                  echo '</div><!-- end mug -->';
              }
              if ($user_stuff["nickname"] ) {
                echo '<div class="listing-author-name">';
                  echo $user_stuff["nickname"][0] ;
                echo '</div><!-- end name -->';
              }

              echo "</div><!-- end col3 -->";
              echo '<div class="col-md-8">';
          }
          if ($user_stuff["description"]) {
            echo '<div class="listing-author-bio">';
              echo $user_stuff["description"][0] ;
            echo '</div><!-- end desc -->';
          }
            echo '</div><!-- end col8 for bio -->';
          echo '</div><!-- end author "row" -->';
        echo '</div><!-- end author-->';
        /* if ( class_exists( 'Inventor_Template_Loader' ) ) {
    			echo Inventor_Template_Loader::load( 'widgets/listing-author' );
    		} */

    } // show autho is on

  } // post type real estate
}

// disable street view
add_filter( 'inventor_metabox_field_enabled', 'disable_gmap_views', 10, 4 );
function disable_gmap_views( $enabled, $metabox_id, $field_id, $post_type ) {
    if ( ( 'listing_street_view' == $field_id ) || ('listing_inside_view' == $field_id) ) {
        return false;
    }

    return $enabled;
}

function reach_get_post_type_image($str_post_type) {
  $str_imgurl = "";
  switch ($str_post_type) {
      case "helpwanted":
           $str_imgurl = esc_attr(get_stylesheet_directory_uri() ) . '/images/'.'default-image-jobs.jpg';
        break;
      case "classifieds":
        $str_imgurl = esc_attr(get_stylesheet_directory_uri() ) . '/images/'.'default-listing.png';
        break;
      case "rentals":
        $str_imgurl = esc_attr(get_stylesheet_directory_uri() ) . '/images/'.'ea_square_rentals.jpg';
        break;
      case "realestate":
        $str_imgurl = esc_attr(get_stylesheet_directory_uri() ) . '/images/'.'ea_square_realestate.png';
        break;
      case "local":
        /* $str_imgurl = esc_attr(get_stylesheet_directory_uri() ) . '/images/'.'default-listing.png';
        break; */
      default:
        $str_imgurl = esc_attr(get_stylesheet_directory_uri() ) . '/images/'.'default-listing.png';
        break;
    } // end switch
    return $str_imgurl;
}

// swtich order of details & description.  by removing them & then puthsing them back onto the beginning of the array
add_filter( 'inventor_listing_detail_sections', 'reach_list_details', 10, 2);
function reach_list_details($sections, $post_type) {
  //echo "<pre>"; var_dump($sections); echo "</pre>";
  unset($sections['overview']);
  unset($sections['gallery']);
  $sections = array('gallery' => "Gallery", 'overview'=> "Details", ) + $sections;
  //echo "<pre>"; var_dump($sections); echo "</pre>";
  return $sections;
}
