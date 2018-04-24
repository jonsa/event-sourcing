<?php
/**
 * This file is part of the prooph/event-sourcing.
 * (c) 2014-2018 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2018 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace ProophTest\EventSourcing\EventStoreIntegration;

use ArrayIterator;
use BadMethodCallException;
use PHPUnit\Framework\TestCase;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\EventStoreIntegration\AggregateRootDecorator;
use ProophTest\EventSourcing\Mock\ExtendedAggregateRootDecorator;
use RuntimeException;

class AggregateRootDecoratorTest extends TestCase
{
    /**
     * @test
     */
    public function it_throws_exception_when_reconstitute_from_history_with_invalid_class()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Aggregate root class UnknownClass cannot be found');

        $decorator = AggregateRootDecorator::newInstance();
        $decorator->fromHistory('UnknownClass', new ArrayIterator([]));
    }

    /**
     * @test
     */
    public function it_throws_exception_when_accessing_aggregate_id()
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('The AggregateRootDecorator does not have an id');

        $decorator = ExtendedAggregateRootDecorator::newInstance();
        $decorator->getAggregateId();
    }

    /**
     * @test
     */
    public function it_does_nothing_on_apply_by_default()
    {
        $event = $this->prophesize(AggregateChanged::class);

        $decorator = ExtendedAggregateRootDecorator::newInstance();

        $this->assertNull($decorator->doApply($event->reveal()));
    }
}
