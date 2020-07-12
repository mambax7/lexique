<?php
//  ------------------------------------------------------------------------ //
//            LEXIQUE - Module de gestion de lexiques pour XOOPS             //
//                    Copyright (c) 2006 JJ Delalandre                       //
//                       <http://kiolo.com>                                  //
//  ------------------------------------------------------------------------ //
/******************************************************************************

Module LEXIQUE version 1.6.2 pour XOOPS- Gestion multi-lexiques 
Copyright (C) 2007 Jean-Jacques DELALANDRE 
Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes de la Licence Publique GTnTrale GNU publiTe par la Free Software Foundation (version 2 ou bien toute autre version ultTrieure choisie par vous). 

Ce programme est distribuT car potentiellement utile, mais SANS AUCUNE GARANTIE, ni explicite ni implicite, y compris les garanties de commercialisation ou d'adaptation dans un but spTcifique. Reportez-vous a la Licence Publique GTnTrale GNU pour plus de dTtails. 

Vous devez avoir retu une copie de la Licence Publique GTnTrale GNU en mOme temps que ce programme ; si ce n'est pas le cas, Tcrivez a la Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, +tats-Unis. 

DerniFre modification : juin 2007 
******************************************************************************/
//-----------------------------------------------------------------
define ('_LEX_SHOWID', true);
//-----------------------------------------------------------------
//define ('_br', "\n");
//define ('_br', '<br>');
//-----------------------------------------------------------------
//Definition des constante e dossier
//-----------------------------------------------------------------
global $xoopsModule;
if (!defined('_LEX_DIR_NAME')){ 
    define ('_LEX_DIR_NAME','lexique');
}

if (!defined('_LEX_NAME')){ 
    define ('_LEX_NAME','Lexiques');
}

define ('_LEX_JJD_PATH',      XOOPS_ROOT_PATH.'/modules/jjd_tools/_common/');
define ('_LEX_SUB_FOLDER',    '/modules/'._LEX_DIR_NAME.'/'  );


//define ('_LEX_DIR_NAME',            $xoopsModule->getVar('dirname')  );
//echo "<hr>"._LEX_DIR_NAME."<hr>";



/*

define ('_LEX_URL',             XOOPS_URL.'/modules/'._LEX_DIR_NAME.'/'  );



define ('_LEX_ROOT_PATH',        XOOPS_ROOT_PATH.'/modules/'._LEX_DIR_NAME.'/' );
define ('_LEX_DIR_INCLUDE',     _LEX_ROOT_PATH.'/include/'  );
define ('_LEX_DIR_ADMIN',       _LEX_ROOT_PATH.'/admin/'  );
define ('_LEX_DIR_IMAGES',      _LEX_ROOT_PATH.'/images/'  );
*/
$xoopsRP = XOOPS_ROOT_PATH . ((substr(XOOPS_ROOT_PATH,-1)=='/') ? '': '/');
define ('_LEX_ROOT', XOOPS_ROOT_PATH . ((substr(XOOPS_ROOT_PATH,-1)=='/') ? '': '/'));
//-----------------------------------------------------------------------------
define ('_LEX_ROOT_PATH',   XOOPS_ROOT_PATH.'/modules/'._LEX_DIR_NAME.'/'  );
define ('_LEX_ROOT_JJD',    _LEX_JJD_PATH.'include/'  );
define ('_LEX_ROOT_UPLOAD', $xoopsRP.'uploads/lexique/'  );
define ('_LEX_URL_UPLOAD', XOOPS_URL.'/uploads/lexique/'  );
define ('_LEX_PREFIX_UPLOAD', 'def-'  );


define ('_LEX_ROOT_ADMIN',     _LEX_ROOT_PATH.'admin/');
define ('_LEX_ROOT_BLOCKS',    _LEX_ROOT_PATH.'blocks/');
define ('_LEX_ROOT_DOC',       _LEX_ROOT_PATH.'doc/');
define ('_LEX_ROOT_IMAGES',    _LEX_ROOT_PATH.'images/');
define ('_LEX_ROOT_INCLUDE',   _LEX_ROOT_PATH.'include/');
define ('_LEX_ROOT_LANGUAGE',  _LEX_ROOT_PATH.'language/');
define ('_LEX_ROOT_LOG',       _LEX_ROOT_PATH.'log/');
define ('_LEX_ROOT_SQL',       _LEX_ROOT_PATH.'sql/');
define ('_LEX_ROOT_TEMPLATES', _LEX_ROOT_PATH.'templates/');
define ('_LEX_ROOT_NOTEIMG',   _LEX_ROOT_PATH.'images/note/');
//-----------------------------------------------------------------------------

define ('_LEXCST_DIR_ROOT',       '/modules/'._LEX_DIR_NAME.'/'  );


//-----------------------------------------------------------------
define ('_LEXCST_DIR_JS',        '/include/jjd/js/');
//-----------------------------------------------------------------
define ('_LEX_URL',             XOOPS_URL.'/modules/'._LEX_DIR_NAME.'/');
define ('_LEX_URL_ADMIN',        _LEX_URL.'admin/');
define ('_LEX_URL_IMG',          _LEX_URL.'images/');
define ('_LEX_URL_ICONES',       _LEX_URL.'images/icones/');
define ('_LEX_URL_LEXICONES',    _LEX_URL.'images/lexIcones/');
define ('_LEX_URL_CACHE',        _LEX_URL.'cache/');
define ('_LEX_URL_INCLUDE',      _LEX_URL.'include/'  );
define ('_LEX_URL_NOTEIMG',      _LEX_URL.'images/note/');
//-----------------------------------------------------------------
//define ('_JJD_JS_TOOLS',     XOOPS_URL.'/include/jjd/js/jjd_tools.js');
//define ('_JJD_JSI_TOOLS',     "<script type=\"text/javascript\" src=\""._JJD_JS_TOOLS."\"></script>\n");

define ('_LEX_JS_LEXIQUE',   _LEX_URL.'js/lex_tools.js');
define ('_LEX_JS_CATEGORY',  _LEX_URL.'js/lex_catrequest.js');


define ('_LEX_JSI_LEXIQUE',   "<script type=\"text/javascript\" src=\""._LEX_JS_LEXIQUE."\"></script>\n");
define ('_LEX_JSI_CATEGORY',  "<script type=\"text/javascript\" src=\""._LEX_JS_CATEGORY."\"></script>\n");
//-----------------------------------------------------------------
//define ('_LEX_GOTO_ADMIN', "javascript:window.navigate(\"".XOOPS_URL.""._LEXCST_DIR_ROOT."admin/index.php\");");
//define ('_LEX_GOTO_ADMIN', buildUrlJava(XOOPS_URL._LEXCST_DIR_ROOT."admin/index.php",false)) ;

//-----------------------------------------------------------------
//Definition des constante de table
//-----------------------------------------------------------------
define ('_LEX_PREFIXE',         'lex_');
define ('_LEX_TAB_PREFIXE',     'lex_');


define ('_LEX_TAB_ACCESS',      'access');
define ('_LEX_TAB_CAPTION',     'caption');
define ('_LEX_TAB_CAPTIONSET',  'captionset');
define ('_LEX_TAB_CATEGORY',    'category');
define ('_LEX_TAB_FAMILY',      'family');
define ('_LEX_TAB_LEXIQUE',     'lexique');
define ('_LEX_TAB_LIST',        'list');
define ('_LEX_TAB_PROPERTY',    'property');
define ('_LEX_TAB_PROPERTYSET', 'propertyset');
define ('_LEX_TAB_PROPERTYVAL', 'propertyval');
define ('_LEX_TAB_SELECTEUR',   'selecteur');
define ('_LEX_TAB_TEMP',        'temp');
define ('_LEX_TAB_TERME',       'terme');


define ('_LEX_TBL_LEXIQUE',     _LEX_TAB_PREFIXE._LEX_TAB_LEXIQUE);
define ('_LEX_TBL_TERME',       _LEX_TAB_PREFIXE._LEX_TAB_TERME);
define ('_LEX_TBL_TEMP',        _LEX_TAB_PREFIXE._LEX_TAB_TEMP);
define ('_LEX_TBL_FAMILY',      _LEX_TAB_PREFIXE._LEX_TAB_FAMILY);
define ('_LEX_TBL_CATEGORY',    _LEX_TAB_PREFIXE._LEX_TAB_CATEGORY);
define ('_LEX_TBL_SELECTEUR',   _LEX_TAB_PREFIXE._LEX_TAB_SELECTEUR);
define ('_LEX_TBL_CAPTION',     _LEX_TAB_PREFIXE._LEX_TAB_CAPTION);
define ('_LEX_TBL_CAPTIONSET',  _LEX_TAB_PREFIXE._LEX_TAB_CAPTIONSET);
define ('_LEX_TBL_PROPERTY',    _LEX_TAB_PREFIXE._LEX_TAB_PROPERTY);
define ('_LEX_TBL_PROPERTYSET', _LEX_TAB_PREFIXE._LEX_TAB_PROPERTYSET);
define ('_LEX_TBL_PROPERTYVAL', _LEX_TAB_PREFIXE._LEX_TAB_PROPERTYVAL);
define ('_LEX_TBL_ACCESS',      _LEX_TAB_PREFIXE._LEX_TAB_ACCESS);
define ('_LEX_TBL_LIST',        _LEX_TAB_PREFIXE._LEX_TAB_LIST);

//-----------------------------------------------------------------
define ('_LEX_TAB_USERS',       'users');
define ('_LEX_TAB_GLOSSAIRE',   'glossaire');
define ('_LEX_TAB_GROUPS',      'groups');
//-----------------------------------------------------------------

global $xoopsDB;

define ('_LEX_TFN_LEXIQUE',     $xoopsDB->prefix(_LEX_TAB_PREFIXE._LEX_TAB_LEXIQUE));
define ('_LEX_TFN_TERME',       $xoopsDB->prefix(_LEX_TAB_PREFIXE._LEX_TAB_TERME));
define ('_LEX_TFN_TEMP',        $xoopsDB->prefix(_LEX_TAB_PREFIXE._LEX_TAB_TEMP));
define ('_LEX_TFN_FAMILY',      $xoopsDB->prefix(_LEX_TAB_PREFIXE._LEX_TAB_FAMILY));
define ('_LEX_TFN_CATEGORY',    $xoopsDB->prefix(_LEX_TAB_PREFIXE._LEX_TAB_CATEGORY));
define ('_LEX_TFN_SELECTEUR',   $xoopsDB->prefix(_LEX_TAB_PREFIXE._LEX_TAB_SELECTEUR));

define ('_LEX_TFN_CAPTION',     $xoopsDB->prefix(_LEX_TAB_PREFIXE._LEX_TAB_CAPTION));
define ('_LEX_TFN_CAPTIONSET',  $xoopsDB->prefix(_LEX_TAB_PREFIXE._LEX_TAB_CAPTIONSET));
define ('_LEX_TFN_PROPERTY',    $xoopsDB->prefix(_LEX_TAB_PREFIXE._LEX_TAB_PROPERTY));
define ('_LEX_TFN_PROPERTYSET', $xoopsDB->prefix(_LEX_TAB_PREFIXE._LEX_TAB_PROPERTYSET));
define ('_LEX_TFN_PROPERTYVAL', $xoopsDB->prefix(_LEX_TAB_PREFIXE._LEX_TAB_PROPERTYVAL));
define ('_LEX_TFN_ACCESS',      $xoopsDB->prefix(_LEX_TAB_PREFIXE._LEX_TAB_ACCESS));
define ('_LEX_TFN_LIST',        $xoopsDB->prefix(_LEX_TAB_PREFIXE._LEX_TAB_LIST));


define ('_LEX_TFN_USERS',       $xoopsDB->prefix(_LEX_TAB_USERS));
define ('_LEX_TFN_GLOSSAIRE',   $xoopsDB->prefix(_LEX_TAB_GLOSSAIRE));

define ('_LEX_TFN_LGPREFIXE0',  strlen($xoopsDB->prefix(_LEX_TAB_PREFIXE)));
define ('_LEX_TFN_LGPREFIXE1',  strlen($xoopsDB->prefix(_LEX_TAB_PREFIXE))-strlen(_LEX_TAB_PREFIXE));
//-----------------------------------------------------------------

define ('_LEXCOL_SEEALSO',     'seeAlsoList');
define ('_LEXCOL_SEEALSOID',   'seeAlsoList');


define ('_LEXCST_SA_NOCACHE',   0);
define ('_LEXCST_SA_CACHEON',   1);
define ('_LEXCST_SA_CACHEMARK', 2);



//---------------------------------
define ('_LEXJJD_DEBUG',        255);
//---------------------------------
define ('_LEXJJD_DEBUG_NONE',   0);
define ('_LEXJJD_DEBUG_ALL',  255);

define ('_LEXJJD_DEBUG_VAR',    1);
define ('_LEXJJD_DEBUG_SQL',    2);
define ('_LEXJJD_DEBUG_ARRAY',  4);
define ('_LEXJJD_DEBUG_08',     8);
define ('_LEXJJD_DEBUG_16',    16);
define ('_LEXJJD_DEBUG_32',    32);



define ('_LEXCST_OTHER_NONE',      '@');
define ('_LEXCST_MODELESELECTEUR', ' A B C ... X Y Z ');
define ('_LEXCST_FRAMEDELIMITOR',  '#;(#);[#];{#};<#>');


//------------------------------------------------------------------------
//attention que ces consante soit sinchrone avec la liste dans admin_Acces 
//qui permet de definirles autotisation
//------------------------------------------------------------------------
$h = -1;
define('_LEX_BYTE_VISIBLE_IN_GROUP', 1+$h++);define('_LEXBTN_VISIBLE_IN_GROUP', pow(2, $h));


$h = -1;
define('_LEX_BYTE_HOME_BIBLIO', 1+$h++);define('_LEXBTN_HOME_BIBLIO',   pow(2, $h));
define('_LEX_BYTE_HOME_LEXIQUE',1+$h++);define('_LEXBTN_HOME_LEXIQUE',  pow(2, $h));
define('_LEX_BYTE_SEARCH',      1+$h++);define('_LEXBTN_SEARCH',        pow(2, $h));
define('_LEX_BYTE_NEW',         1+$h++);define('_LEXBTN_NEW',           pow(2, $h));
define('_LEX_BYTE_ASKDEF',      1+$h++);define('_LEXBTN_ASKDEF',        pow(2, $h));
define('_LEX_BYTE_SENDMAIL_LEX',1+$h++);define('_LEXBTN_SENDMAIL_LEX',  pow(2, $h));
define('_LEX_BYTE_NOTE_LEX' ,   1+$h++);define('_LEXBTN_NOTE_LEX',      pow(2, $h));
define('_LEX_BYTE_ADMIN',       1+$h++);define('_LEXBTN_ADMIN',         pow(2, $h));


define('_LEX_BYTE_VIEW',        1+$h++);define('_LEXBTN_VIEW',          pow(2, $h));
define('_LEX_BYTE_EDIT',        1+$h++);define('_LEXBTN_EDIT',          pow(2, $h));
define('_LEX_BYTE_DELETE',      1+$h++);define('_LEXBTN_DELETE',        pow(2, $h));
define('_LEX_BYTE_MOVE_DEF',    1+$h++);define('_LEXBTN_MOVE_DEF',      pow(2, $h));
define('_LEX_BYTE_PRINT',       1+$h++);define('_LEXBTN_PRINT',         pow(2, $h));
define('_LEX_BYTE_SENDMAIL',    1+$h++);define('_LEXBTN_SENDMAIL',      pow(2, $h));
define('_LEX_BYTE_COMMENT',     1+$h++);define('_LEXBTN_COMMENT',       pow(2, $h));
define('_LEX_BYTE_FOLLOW',      1+$h++);define('_LEXBTN_FOLLOW',        pow(2, $h));

define('_LEX_BYTE_SHOWVISIT' ,  1+$h++);define('_LEXBTN_SHOWVISIT',     pow(2, $h));
define('_LEX_BYTE_SHOWOPTION',  1+$h++);define('_LEXBTN_SHOWOPTION',    pow(2, $h));

define('_LEX_BYTE_NOTE_TERME' , 1+$h++);define('_LEXBTN_NOTE_TERME',    pow(2, $h));
define('_LEX_BYTE_FILES' ,      1+$h++);define('_LEXBTN_FILES',         pow(2, $h));

define('_LEX_BYTE_COMMENT1' ,   1+$h++);define('_LEXBTN_COMMENT1',      pow(2, $h));
define('_LEX_BYTE_COMMENT2' ,   1+$h++);define('_LEXBTN_COMMENT2',      pow(2, $h));

define('_LEXBTN_ALL',       pow(2, ($h+1)) -1 );
define('_LEXBTN_NONE',        0);

                        
define('_LEXBTN_MENU0', _LEXBTN_HOME_BIBLIO + _LEXBTN_HOME_LEXIQUE + _LEXBTN_SEARCH
                      + _LEXBTN_NEW + _LEXBTN_ASKDEF + _LEXBTN_SENDMAIL_LEX
                      + _LEXBTN_NOTE_LEX + _LEXBTN_ADMIN);



define('_LEXBTN_TLB_MENU0',    _LEXBTN_MENU0);
define('_LEXBTN_TLB_MASKED', _LEXBTN_ALL & (~_LEXBTN_MENU0) );



$h=0;

//------------------------------------------------------------------------


define('_LEXCST_SEPARTEUR_SEEALSO',  "[<B><font color='#0000FF'> : , ; | / </font></B>]");

define('_LEX_STATE_OK',        'O'); //ok
define('_LEX_STATE_BLOCKED',   'B'); //bloque
define('_LEX_STATE_WAIT',      'N'); //proposition en attente de validatiion
define('_LEX_STATE_ASK',       'A'); //demande de definition
define('_LEX_STATE_LIST',      'OBNA'); 

define('_LEX_ACTION_MENU',      0);
define('_LEX_ACTION_SEARCH',    1);
define('_LEX_ACTION_ASKDEF',    2);
define('_LEX_ACTION_ADDDEF',    3);

/************************************************************************
 * 
 ************************************************************************/


/************************************************************************
 * ces constante doivesnt avoir les nom des constantes par defaut non prefixTes
 ************************************************************************/

define('_LEX_LANG_CATEGORYS',   'categories');
define('_LEX_LANG_CATEGORY',    'category');

define('_LEX_LANG_DEF1',        'def1');
define('_LEX_LANG_DEF2',        'def2');
define('_LEX_LANG_DEF3',        'def3');

define('_LEX_LANG_DEFS1',        'DEFS1');
define('_LEX_LANG_DEFS2',        'DEFS2');
define('_LEX_LANG_DEFS3',        'DEFS3');

define('_LEX_LANG_DEFINITION1', 'definition1');
define('_LEX_LANG_DEFINITION2', 'definition2');
define('_LEX_LANG_DEFINITION3', 'definition3');


define('_LEX_LANG_DEFINITIONS1', 'lesDefinitions1');
define('_LEX_LANG_DEFINITIONS2', 'lesDefinitions2');
define('_LEX_LANG_DEFINITIONS3', 'lesDefinitions3');

define('_LEX_LANG_NAME',        'lexique');
define('_LEX_LANG_REFERENCIEL', 'referentiel');
define('_LEX_LANG_SEEALSO2',    'seealso');
define('_LEX_LANG_SHORTDEF2',   'shortdef');
define('_LEX_LANG_TERME2',      'terme');
define('_LEX_LANG_TERMEANDDEFINITIONS',     'termesAndDefinitions');
define('_LEX_LANG_REFERENCIEL_TITLE1',      'referentiel');

define('_LEX_LANG_PROPERTY',  'property');
define('_LEX_LANG_PROPERTYS', 'properties');
define('_LEX_LANG_FOLLOW',    'follow');
define('_LEX_LANG_DOWNLOAD',  'download');
//--------------------------------------------------
define('_LEX_LANG_FAMILY', 'family');
//--------------------------------------------------


//*************************************************************************//



define ('_LEX_PREFIX_ID'    , 'id_');
define ('_LEX_PREFIX_NAME'  , 'name_');
/*************************************************************************
* frfinition de constante pour la gestion des droit d'acces
*************************************************************************/
define('_LEX_BYTE_DEFAULT_BUTTON',       195);
define('_LEX_BYTE_DEFAULT_BTN_TLB',      pow(2, 8)-1);

define('_LEX_BYTE_DEFAULT_BTN_LIST',     pow(2,32)-1);
define('_LEX_BYTE_DEFAULT_READLIST',     pow(2, 8)-1);
define('_LEX_BYTE_DEFAULT_PROPERTYLIST', pow(2,32)-1);

define('_LEX_BYTE_DEFAULT_BTN_FORM',     pow(2,32)-1);
define('_LEX_BYTE_DEFAULT_READFORM',     pow(2, 8)-1);
define('_LEX_BYTE_DEFAULT_PROPERTYFORM', pow(2,32)-1);

define('_LEX_BYTE_DEFAULT_SHOWOPTION',   0 );

   
//attention que ces consante soit sinchrone avec la liste dans admin_Acces 
//qui permet de definirles autotisation



define('_LEX_BYTE_DEFINITION1', 0);
define('_LEX_BYTE_DEFINITION2', 1);
define('_LEX_BYTE_DEFINITION3', 2);
define('_LEX_BYTE_SHORTDEF'   , 3);
define('_LEX_BYTE_CATEGORYS'  , 4);
define('_LEX_BYTE_SEEALSO'    , 5);
define('_LEX_BYTE_DOWNLOAD'   , 6);
//define('_LEX_BYTE_FOLLOW2'     , 7);


/*************************************************************************
* frfinition de constante pour la gestion des droit d'acces
*************************************************************************/
define('_LEX_SHOW_IDLEXIQUE'     , 0);
define('_LEX_SHOW_IDTERME_AUTO'  , 1);
define('_LEX_SHOW_IDTERME_LEX'   , 2);
define('_LEX_SHOW_IDFAMILY'      , 3);
define('_LEX_SHOW_IDCATEGORY'    , 4);
define('_LEX_SHOW_IDPROPERTY'    , 5);


/*************************************************************************
* definition des onglets
*************************************************************************/
define('_LEX_ONGLET_GESTION',   0);
define('_LEX_ONGLET_LEXIQUE',   1);
define('_LEX_ONGLET_SELECTEUR', 2);
define('_LEX_ONGLET_FAMILY',    3);
define('_LEX_ONGLET_CAPTION',   4);
define('_LEX_ONGLET_PROPERTY',  5);
define('_LEX_ONGLET_LIST',      6);

define('_LEX_ONGLET_DOC',       7);
define('_LEX_ONGLET_LICENCE',   8);
define('_LEX_ONGLET_JJD_TOOLS', 9);







?>
