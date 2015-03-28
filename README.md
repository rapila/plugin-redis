# Redis caching strategy for rapila 1.5+

## Configuration

Add a configuration for the redis caching strategy to a config/caching.yml:

	strategies:
	…
		redis:
			class: "CachingStrategyRedis"
			options:
				host: "fillme"
				port: 6379
				password: "fillme"

Use the strategies for the modules you want:

	modules:
		templates: "redis"

Or use it for all modules (except images, which has to be overridden explicitly):

	modules:
		_default: "redis"


## License

The rapila redis plugin is freely distributable under the terms of an MIT-style license.

Copyright (c) 2015 The Rapila Team, http://rapi.la/

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
