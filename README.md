# Star Atlas

This is the initial, unfinished, work on a rebuild of staratlas.co.uk. The original site was built as a university project over a decade ago. The plan for the rebuild is to bring it up to date with more modern PHP concepts and provide a publicly available API to fetch star and planetary information.

Note: Unit tests are not currently all passing

## Setup

Clone the repository to your chosen folder. Run "composer install". Import the data.sql into a newly created database. Copy the config.sample.yml file in the app folder to config.yml and edit with your database connection details.

## Routes

*_/planets_* - Get a full listing of planets
*_/planets/Mercury_* - Get details of a particular planet by its name
*_/stars_* - Get a full listing of stars
*_/stars/32349_* - Get details of a particular star by its Hipparcos catalogue number
*_/moon_* - Get details about the Moon

## Credits

All formulas are derived from:
Duffett-Smith, Peter (1988), Practical Astronomy with your Calculator 3rd Edition, Cambridge University Press
Meeus, Jean (1991), Astronomical Algorithms, Willmann-Bell Inc
