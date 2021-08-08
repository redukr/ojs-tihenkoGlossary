var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

function getKeyByValue(object, value) {
  return Object.keys(object).find(key => object[key][0] === value);
}

$( function() {
function run_glossary() {    
    //light article and glossary
        if ( $('.main_entry').length) {
        var replace_class = '.main_entry';
        var href_link = '../../glossary?word=';
        var popup_link = '../../word?word=';
    }
    else if ( $('.glossaryOutput').length) {
        var replace_class = '.glossaryOutput';
        var href_link = 'glossary?word='; 
        var popup_link = 'word?word=';
    }
    
 if ( $('.main_entry').length ||  $('.glossaryOutput').length)  {   
                function markWords(){ 
                    for( var key in glos ) {
            findAndReplaceDOMText($(replace_class)[0], {
                        find: RegExp(' '+key, 'i'),
                        replace: function(portion, match) {
                        called = true;
                        var el = document.createElement('a');
                        el.setAttribute('title', glos[key][1]); 
                        el.setAttribute('class', 'glossary'); 
                        el.setAttribute('href', href_link+glos[key][1]); 
                        //el.setAttribute('target', '_blank');
                        el.innerHTML = portion.text;                     
                        return el;
                        }});
                        }}
                    
                    $.when( markWords() ).then(
                            $( ".glossary" ).each(function( ) {
                                var id = $(this)
  $.ajax({
        url: popup_link+$(this).attr('title')+'&type=short',
        cache: false,  
        dataType: 'text', 
        type: 'GET',
        success: function (result) {
            id.attr('title',  result );
        }
    }) 
})
        );
    $( document ).tooltip({
      position: {
        my: 'center bottom-20',
        at: 'center top',
        using: function( position, feedback ) {
          $( this ).css( position );
          $( '<div>' ).addClass( 'arrow' ).addClass( feedback.vertical ).addClass( feedback.horizontal ).appendTo( this );
        }
      }
    });
  } 
  }
  run_glossary();
  
  if ( $('#glossaryOutput').length ) {
     $( "input[name='Word']" ).autocomplete({
        minLength: 2,
        source: function (request, response) {
			response($.map(glos, function (value, key) {
				
				//var name = key.toUpperCase();
				if (key.toUpperCase().indexOf(request.term.toUpperCase()) != -1) {				
					return {
						label: key, 
						translit: value[1],
                                                id: value[0], 
                                                synonymid: value[2] 
					}
				} else {
					return null;
				}
			}));			
		},
		select: function(event, ui) {
            event.preventDefault();
                          $("#wordGlos" ).html(ui.item.label);
                          $( "input[name='Word']" ).val(ui.item.label);
                          $.ajax({
                            url: 'word?word='+ui.item.translit,
                            cache: false,  
                            dataType: 'text', 
                            type: 'GET',
                            success: function (result) {
                                $("#meaningGlos" ). html(result);
                                run_glossary();
                                 location.hash = 'search='+ui.item.translit;
                            }
                        }); 
		} 
    });  
      
    }
  if ( $('#tihenkoGlossarySettings').length ) {
      
    $( "input[name='synonym']" ).css("background-color","#ECFFEC");
    $( "input[name='newWord']" ).css("background-color","#ECFFEC");
    $("[name='newWordMeaning']" ).css("background-color","#ECFFEC"); 
        
    $( "input[name='newWord']" ).autocomplete({
        minLength: 2,
        source: function (request, response) {
			response($.map(glos, function (value, key) {
				
				//var name = key.toUpperCase();
				if (key.toUpperCase().indexOf(request.term.toUpperCase()) != -1) {				
					return {
						label: key, 
						translit: value[1],
                                                id: value[0], 
                                                synonymid: value[2]
					}
				} else {
					return null;
				}
			}));			
		},
		select: function(event, ui) {
            event.preventDefault();
                        $( "input[name='synonym']" ).val(getKeyByValue(glos, ui.item.synonymid)).css("background-color","#FFFDC0");
                        $( "#synonymID" ).val(ui.item.synonymid);
                        $( "input[name='newWord']" ).val(ui.item.label).css("background-color","#FFFDC0");;
                        $( "input[name='id']" ).val(ui.item.id);
                        $('#dbActionUpdate').attr('checked', true);
                        $('#dbActionInsert').attr('checked', false);
                        $('#dbActionDelete').attr('checked', false);
                          $.ajax({
                            url: '../../word?word='+ui.item.translit+'&noS=1',
                            cache: false,  
                            dataType: 'text', 
                            type: 'GET',
                            success: function (result) {
                                $("[name='newWordMeaning']" ). val(result).css("background-color","#FFFDC0");;
                            }
                        }); 
		} 
    }); 
    
    $( "input[name='synonym']" ).autocomplete({
        minLength: 2,
        source: function (request, response) {
			response($.map(glos, function (value, key) {
				
				//var name = key.toUpperCase();
				if (key.toUpperCase().indexOf(request.term.toUpperCase()) != -1) {				
					return {
						label: key, 
						translit: value[1],
                                                id: value[0] 
					}
				} else {
					return null;
				}
			}));			
		},
		select: function(event, ui) {
            event.preventDefault();
                        $( "input[name='synonym']" ).val(ui.item.label);
                        $( "#synonymID" ).val(ui.item.id);
		} 
    }); 
    
    $( "#tihenkoGlossarySettings" ).on( "click", "#dbActionInsert", function() {
        $( "input[name='synonym']" ).val('').css("background-color","#ECFFEC");
        $( "#synonymID" ).val('');
        $( "input[name='newWord']" ).val('').css("background-color","#ECFFEC");
        $( "input[name='id']" ).val('');
        $("[name='newWordMeaning']" ).val('').css("background-color","#ECFFEC");
        $('#dbActionUpdate').attr('checked', false);  
        $('#dbActionDelete').attr('checked', false);
});
 $( "#tihenkoGlossarySettings" ).on( "click", "#dbActionDelete", function() {
        $( "input[name='synonym']" ).css("background-color","#FFCEC0");
        $( "input[name='newWord']" ).css("background-color","#FFCEC0");
        $("[name='newWordMeaning']" ).css("background-color","#FFCEC0");
        $('#dbActionUpdate').attr('checked', false);  
        $('#dbActionInsert').attr('checked', false);
});

    }

});