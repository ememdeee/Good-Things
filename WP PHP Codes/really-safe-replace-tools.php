<?php
require_once('/var/www/wp/wp-load.php');
global $wpdb;

$old_url_posts = '/vin-decoder/hyundai/';
$new_url_posts = '/vin-decoder/hyundai';
$old_url_postmeta = '\/vin-decoder\/hyundai\/';  // Escaped version
$new_url_postmeta = '\/vin-decoder\/hyundai';  // Escaped version

// Specify the post IDs to update
$post_ids = array(225030,112754,3738,224628,223435,223127,140867,224661,218660,223297,223408,223448,223387,223290,223454,131413,140876,224711,135372,223148,223257,225043,223105,222997,224533,224648,223504,224989,223307,223277,135384,223138,105088,223334,224635,223035,224505,223150,223473,223262,223129,140864,135366,221234,42856,224958,223310,224955,223137,223145,223507,223432,223034,223143,223309,223407,223414,222938,224945,223053,222911,140865,223265,223240,224996,222999,223028,224631,134796,224663,223255,140866,224608,225001,223293,222961,222992,223394,224717,223482,223260,223152,223009,224646,223456,223402,223083,222990,112803,221231,223403,223439,151322,223383,99186,101757,43326,223478,222976,224494,224502,223014,224662,224499,224498,224636,131369,223502,140821,44478,224943,224714,223316,223404,223471,224596,44647,223102,223318,225892,223329,223012,224555,223335,224554,223149,140830,223294,224490,223270,222951,222889,223450,223391,224708,223287,223289,223455,223141,224597,224951,140822,224954,223298,151142,223276,223312,223441,224944,82207,223465,224674,223259,227983,223268,223142,224493,223500,223067,223010,150478,222935,224487,224510,223063,223068,223438,131473,223388,224599,223512,223285,151206,223311,223295,224643,222969,226060,223336,224972,222996,140870,224963,223086,223399,93197,222966,223264,224953,218541,84859,223117,105419,224967,223390,140825,223282,225027,224503,151390,223131,223344,144232,140873,220265,224971,223021,223106,222998,223109,223445,151336,223008,223427,224538,223284,224518,44631,105088,224718,223273,224724,223395,224957,223331,223434,223026,224673,223385,224537,221239,140831,224947,224504,223271,224528,224603,223272,223325,223411,93237,225088,224647,223401,223317,223125,223314,101420,105592,223089,222943,224633,223225,223467,223134,224713,206913,224960,224650,222937,221241,223278,223275,222974,223084,225833,224986,140815,223269,224973,223097,224644,223007,223300,223415,223446,223071,223505,224966,223015,224687,223326,223054,223513,223077,224723,223475,217674,150995,223291,223003,99431,222995,223389,46226,224981,135361,136508,223386,223135,223421,224995,223056,222988,224998,133104,86246,140827,225083,223419,223384,225979,224638,223340,222934,82120,223337,224491,223469,221235,223425,223266,224602,222895,223144,224529,223133,223476,224601,224515,224677,221249,223433,224676,221236,223263,223059,97253,223107,222959,224524,223147,224645,222082,224519,151137,223146,221230,223251,223237,223124,135382,23914,224520,149773,223249,223302,219684,223281,223451,224556,223036,224612,223303,224991,149130,224535,223436,222902,207018,108728,224500,224495,223120,131350,224620,225002,224965,223437,217060,224671,131448,224952,224670,223065,223111,223154,150985,223128,223506,222968,223017,223004,223115,223498,223261,224506,206985,224949,223458,223139,224607,86266,223156,223025,225067,223491,140828,99399,224946,223428,223339,223405,223050,222994,23847,223514,224497,140869,221244,223002,223305,224530,224962,223416,222984,223400,223245,224977,221245,224974,223481,223511,224632,140820,223080,223443,223333,222907,223338,223011,224627,140874,3673,222890,223426,222903,223049,223132,223096,151264,223241,221240,224509,3669,219695,108565,224999,223153,224517,135370,223396,223236,223079,224721,223341,223417,223393,223288,223024,223470,224629,223420,223073,223224,114035,224969,158873,223480,228002,149555,223013,224531,224639,224956,222989,223103,224523,225057,223090,221250,224640,149873,223308,225981,224975,223082,223413,223418,223322,224682,225004,225029,140879,140858,161387,223324,226068,223381,224496,140878,223422,223347,43310,223382,223031,223037,223459,223315,223346,134550,223474,223136,223447,223087,223092,224637,224948,223032,223286,224525,223397,223242,222910,23650,223449,223033,223006,221903,223247,127949,223075,223323,223098,222940,223130,223122,224630,223108,223029,223468,223409,223460,223239,135378,223114,225984,135374,223222,223121,222891,221232,223424,223392,224959,222972,151216,224970,221243,140856,223453,105474,224614,224968,101803,226077,223509,223440,224675,223062,223226,221435,222912,224987,224613,223479,224726,223254,223232,224985,224507,222987,140823,224600,225003,223283,224980,224978,224634,224961,223027,223094,223301,221237,223299,222955,151393,223319,223235,223461,222900,27148,225072,223292,226064,223296,223267,223256,223279,223345,223431,151407,223038,224536,223477,223501,222909,223157,224501,223030,140812,222923,221248,223423,223023,224988,223234,223022,223229,140857,223472,135376,224716,224964,223320,224641,96548,222893,224979,224611,217269,224950,222991,220068,223074,141216,224725,223444,223020,222993,223258,223332,225044,126636,223503,224513,223466,135380,224508,222908,223349,224649,223244,225062,223452,86656,223430,223001,223342,223118,223429,128005,224604,223243,168424,140872,223280,223140,223406,82209,224534,46268,140824,223462,223253,223250,151215,223045,224492,224605,223047,225013,223112,224511,222905,226079,222904,223274,223093,149846,223508,149813,222901,150991,225000,149860,223046,223099,223018,223463,223313,223330,223072,140832,223327,223442,223069,223113,151139,224715,224526,140861,140826,223052,224539,111968,223155,135368,224512,223081,141217,223304,222897,223078,224976,3814,224990,140877,223005,223126,140819,223104,224993,223016,140926,224516,207972,139734,151212,223151,223101,223252,224719,223057,223088,222899,151213,226073,224540,223119,223070,223100,222949,223000,140868,224514,222945,224642,224712,217638,223042,224527,222898,151144,223231,167259,223410,223123,222947,223048,223041,151138,224615,223095,223158,224532,223321,224992,223091,223398,222896,223019,96208,222941,223230,224606,223085,223051,221233,221242,151025,223238,224521,224522,151136,223058,110780,222963,222894,223039,222913,222906,158269,223076,151088,99995,226075,223246,225078,223457,221247,222915,222985,225880,224610,223227,223061,224598,223499,223464,223066,224722,224672,223043,223116,227622,223248,223306,224720,224609,3908,221246,222892,223412,224660,223055,223110,223228,145194,224541,225056,223233,224994,95969,46658,223044,223040,223064,151262,223060,151268,97806,222914,227992);
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
        $updated_meta_value = str_replace('\"' . 'https:\/\/detailedvehiclehistory.com' . $old_url_postmeta . '\"', '\"' . 'https:\/\/detailedvehiclehistory.com' . $new_url_postmeta . '\"', $updated_meta_value);  // Full URLs with domain in plain html
        
        $updated_meta_value = json_decode($updated_meta_value, true);
    } else {
        // Replace the old URL with the new URL in the plain string
        $updated_meta_value = str_replace('"' . $old_url_postmeta . '"', '"' . $new_url_postmeta . '"', $meta_value);  // Relative URLs
        $updated_meta_value = str_replace('"' . 'https:\/\/detailedvehiclehistory.com' . $old_url_postmeta . '"', '"' . 'https:\/\/detailedvehiclehistory.com' . $new_url_postmeta . '"', $updated_meta_value);  // Full URLs with domain
        $updated_meta_value = str_replace('\u0022' . $old_url_postmeta . '\u0022', '\u0022' . $new_url_postmeta . '\u0022', $updated_meta_value);  // Relative URLs in text
        $updated_meta_value = str_replace('\u0022' . 'https:\/\/detailedvehiclehistory.com' . $old_url_postmeta . '\u0022', '\u0022' . 'https:\/\/detailedvehiclehistory.com' . $new_url_postmeta . '\u0022', $updated_meta_value);  // Full URLs with domain in text
        $updated_meta_value = str_replace('\"' . $old_url_postmeta . '\"', '\"' . $new_url_postmeta . '\"', $updated_meta_value);  // Relative URLs in plain html
        $updated_meta_value = str_replace('\"' . 'https:\/\/detailedvehiclehistory.com' . $old_url_postmeta . '\"', '\"' . 'https:\/\/detailedvehiclehistory.com' . $new_url_postmeta . '\"', $updated_meta_value);  // Full URLs with domain in plain html
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