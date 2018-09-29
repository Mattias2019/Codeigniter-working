<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use \Zend\Permissions\Acl\Acl as AclCore;
use \Zend\Permissions\Acl\Assertion\AssertionInterface as AclAssertion;
use \Zend\Permissions\Acl\Role\RoleInterface as AclRole;
use \Zend\Permissions\Acl\Resource\ResourceInterface as AclResource;

/**
 * ACL check if escrow is available
 *
 * Class EscrowAssertion
 */
class EscrowAssertion implements AclAssertion
{
	public function assert(AclCore $acl, AclRole $role = null, AclResource $resource = null, $privilege = null)
	{
		$CI = &get_instance();
		return empty($CI->config->item('disable_escrow'));
	}
}