<?php

if (!session_id()) session_start();

$link = htmlspecialchars('https://cbproads.com/xmlfeed/wp/main/tracksf.asp'
    . '?memnumber='.$_GET['memnumber']
    . '&mem='.$_GET['mem']
    . '&tar='.$_GET['tar']
    . (isset($_SESSION['cs_tid'])
        ? '&tid='.$_SESSION['cs_tid']
        : (isset($_COOKIE['cs_tid'])
            ? '&tid='.$_COOKIE['cs_tid']
            : ''))
    . '&niche='.$_GET['niche']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="refresh" content="0; url=<?php echo $link ?>">
</head>
<body></body>
</html>
