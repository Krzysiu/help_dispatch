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
require_once('manuals.php');
    
    /* 
        Variable with HTML code to show if there are multiple manuals. Used vars:
        * {URL} - URL of the manual
        * {TERM} - searched keyword (called "term" in code)
        * {NAME} - manual provider name taken from key name in the array
        PHP's built-in str_replace is used for variable substitution, so you can 
        either omit some variables or use them multiple times
    */
    $HTMLTemplate = '<li><a href="{URL}"><tt>{TERM}</tt> in <strong>{NAME}</strong></li>';
	
	// _GET checks
	if (!$_GET) exit;
	$data = array_map('trim', $_GET); // in case if term would be "\nterm"
	array_filter($data); //remove empty GET parameters to ensure better checking of validity
    
	if (!array_key_exists('ext', $data) || !array_key_exists('term', $data)) exit; 
    
	$term = urlencode(strtolower($data['term']));
    
	$ext = substr($data['ext'], 0, 1) === '.' ? substr($data['ext'], 1) : $data['ext']; // normalize ext (remove leading dot if exists)
    
    if (!array_key_exists($ext, $manuals) && array_key_exists('*', $manuals)) $ext = '*';
	if (array_key_exists($ext, $manuals)) {  // help available
        $urlTemplate = $manuals[$ext]; // variable for URL template(s)
        if (!is_array($manuals[$ext]) && substr($manuals[$ext], 0, 1) === '>') { // parse redirects
            if (!array_key_exists(substr($manuals[$ext], 1), $manuals)) {
                echo 'Wrong redirect'; // error: redirect to non-existent key 
                exit; 
                } elseif (!is_array($manuals[substr($manuals[$ext], 1)]) && substr($manuals[substr($manuals[$ext], 1)], 0, 1) === '>') {
                printf('Multiple redirect or infinite loop detected: <strong><tt>%s=>%s=>%s</tt></strong>', htmlentities($ext), htmlentities(substr($manuals[$ext], 1)), htmlentities(substr($manuals[substr($manuals[$ext], 1)], 1)));
                exit;
                
            } else $urlTemplate = $manuals[substr($manuals[$ext], 1)];
        }
        if (is_array($urlTemplate)) { 
            foreach ($urlTemplate as $name => $manpage) {
                //print HTML if there's multiple manuals
                $url = str_replace('{TERM}', $term, $manpage);
                echo str_replace(['{URL}', '{TERM}', '{NAME}'], [$url, htmlentities($term), htmlentities($name)], $HTMLTemplate);
            }
            exit;
        }
        
        $url = str_replace('{TERM}', $term, $urlTemplate);		
        header('Location: ' . $url, true, 301); // after zillion of "ifs" - final redirect!        
        exit;
        } else {
        printf('No help entry found for <strong><tt>%s</tt></strong>. Searched term: <strong><tt>%s</tt></strong>', htmlentities($ext), htmlentities($data['term']));
    }                        