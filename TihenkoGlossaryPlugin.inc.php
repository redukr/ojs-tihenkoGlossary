<?php
import('lib.pkp.classes.plugins.GenericPlugin');
class TihenkoGlossaryPlugin extends GenericPlugin {
    
    /*
    function __construct() {
		parent::__construct();
                $plugin = PluginRegistry::getPlugin('generic', 'tihenkoglossaryplugin');
                
                $plugin->import('GlossaryDAO');
                DAORegistry::registerDAO('GlossaryDAO', new GlossaryDAO());
                $glossDao = DAORegistry::getDAO('GlossaryDAO');  
                $glossDao->update('CREATE TABLE IF NOT EXISTS  `glossary1` (
                                                `ID` INT NOT NULL AUTO_INCREMENT,
                                                `lang` VARCHAR(5),
                                                `word` VARCHAR(120),
                                                `meaning` VARCHAR(800),
                                                `synonymID` INT,
                                                PRIMARY KEY (`ID`)
                                                ) ENGINE=InnoDB;');
                
	}
*/
    
    
	public function register($category, $path, $mainContextId = NULL) {

		// Register the plugin even when it is not enabled
		$success = parent::register($category, $path);

		if ($success && $this->getEnabled()) {
                //implement db table support    
                $this->import('GlossaryDAO');
                DAORegistry::registerDAO('GlossaryDAO', new GlossaryDAO());
                  
                
		$request = Application::get()->getRequest();
		$templateMgr = TemplateManager::getManager($request);
                $templateMgr->addStyleSheet('TihenkoGlossaryPluginStyles', $request->getBaseUrl() . '/' . $this->getPluginPath() . '/css/tihenkoGlossaryPlugin.css?h=1'); 
                $templateMgr->addStyleSheet('jQueryUICss', $request->getBaseUrl() . '/' . $this->getPluginPath() . '/css/jquery-ui.min.css?v=4');
                
                $templateMgr->addJavaScript('jQuery',$request->getBaseUrl() . '/' . $this->getPluginPath() . '/js/jquery-3.4.1.min.js');
                $templateMgr->addJavaScript('jQueryUI',$request->getBaseUrl() . '/' . $this->getPluginPath() . '/js/jquery-ui.min.js');
                $templateMgr->addJavaScript('FindAndReplaceDomText',  $request->getBaseUrl() . '/' . $this->getPluginPath() . '/js/findandreplacedomtext.js');
                
                //Get settings
                $context = $request->getContext();
                if (!$context) {
		$secretKey = 'test';
		}
                else {
                $secretKey = $this->getSetting($request->getContext()->getId(), 'secretKey');    
                }
                $templateMgr->addJavaScript('TihenkoGlossaryDB', $request->getBaseUrl() . '/' . $this->getPluginPath() . '/js/tihenkoGlossaryPluginDB_'. AppLocale::getLocale() .'.js?code='.str_replace(array(" ",':','-'), "",$secretKey)); 

                // Register hooks 
	        HookRegistry::register('LoadHandler', array($this, 'setGlossaryHandler'));
		HookRegistry::register('TemplateManager::display', array($this, 'registerScript'));
                
                             /*
                $userGroupDao = DAORegistry::getDAO('UserGroupDAO'); 
                $result = $userGroupDao->update('CREATE TABLE IF NOT EXISTS  `glossary` (
                                                `ID` INT NOT NULL AUTO_INCREMENT,
                                                `lang` VARCHAR(3),
                                                `word` VARCHAR(120),
                                                `meaning` VARCHAR(800),
                                                `synonymID` INT,
                                                PRIMARY KEY (`ID`)
                                                ) ENGINE=InnoDB;');
		//$userResult = $userGroupDao->retrieve('SELECT user_group_id FROM user_groups');
                $userGroupDao = DAORegistry::getDAO('UserGroupDAO');
                $userResult = $userGroupDao->retrieve('SELECT announcement_id FROM glossary WHERE 1');
                while (!$userResult->EOF) {
			$row = $userResult->GetRowAssoc(false);
			$templateMgr->addJavaScript('TihenkoGlossaryScript'.$row['word'], $request->getBaseUrl() . '/' . $this->getPluginPath() . '/js/tihenko'.$row['word'].'.js');    
                
			$userResult->MoveNext();
		}
                $templateMgr->addJavaScript('locale1', $request->getBaseUrl() . '/' . $this->getPluginPath() . '/js/tihenko'.AppLocale::getLocale().'.js');   
                */
                
		}

		return $success;
	}
	
		public function setGlossaryHandler($hookName, $params) {
		$page = $params[0];
		if ($page === 'glossary') {
			$this->import('TihenkoGlossaryPluginHandler');
			define('HANDLER_CLASS', 'TihenkoGlossaryPluginHandler');
			return true;
		}
                else if ($page === 'word') {
			$this->import('TihenkoGlossaryPluginWordHandler');
			define('HANDLER_CLASS', 'TihenkoGlossaryPluginWordHandler');
			return true;
		}
                else if ($page === 'alphabeticalindex') {
			$this->import('TihenkoGlossaryPluginAlphabeticalIndex');
			define('HANDLER_CLASS', 'TihenkoGlossaryPluginAlphabeticalIndex');
			return true;
		}
		return false;
	}

	/**
	 * Provide a name for this plugin
	 *
	 * The name will appear in the Plugin Gallery where editors can
	 * install, enable and disable plugins.
	 */
	public function getDisplayName() {
		//return 'Tihenko Glossary Plugin';
		return __('plugins.generic.tihenkoGlossary.displayName');
	}

	/**
	 * Provide a description for this plugin
	 *
	 * The description will appear in the Plugin Gallery where editors can
	 * install, enable and disable plugins.
	 */
	public function getDescription() {
		//return 'Tihenko Glossary Plugin';
		return __('plugins.generic.tihenkoGlossary.description');
	}
	
      /** depricated, currently produces PHP Fatal error:  Cannot override final method Plugin::getInstallSchemaFile() in 
        function getInstallSchemaFile() {
		return $this->getPluginPath() . '/' . 'schema.xml';
	}
	*/
	 /**
     * This function only work from OJS 3.3.0-6
     */
    function getInstallMigration() {
        $this->import('classes.TihenkoSchemaMigration');
        return new TihenkoSchemaMigration();
    }

        
	//Registers scripts
		function registerScript($hookName, $params) {
		$request = Application::get()->getRequest();
		
                //$context = $request->getContext();
		//if (!$context) return false;
                   

        $templateMgr = TemplateManager::getManager($request);
		$templateMgr->addJavaScript(  
			'TihenkoGlossaryPlugin',
                        $request->getBaseUrl() . '/' . $this->getPluginPath() . '/js/tihenkoGlossaryPlugin.js?tes=7',
			//$glossaryCode,
			array(
				'priority' => STYLE_SEQUENCE_LAST,
				'inline'   => false,
			)
		);
		
		
		
			
		
		return false;
	}
        
        
        
        
        public function getActions($request, $actionArgs) {

    // Get the existing actions
		$actions = parent::getActions($request, $actionArgs);
		if (!$this->getEnabled()) {
			return $actions;
		}

    // Create a LinkAction that will call the plugin's
    // `manage` method with the `settings` verb.
		$router = $request->getRouter();
		import('lib.pkp.classes.linkAction.request.AjaxModal');
		$linkAction = new LinkAction(
			'settings',
			new AjaxModal(
				$router->url(
					$request,
					null,
					null,
					'manage',
					null,
					array(
						'verb' => 'settings',
						'plugin' => $this->getName(),
						'category' => 'generic'
					)
				),
				$this->getDisplayName()
			),
			__('manager.plugins.settings'),
			null
		);
		array_unshift($actions, $linkAction);

		return $actions;
	}
	
	public function manage($args, $request) {
		switch ($request->getUserVar('verb')) {
      case 'settings':
        // Load the custom form
        $this->import('TihenkoGlossarySettingsForm');
        $form = new TihenkoGlossarySettingsForm($this);
        // Fetch the form the first time it loads, before
        // the user has tried to save it
        if (!$request->getUserVar('save')) {
            $form->initData();
            return new JSONMessage(true, $form->fetch($request));
        }
        // Validate and execute the form
        $form->readInputData();
        if ($form->validate()) {
          $form->execute();
          return new JSONMessage(true);
        }
        
		}
		return parent::manage($args, $request);
	}
}