<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */
 
 

function optionsframework_option_name() {

	// 从样式表获取主题名称
	$themename = wp_get_theme();
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  请阅读:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {
	// 测试数据
	$test_array = array(
		'one' => __('1', 'options_framework_theme'),
		'two' => __('2', 'options_framework_theme'),
		'three' => __('3', 'options_framework_theme'),
		'four' => __('4', 'options_framework_theme'),
		'five' => __('5', 'options_framework_theme'),
		'six' => __('6', 'options_framework_theme'),
		'seven' => __('7', 'options_framework_theme')
	);
		

	// 复选框数组
	$multicheck_array = array(
		'one' => __('法国吐司', 'options_framework_theme'),
		'two' => __('薄煎饼', 'options_framework_theme'),
		'three' => __('煎蛋', 'options_framework_theme'),
		'four' => __('绉绸', 'options_framework_theme'),
		'five' => __('感化饼干', 'options_framework_theme')
	);

	// 复选框默认值
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// 背景默认值
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// 版式默认值
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );
		
	// 版式设置选项
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => '普通','bold' => '粗体' ),
		'color' => false
	);

	// 将所有分类（categories）加入数组
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// 将所有标签（tags）加入数组
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// 将所有页面（pages）加入数组
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// 如果使用图片单选按钮, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	$options = array();

	//基本设置
	$options[] = array(
		'name' => __('基本设置', 'options_framework_theme'),
		'type' => 'heading');
	
	$options[] = array(
        'name' => __("主题风格", 'akina'),
        'id' => 'theme_skin',
        'std' => "#FE9600",
        'desc' => __('自定义主题颜色', ''),
        'type' => "color"
    );
		
	$options[] = array(
		'name' => __('logo', 'options_framework_theme'),
		'desc' => __('最佳高度尺寸40px。', 'options_framework_theme'),
		'id' => 'akina_logo',
		'type' => 'upload');	
	
	$options[] = array(
		'name' => __('自定义关键词和描述', 'options_framework_theme'),
		'desc' => __('开启之后可自定义填写关键词和描述', 'options_framework_theme'),
		'id' => 'akina_meta',
		'std' => '0',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('网站关键词', 'options_framework_theme'),
		'desc' => __('各关键字间用半角逗号","分割，数量在5个以内最佳。', 'options_framework_theme'),
		'id' => 'akina_meta_keywords',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('网站描述', 'options_framework_theme'),
		'desc' => __('用简洁的文字描述本站点，字数建议在120个字以内。', 'options_framework_theme'),
		'id' => 'akina_meta_description',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('一直显示导航菜单', 'options_framework_theme'),
		'desc' => __('勾选开启，默认收缩', 'options_framework_theme'),
		'id' => 'shownav',
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('头部装饰图', 'options_framework_theme'),
		'desc' => __('默认开启，勾选关闭，显示在文章页面，独立页面以及分类页', 'options_framework_theme'),
		'id' => 'patternimg',
		'std' => '0',
		'type' => 'checkbox');

	/*$options[] = array(
		'name' => __('导航菜单靠左显示', 'options_framework_theme'),
		'id' => 'shownav_left',
		'std' => "yes",
		'type' => "radio",
		'options' => array(
			'yes' => __('开启', ''),
			'no' => __('关闭', '')
		));	*/	
	
	$options[] = array(
		'name' => __('顶部搜索按钮', 'akina'),
		'id' => 'top_search',
		'std' => "yes",
		'type' => "radio",
		'options' => array(
			'yes' => __('开启', ''),
			'no' => __('关闭', '')
		));

	$options[] = array(
		'name' => __('首页列表特色图样式', 'akina'),
		'id' => 'list_type',
		'std' => "round",
		'type' => "radio",
		'options' => array(
			'round' => __('圆形', ''),
			'square' => __('方形', '')
		));	
		
	$options[] = array(
		'name' => __('评论收缩', 'akina'),
		'id' => 'toggle-menu',
		'std' => "yes",
		'type' => "radio",
		'options' => array(
			'yes' => __('开启', ''),
			'no' => __('关闭', '')
		));	
		
	$options[] = array(
		'name' => __('分页模式', 'akina'),
		'id' => 'pagenav_style',
		'std' => "ajax",
		'type' => "radio",
		'options' => array(
			'ajax' => __('ajax加载', ''),
			'np' => __('上一页和下一页', '')
		));

	$options[] = array(
		'name' => __('博主描述', 'options_framework_theme'),
		'desc' => __('一段自我描述的话', 'options_framework_theme'),
		'id' => 'admin_des',
		'std' => '公交车司机终于在众人的指责中将座位让给了老太太',
		'type' => 'textarea');	

	$options[] = array(
		'name' => __('页脚信息', 'options_framework_theme'),
		'desc' => __('页脚说明文字，支持HTML代码', 'options_framework_theme'),
		'id' => 'footer_info',
		'std' => '&copy; 2016',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('站长统计', 'options_framework_theme'),
		'desc' => __('填写统计代码，将被隐藏，如需要在下方填写链接地址', 'options_framework_theme'),
		'id' => 'site_statistics',
		'std' => '',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('站长统计后台地址', 'options_framework_theme'),
		'desc' => __('填写查看统计数据的链接地址', 'options_framework_theme'),
		'id' => 'site_statistics_link',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('网站地图地址', 'options_framework_theme'),
		'desc' => __('Sitemap生成的地图链接', 'options_framework_theme'),
		'id' => 'site_map_link',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('自定义CSS样式', 'options_framework_theme'),
		'desc' => __('直接填写CSS，不需要写style标签', 'options_framework_theme'),
		'id' => 'site_custom_style',
		'std' => '',
		'type' => 'textarea');		

		
	//第一屏
	$options[] = array(
		'name' => __('第一屏', 'options_framework_theme'),
		'type' => 'heading');
		
	$options[] = array(
		'name' => __('总开关', 'options_framework_theme'),
		'desc' => __('默认开启，勾选关闭', 'options_framework_theme'),
		'id' => 'head_focus',
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('社交信息', 'options_framework_theme'),
		'desc' => __('默认开启，勾选关闭，显示头像、签名、SNS', 'options_framework_theme'),
		'id' => 'focus_infos',
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('全屏显示', 'options_framework_theme'),
		'desc' => __('默认开启，勾选关闭', 'options_framework_theme'),
		'id' => 'focus_height',
		'std' => '0',
		'type' => 'checkbox'); 	
	
	$options[] = array(
		'name' => __('背景图', 'options_framework_theme'),
		'desc' => __('高度尺寸1920*1080', 'options_framework_theme'),
		'id' => 'focus_img',
		'type' => 'upload'); 
		
	 $options[] = array(
		'name' => __('个人头像', 'options_framework_theme'),
		'desc' => __('最佳高度尺寸130px。', 'options_framework_theme'),
		'id' => 'focus_logo',
		'type' => 'upload');

	 $options[] = array(
		'name' => __('开启视频', 'options_framework_theme'),
		'desc' => __('勾选开启', 'options_framework_theme'),
		'id' => 'focus_amv',
		'std' => '0',
		'type' => 'checkbox');

	 $options[] = array(
		'name' => __('Video Live', 'options_framework_theme'),
		'desc' => __('勾选开启，视频自动续播，需要开启Pjax功能', 'options_framework_theme'),
		'id' => 'focus_mvlive',
		'std' => '0',
		'type' => 'checkbox');

	 $options[] = array(
		'name' => __('视频地址', 'options_framework_theme'),
		'desc' => __('视频的来源地址，该地址拼接下面的视频名，地址尾部不需要加斜杠', 'options_framework_theme'),
		'id' => 'amv_url',
		'std' => '',
		'type' => 'text');

	 $options[] = array(
		'name' => __('视频名称', 'options_framework_theme'),
		'desc' => __('abc.mp4 ，只需要填写视频名称 abc 即可，多个用英文逗号隔开如 abc,efg ，无需在意顺序，因为加载是随机的抽取的 ', 'options_framework_theme'),
		'id' => 'amv_title',
		'std' => '',
		'type' => 'text');
			
		
	//文章页
	$options[] = array(
		'name' => __('文章页', 'options_framework_theme'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('文章点赞', 'akina'),
		'id' => 'post_like',
		'std' => "yes",
		'type' => "radio",
		'options' => array(
			'yes' => __('开启', ''),
			'no' => __('关闭', '')
		));	
		
	$options[] = array(
		'name' => __('文章分享', 'akina'),
		'id' => 'post_share',
		'std' => "yes",
		'type' => "radio",
		'options' => array(
			'yes' => __('开启', ''),
			'no' => __('关闭', '')
		));	
	
	$options[] = array(
		'name' => __('上一篇下一篇', 'akina'),
		'id' => 'post_nepre',
		'std' => "yes",
		'type' => "radio",
		'options' => array(
			'yes' => __('开启', ''),
			'no' => __('关闭', '')
		));	
		
	$options[] = array(
		'name' => __('博主信息', 'akina'),
		'id' => 'author_profile',
		'std' => "yes",
		'type' => "radio",
		'options' => array(
			'yes' => __('开启', ''),
			'no' => __('关闭', '')
		));	

		
	//社交选项
	$options[] = array(
		'name' => __('社交网络', 'options_framework_theme'),
		'type' => 'heading');	
	
	$options[] = array(
		'name' => __('微信', 'options_framework_theme'),
		'desc' => __('微信二维码', 'options_framework_theme'),
		'id' => 'wechat',
		'type' => 'upload');
	
    $options[] = array(
		'name' => __('新浪微博', 'options_framework_theme'),
		'desc' => __('新浪微博地址', 'options_framework_theme'),
		'id' => 'sina',
		'std' => '',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('腾讯QQ', 'options_framework_theme'),
		'desc' => __('QQ号码', 'options_framework_theme'),
		'id' => 'qq',
		'std' => '',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('QQ空间', 'options_framework_theme'),
		'desc' => __('QQ空间地址', 'options_framework_theme'),
		'id' => 'qzone',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('GitHub', 'options_framework_theme'),
		'desc' => __('GitHub地址', 'options_framework_theme'),
		'id' => 'github',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Lofter', 'options_framework_theme'),
		'desc' => __('lofter地址', 'options_framework_theme'),
		'id' => 'lofter',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('BiliBili', 'options_framework_theme'),
		'desc' => __('B站地址', 'options_framework_theme'),
		'id' => 'bili',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('优酷视频', 'options_framework_theme'),
		'desc' => __('优酷地址', 'options_framework_theme'),
		'id' => 'youku',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('网易云音乐', 'options_framework_theme'),
		'desc' => __('网易云音乐地址', 'options_framework_theme'),
		'id' => 'wangyiyun',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Twitter', 'options_framework_theme'),
		'desc' => __('推特地址', 'options_framework_theme'),
		'id' => 'twitter',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Facebook', 'options_framework_theme'),
		'desc' => __('脸书地址', 'options_framework_theme'),
		'id' => 'facebook',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Google+', 'options_framework_theme'),
		'desc' => __('G+地址', 'options_framework_theme'),
		'id' => 'googleplus',
		'std' => '',
		'type' => 'text');

		
	//聚焦图链
	$options[] = array(
		'name' => __('聚焦图', 'options_framework_theme'),
		'type' => 'heading' );

	$options[] = array(
		'name' => __('是否开启聚焦', 'options_framework_theme'),
		'desc' => __('默认开启', 'options_framework_theme'),
		'id' => 'top_feature',
		'std' => '1',
		'type' => 'checkbox');	

	$options[] = array(
		'name' => __('聚焦标题', 'options_framework_theme'),
		'desc' => __('默认为聚焦，你也可以修改为其他，当然不能当广告用！不允许！！', 'options_framework_theme'),
		'id' => 'feature_title',
		'std' => '聚焦',
		'class' => 'mini',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('聚焦图一', 'options_framework_theme'),
		'desc' => __('尺寸257px*160px', 'options_framework_theme'),
		'id' => 'feature1_img',
		'std' => $imagepath.'/temp.jpg',
		'type' => 'upload');

	$options[] = array(
		'name' => __('聚焦图一标题', 'options_framework_theme'),
		'desc' => __('聚焦图一标题', 'options_framework_theme'),
		'id' => 'feature1_title',
		'std' => 'feature1',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('聚焦图一链接', 'options_framework_theme'),
		'desc' => __('聚焦图一链接', 'options_framework_theme'),
		'id' => 'feature1_link',
		'std' => '#',
		'type' => 'text');		
		
	$options[] = array(
		'name' => __('聚焦图二', 'options_framework_theme'),
		'desc' => __('尺寸257px*160px', 'options_framework_theme'),
		'id' => 'feature2_img',
		'std' => $imagepath.'/temp.jpg',
		'type' => 'upload');

	$options[] = array(
		'name' => __('聚焦图二标题', 'options_framework_theme'),
		'desc' => __('聚焦图二标题', 'options_framework_theme'),
		'id' => 'feature2_title',
		'std' => 'feature2',
		'type' => 'text');

	$options[] = array(
		'name' => __('聚焦图二链接', 'options_framework_theme'),
		'desc' => __('聚焦图二链接', 'options_framework_theme'),
		'id' => 'feature2_link',
		'std' => '#',
		'type' => 'text');
			
	$options[] = array(
		'name' => __('聚焦图三', 'options_framework_theme'),
		'desc' => __('尺寸257px*160px', 'options_framework_theme'),
		'id' => 'feature3_img',
		'std' => $imagepath.'/temp.jpg',
		'type' => 'upload');

	$options[] = array(
		'name' => __('聚焦图三标题', 'options_framework_theme'),
		'desc' => __('聚焦图三标题', 'options_framework_theme'),
		'id' => 'feature3_title',
		'std' => 'feature3',
		'type' => 'text');	

	$options[] = array(
		'name' => __('聚焦图三链接', 'options_framework_theme'),
		'desc' => __('聚焦图三链接', 'options_framework_theme'),
		'id' => 'feature3_link',
		'std' => '#',
		'type' => 'text');
	

	//其他
	$options[] = array(
		'name' => __('其他', 'options_framework_theme'),
		'type' => 'heading' );

	$options[] = array(
		'name' => __('开启PJAX局部刷新', 'options_framework_theme'),
		'desc' => __('原理与Ajax相同', 'options_framework_theme'),
		'id' => 'poi_pjax',
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('开启公告', 'options_framework_theme'),
		'desc' => __('默认不显示，勾选开启', 'options_framework_theme'),
		'id' => 'head_notice',
		'std' => '0',
		'type' => 'checkbox');	

	$options[] = array(
		'name' => __('公告内容', 'options_framework_theme'),
		'desc' => __('公告内容，文字超出142个字节将会被滚动显示（移动端无效），一个汉字 = 3字节，一个字母 = 1字节，自己计算吧', 'options_framework_theme'),
		'id' => 'notice_title',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('首页不显示的分类文章', 'options_framework_theme'),
		'desc' => __('填写分类ID，多个用英文“ , ”分开', 'options_framework_theme'),
		'id' => 'classify_display',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('图片展示分类', 'options_framework_theme'),
		'desc' => __('填写分类ID，多个用英文“ , ”分开', 'options_framework_theme'),
		'id' => 'image_category',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('允许私密评论', 'options_framework_theme'),
		'desc' => __('允许用户设置自己的评论对其他人不可见', 'options_framework_theme'),
		'id' => 'open_private_message',
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('开启多说插件支持', 'options_framework_theme'),
		'desc' => __('如果使用多说插件，请勾选此项', 'options_framework_theme'),
		'id' => 'general_disqus_plugin_support',
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('开启Prism代码高亮支持', 'options_framework_theme'),
		'desc' => __('仅支持Prism.js的高亮插件，如果你用使用该插件且开启了Pjax，请勾选此项，这不是插件功能，只是帮助插件JS文件进入Pjax重载', 'options_framework_theme'),
		'id' => 'open_prism_codelamp',
		'std' => '0',
		'type' => 'checkbox');	
		
	$options[] = array(
		'name' => __('七牛图片cdn', 'options_framework_theme'),
		'desc' => __('！重要:填写格式为 http://你的二级域名（七牛三级域名）/wp-content/uploads', 'options_framework_theme'),
		'id' => 'qiniu_cdn',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('登陆界面背景图', 'options_framework_theme'),
		'desc' => __('该地址为空则使用默认图片，或者在下方设置必应图片。', 'options_framework_theme'),
		'id' => 'login_bg',
		'type' => 'upload');

	$options[] = array(
		'name' => __('登陆界面背景图（ 必应美图 1920*1080 ）', 'options_framework_theme'),
		'desc' => __('勾选开启，请移除当前设置的图片，否则不会生效。', 'options_framework_theme'),
		'id' => 'login_bg_bing',
		'std' => '0',
		'type' => 'checkbox');

	//前台登录
	$options[] = array(
		'name' => __('前台登录', 'options_framework_theme'),
		'type' => 'heading' );

	$options[] = array(
		'name' => __('指定登录地址', 'options_framework_theme'),
		'desc' => __('强制不使用后台地址登陆，填写新建的登陆页面地址，比如 http://www.xxx.com/login ', 'options_framework_theme'),
		'id' => 'exlogin_url',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('指定注册地址', 'options_framework_theme'),
		'desc' => __('该链接使用在登录页面作为注册入口，建议填写', 'options_framework_theme'),
		'id' => 'exregister_url',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('允许用户注册', 'options_framework_theme'),
		'desc' => __('勾选开启，允许用户在前台注册', 'options_framework_theme'),
		'id' => 'ex_register_open',
		'std' => '0',
		'type' => 'checkbox');	

	$options[] = array(
		'name' => __('登录后自动跳转', 'options_framework_theme'),
		'desc' => __('勾选开启，管理员跳转至后台，用户跳转至主页', 'options_framework_theme'),
		'id' => 'login_urlskip',
		'std' => '0',
		'type' => 'checkbox');	

	return $options;
}