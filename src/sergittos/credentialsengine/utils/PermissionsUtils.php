<?php
/*
* Copyright (C) Sergittos - All Rights Reserved
* Unauthorized copying of this file, via any medium is strictly prohibited
* Proprietary and confidential
*/

declare(strict_types=1);


namespace sergittos\credentialsengine\utils;


use sergittos\credentialsengine\CredentialsEngine;
use sergittos\credentialsengine\session\Session;

class PermissionsUtils {

    static public function updateSessionPermissions(Session $session): void {
        $player = $session->getPlayer();
        foreach($player->getEffectivePermissions() as $permission) {
            $attachment = $permission->getAttachment();
            if($attachment !== null) {
                $player->removeAttachment($attachment);
            }
        }
        foreach($session->getRank()->getPermissions() as $permission) {
            $player->addAttachment(CredentialsEngine::getInstance(), $permission, true);
        }
    }

}