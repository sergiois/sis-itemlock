<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.SISItemLock
 *
 * @copyright	Copyright © 2019 SergioIglesiasNET - All rights reserved.
 * @license		GNU General Public License v2.0
 * @author 		Sergio Iglesias (@sergiois)
 */

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die;

class PlgSystemSisitemlock extends CMSPlugin
{
	protected $app;

	public function onAfterRender()
	{
		$app = Factory::getApplication();

		if ($app->isClient('administrator') || $app->get('offline', '0'))
		{
			return;
		}

		$item = $this->inItems($this->params->get('items'));
		if($app->isClient('site') && $item)
		{
			// Get Hash
			if( ($app->input->get('sislock') && $app->input->get('sislock') != $item->hash_sislock)
				|| empty($app->input->get('sislock'))
			)
			{
				$this->app->redirect(Route::_('index.php?Itemid='.$item->item_return,false));
			}
        }
	}

	private function inItems($items)
	{
		$app = Factory::getApplication();

		$itemid = $app->getMenu()->getActive()->id;
		foreach($items as $item)
		{
			if($itemid == $item->item_lock)
			{
				return $item;
			}
		}
		
		return false;
	}
}
