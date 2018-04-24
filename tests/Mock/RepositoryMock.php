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

use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateTranslator;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\StreamName;
use Prooph\SnapshotStore\SnapshotStore;

final class RepositoryMock extends AggregateRepository
{
    public function accessEventStore()
    {
        return $this->eventStore;
    }

    public function accessAggregateType()
    {
        return $this->aggregateType;
    }

    public function accessAggregateTranslator()
    {
        return $this->aggregateTranslator;
    }

    public function accessDeterminedStreamName($aggregateId = null)
    {
        return $this->determineStreamName($aggregateId);
    }

    public function accessOneStreamPerAggregateFlag()
    {
        return $this->oneStreamPerAggregate;
    }

    public function accessSnapshotStore()
    {
        return $this->snapshotStore;
    }
}
