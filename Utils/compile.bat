::Page-specific startup file compilation + gzipping
	"C:\Python27\python" compile.py ../WebClient/js/index-startup.js > ../WebClient/js/index-startup.min.js
	"C:\Program Files (x86)\GnuWin32\bin\gzip" ../WebClient/js/index-startup.min.js --to-stdout --best > ../WebClient/js/index-startup.min.js.gz

	"C:\Python27\python" compile.py ../WebClient/js/game-startup.js > ../WebClient/js/game-startup.min.js
	"C:\Program Files (x86)\GnuWin32\bin\gzip" ../WebClient/js/game-startup.min.js --to-stdout --best > ../WebClient/js/game-startup.min.js.gz

	"C:\Python27\python" compile.py ../WebClient/js/startup.js > ../WebClient/js/startup.min.js
	"C:\Program Files (x86)\GnuWin32\bin\gzip" ../WebClient/js/startup.min.js --to-stdout --best > ../WebClient/js/startup.min.js.gz

	"C:\Python27\python" compile.py ../WebClient/js/account-startup.js > ../WebClient/js/account-startup.min.js
	"C:\Program Files (x86)\GnuWin32\bin\gzip" ../WebClient/js/account-startup.min.js --to-stdout --best > ../WebClient/js/account-startup.min.js.gz

	"C:\Python27\python" compile.py ../WebClient/js/tops-startup.js > ../WebClient/js/tops-startup.min.js
	"C:\Program Files (x86)\GnuWin32\bin\gzip" ../WebClient/js/tops-startup.min.js --to-stdout --best > ../WebClient/js/tops-startup.min.js.gz

::Game core startup file compilation + gzipping
	"C:\Python27\python" compile.py ../WebClient/core/core.js ../WebClient/core/core-AccountService.js ../WebClient/core/core-APIService.js ../WebClient/core/core-CharacterService.js ../WebClient/core/core-ChatService.js ../WebClient/core/core-CommandService.js ../WebClient/core/core-Interface.js ../WebClient/core/core-ItemService.js ../WebClient/core/core-MapService.js ../WebClient/core/core-MonsterService.js ../WebClient/core/jquery-md5.js ../WebClient/core/json.js > ../WebClient/core/core.min.js
	"C:\Program Files (x86)\GnuWin32\bin\gzip" ../WebClient/core/core.min.js --to-stdout --best > ../WebClient/core/core.min.js.gz

::Plugins
	"C:\Python27\python" compile.py ../WebClient/js/consolefix.js ../WebClient/js/jquery.cookie.js ../WebClient/js/jquery.datalink.js ../WebClient/js/jquery.tipsy.js ../WebClient/js/jquery.watermark.min.js ../WebClient/js/jquery-easing.js ../WebClient/js/jsend.min.js ../WebClient/js/jstorage.js > ../WebClient/js/plugins.min.js
	"C:\Program Files (x86)\GnuWin32\bin\gzip" ../WebClient/js/plugins.min.js --to-stdout --best > ../WebClient/js/plugins.min.js.gz

::Libraries	
	"C:\Python27\python" compile.py ../WebClient/core/staticInfo/items.js ../WebClient/core/staticInfo/maps.js ../WebClient/core/staticInfo/monsters.js ../WebClient/core/staticInfo/races.js  > ../WebClient/core/staticInfo/libraries.min.js
	"C:\Program Files (x86)\GnuWin32\bin\gzip" ../WebClient/core/staticInfo/libraries.min.js --to-stdout --best > ../WebClient/core/staticInfo/libraries.min.js.gz

::CSS (previously minified)
	"C:\Program Files (x86)\GnuWin32\bin\gzip" ../WebClient/css/neflaria.min.css --to-stdout --best > ../WebClient/css/neflaria.min.css.gz
	"C:\Program Files (x86)\GnuWin32\bin\gzip" ../WebClient/css/grid.min.css --to-stdout --best > ../WebClient/css/grid.min.css.gz
	"C:\Program Files (x86)\GnuWin32\bin\gzip" ../WebClient/css/grid-fluid.min.css --to-stdout --best > ../WebClient/css/grid-fluid.min.css.gz
	
echo "Compilation completed."
pause