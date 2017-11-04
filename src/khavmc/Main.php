<?php

namespace khavmc;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener
{

    public $tasks = [];

    public function onEnable()
    {
        $this->getLogger()->info(TextFormat::GREEN . "WingsParticles Enabled by @khavmc");
        $this->getLogger()->info(TextFormat::GREEN . "Thx for SanderTV for resource :)");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

    }


    public function onMove(PlayerMoveEvent $event){
        $player = $event->getPlayer();
        $task = new WingsTask($this);
        // The Task handler
        $h = $this->getServer()->getScheduler()->scheduleRepeatingTask($task, 20);
    }
}