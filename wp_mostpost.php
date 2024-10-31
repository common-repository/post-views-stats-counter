<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function pvs_counter_most_post_rows(){
	global $wpdb;
	$table_name_pvs_counter = $wpdb->prefix . 'pvs_counter';
	$query = $wpdb->prepare("
				 SELECT title,url,sum(access) as total_access
				 FROM $table_name_pvs_counter
				 GROUP BY title
				 ORDER BY total_access DESC","");
	$output = $wpdb->get_results($query);
	return $output;
}
$most_post_rows = pvs_counter_most_post_rows();

$most_post_title = array();$most_post_access = array();$most_post_url = array();
foreach ($most_post_rows as $each_rows) {
   		array_push($most_post_title , $each_rows->title);
   		array_push($most_post_url , $each_rows->url);
   		array_push($most_post_access , $each_rows->total_access);
}

for ($i=0; $i <= $number_post-1; $i++){
	if ($most_post_title[$i]){
		?>
		<a href="<?php echo $most_post_url[$i]; ?>"><?php echo $most_post_title[$i]; ?></a>
		<?php echo "<br>";
	}
}
