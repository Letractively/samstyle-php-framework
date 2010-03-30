<?php

$_SESSION['csrfexample'] = html::encode(strip_tags($_POST['nme']));

redirect(url_route('examples-csrf'));