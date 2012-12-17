<?php

add_action( 'widgets_init', 'follow_me_tabs_widget' );
add_shortcode( 'follow_me_icons', 'follow_me_icons_content_processor' );


function follow_me_tabs_widget() 
{
	register_widget( 'FollowMeTabs_Widget' );
}

function follow_me_icons_content_processor($atts)
{
	extract( shortcode_atts( array(
					'size' => 'small',
					'type' => 'zoom'
					), $atts ) );
					
	return  follow_me_icons_build($size, $type);
}

function follow_me_icons_build($size, $style, $widget_text = '', $widget_list = array())
{
	global $networks_array, $path_to_images;
	$content = '';
	if($style == 'zoom') $style = 2;
	if($style == 'color') $style = 3;
	if($style == 'grey') $style = 4;
	
	if($size == 'small') $size = 40;
	if($size == 'large') $size = 50;
	
	if(!in_array($style, array('2','3','4'))) $style = '2';
	if(!in_array($size, array('40','50'))) $size = '40';
	
	$data = get_option('follow_me_tabs_133');
	
	if(count($data) > 0 && $data['in_position'] != 'hidden')
	{
		if($widget_text != '') $content .= $widget_text;
		
		$main_class = ($style == '2') ? 'widget_fm_zoom' : 'widget_fm_color';
		$content .= '<div class="widget_fm_'.$size.' '.$main_class.'">';
		if($style == '2') 
		{
			if(count($widget_list) > 0)
				$min_width = count($widget_list) * ($size + 10);
			else
			{ 
				$cnt = 0;
				foreach ($data['networks'] as $network=>$network_params)
					if($network_params['value'] != '' && isset($network_params['active']) && $network_params['active'] == "1")
						$cnt++;
				$min_width = $cnt * ($size + 10);
			}
			$content .= '<div class="widget_inner_fm_'.$size.'" style="min-width: '.$min_width.'px;">';
		}
		
		foreach ($data['networks'] as $network=>$network_params)
		{
			if(count($widget_list) > 0 && !in_array($network, $widget_list)) continue;
			
			if($style == '2')
				$add_img = '<img src="'.$path_to_images.'s2/'.$networks_array[$network]['icon'].'.png" alt="" width="'.$size.'" />';
			else
				$add_img = '';
			
			$link_class = '';
			if($style == '3' || $style == '4')
				$link_class = 'tabs_fm_s_a_'.$size.' i_'.$style.'_'.$size.'_'.$networks_array[$network]['icon'];
			
			if($network_params['value'] != '' && isset($network_params['active']) && $network_params['active'] == "1")
				$content .= '<a href="'.$network_params['value'].'" class="'.$link_class.'" target="_blank" title="">'.$add_img.'</a>';
		}
		if($style == '2') $content .= '</div>';				
		$content .= '</div>';
	}
	
	return $content;
}
/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 */
class FollowMeTabs_Widget extends WP_Widget 
{
	
	/**
	 * Widget setup.
	 */
	function FollowMeTabs_Widget() 
	{
		/* Widget settings. */
		$widget_ops = array( 
				'classname' => 'FollowMe', 
				'description' => __('"Fallow Me" buttons as Widget', 'FollowMe') 
				);
		
		/* Widget control settings. */
		$control_ops = array( 
				'width' => 400, 
				'height' => 400, 
				'id_base' => 'follow_me_tabs_widget' );
		
		/* Create the widget. */
		$this->WP_Widget( 
				'follow_me_tabs_widget', 
				__('Follow Me Widget', 'FollowMe'), 
				$widget_ops, 
				$control_ops 
				);
	}
	
	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) 
	{
		extract( $args );
		
		$defaults = array('w_network' => array(), 'w_network_style'=>'2', 'w_network_size'=>40, 'w_network_text'=>'');
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$title = ($instance['w_network_text'] != '') ? $args['before_title'] . $instance['w_network_text'] . $args['after_title'] : '';
		echo $args['before_widget'];
		echo follow_me_icons_build($instance['w_network_size'], $instance['w_network_style'], $title, $instance['w_network']);
		echo $args['after_widget'];
	}
	
	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) 
	{
		
		$instance = $new_instance;
		
		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['w_network'] = isset($_POST['w_network']) ? $_POST['w_network'] : array();
		$instance['w_network_style'] = isset($_POST['w_network_style']) ? $_POST['w_network_style'] : '2';
		$instance['w_network_size'] = isset($_POST['w_network_size']) ? $_POST['w_network_size'] : '40';
		$instance['w_network_text'] = isset($_POST['w_network_text']) ? $_POST['w_network_text'] : '';
		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 */
	function form( $instance ) 
	{
		
		global $networks_array,$path_to_images;
		
		/* Set up some default widget settings. */
		$defaults = array('w_network' => array(), 'w_network_style'=>'2', 'w_network_size'=>40, 'w_network_text'=>'');
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
		$data = get_option('follow_me_tabs_133');
		$networks = isset($data['networks']) ? $data['networks'] : array();
		
		if(count($networks) > 0)
		{
			echo '<p>Please check the network that you want to include in your widget (Here are listed only active networks with valid network URL set in Settings->Follow Me Tabs page)</p>';
			echo '<div style="width:400px;display:block;">';
			
			foreach ($data['networks'] as $network=>$network_params)
			{
				if($network_params['value'] != '' && isset($network_params['active']) && $network_params['active'] == "1")
				{
					$checked = in_array($network, $instance['w_network']) ? ' checked="checked" ' : '';
					?>
					<div style="width:130px;float:left;">
						<div style="display:inline;margin-bottom:10px;vertical-align: top;">
							<input type="checkbox" name="w_network[]" value="<?php echo $network?>" <?php echo $checked?>/>
						</div>
						<div style="display:inline;">
							<img src="<?php echo $path_to_images?>s2/<?php echo $networks_array[$network]['icon']?>.png" alt="" width="45" />
						</div>
					</div>
					
					<?
				}
				
			}
			
			?>
			<div style="clear:both;"></div>
			<br />Widget Title (optional):<br />
			<input type="text" name="w_network_text" value="<?php echo $instance['w_network_text']?>" style="width: 370px;" />
			<br />Style:<br />
			<select name="w_network_style">
			<option value="2" <?php if($instance['w_network_style'] == '2') echo 'selected';?>>Zoom Icons</option>
			<option value="3" <?php if($instance['w_network_style'] == '3') echo 'selected';?>>Color Up-Down Icons</option>
			<option value="4" <?php if($instance['w_network_style'] == '4') echo 'selected';?>>Grey Up-Down Icons</option>
			</select>
			
			<br />Size:<br />
			<select name="w_network_size">
			<option value="40" <?php if($instance['w_network_size'] == '40') echo 'selected';?>>Small</option>
			<option value="50" <?php if($instance['w_network_size'] == '50') echo 'selected';?>>Large</option>
			</select>
			<p>If you select zoom style, you need to have wider space in selected widget area!</p>
			</div>
			<?
		}
		else 
		{
			echo 'Please go in Settings->Follow me Tabs and set up your networks first!';
		}
	}
}

?>