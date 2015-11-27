/* 
 * This file controls how the mass uploader looks. It does not implement behavior but it could.
 * The best place to implement behavior changes is in the controller that shows the upload
 * flash object.
 * The documentation for SWFUpload can be found in
 *		/static/jscript/massuploader/Documentation/index.html
 * Not every CSS property works, for a list of supported properties please look here:
 *		http://livedocs.adobe.com/flash/9.0/ActionScriptLangRefV3/flash/text/StyleSheet.html
 *		http://livedocs.adobe.com/flash/9.0/ActionScriptLangRefV3/flash/text/TextField.html#htmlText
 *
 * The swfu object is a javascript object that interacts with the flash object. It is ultimately up to
 * the flash object to render the looks that you define in this file
 * The flash object is known not to work with css ids, use classes instead.
 * The function swfuExtra will be called when the flash object has loaded.
 */
function swfuExtra()
{
	// swfu.setButtonTextStyle(".swfuText{font-size:18px;}");
	// swfu.setButtonImageURL("http://www.yoursite.com/bg.jpg");
}