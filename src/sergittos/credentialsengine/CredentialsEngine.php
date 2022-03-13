<?php
/*
* Copyright (C) Sergittos - All Rights Reserved
* Unauthorized copying of this file, via any medium is strictly prohibited
* Proprietary and confidential
*/

declare(strict_types=1);


namespace sergittos\credentialsengine;


use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use sergittos\credentialsengine\listener\ChatFormatListener;
use sergittos\credentialsengine\listener\SessionListener;
use sergittos\credentialsengine\provider\mysql\MysqlProvider;
use sergittos\credentialsengine\provider\Provider;
use sergittos\credentialsengine\rank\RankManager;
use sergittos\credentialsengine\session\SessionFactory;
use sergittos\credentialsengine\utils\ConfigGetter;

class CredentialsEngine extends PluginBase {
    use SingletonTrait;

    private Provider $provider;
    private RankManager $rank_manager;

    protected function onLoad(): void {
        self::setInstance($this);

        $this->saveResource("ranks.json");
        $this->saveDefaultConfig();
    }

    protected function onEnable(): void {
        ConfigGetter::init();

        $this->provider = new MysqlProvider();
        $this->rank_manager = new RankManager();

        $this->registerEvents(new ChatFormatListener());
        $this->registerEvents(new SessionListener());

        $this->getServer()->getCommandMap()->register("ranks", new RanksCommand());
    }

    protected function onDisable(): void {
        foreach(SessionFactory::getSessions() as $session) {
            $session->save();
        }
    }

    private function registerEvents(Listener $listener): void {
        $this->getServer()->getPluginManager()->registerEvents($listener, $this);
    }

    public function getProvider(): Provider {
        return $this->provider;
    }

    public function getRankManager(): RankManager {
        return $this->rank_manager;
    }

}