<?PHP
/**
 * @package	ImageSizer for Joomla! 3.x
 * @version	3.2.4
 * @author	reDim GmbH
 * @copyright	(C) 2009-2015 reDim GmbH All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('JPATH_BASE') or die;
#JHtml::_('behavior.framework', true);
#jimport('joomla.html.html.bootstrap');
#JHTML::_('behavior.bootstrap'); 
#JHtml::_('jquery.framework');

#JHTml::_('behavior.jquery');

$path="/plugins"."/"."system"."/"."imagesizer"."/"."lbscripts"."/"."colorbox"."/";

$document   = JFactory::getDocument();

#	$document->addScript('/media/jui/js/jquery.ui.core.min.js');
$document->addScript('https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');

$document->addStyleSheet(redim_imagesizer_class::clean_include_documentpath($path.'colorbox.css'),'text/css',"all");
$document->addScript(redim_imagesizer_class::clean_include_documentpath($path.'colorbox.min.js'));

$document->addScriptDeclaration("
jQuery(document).ready(function() {
	$('a.colorbox').colorbox({rel:'colorbox'});	
});
");

unset($path);


function imagesizer_addon_colorbox(&$ar,&$imagesizer){

	$output=plgSystemimagesizer::make_img_output($ar);
	
	if(isset($ar["title"])){
		$title=' title="'.$ar["title"].'"';
	}else{
		if(isset($ar["alt"])){
			$title=' title="'.$ar["alt"].'"';
		}else{
			$title="";
		} 
	} 

	$id=0;
	
	if(isset($imagesizer->article->id)){
		$id=$imagesizer->article->id;
	}
	
	$output='<a class="colorbox '.trim($imagesizer->params->get("linkclass","linkthumb")).'" target="_blank"'.$title.' rel="colorbox[id_'.$id.']" href="'.$ar["href"].'"><img '.$output.' /></a>';	

	return $output;

}

