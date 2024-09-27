-- Final
UPDATE ns_3_posts SET guid = replace(guid, 'https://detailedvehiclehistory.com/vin-number','https://detailedvehiclehistory.com/vin-decoder') LIMIT 200000;

UPDATE ns_3_posts SET post_content = replace(post_content, 'https://detailedvehiclehistory.com/vin-number', 'https://detailedvehiclehistory.com/vin-decoder') LIMIT 200000;

UPDATE ns_3_postmeta 
SET meta_value = replace(meta_value, 'https://detailedvehiclehistory.com/vin-number', 'https://detailedvehiclehistory.com/vin-decoder') 
WHERE meta_id > 60000 
LIMIT 60000;







-- Note 
UPDATE ns_3_posts SET guid = replace(guid, 'https://detailedvehiclehistory.com/vin-number','https://detailedvehiclehistory.com/vin-decoder') LIMIT 200000;

UPDATE ns_3_posts SET post_content = replace(post_content, 'https://detailedvehiclehistory.com/vin-number', 'https://detailedvehiclehistory.com/vin-decoder') LIMIT 200000;



-- will gone away
UPDATE ns_3_postmeta SET meta_value = replace(meta_value,'https://detailedvehiclehistory.com/vin-number','https://detailedvehiclehistory.com/vin-decoder') LIMIT 120000;
-- so for postmeta use this 

-- UPDATE ns_3_postmeta 
-- SET meta_value = replace(meta_value, 'https://detailedvehiclehistory.com/vin-number','https://detailedvehiclehistory.com/vin-decoder') 
-- WHERE COLUMN-TO-CHECK > STARTER
-- LIMIT LIMITNUMBER;

UPDATE ns_3_postmeta 
SET meta_value = replace(meta_value, 'https://detailedvehiclehistory.com/vin-number', 'https://detailedvehiclehistory.com/vin-decoder') 
WHERE meta_id > 60000 
LIMIT 60000;


UPDATE ns_3_posts SET guid = replace(guid, 'https://www.detailedvehiclehistory.com/vin-number','https://detailedvehiclehistory.com/vin-decoder') LIMIT 120000;

UPDATE ns_3_posts SET post_content = replace(post_content, 'https://www.detailedvehiclehistory.com/vin-number', 'https://detailedvehiclehistory.com/vin-decoder') LIMIT 120000;

UPDATE ns_3_postmeta SET meta_value = replace(meta_value,'https://www.detailedvehiclehistory.com/vin-number','https://detailedvehiclehistory.com/vin-decoder') LIMIT 120000;





UPDATE ns_3_options SET option_value = replace(option_value, 'https://detailedvehiclehistory.com/vin-number', 'https://detailedvehiclehistory.com/vin-decoder') WHERE option_name = 'home' OR option_name = 'siteurl' LIMIT 120000;

UPDATE ns_3_options SET option_value = replace(option_value, 'https://www.detailedvehiclehistory.com/vin-number', 'https://detailedvehiclehistory.com/vin-decoder') WHERE option_name = 'home' OR option_name = 'siteurl' LIMIT 120000;





