<?php
require_once('/var/www/wp/wp-load.php');
global $wpdb;

$old_url_posts = '/how-to-find-a-stolen-vehicle-using-detailed-vehicle-history';
$new_url_posts = '/blog/how-to-find-a-stolen-vehicle-using-detailed-vehicle-history';
$old_url_postmeta = '\/how-to-find-a-stolen-vehicle-using-detailed-vehicle-history';  // Escaped version
$new_url_postmeta = '\/blog\/how-to-find-a-stolen-vehicle-using-detailed-vehicle-history';  // Escaped version

// Specify the post IDs to update
$post_ids = array(222969,210063,140876,223333,223016,47011,223341,86246,223336,141216,135382,140878,42856,43008,223309,223305,207948,42812,223017,140857,223343,140831,43114,140823,43326,43083,218791,140819,140824,47532,140821,131448,43065,141217,140879,44631,210065,140873,140866,140815,131369,223013,151142,218541,140825,222994,46268,140874,131413,223032,222945,44647,140820,208002,218374,210081,42873,151206,140868,135376,207195,14300,223340,43108,135380,207210,140870,93197,140926,84859,223325,223117,222923,223319,86266,151390,220265,223331,131473,43052,222984,223304,223036,135374,223345,20328,222999,135372,140877,223328,101420,140832,206985,222976,207079,135378,210055,207092,43026,42890,135361,223008,43136,223315,207885,206913,43102,223469,222951,43014,135368,223323,223337,140865,97253,134550,224506,223342,223332,223324,44478,223347,43154,223330,135370,219684,222998,207018,43148,133104,210059,222082,207422,140827,140826,223037,223344,206961,223327,210079,222985,223491,210085,46742,140869,42867,140864,222963,222988,140861,223026,210061,140830,218854,210077,135366,42922,158873,140828,43123,223005,161387,222922,43310,223012,222938,222961,223023,42929,222934,223314,206970,225981,222959,223311,223025,222990,46434,223007,223018,151216,206805,207538,207650,140856,217796,223003,223312,223009,131350,222927,225072,140867,223348,20262,223310,223011,223030,96548,207732,222955,207478,223320,222937,223318,140812,222993,218750,223001,43071,140858,136508,222989,144232,223308,207047,222986,223316,210052,223019,151215,225013,225029,223321,210069,222996,210083,223021,222966,151139,222949,210057,218826,222968,135384,223313,223006,227983,207112,223015,207466,223326,224509,140872,207960,207059,223306,222987,225044,222972,223002,223029,222943,223339,210073,207689,222997,223031,151144,37485,99431,223035,151138,210075,225979,223022,223307,207936,223346,223335,139734,223408,210067,222995,223014,222992,223322,207451,222974,210071,223317,223010,99995,224507,223028,207000,225880,223027,210089,223033,223020,224508,225067,227622,3908,222991,223004,222935,207972,222941,223000,207913,223034,222940,223334,224541,223329,223024,95969,223338,151259,222947,207030,3738,101757,105419,105088,93237,105592,140822,44545,23914,149130,108728,99399,23847,3669,149555,149873,23650,105474,101803,27148,3814,46658);
$post_ids_placeholder = implode(',', array_fill(0, count($post_ids), '%d'));

// UPDATE POST
// Update post_content and guid in the ns_3_posts table
$old_url_posts_href_domain = 'href="https://detailedvehiclehistory.com' . $old_url_posts . '"';
$new_url_posts_href_domain = 'href="https://detailedvehiclehistory.com' . $new_url_posts . '"';
$old_url_posts_href_noDomain = 'href="' . $old_url_posts . '"';
$new_url_posts_href_noDomain = 'href="' . $new_url_posts . '"';

$wpdb->query($wpdb->prepare(
    "UPDATE ns_3_posts 
     SET post_content = REPLACE(post_content, %s, %s)
     WHERE ID IN ($post_ids_placeholder)",
    $old_url_posts_href_domain,
    $new_url_posts_href_domain,
    ...$post_ids
));

$wpdb->query($wpdb->prepare(
    "UPDATE ns_3_posts 
     SET guid = REPLACE(guid, %s, %s)
     WHERE ID IN ($post_ids_placeholder)",
    $old_url_posts_href_domain,
    $new_url_posts_href_domain,
    ...$post_ids
));

$wpdb->query($wpdb->prepare(
    "UPDATE ns_3_posts 
     SET post_content = REPLACE(post_content, %s, %s)
     WHERE ID IN ($post_ids_placeholder)",
    $old_url_posts_href_noDomain,
    $new_url_posts_href_noDomain,
    ...$post_ids
));

$wpdb->query($wpdb->prepare(
    "UPDATE ns_3_posts 
     SET guid = REPLACE(guid, %s, %s)
     WHERE ID IN ($post_ids_placeholder)",
    $old_url_posts_href_noDomain,
    $new_url_posts_href_noDomain,
    ...$post_ids
));

// UPDATE POSTMETA
$postmeta_table = $wpdb->prefix . 'postmeta';

// Query to select the data based on post IDs
$query = $wpdb->prepare(
    "SELECT meta_id, post_id, meta_value 
     FROM $postmeta_table 
     WHERE post_id IN ($post_ids_placeholder)", 
    ...$post_ids
);

$results = $wpdb->get_results($query);
$count = count($results);
print_r($count);
// die();

// Loop through each result and update the URLs
foreach ($results as $row) {
    // Unserialize the meta_value if it's serialized
    $meta_value = maybe_unserialize($row->meta_value);

    // If it's JSON (array or object), decode it, replace the URL, and encode it back
    if (is_array($meta_value) || is_object($meta_value)) {
        $meta_value = json_encode($meta_value);

        $updated_meta_value = str_replace('"' . $old_url_postmeta . '"', '"' . $new_url_postmeta . '"', $meta_value);  // Relative URLs
        $updated_meta_value = str_replace('"' . 'https:\/\/detailedvehiclehistory.com' . $old_url_postmeta . '"', '"' . 'https:\/\/detailedvehiclehistory.com' . $new_url_postmeta . '"', $updated_meta_value);  // Full URLs with domain
        $updated_meta_value = str_replace('\u0022' . $old_url_postmeta . '\u0022', '\u0022' . $new_url_postmeta . '\u0022', $updated_meta_value);  // Relative URLs in text
        $updated_meta_value = str_replace('\u0022' . 'https:\/\/detailedvehiclehistory.com' . $old_url_postmeta . '\u0022', '\u0022' . 'https:\/\/detailedvehiclehistory.com' . $new_url_postmeta . '\u0022', $updated_meta_value);  // Full URLs with domain in text
        $updated_meta_value = str_replace('\"' . $old_url_postmeta . '\"', '\"' . $new_url_postmeta . '\"', $updated_meta_value);  // Relative URLs in plain html
        $updated_meta_value = str_replace('\"https:\/\/detailedvehiclehistory.com' . $old_url_postmeta . '\"', '\"https:\/\/detailedvehiclehistory.com' . $new_url_postmeta . '\"', $updated_meta_value);  // Full URLs with domain in plain html
        
        $updated_meta_value = json_decode($updated_meta_value, true);
    } else {
        // Replace the old URL with the new URL in the plain string
        $updated_meta_value = str_replace('"' . $old_url_postmeta . '"', '"' . $new_url_postmeta . '"', $meta_value);  // Relative URLs
        $updated_meta_value = str_replace('"' . 'https:\/\/detailedvehiclehistory.com' . $old_url_postmeta . '"', '"' . 'https:\/\/detailedvehiclehistory.com' . $new_url_postmeta . '"', $updated_meta_value);  // Full URLs with domain
        $updated_meta_value = str_replace('\u0022' . $old_url_postmeta . '\u0022', '\u0022' . $new_url_postmeta . '\u0022', $updated_meta_value);  // Relative URLs in text
        $updated_meta_value = str_replace('\u0022' . 'https:\/\/detailedvehiclehistory.com' . $old_url_postmeta . '\u0022', '\u0022' . 'https:\/\/detailedvehiclehistory.com' . $new_url_postmeta . '\u0022', $updated_meta_value);  // Full URLs with domain in text
        $updated_meta_value = str_replace('\"' . $old_url_postmeta . '\"', '\"' . $new_url_postmeta . '\"', $updated_meta_value);  // Relative URLs in plain html
        $updated_meta_value = str_replace('\"https:\/\/detailedvehiclehistory.com' . $old_url_postmeta . '\"', '\"https:\/\/detailedvehiclehistory.com' . $new_url_postmeta . '\"', $updated_meta_value);  // Full URLs with domain in plain html
    }

    // Re-serialize and update the postmeta table
    $wpdb->update(
        $postmeta_table,
        array('meta_value' => maybe_serialize($updated_meta_value)),
        array('meta_id' => $row->meta_id)
    );
}

echo 'URLs updated successfully.';
?>
<!-- power  -->
<!-- capital is differed, good point -->
<!-- only effect exact url, very good point -->



<!-- loop gear  -->
<!-- $makes = array(
    "Audi", 
    "Hyundai", 
);

foreach ($makes as $make) {
    $old_url_posts = '/vin-decoder/' . $make . '/';
    $new_url_posts = '/vin-decoder/' . $make;
    $old_url_postmeta = '\/vin-decoder\/' . $make . '\/';  // Escaped version
    $new_url_postmeta = '\/vin-decoder\/' . $make;  // Escaped version

    other code
} -->