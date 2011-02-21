#!C:\Python27\

import httplib, urllib, sys

# Define the parameters for the POST request and encode them in
# a URL-safe format.
js = ""

for i in range(len(sys.argv)):
	if i != 0:
		js += open(sys.argv[i], 'r').read()

params = urllib.urlencode([
    # Multiple code_url parameters:
    ('js_code', js),
    ('compilation_level', 'SIMPLE_OPTIMIZATIONS'),
    ('output_format', 'text'),
    ('output_info', 'compiled_code'),
  ])

# Always use the following value for the Content-type header.
headers = { "Content-type": "application/x-www-form-urlencoded" }
conn = httplib.HTTPConnection('closure-compiler.appspot.com')
conn.request('POST', '/compile', params, headers)
response = conn.getresponse()
data = response.read()
print data
conn.close