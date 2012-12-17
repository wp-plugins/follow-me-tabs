<?php  
/* 
Plugin Name: Follow me Tabs 
Plugin URI: http://follow.code4site.com 
Description: Plugin for displaying "Follow me Tabs" on different positions on the browser screen  
Author: Igor Ivanov
Version: 1.0 
Author URI: http://follow.code4site.com
*/  


add_action('wp_footer', 'mp_footer');
add_action('admin_menu', 'followmetab_admin_actions');
add_action('wp_enqueue_scripts', 'my_scripts_method');

//include widget code
include('followme_widget.php');  

//include css and javascript
function my_scripts_method() 
{
	wp_enqueue_script('custom-script', WP_PLUGIN_URL . '/follow_me_tabs_133/js/inc.js', array('jquery'));
	wp_enqueue_style( 'prefix-style', WP_PLUGIN_URL . '/follow_me_tabs_133/css/style.css' );
}

//footer code
function mp_footer()
{
	global $networks_array, $path_to_images;
	
	$data = get_option('follow_me_tabs_133');
	
	if(count($data) > 0 && $data['in_position'] != 'hidden')
	{
		//get style, position and size of the tabs from database
		$style = $data['in_style'];
		$position = $data['in_position'];
		$size = $data['in_size'];
		
		//make sure they are valid
		if(!in_array($style, array('1','2','3','4'))) $style = '1';
		if(!in_array($position, array('left','right'))) $position = 'left';
		if(!in_array($size, array('40','50'))) $size = '40';
		
		echo '<div class="tabs_fm_s_'.$style.'_'.$size.' tabs_'.$position.'_'.$style.'_'.$size.'">';
		if($style == '2') echo '<div class="tabs_inner_fm_s_'.$style.'_'.$size.' tabs_'.$position.'_fm_s">';
		
		foreach ($data['networks'] as $network=>$network_params)
		{
			if($style == '2')
				$add_img = '<img src="'.$path_to_images.'s2/'.$networks_array[$network]['icon'].'.png" alt="" width="'.$size.'" />';
			else
				$add_img = '';
			
			$link_class = $position.'_'.$style.'_'.$size.'_'.$networks_array[$network]['icon'];
			if($style == '3' || $style == '4')
				$link_class = 'tabs_fm_s_a_'.$size.' i_'.$style.'_'.$size.'_'.$networks_array[$network]['icon'];
				
			if($network_params['value'] != '' && $network_params['active'] == 1)
				echo '<a href="'.$network_params['value'].'" class="'.$link_class.'" target="_blank" title="">'.$add_img.'</a>';
		}
		if($style == '2') echo '</div>';				
		echo '</div>';
	}
}

//menu link in Settings admin menu
function followmetab_admin_actions()
{
	add_options_page("Follow Me Tabs", "Follow Me Tabs", 1, "follow_me_tabs_133", "followmetabs_admin");
}

//open admin page
function followmetabs_admin() 
{  
	global $networks_array;
	include('followmetab_admin.php');  
} 

//path to plugin image folder
$path_to_images = WP_PLUGIN_URL . '/follow_me_tabs_133/img/';

//networks array
$networks_array = array(
		'Facebook'=>array(
			'description'=>'Ex: http://facebook.com/<b>username</b> or <br />http://facebook.com/profile.php?id=<b>profileID</b>',
			'icon'=>'facebook',
			'value'=>'',
			'active'=>''
			),
		'Google_Plus'=>array(
			'description'=>'Ex: https://plus.google.com/u/1/<b>userID</b>',
			'icon'=>'plus',
			'value'=>'',
			'active'=>''
			),
		'LinkedIn'=>array(
			'description'=>'Ex: http://www.linkedin.com/in/<b>username</b>',
			'icon'=>'linkedin',
			'value'=>'',
			'active'=>''
			),
		'Twitter'=>array(
			'description'=>'Ex: http://www.twitter.com/<b>username</b>',
			'icon'=>'twitter',
			'value'=>'',
			'active'=>''
			),
		'Youtube'=>array(
			'description'=>'Ex: http://www.youtube.com/<b>username</b>',
			'icon'=>'youtube',
			'value'=>'',
			'active'=>''
			),
		'Blogger'=>array(
			'description'=>'Ex: http://www.<b>username</b>.blogspot.com',
			'icon'=>'blogger',
			'value'=>'',
			'active'=>''
			),
		'Skype_Name'=>array(
			'description'=>'Ex: skype:<b>SkypeName</b>?chat',
			'icon'=>'skype',
			'value'=>'',
			'active'=>''
			),
		'MySpace'=>array(
			'description'=>'Ex: http://www.myspace.com/<b>userID</b>',
			'icon'=>'myspace',
			'value'=>'',
			'active'=>''
			),
		'Pinterest'=>array(
			'description'=>'Ex: http://pinterest.com/<b>username</b>/',
			'icon'=>'pinterest',
			'value'=>'',
			'active'=>''
			),
		'RSS_Feed'=>array(
			'description'=>'Ex: url from your rss feed',
			'icon'=>'rssfeed',
			'value'=>'',
			'active'=>''
			),
		'Last_fm'=>array(
			'description'=>'Ex: http://www.last.fm/user/<b>username</b>',
			'icon'=>'lastfm',
			'value'=>'',
			'active'=>''
			),
		'Deviant_Art'=>array(
			'description'=>'Ex: http://<b>username</b>.deviantart.com/',
			'icon'=>'deviantart',
			'value'=>'',
			'active'=>''
			),
		);
?>