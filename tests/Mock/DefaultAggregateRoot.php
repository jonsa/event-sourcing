<?php
/**
 * This file is part of the prooph/event-sourcing.
 * (c) 2014-2018 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2018 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace ProophTest\EventSourcing\Mock;

use Iterator;
use Prooph\Common\Messaging\Message;

final class DefaultAggregateRoot implements DefaultAggregateRootContract
{
    private $historyEvents = [];

    /**
     * @var int
     */
    private $version = 0;

    public function getVersion()
    {
        return $this->version;
    }

    public static function reconstituteFromHistory(Iterator $historyEvents)
    {
        $self = new self();

        $self->historyEvents = iterator_to_array($historyEvents);

        return $self;
    }

    public function getHistoryEvents()
    {
        return $this->historyEvents;
    }

    public function getId()
    {
        // not required for this mock
    }

    /**
     * @return Message[]
     */
    public function popRecordedEvents()
    {
        // not required for this mock
    }

    public function replay($event)
    {
        // not required for this mock
    }
}
