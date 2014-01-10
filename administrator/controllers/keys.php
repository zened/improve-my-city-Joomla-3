<?php
/**
 * @version     2.5.x
 * @package     com_improvemycity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      Ioannis Tsampoulatidis for the URENIO Research Unit
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Issues list controller class.
 */
class ImprovemycityControllerKeys extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'key', $prefix = 'ImprovemycityModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		
		return $model;
	}
	
	public function updateCategoryTimestamp()
	{
		//get model and categories
		$model = $this->getModel('keys');
		$updated = $model->updateCategoryTimestamp();
		JFactory::getApplication()->enqueueMessage('Timestamps updated');
		$this->setRedirect("index.php?option=com_improvemycity&view=keys");
		
	}	
}
