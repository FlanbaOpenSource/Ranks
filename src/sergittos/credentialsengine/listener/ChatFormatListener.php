<?php
/*
* Copyright (C) Sergittos - All Rights Reserved
* Unauthorized copying of this file, via any medium is strictly prohibited
* Proprietary and confidential
*/

declare(strict_types=1);


namespace sergittos\credentialsengine\listener;


use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use sergittos\credentialsengine\session\SessionFactory;
use sergittos\credentialsengine\utils\ColorUtils;
use sergittos\credentialsengine\utils\ConfigGetter;

class ChatFormatListener implements Listener {

    public function onChat(PlayerChatEvent $event): void {
        $session = SessionFactory::getSession($player = $event->getPlayer());
        $rank = $session->getRank();
        $event->setFormat(ColorUtils::translate(str_replace(
            ["{rank}", "{player}", "{message}"],
            [$rank->getColor() . $rank->getName(), $player->getName(), $event->getMessage()],
            ConfigGetter::getChatFormat()
        )));
    }

}