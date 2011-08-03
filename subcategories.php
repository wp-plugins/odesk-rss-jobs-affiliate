<?php
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

//echo $_GET['cat'];
$cat = $_GET['cat'];
if ($cat != '') {
?>
	<option value=""></option>
	<?php
    foreach ($sub[$cat] as $s) { ?>
        <option value="<?php echo $s; ?>"><?php echo $s; ?></option>
    <?php	
    }
}
?>