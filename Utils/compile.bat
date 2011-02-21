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

echo "Compilation completed."
pause