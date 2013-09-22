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

		$menu = $event->getMenu()->addChild($this->translator->trans("Media Library"), ['route' => 'HexMediaContentMedia', 'id' => 'HexMediaContentMedia']);
//		$menu->addChild($this->translator->trans("Media"), ['route' => 'HexMediaContentMedia', 'under' => 'HexMediaContentMedia']);
		$menu->addChild($this->translator->trans("Add"), ['route' => 'HexMediaContentMediaAdd', 'under' => 'HexMediaContentMedia']);

		$menu = $event->getMenu()->addChild($this->translator->trans("Area"), ['route' => 'HexMediaContentArea', 'id' => 'HexMediaContentArea']);
		$menu->addChild($this->translator->trans("Add"), ['route' => 'HexMediaContentAreaAdd']);

        $menu = $event->getMenu()->addChild($this->translator->trans("Page"), ['route' => 'HexMediaContentPage', 'id' => "HexMediaContentPage"]);
        $menu->addChild($this->translator->trans("Add"), ['route' => 'HexMediaContentPageAdd']);

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
