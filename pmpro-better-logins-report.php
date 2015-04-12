<?php
/*
Plugin Name: PMPro Better Logins Report
Plugin URI: http://www.paidmembershipspro.com/wp/pmpro-better-logins-report/
Description: Adds login, view, and visit stats for "thisweek" and "year to date".
Version: .1
Author: Stranger Studios
Author URI: http://www.strangerstudios.com
*/

require_once(dirname(__FILE__) . "/reports/better-logins.php");

function pmproblr_init()
{
	//remove the default login report
	global $pmpro_reports;
	unset($pmpro_reports['login']);
	
	//some functions we might need
	if(!function_exists('pmpro_isDateThisWeek'))
	{
		function pmpro_isDateThisWeek($str)
		{
			$now = current_time('timestamp');
			$this_week = intval(date("W", $now));
			$this_year = intval(date("Y", $now));

			$date = strtotime($str, $now);
			$date_week = intval(date("W", $date));
			$date_year = intval(date("Y", $date));

			if($date_week === $this_week && $date_year === $this_year)
				return true;
			else
				return false;
		}
	}
		
	if(!function_exists('pmpro_isDateThisYear'))
	{
		function pmpro_isDateThisYear($str)
		{
			$now = current_time('timestamp');
			$this_year = intval(date("Y", $now));

			$date = strtotime($str, $now);
			$date_year = intval(date("Y", $date));

			if($date_year === $this_year)
				return true;
			else
				return false;
		}
	}
}
add_action('init', 'pmproblr_init');

/*
	When first installing this plugin, the view/visits/logins reporting options
	won't have elements that this plugin will be expecting.
	
	This function fixes them.
*/
function pmproblr_fixOptions($option)
{
	$now = current_time('timestamp');

	if(!isset($option['week']))
		$option['week'] = 0;
	if(!isset($option['thisweek']))
		$option['thisweek'] = date('W', $now);
	
	if(!isset($option['ytd']))
		$option['ytd'] = 0;
	if(!isset($option['thisyear']))
		$option['thisyear'] = date('Y', $now);
		
	return $option;
}