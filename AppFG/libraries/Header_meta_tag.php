<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Header_meta_tag
{
    private $_CI;

    function __construct()
    {
        $this->_CI = &get_instance();
        $this->_CI->load->model('Model_common');
    }

	public function index()
	{
		$class_name = '';
		$segment_2 = 0;
		$segment_3 = 0;
		$class_name = $this->_CI->router->fetch_class();
		$segment_2 = $this->_CI->uri->segment('2');
		$segment_3 = $this->_CI->uri->segment('3');

		
		$data['setting'] = $this->_CI->Model_common->all_setting();

		$text_color = !empty($data['setting']['front_end_color']) ? 'style="color:#' . $data['setting']['front_end_color'] . ' !important"' : '';
		$background_color = !empty($data['setting']['front_end_background_color']) ? 'style="background-color:#' . $data['setting']['front_end_background_color'] . ' !important"' : '';

		
		if ($class_name == 'shop') {
			echo '<meta name="description" content="IRISPICTURE">';
			echo '<meta name="keywords" content="irisshot, irispohoto, irispicture">';
			echo '<title>SHOP</title>';
		} else if ($class_name == 'home') {
			echo '<meta name="description" content="' . $page_home['meta_description'] . '">';
			echo '<meta name="keywords" content="' . $page_home['meta_keyword'] . '">';
			echo '<title>' . $page_home['title'] . '</title>';
		} else if ($class_name == 'about') {
			echo '<meta name="description" content="' . $page_about['md_about'] . '">';
			echo '<meta name="keywords" content="' . $page_about['mk_about'] . '">';
			echo '<title>' . $page_about['mt_about'] . '</title>';
		} else if ($class_name == 'job') {
			echo '<meta name="description" content="' . $page_job['md_job'] . '">';
			echo '<meta name="keywords" content="' . $page_job['mk_job'] . '">';
			echo '<title>' . $page_job['mt_job'] . '</title>';
		} else if ($class_name == 'impressum') {
			echo '<meta name="description" content="' . $page_impressum['md_impressum'] . '">';
			echo '<meta name="keywords" content="' . $page_impressum['mk_impressum'] . '">';
			echo '<title>' . $page_impressum['mt_impressum'] . '</title>';
		} else if ($class_name == 'datenschutz') {
			echo '<meta name="description" content="' . $page_datenschutz['md_datenschutz'] . '">';
			echo '<meta name="keywords" content="' . $page_datenschutz['mk_datenschutz'] . '">';
			echo '<title>' . $page_datenschutz['mt_datenschutz'] . '</title>';
		} else if ($class_name == 'faq') {
			echo '<meta name="description" content="' . $page_faq['md_faq'] . '">';
			echo '<meta name="keywords" content="' . $page_faq['mk_faq'] . '">';
			echo '<title>' . $page_faq['mt_faq'] . '</title>';
		} else if ($class_name == 'team') {
			echo '<meta name="description" content="' . $page_team['md_team'] . '">';
			echo '<meta name="keywords" content="' . $page_team['mk_team'] . '">';
			echo '<title>' . $page_team['mt_team'] . '</title>';
		} else if ($class_name == 'team_member') {
			$single_team_member = $this->_CI->Model_team_member->team_member_detail($segment_2);
			echo '<meta name="description" content="' . $single_team_member['meta_description'] . '">';
			echo '<meta name="keywords" content="' . $single_team_member['meta_keyword'] . '">';
			echo '<title>' . $single_team_member['meta_title'] . '</title>';
		} else if ($class_name == 'portfolio') {
			echo '<meta name="description" content="' . $page_portfolio['md_portfolio'] . '">';
			echo '<meta name="keywords" content="' . $page_portfolio['mk_portfolio'] . '">';
			echo '<title>' . $page_portfolio['mt_portfolio'] . '</title>';
		} else if ($class_name == 'testimonial') {
			echo '<meta name="description" content="' . $page_testimonial['md_testimonial'] . '">';
			echo '<meta name="keywords" content="' . $page_testimonial['mk_testimonial'] . '">';
			echo '<title>' . $page_testimonial['mt_testimonial'] . '</title>';
		} else if ($class_name == 'contact') {
			echo '<meta name="description" content="' . $page_contact['md_contact'] . '">';
			echo '<meta name="keywords" content="' . $page_contact['mk_contact'] . '">';
			echo '<title>' . $page_contact['mt_contact'] . '</title>';
		} else if ($class_name == 'search') {
			echo '<meta name="description" content="' . $page_search['md_search'] . '">';
			echo '<meta name="keywords" content="' . $page_search['mk_search'] . '">';
			echo '<title>' . $page_search['mt_search'] . '</title>';
		} else if ($class_name == 'terms-and-conditions') {
			echo '<meta name="description" content="' . $page_term['md_term'] . '">';
			echo '<meta name="keywords" content="' . $page_term['mk_term'] . '">';
			echo '<title>' . $page_term['mt_term'] . '</title>';
		} else if ($class_name == 'privacy-policy') {
			echo '<meta name="description" content="' . $page_privacy['md_privacy'] . '">';
			echo '<meta name="keywords" content="' . $page_privacy['mk_privacy'] . '">';
			echo '<title>' . $page_privacy['mt_privacy'] . '</title>';
		} else if ($class_name == 'pricing') {
			echo '<meta name="description" content="' . $page_pricing['md_pricing'] . '">';
			echo '<meta name="keywords" content="' . $page_pricing['mk_pricing'] . '">';
			echo '<title>' . $page_pricing['mt_pricing'] . '</title>';
		} else if ($class_name == 'photo_gallery') {
			echo '<meta name="description" content="' . $page_photo_gallery['md_photo_gallery'] . '">';
			echo '<meta name="keywords" content="' . $page_photo_gallery['mk_photo_gallery'] . '">';
			echo '<title>' . $page_photo_gallery['mt_photo_gallery'] . '</title>';
		} else if ($class_name == 'service') {
			if ($segment_3 == 0) {
				echo '<meta name="description" content="' . $page_service['md_service'] . '">';
				echo '<meta name="keywords" content="' . $page_service['mk_service'] . '">';
				echo '<title>' . $page_service['mt_service'] . '</title>';
			} else {
				$single_service = $this->_CI->Model_service->service_detail($segment_3);
				echo '<meta name="description" content="' . $single_service['meta_description'] . '">';
				echo '<meta name="keywords" content="' . $single_service['meta_keyword'] . '">';
				echo '<title>' . $single_service['meta_title'] . '</title>';
			}
		} else if ($class_name == 'category') {
			$single_category = $this->_CI->Model_category->category_by_id($segment_2);
			echo '<meta name="description" content="' . $single_category['meta_description'] . '">';
			echo '<meta name="keywords" content="' . $single_category['meta_keyword'] . '">';
			echo '<title>' . $single_category['meta_title'] . '</title>';
		} else if ($class_name == 'news') {
			if ($segment_3 == 0) {
				echo '<meta name="description" content="' . $page_news['md_news'] . '">';
				echo '<meta name="keywords" content="' . $page_news['mk_news'] . '">';
				echo '<title>' . $page_news['mt_news'] . '</title>';
			} else {
				$news_single_item = $this->_CI->Model_news->news_detail($segment_3);
				echo '<meta name="description" content="' . $news_single_item['meta_description'] . '">';
				echo '<meta name="keywords" content="' . $news_single_item['meta_keyword'] . '">';
				echo '<title>' . $news_single_item['meta_title'] . '</title>';
				$og_id = $news_single_item['news_id'];
				$og_photo = $news_single_item['photo'];
				$og_title = $news_single_item['news_title'];
				$og_description = $news_single_item['news_content_short'];
				echo '<meta property="og:title" content="' . $og_title . '">';
				echo '<meta property="og:type" content="website">';
				echo '<meta property="og:url" content="' . base_url() . 'news/view/' . $og_id . '">';
				echo '<meta property="og:description" content="' . $og_description . '">';
				echo '<meta property="og:image" content="' . base_url() . 'public/uploads/' . $og_photo . '">';
			}
		} else if ($class_name == 'event') {
			if ($segment_3 == 0) {
				echo '<meta name="description" content="' . $page_event['md_event'] . '">';
				echo '<meta name="keywords" content="' . $page_event['mk_event'] . '">';
				echo '<title>' . $page_event['mt_event'] . '</title>';
			} else {
				$event_single_item = $this->_CI->Model_event->event_detail($segment_3);
				echo '<meta name="description" content="' . $event_single_item['meta_description'] . '">';
				echo '<meta name="keywords" content="' . $event_single_item['meta_keyword'] . '">';
				echo '<title>' . $event_single_item['meta_title'] . '</title>';
				$og_id = $event_single_item['event_id'];
				$og_photo = $event_single_item['photo'];
				$og_title = $event_single_item['event_title'];
				$og_description = $event_single_item['event_content_short'];
				echo '<meta property="og:title" content="' . $og_title . '">';
				echo '<meta property="og:type" content="website">';
				echo '<meta property="og:url" content="' . base_url() . 'event/view/' . $og_id . '">';
				echo '<meta property="og:description" content="' . $og_description . '">';
				echo '<meta property="og:image" content="' . base_url() . 'public/uploads/' . $og_photo . '">';
			}
		} else {
			echo '<meta name="description" content="IRISPICTURE">';
			echo '<meta name="keywords" content="irisshot, irispohoto, irispicture">';
			echo '<title>IRISPICTURE</title>';
		}
	}

    
    
}
