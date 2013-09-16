<?php

session_start();

unset( $_SESSION['filtros'] );
header( 'Location: '.$_SERVER['HTTP_REFERER'] );