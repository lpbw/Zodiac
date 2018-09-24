<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<!-- HTML Markup (Parent) -->
<select id="cat-id">
    <option id="">Select ...</option>
    <!-- other options -->
</select>

<!-- HTML Markup (Child # 1) -->
<select id="subcat-id">
    <option id="">Select ...</option>
    <!-- other options -->
</select>

<!-- HTML Markup (Child # 2) -->
<select id="prod-id">
    <option id="">Select ...</option>
    <!-- other options -->
</select>

<!-- Javascript call on document ready -->
<script>
    // Child # 1
    $("#subcat-id").depdrop({
        url: '/server/getSubcat.php',
        depends: ['cat-id']
    });

    // Child # 2
    $("#prod-id").depdrop({
        url: '/server/getProd.php',
        depends: ['cat-id', 'subcat-id']
    });
</script>

<!-- PHP example: /server/getSubCat.php -->
<?php
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $cat_id = $parents[0];
            $out = self::getSubCatList($cat_id); 
            // the getSubCatList function will query the database based on the
            // cat_id and return an array like below:
            // [
            //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
            //    ['id'=>'<sub-cat-id-2>', 'name'=>'<sub-cat-name2>']
            // ]
            echo json_encode(['output'=>$out, 'selected'=>'']);
            return;
        }
    }
    echo json_encode(['output'=>'', 'selected'=>'']);
?>

<!-- PHP example: /server/getProd.php -->
<?php
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $ids = $_POST['depdrop_parents'];
        $cat_id = empty($ids[0]) ? null : $ids[0];
        $subcat_id = empty($ids[1]) ? null : $ids[1];
        if ($cat_id != null) {
           $data = self::getProdList($cat_id, $subcat_id);
            /**
             * the getProdList function will query the database based on the
             * cat_id and sub_cat_id and return an array like below:
             *  [
             *      'out'=>[
             *          ['id'=>'<prod-id-1>', 'name'=>'<prod-name1>'],
             *          ['id'=>'<prod-id-2>', 'name'=>'<prod-name2>']
             *       ],
             *       'selected'=>'<prod-id-1>'
             *  ]
             */
           
           echo json_encode(['output'=>$data['out'], 'selected'=>$data['selected']]);
           return;
        }
    }
    echo json_encode(['output'=>'', 'selected'=>'']);
?>
</body>
</html>
