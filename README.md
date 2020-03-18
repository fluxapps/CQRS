# CQRS
Contains the basic structure for a DDD / CQRS project (optionally event sourced):
* Abstracts and Interfaces for:
    * Aggregates
    * Entities
    * ValueObjects
    * Commands
    * CommandHandlers
    * Events
    * EventSourced Aggregates / EventStores
    * Projections
    * Revisions
    * ...
* Infrastructure:
    * CommandBus

## Getting Started

### Requirements
* ILIAS 5.4 - 6.0
* PHP >= 7.2

### Installing
Add to your composer.json "require":

`"srag/cqrs": ">=1.2.1"`

## Authors

This is an OpenSource project by studer + raimann ag (https://studer-raimann.ch)

## License

This project is licensed under the GPL v3 License 

### ILIAS Plugin SLA

We love and live the philosophy of Open Source Software! Most of our developments, which we develop on behalf of customers or on our own account, are publicly available free of charge to all interested parties at https://github.com/studer-raimann.

Do you use one of our plugins professionally? Secure the timely availability of this plugin for the upcoming ILIAS versions via SLA. Please inform yourself under https://studer-raimann.ch/produkte/ilias-plugins/plugin-sla.

Please note that we only guarantee support and release maintenance for institutions that sign a SLA.