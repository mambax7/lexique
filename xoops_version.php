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


//-----------------------------------------------------------------------------------
//global $xoopsModule;
//-----------------------------------------------------------------------------------

if (!defined('_LEX_DIR_NAME')){ 
    define ('_LEX_DIR_NAME','lexique');
}
//----------------------------------------------------------------------------

include_once (dirname(__FILE__)."/include/constantes.php");
include_once (_LEX_JJD_PATH."include/editor_functions.php");

//----------------------------------------------------------------------------

$modversion['name']         = "lexique"; //_MI_LEX_NAME;
$modversion['version']      = "2.15"; 
$modversion['description']  = defined('_MI_LEX_LEXIQUE_DESC')?constant('_MI_LEX_LEXIQUE_DESC'):'Gestion multi-Lexiques';
$modversion['credits']      = "Jean-Jacques DELALANDRE";
$modversion['author']       = "jjd@kiolo.com";
$modversion['initiales']    = "J&deg;J&deg;D";
$modversion['license']      = "GPL";
$modversion['official']     = 0;
$modversion['image']        = "images/lexique_logo.png";
$modversion['dirname']      = _LEX_DIR_NAME;

// Admin things
$modversion['hasAdmin']     = 1;
$modversion['adminindex']   = "admin/index.php";
$modversion['adminmenu']    = "admin/menu.php";

//--------------------------------------------------------

//install:
$modversion['onInstall']     = 'admin/admin_version.php';
//suppression:
$modversion['onUninstall']   = 'admin/admin_version.php';
//mise a jour:
$modversion['onUpdate'] = 'admin/admin_version.php';
//--------------------------------------------------------

// Blocks

$i=1;
$modversion['blocks'][$i]['file']        = "lexique_block_new.php";
$modversion['blocks'][$i]['name']        = 'Lexique';  //_MB_LEX_BNAMEDESC';
$modversion['blocks'][$i]['description'] = '_MD_LEX_BNAMEDESC';
$modversion['blocks'][$i]['show_func']   = "lexique_show_new";
$modversion['blocks'][$i]['edit_func']   = "numDef_edit";
$modversion['blocks'][$i]['options']     = "5";
$modversion['blocks'][$i]['template']    = 'lexique_block_new.html';

$i++;
$modversion['blocks'][$i]['file']        = "lexiqueList_block.php";
$modversion['blocks'][$i]['name']        = 'LexiquesList';  //_MB_LEX_BNAMEDESC';
$modversion['blocks'][$i]['description'] = '_MD_LEX_LEXIQUES';
$modversion['blocks'][$i]['show_func']   = "lexiqueList_show";
$modversion['blocks'][$i]['edit_func']   = "lexiqueList_edit";
$modversion['blocks'][$i]['options']     = "99";
$modversion['blocks'][$i]['template']    = 'lexiqueList_block.html';

// Menu
$modversion['hasMain'] = 1;

/*


$i++;
$modversion['sub'][$i]['name']  = defined('_MI_LEX_SUBMIT')?constant('_MI_LEX_SUBMIT'):'Soumettre une d&eacute;finition';
$modversion['sub'][$i]['url']   = "submit.php";


$modversion['sub'][$i]['name']  = defined('_MI_LEX_QUESTION')?constant('_MI_LEX_QUESTION'):'Demander une d&eacute;finition';
$modversion['sub'][$i]['url']   = "question.php";
*/


// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables created by sql file (without prefix!)
$modversion['tables'][0]  = _LEX_TBL_CATEGORY;
$modversion['tables'][1]  = _LEX_TBL_FAMILY;
$modversion['tables'][2]  = _LEX_TBL_SELECTEUR;
$modversion['tables'][3]  = _LEX_TBL_LEXIQUE;
$modversion['tables'][4]  = _LEX_TBL_TERME;
$modversion['tables'][5]  = _LEX_TBL_TEMP;
$modversion['tables'][6]  = _LEX_TBL_CAPTION;
$modversion['tables'][7]  = _LEX_TBL_CAPTIONSET;
$modversion['tables'][8]  = _LEX_TBL_PROPERTY;
$modversion['tables'][9]  = _LEX_TBL_PROPERTYSET;
$modversion['tables'][10] = _LEX_TBL_PROPERTYVAL;
$modversion['tables'][11] = _LEX_TBL_ACCESS;
$modversion['tables'][12] = _LEX_TBL_LIST;


// Templates
$i = 0;

/*

$i++;
$modversion['templates'][$i]['file']         = 'adminOnglet.html';
$modversion['templates'][$i]['description']  = 'Admin onglet';
*/

$i++;
$modversion['templates'][$i]['file']         = 'lexique_index.html';
$modversion['templates'][$i]['description']  = 'Page Layout';

$i++;
$modversion['templates'][$i]['file']         = 'lexique_post.html';
$modversion['templates'][$i]['description']  = 'Page Layout';

$i++;
$modversion['templates'][$i]['file']         = 'lexique_letter.html';
$modversion['templates'][$i]['description']  = 'Page Layout';

$i++;
$modversion['templates'][$i]['file']         = 'lexique_question.html';
$modversion['templates'][$i]['description']  = 'Page Layout';

$i++;
$modversion['templates'][$i]['file']         = 'lexique_submit.html';
$modversion['templates'][$i]['description']  = 'Page Layout';

$i++;
$modversion['templates'][$i]['file']         = 'lexique_search.html';
$modversion['templates'][$i]['description']  = 'Page Layout';

$i++;
$modversion['templates'][$i]['file']         = 'lexique_detail.html';
$modversion['templates'][$i]['description']  = 'Page Layout';

$i++;
$modversion['templates'][$i]['file']         = 'lexique_searchhead.html';
$modversion['templates'][$i]['description']  = 'Page Layout';

$i++;
$modversion['templates'][$i]['file']         = 'lexique_letterbar.html';
$modversion['templates'][$i]['description']  = 'Page Layout';

$i++;
$modversion['templates'][$i]['file']        = 'lexique_postcat.html';
$modversion['templates'][$i]['description'] = 'Page Layout';

$i++;
$modversion['templates'][$i]['file']        = 'lexique_searchExp.html';
$modversion['templates'][$i]['description'] = 'Page Layout';

$i++;
$modversion['templates'][$i]['file']        = 'lexique_propertyEdit.html';
$modversion['templates'][$i]['description'] = 'Property Edit';

$i++;
$modversion['templates'][$i]['file']        = 'lexique_propertyView.html';
$modversion['templates'][$i]['description'] = 'Property view';

$i++;
$modversion['templates'][$i]['file']        = 'lexique_lexique.html';
$modversion['templates'][$i]['description'] = 'Page lexique';

$i++;
$modversion['templates'][$i]['file']        = 'lexique_list.html';
$modversion['templates'][$i]['description'] = 'Page lexique list';

$i++;
$modversion['templates'][$i]['file']        = 'lexique_print.html';
$modversion['templates'][$i]['description'] = 'Entete des impressions';

$i++;
$modversion['templates'][$i]['file']        = 'lexique_buttons.html';
$modversion['templates'][$i]['description'] = 'buttons';

$i++;
$modversion['templates'][$i]['file']        = 'lexique_toolbarre.html';
$modversion['templates'][$i]['description'] = 'Tool barre';
$i++;
$modversion['templates'][$i]['file']        = 'lexique_footer.html';
$modversion['templates'][$i]['description'] = 'Pied de page gTnTral';
$i++;
$modversion['templates'][$i]['file']        = 'lexique_loadFile.html';
$modversion['templates'][$i]['description'] = 'Formlaire de chargemet de fichiers';

//------------------------------------------------------------------
// Search
$modversion['hasSearch']      = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "lex_search";

// Comments
$modversion['hasComments']          = 1;
$modversion['comments']['pageName'] = 'detail.php';
$modversion['comments']['itemName'] = 'id';

$modversion['comments']['callbackFile']         = 'include/comment_functions.php';
$modversion['comments']['callback']['approve']  = 'lexique_com_approve';
$modversion['comments']['callback']['update']   = 'lexique_com_update';



            
//------------------------------------------------------------------
// Config Settings
//------------------------------------------------------------------
$i=-1;
//------------------------------------------------------------------
// General 
//------------------------------------------------------------------
$i++;
$modversion['config'][$i]['name'] = 'dateVersion';
$modversion['config'][$i]['title'] = 'dateVersion';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '19/10/2008';


//------------------------------------------------------------------
//  Definition
//------------------------------------------------------------------
$i++;
$modversion['config'][$i]['name'] = 'textintro';
$modversion['config'][$i]['title'] = '_MI_LEX_INTROTEXT';
$modversion['config'][$i]['description'] = '_MI_LEX_INTROTEXTDESC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'urlDoc';
$modversion['config'][$i]['title'] = '_MI_LEX_URLDOC';
$modversion['config'][$i]['description'] = '_MI_LEX_URLDOC_DSC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'xoops.kiolo.com';

$i++;
$modversion['config'][$i]['name'] = 'editor';
$modversion['config'][$i]['title'] = '_MI_LEX_EDITOR';
$modversion['config'][$i]['description'] = '_MI_LEX_EDITOR_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['options'] =  getEditorList();

$i++;
$modversion['config'][$i]['name'] = 'alphabet';
$modversion['config'][$i]['title'] = '_MI_LEX_ALPHABET';
$modversion['config'][$i]['description'] = '_MI_LEX_ALPHABET_DEFAULT_DSC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

$i++;
$modversion['config'][$i]['name'] = 'showMenuList';
$modversion['config'][$i]['title'] = '_MI_LEX_MENULIST';
$modversion['config'][$i]['description'] = '_MI_LEX_MENULIST_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['options'] = array('_NO' => 0, 
                                             '_YES' => 1);
$i++;
$modversion['config'][$i]['name'] = 'showMenuBtn';
$modversion['config'][$i]['title'] = '_MI_LEX_MENUBTN';
$modversion['config'][$i]['description'] = '_MI_LEX_MENUBTN_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['options'] = array('_NO' => 0, 
                                             '_YES' => 1);


$i++;
$modversion['config'][$i]['name'] = 'categoriesMax';
$modversion['config'][$i]['title'] = '_MI_LEX_CATMAX';
$modversion['config'][$i]['description'] = '_MI_LEX_CATMAX_DSC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '16';



$i++;
$modversion['config'][$i]['name'] = 'imgCounterFolder';
$modversion['config'][$i]['title'] = '_MI_LEX_NOTE_FOLDER';
$modversion['config'][$i]['description'] = '_MI_LEX_NOTE_FOLDER_DSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = ""
        ."/modules/xoopsvisit/images/templates/*/?.gif\n"
        ."/modules/xoopsvisit/images/templates/*/?.jpg\n"
        ."/modules/xoopsvisit/images/templates/*/?.png\n"                
        ."/modules/counter/images/*/?.gif\n"	
        ."/modules/counter/images/*/?.jpg\n"
        ."/modules/counter/images/*/?.png\n";
/**
 **/
//------------------------------------------------------------------------
// utilisation de security image
$i++;
$modversion['config'][$i]['name'] = 'capcha_question';
$modversion['config'][$i]['title'] = '_MI_LEX_CAPCHA_QUESTION';
$modversion['config'][$i]['description'] = '_MI_LEX_CAPCHA_QUESTION_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$modversion['config'][$i]['options'] = array('_NO' => 0, 
                                             '_YES' => 1);
                                             
// utilisation de security image
$i++;
$modversion['config'][$i]['name'] = 'capcha_terme';
$modversion['config'][$i]['title'] = '_MI_LEX_CAPCHA_TERME';
$modversion['config'][$i]['description'] = '_MI_LEX_CAPCHA_TERME_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$modversion['config'][$i]['options'] = array('_NO' => 0, 
                                             '_YES' => 1);
 
//-------------------------------------------------------------------------

$i++;
$modversion['config'][$i]['name'] = 'traitementJJD';
$modversion['config'][$i]['title'] = '_MI_LEX_TRAITEMENT_JJD';
$modversion['config'][$i]['description'] = '_MI_LEX_TRAITEMENT_JJD_DSC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';

//--------------------------------------------------------------
// Notification
$modversion['hasNotification'] = 1;

$modversion['notification']['category'][1]['name'] = 'global';
$modversion['notification']['category'][1]['title'] =  defined('_MI_LEX_NOTIFY')?constant('_MI_LEX_NOTIFY'):'???';
$modversion['notification']['category'][1]['description'] = defined('_MI_LEX_NOTIFYDSC')?constant('_MI_LEX_NOTIFYDSC'):'???';
$modversion['notification']['category'][1]['subscribe_from'] = 'index.php';

$modversion['notification']['event'][1]['name'] = 'new_post';
$modversion['notification']['event'][1]['category'] = 'global';
$modversion['notification']['event'][1]['title'] = defined('_MI_LEX_NEWPOST_NOTIFY')?constant('_MI_LEX_NEWPOST_NOTIFY'):'???';
$modversion['notification']['event'][1]['caption'] = defined('_MI_LEX_NEWPOST_NOTIFYCAP')?constant('_MI_LEX_NEWPOST_NOTIFYCAP'):'???';
$modversion['notification']['event'][1]['description'] = defined('_MI_LEX_NEWPOST_NOTIFYDSC')?constant('_MI_LEX_NEWPOST_NOTIFYDSC'):'???';
$modversion['notification']['event'][1]['mail_template'] = 'lexique_newpost_notify';
$modversion['notification']['event'][1]['mail_subject'] = defined('_MI_LEX_NEWPOST_NOTIFYSBJ')?constant('_MI_LEX_NEWPOST_NOTIFYSBJ'):'???';


?>
