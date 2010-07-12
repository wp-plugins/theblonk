<?php
/*
Plugin Name: theBlonk
Plugin URI: http://www.theBlonk.com/
Description: Use this plugin to put theBlonk widget on your Wordpress Blog.
Author: theBlonk
Version: 1.0.3
Author URI: http://blog.theBlonk.com/
*/
 
 
function install_theBlonk(){
        wp_register_sidebar_widget("theBlonk", "theBlonk Widget", "theBlonk_widget", $options );
        register_widget_control('theBlonk', 'theBlonk_widget_control', 275, 200 );
        add_option("theBlonk_widget_data", null);
}
 
add_action("plugins_loaded", "install_theBlonk");

function theBlonk_widget() {
$data = get_option("theBlonk_widget_data");

if(empty($data['widget_id'])){
echo "<div style='width:90%;align:center;border: 1px solid;margin: 10px 0px;padding:10px 5px 10px 5px;color: #D8000C;background-color: #FFBABA;'><b>theBlonk Widget Error:</b><br/>Widget ID not set.</div>";
}else{

if(isset($data['widget_title'])){
$extra = "&t=".urlencode(stripslashes($data['widget_title']));
}


if(is_single()){
$extra = "";
}elseif(is_home()){
$extra = "&i=1";
}

echo"<div id=\"theblonk_widget_container\" style=\"width:100%;overflow:hidden;\"><center><img src='http://widget.theBlonk.com/loading' /></div>";
echo "<script type=\"text/javascript\">
var _widgetID = ".$data['widget_id'].";
var _widgetExtraData = \"&wp=1$extra\";
</script>
<script src=\"http://widget.theBlonk.com/load\" type=\"text/javascript\"></script>
";
}//end if widget id set

}//end widget function



function settings_warning() {
$data = get_option('theBlonk_widget_data');
if(empty($data['widget_id'])){
echo "<div id='theBlonk-warning' class='updated fade'><p><strong>".__('theBlonk sidebar is almost ready.')."</strong> ".sprintf(__('You must <a href="%1$s">enter your Widget ID</a> for it to work. If you don\'t have a Widget ID, get one for free <a href="http://www.theBlonk.com">here</a>'), "widgets.php")."</p></div>";
}
}//end SETTINGS warning

add_action('admin_notices', 'settings_warning');

function theBlonk_widget_control(){
  if (isset($_POST['theBlonk_widget_id']) && isset($_POST['theBlonk_widget_title'])){
     $data['widget_id'] = attribute_escape($_POST['theBlonk_widget_id']);
     $data['widget_title'] = attribute_escape($_POST['theBlonk_widget_title']);
    update_option('theBlonk_widget_data', $data);
   }else{
  $data = get_option('theBlonk_widget_data');
  }
  
  
  if(isset($data['widget_title'])){
  $title =	$data['widget_title'];
  }else{
  $title = "More Blog Posts";	
  }
  ?>
  <table>
  <tr><td><p><label>Widget Title (<a href="http://blog.theblonk.com/faq/#Wordpress+Plugin+Widget+ID+and+Title" target="_blank">?</a>)</label></td><td><input name="theBlonk_widget_title" type="text" value="<?php echo $title; ?>"/></p></td></tr>
  <tr><td><p><label>Widget ID (<a href="http://blog.theblonk.com/faq/#Wordpress+Plugin+Widget+ID+and+Title" target="_blank">?</a>)</label></td><td><input name="theBlonk_widget_id" type="text" value="<?php echo $data['widget_id']; ?>"/></p></td></tr>
  </table>
<?php
}
?>