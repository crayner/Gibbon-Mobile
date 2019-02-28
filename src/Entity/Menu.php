<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon, Flexible & Open School System
 * Copyright (C) 2010, Ross Parker
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program in the LICENCE file.
 * If not, see <http://www.gnu.org/licenses/>.
 *
 * Gibbon-Mobile
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