<?php
// Add Schema.org JSON-LD to the header
function add_schema_org_json_ld() {
    
    // // // this is for BreaCrum // // //
    // Get the current URL
    $currentURL = $_SERVER['REQUEST_URI'];

    // Remove leading slash
    $currentURL = ltrim($currentURL, '/');
    
    // Explode the URL by '/'
    $urlParts = explode('/', $currentURL);
    
    // Remove empty elements
    $urlParts = array_filter($urlParts);
    // Adding empty data at the beginning
    array_unshift($urlParts, "");
    
    // echo "current url: ";
    // print_r($urlParts);
    
    // echo "|||";
    $position = 1;
    $url = $domain = "https://detailedvehiclehistory.com";
    // Define the breadcrumbs
    $breadcrumbs = array();

    // custom_1 breadcrumb for dvh/country/vin-check
    $custom_1 = ["georgia", "uganda", "south-africa", "jamaica", "ghana", "united-arab-emirates", "oman", "sweden", "qatar", "saudi-arabia", "austria", "luxembourg", "germany", "switzerland", "belgium", "lebanon", "albania", "france", "nigeria", "italy", "russia", "bahrain", "taiwan", "ireland", "brazil", "mexico", "ukraine", "dominican-republic", "costa-rica", "bulgaria", "finland", "uk", "mauritius", "portugal", "kenya", "croatia", "romania", "iraq", "israel", "cambodia", "new-zealand", "puerto-rico", "belarus", "greece", "moldova", "spain", "jordan", "el-salvador", "lithuania", "estonia", "nicaragua", "honduras", "argentina", "bahamas", "senegal", "azerbaijan", "colombia", "yemen", "chile", "sudan", "poland", "armenia", "kazakhstan", "bolivia"];

    for ($i = 0; $i < count($urlParts); $i++) {
      if ($position !== 1) {

        // custom breadcrumb for custom_1
        if (in_array($urlParts[1], $custom_1) && $urlParts[2] == "vin-check") {
          echo "MMDaaa";
          if ($position == 2){
            $name = "Vin Check";
            $url = $url . "/" . "vin-check";
          }elseif ($position == 3){
            $name = str_replace('-', ' ', $urlParts[1]);
            $name = ucwords($name); // Capitalize each word
            $url = $domain . "/" . $currentURL;
          }
        }
        else{
          $name = str_replace('-', ' ', $urlParts[$i]);
          $name = ucwords($name); // Capitalize each word
          $url = $url . "/" . $urlParts[$i];
        }
      } else {
        $name = "Detailed Vehicle History (DVH)";
      }
      // echo "Position: " . $position . "\n";
      // echo $url . "\n";
      // echo $name . "\n";
      // echo $urlParts[$i] . "\n";
      $breadcrumbs[] = array(
        "@type" => "ListItem",
        "item" => array(
          "@id" => $url,
          "name" => $name
        ),
        "position" => $position
      );
      $position++;
    }

    // // // this is for Article // // //
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    
    $latest_articles = new WP_Query( $args );
    // Output the schema.org markup for each article
    if ( $latest_articles->have_posts() ) :
        while ( $latest_articles->have_posts() ) : $latest_articles->the_post();
            ?>
            <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "Article",
                "publisher": {
                    "@type": "Organization",
                    "name": "<?php echo get_bloginfo( 'name' ); ?>",
                    "logo": {
                        "@type": "ImageObject",
                        "url": "<?php echo get_theme_mod( 'custom_logo' ); ?>",
                        "width": "136",
                        "height": "70"
                    }
                },
                "mainEntityOfPage": {
                    "@type": "WebPage",
                    "@id": "<?php the_permalink(); ?>"
                },
                "headline": "<?php the_title(); ?>",
                "alternativeHeadline": "<?php the_title(); ?>",
                "url": "<?php the_permalink(); ?>",
                "datePublished": "<?php echo get_the_date( 'c' ); ?>",
                "image": {
                    "@type": "ImageObject",
                    "url": "<?php echo get_the_post_thumbnail_url(); ?>",
                    "width": "800",
                    "height": "600"
                },
                "author": {
                    "@type": "Person",
                    "name": "<?php echo get_the_author(); ?>",
                    "url": "<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"
                }
            }
            </script>
            <?php
        endwhile;
        wp_reset_postdata();
    endif;
?>
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "WebSite",
  "name": "Detailed Vehicle History (DVH)",
  "url": "https://detailedvehiclehistory.com/",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://detailedvehiclehistory.com/?s={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Organization",
  "url": [
    "https://detailedvehiclehistory.com/vin-decoder",
    "https://detailedvehiclehistory.com/classic-vin-decoder",
    "https://detailedvehiclehistory.com/vin-check",
    "https://detailedvehiclehistory.com/classic-vehicle-history",
    "https://detailedvehiclehistory.com/license-plate-lookup",
    "https://detailedvehiclehistory.com/window-sticker",
    "https://detailedvehiclehistory.com/classic-window-stickers",
    "https://detailedvehiclehistory.com/sample",
    "https://detailedvehiclehistory.com/vin-check-rates",
    "https://detailedvehiclehistory.com/dealers",
    "https://detailedvehiclehistory.com/blog",
    "https://detailedvehiclehistory.com/faq"
  ],
  "sameAs": [
    "https://www.facebook.com/DetailedVehicleHistory",
    "https://twitter.com/DetailedVehicle",
    "https://www.linkedin.com/company/search-detailed-vehicle-history/",
    "https://www.instagram.com/detailedvehiclehistory/",
    "https://www.youtube.com/channel/UCBVm1Oh-dC9Y_yoWh9B1Fow"
  ],
  "potentialAction": {
    "@type": "SearchAction",
    "query-input": "required name=search_term_string",
    "target": {
      "@type": "EntryPoint",
      "urlTemplate": "https://detailedvehiclehistory.com/?s={search_term_string}"
    }
  }
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org/",
    "@type": "BreadcrumbList",
    "itemListElement": <?php echo json_encode($breadcrumbs, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
}
</script>
<?php
}
add_action('wp_head', 'add_schema_org_json_ld');
?>