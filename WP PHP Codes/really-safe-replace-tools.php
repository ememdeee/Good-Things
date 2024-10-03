<?php
require_once('/var/www/wp/wp-load.php');
global $wpdb;

$old_url_posts = '/vin-decoder/Lexus/';
$new_url_posts = '/vin-decoder/lexus';
$old_url_postmeta = '\/vin-decoder\/Lexus\/';  // Escaped version
$new_url_postmeta = '\/vin-decoder\/lexus';  // Escaped version

// Specify the post IDs to update
$post_ids = array(112754,3738,140867,224661,223218,131413,140876,224711,135372,223307,135384,223138,223334,223212,223488,223129,140864,135366,42856,223137,223143,223309,223407,224611,140865,140866,42812,224608,223403,151322,99186,101757,43326,223367,224662,131369,140821,218791,44478,223316,47532,44647,224555,223206,223149,140830,223199,140822,151142,223185,223363,224674,150478,131473,223201,42873,151206,140870,93197,223189,223194,218541,84859,223158,223117,105419,140825,223358,151390,144232,140873,220265,224615,151336,44631,223173,140831,224603,93237,223401,223317,101420,105592,224614,223489,140815,150995,99431,42890,43136,223365,135361,223176,136508,223204,133104,86246,140827,223329,43102,223340,223469,43014,224602,224610,224595,223220,224677,43108,223355,97253,223310,151137,223146,43052,43154,135382,23914,223145,219684,224673,223184,224612,149130,224613,207018,108728,223349,223482,131350,223219,222082,223169,217060,224671,223221,131448,223154,223373,150985,223213,223487,224607,86266,223312,223156,223491,140828,99399,43008,223339,23847,223356,223186,140869,42867,223400,224609,140820,223364,140874,224605,151264,224687,223376,224509,3669,223326,135370,223341,223354,42922,158873,149555,223142,43083,223177,149873,223308,43123,223322,140879,140858,161387,223324,223493,223190,140878,43310,223214,223375,223150,42929,134550,223315,223178,223136,223153,223160,23650,225981,223323,43114,223130,223484,223336,135378,223198,135374,223325,223366,151216,140856,223405,105474,223147,101803,223165,223174,223362,223368,223331,223148,223379,224507,140823,223208,223139,223192,151393,27148,225072,223179,223305,223335,223345,223166,151407,43065,223196,223205,140812,223217,224606,219695,140857,135376,223209,223195,96548,217269,223133,223377,141216,223353,223183,223359,43071,135380,224508,224676,223485,128005,224604,223337,168424,140872,43148,46268,140824,223494,223495,223168,223357,223378,151215,223167,225013,225029,150991,223132,223131,223180,223330,140832,223203,223327,151139,223172,223141,140861,218826,140826,223215,223200,135368,223163,43026,141217,223360,223171,3814,140877,223490,140819,227983,223155,223483,223164,223342,223372,140926,223374,223188,223352,139734,151212,225044,223152,151213,223187,223313,223347,140868,223369,223170,223344,151144,223404,223311,223175,223319,223333,151138,225979,223202,223492,223157,96208,223161,224675,223332,223408,223371,223318,223216,151025,151136,223370,223207,223338,223211,223134,223193,151088,223361,99995,223181,225880,223159,225067,223125,227622,223321,223380,3908,223314,223210,223197,223320,223128,223191,223350,224672,223162,224663,223151,223127,223140,224541,223351,95969,46658,151259,223182,223306,151262,223486,223126,223402,223144,223346,151268,97806,223135);
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