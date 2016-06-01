<?php
error_reporting(E_ALL);
include_once('../simple_html_dom.php');

$html = file_get_html('google.htm');


$lang = '';
$l=$html->find('html', 0);
if ($l!==null)
    $lang = $l->lang;
if ($lang!='')
    $lang = 'lang="'.$lang.'"';

$charset = $html->find('meta[http-equiv*=content-type]', 0);
$target = array();
$query = '';

if (isset($_REQUEST['query'])) {
    $query = $_REQUEST['query'];
    $target = $html->find($query);
}

function stat_dom($dom) {
    $count_text = 0;
    $count_comm = 0;
    $count_elem = 0;
    $count_tag_end = 0;
    $count_unknown = 0;
    
    foreach($dom->nodes as $n) {
        if ($n->nodetype==HDOM_TYPE_TEXT)
            ++$count_text;
        if ($n->nodetype==HDOM_TYPE_COMMENT)
            ++$count_comm;
        if ($n->nodetype==HDOM_TYPE_ELEMENT)
            ++$count_elem;
        if ($n->nodetype==HDOM_TYPE_ENDTAG)
            ++$count_tag_end;
        if ($n->nodetype==HDOM_TYPE_UNKNOWN)
            ++$count_unknown;
    }
    
    echo 'Total: '. count($dom->nodes).
        ', Text: '.$count_text.
        ', Commnet: '.$count_comm.
        ', Tag: '.$count_elem.
        ', End Tag: '.$count_tag_end.
        ', Unknown: '.$count_unknown;
}

function dump_my_html_tree($node, $show_attr=true, $deep=0, $last=true) {
    $count = count($node->nodes);
    if ($count>0) {
        if($last)
            echo '<li class="expandable lastExpandable"><div class="hitarea expandable-hitarea lastExpandable-hitarea"></div>&lt;<span class="tag">'.htmlspecialchars($node->tag).'</span>';
        else
            echo '<li class="expandable"><div class="hitarea expandable-hitarea"></div>&lt;<span class="tag">'.htmlspecialchars($node->tag).'</span>';
    }
    else {
        $laststr = ($last===false) ? '' : ' class="last"';
        echo '<li'.$laststr.'>&lt;<span class="tag">'.htmlspecialchars($node->tag).'</span>';
    }

    if ($show_attr) {
        foreach($node->attr as $k=>$v) {
            echo ' '.htmlspecialchars($k).'="<span class="attr">'.htmlspecialchars($node->$k).'</span>"';
        }
    }
    echo '&gt;';
    
    if ($node->tag==='text' || $node->tag==='comment') {
        echo htmlspecialchars($node->innertext);
        return;
    }

    if ($count>0) echo "\n<ul style=\"display: none;\">\n";
    $i=0;
    foreach($node->nodes as $c) {
        $last = (++$i==$count) ? true : false;
        dump_my_html_tree($c, $show_attr, $deep+1, $last);
    }
    if ($count>0)
        echo "</ul>\n";

    //if ($count>0) echo '&lt;/<span class="attr">'.htmlspecialchars($node->tag).'</span>&gt;';
    echo "</li>\n";
}
?>
