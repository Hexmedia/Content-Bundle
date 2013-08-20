<?php

namespace Hexmedia\ContentBundle\Menu;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Hexmedia\AdministratorBundle\Menu\Subscriber as SubscriberAbstract;
use Hexmedia\AdministratorBundle\Menu\Builder as MenuBuilder;
use Hexmedia\AdministratorBundle\Menu\Event as MenuEvent;

class Subscriber extends SubscriberAbstract implements EventSubscriberInterface
{

	public function addPositions(MenuEvent $event)
	{

		$menu = $event->getMenu()->addChild($this->translator->trans("Media Library"), array('route' => 'HexMediaMediaLibrary', 'id' => 'HexMediaMediaLibrary'));
//		$menu->addChild($this->translator->trans("Media"), array('route' => 'HexMediaMediaLibrary', 'under' => 'HexMediaMediaLibrary'));
		$menu->addChild($this->translator->trans("Add"), array('route' => 'HexMediaMediaAdd', 'under' => 'HexMediaMediaLibrary'));

		return $event->getMenu();
	}

	public static function getSubscribedEvents()
	{
		return array(
			MenuBuilder::MENU_BUILD_EVENT => array('addPositions', 4)
		);
	}

}

?>
