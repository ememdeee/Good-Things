-- Note: 1. the table that need updated is both wp_posts[post_content] and wp_postmeta[elementor_data]
-- to check manual
SELECT * FROM `ns_3_posts` WHERE ID = 228768 
SELECT * FROM `ns_3_postmeta` WHERE post_id = 223480 AND meta_key = '_elementor_data'

-- from GPT
-- Replace regular URLs in ns_3_posts
UPDATE ns_3_posts 
SET post_content = REPLACE(post_content, 'https://detailedvehiclehistory.com/vin-number', 'https://detailedvehiclehistory.com/vin-decoder')
WHERE post_content LIKE '%https://detailedvehiclehistory.com/vin-number%';

-- Replace regular URLs in ns_3_postmeta
UPDATE ns_3_postmeta 
SET meta_value = REPLACE(meta_value, 'https://detailedvehiclehistory.com/vin-number', 'https://detailedvehiclehistory.com/vin-decoder')
WHERE meta_value LIKE '%https://detailedvehiclehistory.com/vin-number%';

-- Replace escaped URLs in ns_3_postmeta
UPDATE ns_3_postmeta 
SET meta_value = REPLACE(meta_value, 'https:\/\/detailedvehiclehistory.com\/vin-number', 'https:\/\/detailedvehiclehistory.com\/vin-decoder')
WHERE meta_value LIKE '%https:\/\/detailedvehiclehistory.com\/vin-number%';

-- Replace Unicode-encoded URLs in ns_3_postmeta
UPDATE ns_3_postmeta 
SET meta_value = REPLACE(meta_value, '\u0022https:\/\/detailedvehiclehistory.com\/vin-number\u0022', '\u0022https:\/\/detailedvehiclehistory.com\/vin-decoder\u0022')
WHERE meta_value LIKE '%\u0022https:\/\/detailedvehiclehistory.com\/vin-number\u0022%';

-- Replace HTML-encoded double quotes around URLs in ns_3_postmeta
UPDATE ns_3_postmeta 
SET meta_value = REPLACE(meta_value, '&quot;https:\/\/detailedvehiclehistory.com\/vin-number&quot;', '&quot;https:\/\/detailedvehiclehistory.com\/vin-decoder&quot;')
WHERE meta_value LIKE '%&quot;https:\/\/detailedvehiclehistory.com\/vin-number&quot;%';


-- To 1 page only
-- Replace regular URLs in ns_3_posts for page ID 223363
UPDATE ns_3_posts 
SET post_content = REPLACE(post_content, 'https://detailedvehiclehistory.com/vin-number', 'https://detailedvehiclehistory.com/vin-decoder')
WHERE post_content LIKE '%https://detailedvehiclehistory.com/vin-number%'
AND ID = 223363;

-- Replace regular URLs in ns_3_postmeta for page ID 223363
UPDATE ns_3_postmeta 
SET meta_value = REPLACE(meta_value, 'https://detailedvehiclehistory.com/vin-number', 'https://detailedvehiclehistory.com/vin-decoder')
WHERE meta_value LIKE '%https://detailedvehiclehistory.com/vin-number%'
AND post_id = 223363;

-- Replace escaped URLs in ns_3_postmeta for page ID 223363
UPDATE ns_3_postmeta 
SET meta_value = REPLACE(meta_value, 'https:\/\/detailedvehiclehistory.com\/vin-number', 'https:\/\/detailedvehiclehistory.com\/vin-decoder')
WHERE meta_value LIKE '%https:\/\/detailedvehiclehistory.com\/vin-number%'
AND post_id = 223363;

-- Replace Unicode-encoded URLs in ns_3_postmeta for page ID 223363
UPDATE ns_3_postmeta 
SET meta_value = REPLACE(meta_value, '\u0022https:\/\/detailedvehiclehistory.com\/vin-number\u0022', '\u0022https:\/\/detailedvehiclehistory.com\/vin-decoder\u0022')
WHERE meta_value LIKE '%\u0022https:\/\/detailedvehiclehistory.com\/vin-number\u0022%'
AND post_id = 223363;

-- Replace HTML-encoded double quotes around URLs in ns_3_postmeta for page ID 223363
UPDATE ns_3_postmeta 
SET meta_value = REPLACE(meta_value, '&quot;https:\/\/detailedvehiclehistory.com\/vin-number&quot;', '&quot;https:\/\/detailedvehiclehistory.com\/vin-decoder&quot;')
WHERE meta_value LIKE '%&quot;https:\/\/detailedvehiclehistory.com\/vin-number&quot;%'
AND post_id = 223363;



-- Final with ahsan
UPDATE ns_3_posts SET guid = replace(guid, 'https://detailedvehiclehistory.com/vin-number','https://detailedvehiclehistory.com/vin-decoder') LIMIT 200000;

UPDATE ns_3_posts SET post_content = replace(post_content, 'https://detailedvehiclehistory.com/vin-number', 'https://detailedvehiclehistory.com/vin-decoder') LIMIT 200000;

UPDATE ns_3_postmeta 
SET meta_value = replace(meta_value, 'https://detailedvehiclehistory.com/vin-number', 'https://detailedvehiclehistory.com/vin-decoder') 
WHERE meta_id > 60000 
LIMIT 60000;


UPDATE ns_3_postmeta 
SET meta_value = replace(meta_value, '\u0022https:\/\/detailedvehiclehistory.com\/vin-number\u0022', '\u0022https:\/\/detailedvehiclehistory.com\/vin-decoder\u0022') 
WHERE post_id = 223363



SELECT meta_value
FROM ns_3_postmeta
WHERE post_id = 223363
AND meta_value LIKE 'https:\/\/detailedvehiclehistory.com\/vin-number\';



-- 223368




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





