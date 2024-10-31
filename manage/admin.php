<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/***
 * 管理画面
***/

	$is_act = false;
	if(get_option('post_views_stats_counter_plus_dir')){
		$file= get_option('post_views_stats_counter_plus_dir');
		$is_act = false;
		
		foreach ((array) get_option('active_plugins') as $val) {
			if (preg_match('/'.preg_quote($file, '/').'/i', $val)) {
				$is_act = true;
			}
		}
	}

?>

<div class="wrap"><br/>
	<h1>Post Views Stats Counter <font size="2">v1.1.7</font></h1>

<?php

	 /***
	   *Saveされた時の処理
	 ***/

 	 $Pvs_Counter_save = $_POST['Pvs_Counter_save'];
     $Pvs_Counter_save = wp_kses($Pvs_Counter_save, array());
		
		if ( isset( $Pvs_Counter_save )){

		   //nonceチェック
	       if ( isset( $_POST['_wpnonce'] ) && $_POST['_wpnonce'] ) {
	            if ( check_admin_referer( 'Pvs_Counter', '_wpnonce' ) ) {

		        	//POST取得
			        $pvs_counter_dayselect_value = $_POST['pvs_counter_dayselect_value'];
			        $pvs_counter_dayselect_value = wp_kses($pvs_counter_dayselect_value, array());
			        
			        $pvs_counter_order_value = $_POST['pvs_counter_order_value'];
			        $pvs_counter_order_value = wp_kses($pvs_counter_order_value, array());
			        
			        $pvs_counter_title_value = $_POST['pvs_counter_title_value'];
			        $pvs_counter_title_value = wp_kses($pvs_counter_title_value, array());

			        $pvs_counter_value_user = $_POST['pvs_counter_value_user'];
			        $pvs_counter_value_user = wp_kses($pvs_counter_value_user, array());
			        
			        $pvs_counter_value_admin = $_POST['pvs_counter_value_admin'];
			        $pvs_counter_value_admin = wp_kses($pvs_counter_value_admin, array());
			        
			        $pvs_counter_value_reset = $_POST['pvs_counter_value_reset'];
			        $pvs_counter_value_reset = wp_kses($pvs_counter_value_reset, array());
			        
			        $_POST['pvs_counter_value_admin_bots'] = preg_replace('/\r\n\r\n/', '', strip_tags($_POST['pvs_counter_value_admin_bots']));
		        	$pvs_counter_value_admin_bots = $_POST['pvs_counter_value_admin_bots'];
			        $pvs_counter_value_admin_bots = wp_kses($pvs_counter_value_admin_bots, array());
			        
			        $pvs_counter_value_user_bots = $_POST['pvs_counter_value_user_bots'];
			        $pvs_counter_value_user_bots = wp_kses($pvs_counter_value_user_bots, array());
				        if(isset($pvs_counter_value_user_bots)){
				        global $wpdb;
						$table_name_pvs_counter = $wpdb->prefix . 'pvs_counter';
							$wpdb->query($wpdb->prepare("DELETE FROM $table_name_pvs_counter WHERE useragent='%s'" , $pvs_counter_value_user_bots));
							
						}
					$pvs_counter_eliminated_useragent = $_POST['pvs_counter_eliminated_useragent'];
					$pvs_counter_eliminated_useragent = wp_kses($pvs_counter_eliminated_useragent, array());
					
				        //proversion
				        $pvs_counter_schedule_check = $_POST['pvs_counter_schedule_check'];
			        	$pvs_counter_schedule_check = wp_kses($pvs_counter_schedule_check, array());
			        	//データベース登録
			        	update_option('pvs_counter_schedule_check', $pvs_counter_schedule_check);
			        	
			        	$pvs_counter_year_front_value = $_POST['pvs_counter_year_front_value'];
			        	$pvs_counter_year_front_value = wp_kses($pvs_counter_year_front_value, array());
			        	update_option('pvs_counter_year_front_value', $pvs_counter_year_front_value);
			        	
			        	$pvs_counter_month_front_value = $_POST['pvs_counter_month_front_value'];
			        	$pvs_counter_month_front_value = wp_kses($pvs_counter_month_front_value, array());
			        	update_option('pvs_counter_month_front_value', $pvs_counter_month_front_value);
			        	
			        	$pvs_counter_day_front_value = $_POST['pvs_counter_day_front_value'];
			        	$pvs_counter_day_front_value = wp_kses($pvs_counter_day_front_value, array());
			        	update_option('pvs_counter_day_front_value', $pvs_counter_day_front_value);
			        	
			        	$pvs_counter_year_back_value = $_POST['pvs_counter_year_back_value'];
			        	$pvs_counter_year_back_value = wp_kses($pvs_counter_year_back_value, array());
			        	update_option('pvs_counter_year_back_value', $pvs_counter_year_back_value);
			        	
			        	$pvs_counter_month_back_value = $_POST['pvs_counter_month_back_value'];
			        	$pvs_counter_month_back_value = wp_kses($pvs_counter_month_back_value, array());
			        	update_option('pvs_counter_month_back_value', $pvs_counter_month_back_value);
			        	
			        	$pvs_counter_day_back_value = $_POST['pvs_counter_day_back_value'];
			        	$pvs_counter_day_back_value = wp_kses($pvs_counter_day_back_value, array());
			        	update_option('pvs_counter_day_back_value', $pvs_counter_day_back_value);
				        //proversion
			        
				    
					//データベース登録
					update_option('pvs_counter_dayselect_value', $pvs_counter_dayselect_value);
					update_option('pvs_counter_order_value', $pvs_counter_order_value);
					update_option('pvs_counter_title_value', $pvs_counter_title_value);
					update_option('pvs_counter_value_user', $pvs_counter_value_user);
					update_option('pvs_counter_value_admin', $pvs_counter_value_admin);
					update_option('pvs_counter_value_reset', $pvs_counter_value_reset);
					update_option('pvs_counter_value_admin_bots', $pvs_counter_value_admin_bots);
					
					//Bots UserAgent 登録
					$existing = get_option('pvs_counter_value_user_bots');
						if(!($pvs_counter_value_user_bots == "Select")){
					        if($existing === false){
					        	add_option('pvs_counter_value_user_bots' , array($pvs_counter_value_user_bots));
					        }else{
					        	array_push( $existing, $pvs_counter_value_user_bots );
					        	update_option('pvs_counter_value_user_bots', $existing);
					        }
				        }
				    
				    //Bots UserAgent 削除
				    $existing_registered_ua = get_option('pvs_counter_value_user_bots');
						if(!($pvs_counter_eliminated_useragent == "Select")){
					        
					       		unset($existing_registered_ua[$pvs_counter_eliminated_useragent]);
					       		
					       		$existing_registered_ua = array_values($existing_registered_ua);
					        	update_option('pvs_counter_value_user_bots', $existing_registered_ua);
				        }
					
					
				}
			}
		}


	/***
	 * データを取得
	***/
	//登録データ
	$pvs_counter_dayselect_value = get_option('pvs_counter_dayselect_value');
	$pvs_counter_order_value = get_option('pvs_counter_order_value');
	$pvs_counter_title_value = get_option('pvs_counter_title_value');
	$pvs_counter_value_user = get_option('pvs_counter_value_user');
	$pvs_counter_value_admin = get_option('pvs_counter_value_admin');
	$pvs_counter_value_reset = get_option('pvs_counter_value_reset');
	$pvs_counter_value_admin_bots = get_option('pvs_counter_value_admin_bots');
	$pvs_counter_value_user_bots = get_option('pvs_counter_value_user_bots');
	
		//proversion
		$pvs_counter_schedule_check = get_option('pvs_counter_schedule_check');
		$post_views_stats_counter_schedule_on = get_option('post_views_stats_counter_plus_active');
		
		//スケジュールボタンにチェックが付いていたら、選択した日付にする。そうでなければ、今日の日付を出す。
		if ($pvs_counter_schedule_check == false){
			$pvs_counter_year_front_value = current_time('Y');//大文字にすると2019の20まで入る
			$pvs_counter_month_front_value = current_time('m');
			$pvs_counter_day_front_value = current_time('d');
			$pvs_counter_year_back_value = current_time('Y');
			$pvs_counter_month_back_value = current_time('m');
			$pvs_counter_day_back_value = current_time('d');
		}else{
			$pvs_counter_year_front_value = get_option('pvs_counter_year_front_value');
			$pvs_counter_month_front_value = get_option('pvs_counter_month_front_value');
			$pvs_counter_day_front_value = get_option('pvs_counter_day_front_value');
			$pvs_counter_year_back_value = get_option('pvs_counter_year_back_value');
			$pvs_counter_month_back_value = get_option('pvs_counter_month_back_value');
			$pvs_counter_day_back_value = get_option('pvs_counter_day_back_value');
		}
		//proversion

	//Contributer`s checker see registered UA bots.
    //print_r($pvs_counter_value_user_bots);	

//テーブル名にはプリフィックスを必ず付ける（wp-includes内:wp-db.phpのvar $tablesでも可）
global $wpdb;
$table_name_pvs_counter = $wpdb->prefix . 'pvs_counter';

//データベースバージョンの削除
		if ($pvs_counter_value_reset == true){
	        delete_option('jal_db_version');
	        //テーブルの削除
	        global $wpdb;
	        $table_name = $wpdb->prefix . 'pvs_counter';
	        $sql = "DROP TABLE IF EXISTS $table_name";
	        $wpdb->query($sql);
	        
	        //テーブルを再開
			global $jal_db_version;
			$jal_db_version = '1.0';
		    global $jal_db_version;

		    $table_name = $wpdb->prefix . 'pvs_counter';

		    $charset_collate = $wpdb->get_charset_collate();

		    $sql = "CREATE TABLE $table_name (
		      id mediumint(9) NOT NULL AUTO_INCREMENT,
		      time date DEFAULT '0000-00-00' NOT NULL,
		      title varchar(155) DEFAULT '' NOT NULL,
		      url varchar(155) DEFAULT '' NOT NULL,
		      access int(30) DEFAULT 0 NOT NULL,
		      pageid int(30) DEFAULT 0 NOT NULL,
		      ipaddress varchar(155) DEFAULT '' NOT NULL,
		      useragent varchar(155) DEFAULT '' NOT NULL,
		      UNIQUE KEY id (id)
		    ) $charset_collate;";

		   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		   dbDelta( $sql );

		   add_option( 'jal_db_version', $jal_db_version );
		   update_option('pvs_counter_value_reset', false);        
        }


//現在の年月日を取得
	$current_now = current_time("Y-m-d");
	$current_yesterday = date( 'Y-m-d', strtotime( '-1 days', current_time('timestamp') ) );
	$current_week = date( 'Y-m-d', strtotime( '-7 days', current_time('timestamp') ) );
	$current_month = date( 'Y-m-d', strtotime( '-30 days', current_time('timestamp') ) );
	
	
	
//proversion
			
			//今の年の取得
			$current_year_pro = current_time('Y');//大文字にすると2019の20まで入る
			
			$i = 0;
			//月の取得
			$months = array();
				for($i = 1; $i <= 12; $i++) {
				array_push($months, $i);
			}

			//日の取得
			$days = array();
				for($i = 1; $i <= 31; $i++) {
				array_push($days, $i);
			}

			//年の5年単位
			$years = array();
				for($i = $current_year_pro - 2; $i <= $current_year_pro; $i++) {
				array_push($years, $i);
			}
//proversion



//データベースの今日、昨日、7日間、30日間のアクセスを集計する
if(!($pvs_counter_schedule_check == true)){
	function pvs_counter_static_days($current , $current_length){
		global $wpdb;
		$table_name_pvs_counter = $wpdb->prefix . 'pvs_counter';
		if (!($current == "alldays")){
			$query = $wpdb->get_var($wpdb->prepare("
					 SELECT SUM(access)
					 FROM $table_name_pvs_counter
					 WHERE time >= '%s' AND  time <= '%s'" , $current_length , $current));
			return $query;
		}else{
			$query = $wpdb->get_var($wpdb->prepare("
					 SELECT SUM(access)
					 FROM $table_name_pvs_counter" , ""));
			return $query;
		}
	}
	function pvs_counter_static_title_days($current , $current_length , $pvs_counter_title_value){
		global $wpdb;
		$table_name_pvs_counter = $wpdb->prefix . 'pvs_counter';
		if (!($current == "alldays")){
			$query = $wpdb->get_var($wpdb->prepare("
					 SELECT SUM(access)
					 FROM $table_name_pvs_counter
					 WHERE time >= '%s' AND  time <= '%s'  and title='%s' " , $current_length , $current , $pvs_counter_title_value));
			return $query;
		}else{
			$query = $wpdb->get_var($wpdb->prepare("
					 SELECT SUM(access)
					 FROM $table_name_pvs_counter
					 WHERE title='%s' " , $pvs_counter_title_value));
			return $query;
		}
	}
}else{
	//proversion
	function pvs_counter_static_days($current , $current_length){
		global $wpdb;
		$table_name_pvs_counter = $wpdb->prefix . 'pvs_counter';
		
			$query = $wpdb->get_var($wpdb->prepare("
					 SELECT SUM(access)
					 FROM $table_name_pvs_counter
					 WHERE time >= '%s' AND  time <= '%s'" , $current_length , $current));
			return $query;
	}
	function pvs_counter_static_title_days($current , $current_length , $pvs_counter_title_value){
		global $wpdb;
		$table_name_pvs_counter = $wpdb->prefix . 'pvs_counter';
		
			$query = $wpdb->get_var($wpdb->prepare("
					 SELECT SUM(access)
					 FROM $table_name_pvs_counter
					 WHERE time >= '%s' AND  time <= '%s'  and title='%s' " , $current_length , $current , $pvs_counter_title_value));
			return $query;
	}
}

$query_today = pvs_counter_static_days($current_now , $current_now);
$query_yesterday = pvs_counter_static_days($current_yesterday , $current_yesterday);
$query_7days = pvs_counter_static_days($current_now , $current_week);
$query_30days = pvs_counter_static_days($current_now , $current_month);
$query_alldays = pvs_counter_static_days($pvs_counter_dayselect_value , $pvs_counter_dayselect_value);
		 
$query_title_now = pvs_counter_static_title_days($current_now , $current_now , $pvs_counter_title_value);
$query_title_yesterday = pvs_counter_static_title_days($current_yesterday , $current_yesterday , $pvs_counter_title_value);
$query_title_7days = pvs_counter_static_title_days($current_now , $current_week , $pvs_counter_title_value);
$query_title_30days = pvs_counter_static_title_days($current_now , $current_month , $pvs_counter_title_value);
$query_title_alldays = pvs_counter_static_title_days($pvs_counter_dayselect_value , $pvs_counter_dayselect_value , $pvs_counter_title_value);

		//proversion
		$i=0;
		for ($i=1; $i<=9; $i++){
			if($pvs_counter_month_front_value == $i){$pvs_counter_month_front_value = "0".$pvs_counter_month_front_value;}
			if($pvs_counter_day_front_value == $i){$pvs_counter_day_front_value = "0".$pvs_counter_day_front_value;}
			if($pvs_counter_month_back_value == $i){$pvs_counter_month_back_value = "0".$pvs_counter_month_back_value;}
			if($pvs_counter_day_back_value == $i){$pvs_counter_day_back_value = "0".$pvs_counter_day_back_value;}
		}
		$pvs_counter_schedule_front_value = $pvs_counter_year_front_value."-".$pvs_counter_month_front_value."-".$pvs_counter_day_front_value;
		$pvs_counter_schedule_front_value = date( 'Y-m-d', strtotime($pvs_counter_schedule_front_value));
		
		$pvs_counter_schedule_back_value = $pvs_counter_year_back_value."-".$pvs_counter_month_back_value."-".$pvs_counter_day_back_value;
		$pvs_counter_schedule_back_value = date( 'Y-m-d', strtotime($pvs_counter_schedule_back_value));
		
		$query_schedule = pvs_counter_static_days($pvs_counter_schedule_back_value , $pvs_counter_schedule_front_value);
		$query_title_schedule = pvs_counter_static_title_days($pvs_counter_schedule_back_value , $pvs_counter_schedule_front_value , $pvs_counter_title_value);
		//proversion
		

//Accessのトータルを取得
function pvs_counter_accesstotal($query_when , $query_title_when , $pvs_counter_dayselect_value , $pvs_counter_title_value){
		if ($pvs_counter_title_value == "all"){
			$query_total = $query_when;
		}else{
			$query_total = $query_title_when;
		}
		return $query_total;	
}

if (!($pvs_counter_schedule_check == true)){
	if ($pvs_counter_dayselect_value == "now"){
		$query_total = pvs_counter_accesstotal($query_today , $query_title_now , $pvs_counter_dayselect_value , $pvs_counter_title_value);
	}elseif ($pvs_counter_dayselect_value == "7days"){
		$query_total = pvs_counter_accesstotal($query_7days , $query_title_7days , $pvs_counter_dayselect_value , $pvs_counter_title_value);
	}elseif ($pvs_counter_dayselect_value == "yesterday"){
		$query_total = pvs_counter_accesstotal($query_yesterday , $query_title_yesterday , $pvs_counter_dayselect_value , $pvs_counter_title_value);
	}elseif ($pvs_counter_dayselect_value == "30days"){
		$query_total = pvs_counter_accesstotal($query_30days , $query_title_30days , $pvs_counter_dayselect_value , $pvs_counter_title_value);
	}elseif ($pvs_counter_dayselect_value == "alldays"){
		$query_total = pvs_counter_accesstotal($query_alldays , $query_title_alldays , $pvs_counter_dayselect_value , $pvs_counter_title_value);
	}
}else{
   		$query_total = pvs_counter_accesstotal($query_schedule , $query_title_schedule , $pvs_counter_dayselect_value , $pvs_counter_title_value);//proversion
}


//データベースのタイトルなどの内容を今日の日付で取得 + 並び順の指定 + 特定のタイトルのみ出力
function pvs_counter_rows_all($current , $current_length , $pvs_counter_order_value , $pvs_counter_title_value){
	global $wpdb;
	$table_name_pvs_counter = $wpdb->prefix . 'pvs_counter';
	//アクセスの並び順
	if ($pvs_counter_order_value == "access"){
			//タイトルが全部の場合
			if ($pvs_counter_title_value == "all"){
				//全日付以外の場合
				if (!($current == "alldays")){
					$query = $wpdb->prepare("SELECT time,title,url,sum(access) as total_access,pageid,ipaddress,useragent FROM $table_name_pvs_counter WHERE time >= '%s' AND  time <= '%s' GROUP BY title,time ORDER BY total_access DESC" , $current_length , $current);
				//全日付の場合
				}else{
					$query = $wpdb->prepare("SELECT time,title,url,sum(access) as total_access,pageid,ipaddress,useragent FROM $table_name_pvs_counter GROUP BY title,time ORDER BY total_access DESC" , "");
				}
			//それぞれのタイトルの場合
			}else{
				//全日付以外の場合
				if (!($current == "alldays")){
					$query = $wpdb->prepare("SELECT time,title,url,sum(access) as total_access,pageid,ipaddress,useragent FROM $table_name_pvs_counter WHERE time >= '%s' AND  time <= '%s' and title='%s' GROUP BY title,time ORDER BY total_access DESC" , $current_length , $current , $pvs_counter_title_value);
				//全日付の場合
				}else{
					$query = $wpdb->prepare("SELECT time,title,url,sum(access) as total_access,pageid,ipaddress,useragent FROM $table_name_pvs_counter WHERE title='$pvs_counter_title_value' GROUP BY title,time ORDER BY total_access DESC" , "");
				}
			}
	//タイムの並び順
	}else if ($pvs_counter_order_value == "time"){
			//全日付の場合
			if ($pvs_counter_title_value == "all"){
				//全日付の場合
				if (!($current == "alldays")){
					$query = $wpdb->prepare("SELECT time,title,url,sum(access) as total_access,pageid,ipaddress,useragent FROM $table_name_pvs_counter WHERE time >= '%s' AND  time <= '%s' GROUP BY title,time ORDER BY time DESC" , $current_length , $current);
				//全日付以外の場合
				}else{
					$query = $wpdb->prepare("SELECT time,title,url,sum(access) as total_access,pageid,ipaddress,useragent FROM $table_name_pvs_counter GROUP BY title,time ORDER BY time DESC" , "");
				}
			//それぞれのタイトルの場合
			}else{
				//全日付の場合
				if (!($current == "alldays")){
					$query = $wpdb->prepare("SELECT time,title,url,sum(access) as total_access,pageid,ipaddress,useragent FROM $table_name_pvs_counter WHERE time >= '%s' AND  time <= '%s' and title='%s' GROUP BY title,time ORDER BY time DESC" , $current_length , $current , $pvs_counter_title_value);
				//全日付以外の場合
				}else{
					$query = $wpdb->prepare("SELECT time,title,url,sum(access) as total_access,pageid,ipaddress,useragent FROM $table_name_pvs_counter WHERE title='%s' GROUP BY title,time ORDER BY time DESC" , $pvs_counter_title_value);
				}
			}
	}										
	$rows = $wpdb->get_results($query);
	return $rows;
}
$rows_now = pvs_counter_rows_all($current_now , $current_now , $pvs_counter_order_value , $pvs_counter_title_value);
$rows_yesterday = pvs_counter_rows_all($current_yesterday , $current_yesterday , $pvs_counter_order_value , $pvs_counter_title_value);
$rows_7days = pvs_counter_rows_all($current_now , $current_week , $pvs_counter_order_value , $pvs_counter_title_value);
$rows_30days = pvs_counter_rows_all($current_now , $current_month , $pvs_counter_order_value , $pvs_counter_title_value);
$rows_alldays = pvs_counter_rows_all($pvs_counter_dayselect_value , $pvs_counter_dayselect_value , $pvs_counter_order_value , $pvs_counter_title_value);

//proversion
	//始まりスケジュール
	if ($pvs_counter_schedule_check == true){
		$rows_schedule = pvs_counter_rows_all($pvs_counter_schedule_back_value , $pvs_counter_schedule_front_value , $pvs_counter_order_value , $pvs_counter_title_value);
	}
//proversion


//プルダウンタイトルをDISTINCTで取得
if ($pvs_counter_order_value == "access"){
		$query = $wpdb->prepare("SELECT DISTINCT title FROM $table_name_pvs_counter WHERE time >= '%s' AND  time <= '%s' ORDER BY access DESC" , $current_month , $current_now);
}else if ($pvs_counter_order_value == "time"){
		$query = $wpdb->prepare("SELECT DISTINCT title FROM $table_name_pvs_counter WHERE time >= '%s' AND  time <= '%s' ORDER BY time DESC" , $current_month , $current_now);
}										
$titles_30days = $wpdb->get_results($query);


//UserAgentボットのプルダウンを取得
$query_useragent = $wpdb->prepare("SELECT DISTINCT useragent FROM $table_name_pvs_counter WHERE time >= '%s' AND  time <= '%s'" , $current_week , $current_now);
$rows_useragent = $wpdb->get_results($query_useragent);
$useragent_bot_list = array();
	foreach ($rows_useragent as $row_useragent) {
	   		array_push($useragent_bot_list,$row_useragent->useragent);
	}

   //それぞれの項目を（今日、昨日、7日間、30日、全期間）で取得 
   $times_all = array(); $titles_all = array(); $accesses_all = array(); $urls_all = array(); 
   		if (!($pvs_counter_schedule_check == true)){
	   		if ($pvs_counter_dayselect_value == "now"){
	   			$rows_all = $rows_now;
	   		}elseif ($pvs_counter_dayselect_value == "yesterday"){
	   			$rows_all = $rows_yesterday;
	   		}elseif ($pvs_counter_dayselect_value == "7days"){
	   			$rows_all = $rows_7days;
	   		}elseif ($pvs_counter_dayselect_value == "30days"){
	   			$rows_all = $rows_30days;
	   		}elseif ($pvs_counter_dayselect_value == "alldays"){
	   			$rows_all = $rows_alldays;
	   		}
   		}else{
   			$rows_all = $rows_schedule;//proversion
   		}
   		
   foreach ($rows_all as $row_all) {
   		array_push($times_all,$row_all->time); array_push($accesses_all,$row_all->total_access); array_push($titles_all,$row_all->title); array_push($urls_all,$row_all->url);
   }
   

   //それぞれの（タイトル）項目を（今日、昨日、7日間、30日間）で取得 
   $times_only = array(); $titles_only = array(); $accesses_only = array(); $urls_only = array(); 
   foreach ($titles_30days as $title_30days) {
   		array_push($times_only,$title_30days->time); array_push($accesses_only,$title_30days->total_access); array_push($titles_only,$title_30days->title); array_push($urls_only,$title_30days->url);
   }
?>

<!-- 左サイド統計 -->
<?php if(!(wp_is_mobile())): ?>
<div style="display:flex;">
<?php endif; ?>
	<div style="margin:0 10px 10px 0;">
	<table style="border:solid #000000 1px;padding:7px;font-size:14px;line-height:160%;text-align:left;">

	<tr valign="top" style="white-space:nowrap;">
		<th width="60" scope="row"><?php _e('Total View', 'post-views-stats-counter' );?></th>
		<td></td>
	</tr>

	<tr valign="top" style="white-space:nowrap;">
		<th width="60" scope="row"><?php _e('Today', 'post-views-stats-counter' );?> :</th>
		<td><?php echo $query_today; ?></td>
	</tr>

	<tr valign="top" style="white-space:nowrap;">
		<th scope="row"><?php _e('Yesterday', 'post-views-stats-counter' );?> :</th>
		<td><?php echo $query_yesterday; ?></td>
	</tr>

	<tr valign="top" style="white-space:nowrap;">
		<th scope="row"><?php _e('7days', 'post-views-stats-counter' );?> :</th>
		<td><?php echo $query_7days; ?></td>
	</tr>

	<tr valign="top" style="white-space:nowrap;">
		<th scope="row"><?php _e('30days', 'post-views-stats-counter' );?> :</th>
		<td><?php echo $query_30days; ?></td>
	</tr>

	</table>
	</div>



	<!-- 右サイド統計 -->
	<div>

	<form method="post" id="protection_copy_form" action="">
		<?php wp_nonce_field( 'Pvs_Counter', '_wpnonce' ); ?>
		
	<table style="border:solid #000000 1px;padding:7px;font-size:14px;line-height:160%;text-align:left;">

	<tr>
		<td>
		<div><span style="font-size:14px;font-weight:bold;"><?php _e('Display - Date , View , Title , URL', 'post-views-stats-counter' );?>&nbsp;&nbsp;<input type="submit" name="Pvs_Counter_save" value="<?php _e('Save to display', 'post-views-stats-counter'); ?>" /></span> <span style="font-weight:nomal;">←<?php _e('This will also save all the parts on this page.', 'post-views-stats-counter' );?></span></div>
		</td>
	</tr>


	<tr valign="top" style="white-space:nowrap;">
		<td>
			<input type="radio" name="pvs_counter_dayselect_value" value="<?php echo (esc_attr("now")); ?>" <?php if($pvs_counter_dayselect_value == "now") echo('checked'); ?> />
				<?php _e('Today', 'post-views-stats-counter' );?><span>&nbsp;&nbsp;</span>
			<input type="radio" name="pvs_counter_dayselect_value" value="<?php echo (esc_attr("yesterday")); ?>" <?php if($pvs_counter_dayselect_value == "yesterday") echo('checked'); ?> />
				<?php _e('Yesterday ', 'post-views-stats-counter' );?><span>&nbsp;&nbsp;</span>
			<input type="radio" name="pvs_counter_dayselect_value" value="<?php echo (esc_attr("7days")); ?>" <?php if($pvs_counter_dayselect_value == "7days") echo('checked'); ?> />
				<?php _e('7days ', 'post-views-stats-counter' );?><span>&nbsp;&nbsp;</span>
			<input type="radio" name="pvs_counter_dayselect_value" value="<?php echo (esc_attr("30days")); ?>" <?php if($pvs_counter_dayselect_value == "30days") echo('checked'); ?> />
				<?php _e('30days ', 'post-views-stats-counter' );?><span>&nbsp;&nbsp;</span>
			<input type="radio" name="pvs_counter_dayselect_value" value="<?php echo (esc_attr("alldays")); ?>" <?php if($pvs_counter_dayselect_value == "alldays") echo('checked'); ?> />
				<?php _e('All days ', 'post-views-stats-counter' );?>

			<select name="pvs_counter_order_value">
				<option value="<?php echo (esc_attr("access")); ?>" <?php if($pvs_counter_order_value == "access") echo('selected'); ?>><?php _e('Order by View', 'post-views-stats-counter' );?></option>
				<option value="<?php echo (esc_attr("time")); ?>" <?php if($pvs_counter_order_value == "time") echo('selected'); ?>><?php _e('Order by Date', 'post-views-stats-counter' );?></option>
			</select>
			
			<select name="pvs_counter_title_value">
				<?php $i=0; ?>
					<option value="<?php echo (esc_attr("all")); ?>" <?php if($pvs_counter_title_value == "all") echo('selected'); ?>><?php _e('Select by All Titles', 'post-views-stats-counter' );?></option>
				<?php foreach($titles_30days as $title_30days): ?>
					<option value="<?php echo (esc_attr($titles_only[$i])); ?>" <?php if($pvs_counter_title_value == $titles_only[$i]) echo('selected'); ?>><?php echo $titles_only[$i]; ?></option>
				<?php $i++; ?>
				<?php endforeach; ?>
			</select>
	    </td>
	</tr>


<!-- proversion from here -->
	<tr valign="top" style="white-space:nowrap;">
		<td>
			<hr>
			<span><?php _e('Check here for selection →', 'post-views-stats-counter' );?></span>
			<input type="checkbox" name="pvs_counter_schedule_check" value="<?php echo (esc_attr(pvs_counter_schedule_check)); ?>" <?php if($pvs_counter_schedule_check == true and $post_views_stats_counter_schedule_on == true) { echo('checked="checked"'); } ?><?php if(!$is_act){ ?>disabled="disabled"<?php } ?> />
			
			<select name="pvs_counter_year_front_value" <?php if(!$is_act){ ?>disabled="disabled"<?php } ?>>
				<?php foreach ($years as $select_years): ?>
				<option value="<?php echo (esc_attr($select_years)); ?>" <?php if($select_years == $pvs_counter_year_front_value) echo('selected'); ?>><?php echo $select_years; ?>
				<?php endforeach; ?>
			</select>


			<select name="pvs_counter_month_front_value" <?php if(!$is_act){ ?>disabled="disabled"<?php } ?>>
				<?php foreach ($months as $select_months): ?>
				<option value="<?php echo (esc_attr($select_months)); ?>" <?php if($select_months == $pvs_counter_month_front_value) echo('selected'); ?>><?php echo $select_months; ?>
				<?php endforeach; ?>
			</select>


			<select name="pvs_counter_day_front_value" <?php if(!$is_act){ ?>disabled="disabled"<?php } ?>>
				<?php foreach ($days as $select_days): ?>
				<option value="<?php echo (esc_attr($select_days)); ?>" <?php if($select_days == $pvs_counter_day_front_value) echo('selected'); ?>><?php echo $select_days; ?>
				<?php endforeach; ?>
			</select>


			<span>to</span>


			<select name="pvs_counter_year_back_value" <?php if(!$is_act){ ?>disabled="disabled"<?php } ?>>
				<?php foreach ($years as $select_years): ?>
				<option value="<?php echo (esc_attr($select_years)); ?>" <?php if($select_years == $pvs_counter_year_back_value) echo('selected'); ?>><?php echo $select_years; ?>
				<?php endforeach; ?>
			</select>


			<select name="pvs_counter_month_back_value" <?php if(!$is_act){ ?>disabled="disabled"<?php } ?>>
				<?php foreach ($months as $select_months): ?>
				<option value="<?php echo (esc_attr($select_months)); ?>" <?php if($select_months == $pvs_counter_month_back_value) echo('selected'); ?>><?php echo $select_months; ?>
				<?php endforeach; ?>
			</select>


			<select name="pvs_counter_day_back_value" <?php if(!$is_act){ ?>disabled="disabled"<?php } ?>>
				<?php foreach ($days as $select_days): ?>
				<option value="<?php echo (esc_attr($select_days)); ?>" <?php if($select_days == $pvs_counter_day_back_value) echo('selected'); ?>><?php echo $select_days; ?>
				<?php endforeach; ?>
			</select>
			
			<?php if(!$is_act){ ?><a href="https://global-s-h.com/shop/product/213/" target="_blank"><?php _e('←Pro version from here!', 'post-views-stats-counter' );?></a><?php } ?>
			<hr>
	    </td>
	</tr>
<!-- proversion from here -->
	
	
	<tr valign="top" style="white-space:nowrap;">
		<td>
		   <?php $i=0; ?>
		   
		   	   <!-- 統計出力 -->
			   <?php foreach($rows_all as $row_all): ?>
			   			 <?php echo $times_all[$i]; ?>
					   	 <span>&nbsp;&nbsp;&nbsp;</span><?php _e('View ', 'post-views-stats-counter' );?><?php echo $accesses_all[$i]; ?>
					   	 <?php echo "&nbsp;&nbsp;&nbsp; $titles_all[$i]"; ?>
					   	 <a href="<?php echo $urls_all[$i] ?>" target="_blank"><?php echo $urls_all[$i]; ?></a>
					   	 <?php echo "<br>"; ?>
					   	 
			       <?php $i++; ?>
			   <?php endforeach; ?>
			   <?php _e('View total ', 'post-views-stats-counter' );?>
			   <?php echo $query_total; ?>
			   
	    </td>
	</tr>

	</table>
	</div>
<?php if(!(wp_is_mobile())): ?>
</div>
<?php endif; ?>

		<fieldset class="options" style="clear:both;">
		<table class="form-table">

			<tr valign="top"> 
				<th width="108" scope="row"><?php _e('Note', 'post-views-stats-counter' );?> :</th> 
				<td><?php _e('View data will be kept even if you deactivate or uninstall the plugin.', 'post-views-stats-counter' );?><br>
				<?php _e('Counts of the view will be differed from the other post view analytics because of the bots that have been ignored.', 'post-views-stats-counter' );?><br>
				<?php _e('※This plugin won`t count the same ip address per page per day.', 'post-views-stats-counter' );?></td> 
			</tr>

			<tr valign="top"> 
				<th width="108" scope="row"><?php _e('Exclude login users', 'post-views-stats-counter' );?> :</th> 
				<td>
				<input type="checkbox" id="pvs_counter_value_user" name="pvs_counter_value_user" value="<?php echo esc_attr(pvs_counter_value_user); ?>" <?php if($pvs_counter_value_user == true) { echo('checked="checked"'); } ?> />
				<?php _e('Yes', 'post-views-stats-counter' ); ?><hr></td> 
			</tr>

			<tr valign="top"> 
				<th width="108" scope="row"><?php _e('Exclude admin user', 'post-views-stats-counter' );?> :</th> 
				<td>
				<input type="checkbox" id="pvs_counter_value_admin" name="pvs_counter_value_admin" value="<?php echo esc_attr(pvs_counter_value_admin); ?>" <?php if($pvs_counter_value_admin == true) { echo('checked="checked"'); } ?> />
				<?php _e('Yes', 'post-views-stats-counter' ); ?><hr></td> 
			</tr>
			
			<tr valign="top"> 
				<th width="108" scope="row" style="white-space:nowrap;"><?php _e('UserAgent to ignore', 'post-views-stats-counter' );?> :</th> 
				<td>
				<select name="pvs_counter_value_user_bots">
				<?php $i=0; ?>
				<option value="Select"><?php _e('Select', 'post-views-stats-counter' ); ?></option>
				<?php foreach($useragent_bot_list as $useragent_bot): ?>
					<option value="<?php echo (esc_attr($useragent_bot)); ?>"><?php echo $useragent_bot; ?></option>
				<?php endforeach; ?>
				</select>
				<br>
				<?php _e('You can exclude UserAgent from the above select area. (Showing 7days accessed UserAgent)', 'post-views-stats-counter' ); ?>
				<br>
				<?php _e('(Able to eliminate bots also from this UserAgent.)', 'post-views-stats-counter' ); ?>
				<br>
				<span style="color:red;"><?php _e('Be careful! Selected UserAgent will erase the view count from all days!! + It will exclude from now on.', 'post-views-stats-counter' ); ?></span>
				
				<br><br>
				<select name="pvs_counter_eliminated_useragent">
				<?php $i=0; ?>
				<option value="Select"><?php _e('Select', 'post-views-stats-counter' ); ?></option>
				<?php foreach($pvs_counter_value_user_bots as $pvs_counter_value_user_bot): ?>
					<option value=<?php echo $i; ?>><?php echo $pvs_counter_value_user_bot; ?></option>
					<?php $i++; ?>
				<?php endforeach; ?>
				</select>
				<br>
				<?php _e('(Above select area is the eliminated UserAgents. You can select to uneliminate the UserAgent. (The past counts won`t recover.)', 'post-views-stats-counter' ); ?>
				<hr></td> 
			</tr>
			
			<tr valign="top"> 
				<th width="108" scope="row"><?php _e('Bots to ignore', 'post-views-stats-counter' );?> :</th> 
				<td>
				<textarea name="pvs_counter_value_admin_bots" cols="50" rows="10"><?php echo $pvs_counter_value_admin_bots; ?></textarea>
				<br>
				<?php _e('You can add bots on the above text area.', 'post-views-stats-counter' ); ?>
				<hr></td> 
			</tr>
			
			<tr valign="top"> 
				<th width="108" scope="row"><?php _e('Reset all data', 'post-views-stats-counter' );?> :</th> 
				<td>
				<input type="checkbox" id="pvs_counter_value_reset" name="pvs_counter_value_reset" value="<?php echo esc_attr(pvs_counter_value_user); ?>" />
				<span style="color:red;"><?php _e('Be careful! All data will be gone inside the database!', 'post-views-stats-counter' ); ?></span><hr></td> 
			</tr>

			
			<tr>
			    <th width="108" scope="row"><?php _e('Save this setting', 'post-views-stats-counter' );?> :</th> 
			    <td>
				<input type="submit" name="Pvs_Counter_save" value="<?php _e(esc_attr('Save', 'post-views-stats-counter' )); ?>" /><br /></td>
		    </tr>
			
		</table>
		</fieldset>
	</form>
	</table>

</div>



<div style="margin-top:60px;">
<?php _e('Please see the explanation of this plugin from here!', 'post-views-stats-counter' );?>
<br />
<a href="https://global-s-h.com/pvs/en/" target="_blank">https://global-s-h.com/pvs/en/</a>

<br><a href="https://wordpress.org/support/plugin/post-views-stats-counter/" target="_blank"> <?php _e('Help page for troubles', 'post-views-stats-counter' );?> </a> | <a href="https://global-s-h.com/wp_protect/en/index.php#donate" target="_blank"> <?php _e('Donate', 'post-views-stats-counter' );?> </a> | 
<br /><br />
<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fwebshakehands&amp;width=285&amp;height=65&amp;show_faces=false&amp;colorscheme=light&amp;stream=false&amp;show_border=false&amp;header=false&amp;" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:305px; height:65px;" allowTransparency="true"></iframe>

</div>