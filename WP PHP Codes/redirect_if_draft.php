<?php
add_action('template_redirect', 'redirect_draft_pages');

function redirect_draft_pages() {
    if (is_404()) {
        global $wp;
        $requested_url = home_url(add_query_arg(array(),$wp->request));

        $page = get_page_by_path($wp->request);

        if ($page && $page->post_status === 'draft') {
            wp_redirect(home_url('/coming-soon'));
            exit();
        }
    }
}