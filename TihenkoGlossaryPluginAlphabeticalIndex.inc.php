<?php

import('classes.handler.Handler');

class TihenkoGlossaryPluginAlphabeticalIndex extends Handler {

    public function index($args, $request) {
        $wordsOnPage = 20; //change this to manafe number of words shown on a page
        $letter = $_GET['letter'];
        $order = intval($_GET['order']);
        $alphabet = '';
        $alphabet2 = '';
        $content = '';
        $next = '';
        $plugin = PluginRegistry::getPlugin('generic', 'tihenkoglossaryplugin');
        $templateMgr = TemplateManager::getManager($request);
        $glossDao = DAORegistry::getDAO('GlossaryDAO');

        //draw list of letters 
        $glossResult = $glossDao->retrieve('SELECT DISTINCT LEFT(UCASE(word),1) as letter 
                                                FROM glossary
                                                WHERE  lang="' . AppLocale::getLocale() . '"
                                                ORDER BY letter');

        foreach ($glossResult as $row) {
            $alphabet .= "<a href='alphabeticalindex?letter=" . $row->letter . "&order=0'>";
            if ($row->letter == mb_substr($letter, 0, 1)) {
                $alphabet .= '<span class="wordalfabet">' . $row->letter . '</span>';
            }
            else
                $alphabet .= $row->letter;
            $alphabet .= "</a> - ";
        }

        //Get content word + meaning by letter
        if (isset($letter)) {
            $glossResult = $glossDao->retrieve('SELECT a.word, a.meaning, b.meaning as synonym, a.wordtrans
                                            FROM glossary as a LEFT JOIN glossary as b 
                                            ON a.synonymID = b.ID  
                                            WHERE a.word LIKE "' . $letter . '%" 
                                                  AND a.lang="' . AppLocale::getLocale() . '"
                                                      LIMIT ' . $order . ', ' . $wordsOnPage);
            $countLines = 0;
            foreach ($glossResult as $row) {
                $countLines++;
                $content .= "<div class='wordalfabet'>" . $row->word . "</div><div class='alphamean'>" . mb_substr($row->meaning . " " . $row->synonym, 0, 1000);
                if (mb_strlen(mb_substr($row->meaning . " " . $row->synonym, 0, 1000)) == 1000) {
                    $content .= '... <a style="color: #ff9d00; text-decoration: none; cursor: pointer;" href="glossary?word=' . $row->wordtrans . '">'. __('plugins.generic.tihenkoGlossary.readNext') .'</a>';
                }
                $content .= '</div><br>';
            }
            //Draw second line of letter navigation if letter was selected
            $glossResult = $glossDao->retrieve('SELECT DISTINCT LEFT(UCASE(word),2) as letter 
                                                FROM glossary
                                                WHERE  lang="' . AppLocale::getLocale() . '" 
                                                       AND word LIKE "' . mb_substr($letter, 0, 1) . '%"
                                                ORDER BY letter');

            foreach ($glossResult as $row) {
                $alphabet2 .= "<a href='alphabeticalindex?letter=" . $row->letter . "&order=0'>";
                if ($row->letter == $letter) {
                    $alphabet2 .= '<span class="wordalfabet">' . $row->letter . '</span>';
                }
                else
                    $alphabet2 .= $row->letter;
                $alphabet2 .= "</a> - ";
            }
            $alphabet2 = substr($alphabet2, 0, -3) . '<hr>';

            //show back button, if second or more bunch of words
            if ($order >= $wordsOnPage) {
                $next .= "<a class='glosb' href='alphabeticalindex?letter=" . $letter . "&order=" . ($order - 20) . "'>" . __('plugins.generic.tihenkoGlossary.back') . "</a>   ";
            }
            //show next button
            if ($countLines == $wordsOnPage) {
                $next .= "<a class='glosn' href='alphabeticalindex?letter=" . $letter . "&order=" . ($order + 20) . "'>" . __('plugins.generic.tihenkoGlossary.next') . "</a>";
            }
        }

        //show default help content (change in locale section) 
        if (!isset($letter)) {
            $content = __('plugins.generic.tihenkoGlossary.help');
        }

        $templateMgr->assign(array(
            'alphabet'  => substr($alphabet, 0, -3),
            'alphabet2' => $alphabet2,
            'content'   => $content,
            'next'      => $next,
        ));

        return $templateMgr->display($plugin->getTemplateResource('alphabeticalindex.tpl'));
    }

}
