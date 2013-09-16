<?php
/**
 * @version     2.5.x
 * @package     com_improvemycity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      Ioannis Tsampoulatidis for the URENIO Research Unit
 */

defined('_JEXEC') or die;
if(!defined('DS'))
	define('DS',DIRECTORY_SEPARATOR);

// require helper file
JLoader::register('ImprovemycityHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'improvemycity.php');
 
// Include dependancies
jimport('joomla.application.component.controller');

// Execute the task.
$controller	= JControllerLegacy::getInstance('Improvemycity');
$controller->execute(JRequest::getVar('task'));
$controller->redirect();
