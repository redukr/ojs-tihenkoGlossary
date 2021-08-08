{include file="frontend/components/header.tpl" pageTitle="plugins.generic.tihenkoGlossary.displayName"}
<div id="glossaryOutput">
            {fbvElement
            inline="true"
            type="text" 
            id="Word" 
            maxlength="120"  
            size=$fbvStyles.size.LARGE
            placeholder="plugins.generic.tihenkoGlossary.FindWord"
            }
    <hr>       
    <div id="wordGlos">{$word}</div>
    <div class="glossaryOutput" id="meaningGlos">{$meaning}</div>
</div>
{include file="frontend/components/footer.tpl" pageTitle="plugins.generic.tihenkoGlossary.displayName"}