<?php

import('lib.pkp.classes.db.DAO');

class GlossaryDAO extends DAO {

    /** @var $_result ADORecordSet */
    var $_result;

    /** @var $_loadId string */
    var $_loadId;

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();

        $this->_result = false;
        $this->_loadId = null;
    }

    function insert($word, $wordTranslit, $meaning, $synonymID = null) {
        $this->update('INSERT INTO glossary
				(lang,word,wordtrans,meaning,synonymid,datetimeupdate)
				VALUES
				(?, ?, ?, ?, NULLIF(?,""), NOW())',
                array(AppLocale::getLocale(),
                    $word,
                    $wordTranslit,
                    $meaning,
                    $synonymID
                )
        );

        return true;
    }

    function updateWord($id, $word, $wordTranslit, $meaning, $synonymID = null) {
        if ($synonymID=='' or $synonymID==0) {$synonymID = null;}
        $this->update('UPDATE glossary SET word = ?,
                                               wordtrans = ?,
                                               meaning = ?,
                                               datetimeupdate = NOW(),
                                               synonymid = NULLIF(?,"")
                                               WHERE lang = ? 
                                                     AND id = ?',
                array($word,
                    $wordTranslit,
                    $meaning,
                    $synonymID,
                    AppLocale::getLocale(),
                    $id
                ));
    }

    function delete($id) {
        return $this->update('DELETE from glossary WHERE id = ?',
                        array($id)); // Not number.
    }

    function getSupportedLang() {
        $result = array();
        $glossResult = $this->retrieve('SELECT distinct lang FROM glossary');
        foreach ($glossResult as $row) 
		{  
            $result[] = $row->lang;
        }
        return $result;
    }

}
