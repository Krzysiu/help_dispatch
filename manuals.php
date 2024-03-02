<?php	
    /* 
        Main list of help providers in form extension => URL, where {TERM} gets
        substituted by term given in GET.  
        
        Special cases:
        1) If there are different extensions for single manual, you can use 
        'bar' => '>foo' syntax, which, in case if BAR extension is given, it 
        looks for value named FOO. Note the ">" symbol before "foo". 
        Note: redirects are single level, so you can't have 
        'bar' => '>foo', 'foo' => '>foobar'
        
        2) If there's more manuals for single extension, use nested array like:
        'foo' => 
        ['Name1' => 'http://example.com/{$TERM}', 
        'Name2' => 'http://example.net/{$TERM}'];
        ...and change $HTMLTemplate variable to your needs.
        
        3) you can set special, catch-all item - using key named "*" - which 
        will be triggered in case if no particular extension is on the list. 
        Using array for multiple choices seems to be a good approach here.
        
        4) if * (see special case #3) is not defined, error will be shown
    */ 
    //
    
    $manuals = [
	'php' => 'http://www.php.net/{TERM}',
	'ahk' => 'https://www.autohotkey.com/docs/v1/lib/{TERM}.htm',
    'ahk2' => 'https://www.autohotkey.com/docs/v2/lib/{TERM}.htm',
    'py' =>  'https://docs.python.org/3/search.html?q={TERM}',
    'htm' => '>html',
    'html' => [
    'Mozilla Developer Network HTML reference' => 'https://developer.mozilla.org/en-US/docs/Web/HTML/Element/{TERM}',
    'Mozilla Developer Network search engine' => 'https://developer.mozilla.org/en-US/search?q={TERM}',    
    'w3 Schools' => 'https://www.w3schools.com/tags/tag_{TERM}.asp',
    'canIuse' => 'https://caniuse.com/?search={TERM}'
    ],
    'css' => 'https://developer.mozilla.org/en-US/docs/Web/CSS/{TERM}',
    'svg' => 'https://developer.mozilla.org/en-US/docs/Web/SVG/Element/{TERM}',
    'js' => 'https://developer.mozilla.org/en-US/search?q=javascript+{TERM}', //classes, objects, functions... So let redirect to search, narrowing it down with "javascript" keyword
    '*' => [
    'StackOverflow' => 'https://stackoverflow.com/search?q={TERM}',
    'SuperUser' => 'https://superuser.com/search?q={TERM}', 
    // two above will do full-text search, unless there's a tag with that name,
    // then it will simply show questions tagged with 'term'
    'Google.com' => 'https://www.google.com/search?q={TERM}',
    'Google.com (with "manual" keyword)' => 'https://www.google.com/search?q={TERM}+manual',
    'Google.com (with "programming" keyword)' => 'https://www.google.com/search?q={TERM}+programming',    
    ],
];