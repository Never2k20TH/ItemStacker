<?php



namespace Never2k20\ItemStacker;



use pocketmine\event\Listener;

use pocketmine\plugin\PluginBase;

use pocketmine\entity\object\ItemEntity;

use pocketmine\event\entity\ItemSpawnEvent;



class Main extends PluginBase implements Listener{

    

    public function onEnable(): void{

        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        $this->getLogger()->info("ItemStacker is work");

    }



    public function onEntitySpawn(ItemSpawnEvent $event): void{

        $entity = $event->getEntity();

        $entities = $entity->getLevel()->getNearbyEntities($entity->getBoundingBox()->expandedCopy(10, 10, 10));

        if(empty($entities)) return;

        $originalItem = $entity->getItem();

        foreach($entities as $e) {

            if($e instanceof ItemEntity and $entity->getId() !== $e->getId()) {

                $item = $e->getItem();

                if($item->getId() == $originalItem->getId() && $item->getDamage() == $originalItem->getDamage() && !$item->hasEnchantments() && !$originalItem->hasEnchantments()){

                    $e->flagForDespawn();

                    $entity->getItem()->setCount($originalItem->getCount() + $item->getCount());

                    $entity->setNameTag("§7".$entity->getItem()->getName()." §6x".$entity->getItem()->getCount());

                    //$entity->setNameTagVisible(true);

                    $entity->setNameTagAlwaysVisible(true);

                }

            }

        }

    }

}
