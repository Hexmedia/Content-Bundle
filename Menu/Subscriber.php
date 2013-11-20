<?php

namespace Hexmedia\ContentBundle\Menu;

use Hexmedia\AdministratorBundle\Menu\Builder;
use Hexmedia\AdministratorBundle\Menu\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Hexmedia\AdministratorBundle\Menu\Subscriber as SubscriberAbstract;

class Subscriber extends SubscriberAbstract implements EventSubscriberInterface {

	public function addPositions(Event $event) {

		$menu = $event->getMenu()->addChild($this->translator->trans("Media Library"), ['route' => 'HexMediaContentMedia', 'id' => 'HexMediaContentMedia'])->setAttribute('icon', 'icon-picture');
		$menu = $event->getMenu()->addChild($this->translator->trans("Pages"), ['route' => 'HexMediaContentPage', 'id' => "HexMediaContentPage"])->setAttribute('icon', 'icon-sitemap');

		return $event->getMenu();
	}

	public static function getSubscribedEvents() {
		return array(
			Builder::MENU_BUILD_EVENT => array('addPositions', 4)
		);
	}

}

?>
