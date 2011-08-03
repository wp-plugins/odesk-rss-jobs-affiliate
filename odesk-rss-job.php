<?php
/*
Plugin Name: Odesk RSS Jobs Affiliate
Plugin URI: http://reygcalantaol.com/odesk-rss-job-affiliate
Description: This plugin display configuration page and widget to display list of odesk job listing via commision junction affiliate to earn commision once someone click the job link and got hired. If you find this plugin useful, please consider making a small donation to help this maintained and free to everyone.<br /><a href="http://reygcalantaol.com/php-asp-programmer-donation">Click here to donate.</a>
Version: 0.1.0
Author: Rey Calanta-ol
Author URI: http://reygcalantaol.com
License: GPL2

Copyright 2011 Odesk Profile Fetcher  (email : reygcalantaol@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


//Job Category List
global $categories;
$categories[] = array('Web Development', 'Software Development', 'Networking and Information Systems', 'Writing and Translation',  'Administrative Support', 'Design and Multimedia', 'Customer Service', 'Sales and Marketing', 'Business Services');

if (isset($_POST['odesk_rss_cjid'])) {
	update_option('odesk_rss_cjid', $_POST['odesk_rss_cjid'], ' ', 'yes');
	update_option('odesk_rss_keyword', $_POST['odesk_rss_keyword'], ' ', 'yes');
	update_option('odesk_rss_jobcat', $_POST['odesk_rss_jobcat'], ' ', 'yes');
	update_option('odesk_rss_subcat', $_POST['odesk_rss_subcat'], ' ', 'yes');
	update_option('odesk_rss_jobtype', $_POST['odesk_rss_jobtype'], ' ', 'yes');
	update_option('odesk_rss_min', $_POST['odesk_rss_min'], ' ', 'yes');
	update_option('odesk_rss_max', $_POST['odesk_rss_max'], ' ', 'yes');
	update_option('odesk_rss_hrsperweek', $_POST['odesk_rss_hrsperweek'], ' ', 'yes');
	update_option('odesk_rss_dateposted', $_POST['odesk_rss_dateposted'], ' ', 'yes');
	update_option('odesk_rss_numresult', $_POST['odesk_rss_numresult'], ' ', 'yes');
	
	update_option('odesk_rss_footer', $_POST['footer_'], ' ', 'yes');
}

add_action('admin_menu', 'odesk_admin_page_rss');
add_action('admin_init', 'add_odesk_rss_scripts');

add_shortcode('odesk_rss_affiliate', 'odesk_rss_display');

function odesk_admin_page_rss() {
	add_options_page('Odesk RSS Job Affiliate', 'Odesk RSS Job Affiliate', 'manage_options', 'odesk-rss-job-affiliate', 'odesk_rss_jobs_options_page');
}


function odesk_rss_display() {
	$jobs = get_odesk_display();

	if ($jobs) {
		if ($jobs->jobs->lister->total_items[0] > 0) {
			display_RSSJobs($jobs);
		}else{
			echo "No matching data, please optimize your search.";	
		}
	}else{
		echo "There is an error in your query!";
	}
	
}

function display_RSSJobs($data) {
	$cjid = "3216638";
	
	if (get_option("odesk_rss_cjid") != '') {
		$cjid = get_option("odesk_rss_cjid");
	}
	$output = "";
	foreach ($data->jobs->job as $job) {
		$output .= "<div style=\"padding-top:10px;\"><strong><a href=\"http://www.jdoqocy.com/click-".$cjid."-10718312?url=https://www.odesk.com/jobs/".$job->ciphertext."?source=rss\" rel=\"nofollow\" target=\"_blank\">".$job->op_title."</a><br />".$job->job_type." - </strong>";
		$output .= "<span style=\"font-size:11px;\"><i>";
		if ($job->job_type == 'Hourly') {
			$output .= "Est. Time: ". $job->op_est_duration." week(s),";
		}else{
			$output .= "Est. Budget: $".number_format((double)$job->amount,2);
		}
		$output .= " - Posted: ".$job->date_posted." " .$job->op_time_posted;
		$output .= "</i></span><br />";
		$output .= "<span>".strip_tags(substr($job->op_description,0,200))."...</span><br />";
		$output .= "<span style=\"font-size:11px;\"><i>Skills: ";
		if ($job->op_required_skills == '') {
			$output .= "None";
		}else{
			$output .= trim($job->op_required_skills,",");
		}
		$output .= " - Category: ".$job->job_category_level_one.">".$job->job_category_level_two."</i></span><br style=\"clear:both;\" />";
		$output .= "<span>[<strong><a href=\"http://www.jdoqocy.com/click-".$cjid."-10718312?url=https://www.odesk.com/jobs/".$job->ciphertext."?source=rss rel=\"nofollow\" target=\"_blank\">Apply Now!</a></strong>]</span>";
		$output .= "<div style=\"clear:both;\"></div>";
		$output .= "</div>";
		$output .= "<div style=\"border-bottom:1px dotted; padding-bottom:10px;\"></div>";
	}
		if (get_option('odesk_rss_footer') == 1) {
		$output .= "<div style=\"text-align:right; font-size:10px;\"><i><a target\"_blank\" href=\"http://reygcalantaol.com/odesk-rss-job-affiliate\">Odesk RSS Job Affiliate Plugin</a> by Rey G. Calanta-ol</i></div>";
		}else{
		$output .= "<div style=\"text-align:right; font-size:10px;\"><i>Odesk RSS Job Affiliate Plugin by Rey G. Calanta-ol</i></div>";			
		}
		
	print_r($output);
}

function get_odesk_display() {

		$keyword = get_option("odesk_rss_keyword");
		$jobcategory = get_option("odesk_rss_jobcat");
		$subcategory = get_option("odesk_rss_subcat");
		$jobtype = get_option("odesk_rss_jobtype");
		$min = get_option("odesk_rss_min");
		$max = get_option("odesk_rss_max");
		$hrsperweek = get_option("odesk_rss_hrsperweek");
		$dateposted = get_option("odesk_rss_dateposted");
		$numresult = get_option("odesk_rss_numresult");
	

		$string = "";
		$string .= "q=$keyword&";
		$string .= "c1=$jobcategory&";
		$string .= "c2=$subcategory&";
		$string .= "min=$min&";
		$string .= "max=$max&";
		$string .= "t=$jobtype&";
		$string .= "wl=$hrsperweek&";
		$string .= "dp=$dateposted&";
	
	if ($numresult == '') {
		$string .= "page=0;5";
	}else{
		$string .= "page=0;$numresult";
	}
	
	$string = trim($string,"&");

	$url = "http://www.odesk.com/api/profiles/v1/search/jobs.xml?$string";
	$data = simplexml_load_file($url);
	
	return $data;

	
}


//display the admin options page
function odesk_rss_jobs_options_page() { ?>
<?php
	global $categories;

//Sub Category List
$sub = array(
			'Web Development' => array('Web Design', 'Web Programming', 'Ecommerce', 'UI Design', 'Website QA', 'Website Project Management', 'Other - Web Development'),
			'Software Development' => array('Desktop Application', 'Game Development', 'Scripts and Utilities', 'Software Plug-ins', 'Mobile Apps', 'Application Interface Design', 'Software Project Management', 'Software QA', 'VOIP', 'Other - Software Development'),
			'Networking and Information Systems' => array('Network Administration', 'DBA - Database Administration', 'Server Administration', 'ERP / CRM Implementation', 'Other - Networking and Information Systems'),
			'Writing and Translation' => array('Technical Writing', 'Website Content', 'Blog and Article Writing', 'Copywriting', 'Translation', 'Translation', 'Creative Writing', 'Other - Writing and Translation'),
			'Administrative Support' => array('Data Entry', 'Personal Assistant', 'Web Research', 'Email Response Handling', 'Transcription', 'Other - Administrative Support'),
			'Design and Multimedia' => array('Graphic Design', 'Logo Design', 'Illustration', 'Print Design', '3D Modeling and CAD', 'Audio Production', 'Video Production', 'Voice Talent', 'Animation', 'Presentations', 'Engineering and Technical Design', 'Other - Design and Multimedia'),
			'Customer Service' => array('Customer Service and Support', 'Technical support', 'Phone Support', 'Order Processing', 'Other - Customer Service'),
			'Sales and Marketing' => array('Advertising', 'Email Marketing', 'SEO - Search Engine Optimization', 'SEM - Search Engine Marketing', 'SMM - Social Media Marketing', 'PR - Public Relations', 'Telemarketing and Telesales', 'Business Plans and Marketing Strategy', 'Market Research and Surveys', 'Sales and Lead Generation', 'Other - Sales and Marketing'),
			'Business Services' => array('Accounting', 'Bookkeeping', 'HR / Payroll', 'Financial Services and Planning', 'Payment Processing', 'Legal', 'Project Management', 'Business Consulting', 'Recruiting', 'Statistical Analysis', 'Other - Business Services'));

	$cjid = get_option("odesk_rss_cjid");
	$keyword = get_option("odesk_rss_keyword");
	$jobcategory = get_option("odesk_rss_jobcat");
	$subcategory = get_option("odesk_rss_subcat");
	$jobtype = get_option("odesk_rss_jobtype");
	$min = get_option("odesk_rss_min");
	$max = get_option("odesk_rss_max");
	$hrsperweek = get_option("odesk_rss_hrsperweek");
	$dateposted = get_option("odesk_rss_dateposted");
	$numresult = get_option("odesk_rss_numresult");
	
	$jquery = "<script type=\"text/javascript\">
			function GetSubcategory(cat) {
				jQuery.ajax({
					url: '".WP_CONTENT_URL."/plugins/".basename(dirname(__FILE__)) . "/subcategories.php?cat='+cat,
					async: false,
					cache: false,
					type: 'POST',
					dataType: 'text',
					success: function(obj) {
						jQuery('#odesk_rss_subcat').html(obj);
					}
				});
			}


			jQuery(function() {
				jQuery('#odesk_rss_dateposted').datepicker({dateFormat : 'mm-dd-yy'});							
			});

			\n</script>\n";
		echo $jquery;
?>		
    <div><h2>Odesk RSS Jobs Affiliate</h2>
    This plugin requires Commision Junction Account (Publisher) to earn commision when someone got hired through your listing link.<br />If you do not have one, please signup <a href="http://www.cj.com/get-started-publisher?x" target="_blank" rel="nofollow">here</a>.<br />
    After saving this options, create a post or page and put this shortcode [odesk_rss_affiliate].
    <br /><br />
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>&updated=true" method="post">
        <table cellpadding="10" cellspacing="10">
        <tr>
        	<td>Commission Junction ID *:</td>
            <td>
            <input class="widefat" type="text" name="odesk_rss_cjid" value="<?php echo $cjid; ?>" />
            </td>
		</tr>
        <tr>
        	<td>Keyword (optional):</td>
            <td>
            <input class="widefat" type="text" name="odesk_rss_keyword" value="<?php echo $keyword; ?>" />
            </td>
		</tr>        
        <tr>
        	<td>Job Category (optional):</td>
            <td>
            <select class="widefat" name="odesk_rss_jobcat" onblur="GetSubcategory(this.value)">
            <option value="" <?php echo ($jobcategory == "") ? "selected=selected" : ""; ?>></option>            
            <?php
				asort($categories[0]);
				foreach ($categories[0] as $key => $c) { ?>
                <option value="<?php echo $c; ?>" <?php echo ($jobcategory == $c) ? "selected=selected" : ""; ?>><?php echo $c; ?></option>
			<?php		
				}
				?>
            </select>
            </td>
		</tr>
        <tr>
        	<td>Sub Category (optional):</td>
            <td>
            <select id="odesk_rss_subcat" class="widefat" name="odesk_rss_subcat">
                <option value="" <?php echo ($subcategory == "") ? "selected=selected" : ""; ?>></option>
    
                <?php
				//print_r($sub);
                foreach ($sub[$jobcategory] as $s) { ?>
                    <option value="<?php echo $s; ?>" <?php echo ($subcategory == $s) ? "selected=selected" : ""; ?>><?php echo $s; ?></option>
                <?php	
                }
                ?>
            </select>
            </td>
		</tr>        
        <tr>
        	<td>Job Type (optional):</td>
            <td>
            <select id="odesk_rss_jobtype" name="odesk_rss_jobtype">
                <option value="" <?php echo ($jobtype == "") ? "selected=selected" : ""; ?>></option>
                <option value="Hourly" <?php echo ($jobtype == "Hourly") ? "selected=selected" : ""; ?>>Hourly</option>
                <option value="Fixed" <?php echo ($jobtype == "Fixed") ? "selected=selected" : ""; ?>>Fixed</option>
            </select>
            </td>
		</tr>
        <tr>
        	<td>Minimum Budget (optional):</td>
            <td>
            <input size="15" type="text" name="odesk_rss_min" value="<?php echo $min; ?>" />
            </td>
		</tr>
        <tr>
        	<td>Maximum Budget (optional):</td>
            <td>
            <input size="15" type="text" name="odesk_rss_max" value="<?php echo $max; ?>" />
            </td>
		</tr>
        <tr>
        	<td>Hours/Week (optional):</td>
            <td>
            <input size="15" type="text" name="odesk_rss_hrsperweek" value="<?php echo $hrsperweek; ?>" />
            </td>
		</tr>
        <tr>
        	<td>Date Posted (optional):</td>
            <td>
            <input id="odesk_rss_dateposted" size="15" type="text" name="odesk_rss_dateposted" value="<?php echo $dateposted; ?>" />
            </td>
		</tr>              
        <tr>
        	<td>Number of results (default: 5):</td>
            <td>
            <input type="text" name="odesk_rss_numresult" value="<?php echo $numresult; ?>" size="15" />
            </td>
		</tr>                                          
       <tr>
       <td>
       </td>
       <td>
       <input name="footer_" type="checkbox" value="1" <?php if (get_option("odesk_rss_footer") != '') { echo "checked=\"checked\"";} ?>/> Display developer link at the footer?
       </td>
       </tr>
       <tr>
       		<td></td>
            <td><input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" /></td>
		</tr>
        </table>
    </form>
    </div>
<?php
}

function getOdeskRSSJobs($args = array(), $position) {
	$q = $args['q'];
	$c1 = $args['c1'];
	$c2 = $args['c2'];
	$min = $args['min'];
	$max = $args['max'];
	$t = $args['t'];
	$wl = $args['wl'];
	$dp = $args['dp'];
	$ret = $args['ret'];
	$cjid = $args['cjid'];
		$string = "";
		$string .= "q=$q&";
		$string .= "c1=$c1&";
		$string .= "c2=$c2&";
		$string .= "min=$min&";
		$string .= "max=$max&";
		$string .= "t=$t&";
		$string .= "wl=$wl&";
		$string .= "dp=$dp&";
	
	if ($ret == '') {
		$string .= "page=0;5";
	}else{
		$string .= "page=0;$ret";
	}
	
	$string = trim($string,"&");

	$url = "http://www.odesk.com/api/profiles/v1/search/jobs.xml?$string";
	$data = simplexml_load_file($url);
	return $data;
	//return $url;
}

function displayOdeskRSSJobs($args = array(), $position) {
	$jobs = getOdeskRSSJobs($args, $position);
	//print_r($jobs);	
	if ($jobs) {
		//print_r($jobs);
		if ($jobs->jobs->lister->total_items[0] > 0) {
			displayRSSJobs($jobs);
		}else{
			echo "No matching data, please optimize your search.";	
		}
	}else{
		echo "There is an error in your query!";
	}
}


function displayRSSJobs($data) {
	$cjid = "3216638";
	
	if (esc_attr($instance['cjid']) != '') {
		$cjid = esc_attr($instance['cjid']);
	}
	
	
	$output = "<ul>";	
	foreach ($data->jobs->job as $job) {
		$output .= "<li><strong><a href=\"http://www.jdoqocy.com/click-".$cjid."-10718312?url=https://www.odesk.com/jobs/".$job->ciphertext."?source=rss\" rel=nofollow target=_blank>".$job->op_title."</a></strong><br /><span>".substr($job->op_description,0,75)."...</span></li>";		
	}
	$output .= "</ul>";
	print_r($output);
}


function add_odesk_rss_scripts() {
	wp_enqueue_style('jquery.ui.theme', WP_CONTENT_URL."/plugins/".basename(dirname(__FILE__)).'/jquery-ui-1.7.3.custom.css');
	
    wp_enqueue_script("jquery");
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-datepicker', WP_CONTENT_URL."/plugins/".basename(dirname(__FILE__)) . '/ui.datepicker.min.js', array('jquery','jquery-ui-core'));
		
}


/**
 * Odesk PRofile Widget, will be displayed on post page
 */
class OdeskJobsWidget extends WP_Widget {
	function OdeskJobsWidget() {
		parent::WP_Widget(false, $name = 'Odesk Affiliate RSS Widget');
	}

	function widget($args, $instance) {
			extract( $args );
			$title = apply_filters('widget_title', $instance['title']);
			echo $before_widget;
			if ( $title )
				echo $before_title . $title . $after_title;
			//echo getOdeskRSSJobs($instance, 'widget');
			displayOdeskRSSJobs($instance, 'widget');
			echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['q'] = strip_tags($new_instance['q']);
		$instance['c1'] = strip_tags($new_instance['c1']);
		$instance['c2'] = strip_tags($new_instance['c2']);
		$instance['t'] = strip_tags($new_instance['t']);
		$instance['min'] = strip_tags($new_instance['min']);
		$instance['max'] = strip_tags($new_instance['max']);
		$instance['wl'] = strip_tags($new_instance['wl']);
		$instance['dp'] = strip_tags($new_instance['dp']);
		$instance['ret'] = strip_tags($new_instance['ret']);
		$instance['cjid'] = strip_tags($new_instance['cjid']);
	
		return $instance;
	}



	function form( $instance ) {
		
		global $categories;

//Sub Category List
$sub = array(
			'Web Development' => array('Web Design', 'Web Programming', 'Ecommerce', 'UI Design', 'Website QA', 'Website Project Management', 'Other - Web Development'),
			'Software Development' => array('Desktop Application', 'Game Development', 'Scripts and Utilities', 'Software Plug-ins', 'Mobile Apps', 'Application Interface Design', 'Software Project Management', 'Software QA', 'VOIP', 'Other - Software Development'),
			'Networking and Information Systems' => array('Network Administration', 'DBA - Database Administration', 'Server Administration', 'ERP / CRM Implementation', 'Other - Networking and Information Systems'),
			'Writing and Translation' => array('Technical Writing', 'Website Content', 'Blog and Article Writing', 'Copywriting', 'Translation', 'Translation', 'Creative Writing', 'Other - Writing and Translation'),
			'Administrative Support' => array('Data Entry', 'Personal Assistant', 'Web Research', 'Email Response Handling', 'Transcription', 'Other - Administrative Support'),
			'Design and Multimedia' => array('Graphic Design', 'Logo Design', 'Illustration', 'Print Design', '3D Modeling and CAD', 'Audio Production', 'Video Production', 'Voice Talent', 'Animation', 'Presentations', 'Engineering and Technical Design', 'Other - Design and Multimedia'),
			'Customer Service' => array('Customer Service and Support', 'Technical support', 'Phone Support', 'Order Processing', 'Other - Customer Service'),
			'Sales and Marketing' => array('Advertising', 'Email Marketing', 'SEO - Search Engine Optimization', 'SEM - Search Engine Marketing', 'SMM - Social Media Marketing', 'PR - Public Relations', 'Telemarketing and Telesales', 'Business Plans and Marketing Strategy', 'Market Research and Surveys', 'Sales and Lead Generation', 'Other - Sales and Marketing'),
			'Business Services' => array('Accounting', 'Bookkeeping', 'HR / Payroll', 'Financial Services and Planning', 'Payment Processing', 'Legal', 'Project Management', 'Business Consulting', 'Recruiting', 'Statistical Analysis', 'Other - Business Services'));
		
		$title = esc_attr($instance['title']);
		$q = esc_attr($instance['q']);
		$c1 = esc_attr($instance['c1']);
		$c2 = esc_attr($instance['c2']);
		$t = esc_attr($instance['t']);
		$min = esc_attr($instance['min']);
		$max = esc_attr($instance['max']);
		$wl = esc_attr($instance['wl']);
		$dp = esc_attr($instance['dp']);
		$ret = esc_attr($instance['ret']);
		$cjid = esc_attr($instance['cjid']);
		
		$jquery = "<script type=\"text/javascript\">
			function GetSubcategory(cat) {
				jQuery.ajax({
					url: '".WP_CONTENT_URL."/plugins/".basename(dirname(__FILE__)) . "/subcategories.php?cat='+cat,
					async: false,
					cache: false,
					type: 'POST',
					dataType: 'text',
					success: function(obj) {
						jQuery('#".$this->get_field_id('c2')."').html(obj);
					}
				});
			}


			jQuery(function() {
				jQuery('#".$this->get_field_id('dp')."').datepicker({dateFormat : 'mm-dd-yy'});							
			});

			\n</script>\n";
		echo $jquery;
		
//print_r($sub);

		// Default Widget Settings
		$defaults = array( 'title' => 'New Odesk Jobs', 'q' => '', 'c1' => '', 'c2' => '', 'min' => '', 'max' => '', 't' => '', 'wl' => '', 'dp' => '', 'ret' => '', 'cjid'=>'');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?><br />
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('cjid'); ?>"><?php _e('Commision Junction ID:'); ?><br />
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('cjid'); ?>" name="<?php echo $this->get_field_name('cjid'); ?>" value="<?php echo $cjid; ?>" />
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('q'); ?>"><?php _e('Keyword (optional):'); ?><br />
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('q'); ?>" name="<?php echo $this->get_field_name('q'); ?>" value="<?php echo $q; ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('c1'); ?>"><?php _e('Job Category (optional):'); ?><br />
            <select class="widefat" id="<?php echo $this->get_field_id('c1'); ?>" name="<?php echo $this->get_field_name('c1'); ?>" onblur="GetSubcategory(this.value);">
            <option value="" <?php echo ($c1 == "") ? "selected=selected" : ""; ?>></option>
            <?php				
				asort($categories[0]);
				foreach ($categories[0] as $key => $c) { ?>
                <option value="<?php echo $c; ?>" <?php echo ($c1 == $c) ? "selected=selected" : ""; ?>><?php echo $c; ?></option>
			<?php		
				}
			?>
            </select>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('c2'); ?>"><?php _e('Sub Category (optional):'); ?><br /> 
            <select class="widefat" id="<?php echo $this->get_field_id('c2'); ?>" name="<?php echo $this->get_field_name('c2'); ?>">
            <option value="" <?php echo ($c2 == "") ? "selected=selected" : ""; ?>></option>

			<?php
            foreach ($sub[$c1] as $s) { ?>
                <option value="<?php echo $s; ?>" <?php echo ($c2 == $s) ? "selected=selected" : ""; ?>><?php echo $s; ?></option>
            <?php	
            }
            ?>
            </select>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('t'); ?>"><?php _e('Job Type (optional):'); ?><br />
            <select class="widefat" id="<?php echo $this->get_field_id('t'); ?>" name="<?php echo $this->get_field_name('t'); ?>">            
            <option value="" <?php echo ($t == "") ? "selected=selected" : ""; ?>></option>
            <option value="Hourly" <?php echo ($t == "Hourly") ? "selected=selected" : ""; ?>>Hourly</option>
            <option value="Fixed" <?php echo ($t == "Fixed") ? "selected=selected" : ""; ?>>Fixed</option>
            </select>
            </label>
        </p>         
        <p>
            <label for="<?php echo $this->get_field_id('min'); ?>"><?php _e('Minimum Budget (optional):'); ?><br />
            <input type="text" id="<?php echo $this->get_field_id('min'); ?>" name="<?php echo $this->get_field_name('min'); ?>" value="<?php echo $min; ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('max'); ?>"><?php _e('Maximum Budget (optional):'); ?><br />
            <input type="text" id="<?php echo $this->get_field_id('max'); ?>" name="<?php echo $this->get_field_name('max'); ?>" value="<?php echo $max; ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('wl'); ?>"><?php _e('Hours/Week (optional):'); ?><br />
            <input type="text" id="<?php echo $this->get_field_id('wl'); ?>" name="<?php echo $this->get_field_name('wl'); ?>" value="<?php echo $wl; ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('dp'); ?>"><?php _e('Date Posted (optional):'); ?> 
            <input type="text" id="<?php echo $this->get_field_id('dp'); ?>" name="<?php echo $this->get_field_name('dp'); ?>" value="<?php echo $dp; ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('ret'); ?>"><?php _e('Number of results (default: 5):'); ?> 
            <input type="text" id="<?php echo $this->get_field_id('ret'); ?>" name="<?php echo $this->get_field_name('ret'); ?>" value="<?php echo $ret; ?>" />
            </label>
        </p>        

        <?php 
	}




} // class OdeskProfileWidget

add_action( 'widgets_init', create_function( '', 'return register_widget("OdeskJobsWidget");' ) );

?>