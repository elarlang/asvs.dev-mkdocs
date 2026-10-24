<?php

define('DIR_MKDOCS_CONTENT_INPUT', 'tmp-mkdocs-content-input/');
define('DIR_OWASP_ASVS_GIT_SOURCE', 'tmp-OWASP-ASVS-git-checkout/');

define('GIT_OWASP_ASVS_REPO', 'git@github.com:OWASP/ASVS.git');
//define('DIR_OWASP_ASVS_GIT_SOURCE', '/home/e/owasp-asvs-dev/asvs-2560-levels-to-numeric/ASVS/'); // without 5.0/en/
// define('DIR_OWASP_ASVS_GIT_SOURCE', '/home/e/owasp-asvs-dev/asvs-2456-step-1-6-cleanup/ASVS/'); // without 5.0/en/
// define('DIR_OWASP_ASVS_GIT_SOURCE', '/home/e/report/owasp-md-export/tmp-repo-ASVS-master/');

if (!is_dir(DIR_MKDOCS_CONTENT_INPUT)) {
	exec('mkdir -p '.DIR_MKDOCS_CONTENT_INPUT);
} else {
	exec('rm -rf '.DIR_MKDOCS_CONTENT_INPUT.'*');
}
exec('mkdir -p '.DIR_MKDOCS_CONTENT_INPUT.'docs/images/');

if (!is_dir(DIR_OWASP_ASVS_GIT_SOURCE)) {
	exec('mkdir -p '.DIR_OWASP_ASVS_GIT_SOURCE);
}

/**/
if (is_dir(DIR_OWASP_ASVS_GIT_SOURCE) && is_file(DIR_OWASP_ASVS_GIT_SOURCE.'README.md')) {
	exec('cd '.DIR_OWASP_ASVS_GIT_SOURCE.'; git pull origin; cd -');
} else {
	exec('cd '.DIR_OWASP_ASVS_GIT_SOURCE.'; git clone '.GIT_OWASP_ASVS_REPO.' .');
}
/**/

exec('cp -r mkdocs-engine/* '.DIR_MKDOCS_CONTENT_INPUT);

$github_raw_url = 'https://raw.githubusercontent.com/OWASP/ASVS/master/';

function asvsVersionContentFilesAndMkdocsNav($folder) {
	//echo $folder, PHP_EOL;
	//echo getcwd(), PHP_EOL;
	$mkdocsyml_file = DIR_MKDOCS_CONTENT_INPUT.'mkdocs.yml';
	$mkdocsyml_file_intent = '    - ';

	$public_root = explode(DIR_MKDOCS_CONTENT_INPUT.'docs/', $folder)[1];
	$list = glob($folder.'*.md');
	sort($list);
	$mkdocsyml_replacement = '';
	foreach($list as $file) {
		$new_name = preg_replace('/^(0x[0-9]+\-)/', '', basename($file));
		//echo $file, ' ', basename($file), ' ', $new_name, PHP_EOL;
		exec('mv '.$file.' '.$folder.$new_name);
		$mkdocsyml_replacement .= $mkdocsyml_file_intent."'".$public_root.$new_name."'".PHP_EOL;
	}

	$mkdocs_content = file_get_contents($mkdocsyml_file);
	$mkdocs_content = str_replace($mkdocsyml_file_intent."'... | flat | ".$public_root."*.md'", rtrim($mkdocsyml_replacement), $mkdocs_content);
	file_put_contents($mkdocsyml_file, $mkdocs_content);
	//echo $mkdocs_content, PHP_EOL;
}


// copy custom static content
exec('cp custom-assets/owasp_asvs_c.png '.DIR_MKDOCS_CONTENT_INPUT.'docs/images/');
exec('cp custom-assets/owasp_asvs_w.png '.DIR_MKDOCS_CONTENT_INPUT.'docs/images/');
exec('cp custom-assets/owasp_asvs_w.png '.DIR_MKDOCS_CONTENT_INPUT.'docs/favicon.png');


/**
 * ***| PAGE: The Project |***************************************************
 */

// todo: add "ABOUT page"
exec('cp '.DIR_OWASP_ASVS_GIT_SOURCE.'README.md '.DIR_MKDOCS_CONTENT_INPUT.'docs/');
# exec('cp '.DIR_OWASP_ASVS_GIT_SOURCE.'COMPILING.md '.DIR_MKDOCS_CONTENT_INPUT.'docs/');
exec('cp '.DIR_OWASP_ASVS_GIT_SOURCE.'CONTRIBUTING.md '.DIR_MKDOCS_CONTENT_INPUT.'docs/');
//exec('cp -r '.DIR_OWASP_ASVS_GIT_SOURCE.'LICENSE.md '.DIR_MKDOCS_CONTENT_INPUT.'docs/');
exec('cp '.DIR_OWASP_ASVS_GIT_SOURCE.'SUPPORTERS.md '.DIR_MKDOCS_CONTENT_INPUT.'docs/');

$supporters_md = file_get_contents(DIR_MKDOCS_CONTENT_INPUT.'docs/SUPPORTERS.md');
$supporters_md = preg_replace('/\[\<img src=\"\.\/images\/supporters\/([^\"]+)\" height=\"?([0-9]+)\"?\>\]\(([^\)]+)\)/', '[<img src="'.$github_raw_url.'images/supporters/\\1" style="height:\\2px;margin-bottom:20px;">](\\3){:target="_blank"}', $supporters_md);
file_put_contents(DIR_MKDOCS_CONTENT_INPUT.'docs/SUPPORTERS.md', $supporters_md);


// rm dead link, fix till https://github.com/OWASP/ASVS/issues/3424
$rm_tag = '<img src="https://owasp.org/www-project-application-security-verification-standard/assets/images/OWASP_ASVS_Linkedin_Banner-01.jpg" width="700px">';

$files = [
	DIR_MKDOCS_CONTENT_INPUT.'docs/CONTRIBUTING.md',
	DIR_MKDOCS_CONTENT_INPUT.'docs/README.md',
	DIR_MKDOCS_CONTENT_INPUT.'docs/SUPPORTERS.md'
];

foreach($files as $replace_in_file) {
	$file_src = file_get_contents($replace_in_file);
	file_put_contents($replace_in_file, str_replace($rm_tag, '', $file_src));
}

// todo: add "ABOUT page"


/**
 * ***| PAGE: ASVS v5.0.0 |***************************************************
 */

exec('cp custom-assets/AppSec_Barcelona_2025_Elar_Lang.jpg '.DIR_MKDOCS_CONTENT_INPUT.'docs/images/');

$checkout_to_dir = DIR_MKDOCS_CONTENT_INPUT.'docs/v5.0.0/';

exec('mkdir -p '.$checkout_to_dir);
exec('cp -r '.DIR_OWASP_ASVS_GIT_SOURCE.'/5.0/en/* '.$checkout_to_dir);

$header_md = '# Application Security Verification Standard v5.0.0

![ASVS LOGO](/images/owasp_asvs_c.png){: style="max-height:200px;"}

## v5.0.0, released on May 30, 2025.

"[Introducing the 5.0 release of the ASVS](https://owasp2025globalappseceu.sched.com/event/1whCc)" at [OWASP Global AppSec EU](https://owasp2025globalappseceu.sched.com/)

[![](/images/AppSec_Barcelona_2025_Elar_Lang.jpg){: style="max-height:400px;"}](https://owasp2025globalappseceu.sched.com/event/1whCc)

## What is new in the ASVS v5.0.0

Presentation at [OWASP BeNeLux 2025](https://2025.owaspbenelux.eu/) "OWASP ASVS - What Is It And What Is New In The V5.0 Release - Elar Lang"

<iframe width="560" height="315" src="https://www.youtube.com/embed/Qr6mv4EFNqQ?si=mX0cTfmaycv1rwd6" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
';
$input_file = $checkout_to_dir.'0x00-Header.md';
file_put_contents($input_file, $header_md);


$input_file = $checkout_to_dir.'0x01-Frontispiece.md';
$front_md = file_get_contents($input_file);
$front_md = str_replace('![license](../images/license.png)', '![license]('.$github_raw_url.'/5.0/images/license.png)', $front_md);
file_put_contents($input_file, $front_md);

asvsVersionContentFilesAndMkdocsNav($checkout_to_dir);


/**
 * ***| PAGE: ASVS v4.0.3 |***************************************************
 */

$checkout_to_dir = DIR_MKDOCS_CONTENT_INPUT.'docs/v4.0.3/';

// todo: add "ABOUT page"
exec('mkdir -p '.$checkout_to_dir);
exec('cp -r '.DIR_OWASP_ASVS_GIT_SOURCE.'/4.0/en/* '.$checkout_to_dir);


$header_md = '# Application Security Verification Standard v4.0.3

![OWASP LOGO]('.$github_raw_url.'/4.0/images/owasp_logo_1c_notext.png){: style="max-height:150px;"}

## Final

October 2021
';
$input_file = $checkout_to_dir.'0x00-Header.md';
file_put_contents($input_file, $header_md);


$input_file = $checkout_to_dir.'0x01-Frontispiece.md';
$front_md = file_get_contents($input_file);
$front_md = str_replace('![license](../images/license.png)', '![license]('.$github_raw_url.'/4.0/images/license.png)', $front_md);
file_put_contents($input_file, $front_md);

asvsVersionContentFilesAndMkdocsNav($checkout_to_dir);


/**
 * ***| PAGE: Mappigs |***************************************************
 */

exec('cp '.(__DIR__).'/custom-pages/mapping.md '.DIR_MKDOCS_CONTENT_INPUT.'docs/Mappings.md');
