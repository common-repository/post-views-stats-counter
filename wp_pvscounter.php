<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/*
Plugin Name: Post Views Stats Counter
Plugin URI: https://global-s-h.com/pvs/en/
Description: This plugin will display how many times post and page viewed. It shows total view of access per day, week, month, and all days. Those view are showed with titles and permalink so that you can keep track of each pages in details. You can ignore bots and useragents. The another merit is that "Most Popular articles" section can be added on to your widget for the users.
Author: Kazuki Yanamoto
Version: 1.1.7
License: GPLv2 or later
*/

class PostViewsStats
{
    public $textdomain = 'post-views-stats-counter';
    public $plugins_url = '';

    public function __construct()
    {
        // プラグインが有効化された時
        if (function_exists('register_activation_hook')) {
            register_activation_hook(__FILE__, array($this, 'pvs_counter_activationHook'));
        }
        
        //無効化
        if (function_exists('register_deactivation_hook')) {
            register_deactivation_hook(__FILE__, array($this, 'pvs_counter_deactivationHook'));
        }
        //アンインストール
        if (function_exists('register_uninstall_hook')) {
            register_uninstall_hook(__FILE__, array($this, 'pvs_counter_uninstallHook'));
        }

        //footer()のフック
        add_filter('wp_footer', array($this, 'pvs_counter_filter_footer'));

        //init
        add_action('init', array($this, 'pvs_counter_init'));

        //ローカライズ
        add_action('init', array($this, 'pvs_counter_load_textdomain'));

        //管理画面について
        add_action('admin_menu', array($this, 'pvs_counter_admin_menu'));
    }


    /**
     * init
     */
     public function pvs_counter_init()
     {
         $this->plugins_url = untrailingslashit(plugins_url('', __FILE__));
     }


    /***
     * ローカライズ
    ***/
    public function pvs_counter_load_textdomain()
    {
        load_plugin_textdomain('post-views-stats-counter', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }


	/**
	* プラグインが有効化された時
	*
	*/
	public function pvs_counter_activationHook()
	{
		//オプションを初期値

		global $jal_db_version;
		$jal_db_version = '1.0';

		  global $wpdb;
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

			
			//右サイド統計日付の初期値
	        if (! get_option('pvs_counter_dayselect_value')) {
	            update_option('pvs_counter_dayselect_value', 'now');
	        }
	        if (! get_option('pvs_counter_order_value')) {
	            update_option('pvs_counter_order_value', 'access');
	        }
	        if (! get_option('pvs_counter_title_value')) {
	            update_option('pvs_counter_title_value', 'all');
	        }
	        
			//ユーザー（デフォルトはログインユーザーは除く）
	        if (! get_option('pvs_counter_value_user')) {
	            update_option('pvs_counter_value_user', false);
	        }
	        
	        //ユーザー（デフォルトはアドミンユーザーは除く）
	        if (! get_option('pvs_counter_value_admin')) {
	            update_option('pvs_counter_value_admin', false);
	        }
	        //データリセットの初期値はfalse
	        if (! get_option('pvs_counter_value_reset')) {
	            update_option('pvs_counter_value_reset', false);
	        }
	        
	        //eliminated useragentの配列初期値登録
	        if (! get_option('pvs_counter_value_user_bots')) {
	            update_option('pvs_counter_value_user_bots', array());
	        }
	        
	        //botデータ
			$bot = array("findlinks\ngooblog\nichiro\nbot\nspider\nsearch\ncrawler\nask.com\nvalidator\nsnoopy\nsuchen.de\nsuchbaer.de\nshelob\nsemager\nxenu\nsuch_de\nia_archiver\nMicrosoft URL Control\nnetluchs\nUnwindFetchor\nPostRank\nCrowsnest\nlarbin\nJS-Kit\ntwieve\nHatena::BookmarkAcoon\nJakarta Commons\nMetaURI API\nWWW-Mechanize\nfacebookexternalhit\nbutterfly\nFlipboardProxy\nGooglebot-Image\nYahoo-MMCrawler\nBaiduspider\ne-SocietyRobot\nBaiduImagespiderYeti\nGooglebot\nICC-Crawler\ne-SocietyRobot\nSteeler\nTeoma\nBaiduspider\nYodaoBot\nTurnitinBot\nBecomeJPBot\nBecomeBot");
	        if (! get_option('pvs_counter_value_admin_bots')) {
	            update_option('pvs_counter_value_admin_bots', $bot[0]);
	        }
	        
	        //proversion
	        		//選択チェックボックス
	        		if (! get_option('pvs_counter_schedule_check')) {
			            update_option('pvs_counter_schedule_check', false);
			        }
	        		
	        		//今の年の取得
					$current_year_pro_front = current_time('Y');//大文字にすると2019の20まで入る
					$current_year_pro_back = current_time('Y');
					//今の月の取得
					$current_month_pro_front = current_time('m');
					$current_month_pro_back = current_time('m');
					//今の日の取得
					$current_day_pro_front = current_time('d');
					$current_day_pro_back = current_time('d');
	        		
	        		//年登録front
			        if (! get_option('pvs_counter_year_front_value')) {
			            update_option('pvs_counter_year_front_value', $current_year_pro_front);
			        }
			        //月登録front
			        if (! get_option('pvs_counter_month_front_value')) {
			            update_option('pvs_counter_month_front_value', $current_month_pro_front);
			        }
			        //日登録front
			        if (! get_option('pvs_counter_day_front_value')) {
			            update_option('pvs_counter_day_front_value', $current_day_pro_front);
			        }
			        
	        		//年登録back
			        if (! get_option('pvs_counter_year_back_value')) {
			            update_option('pvs_counter_year_back_value', $current_year_pro_back);
			        }
			        //月登録back
			        if (! get_option('pvs_counter_month_back_value')) {
			            update_option('pvs_counter_month_back_value', $current_month_pro_back);
			        }
			        //日登録back
			        if (! get_option('pvs_counter_day_back_value')) {
			            update_option('pvs_counter_day_back_value', $current_day_pro_back);
			        }
			//proversion
	}


    /***
     * アンインストール時
    ***/
    public function pvs_counter_uninstallHook()
    {
        delete_option('pvs_counter_dayselect_value');
        delete_option('pvs_counter_order_value');
        delete_option('pvs_counter_title_value');
        delete_option('pvs_counter_value_user');
        delete_option('pvs_counter_value_admin');
        delete_option('pvs_counter_value_reset');
        delete_option('pvs_counter_value_admin_bots');
        //proversion
        delete_option('pvs_counter_schedule_check');
        delete_option('pvs_counter_year_front_value');
        delete_option('pvs_counter_month_front_value');
        delete_option('pvs_counter_day_front_value');
        delete_option('pvs_counter_year_back_value');
        delete_option('pvs_counter_month_back_value');
        delete_option('pvs_counter_day_back_value');
    }
    
    
    /***
     * 無効化時
    ***/
    public function pvs_counter_deactivationHook()
    {
        delete_option('pvs_counter_dayselect_value');
        delete_option('pvs_counter_order_value');
        delete_option('pvs_counter_title_value');
        delete_option('pvs_counter_value_user');
        delete_option('pvs_counter_value_admin');
        delete_option('pvs_counter_value_reset');
        delete_option('pvs_counter_value_admin_bots');
        //proversion
        delete_option('pvs_counter_schedule_check');
        delete_option('pvs_counter_year_front_value');
        delete_option('pvs_counter_month_front_value');
        delete_option('pvs_counter_day_front_value');
        delete_option('pvs_counter_year_back_value');
        delete_option('pvs_counter_month_back_value');
        delete_option('pvs_counter_day_back_value');
    }


    /***
     * 管理画面
    ***/
    public function pvs_counter_admin_menu()
    {
        add_options_page(
            'Post Views Stats Counter', 
            __('View & Settings for Post Views Stats', 'post-views-stats-counter'), 
            'manage_options',
            'post_views_stats_admin_menu',
            array($this, 'pvs_counter_edit_setting')
        );
    }


    /***
     * 管理画面を表示
    ***/
    public function pvs_counter_edit_setting()
    {
        // Include the settings page
        include(sprintf("%s/manage/admin.php", dirname(__FILE__)));
    }


	/***
	* footerの処理
	***/
	public function pvs_counter_filter_footer()
	{
			
	//日付の取得

	//現在の年月日を取得
	        $current_year = current_time('Y');//大文字にすると2019の20まで入る
	        $current_month = current_time('m');
	        $current_day = current_time('d');
			$current_now = current_time("Y-m-d");
			$current_yesterday = date( 'Y-m-d', strtotime( '-1 days', current_time('timestamp') ) );
			$current_week = date( 'Y-m-d', strtotime( '-7 days', current_time('timestamp') ) );
	//ip addressとuseragentの取得	
			$ua = $_SERVER['HTTP_USER_AGENT'];
			$ip = $_SERVER['REMOTE_ADDR'];
			
	//bot判定
	function pvs_counter_is_bot() {
	    // ボットのUAに含まれる文字列
	    $pvs_bots = get_option('pvs_counter_value_admin_bots');
	    $pvs_bots = (explode("\n", $pvs_bots));
	    $pvs_bots = array_map('trim', $pvs_bots);
	    
	    
	    // UAがボットに一致するかどうか
	    $ua = $_SERVER['HTTP_USER_AGENT'];
	    foreach( $pvs_bots as $pvs_bot ) {
	        if (stripos( $ua, $pvs_bot ) !== false) {
	            $bot = 1;
	            return $bot;
	    	}
	    }
	}
	//登録されたボット判定
	function pvs_counter_is_register_bot() {
	    $pvs_bots_register = get_option('pvs_counter_value_user_bots');
	    $pvs_bots_register = array_map('trim', $pvs_bots_register);
	    //print_r(get_option('pvs_counter_value_user_bots'));
	    $ua = $_SERVER['HTTP_USER_AGENT'];
	    
		foreach( $pvs_bots_register as $pvs_bot_register ) {
	        if ( strval($ua) === $pvs_bot_register ) {
	            $register_bot = 1;
	            return $register_bot;
	    	}
	    }
	}
	
	
	//テーブル名にはプリフィックスを必ず付ける（wp-includes内:wp-db.phpのvar $tablesでも可）
	global $wpdb;
	$table_name_pvs_counter = $wpdb->prefix . 'pvs_counter';


	//データベースに内容を追加
		$pvs_stop = false;
		// Botだったらストップ
		if(pvs_counter_is_bot() == 1){$pvs_stop = true;}
		if(pvs_counter_is_register_bot() == 1){$pvs_stop = true;}
		// タイトルが空のページだったらストップ
		if(get_the_title() === ''){$pvs_stop = true;}
		if(get_bloginfo('name') === ''){$pvs_stop = true;}
		// ログインユーザーだったら
	 	if(!is_user_logged_in() || get_option('pvs_counter_value_user') == false){ 
	 	// 管理者だったら
	 	if(!current_user_can('administrator') || get_option('pvs_counter_value_admin') == false){ 
			
		
			if(is_front_page()){
				$post_id = 0;
			}else{
				$post_id = get_the_ID();
				// is_home()だったらストップ
				if(is_home()){$pvs_stop = true;}
				if(is_category()){$pvs_stop = true;}
				if(is_archive()){$pvs_stop = true;}
			}
			
			
				//データベースの内容を今日とpostidであれば引き出す
				$query = $wpdb->prepare("SELECT * FROM $table_name_pvs_counter WHERE pageid=%d AND time='%s'" , $post_id , $current_now);
				$rows = $wpdb->get_results($query);
			
				//データベースの内容を全日数のpostidであれば引き出す
				$postid_query = $wpdb->prepare("SELECT * FROM $table_name_pvs_counter WHERE pageid=%d" , $post_id);
				$postid_rows = $wpdb->get_results($postid_query);
				
				 
			  	  
			  	  if(is_front_page()){
			  	  	   if(!(get_bloginfo('name') === '')){
				  	  	  // 全タイトルとURLを変更
					  	  foreach($postid_rows as $postid_row) {
							  if($postid_row->title !== get_bloginfo('name') or $postid_row->url !== site_url()){
									$wpdb->update(
										$table_name_pvs_counter,
										array( 
										'title' => get_bloginfo('name'),
										'url' => site_url()),
										array( 
										'pageid' => $post_id )
									);
						}	  }

						  }
				  }else{
					  // 全タイトルとURLを変更
					  if(!(get_the_title() === '')){
					  	  foreach($postid_rows as $postid_row) {
							  if($postid_row->title !== get_the_title() or $postid_row->url !== get_permalink()){
									$wpdb->update(
										$table_name_pvs_counter,
										array( 
										'title' => get_the_title(),
										'url' => get_permalink()),
										array( 
										'pageid' => $post_id )
									);
							  }
						  }
					  }
				  }
						  
		
			  //データベース登録
			  	  //トップページだったら
			  	  if(is_front_page()){
				  	  //今日のipアドレスとタイトルが同じ（ipが同じ2回目の登録の場合は除去）
					  foreach($rows as $row) {
						  		if($row->title == get_bloginfo('name') and $row->ipaddress == $ip){
						  		$pvs_stop == true;
							return $pvs_stop;
					  		}
					  }
				  //トップページ以外だったら
				  }else{
				  	  //今日のipアドレスとタイトルが同じ（ipが同じ2回目の登録の場合は除去）
					  foreach($rows as $row) {
						  		if($row->title == get_the_title() and $row->ipaddress == $ip){
						  		$pvs_stop == true;
							return $pvs_stop;
					  		}
					  }
				  }
							  if(!($pvs_stop == true)){
									  if(is_front_page()){
										  $wpdb->insert(
										    $table_name_pvs_counter,
										    array(
										      'time' => $current_now,
										      'title' => get_bloginfo('name'),
										      'url' => site_url(),
										      'access' => 1,
										      'pageid' => 0,
										      'ipaddress' => $ip,
										      'useragent' => $ua
										    )
										  );
									  }else{
										  $wpdb->insert(
										    $table_name_pvs_counter,
										    array(
										      'time' => $current_now,
										      'title' => get_the_title(),
										      'url' => get_permalink(),
										      'access' => 1,
										      'pageid' => get_the_ID(),
										      'ipaddress' => $ip,
										      'useragent' => $ua
										    )
										  );
									  }
							   }
					 
			
			}
		}
		}
		
}
$PostViewsStats = new PostViewsStats();


//Widgetを登録する
function wp_pvs_most_popular($number_post) { 
	ob_start();
	// Include the most post page
    include(sprintf("%s/wp_mostpost.php", dirname(__FILE__)));
	$out1 = ob_get_contents();
	ob_end_clean();	
	echo $out1;
}

class My_Widget extends  WP_Widget{
	
	function __construct() {
		parent::__construct(
			'my_widget', // Base ID
			'Post View : Most Popular', // Name
			array( 'description' => 'Displays the most popular posts', ) // Args
		);
	}

	public function widget( $args, $instance ) {
 		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$number_post = $instance['number_post'];
		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		echo wp_pvs_most_popular($number_post);
		echo $after_widget;
	}
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number_post'] = strip_tags( $new_instance['number_post'] );
		return $instance;
	}

	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Most Popular Articles' );
		}
		if ( isset( $instance[ 'number_post' ] ) ) {
			$number_post = $instance[ 'number_post' ];
		}
		else {
			$number_post = 5;
		}
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'post-views-stats-counter' );?></label> <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /><br /><br />
		<label for="<?php echo $this->get_field_id( 'number_post' ); ?>"><?php _e('Number of post:', $this->textdomain );?></label> <input class="widefat" id="<?php echo $this->get_field_id( 'number_post' ); ?>" name="<?php echo $this->get_field_name( 'number_post' ); ?>" type="text" value="<?php echo esc_attr( $number_post ); ?>" /></p>
		<?php
		//class widefat=横幅いっぱいまで
	}
}

add_action( 'widgets_init', function () {
	register_widget( 'My_Widget' );  //WidgetをWordPressに登録する
} );