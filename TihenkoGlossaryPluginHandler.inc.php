<?php
import('classes.handler.Handler');
class TihenkoGlossaryPluginHandler extends Handler { 
	public function index($args, $request) {
		$plugin = PluginRegistry::getPlugin('generic', 'tihenkoglossaryplugin');
    $templateMgr = TemplateManager::getManager($request);
        $templateMgr = TemplateManager::getManager($request);
            $glossDao  = DAORegistry::getDAO('GlossaryDAO'); 
            $glossResult = $glossDao->retrieve('SELECT a.word, a.meaning, b.meaning as synonym 
                                            FROM glossary as a LEFT JOIN glossary as b 
                                            ON a.synonymID = b.ID  
                                            WHERE a.wordtrans="'.$_GET['word'].'" AND a.lang="' . AppLocale::getLocale() . '"'); 
            foreach ($glossResult as $row) 
		{  
            //add synonim meaning if exists
            if (isset($row->synonym)) {
                $row->meaning .=': '.$row->synonym;     
            } 

            //$row['meaning'] = str_replace(array("'", '"'), array("\'", "\'"), $row['meaning']);
            //$row['meaning'] = preg_replace('/\s+/', ' ', trim($row['meaning']));
            //$row['word'] = str_replace(array("'", '"', '\s', '\n', '\r'), array("\'", "\'", ' ', ' ', ' '), $row['word']);
    

            
            $templateMgr->assign(array(
			'meaning' => ucfirst($row->meaning),
                        'word' => ucfirst($row->word),
		));
                }
    return $templateMgr->display($plugin->getTemplateResource('glossary.tpl'));
  }
}