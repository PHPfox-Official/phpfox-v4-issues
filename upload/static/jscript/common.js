
/**
* Define the browser and OS
*
* @var	string	userAgent Useragent string
* @var	boolean	bIsIE  IE
* @var	boolean	bIsWin    Windows
*/
var sClientInfo = navigator.userAgent.toLowerCase();
var bIsIE = (sClientInfo.indexOf("msie") != -1);
var bIsWin = ((sClientInfo.indexOf("win")!=-1) || (sClientInfo.indexOf("16bit") != -1));

function getParam(sParam)
{
	return oParams[sParam];
}

function getPhrase(sParam)
{
	return oTranslations[sParam];	
}

function isModule(sModule)
{
	return (typeof(oModules[sModule]) != 'undefined' ? true : false);
}

function debug(sMessage)
{
	if (getCookie('js_console'))
	{
		if ($('#firebug_no_console').length <= 0)
		{
			var $sConsole = '';
			$sConsole += '<div id="firebug_no_console" style="position:fixed; bottom:0px; left:0px; z-index:9000; border-top:2px #000 solid; width:100%; text-align:left;">';
			$sConsole += '<div style="background:#5F5F5F; color:#fff; padding:4px; font-size:14px; font-weight:bold;">Javascript Console</div>';
			$sConsole += '<div style="background:#5F5F5F; color:#fff; padding:4px; font-size:12px; font-weight:bold; border-top:1px #3F3F3F solid;"><a href="#" onclick="$(\'#firebug_no_console_content\').html(\'\'); return false;">Clear</a></div>';
			$sConsole += '<div id="firebug_no_console_content" style="height:200px; overflow:auto; background:#0F0F0F; color:#fff;"></div>';
			$sConsole += '</div>';
				
			$('body').prepend($sConsole);
		}
		$('#firebug_no_console_content').prepend('<div style="border-bottom:1px #4F4F4F solid; padding:5px 0px 5px 10px;">' + sMessage + '</div>');
	}	
	
	if (typeof console === 'undefined' || typeof console.log == 'undefined')
	{			
		return false;
	}
	console.log(sMessage);
}

function p(sMessage)
{
	debug(sMessage);	
}

function d(aArray)
{
	p(print_r(aArray, true));
}

function setCookie(name, value, expires) 
{
	var today = new Date();
	
	today.setTime( today.getTime() );
	
	if (expires)
	{
		expires = expires * 1000 * 60 * 60 * 24;
	}
	var expires_date = new Date( today.getTime() + (expires) );

	document.cookie = getParam('sJsCookiePrefix') + name + "=" +escape( value ) +
	( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) + 
	( ( getParam('sJsCookiePath') ) ? ";path=" + getParam('sJsCookiePath') : "" ) + 
	( ( getParam('sJsCookieDomain') ) ? ";domain=" + getParam('sJsCookieDomain') : "" );
	
	debug('Adding Cookie: ' + name + ' -> ' + value);
}

function deleteCookie(name) 
{
	if (this.getCookie(name)) 
	{
		document.cookie = getParam('sJsCookiePrefix') + name + "=" +	
		( ( getParam('sJsCookiePath') ) ? ";path=" + getParam('sJsCookiePath') : "") +
		( ( getParam('sJsCookieDomain') ) ? ";domain=" + getParam('sJsCookieDomain') : "" ) +
		";expires=Thu, 01-Jan-1970 00:00:01 GMT";
		debug('Deleting Cookie: ' + name);
	}
}

function getCookie(check_name) 
{
	var a_all_cookies = document.cookie.split( ';' );
	var a_temp_cookie = '';
	var cookie_name = '';
	var cookie_value = '';
	var b_cookie_found = false;
	var check_name = getParam('sJsCookiePrefix') + check_name;

	for (var i = 0; i < a_all_cookies.length; i++ )
	{
		a_temp_cookie = a_all_cookies[i].split( '=' );		
		
		cookie_name = a_temp_cookie[0].replace(/^\s+|\s+$/g, '');
	
		if ( cookie_name == check_name )
		{
			b_cookie_found = true;

			if ( a_temp_cookie.length > 1 )
			{
				cookie_value = unescape( a_temp_cookie[1].replace(/^\s+|\s+$/g, '') );
			}
			return cookie_value;
			break;
		}
		a_temp_cookie = null;
		cookie_name = '';
	}
	
	if ( !b_cookie_found )
	{
		return null;
	}
}

function parse(strInputCode)
{ 
 	strInputCode = strInputCode.replace(/&(lt|gt);/g, function (strMatch, p1)
 	{
 		 	return (p1 == "lt")? "<" : ">";
 	});
	return strInputCode.replace(/<\/?[^>]+(>|$)/g, "");
}

/**
 * PHP
 */
function substr(sString, iStart, iLength) 
{ 
    if(iStart < 0) 
    {
        iStart += sString.length;
    }
 
    if(iLength == undefined) 
    {
        iLength = sString.length;
    } 
    else if(iLength < 0)
    {
        iLength += sString.length;
    } 
    else 
    {
        iLength += iStart;
    }
 
    if(iLength < iStart) 
    {
        iLength = iStart;
    }
 
    return sString.substring(iStart, iLength);
}

function str_repeat(str, repeat) 
{
	var output = '';
  	for (var i = 0; i < repeat; i++) 
  	{
    	output += str;
  	}
  	return output;
}

function print_r( array, return_val ) 
{
	var output = "", pad_char = " ", pad_val = 4;
 
    var formatArray = function (obj, cur_depth, pad_val, pad_char) 
    {
        if (cur_depth > 0) 
        {
            cur_depth++;
        }
 
        var base_pad = repeat_char(pad_val*cur_depth, pad_char);
        var thick_pad = repeat_char(pad_val*(cur_depth+1), pad_char);
        var str = "";
 
        if (obj instanceof Array || obj instanceof Object) {
            str += "Array\n" + base_pad + "(\n";
            for (var key in obj) {
                if (obj[key] instanceof Array) {
                    str += thick_pad + "["+key+"] => "+formatArray(obj[key], cur_depth+1, pad_val, pad_char);
                } else {
                    str += thick_pad + "["+key+"] => " + obj[key] + "\n";
                }
            }
            str += base_pad + ")\n";
        } else if(obj == null || obj == undefined) {
            str = '';
        } else {
            str = obj.toString();
        }
 
        return str;
    };
 
    var repeat_char = function (len, pad_char) {
        var str = "";
        for(var i=0; i < len; i++) { 
            str += pad_char; 
        };
        return str;
    };
    output = formatArray(array, 0, pad_val, pad_char);
 
    if (return_val !== true) {
        document.write("<pre>" + output + "</pre>");
        return true;
    } else {
        return output;
    }
}

function isset() 
{
    var a=arguments; var l=a.length; var i=0;
    
    if (l==0) { 
	        throw new Error('Empty isset'); 
    }
    
    while (i!=l) {
        if (typeof(a[i])=='undefined' || a[i]===null) { 
            return false; 
        } else { 
            i++; 
        }
    }
    return true;
}

function empty(mixed_var) {
    var key;
    
    if (mixed_var === ""
        || mixed_var === 0
        || mixed_var === "0"
        || mixed_var === null
        || mixed_var === false
        || mixed_var === undefined
        || trim(mixed_var) == ""
    ){
        return true;
    }
    if (typeof mixed_var == 'object') {
        for (key in mixed_var) {
            if (typeof mixed_var[key] !== 'function' ) {
              return false;
            }
        }
        return true;
    }
    return false;
}

function trim(str, charlist) { 
    var whitespace, l = 0, i = 0;
    str += '';
    
    if (!charlist) {
        whitespace = " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
    } else {
        charlist += '';
        whitespace = charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '\$1');
    }
    
    l = str.length;
    for (i = 0; i < l; i++) {
        if (whitespace.indexOf(str.charAt(i)) === -1) {
            str = str.substring(i);
            break;
        }
    }
    
    l = str.length;
    for (i = l - 1; i >= 0; i--) {
        if (whitespace.indexOf(str.charAt(i)) === -1) {
            str = str.substring(0, i + 1);
            break;
        }
    }
    
    return whitespace.indexOf(str.charAt(0)) === -1 ? str : '';
}

function ltrim ( str, charlist ) { 
    charlist = !charlist ? ' \s\xA0' : (charlist+'').replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '\$1');
    var re = new RegExp('^[' + charlist + ']+', 'g');
    return (str+'').replace(re, '');
}

function rtrim ( str, charlist ) { 
    charlist = !charlist ? ' \s\xA0' : (charlist+'').replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '\$1');
    var re = new RegExp('[' + charlist + ']+$', 'g');
    return (str+'').replace(re, '');
}

function function_exists( function_name ) { 
    if (typeof function_name == 'string'){
        return (typeof window[function_name] == 'function');
    } else{
        return (function_name instanceof Function);
    }
}

function explode( delimiter, string, limit ) { 
    var emptyArray = { 0: '' };
    
    if ( arguments.length < 2
        || typeof arguments[0] == 'undefined'
        || typeof arguments[1] == 'undefined' )
    {
        return null;
    }
 
    if ( delimiter === ''
        || delimiter === false
        || delimiter === null )
    {
        return false;
    }
 
    if ( typeof delimiter == 'function'
        || typeof delimiter == 'object'
        || typeof string == 'function'
        || typeof string == 'object' )
    {
        return emptyArray;
    }
 
    if ( delimiter === true ) {
        delimiter = '1';
    }
    
    if (!limit) {
        return string.toString().split(delimiter.toString());
    } else {
        var splitted = string.toString().split(delimiter.toString());
        var partA = splitted.splice(0, limit - 1);
        var partB = splitted.join(delimiter.toString());
        partA.push(partB);
        return partA;
    }
}

function in_array(needle, haystack, strict) { 
    var found = false, key, strict = !!strict;
 
    for (key in haystack) {
        if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
            found = true;
            break;
        }
    }
 
    return found;
}

function getResizedWindow() 
{
	var myWidth = 0;
	var myHeight = 0;
  	if( typeof( window.innerWidth ) == 'number' ) 
  	{
    	//Non-IE
    	myWidth = window.innerWidth;
    	myHeight = window.innerHeight;
  	} 
  	else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight )) 
  	{
    	//IE 6+ in 'standards compliant mode'
    	myWidth = document.documentElement.clientWidth;
    	myHeight = document.documentElement.clientHeight;
  	} else if( document.body && ( document.body.clientWidth || document.body.clientHeight )) 
  	{
    	//IE 4 compatible
    	myWidth = document.body.clientWidth;
    	myHeight = document.body.clientHeight;
  	}
  
  return myHeight;
}

function htmlspecialchars (string, quote_style, charset, double_encode) {
    // http://kevin.vanzonneveld.net
    // +   original by: Mirek Slugen
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Nathan
    // +   bugfixed by: Arno
    // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    bugfixed by: Brett Zamir (http://brett-zamir.me)
    // +      input by: Ratheous
    // +      input by: Mailfaker (http://www.weedem.fr/)
    // +      reimplemented by: Brett Zamir (http://brett-zamir.me)
    // +      input by: felix
    // +    bugfixed by: Brett Zamir (http://brett-zamir.me)
    // %        note 1: charset argument not supported
    // *     example 1: htmlspecialchars("<a href='test'>Test</a>", 'ENT_QUOTES');
    // *     returns 1: '&lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt;'
    // *     example 2: htmlspecialchars("ab\"c'd", ['ENT_NOQUOTES', 'ENT_QUOTES']);
    // *     returns 2: 'ab"c&#039;d'
    // *     example 3: htmlspecialchars("my "&entity;" is still here", null, null, false);
    // *     returns 3: 'my &quot;&entity;&quot; is still here'

    var optTemp = 0, i = 0, noquotes= false;
    if (typeof quote_style === 'undefined' || quote_style === null) {
        quote_style = 2;
    }
    string = string.toString();
    if (double_encode !== false) { // Put this first to avoid double-encoding
        string = string.replace(/&/g, '&amp;');
    }
    string = string.replace(/</g, '&lt;').replace(/>/g, '&gt;');

    var OPTS = {
        'ENT_NOQUOTES': 0,
        'ENT_HTML_QUOTE_SINGLE' : 1,
        'ENT_HTML_QUOTE_DOUBLE' : 2,
        'ENT_COMPAT': 2,
        'ENT_QUOTES': 3,
        'ENT_IGNORE' : 4
    };
    if (quote_style === 0) {
        noquotes = true;
    }
    if (typeof quote_style !== 'number') { // Allow for a single string or an array of string flags
        quote_style = [].concat(quote_style);
        for (i=0; i < quote_style.length; i++) {
            // Resolve string input to bitwise e.g. 'PATHINFO_EXTENSION' becomes 4
            if (OPTS[quote_style[i]] === 0) {
                noquotes = true;
            }
            else if (OPTS[quote_style[i]]) {
                optTemp = optTemp | OPTS[quote_style[i]];
            }
        }
        quote_style = optTemp;
    }
    if (quote_style & OPTS.ENT_HTML_QUOTE_SINGLE) {
        string = string.replace(/'/g, '&#039;');
    }
    if (!noquotes) {
        string = string.replace(/"/g, '&quot;');
    }

    return string;
}

  // getPageScroll() by quirksmode.com
  function getPageScroll() {
    var xScroll;
    var yScroll;
    if (self.pageYOffset) {
      yScroll = self.pageYOffset;
      xScroll = self.pageXOffset;
    } else if (document.documentElement && document.documentElement.scrollTop) {	 // Explorer 6 Strict
      yScroll = document.documentElement.scrollTop;
      xScroll = document.documentElement.scrollLeft;
    } else if (document.body) {// all other Explorers
      yScroll = document.body.scrollTop;
      xScroll = document.body.scrollLeft;
    }
    return new Array(xScroll,yScroll);
  }

  // Adapted from getPageSize() by quirksmode.com
  function getPageHeight() {
    var windowHeight;
    if (self.innerHeight) {	// all except Explorer
      windowHeight = self.innerHeight;
    } else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
      windowHeight = document.documentElement.clientHeight;
    } else if (document.body) { // other Explorers
      windowHeight = document.body.clientHeight;
    }
    return windowHeight;
  }
  
function htmlentities (str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');

}

function parse_url (str, component) {
    // http://kevin.vanzonneveld.net
    // +      original by: Steven Levithan (http://blog.stevenlevithan.com)
    // + reimplemented by: Brett Zamir (http://brett-zamir.me)
    // %          note: Based on http://stevenlevithan.com/demo/parseuri/js/assets/parseuri.js
    // %          note: blog post at http://blog.stevenlevithan.com/archives/parseuri
    // %          note: demo at http://stevenlevithan.com/demo/parseuri/js/assets/parseuri.js
    // %          note: Does not replace invaild characters with '_' as in PHP, nor does it return false with
    // %          note: a seriously malformed URL.
    // %          note: Besides function name, is the same as parseUri besides the commented out portion
    // %          note: and the additional section following, as well as our allowing an extra slash after
    // %          note: the scheme/protocol (to allow file:/// as in PHP)
    // *     example 1: parse_url('http://username:password@hostname/path?arg=value#anchor');
    // *     returns 1: {scheme: 'http', host: 'hostname', user: 'username', pass: 'password', path: '/path', query: 'arg=value', fragment: 'anchor'}

    var  o   = {
        strictMode: false,
        key: ["source","protocol","authority","userInfo","user","password","host","port","relative","path","directory","file","query","anchor"],
        q:   {
            name:   "queryKey",
            parser: /(?:^|&)([^&=]*)=?([^&]*)/g
        },
        parser: {
            strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
            loose:  /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/\/?)?((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/ // Added one optional slash to post-protocol to catch file:/// (should restrict this)
        }
    };
    
    var m   = o.parser[o.strictMode ? "strict" : "loose"].exec(str),
    uri = {},
    i   = 14;
    while (i--) {uri[o.key[i]] = m[i] || "";}
    // Uncomment the following to use the original more detailed (non-PHP) script
    /*
        uri[o.q.name] = {};
        uri[o.key[12]].replace(o.q.parser, function ($0, $1, $2) {
        if ($1) {uri[o.q.name][$1] = $2;}
        });
        return uri;
    */

    switch (component) {
        case 'PHP_URL_SCHEME':
            return uri.protocol;
        case 'PHP_URL_HOST':
            return uri.host;
        case 'PHP_URL_PORT':
            return uri.port;
        case 'PHP_URL_USER':
            return uri.user;
        case 'PHP_URL_PASS':
            return uri.password;
        case 'PHP_URL_PATH':
            return uri.path;
        case 'PHP_URL_QUERY':
            return uri.query;
        case 'PHP_URL_FRAGMENT':
            return uri.anchor;
        default:
            var retArr = {};
            if (uri.protocol !== '') {retArr.scheme=uri.protocol;}
            if (uri.host !== '') {retArr.host=uri.host;}
            if (uri.port !== '') {retArr.port=uri.port;}
            if (uri.user !== '') {retArr.user=uri.user;}
            if (uri.password !== '') {retArr.pass=uri.password;}
            if (uri.path !== '') {retArr.path=uri.path;}
            if (uri.query !== '') {retArr.query=uri.query;}
            if (uri.anchor !== '') {retArr.fragment=uri.anchor;}
            return retArr;
    }
}

function isScrolledIntoView(elem)
{
	if (!$Core.exists(elem)){
		return;
	}
	
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();

    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();

	return ((docViewTop < elemTop) && (docViewBottom > elemBottom));
}