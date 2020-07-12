[categories] => Catégories
[definition1] => Première définition
[definition2] => Seconde définition
[definition3] => Troisième définition
[lexique] => Lexique
[referentiel] => Référenciel
[seealso] => Voir aussi
[shortdef] => Définition courte:
[terme] => Terme:
[category] => Catégorie
[definitions1] => DEFS1
[definitions2] => DEFS2
[definitions3] => DEFS3
[lesDefinitions1] => DEFINITIONS1
[lesDefinitions2] => DEFINITIONS2
[lesDefinitions3] => DEFINITIONS3
[properties] => Propriétés
[property] => Propriété
[termesAndDefinitions] => le terme et les définitions
[idCaption] => 0
[family] => Discipline
[copyright] => lexique Version 2.06 Author J°J°D
[add] => Soumettre




$libelle[_LEX_LANG_SHORTDEF2]);
$libelle[_LEX_LANG_SEEALSO2]);
$libelle[_LEX_LANG_DEFINITION1]);	
$libelle[_LEX_LANG_DEFINITION2]);
$libelle[_LEX_LANG_DEFINITION3]);        	
$libelle[_LEX_LANG_TERME2]);		
$libelle[_LEX_LANG_REFERENCIEL_TITLE1]); 
$libelle[_LEX_LANG_FAMILY]);








		$xoopsTpl->assign('lang_shortdef2',     $libelle[_LEX_LANG_SHORTDEF2]);
		$xoopsTpl->assign('lang_seealso2',      $libelle[_LEX_LANG_SEEALSO2]);
		$xoopsTpl->assign('lang_def1',          $libelle[_LEX_LANG_DEFINITION1]);	
		$xoopsTpl->assign('lang_def2',          $libelle[_LEX_LANG_DEFINITION2]);
		$xoopsTpl->assign('lang_def3',          $libelle[_LEX_LANG_DEFINITION3]);        	
		$xoopsTpl->assign('lang_terme2',        $libelle[_LEX_LANG_TERME2]);		
    $xoopsTpl->assign('lang_referentiel1',  $libelle[_LEX_LANG_REFERENCIEL_TITLE1]); 
    $xoopsTpl->assign('lang_category',      $libelle[_LEX_LANG_FAMILY]);
    $xoopsTpl->assign('lang_add', $btnOK);
		$xoopsTpl->assign('lang_cancel', _CANCEL);
	$xoopsTpl->assign('lang_copyright', getCopyright());































DELETE FROM `xoops_lex_access`;
  
INSERT INTO `xoops_lex_access` 
(`idLexique`, `idGroup`, `isDefine`, `buttonAccess`, `readAccessList`, `readPropertyList`) 
VALUES 
(1, 1, 1, 3, 3, 3),
(2, 1, 1, 3, 3, 3),
(3, 1, 1, 3, 3, 3),
(4, 1, 1, 3, 3, 3),
(5, 1, 1, 3, 3, 3),
(6, 1, 1, 3, 3, 3),
(7, 1, 1, 0, 1, 1);

