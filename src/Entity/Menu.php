<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 27/02/2019
 * Time: 17:58
 */

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class Menu
{
    /**
     * @var ArrayCollection
     */
    private $items;

    /**
     * @return ArrayCollection
     */
    public function getItems(): ArrayCollection
    {
        if (empty($this->items))
            $this->items = new ArrayCollection();
        return $this->items;
    }

    /**
     * @param ArrayCollection $items
     * @return Menu
     */
    public function setItems(ArrayCollection $items): Menu
    {
        $this->items = $items;
        return $this;
    }

    /**
     * addItem
     * @param MenuItem $item
     * @return Menu
     */
    public function addItem(MenuItem $item): Menu
    {
        if ($this->getItems()->contains($item))
            return $this;
        if (! empty($item->getEventKey()))
            $this->items->set($item->getEventKey(), $item);
        return $this;
    }

    /**
     * toArray
     * @return array
     */
    public function toArray(): array
    {
        $menu = [];
        foreach($this->getItems()->toArray() as $item)
        {
            if (! empty($item->toArray()))
                $menu[] = $item->toArray();
        }
        return $menu;
    }
}