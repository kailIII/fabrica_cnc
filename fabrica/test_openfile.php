<?php

$word = new COM("word.application");
$word->Documents->Open( dirname(__FILE__).'/test.docx');