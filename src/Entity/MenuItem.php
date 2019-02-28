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
 * Time: 17:56
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MenuItem
 * @package App\Entity
 */
class MenuItem
{
    /**
     * @var string
     */
    private $eventKey;

    /**
     * @return string
     */
    public function getEventKey(): string
    {
        return $this->eventKey;
    }

    /**
     * @param string $eventKey
     * @return MenuItem
     */
    public function setEventKey(string $eventKey): MenuItem
    {
        $this->eventKey = $eventKey;
        return $this;
    }

    /**
     * @var array
     */
    private $icon = [];

    /**
     * getIcon
     * @return array
     */
    public function getIcon(): array
    {
        return $this->icon = $this->icon ?: [];
    }

    /**
     * @param array $icon
     * @return MenuItem
     */
    public function setIcon(array $icon): MenuItem
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'prefix' => 'fas',
        ]);
        $resolver->setRequired([
            'iconName',
        ]);
        $resolver->setAllowedValues('prefix', ['fas','far','fab']);
        $icon = $resolver->resolve($icon);
        $this->icon = $icon;
        return $this;
    }

    /**
     * @var string
     */
    private $text;

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return MenuItem
     */
    public function setText(string $text): MenuItem
    {
        $this->text = $text;
        if (empty($this->getEventKey()))
            $this->setEventKey($text);
        return $this;
    }

    /**
     * @var ArrayCollection|null
     */
    private $items;

    /**
     * @return ArrayCollection|null
     */
    public function getItems(): ?ArrayCollection
    {
        return $this->items;
    }

    /**
     * @param ArrayCollection $items
     * @return MenuItem
     */
    public function setItems(ArrayCollection $items): MenuItem
    {
        $this->items = $items;
        return $this;
    }

    /**
     * addItem
     * @return MenuItem
     */
    public function addItem(MenuItem $item): MenuItem
    {
        if (empty($this->getItems()))
            $this->setItems(new ArrayCollection());
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
        $item = [];
        if (empty($this->getEventKey()))
            return $item;
        $item['eventKey'] = $this->getEventKey();
        $item['text'] = substr($this->getText(), 0, 24);
        $item['icon'] = $this->getIcon();
        if (! empty($this->getItems()))
        {
            foreach($this->getItems()->toArray() as $value)
            {
                if (!empty($value->toArray()))
                    $item['items'][] = $value->toArray();
            }
        }
        $item['route'] = $this->getRoute();
        return $item;
    }

    /**
     * @var string
     */
    private $route = '/';

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @param string $route
     * @return MenuItem
     */
    public function setRoute(string $route): MenuItem
    {
        $this->route = $route;
        return $this;
    }
}