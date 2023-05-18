<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="public/css/app.bundle.css">
    <link id="myskin" rel="stylesheet" media="screen, print" href="public/css/skins/skin-master.css">
    <link rel="stylesheet" media="screen, print" href="public/css/fa-solid.css">
    <link rel="stylesheet" media="screen, print" href="public/css/fa-brands.css">
    <link rel="stylesheet" media="screen, print" href="public/css/fa-regular.css">
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="public/css/vendors.bundle.css">
    <title><?=$this->e($title)?></title>
</head>
<body>
    <?=$this->section('content')?>
</body>
</html>