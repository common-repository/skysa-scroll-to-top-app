<?php
/*
Plugin Name: Skysa Scroll-to-Top App
Plugin URI: http://wordpress.org/extend/plugins/skysa-scroll-to-top-app
Description: Adds a Skysa App button for users to quickly scroll to the top of your page.
Version: 1.4
Author: Skysa
Author URI: http://www.skysa.com
*/

/*
*************************************************************
*                 This app was made using the:              *
*                       Skysa App SDK                       *
*    http://wordpress.org/extend/plugins/skysa-app-sdk/     *
*************************************************************
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
MA  02110-1301, USA.
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) exit;

// Skysa App plugins require the skysa-req subdirectory,
// and the index file in that directory to be included.
// Here is where we make sure it is included in the project.
include_once dirname( __FILE__ ) . '/skysa-required/index.php';


// SCROLL TO TOP APP
$GLOBALS['SkysaApps']->RegisterApp(array( 
    'debug' => 1, // 'debug' => 1 for outputting errors, remove this or set to 0 for production
    'id' => '501b41337de22',
    'label' => 'Scroll-to-Top',
	'options' => array(
		'bar_label' => array( // key is the field name
            'label' => 'Button Label',
			'info' => 'What would you like the bar link label name to be?',
			'type' => 'text',
			'value' => '',
			'size' => '30|1'
		),
        'icon' => array(
            'label' => 'Button Icon URL',
            'info' => 'Enter a URL for the an Icon Image. (You can leave this blank for none)',
			'type' => 'image',
			'value' => plugins_url( '/icons/up-icon-wp.png', __FILE__ ),
			'size' => '50|1'
        ),
        'title' => array(
            'label' => 'Tooltip Text',
            'info' => 'Text which displays when the app button is hovered over.',
			'type' => 'text',
			'value' => 'Scroll to Top',
			'size' => '30|1'
        )
	),
    'html' => '<div id="$button_id" class="bar-button SKYUI-menuoff" apptitle="$app_title">$app_icon<span class="label">$app_bar_label</span></div>',
    'js' => "
        S.on('click',function(){
			S.yG.use('yui2-animation',function(){
            var YUI2 = S.yG.YUI2;
            var iebody =(document.compatMode=='CSS1Compat')? document.documentElement : document.body;
	        var scrollt=(iebody.scrollTop)? iebody.scrollTop : window.pageYOffset;
	        scrollt = scrollt || 0;
	        var d = document.createElement('div');
	        var anim = new YUI2.util.Anim(d, {top: { to: 0, from:scrollt}}, 1, YUI2.util.Easing.easeOutStrong);
	        anim.onTween.subscribe(function(){
                var n = d.style.top.replace('px','');
                if(n != ''){
                n = Math.floor(n);
		                window.scroll(0,n);
                }
	        });
	        anim.animate(); 
            S.saveAction('click');
			});
        });
     "
));
?>