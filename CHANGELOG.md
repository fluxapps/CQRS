# Changelog

## [1.2.3]
- made ledgers occurred_at nullable

## [1.2.2]
- added missing namespace in ilDBPositionLedger

## [1.2.1]
- bugfix (wrong namespace)

## [1.2.0]
- Introduced EventID
- Introduced Projections

## [1.1.5]
- added event publisher and subscriber
- major changes to abstract value object
- some small refactorings

## [1.1.4]
- dependency to ramsey/uuid
- added missing 'restore' method in DomainEvent interface
- phpdocs

## [1.1.3]
- small adjustments
- changes in domain event

## [1.1.2]
- fix in namespace

## [1.1.1]
- changed namespace: srag\Libraries\CQRS\Command -> srag\CQRS\Command

## [1.1.0]
- restructuring for packagist

## [1.0.0]
- First version, contains: 
    * Aggregates
    * Entities
    * ValueObjects
    * Commands
    * CommandHandlers
    * Events
    * EventSourced Aggregates / EventStores
    * Projections
    * Revisions
    * CommandBus
