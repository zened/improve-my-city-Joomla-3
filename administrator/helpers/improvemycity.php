<?php
/**
 * @version     2.5.x
 * @package     com_improvemycity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      Ioannis Tsampoulatidis for the URENIO Research Unit
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Improvemycity helper.
 */
class ImprovemycityHelper extends JHelperContent
{
	/**
	 * Configure the Linkbar.
	 */
	public static function addSubmenu($vName = '')
	{

		JHtmlSidebar::addEntry(
			JText::_('COM_IMPROVEMYCITY_TITLE_ITEMS'),
			'index.php?option=com_improvemycity&view=issues',
			$vName == 'issues'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_IMPROVEMYCITY_SUBMENU_CATEGORIES'), 
			'index.php?option=com_categories&view=categories&extension=com_improvemycity', 
			$vName == 'categories'
		);
		JHtmlSidebar::addEntry(
				JText::_('COM_IMPROVEMYCITY_SUBMENU_COMMENTS'),
				'index.php?option=com_improvemycity&view=comments',
				$vName == 'comments'
		);
		JHtmlSidebar::addEntry(
				JText::_('COM_IMPROVEMYCITY_SUBMENU_REPORTS'),
				'index.php?option=com_improvemycity&view=reports',
				$vName == 'reports'
		);
		JHtmlSidebar::addEntry(
				JText::_('COM_IMPROVEMYCITY_SUBMENU_KEYS'),
				'index.php?option=com_improvemycity&view=keys',
				$vName == 'keys'
		);		
				
		// set some global property
		$document = JFactory::getDocument();
		if ($vName == 'categories') 
		{
			$document->setTitle(JText::_('COM_IMPROVEMYCITY_ADMINISTRATION_CATEGORIES'));
		}
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_improvemycity';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
}
