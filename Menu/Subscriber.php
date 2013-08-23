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

		$menu = $event->getMenu()->addChild($this->translator->trans("Media Library"), array('route' => 'HexMediaContentMediaLibrary', 'id' => 'HexMediaContentMediaLibrary'));
//		$menu->addChild($this->translator->trans("Media"), array('route' => 'HexMediaContentMediaLibrary', 'under' => 'HexMediaContentMediaLibrary'));
		$menu->addChild($this->translator->trans("Add"), array('route' => 'HexMediaContentMediaAdd', 'under' => 'HexMediaContentMediaLibrary'));


		$menu = $event->getMenu()->addChild($this->translator->trans("Area"), array('route' => 'HexMediaContentArea', 'id' => 'HexMediaContentArea'));

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
