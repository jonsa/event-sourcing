<?php
/**
 * This file is part of the prooph/event-sourcing.
 * (c) 2014-2018 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2018 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Prooph\EventSourcing\EventStoreIntegration;

use Iterator;
use Prooph\Common\Messaging\Message;
use Prooph\EventSourcing\Aggregate\AggregateTranslator as EventStoreAggregateTranslator;
use Prooph\EventSourcing\Aggregate\AggregateType;
use RuntimeException;

final class ClosureAggregateTranslator implements EventStoreAggregateTranslator
{
    protected $aggregateIdExtractor;
    protected $aggregateReconstructor;
    protected $pendingEventsExtractor;
    protected $replayStreamEvents;
    protected $versionExtractor;

    /**
     * @param object $eventSourcedAggregateRoot
     *
     * @return int
     */
    public function extractAggregateVersion($eventSourcedAggregateRoot)
    {
        if (null === $this->versionExtractor) {
            $this->versionExtractor = function () {
                return $this->version;
            };
        }

        $closure = $this->versionExtractor->bindTo($eventSourcedAggregateRoot, $eventSourcedAggregateRoot);
        return $closure();
    }

    /**
     * @param object $anEventSourcedAggregateRoot
     *
     * @return string
     */
    public function extractAggregateId($anEventSourcedAggregateRoot)
    {
        if (null === $this->aggregateIdExtractor) {
            $this->aggregateIdExtractor = function () {
                return $this->aggregateId();
            };
        }

        $closure = $this->aggregateIdExtractor->bindTo($anEventSourcedAggregateRoot, $anEventSourcedAggregateRoot);
        return $closure();
    }

    /**
     * @param AggregateType $aggregateType
     * @param Iterator $historyEvents
     *
     * @return object reconstructed AggregateRoot
     */
    public function reconstituteAggregateFromHistory(AggregateType $aggregateType, Iterator $historyEvents)
    {
        if (null === $this->aggregateReconstructor) {
            $this->aggregateReconstructor = function ($historyEvents) {
                return static::reconstituteFromHistory($historyEvents);
            };
        }

        $arClass = $aggregateType->toString();

        if (! class_exists($arClass)) {
            throw new RuntimeException(
                sprintf('Aggregate root class %s cannot be found', $arClass)
            );
        }

        $closure = $this->aggregateReconstructor->bindTo(null, $arClass);

        return $closure($historyEvents);
    }

    /**
     * @param object $anEventSourcedAggregateRoot
     *
     * @return Message[]
     */
    public function extractPendingStreamEvents($anEventSourcedAggregateRoot)
    {
        if (null === $this->pendingEventsExtractor) {
            $this->pendingEventsExtractor = function () {
                return $this->popRecordedEvents();
            };
        }

        $closure = $this->pendingEventsExtractor->bindTo($anEventSourcedAggregateRoot, $anEventSourcedAggregateRoot);
        return $closure();
    }

    /**
     * @param object $anEventSourcedAggregateRoot
     * @param Iterator $events
     *
     * @return void
     */
    public function replayStreamEvents($anEventSourcedAggregateRoot, Iterator $events)
    {
        if (null === $this->replayStreamEvents) {
            $this->replayStreamEvents = function ($events) {
                $this->replay($events);
            };
        }

        $closure = $this->replayStreamEvents->bindTo($anEventSourcedAggregateRoot, $anEventSourcedAggregateRoot);
        $closure($events);
    }
}
