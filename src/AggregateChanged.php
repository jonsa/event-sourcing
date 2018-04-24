<?php
/**
 * This file is part of the prooph/event-sourcing.
 * (c) 2014-2018 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2018 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Prooph\EventSourcing;

use Assert\Assertion;
use Prooph\Common\Messaging\DomainEvent;

class AggregateChanged extends DomainEvent
{
    /**
     * @var array
     */
    protected $payload = [];

    /**
     * @return static
     */
    public static function occur($aggregateId, array $payload = [])
    {
        return new static($aggregateId, $payload);
    }

    protected function __construct($aggregateId, array $payload, array $metadata = [])
    {
        //Metadata needs to be set before setAggregateId and setVersion is called
        $this->metadata = $metadata;
        $this->setAggregateId($aggregateId);
        $this->setVersion(isset($metadata['_aggregate_version']) ? $metadata['_aggregate_version'] : 1);
        $this->setPayload($payload);
        $this->init();
    }

    public function aggregateId()
    {
        return $this->metadata['_aggregate_id'];
    }

    /**
     * Return message payload as array
     *
     * The payload should only contain scalar types and sub arrays.
     * The payload is normally passed to json_encode to persist the message or
     * push it into a message queue.
     */
    public function payload()
    {
        return $this->payload;
    }

    public function version()
    {
        return $this->metadata['_aggregate_version'];
    }

    public function withVersion($version)
    {
        $self = clone $this;
        $self->setVersion($version);

        return $self;
    }

    protected function setAggregateId($aggregateId)
    {
        Assertion::notEmpty($aggregateId);

        $this->metadata['_aggregate_id'] = $aggregateId;
    }

    protected function setVersion($version)
    {
        $this->metadata['_aggregate_version'] = $version;
    }

    /**
     * This method is called when message is instantiated named constructor fromArray
     */
    protected function setPayload(array $payload)
    {
        $this->payload = $payload;
    }
}
