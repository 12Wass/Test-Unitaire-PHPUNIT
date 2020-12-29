<?php

namespace App\Test;

use App\Entity\Item;
use PHPUnit\Framework\TestCase;
use DateTime;
use DateInterval;

class ItemTest extends TestCase
{
    private $item;

    protected function setUp(): void
    {
        parent::setUp();

        $today = new DateTime('now');
        $createdItemAt = $today->add(new DateInterval('PT45M'));

        $this->item = new Item(
            'Devenir le maître du monde',
            'Toujours en restant gentil, bien évidemment.',
            $createdItemAt
        );
    }

    public function testIsValidNominal()
    {
        $this->assertTrue($this->item->isValid());
    }

    public function testIsNameEmpty()
    {
        $this->item->setName('');
        $this->assertFalse($this->item->isValid());
    }

    public function testIsContentEmpty()
    {
        $this->item->setContent('');
        $this->assertFalse($this->item->isValid());
    }

    public function testIsLengthContent()
    {
        $this->item->setContent('zk');
        $this->assertTrue($this->item->isValid());
    }

    public function testIsDateEmpty()
    {
        $this->item->setCreatedAt('');
        $this->assertFalse($this->item->isValid());
    }
}