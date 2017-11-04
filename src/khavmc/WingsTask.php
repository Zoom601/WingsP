<?php

namespace khavmc;

use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\scheduler\PluginTask;
use khavmc\Main;
use pocketmine\level\particle\DustParticle;

class WingsTask extends PluginTask
{

    private $image;

    public function __construct(Plugin $owner)
    {
        parent::__construct($owner);
        $this->image = imagecreatefrompng($owner->getDataFolder() . "Wings.png");
    }

    public function onRun(int $currentTick): void
    {
        foreach ($this->getOwner()->getServer()->getOnlinePlayers() as $player) {
            $directionVector = $player->getDirectionVector();
            $sub = $player->getDirectionVector()->multiply(0.5); // Because the direction vector is 1 block away from the player, we need to get a point closer to the player so the wings don't have a gap between the player.
            $base = $player->subtract($sub)->add(0, 1.8); // We try to get the base on a proper location here. First subtract the sub to get it at the right distance from the player, then make it higher.
            $particleDistance = 0.13; // This is the distance between the particles. You have to use a value you like.
            $imageHeight = 16;
            $halfImageWidth = 16;
            for ($x = -$halfImageWidth; $x < $halfImageWidth; $x++) { // We use the half negative + half positive width to center the wings correctly.
                for ($y = 0; $y < $imageHeight; $y++) {
                    $pos = $base->add($directionVector->z * $x * $particleDistance, -$y * $particleDistance, -$directionVector->x * $x * $particleDistance);

                    $rgba = imagecolorsforindex($this->image, imagecolorat($this->image, $x + 16, $y)); // First we translate the colors on the X and Y position to a readable colour array.
                    $alpha = $rgba["alpha"];
                    if ($alpha >= 95) { // We check if the alpha value is reasonably high, as alpha particles do not actually show their alpha value.
                        continue;
                    }
                    $player->level->addParticle(new DustParticle($pos, $rgba["red"], $rgba["green"], $rgba["blue"], $rgba["alpha"])); // We'll now add the particle with the colours of the original image.
                }
            }
        }
    }
}