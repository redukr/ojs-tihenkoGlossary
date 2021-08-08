<script>
	$(function() {ldelim}
		$('#tihenkoGlossarySettings').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});
</script> 
<form
  class="pkp_form"
  id="tihenkoGlossarySettings"
  method="POST"
  action="{url router=$smarty.const.ROUTE_COMPONENT op="manage" category="generic" plugin=$pluginName verb="settings" save=true}"
>
  <!-- Always add the csrf token to secure your form -->
	{csrf}

  {fbvFormArea}
		{fbvFormSection list=true}
			{fbvElement
        type="text"
        id="secretKey"
        value=$secretKey
        size=$fbvStyles.size.LARGE
        label="plugins.generic.tihenkoGlossary.secretKey"
        inline="true"
      }
      {fbvElement type="checkbox" 
        id="jsDBstatus" 
        name="jsDBstatus" 
        value="true"
        checked=$jsDBstatus|compare:true
        label="plugins.generic.tihenkoGlossary.renewjs"
        inline="true"
       }
       {/fbvFormSection}
      {fbvFormSection list=true}
      
      {fbvElement type="radio" 
        id="dbActionInsert" 
        name="dbAction" 
        value="insert"
        label="plugins.generic.tihenkoGlossary.insert" 
        checked="true"
        inline="true"
       }
      {fbvElement type="radio" 
        id="dbActionUpdate" 
        name="dbAction" 
        value="update"
        label="plugins.generic.tihenkoGlossary.update"
        inline="true"
       }
       {fbvElement type="radio" 
        id="dbActionDelete" 
        name="dbAction" 
        value="delete"
        label="plugins.generic.tihenkoGlossary.delete"} 
        
            {fbvElement 
            type="text" 
            id="newWord" 
            maxlength="120"  
            size=$fbvStyles.size.LARGE
            label="plugins.generic.tihenkoGlossary.newWord"}
            
            {fbvElement 
            type="hidden" 
            id="id"  
            size=$fbvStyles.size.SMALL}
        
      {fbvElement 
            type="textarea" 
            id="newWordMeaning" 
            size=$fbvStyles.size.LARGE 
            label="plugins.generic.tihenkoGlossary.meaning
            rich=true"}       
       
            {fbvElement 
            type="text" 
            id="synonym" 
            maxlength="120"  
            size=$fbvStyles.size.LARGE
            label="plugins.generic.tihenkoGlossary.synonym"}
            {fbvElement 
            type="hidden" 
            id="synonymID"}
            {/fbvFormSection}
  {/fbvFormArea}
  		{fbvFormButtons}
</form>
   <script type="text/javascript" src="{$pluginDB}"/></script>
  <script type="text/javascript" src="{$pluginScript}"/></script>