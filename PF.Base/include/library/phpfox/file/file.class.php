<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * Handles anything related to files and/or folders on the server.
 * 
 * Handles:
 * - checking meta data
 * - loading a file that was recently uploaded
 * - upload and move files
 * - get a list of files from a given directory
 * - delete directories
 * - copy files
 * - force a download of a file
 * - check if file/folder is writable
 * - make a new directory
 * - write to a file / create a new file
 * - write to a cache file
 * - get the servers temporary directory
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		Phpfox
 * @version 		$Id: file.class.php 6862 2013-11-07 11:00:19Z Miguel_Espinoza $
 */
class Phpfox_File
{
	/**
	 * Holds the final path of a file that was uploaded
	 *
	 * @var string
	 */
	private $_sDestination;
	
	/**
	 * Holds meta information about a file that was uploaded. Information includes $_FORM
	 *
	 * @var array
	 */
	private $_aFile = array();
	
	/**
	 * Holds the file extension of the file that was uploaded.
	 *
	 * @var string
	 */
	private $_sExt;
	
	/**
	 * Holds an ARRAY of all the supported file types identified by the routine
	 *
	 * @var array
	 */
	private $_aSupported = array();
	
	/**
	 * Holds the max size of what is allowed by the routine in bytes. Note that this
	 * is also checked by the system to make sure it can handle such a size.
	 *
	 * @var int
	 */
	private $_iMaxSize = null;
	
	/**
	 * Foruce a special file check on meta data. This feature is not being used
	 * at the moment as it was designed for MP3s
	 *
	 * @var array
	 */
	private $_aFileCheck = array(
		// 'mp3' => 
	);

	private $_aMap = [
		'123' => 'application/vnd.lotus-1-2-3',
		'3dml' => 'text/vnd.in3d.3dml',
		'3ds' => 'image/x-3ds',
		'3g2' => 'video/3gpp2',
		'3gp' => 'video/3gpp',
		'7z' => 'application/x-7z-compressed',
		'aab' => 'application/x-authorware-bin',
		'aac' => 'audio/x-aac',
		'aam' => 'application/x-authorware-map',
		'aas' => 'application/x-authorware-seg',
		'abw' => 'application/x-abiword',
		'ac' => 'application/pkix-attr-cert',
		'acc' => 'application/vnd.americandynamics.acc',
		'ace' => 'application/x-ace-compressed',
		'acu' => 'application/vnd.acucobol',
		'acutc' => 'application/vnd.acucorp',
		'adp' => 'audio/adpcm',
		'aep' => 'application/vnd.audiograph',
		'afm' => 'application/x-font-type1',
		'afp' => 'application/vnd.ibm.modcap',
		'ahead' => 'application/vnd.ahead.space',
		'ai' => 'application/postscript',
		'aif' => 'audio/x-aiff',
		'aifc' => 'audio/x-aiff',
		'aiff' => 'audio/x-aiff',
		'air' => 'application/vnd.adobe.air-application-installer-package+zip',
		'ait' => 'application/vnd.dvb.ait',
		'ami' => 'application/vnd.amiga.ami',
		'apk' => 'application/vnd.android.package-archive',
		'appcache' => 'text/cache-manifest',
		'application' => 'application/x-ms-application',
		'apr' => 'application/vnd.lotus-approach',
		'arc' => 'application/x-freearc',
		'asc' => 'application/pgp-signature',
		'asf' => 'video/x-ms-asf',
		'asm' => 'text/x-asm',
		'aso' => 'application/vnd.accpac.simply.aso',
		'asx' => 'video/x-ms-asf',
		'atc' => 'application/vnd.acucorp',
		'atom' => 'application/atom+xml',
		'atomcat' => 'application/atomcat+xml',
		'atomsvc' => 'application/atomsvc+xml',
		'atx' => 'application/vnd.antix.game-component',
		'au' => 'audio/basic',
		'avi' => 'video/x-msvideo',
		'aw' => 'application/applixware',
		'azf' => 'application/vnd.airzip.filesecure.azf',
		'azs' => 'application/vnd.airzip.filesecure.azs',
		'azw' => 'application/vnd.amazon.ebook',
		'bat' => 'application/x-msdownload',
		'bcpio' => 'application/x-bcpio',
		'bdf' => 'application/x-font-bdf',
		'bdm' => 'application/vnd.syncml.dm+wbxml',
		'bed' => 'application/vnd.realvnc.bed',
		'bh2' => 'application/vnd.fujitsu.oasysprs',
		'bin' => 'application/octet-stream',
		'blb' => 'application/x-blorb',
		'blorb' => 'application/x-blorb',
		'bmi' => 'application/vnd.bmi',
		'bmp' => 'image/x-ms-bmp',
		'book' => 'application/vnd.framemaker',
		'box' => 'application/vnd.previewsystems.box',
		'boz' => 'application/x-bzip2',
		'bpk' => 'application/octet-stream',
		'btif' => 'image/prs.btif',
		'buffer' => 'application/octet-stream',
		'bz' => 'application/x-bzip',
		'bz2' => 'application/x-bzip2',
		'c' => 'text/x-c',
		'c11amc' => 'application/vnd.cluetrust.cartomobile-config',
		'c11amz' => 'application/vnd.cluetrust.cartomobile-config-pkg',
		'c4d' => 'application/vnd.clonk.c4group',
		'c4f' => 'application/vnd.clonk.c4group',
		'c4g' => 'application/vnd.clonk.c4group',
		'c4p' => 'application/vnd.clonk.c4group',
		'c4u' => 'application/vnd.clonk.c4group',
		'cab' => 'application/vnd.ms-cab-compressed',
		'caf' => 'audio/x-caf',
		'cap' => 'application/vnd.tcpdump.pcap',
		'car' => 'application/vnd.curl.car',
		'cat' => 'application/vnd.ms-pki.seccat',
		'cb7' => 'application/x-cbr',
		'cba' => 'application/x-cbr',
		'cbr' => 'application/x-cbr',
		'cbt' => 'application/x-cbr',
		'cbz' => 'application/x-cbr',
		'cc' => 'text/x-c',
		'cct' => 'application/x-director',
		'ccxml' => 'application/ccxml+xml',
		'cdbcmsg' => 'application/vnd.contact.cmsg',
		'cdf' => 'application/x-netcdf',
		'cdkey' => 'application/vnd.mediastation.cdkey',
		'cdmia' => 'application/cdmi-capability',
		'cdmic' => 'application/cdmi-container',
		'cdmid' => 'application/cdmi-domain',
		'cdmio' => 'application/cdmi-object',
		'cdmiq' => 'application/cdmi-queue',
		'cdx' => 'chemical/x-cdx',
		'cdxml' => 'application/vnd.chemdraw+xml',
		'cdy' => 'application/vnd.cinderella',
		'cer' => 'application/pkix-cert',
		'cfs' => 'application/x-cfs-compressed',
		'cgm' => 'image/cgm',
		'chat' => 'application/x-chat',
		'chm' => 'application/vnd.ms-htmlhelp',
		'chrt' => 'application/vnd.kde.kchart',
		'cif' => 'chemical/x-cif',
		'cii' => 'application/vnd.anser-web-certificate-issue-initiation',
		'cil' => 'application/vnd.ms-artgalry',
		'cla' => 'application/vnd.claymore',
		'class' => 'application/java-vm',
		'clkk' => 'application/vnd.crick.clicker.keyboard',
		'clkp' => 'application/vnd.crick.clicker.palette',
		'clkt' => 'application/vnd.crick.clicker.template',
		'clkw' => 'application/vnd.crick.clicker.wordbank',
		'clkx' => 'application/vnd.crick.clicker',
		'clp' => 'application/x-msclip',
		'cmc' => 'application/vnd.cosmocaller',
		'cmdf' => 'chemical/x-cmdf',
		'cml' => 'chemical/x-cml',
		'cmp' => 'application/vnd.yellowriver-custom-menu',
		'cmx' => 'image/x-cmx',
		'cod' => 'application/vnd.rim.cod',
		'com' => 'application/x-msdownload',
		'conf' => 'text/plain',
		'cpio' => 'application/x-cpio',
		'cpp' => 'text/x-c',
		'cpt' => 'application/mac-compactpro',
		'crd' => 'application/x-mscardfile',
		'crl' => 'application/pkix-crl',
		'crt' => 'application/x-x509-ca-cert',
		'crx' => 'application/x-chrome-extension',
		'cryptonote' => 'application/vnd.rig.cryptonote',
		'csh' => 'application/x-csh',
		'csml' => 'chemical/x-csml',
		'csp' => 'application/vnd.commonspace',
		'css' => 'text/css',
		'less' => 'text/less',
		'cst' => 'application/x-director',
		'csv' => 'text/csv',
		'cu' => 'application/cu-seeme',
		'curl' => 'text/vnd.curl',
		'cww' => 'application/prs.cww',
		'cxt' => 'application/x-director',
		'cxx' => 'text/x-c',
		'dae' => 'model/vnd.collada+xml',
		'daf' => 'application/vnd.mobius.daf',
		'dart' => 'application/vnd.dart',
		'dataless' => 'application/vnd.fdsn.seed',
		'davmount' => 'application/davmount+xml',
		'dbk' => 'application/docbook+xml',
		'dcr' => 'application/x-director',
		'dcurl' => 'text/vnd.curl.dcurl',
		'dd2' => 'application/vnd.oma.dd2+xml',
		'ddd' => 'application/vnd.fujixerox.ddd',
		'deb' => 'application/x-debian-package',
		'def' => 'text/plain',
		'deploy' => 'application/octet-stream',
		'der' => 'application/x-x509-ca-cert',
		'dfac' => 'application/vnd.dreamfactory',
		'dgc' => 'application/x-dgc-compressed',
		'dic' => 'text/x-c',
		'dir' => 'application/x-director',
		'dis' => 'application/vnd.mobius.dis',
		'dist' => 'application/octet-stream',
		'distz' => 'application/octet-stream',
		'djv' => 'image/vnd.djvu',
		'djvu' => 'image/vnd.djvu',
		'dll' => 'application/x-msdownload',
		'dmg' => 'application/x-apple-diskimage',
		'dmp' => 'application/vnd.tcpdump.pcap',
		'dms' => 'application/octet-stream',
		'dna' => 'application/vnd.dna',
		'doc' => 'application/msword',
		'docm' => 'application/vnd.ms-word.document.macroenabled.12',
		'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
		'dot' => 'application/msword',
		'dotm' => 'application/vnd.ms-word.template.macroenabled.12',
		'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
		'dp' => 'application/vnd.osgi.dp',
		'dpg' => 'application/vnd.dpgraph',
		'dra' => 'audio/vnd.dra',
		'dsc' => 'text/prs.lines.tag',
		'dssc' => 'application/dssc+der',
		'dtb' => 'application/x-dtbook+xml',
		'dtd' => 'application/xml-dtd',
		'dts' => 'audio/vnd.dts',
		'dtshd' => 'audio/vnd.dts.hd',
		'dump' => 'application/octet-stream',
		'dvb' => 'video/vnd.dvb.file',
		'dvi' => 'application/x-dvi',
		'dwf' => 'model/vnd.dwf',
		'dwg' => 'image/vnd.dwg',
		'dxf' => 'image/vnd.dxf',
		'dxp' => 'application/vnd.spotfire.dxp',
		'dxr' => 'application/x-director',
		'ecelp4800' => 'audio/vnd.nuera.ecelp4800',
		'ecelp7470' => 'audio/vnd.nuera.ecelp7470',
		'ecelp9600' => 'audio/vnd.nuera.ecelp9600',
		'ecma' => 'application/ecmascript',
		'edm' => 'application/vnd.novadigm.edm',
		'edx' => 'application/vnd.novadigm.edx',
		'efif' => 'application/vnd.picsel',
		'ei6' => 'application/vnd.pg.osasli',
		'elc' => 'application/octet-stream',
		'emf' => 'application/x-msmetafile',
		'eml' => 'message/rfc822',
		'emma' => 'application/emma+xml',
		'emz' => 'application/x-msmetafile',
		'eol' => 'audio/vnd.digital-winds',
		'eot' => 'application/vnd.ms-fontobject',
		'eps' => 'application/postscript',
		'epub' => 'application/epub+zip',
		'es3' => 'application/vnd.eszigno3+xml',
		'esa' => 'application/vnd.osgi.subsystem',
		'esf' => 'application/vnd.epson.esf',
		'et3' => 'application/vnd.eszigno3+xml',
		'etx' => 'text/x-setext',
		'eva' => 'application/x-eva',
		'event-stream' => 'text/event-stream',
		'evy' => 'application/x-envoy',
		'exe' => 'application/x-msdownload',
		'exi' => 'application/exi',
		'ext' => 'application/vnd.novadigm.ext',
		'ez' => 'application/andrew-inset',
		'ez2' => 'application/vnd.ezpix-album',
		'ez3' => 'application/vnd.ezpix-package',
		'f' => 'text/x-fortran',
		'f4v' => 'video/x-f4v',
		'f77' => 'text/x-fortran',
		'f90' => 'text/x-fortran',
		'fbs' => 'image/vnd.fastbidsheet',
		'fcdt' => 'application/vnd.adobe.formscentral.fcdt',
		'fcs' => 'application/vnd.isac.fcs',
		'fdf' => 'application/vnd.fdf',
		'fe_launch' => 'application/vnd.denovo.fcselayout-link',
		'fg5' => 'application/vnd.fujitsu.oasysgp',
		'fgd' => 'application/x-director',
		'fh' => 'image/x-freehand',
		'fh4' => 'image/x-freehand',
		'fh5' => 'image/x-freehand',
		'fh7' => 'image/x-freehand',
		'fhc' => 'image/x-freehand',
		'fig' => 'application/x-xfig',
		'flac' => 'audio/flac',
		'fli' => 'video/x-fli',
		'flo' => 'application/vnd.micrografx.flo',
		'flv' => 'video/x-flv',
		'flw' => 'application/vnd.kde.kivio',
		'flx' => 'text/vnd.fmi.flexstor',
		'fly' => 'text/vnd.fly',
		'fm' => 'application/vnd.framemaker',
		'fnc' => 'application/vnd.frogans.fnc',
		'for' => 'text/x-fortran',
		'fpx' => 'image/vnd.fpx',
		'frame' => 'application/vnd.framemaker',
		'fsc' => 'application/vnd.fsc.weblaunch',
		'fst' => 'image/vnd.fst',
		'ftc' => 'application/vnd.fluxtime.clip',
		'fti' => 'application/vnd.anser-web-funds-transfer-initiation',
		'fvt' => 'video/vnd.fvt',
		'fxp' => 'application/vnd.adobe.fxp',
		'fxpl' => 'application/vnd.adobe.fxp',
		'fzs' => 'application/vnd.fuzzysheet',
		'g2w' => 'application/vnd.geoplan',
		'g3' => 'image/g3fax',
		'g3w' => 'application/vnd.geospace',
		'gac' => 'application/vnd.groove-account',
		'gam' => 'application/x-tads',
		'gbr' => 'application/rpki-ghostbusters',
		'gca' => 'application/x-gca-compressed',
		'gdl' => 'model/vnd.gdl',
		'geo' => 'application/vnd.dynageo',
		'gex' => 'application/vnd.geometry-explorer',
		'ggb' => 'application/vnd.geogebra.file',
		'ggt' => 'application/vnd.geogebra.tool',
		'ghf' => 'application/vnd.groove-help',
		'gif' => 'image/gif',
		'gim' => 'application/vnd.groove-identity-message',
		'gml' => 'application/gml+xml',
		'gmx' => 'application/vnd.gmx',
		'gnumeric' => 'application/x-gnumeric',
		'gph' => 'application/vnd.flographit',
		'gpx' => 'application/gpx+xml',
		'gqf' => 'application/vnd.grafeq',
		'gqs' => 'application/vnd.grafeq',
		'gram' => 'application/srgs',
		'gramps' => 'application/x-gramps-xml',
		'gre' => 'application/vnd.geometry-explorer',
		'grv' => 'application/vnd.groove-injector',
		'grxml' => 'application/srgs+xml',
		'gsf' => 'application/x-font-ghostscript',
		'gtar' => 'application/x-gtar',
		'gtm' => 'application/vnd.groove-tool-message',
		'gtw' => 'model/vnd.gtw',
		'gv' => 'text/vnd.graphviz',
		'gxf' => 'application/gxf',
		'gxt' => 'application/vnd.geonext',
		'h' => 'text/x-c',
		'h261' => 'video/h261',
		'h263' => 'video/h263',
		'h264' => 'video/h264',
		'hal' => 'application/vnd.hal+xml',
		'hbci' => 'application/vnd.hbci',
		'hdf' => 'application/x-hdf',
		'hh' => 'text/x-c',
		'hlp' => 'application/winhlp',
		'hpgl' => 'application/vnd.hp-hpgl',
		'hpid' => 'application/vnd.hp-hpid',
		'hps' => 'application/vnd.hp-hps',
		'hqx' => 'application/mac-binhex40',
		'htc' => 'text/x-component',
		'htke' => 'application/vnd.kenameaapp',
		'htm' => 'text/html',
		'html' => 'text/html',
		'hvd' => 'application/vnd.yamaha.hv-dic',
		'hvp' => 'application/vnd.yamaha.hv-voice',
		'hvs' => 'application/vnd.yamaha.hv-script',
		'i2g' => 'application/vnd.intergeo',
		'icc' => 'application/vnd.iccprofile',
		'ice' => 'x-conference/x-cooltalk',
		'icm' => 'application/vnd.iccprofile',
		'ico' => 'image/x-icon',
		'ics' => 'text/calendar',
		'ief' => 'image/ief',
		'ifb' => 'text/calendar',
		'ifm' => 'application/vnd.shana.informed.formdata',
		'iges' => 'model/iges',
		'igl' => 'application/vnd.igloader',
		'igm' => 'application/vnd.insors.igm',
		'igs' => 'model/iges',
		'igx' => 'application/vnd.micrografx.igx',
		'iif' => 'application/vnd.shana.informed.interchange',
		'imp' => 'application/vnd.accpac.simply.imp',
		'ims' => 'application/vnd.ms-ims',
		'in' => 'text/plain',
		'ink' => 'application/inkml+xml',
		'inkml' => 'application/inkml+xml',
		'install' => 'application/x-install-instructions',
		'iota' => 'application/vnd.astraea-software.iota',
		'ipfix' => 'application/ipfix',
		'ipk' => 'application/vnd.shana.informed.package',
		'irm' => 'application/vnd.ibm.rights-management',
		'irp' => 'application/vnd.irepository.package+xml',
		'iso' => 'application/x-iso9660-image',
		'itp' => 'application/vnd.shana.informed.formtemplate',
		'ivp' => 'application/vnd.immervision-ivp',
		'ivu' => 'application/vnd.immervision-ivu',
		'jad' => 'text/vnd.sun.j2me.app-descriptor',
		'jam' => 'application/vnd.jam',
		'jar' => 'application/java-archive',
		'java' => 'text/x-java-source',
		'jisp' => 'application/vnd.jisp',
		'jlt' => 'application/vnd.hp-jlyt',
		'jnlp' => 'application/x-java-jnlp-file',
		'joda' => 'application/vnd.joost.joda-archive',
		'jpe' => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'jpg' => 'image/jpeg',
		'jpgm' => 'video/jpm',
		'jpgv' => 'video/jpeg',
		'jpm' => 'video/jpm',
		'js' => 'application/javascript',
		'json' => 'application/json',
		'jsonml' => 'application/jsonml+json',
		'kar' => 'audio/midi',
		'karbon' => 'application/vnd.kde.karbon',
		'kfo' => 'application/vnd.kde.kformula',
		'kia' => 'application/vnd.kidspiration',
		'kml' => 'application/vnd.google-earth.kml+xml',
		'kmz' => 'application/vnd.google-earth.kmz',
		'kne' => 'application/vnd.kinar',
		'knp' => 'application/vnd.kinar',
		'kon' => 'application/vnd.kde.kontour',
		'kpr' => 'application/vnd.kde.kpresenter',
		'kpt' => 'application/vnd.kde.kpresenter',
		'kpxx' => 'application/vnd.ds-keypoint',
		'ksp' => 'application/vnd.kde.kspread',
		'ktr' => 'application/vnd.kahootz',
		'ktx' => 'image/ktx',
		'ktz' => 'application/vnd.kahootz',
		'kwd' => 'application/vnd.kde.kword',
		'kwt' => 'application/vnd.kde.kword',
		'lasxml' => 'application/vnd.las.las+xml',
		'latex' => 'application/x-latex',
		'lbd' => 'application/vnd.llamagraphics.life-balance.desktop',
		'lbe' => 'application/vnd.llamagraphics.life-balance.exchange+xml',
		'les' => 'application/vnd.hhe.lesson-player',
		'lha' => 'application/x-lzh-compressed',
		'link66' => 'application/vnd.route66.link66+xml',
		'list' => 'text/plain',
		'list3820' => 'application/vnd.ibm.modcap',
		'listafp' => 'application/vnd.ibm.modcap',
		'lnk' => 'application/x-ms-shortcut',
		'log' => 'text/plain',
		'lostxml' => 'application/lost+xml',
		'lrf' => 'application/octet-stream',
		'lrm' => 'application/vnd.ms-lrm',
		'ltf' => 'application/vnd.frogans.ltf',
		'lua' => 'text/x-lua',
		'luac' => 'application/x-lua-bytecode',
		'lvp' => 'audio/vnd.lucent.voice',
		'lwp' => 'application/vnd.lotus-wordpro',
		'lzh' => 'application/x-lzh-compressed',
		'm13' => 'application/x-msmediaview',
		'm14' => 'application/x-msmediaview',
		'm1v' => 'video/mpeg',
		'm21' => 'application/mp21',
		'm2a' => 'audio/mpeg',
		'm2v' => 'video/mpeg',
		'm3a' => 'audio/mpeg',
		'm3u' => 'audio/x-mpegurl',
		'm3u8' => 'application/x-mpegURL',
		'm4a' => 'audio/mp4',
		'm4p' => 'application/mp4',
		'm4u' => 'video/vnd.mpegurl',
		'm4v' => 'video/x-m4v',
		'ma' => 'application/mathematica',
		'mads' => 'application/mads+xml',
		'mag' => 'application/vnd.ecowin.chart',
		'maker' => 'application/vnd.framemaker',
		'man' => 'text/troff',
		'manifest' => 'text/cache-manifest',
		'mar' => 'application/octet-stream',
		'markdown' => 'text/x-markdown',
		'mathml' => 'application/mathml+xml',
		'mb' => 'application/mathematica',
		'mbk' => 'application/vnd.mobius.mbk',
		'mbox' => 'application/mbox',
		'mc1' => 'application/vnd.medcalcdata',
		'mcd' => 'application/vnd.mcd',
		'mcurl' => 'text/vnd.curl.mcurl',
		'md' => 'text/x-markdown',
		'mdb' => 'application/x-msaccess',
		'mdi' => 'image/vnd.ms-modi',
		'me' => 'text/troff',
		'mesh' => 'model/mesh',
		'meta4' => 'application/metalink4+xml',
		'metalink' => 'application/metalink+xml',
		'mets' => 'application/mets+xml',
		'mfm' => 'application/vnd.mfmp',
		'mft' => 'application/rpki-manifest',
		'mgp' => 'application/vnd.osgeo.mapguide.package',
		'mgz' => 'application/vnd.proteus.magazine',
		'mid' => 'audio/midi',
		'midi' => 'audio/midi',
		'mie' => 'application/x-mie',
		'mif' => 'application/vnd.mif',
		'mime' => 'message/rfc822',
		'mj2' => 'video/mj2',
		'mjp2' => 'video/mj2',
		'mk3d' => 'video/x-matroska',
		'mka' => 'audio/x-matroska',
		'mkd' => 'text/x-markdown',
		'mks' => 'video/x-matroska',
		'mkv' => 'video/x-matroska',
		'mlp' => 'application/vnd.dolby.mlp',
		'mmd' => 'application/vnd.chipnuts.karaoke-mmd',
		'mmf' => 'application/vnd.smaf',
		'mmr' => 'image/vnd.fujixerox.edmics-mmr',
		'mng' => 'video/x-mng',
		'mny' => 'application/x-msmoney',
		'mobi' => 'application/x-mobipocket-ebook',
		'mods' => 'application/mods+xml',
		'mov' => 'video/quicktime',
		'movie' => 'video/x-sgi-movie',
		'mp2' => 'audio/mpeg',
		'mp21' => 'application/mp21',
		'mp2a' => 'audio/mpeg',
		'mp3' => 'audio/mpeg',
		'mp4' => 'video/mp4',
		'mp4a' => 'audio/mp4',
		'mp4s' => 'application/mp4',
		'mp4v' => 'video/mp4',
		'mpc' => 'application/vnd.mophun.certificate',
		'mpe' => 'video/mpeg',
		'mpeg' => 'video/mpeg',
		'mpg' => 'video/mpeg',
		'mpg4' => 'video/mp4',
		'mpga' => 'audio/mpeg',
		'mpkg' => 'application/vnd.apple.installer+xml',
		'mpm' => 'application/vnd.blueice.multipass',
		'mpn' => 'application/vnd.mophun.application',
		'mpp' => 'application/vnd.ms-project',
		'mpt' => 'application/vnd.ms-project',
		'mpy' => 'application/vnd.ibm.minipay',
		'mqy' => 'application/vnd.mobius.mqy',
		'mrc' => 'application/marc',
		'mrcx' => 'application/marcxml+xml',
		'ms' => 'text/troff',
		'mscml' => 'application/mediaservercontrol+xml',
		'mseed' => 'application/vnd.fdsn.mseed',
		'mseq' => 'application/vnd.mseq',
		'msf' => 'application/vnd.epson.msf',
		'msh' => 'model/mesh',
		'msi' => 'application/x-msdownload',
		'msl' => 'application/vnd.mobius.msl',
		'msty' => 'application/vnd.muvee.style',
		'mts' => 'model/vnd.mts',
		'mus' => 'application/vnd.musician',
		'musicxml' => 'application/vnd.recordare.musicxml+xml',
		'mvb' => 'application/x-msmediaview',
		'mwf' => 'application/vnd.mfer',
		'mxf' => 'application/mxf',
		'mxl' => 'application/vnd.recordare.musicxml',
		'mxml' => 'application/xv+xml',
		'mxs' => 'application/vnd.triscape.mxs',
		'mxu' => 'video/vnd.mpegurl',
		'n-gage' => 'application/vnd.nokia.n-gage.symbian.install',
		'n3' => 'text/n3',
		'nb' => 'application/mathematica',
		'nbp' => 'application/vnd.wolfram.player',
		'nc' => 'application/x-netcdf',
		'ncx' => 'application/x-dtbncx+xml',
		'nfo' => 'text/x-nfo',
		'ngdat' => 'application/vnd.nokia.n-gage.data',
		'nitf' => 'application/vnd.nitf',
		'nlu' => 'application/vnd.neurolanguage.nlu',
		'nml' => 'application/vnd.enliven',
		'nnd' => 'application/vnd.noblenet-directory',
		'nns' => 'application/vnd.noblenet-sealer',
		'nnw' => 'application/vnd.noblenet-web',
		'npx' => 'image/vnd.net-fpx',
		'nsc' => 'application/x-conference',
		'nsf' => 'application/vnd.lotus-notes',
		'ntf' => 'application/vnd.nitf',
		'nzb' => 'application/x-nzb',
		'oa2' => 'application/vnd.fujitsu.oasys2',
		'oa3' => 'application/vnd.fujitsu.oasys3',
		'oas' => 'application/vnd.fujitsu.oasys',
		'obd' => 'application/x-msbinder',
		'obj' => 'application/x-tgif',
		'oda' => 'application/oda',
		'odb' => 'application/vnd.oasis.opendocument.database',
		'odc' => 'application/vnd.oasis.opendocument.chart',
		'odf' => 'application/vnd.oasis.opendocument.formula',
		'odft' => 'application/vnd.oasis.opendocument.formula-template',
		'odg' => 'application/vnd.oasis.opendocument.graphics',
		'odi' => 'application/vnd.oasis.opendocument.image',
		'odm' => 'application/vnd.oasis.opendocument.text-master',
		'odp' => 'application/vnd.oasis.opendocument.presentation',
		'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
		'odt' => 'application/vnd.oasis.opendocument.text',
		'oga' => 'audio/ogg',
		'ogg' => 'audio/ogg',
		'ogv' => 'video/ogg',
		'ogx' => 'application/ogg',
		'omdoc' => 'application/omdoc+xml',
		'onepkg' => 'application/onenote',
		'onetmp' => 'application/onenote',
		'onetoc' => 'application/onenote',
		'onetoc2' => 'application/onenote',
		'opf' => 'application/oebps-package+xml',
		'opml' => 'text/x-opml',
		'oprc' => 'application/vnd.palm',
		'org' => 'application/vnd.lotus-organizer',
		'osf' => 'application/vnd.yamaha.openscoreformat',
		'osfpvg' => 'application/vnd.yamaha.openscoreformat.osfpvg+xml',
		'otc' => 'application/vnd.oasis.opendocument.chart-template',
		'otf' => 'font/opentype',
		'otg' => 'application/vnd.oasis.opendocument.graphics-template',
		'oth' => 'application/vnd.oasis.opendocument.text-web',
		'oti' => 'application/vnd.oasis.opendocument.image-template',
		'otp' => 'application/vnd.oasis.opendocument.presentation-template',
		'ots' => 'application/vnd.oasis.opendocument.spreadsheet-template',
		'ott' => 'application/vnd.oasis.opendocument.text-template',
		'oxps' => 'application/oxps',
		'oxt' => 'application/vnd.openofficeorg.extension',
		'p' => 'text/x-pascal',
		'p10' => 'application/pkcs10',
		'p12' => 'application/x-pkcs12',
		'p7b' => 'application/x-pkcs7-certificates',
		'p7c' => 'application/pkcs7-mime',
		'p7m' => 'application/pkcs7-mime',
		'p7r' => 'application/x-pkcs7-certreqresp',
		'p7s' => 'application/pkcs7-signature',
		'p8' => 'application/pkcs8',
		'pas' => 'text/x-pascal',
		'paw' => 'application/vnd.pawaafile',
		'pbd' => 'application/vnd.powerbuilder6',
		'pbm' => 'image/x-portable-bitmap',
		'pcap' => 'application/vnd.tcpdump.pcap',
		'pcf' => 'application/x-font-pcf',
		'pcl' => 'application/vnd.hp-pcl',
		'pclxl' => 'application/vnd.hp-pclxl',
		'pct' => 'image/x-pict',
		'pcurl' => 'application/vnd.curl.pcurl',
		'pcx' => 'image/x-pcx',
		'pdb' => 'application/vnd.palm',
		'pdf' => 'application/pdf',
		'pfa' => 'application/x-font-type1',
		'pfb' => 'application/x-font-type1',
		'pfm' => 'application/x-font-type1',
		'pfr' => 'application/font-tdpfr',
		'pfx' => 'application/x-pkcs12',
		'pgm' => 'image/x-portable-graymap',
		'pgn' => 'application/x-chess-pgn',
		'pgp' => 'application/pgp-encrypted',
		'pic' => 'image/x-pict',
		'pkg' => 'application/octet-stream',
		'pki' => 'application/pkixcmp',
		'pkipath' => 'application/pkix-pkipath',
		'plb' => 'application/vnd.3gpp.pic-bw-large',
		'plc' => 'application/vnd.mobius.plc',
		'plf' => 'application/vnd.pocketlearn',
		'pls' => 'application/pls+xml',
		'pml' => 'application/vnd.ctc-posml',
		'png' => 'image/png',
		'pnm' => 'image/x-portable-anymap',
		'portpkg' => 'application/vnd.macports.portpkg',
		'pot' => 'application/vnd.ms-powerpoint',
		'potm' => 'application/vnd.ms-powerpoint.template.macroenabled.12',
		'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
		'ppam' => 'application/vnd.ms-powerpoint.addin.macroenabled.12',
		'ppd' => 'application/vnd.cups-ppd',
		'ppm' => 'image/x-portable-pixmap',
		'pps' => 'application/vnd.ms-powerpoint',
		'ppsm' => 'application/vnd.ms-powerpoint.slideshow.macroenabled.12',
		'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
		'ppt' => 'application/vnd.ms-powerpoint',
		'pptm' => 'application/vnd.ms-powerpoint.presentation.macroenabled.12',
		'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
		'pqa' => 'application/vnd.palm',
		'prc' => 'application/x-mobipocket-ebook',
		'pre' => 'application/vnd.lotus-freelance',
		'prf' => 'application/pics-rules',
		'ps' => 'application/postscript',
		'psb' => 'application/vnd.3gpp.pic-bw-small',
		'psd' => 'image/vnd.adobe.photoshop',
		'psf' => 'application/x-font-linux-psf',
		'pskcxml' => 'application/pskc+xml',
		'ptid' => 'application/vnd.pvi.ptid1',
		'pub' => 'application/x-mspublisher',
		'pvb' => 'application/vnd.3gpp.pic-bw-var',
		'pwn' => 'application/vnd.3m.post-it-notes',
		'pya' => 'audio/vnd.ms-playready.media.pya',
		'pyv' => 'video/vnd.ms-playready.media.pyv',
		'qam' => 'application/vnd.epson.quickanime',
		'qbo' => 'application/vnd.intu.qbo',
		'qfx' => 'application/vnd.intu.qfx',
		'qps' => 'application/vnd.publishare-delta-tree',
		'qt' => 'video/quicktime',
		'qwd' => 'application/vnd.quark.quarkxpress',
		'qwt' => 'application/vnd.quark.quarkxpress',
		'qxb' => 'application/vnd.quark.quarkxpress',
		'qxd' => 'application/vnd.quark.quarkxpress',
		'qxl' => 'application/vnd.quark.quarkxpress',
		'qxt' => 'application/vnd.quark.quarkxpress',
		'ra' => 'audio/x-pn-realaudio',
		'ram' => 'audio/x-pn-realaudio',
		'rar' => 'application/x-rar-compressed',
		'ras' => 'image/x-cmu-raster',
		'rcprofile' => 'application/vnd.ipunplugged.rcprofile',
		'rdf' => 'application/rdf+xml',
		'rdz' => 'application/vnd.data-vision.rdz',
		'rep' => 'application/vnd.businessobjects',
		'res' => 'application/x-dtbresource+xml',
		'rgb' => 'image/x-rgb',
		'rif' => 'application/reginfo+xml',
		'rip' => 'audio/vnd.rip',
		'ris' => 'application/x-research-info-systems',
		'rl' => 'application/resource-lists+xml',
		'rlc' => 'image/vnd.fujixerox.edmics-rlc',
		'rld' => 'application/resource-lists-diff+xml',
		'rm' => 'application/vnd.rn-realmedia',
		'rmi' => 'audio/midi',
		'rmp' => 'audio/x-pn-realaudio-plugin',
		'rms' => 'application/vnd.jcp.javame.midlet-rms',
		'rmvb' => 'application/vnd.rn-realmedia-vbr',
		'rnc' => 'application/relax-ng-compact-syntax',
		'roa' => 'application/rpki-roa',
		'roff' => 'text/troff',
		'rp9' => 'application/vnd.cloanto.rp9',
		'rpss' => 'application/vnd.nokia.radio-presets',
		'rpst' => 'application/vnd.nokia.radio-preset',
		'rq' => 'application/sparql-query',
		'rs' => 'application/rls-services+xml',
		'rsd' => 'application/rsd+xml',
		'rss' => 'application/rss+xml',
		'rtf' => 'text/rtf',
		'rtx' => 'text/richtext',
		's' => 'text/x-asm',
		's3m' => 'audio/s3m',
		'saf' => 'application/vnd.yamaha.smaf-audio',
		'sbml' => 'application/sbml+xml',
		'sc' => 'application/vnd.ibm.secure-container',
		'scd' => 'application/x-msschedule',
		'scm' => 'application/vnd.lotus-screencam',
		'scq' => 'application/scvp-cv-request',
		'scs' => 'application/scvp-cv-response',
		'scurl' => 'text/vnd.curl.scurl',
		'sda' => 'application/vnd.stardivision.draw',
		'sdc' => 'application/vnd.stardivision.calc',
		'sdd' => 'application/vnd.stardivision.impress',
		'sdkd' => 'application/vnd.solent.sdkm+xml',
		'sdkm' => 'application/vnd.solent.sdkm+xml',
		'sdp' => 'application/sdp',
		'sdw' => 'application/vnd.stardivision.writer',
		'see' => 'application/vnd.seemail',
		'seed' => 'application/vnd.fdsn.seed',
		'sema' => 'application/vnd.sema',
		'semd' => 'application/vnd.semd',
		'semf' => 'application/vnd.semf',
		'ser' => 'application/java-serialized-object',
		'setpay' => 'application/set-payment-initiation',
		'setreg' => 'application/set-registration-initiation',
		'sfd-hdstx' => 'application/vnd.hydrostatix.sof-data',
		'sfs' => 'application/vnd.spotfire.sfs',
		'sfv' => 'text/x-sfv',
		'sgi' => 'image/sgi',
		'sgl' => 'application/vnd.stardivision.writer-global',
		'sgm' => 'text/sgml',
		'sgml' => 'text/sgml',
		'sh' => 'application/x-sh',
		'shar' => 'application/x-shar',
		'shf' => 'application/shf+xml',
		'sid' => 'image/x-mrsid-image',
		'sig' => 'application/pgp-signature',
		'sil' => 'audio/silk',
		'silo' => 'model/mesh',
		'sis' => 'application/vnd.symbian.install',
		'sisx' => 'application/vnd.symbian.install',
		'sit' => 'application/x-stuffit',
		'sitx' => 'application/x-stuffitx',
		'skd' => 'application/vnd.koan',
		'skm' => 'application/vnd.koan',
		'skp' => 'application/vnd.koan',
		'skt' => 'application/vnd.koan',
		'sldm' => 'application/vnd.ms-powerpoint.slide.macroenabled.12',
		'sldx' => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
		'slt' => 'application/vnd.epson.salt',
		'sm' => 'application/vnd.stepmania.stepchart',
		'smf' => 'application/vnd.stardivision.math',
		'smi' => 'application/smil+xml',
		'smil' => 'application/smil+xml',
		'smv' => 'video/x-smv',
		'smzip' => 'application/vnd.stepmania.package',
		'snd' => 'audio/basic',
		'snf' => 'application/x-font-snf',
		'so' => 'application/octet-stream',
		'spc' => 'application/x-pkcs7-certificates',
		'spf' => 'application/vnd.yamaha.smaf-phrase',
		'spl' => 'application/x-futuresplash',
		'spot' => 'text/vnd.in3d.spot',
		'spp' => 'application/scvp-vp-response',
		'spq' => 'application/scvp-vp-request',
		'spx' => 'audio/ogg',
		'sql' => 'application/x-sql',
		'src' => 'application/x-wais-source',
		'srt' => 'application/x-subrip',
		'sru' => 'application/sru+xml',
		'srx' => 'application/sparql-results+xml',
		'ssdl' => 'application/ssdl+xml',
		'sse' => 'application/vnd.kodak-descriptor',
		'ssf' => 'application/vnd.epson.ssf',
		'ssml' => 'application/ssml+xml',
		'st' => 'application/vnd.sailingtracker.track',
		'stc' => 'application/vnd.sun.xml.calc.template',
		'std' => 'application/vnd.sun.xml.draw.template',
		'stf' => 'application/vnd.wt.stf',
		'sti' => 'application/vnd.sun.xml.impress.template',
		'stk' => 'application/hyperstudio',
		'stl' => 'application/vnd.ms-pki.stl',
		'str' => 'application/vnd.pg.format',
		'stw' => 'application/vnd.sun.xml.writer.template',
		'sub' => 'text/vnd.dvb.subtitle',
		'sus' => 'application/vnd.sus-calendar',
		'susp' => 'application/vnd.sus-calendar',
		'sv4cpio' => 'application/x-sv4cpio',
		'sv4crc' => 'application/x-sv4crc',
		'svc' => 'application/vnd.dvb.service',
		'svd' => 'application/vnd.svd',
		'svg' => 'image/svg+xml',
		'svgz' => 'image/svg+xml',
		'swa' => 'application/x-director',
		'swf' => 'application/x-shockwave-flash',
		'swi' => 'application/vnd.aristanetworks.swi',
		'sxc' => 'application/vnd.sun.xml.calc',
		'sxd' => 'application/vnd.sun.xml.draw',
		'sxg' => 'application/vnd.sun.xml.writer.global',
		'sxi' => 'application/vnd.sun.xml.impress',
		'sxm' => 'application/vnd.sun.xml.math',
		'sxw' => 'application/vnd.sun.xml.writer',
		't' => 'text/troff',
		't3' => 'application/x-t3vm-image',
		'taglet' => 'application/vnd.mynfc',
		'tao' => 'application/vnd.tao.intent-module-archive',
		'tar' => 'application/x-tar',
		'tcap' => 'application/vnd.3gpp2.tcap',
		'tcl' => 'application/x-tcl',
		'teacher' => 'application/vnd.smart.teacher',
		'tei' => 'application/tei+xml',
		'teicorpus' => 'application/tei+xml',
		'tex' => 'application/x-tex',
		'texi' => 'application/x-texinfo',
		'texinfo' => 'application/x-texinfo',
		'text' => 'text/plain',
		'tfi' => 'application/thraud+xml',
		'tfm' => 'application/x-tex-tfm',
		'tga' => 'image/x-tga',
		'thmx' => 'application/vnd.ms-officetheme',
		'tif' => 'image/tiff',
		'tiff' => 'image/tiff',
		'tmo' => 'application/vnd.tmobile-livetv',
		'torrent' => 'application/x-bittorrent',
		'tpl' => 'application/vnd.groove-tool-template',
		'tpt' => 'application/vnd.trid.tpt',
		'tr' => 'text/troff',
		'tra' => 'application/vnd.trueapp',
		'trm' => 'application/x-msterminal',
		'ts' => 'video/MP2T',
		'tsd' => 'application/timestamped-data',
		'tsv' => 'text/tab-separated-values',
		'ttc' => 'application/x-font-ttf',
		'ttf' => 'application/x-font-ttf',
		'ttl' => 'text/turtle',
		'twd' => 'application/vnd.simtech-mindmapper',
		'twds' => 'application/vnd.simtech-mindmapper',
		'txd' => 'application/vnd.genomatix.tuxedo',
		'txf' => 'application/vnd.mobius.txf',
		'txt' => 'text/plain',
		'u32' => 'application/x-authorware-bin',
		'udeb' => 'application/x-debian-package',
		'ufd' => 'application/vnd.ufdl',
		'ufdl' => 'application/vnd.ufdl',
		'ulx' => 'application/x-glulx',
		'umj' => 'application/vnd.umajin',
		'unityweb' => 'application/vnd.unity',
		'uoml' => 'application/vnd.uoml+xml',
		'uri' => 'text/uri-list',
		'uris' => 'text/uri-list',
		'urls' => 'text/uri-list',
		'ustar' => 'application/x-ustar',
		'utz' => 'application/vnd.uiq.theme',
		'uu' => 'text/x-uuencode',
		'uva' => 'audio/vnd.dece.audio',
		'uvd' => 'application/vnd.dece.data',
		'uvf' => 'application/vnd.dece.data',
		'uvg' => 'image/vnd.dece.graphic',
		'uvh' => 'video/vnd.dece.hd',
		'uvi' => 'image/vnd.dece.graphic',
		'uvm' => 'video/vnd.dece.mobile',
		'uvp' => 'video/vnd.dece.pd',
		'uvs' => 'video/vnd.dece.sd',
		'uvt' => 'application/vnd.dece.ttml+xml',
		'uvu' => 'video/vnd.uvvu.mp4',
		'uvv' => 'video/vnd.dece.video',
		'uvva' => 'audio/vnd.dece.audio',
		'uvvd' => 'application/vnd.dece.data',
		'uvvf' => 'application/vnd.dece.data',
		'uvvg' => 'image/vnd.dece.graphic',
		'uvvh' => 'video/vnd.dece.hd',
		'uvvi' => 'image/vnd.dece.graphic',
		'uvvm' => 'video/vnd.dece.mobile',
		'uvvp' => 'video/vnd.dece.pd',
		'uvvs' => 'video/vnd.dece.sd',
		'uvvt' => 'application/vnd.dece.ttml+xml',
		'uvvu' => 'video/vnd.uvvu.mp4',
		'uvvv' => 'video/vnd.dece.video',
		'uvvx' => 'application/vnd.dece.unspecified',
		'uvvz' => 'application/vnd.dece.zip',
		'uvx' => 'application/vnd.dece.unspecified',
		'uvz' => 'application/vnd.dece.zip',
		'vcard' => 'text/vcard',
		'vcd' => 'application/x-cdlink',
		'vcf' => 'text/x-vcard',
		'vcg' => 'application/vnd.groove-vcard',
		'vcs' => 'text/x-vcalendar',
		'vcx' => 'application/vnd.vcx',
		'vis' => 'application/vnd.visionary',
		'viv' => 'video/vnd.vivo',
		'vob' => 'video/x-ms-vob',
		'vor' => 'application/vnd.stardivision.writer',
		'vox' => 'application/x-authorware-bin',
		'vrml' => 'model/vrml',
		'vsd' => 'application/vnd.visio',
		'vsf' => 'application/vnd.vsf',
		'vss' => 'application/vnd.visio',
		'vst' => 'application/vnd.visio',
		'vsw' => 'application/vnd.visio',
		'vtt' => 'text/vtt',
		'vtu' => 'model/vnd.vtu',
		'vxml' => 'application/voicexml+xml',
		'w3d' => 'application/x-director',
		'wad' => 'application/x-doom',
		'wav' => 'audio/x-wav',
		'wax' => 'audio/x-ms-wax',
		'wbmp' => 'image/vnd.wap.wbmp',
		'wbs' => 'application/vnd.criticaltools.wbs+xml',
		'wbxml' => 'application/vnd.wap.wbxml',
		'wcm' => 'application/vnd.ms-works',
		'wdb' => 'application/vnd.ms-works',
		'wdp' => 'image/vnd.ms-photo',
		'weba' => 'audio/webm',
		'webapp' => 'application/x-web-app-manifest+json',
		'webm' => 'video/webm',
		'webp' => 'image/webp',
		'wg' => 'application/vnd.pmi.widget',
		'wgt' => 'application/widget',
		'wks' => 'application/vnd.ms-works',
		'wm' => 'video/x-ms-wm',
		'wma' => 'audio/x-ms-wma',
		'wmd' => 'application/x-ms-wmd',
		'wmf' => 'application/x-msmetafile',
		'wml' => 'text/vnd.wap.wml',
		'wmlc' => 'application/vnd.wap.wmlc',
		'wmls' => 'text/vnd.wap.wmlscript',
		'wmlsc' => 'application/vnd.wap.wmlscriptc',
		'wmv' => 'video/x-ms-wmv',
		'wmx' => 'video/x-ms-wmx',
		'wmz' => 'application/x-msmetafile',
		'woff' => 'application/x-font-woff',
		'wpd' => 'application/vnd.wordperfect',
		'wpl' => 'application/vnd.ms-wpl',
		'wps' => 'application/vnd.ms-works',
		'wqd' => 'application/vnd.wqd',
		'wri' => 'application/x-mswrite',
		'wrl' => 'model/vrml',
		'wsdl' => 'application/wsdl+xml',
		'wspolicy' => 'application/wspolicy+xml',
		'wtb' => 'application/vnd.webturbo',
		'wvx' => 'video/x-ms-wvx',
		'x32' => 'application/x-authorware-bin',
		'x3d' => 'model/x3d+xml',
		'x3db' => 'model/x3d+binary',
		'x3dbz' => 'model/x3d+binary',
		'x3dv' => 'model/x3d+vrml',
		'x3dvz' => 'model/x3d+vrml',
		'x3dz' => 'model/x3d+xml',
		'xaml' => 'application/xaml+xml',
		'xap' => 'application/x-silverlight-app',
		'xar' => 'application/vnd.xara',
		'xbap' => 'application/x-ms-xbap',
		'xbd' => 'application/vnd.fujixerox.docuworks.binder',
		'xbm' => 'image/x-xbitmap',
		'xdf' => 'application/xcap-diff+xml',
		'xdm' => 'application/vnd.syncml.dm+xml',
		'xdp' => 'application/vnd.adobe.xdp+xml',
		'xdssc' => 'application/dssc+xml',
		'xdw' => 'application/vnd.fujixerox.docuworks',
		'xenc' => 'application/xenc+xml',
		'xer' => 'application/patch-ops-error+xml',
		'xfdf' => 'application/vnd.adobe.xfdf',
		'xfdl' => 'application/vnd.xfdl',
		'xht' => 'application/xhtml+xml',
		'xhtml' => 'application/xhtml+xml',
		'xhvml' => 'application/xv+xml',
		'xif' => 'image/vnd.xiff',
		'xla' => 'application/vnd.ms-excel',
		'xlam' => 'application/vnd.ms-excel.addin.macroenabled.12',
		'xlc' => 'application/vnd.ms-excel',
		'xlf' => 'application/x-xliff+xml',
		'xlm' => 'application/vnd.ms-excel',
		'xls' => 'application/vnd.ms-excel',
		'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroenabled.12',
		'xlsm' => 'application/vnd.ms-excel.sheet.macroenabled.12',
		'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
		'xlt' => 'application/vnd.ms-excel',
		'xltm' => 'application/vnd.ms-excel.template.macroenabled.12',
		'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
		'xlw' => 'application/vnd.ms-excel',
		'xm' => 'audio/xm',
		'xml' => 'application/xml',
		'xo' => 'application/vnd.olpc-sugar',
		'xop' => 'application/xop+xml',
		'xpi' => 'application/x-xpinstall',
		'xpl' => 'application/xproc+xml',
		'xpm' => 'image/x-xpixmap',
		'xpr' => 'application/vnd.is-xpr',
		'xps' => 'application/vnd.ms-xpsdocument',
		'xpw' => 'application/vnd.intercon.formnet',
		'xpx' => 'application/vnd.intercon.formnet',
		'xsl' => 'application/xml',
		'xslt' => 'application/xslt+xml',
		'xsm' => 'application/vnd.syncml+xml',
		'xspf' => 'application/xspf+xml',
		'xul' => 'application/vnd.mozilla.xul+xml',
		'xvm' => 'application/xv+xml',
		'xvml' => 'application/xv+xml',
		'xwd' => 'image/x-xwindowdump',
		'xyz' => 'chemical/x-xyz',
		'xz' => 'application/x-xz',
		'yang' => 'application/yang',
		'yin' => 'application/yin+xml',
		'z1' => 'application/x-zmachine',
		'z2' => 'application/x-zmachine',
		'z3' => 'application/x-zmachine',
		'z4' => 'application/x-zmachine',
		'z5' => 'application/x-zmachine',
		'z6' => 'application/x-zmachine',
		'z7' => 'application/x-zmachine',
		'z8' => 'application/x-zmachine',
		'zaz' => 'application/vnd.zzazz.deck+xml',
		'zip' => 'application/zip',
		'zir' => 'application/vnd.zul',
		'zirz' => 'application/vnd.zul',
		'zmm' => 'application/vnd.handheld-entertainment+xml'
	];

	public function mime($file) {
		if (isset($this->_aMap[$this->extension($file)])) {
			return $this->_aMap[$this->extension($file)];
		}

		return 'unknown';
	}

	public function extension($file) {
		return pathinfo($file, PATHINFO_EXTENSION);
	}

	/**
	 * @return $this
	 */
	public static function instance()
	{
		return Phpfox::getLib('file');
	}

	
	/**
	 * Get meta information about a file using the getID3 library.
	 * Library is located at: include/library/getid3/
	 *
	 * Example:
	 * <code>
	 * $aMeta = Phpfox_File::instance()->getMeta('/var/www/sample.jpg');
	 * </code>
	 * @param string $sFileName Full path to the file we need to check
	 * @return array Returns an ARRAY of meta information about the file
	 */
	public function getMeta($sFileName)
	{
		return false;
	}
	
	/**
	 * Loads an uploaded file and performs checks to make sure it was allowed
	 * to be uploaded bassed on the supported file extensions passed by the 2nd
	 * argument. As well as check if the filesize is allowed bassed on the 3rd argument
	 * that is passed plus to also make sure the server can handle uploading such
	 * a size on the file.
	 *
	 * @param string $sFormItem Name of the <input> used when submitting the form.
	 * @param array $aSupported An ARRAY of allowed file extensions
	 * @param int $iMaxSize Max filesize in bytes for the file being uploaded
	 * @return mixed If a file was not allowed to be uploaded we return a FALSE, however if it is allowed we return an ARRAY with meta information about the uploaded file.
	 */
	public function load($sFormItem, $aSupported = array(), $iMaxSize = null)
	{
		$Request = Phpfox_Request::instance();
		if (Phpfox::isUser() && $Request->getHeader('X-File-Name')) {
			if (!defined('PHPFOX_HTML5_PHOTO_UPLOAD')) {
				define('PHPFOX_HTML5_PHOTO_UPLOAD', true);
			}

			if (isset($_FILES['ajax_upload'])) {
				$_FILES['image'] = $_FILES['ajax_upload'];
			}
			else {
				$file = PHPFOX_DIR_FILE . 'static/' . uniqid() . '.' . \Phpfox_File::instance()->extension($Request->getHeader('X-File-Name'));
				file_put_contents($file, file_get_contents('php://input'));
				$_FILES['image'] = [
					'tmp_name' => $file,
					'name' => $Request->getHeader('X-File-Name'),
					'type' => $Request->getHeader('X-File-Type'),
					'size' => $Request->getHeader('X-File-Size'),
					'error' => 0
				];
			}
		}
		
		if (is_string($aSupported))
		{
			$aSupported = array($aSupported);			
		}
		
		$aSupported = array_map('strtolower', $aSupported);
		
		if (in_array('jpg', $aSupported))
		{
			array_push($aSupported, 'jpeg');
		}
	
		if (in_array('mpg', $aSupported))
		{
			array_push($aSupported, 'mpeg');
		}		
		
		$this->_aSupported = $aSupported;
		
		$this->_buildFile($sFormItem);

		if ($iMaxSize !== null)
		{
			$this->_iMaxSize = $iMaxSize;
		}
		
		if (Phpfox::isUser())
		{
			if (!Phpfox::getService('user.space')->isAllowedToUpload(Phpfox::getUserId(), filesize($this->_aFile['tmp_name'])))
			{
				return false;
			}
		}		
		
		if (count($aSupported) && !in_array(strtolower($this->_aFile['ext']), $aSupported))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('core.not_a_valid_file_extension_we_only_accept_support', array('support' => implode(', ', $aSupported))));
		}		
		
		if (!($bReturn = $this->_verify($this->_aFile['tmp_name'])))
		{
			return $bReturn;
		}

		if (Phpfox_Image::instance()->isImageExtension($this->_aFile['ext']) && !Phpfox_Image::instance()->isImage($this->_aFile['tmp_name']))
		{
			return Phpfox_Error::set(Phpfox::getPhrase('core.not_a_valid_image_we_only_accept_the_following_file_extensions_support', array('support' => implode(', ', $aSupported))));
		}	
		
		if (!$this->_passLimit())
		{
			return false;
		}		

		return $this->_aFile;
	}	
   
	/**
	 * Method is named "upload", however due to how PHP works the file has already been
	 * uploaded and this simply moves the uploaded file to the final location
	 * since it passed all the tests done by the load() method.
	 *
	 * @param string $sFormItem Name of the <input> used when submitting the form.
	 * @param string $sDestination Full path to where the final location of the file will be
	 * @param string $sFileName File name of the uploaded file once we have moved it to its final destination
	 * @param bool $bModifyFileName By default we modify the actual file name with a unique MD5 hash to make it harder to find, however setting this to FALSE will keep the original name of the file.
	 * @param int $iPerm UNIX file permissions on the file. Default is 0644 (read only).
	 * @param bool $buildDir We place files in folders based on the current month/year by default. Set this to FALSE to not create such directories and place it in the specificed destination folder.
	 * @param bool $bCdn If CDN support is enabled we will copy the file to the CDN server. Set this to FALSE to force the script to not copy the file to CDN even if support is enabled for CDN.
	 * @return mixed Returns a FALSE if we cannot move the file or a STRING on the full path of where the file is located as well as the files new name and extension.
	 */
    public function upload($sFormItem, $sDestination, $sFileName, $bModifyFileName = true, $iPerm = 0644, $buildDir = true, $bCdn = true)
    {
        (($sPlugin = Phpfox_Plugin::get('file_upload_start')) ? eval($sPlugin) : false);
        
		if ($buildDir)
		{
			$this->_buildDir($sDestination);
		}
		else
		{
			$this->_sDestination = $sDestination;
		}
	
        if ($sPlugin = Phpfox_Plugin::get('library_phpfox_file_file_upload_1')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
        
        if ($bModifyFileName === true)
        {
        	$sFileName = md5($sFileName . PHPFOX_TIME . uniqid());
        }        
        
        if (Phpfox::getParam(array('balancer', 'enabled')))
        {
	        if (Phpfox_Image::instance()->isImageExtension($this->_aFile['ext']))
	        {
				list($iWidth, $iHeight) = getimagesize($this->_aFile['tmp_name']);
				$sFileName = $iWidth . '-' . $iHeight . '-' . Phpfox_Request::instance()->getServer('PHPFOX_SERVER_ID') . '_' . $sFileName;
			}
			else
			{
				$sFileName = Phpfox_Request::instance()->getServer('PHPFOX_SERVER_ID') . '_' . $sFileName;
			}
        }
        
        $sDest = $this->_sDestination . $sFileName . '.' . $this->_sExt;
		
	if ($sPlugin = Phpfox_Plugin::get('library_phpfox_file_file_upload_2')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}

	    if (defined('PHPFOX_APP_USER_ID') || defined('PHPFOX_HTML5_PHOTO_UPLOAD'))
		{
			 @copy($this->_aFile['tmp_name'], $sDest);
			if (!defined('PHPFOX_FILE_DONT_UNLINK')) {
				@unlink($this->_aFile['tmp_name']);
			}
		}
        else if (!@move_uploaded_file($this->_aFile['tmp_name'], $sDest))
        {
            return Phpfox_Error::set(Phpfox::getPhrase('core.unable_to_move_the_file'));
        }    
        if ($sPlugin = Phpfox_Plugin::get('library_phpfox_file_file_upload_3')){eval($sPlugin);if (isset($mReturnFromPlugin)){return $mReturnFromPlugin;}}
        // Windows permission problem???
        if (stristr(PHP_OS, "win"))
        {        
        	@copy($sDest, $sDest . '.cache');
        	@unlink($sDest);
        	@copy($sDest . '.cache', $sDest);
        	@unlink($sDest . '.cache');
        }
        else 
        {        
			@chmod($sDest, $iPerm);
        }

		if (Phpfox::getParam('core.allow_cdn') && $bCdn === true)
		{
			$bReturn = Phpfox::getLib('cdn')->put($sDestination . str_replace('\\', '/', str_replace($sDestination, '', $this->_sDestination) . $sFileName . '.' . $this->_sExt));
			
			if ($bReturn === false)
			{
				return false;
			}
		}		

        return str_replace('\\', '/', str_replace($sDestination, '', $this->_sDestination) . $sFileName . (($bModifyFileName === true || is_array($bModifyFileName)) ? '%s.' : '.') . $this->_sExt);
    }
    
    /**
     * Gets all the files/folders in a specified directory.
     *
     * @param string $sDir Full path to the directory.
     * @return mixed Returns an ARRAY of files if we found any or FALSE if we were not able to open the directory.
     */
	public function getFiles($sDir)
	{		
		$aFiles = array();
        if ($hDir = @opendir($sDir))
        {
			while (false !== ($sFile = readdir($hDir)))
           	{
            	if ($sFile == '.' || $sFile == '..' || $sFile == '.svn' || $sFile == '.svn-ignore' || $sFile == 'index.html')
               	{
					continue;
               	}
               	$aFiles[] = $sFile;
           	}
           	closedir($hDir);
           	return $aFiles;
        }
		return false;		
	}   
	
	/**
	 * Gets all files/folders in a give directory recursively.
	 *
	 * @param string $sDir Full path to the directory
	 * @param bool $bRecurse TRUE if we are in a recursive check or FALSE if we are not.
	 * @return array List of all the files/folders in a folder.
	 */
	public function getAllFiles($sDir, $bRecurse = false)
	{
		static $aFiles = array();
		
		if ($bRecurse === false)
		{
			$aFiles = array();
		}
		
		$hDir = opendir($sDir);
		while ($sFile = readdir($hDir))
		{
			if ($sFile == '.' || $sFile == '..' || $sFile == '.svn')
			{
				continue;
			}
			
			$sNewDir = rtrim($sDir, PHPFOX_DS) . PHPFOX_DS . $sFile;
			
			if (is_dir($sNewDir))
			{
				$this->getAllFiles($sNewDir, true);
			}
			else 
			{
				$aFiles[] = $sNewDir;
			}	
		}
		closedir($hDir);
		
		return $aFiles;	
	}
    
	/**
	 * Gets the filesize of a file and returns the best human readable output.
	 *
	 * @param int $iSize Size of the file
	 * @param int $iPrecision Precision on the output
	 * @return string Returns a human readable output on the file size of a file
	 */
	public static function filesize($iSize, $iPrecision = 2)
	{
	    if (!is_numeric($iSize))
	    {
	        return $iSize;
	    }

	    if (!is_numeric($iPrecision))
	    {
	        $iPrecision = 2;
	    }

	    $sSize   = '';
	    $fSize   = 0;
	    $sSuffix = '';

	    if ($iSize >= 1073741824)
	    {
	        $fSize = $iSize / 1073741824;
	        $sSuffix = 'Gb';
	    }
	    elseif (($iSize >= 1048576) && ($iSize < 1073741824))
	    {
	        $fSize = $iSize / 1048576;
	        $sSuffix = 'Mb';
	    }
	    elseif (($iSize >= 1024) && ($iSize < 1048576))
	    {
	        $fSize = $iSize / 1024;
	        $sSuffix = 'kb';
	    }
    	else
    	{
    	    $fSize = $iSize;
    	    $sSuffix = 'b';
    	}
    	$sSize = round($fSize, $iPrecision);
    	$sSize .= ' '.$sSuffix;
    	
    	return $sSize;
	}
	
	/**
	 * Writes to a cache file. Overwrites old files and if it does not exist
	 * it creates a new one.
	 *
	 * @param string $sFile Fill name of the file to write to.
	 * @param string $sData Data to add into the file.
	 * @return object Returns the classes own object.
	 */
	public function writeToCache($sFile, $sData)
	{		
		if ($hFile = @fopen(PHPFOX_DIR_CACHE . $sFile, 'w+'))
		{			
			fwrite($hFile, $sData);
			fclose($hFile);		
		}
		
		return $this;	
	}
	
	/**
	 * Writes to a file on the server. Always removes files if it exists.
	 *
	 * @see fopen()
	 * @see fwrite()
	 * @param string $sFile Full path to the file
	 * @param string $sData Data to put in the file
	 * @param string $sMode Mode to take when opening the file. Default is "w"
	 * @return bool Returns TRUE if we were able to write to the file and FALSE if not.
	 */
	public function write($sFile, $sData, $sMode = 'w')
	{
		if (file_exists($sFile))
		{
			unlink($sFile);
		}		
		
		if ($hFile = @fopen($sFile, $sMode))
		{
			if (!is_string($sData))
			{
				$sData = (string)$sData;
			}
			fwrite($hFile, trim($sData));
			fclose($hFile);		
			
			return true;
		}		
		
		return false;
	}
	
	/**
	 * Forces a file to be downloaded by the end-user and at the same time
	 * try to hide the location of the file.
	 *
	 * @param string $sFile Full path to a file
	 * @param string $sName Name of the file when the user trys to download it
	 * @param string $sMimeType MIME type of the file in case we can't find it.
	 * @param string $sFileSize File size of the file in case we can't find it.
	 * @param string $iServerId Optional if the site has more then one server you need to specify the original location of the file with the servers ID#
	 */
	public function forceDownload($sFile, $sName, $sMimeType = '', $sFileSize = '', $iServerId = 0) 
	{	    
		// required for IE  
		if(ini_get('zlib.output_compression')) 
		{
			ini_set('zlib.output_compression', 'Off'); 
		}	
		
		if (!$sMimeType)
		{
	     	if (function_exists('mime_content_type'))
	     	{
	     		$sMimeType = mime_content_type($sFile);
	     	}
	     	else 
	     	{	     	
				if (strtolower(PHP_OS) == 'linux')
				{
					$sMimeType = trim(exec('file -bi ' . escapeshellarg($sFile)));
				}
	     		else
	     		{
		     		// get the file mime type using the file extension  
			     	switch(strtolower(substr(strrchr($sFile,'.'), 1)))  
			     	{  
			        	case 'pdf': 
			        		$sMimeType = 'application/pdf'; 
			        		break;  
			        	case 'zip': 
			        		$sMimeType = 'application/zip'; 
			        		break;  
			        	case 'jpeg':  
			        	case 'jpg': 
			        		$sMimeType = 'image/jpg'; 
			        		break;  
			        	default: 
			        		$sMimeType = 'application/force-download';  
			        		// $sMimeType = 'application/octet-stream';
			     	}
	     		}
	     	}
		}		
		
		if (Phpfox::getParam('core.allow_cdn') && $iServerId > 0)
		{
			//$sFile = Phpfox::getLib('cdn')->getUrl(str_replace(PHPFOX_DIR, Phpfox::getParam('core.path'), $sFile), $iServerId);					
			$sFileSize = $sFileSize ? $sFileSize : filesize($sFile);
			$sFile = Phpfox::getLib('cdn')->getUrl(str_replace(PHPFOX_DIR, Phpfox::getParam('core.path'), $sFile), $iServerId); 
		}		

	    // Make sure there's not anything else left
	    ob_clean();
	    /*
	    if ($iServerId && !file_exists($sFile))
	    {
	    	$sServer = Phpfox_Request::instance()->getServerUrl($iServerId);
	    	$sFileServer = $sServer . '/' .str_replace(PHPFOX_DIR, '', $sFile);
	    	$this->copy($sFileServer, $sFile);
	    	
	    }
		*/
	    // Start sending headers
	    header("Pragma: public"); // required
	    header("Expires: 0");
	    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	    header("Cache-Control: private", false); // required for certain browsers
	    header("Content-Transfer-Encoding: binary");
	    header("Content-Type: " . $sMimeType);
	    header("Content-Length: " . ($sFileSize ? $sFileSize : filesize($sFile)));
	    header("Content-Disposition: attachment; filename=\"" . $sName . "\";" );
	    	
	    // Send data
	    readfile($sFile);
	    
	    // If its stored in the cache folder delete it
	    if (preg_match('/cache\/(.*?)\.(.*?)/', $sFile))
	    {
	    	unlink($sFile);
	    }
	    
	    exit;
	}			
	
	/**
	 * Copy a file from one location to another.
	 *
	 * @see copy()
	 * @param string $sSrc Full path to the orginal file
	 * @param string $sDest Full path to where the orignal file will be copied to
	 * @return bool If copy was successful we return TRUE, otherwise we return FALSE
	 */
	public function copy($sSrc, $sDest)
	{
		if (@copy($sSrc, $sDest))
		{
			return true;
		}
		
		return false;
	}
	
	/**
	 * Renames a file
	 *
	 * @see rename()
	 * @param string $sSrc Full path to the orginal file
	 * @param string $sDest Full path to where the new file will be located with its new name
	 * @return bool If rename was successful we return TRUE, otherwise we return FALSE
	 */	
	public function rename($sSrc, $sDest)
	{
		if (@rename($sSrc, $sDest))
		{
			return true;
		}
		
		return false;
	}
	
	/**
	 * Delete a file from the server.
	 *
	 * @see unlink()
	 * @param string $sSrc Full path to the file
	 * @return bool If we were able to delete the file we return TRUE otherwise we return FALSE
	 */
	public function unlink($sSrc)
	{
		if (Phpfox::getParam('core.allow_cdn'))
		{
			try 
		    { 
		        Phpfox::getLib('cdn')->remove($sSrc); 
		    } 
	    	catch(Exception $e){}	    	
		}		
		
		if (@unlink($sSrc))
		{
			return true;
		}
		
		return false;
	}	
	
    /**
     * Checks if path is writable
     *
     * @param string $sPath Path to file or directory
     * @param bool $bForce If set to TRUE we will disable error reporting and force a check on the file/folder
     * @return boolean If file/folder is writable we return TRUE otherwise we return FALSE
     */
    public function isWritable($sPath, $bForce = false)
    {    	
    	clearstatcache();

    	if ($bForce === false)
    	{
	        if (!is_writable($sPath))
	        {
	            if (!stristr(PHP_OS, "win"))
	            {
	                return false;
	            }
	        }
    	}
    	
    	if ($bForce === true)
    	{
    		Phpfox_Error::skip(true);
    	}

        /**
         * Checking if writable on windows OS
         */
        if (stristr(PHP_OS, "win") || $bForce === true)
        {
            /**
             * need to check whether we can really create files in this directory or not
             */
            if (is_dir($sPath))
            {
                /**
                 * Trying to create a new file
                 */
                $fp = @fopen($sPath . PHPFOX_DS . 'win-test.txt', 'w');                
                if (!$fp)
                {
                    if ($bForce === true)
    				{
    					Phpfox_Error::skip(false);	
    				}
                	return false;
                }
                if (!@fwrite($fp, 'test'))
                {
                    if ($bForce === true)
    				{
    					Phpfox_Error::skip(false);	
    				}
                	return false;
                }
                fclose($fp);
                /**
                 * clean up after ourselves
                 */
				if (file_exists($sPath . 'win-test.txt'))
				{
					unlink($sPath . 'win-test.txt');
				}
            } 
            else
            {
                if (!file_exists($sPath))
                {
                    if ($bForce === true)
    				{
    					Phpfox_Error::skip(false);	
    				}                	
                	return false;
                }

                $sContent = @file_get_contents($sPath);
                if (!$fp = @fopen($sPath, 'w'))
                {
                    if ($bForce === true)
    				{
    					Phpfox_Error::skip(false);	
    				}                    
                	return false;
                }
                
                if (!@fwrite($fp, $sContent))
                {
                    if ($bForce === true)
    				{
    					Phpfox_Error::skip(false);	
    				}                	
                	return false;
                }
                
                fclose($fp);
            }
        }
        
        if ($bForce === true)
    	{
    		Phpfox_Error::skip(false);	
		}        
        
        return true;
    }
    
    /**
     * Get the temporary directory of the server based on the servers enviroment variables.
     * Note: Use with caution some servers can be tricky.
     *
     * @return string Returns the best temporary directory we can find.
     */
    public function getTempDir()
    {		
    	if (!empty($_ENV['TMP'])) 
		{
			$sTempDir = $_ENV['TMP'];
		} 
		elseif (!empty($_ENV['TMPDIR'])) 
		{
			$sTempDir = $_ENV['TMPDIR'];
		} 
		elseif (!empty($_ENV['TEMP'])) 
		{
			$sTempDir = $_ENV['TEMP'];
		} 
		else 
		{
			if (function_exists('sys_get_temp_dir'))
			{
				$sTempDir = sys_get_temp_dir();
			}
			else 
			{
	            $sTempFile = tempnam(md5(uniqid(rand(), true)), '');
	            if ($sTempFile)
	            {
	                $sTempDir = realpath(dirname($sTempFile));
	                
	                unlink($sTempFile);                
	            }
	            else
	            {
	                return false;
	            }				
			}
		}    

		return rtrim($sTempDir, PHPFOX_DS) . PHPFOX_DS;	
    }
    
    /**
     * Gets the servers limit on uploading files.
     *
     * @param int $iMaxSize You can define what you want as a limit.
     * @return string Returns the actual limit the server has and if your limit passes the test it will just return your limit.
     */
    public function getLimit($iMaxSize)
    {
    	$iUploadMaxFileSize = (ini_get('upload_max_filesize') * 1048576);
    	$iPostMaxSize = (ini_get('post_max_size') * 1048576);
    	
    	if ( $iUploadMaxFileSize > 0 && $iUploadMaxFileSize < ($iMaxSize * 1048576))
    	{
    		return ini_get('upload_max_filesize');
    	}
    	
    	if ($iPostMaxSize > 0 && $iPostMaxSize < ($iMaxSize * 1048576))
    	{
    		return ini_get('post_max_size');
    	}
    	
    	return $iMaxSize . 'MB';
    }
    
    /**
     * Gets the directory we just built to place an uploaded file.
     *
     * @param string $sDestination Full path to where we should place the uploaded file.
     * @return string Returns the new full path of where the file will be placed.
     */
    public function getBuiltDir($sDestination)
    {
        $this->_buildDir($sDestination);	
    	
    	return $this->_sDestination;	
    }
    
	/**
	 * Deletes a directory and all the files and folders in it (recursive)
	 * 
	 * @param string $sPath Absolute path to the folder
	 */
	public function delete_directory($dir)
	{
        if(is_dir($dir)) 
        {
        	if($dh = opendir($dir)) 
        	{
            	while(($file = readdir($dh)) !== false) 
            	{
                	if($file != '.' && $file != '..') 
                	{
                    	if(is_dir($dir . '/' . $file)) 
                    	{
                        	$this->delete_directory($dir . '/' . $file);
						} 
						else
						{
                        	unlink($dir . '/' . $file);
                         }
                	}
				}
        	}
        	closedir($dh);
        	@rmdir($dir);
        }
	}

	/**
	 * Creates a directory. Unlike mkdir() it can also create recursive directories based
	 * on the full path that is being passed.
	 *
	 * @param string $sDir Full path of the directory to create
	 * @param bool $bRecurse FALSE by default, however if set to TRUE we will create a recursive run on mkdir.
	 */
	public function mkdir($sDir, $bRecurse = false, $mChmod = null)
	{		
		if ($bRecurse === true)
		{			
			$aParts = explode(PHPFOX_DS, trim($sDir, PHPFOX_DS));
			$sParentDirectory = (Phpfox::getLib('server')->isWindows() ? '' : PHPFOX_DS);
			
			foreach ($aParts as $sDir)
			{			
				if (!is_dir($sParentDirectory . $sDir))
				{
					mkdir($sParentDirectory . $sDir);    
					if ($mChmod !== null)
					{
						chmod($sParentDirectory . $sDir, 0777);
					}          
				}		
				
				$sParentDirectory .= $sDir . PHPFOX_DS;
			}			
		}
		else 
		{			
			mkdir($sDir);
			if ($mChmod !== null)
			{
				chmod($sDir, 0777);
			}
		}
	}	
    
	public function getFileDetails()
	{
		return $this->_aFile;
	}
	
	public function getFileExt($sFileName)
	{
		$sFilename = strtolower($sFileName);
		$aExts = preg_split("/[\/\\.]/", $sFileName);
		$iCnt = count($aExts)-1;
		
		return strtolower($aExts[$iCnt]);		
	}
	
	/**
	 * Runs a check to make sure the item being uploaded is allowed to be uploaded
	 * based on the server requirements.
	 *
	 * @return bool Returns TRUE if item is allowed to be uploaded and FALSE if not
	 */
    private function _passLimit()
    {
		
		$aImage = getimagesize($this->_aFile['tmp_name']);
		/*
			0 => width
			1 => height
			2 => IMAGETYPE_XXX
		*/
		if ($aImage[0] < 10 || $aImage[1] < 10)
		{
			//return Phpfox_Error::set('Image dimensions too small');
		}
    	switch ($this->_aFile['error'])
    	{
    		case 1:
    				return Phpfox_Error::set(Phpfox::getPhrase('core.upload_failed_server_cannot_handle_files_larger_then_file_size', array('file_size' => ini_get('upload_max_filesize'))));
    			break;
    		default:
	    			$iSize = filesize($this->_aFile['tmp_name']);
	    			$iPostMaxSize = ((int) ini_get('post_max_size') * 1048576);
	    			
			    	if ($iSize >= $iPostMaxSize)
			    	{
			    		return Phpfox_Error::set(Phpfox::getPhrase('core.upload_failed_server_cannot_handle_files_size_larger_then_file_size', array('size' => $this->filesize($iSize, 0), 'file_size' => $this->filesize($iUploadMaxFileSize))));
			    	}    
			    	
			    	if ($this->_iMaxSize !== null && $iSize >= ($this->_iMaxSize * 1048576))
			    	{
			    		return Phpfox_Error::set(Phpfox::getPhrase('core.upload_failed_your_file_size_is_larger_then_our_limit_file_size', array('size' => $this->filesize($iSize, 0), 'file_size' => $this->filesize(($this->_iMaxSize * 1048576)))));
			    	}
	    			
	    			return true;
    			break;
    	}
    }
	
    /**
     * Builds a directory structure for items being uploaded based on
     * by deafult the month/year we are in. This is a setting in the AdminCP
     * where admins can control how the structure is to be built. Note that if SAFE_MODE
     * is enabled this feature will do nothing as we are not allowed to create folders
     * in such an enviroment.
     *
     * @param string $sDestination Destination of the folder we are to create new folders in.
     * @return mixed Returns TRUE if we were able to create directories and returns NULL if we did nothing
     */
	private function _buildDir($sDestination)
	{
		if (!PHPFOX_SAFE_MODE && Phpfox::getParam('core.build_file_dir') && !defined('PHPFOX_IS_HOSTED_SCRIPT'))
		{
			$aParts = explode('/', Phpfox::getParam('core.build_format'));
			$this->_sDestination = $sDestination;
			foreach ($aParts as $sPart)
			{
				$sDate = date($sPart) . PHPFOX_DS;
				$this->_sDestination .=	$sDate;
				if (!is_dir($this->_sDestination))
				{
					@mkdir($this->_sDestination, 0777);
					@chmod($this->_sDestination, 0777);
				}
			}
			
			// Make sure the directory was actually created, if not we use the default dir we know is working
			if (is_dir($this->_sDestination))
			{
				return true;
			}	
		}
				
		$this->_sDestination = $sDestination;
	}
	
	/**
	 * We find out a files extension based on information passed along with $_FILE
	 *
	 * @see self::_buildFile()
	 */
    private function _getFileType()
    {
    	$sFilename = strtolower($this->_aFile['name']);
		$aExts = preg_split("/[\/\\.]/", $this->_aFile['name']);
		$iCnt = count($aExts)-1;
		$this->_sExt = strtolower($aExts[$iCnt]);
		$this->_aFile['ext'] = strtolower($aExts[$iCnt]);
    }    
    
    /**
     * We build an ARRAY of information about the file based on information passed by $_FORM
     * or $_FORM['FOO'][] with the latter being a multiple uploade routine.
     *
     * @param string $sFormItem The ID to connect with the $_FORM variable
     */
    private function _buildFile($sFormItem)
    {
    	if (strpos($sFormItem, ']') === false)
        {
            $this->_aFile = $_FILES[$sFormItem];
        }
        elseif (preg_match('/^(.+)\[(.+)\]$/', $sFormItem, $aM))
        {
        	$this->_aFile['name']     = $_FILES[$aM[1]]['name'][$aM[2]];
            $this->_aFile['type']     = $_FILES[$aM[1]]['type'][$aM[2]];
            $this->_aFile['tmp_name'] = $_FILES[$aM[1]]['tmp_name'][$aM[2]];
            $this->_aFile['error']    = $_FILES[$aM[1]]['error'][$aM[2]];
            $this->_aFile['size']     = $_FILES[$aM[1]]['size'][$aM[2]];
        }
        else
        {
            /**
             * @todo Add error message here...
             */
        }  	
        
		$this->_getFileType();
    }
    
    /**
     * If this feature is enabled we use getID3 to try to find the mime type by
     * trying to extract meta information. Note that since this is based off a 3rd
     * party library this method has been known to have it share of problems. We are not
     * using this by default until it is fully stable.
     *
     * @param string $sFileName Path to the file we are going to check
     * @return bool TRUE if mime type checked out and FALSE if there is no mime type
     */
	private function _verify($sFileName)
	{
		return true;
	}
}

?>
