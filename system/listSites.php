<?php
include_once '../system/lib/bootstrapHAX.php';
include_once $HAXCMS->configDirectory . '/config.php';
// test if this is a valid user login
  header('Content-Type: application/json');
  header('Status: 200');
  $return = array(
    "id" => "123-123-123-123",
    "title" => "My site list",
    "author" => "me",
    "description" => "All of my micro sites I know and love.",
    "license" => "by-sa",
    "metadata" => array(),
    "items" => array(
      array(
        "id" => "item-new",
        "indent" => 0,
        "location" => "",
        "order" => -10000000000,
        "parent" => null,
        "title" => "Add new site",
        "description" => "Tap to get started!",
        "metadata" => array(
            "siteName" => "",
            "theme" => "simple-blog",
            "image" => "assets\/banner.jpg",
            "color" => "blue",
            "icon" => "icons:add-circle-outline"
        )
      )
    )
  );
  // loop through files directory so we can cache those things too
  if ($handle = opendir(HAXCMS_ROOT . '/' . $HAXCMS->sitesDirectory)) {
    while (false !== ($item = readdir($handle))) {
      if ($item != "." && $item != ".." && is_dir(HAXCMS_ROOT . '/' . $HAXCMS->sitesDirectory . '/' . $item) && file_exists(HAXCMS_ROOT . '/' . $HAXCMS->sitesDirectory . '/' . $item . '/site.json')) {
        $json = file_get_contents(HAXCMS_ROOT . '/' . $HAXCMS->sitesDirectory . '/' . $item . '/site.json');
        $site = json_decode($json);
        unset($site->items);
        $return['items'][] = $site;
      }
    }
    closedir($handle);
  }
  print json_encode($return);
  exit();
?>
