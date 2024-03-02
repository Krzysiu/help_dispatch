# help_dispatch
Self-hosted tool, mainly for Notepad++/npp_exec plugin combo to HTTP redirect user to proper language manual(s) by giving extension and function name in URL.

## Installation as NppExec script
1. Install Notepad++
2. Upload `dispatch.php` and `manuals.php` to webserver or...
3. You can also use PHP's built-in server (run `php -S 127.0.0.1:5666 -t C:\PATH_TO_SCRIPT`) and then URL will be http://127.0.0.1:5666/dispatch.php
4. Check if everything is working properly, e.g. by checking in browser http://HOSTNAME/dispatch.php?term=strpos&lang=php
5. Go to `Plugins menu>Plugin admin...` and search for `NppExec`, or download it from [author's repo](https://github.com/d0vgan/nppexec/releases)
6. After restarting N++, go to `Plugins>NppExec` and press `F6` or choose `Execute Nppexec Script...`
7. In the text box paste contents of `nppExecScript.txt` (remember to set script URL!)
8. Click on `Save` and give it name (we will use it in the next point)
9. Go to `Setting>Shortcut Mapper...` and click on the top tab `Plugin Commands`. Find your script (by name you used in previous point) and set shortcut. I used NPP's standard `ALT+F1`.

## Usage in N++
Just save the file (for language recognition/extension), click or select the command you need to get manual for, press ALT+F1 (see installation, last point)

## Usage in other tools
Figure it out :) Just set your editor to open `dispatch.php?term={SELECTED_WORD}&lang={EXTENSION OR TYPE}`

## Configuring new/more manuals
Four basic ways, all need editing of `manual.php`
1. **Automatic redirect**: add array element in format EXTENSION => URL{TERM} where {TERM} will be replaced with current word (e.g. `'php' => 'http://www.php.net/{TERM}'`)
2. **Multiple manuals**: add array element with nested array to make `dispatch.php` in format `NAME => URL` show multiple choices (e.g. `py => ['Python3' => 'https://docs.python.org/3/search.html?q={TERM}', '3rd party' => 'https://example.com/lrn2write/{TERM}']` - this way for .py files, it will show `Python3`, linking to `.../3/...` and `3rd party` linking to `...example.com/lrn2write/`)
3. **Aliases**: just set key name to name and value to alias, (e.g. `['php3' => 'php']` will use `php` entry for files with extension `php3`. Also, if you remember this extenstion, how's your back today? ;))
4. **Undefined/catch-all**: set keyname for * and value to page (or pages, see 2.) which will be shown if no extension is given. **This can be also used to ask semiquestions/questions**, e.g. selecting 'parsing dom python' with default manuals.php you'll get links to search engine of StackOverflow and Google.

## Screenshot
Just one, as this script just redirects you to proper manuals.
![screenshot](https://github.com/Krzysiu/help_dispatch/assets/2560298/69935bbc-0544-4c35-8ed0-e4f7f90b8de4)

## Requesting manuals
Either write an issue or create pull request.
