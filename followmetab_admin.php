<?php 

//if post
if(count($_POST) > 1)
{
	$data_for_db = array('networks'=>array());
	
	//save network links
	foreach ($networks_array as $network=>$network_params)
	{
		if(isset($_POST['in_'.$network])) $data_for_db['networks'][$network]['value'] = $_POST['in_'.$network];
		if(isset($_POST['ch_'.$network])) $data_for_db['networks'][$network]['active'] = $_POST['ch_'.$network];	
	}
	
	//save follow me position & style
	$data_for_db['in_position'] = isset($_POST['in_position']) ? $_POST['in_position'] : 'hidden';
	$data_for_db['in_style'] = isset($_POST['in_style']) ? $_POST['in_style'] : '1';
	$data_for_db['in_size'] = isset($_POST['in_size']) ? $_POST['in_size'] : '40';
	
	update_option('follow_me_tabs_133', $data_for_db);	
}

//else get data from database
$data = get_option('follow_me_tabs_133');

foreach ($networks_array as $network => $network_params)
{
	if(isset($data['networks'][$network])) 
	{
		$networks_array[$network]['value'] = $data['networks'][$network]['value'];
		$networks_array[$network]['active'] = $data['networks'][$network]['active'];
	}	
}
if(!isset($data['in_position'])) $data['in_position'] = 'hidden';
if(!isset($data['in_style'])) $data['in_style'] = '1';
if(!isset($data['in_size'])) $data['in_size'] = '40';

?>

<div class="wrap">  
    <h2>Follow Me Tabs Settings</h2>
    
	<form name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
		<table class="form-table" style="width:600px;">
			<tr valign="top">
				<th><b>Account</b></th>
				<th><b>Your Social Network URL or ID</b></th>
				<th><b>Is Active</b></th>
			</tr>
			<?foreach ($networks_array as $network=>$network_params){?>
			<tr valign="top">
				<th scope="row"><?=str_replace('_', ' ', $network)?></th>
				<td>
					<input name="in_<?=$network?>" type="text" value="<?=$network_params['value']?>" style="width: 400px;" />
					<p class="description"><?=$network_params['description']?></p>
				</td>
				<td>
					<input type="checkbox" name="ch_<?=$network?>" value="1" <?if($network_params['active'] == 1) echo "checked"; ?> />
				</td>	
            </tr>
			<? }?>
	  		   
			   
			<tr valign="top">
				<th scope="row">Tabs Position</th>
				<td>
					<select name="in_position">
						<option value="hidden" <?if($data['in_position'] == 'hidden') echo "selected"; ?>>Hidden</option>
						<option value="left" <?if($data['in_position'] == 'left') echo "selected"; ?>>Left</option>
						<option value="right" <?if($data['in_position'] == 'right') echo "selected"; ?>>Right</option>
					</select>
				</td>	
				<td>&nbsp;</td>
            </tr>
			<tr valign="top">
				<th scope="row">Tabs Size</th>
				<td>
					<select name="in_size">
						<option value="40" <?if($data['in_size'] == '40') echo "selected"; ?>>Small</option>
						<option value="50" <?if($data['in_size'] == '50') echo "selected"; ?>>Large</option>
					</select>
				</td>	
				<td>&nbsp;</td>
            </tr>
			<tr valign="top">
				<th scope="row">Tabs Style</th>
				<td>
					<select name="in_style">
						<option value="1" <?if($data['in_style'] == '1') echo "selected"; ?>>Extendable Buttons</option>
						<option value="2" <?if($data['in_style'] == '2') echo "selected"; ?>>Zoom Buttons</option>
						<option value="3" <?if($data['in_style'] == '3') echo "selected"; ?>>Color Buttons</option>
						<option value="4" <?if($data['in_style'] == '4') echo "selected"; ?>>Grey Buttons</option>
					</select>
				</td>	
				<td>&nbsp;</td>
            </tr>
       </table>
		
		<p class="submit">  
			<input type="submit" name="Submit" value="Save Settings" />  
        </p>  
    </form>  
</div> 