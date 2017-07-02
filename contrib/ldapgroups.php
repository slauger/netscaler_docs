<?php
/**
 * LDAP Group Extraction Wrapper for Citrix NetScaler
 * @author Simon Lauger <simon.lauger@teamix.de>
 * @date   11.07.2016
 */

// Return as text
header('Content-Type:text/plain');

// Settings
$ldap_server = 'ldap://dc01.customer.local';
$ldap_binddn = 'CN=NetScaler Users,OU=Service-Accounts,DC=customer,DC=local';
$ldap_bindpw = 'bindpw';
$ldap_basedn = 'DC=customer,DC=local';

// Target
$ldap_member = (isset($_REQUEST['username']) && !empty($_REQUEST['username'])) ? strip_tags($_REQUEST['username']) : null;
if (is_null($ldap_member)) {
		header('HTTP/1.0 500 Internal Server Error');
		die('error: missing argument');
}

$connection = ldap_connect($ldap_server);

if (!$connection) {
		header('HTTP/1.0 500 Internal Server Error');
		die('error: ldap connection failed');
}

// LDAP Settings for Microsoft Active Directory
ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);

ldap_bind($connection, $ldap_binddn, $ldap_bindpw);
$result = ldap_search($connection, $ldap_basedn, sprintf('(sAMAccountName=%s)', $ldap_member), array('memberOf'));
$result = ldap_get_entries($connection, $result);

if (isset($result[0]['memberof']) && !empty($result[0]['memberof'])) {
	foreach ($result[0]['memberof'] as $group) {
			// skip first row (line count)
			if (is_int($group)) continue;
			
			// print out group
			echo $group . PHP_EOL;
}
