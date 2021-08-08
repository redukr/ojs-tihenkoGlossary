<?php
import('classes.handler.Handler');
class TihenkoGlossaryPluginWordHandler extends Handler {
	public function index($args, $request) {
		$plugin = PluginRegistry::getPlugin('generic', 'tihenkoglossaryplugin');
    $templateMgr = TemplateManager::getManager($request);
            $glossDao  = DAORegistry::getDAO('GlossaryDAO'); 
            $glossResult = $glossDao->retrieve('SELECT a.meaning, b.meaning as synonym
                                            FROM glossary as a LEFT JOIN glossary as b 
                                            ON a.synonymID = b.ID  
                                            WHERE a.wordtrans="'.$_GET['word'].'" AND a.lang="' . AppLocale::getLocale() . '"'); 

            foreach ($glossResult as $row) 
		{  
        
            //add synonim meaning if exists
            if (isset($row->synonym) and $_GET['noS']!=1) {
                $row->meaning .=': '.$row->synonym;     
            } 

            //$row['meaning'] = str_replace(array('"'), array("\'"), $row['meaning']);
            //$row['meaning'] = preg_replace('/\s+/', ' ', trim($row['meaning']));
            if (isset($_GET['type'])) {
            if ($_GET['type'] =='short') {
              $row->meaning = mb_substr(strip_tags($row->meaning),0,500)."... Для перегляду повного значення - натисніть на термін";
            }
            }
            $templateMgr->assign(array(
			'meaning' => ucfirst($row->meaning),
		));
            
    return $templateMgr->display($plugin->getTemplateResource('word.tpl'));
                }
  }
  
}