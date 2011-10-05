Chrysellia
==========

Chrysellia was a first attempt at the development of a reusable game engine 
in PHP. While the code and techniques here are somewhat outdated, it provides
an interesting look at how one may build an efficient webgame.

Installation
------------
* Upload the contents os WebClient to root directory on server. 
* Upload Server directory (intact) into this directory.
* Update /Server/Common/Config.inc.php to use your mysql credentials (and
  obivously, you'll need to create a mysql user, password, and database too.)
* Run the MySQL files in /Server/Database/MySql/SQL Files in this order:
  * ChrysoliteEngine.sql
  * ./Content/default_channels.sql
  * ./Content/item_templates.sql
  * ./Content/item_template_equippables.sql
  * ./Content/item_template_socketables.sql
  * ./Content/maps.sql
  * ./Content/map_place_types.sql
  * ./Content/map_places.sql
  * ./Content/map_monsters.sql
  * ./Content/mastery_types.sql
  * ./Content/parlaor.sql
  * ./Content/races.sql
  * ./Content/races.sql
  * ./Content/race_default_items.sql
  * ./Content/race_default_masteries.sql
