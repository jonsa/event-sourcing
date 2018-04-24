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

final class CustomAggregateRoot implements CustomAggregateRootContract
{
    private $historyEvents = [];

    private $version = 0;

    public function version()
    {
        return $this->version;
    }

    public static function buildFromHistoryEvents(Iterator $historyEvents)
    {
        $self = new self();

        $self->historyEvents = $historyEvents;

        return $self;
    }

    public function getHistoryEvents()
    {
        return $this->historyEvents;
    }

    public function identifier()
    {
        // not required for this mock
    }

    /**
     * @return Message[]
     */
    public function getPendingEvents()
    {
        // not required for this mock
    }
}
