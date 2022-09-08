
<?php
 // create Imagick object
 
 echo sha1("123456");
 
 exit;
 
 $imagick = new Imagick();
 // Reads image from PDF
 $imagick->readImage('hello.pdf');
 // Writes an image or image sequence Example- converted-0.jpg, converted-1.jpg
 $imagick->writeImages('converted.jpg', false);
 exit;
?> 

<?php 

$stringresult = pdf2text('Hello.pdf');
$stringresult = trim(preg_replace('/\s\s+/', ' ', $stringresult));
//$stringresult = iconv("UTF-8","UTF-8//IGNORE",$stringresult);
$stringresult = str_replace("\n", '', $stringresult);
$stringresult = converToPlain( $stringresult);

echo $stringresult;exit;






$input = iconv('UTF-8', 'ASCII//TRANSLIT', $stringresult);

echo $result;exit;

$stringresult = preg_replace('/\s+/', '_', $stringresult);
echo $stringresult;

echo containsWord($stringresult,"Claim_No");

function utf8_for_xml($string)
  {
    return preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u',
                        ' ', $string);
  }


function containsWord($str, $word)
{
    return !!preg_match('#\\b' . preg_quote($word, '#') . '\\b#i', $str);
}

function converToPlain($text){
    $text = preg_replace('"{\*?\\\\.+(;})|\\s?\\\[A-Za-z0-9]+|\\s?{\\s?\\\[A-Za-z0-9‹]+\\s?|\\s?}\\s?"', '', $text);
    return $text;
}

function decodeAsciiHex($input) {
    $output = "";

    $isOdd = true;
    $isComment = false;

    for($i = 0, $codeHigh = -1; $i < strlen($input) && $input[$i] != '>'; $i++) {
        $c = $input[$i];

        if($isComment) {
            if ($c == '\r' || $c == '\n')
                $isComment = false;
            continue;
        }

        switch($c) {
            case '\0': case '\t': case '\r': case '\f': case '\n': case ' ': break;
            case '%': 
                $isComment = true;
            break;

            default:
                $code = hexdec($c);
                if($code === 0 && $c != '0')
                    return "";

                if($isOdd)
                    $codeHigh = $code;
                else
                    $output .= chr($codeHigh * 16 + $code);

                $isOdd = !$isOdd;
            break;
        }
    }

    if($input[$i] != '>')
        return "";

    if($isOdd)
        $output .= chr($codeHigh * 16);

    return $output;
}
function decodeAscii85($input) {
    $output = "";

    $isComment = false;
    $ords = array();
    
    for($i = 0, $state = 0; $i < strlen($input) && $input[$i] != '~'; $i++) {
        $c = $input[$i];

        if($isComment) {
            if ($c == '\r' || $c == '\n')
                $isComment = false;
            continue;
        }

        if ($c == '\0' || $c == '\t' || $c == '\r' || $c == '\f' || $c == '\n' || $c == ' ')
            continue;
        if ($c == '%') {
            $isComment = true;
            continue;
        }
        if ($c == 'z' && $state === 0) {
            $output .= str_repeat(chr(0), 4);
            continue;
        }
        if ($c < '!' || $c > 'u')
            return "";

        $code = ord($input[$i]) & 0xff;
        $ords[$state++] = $code - ord('!');

        if ($state == 5) {
            $state = 0;
            for ($sum = 0, $j = 0; $j < 5; $j++)
                $sum = $sum * 85 + $ords[$j];
            for ($j = 3; $j >= 0; $j--)
                $output .= chr($sum >> ($j * 8));
        }
    }
    if ($state === 1)
        return "";
    elseif ($state > 1) {
        for ($i = 0, $sum = 0; $i < $state; $i++)
            $sum += ($ords[$i] + ($i == $state - 1)) * pow(85, 4 - $i);
        for ($i = 0; $i < $state - 1; $i++)
            $ouput .= chr($sum >> ((3 - $i) * 8));
    }

    return $output;
}
function decodeFlate($input) {
    return @gzuncompress($input);
}

function getObjectOptions($object) {
    $options = array();
    if (preg_match("#<<(.*)>>#ismU", $object, $options)) {
        $options = explode("/", $options[1]);
        @array_shift($options);

        $o = array();
        for ($j = 0; $j < @count($options); $j++) {
            $options[$j] = preg_replace("#\s+#", " ", trim($options[$j]));
            if (strpos($options[$j], " ") !== false) {
                $parts = explode(" ", $options[$j]);
                $o[$parts[0]] = $parts[1];
            } else
                $o[$options[$j]] = true;
        }
        $options = $o;
        unset($o);
    }

    return $options;
}
function getDecodedStream($stream, $options) {
    $data = "";
    if (empty($options["Filter"]))
        $data = $stream;
    else {
        $length = !empty($options["Length"]) ? $options["Length"] : strlen($stream);
        $_stream = substr($stream, 0, $length);

        foreach ($options as $key => $value) {
            if ($key == "ASCIIHexDecode")
                $_stream = decodeAsciiHex($_stream);
            if ($key == "ASCII85Decode")
                $_stream = decodeAscii85($_stream);
            if ($key == "FlateDecode")
                $_stream = decodeFlate($_stream);
        }
        $data = $_stream;
    }
    return $data;
}
function getDirtyTexts(&$texts, $textContainers) {
    for ($j = 0; $j < count($textContainers); $j++) {
        if (preg_match_all("#\[(.*)\]\s*TJ#ismU", $textContainers[$j], $parts))
            $texts = array_merge($texts, @$parts[1]);
        elseif(preg_match_all("#Td\s*(\(.*\))\s*Tj#ismU", $textContainers[$j], $parts))
            $texts = array_merge($texts, @$parts[1]);
    }
}
function getCharTransformations(&$transformations, $stream) {
    preg_match_all("#([0-9]+)\s+beginbfchar(.*)endbfchar#ismU", $stream, $chars, PREG_SET_ORDER);
    preg_match_all("#([0-9]+)\s+beginbfrange(.*)endbfrange#ismU", $stream, $ranges, PREG_SET_ORDER);

    for ($j = 0; $j < count($chars); $j++) {
        $count = $chars[$j][1];
        $current = explode("\n", trim($chars[$j][2]));
        for ($k = 0; $k < $count && $k < count($current); $k++) {
            if (preg_match("#<([0-9a-f]{2,4})>\s+<([0-9a-f]{4,512})>#is", trim($current[$k]), $map))
                $transformations[str_pad($map[1], 4, "0")] = $map[2];
        }
    }
    for ($j = 0; $j < count($ranges); $j++) {
        $count = $ranges[$j][1];
        $current = explode("\n", trim($ranges[$j][2]));
        for ($k = 0; $k < $count && $k < count($current); $k++) {
            if (preg_match("#<([0-9a-f]{4})>\s+<([0-9a-f]{4})>\s+<([0-9a-f]{4})>#is", trim($current[$k]), $map)) {
                $from = hexdec($map[1]);
                $to = hexdec($map[2]);
                $_from = hexdec($map[3]);

                for ($m = $from, $n = 0; $m <= $to; $m++, $n++)
                    $transformations[sprintf("%04X", $m)] = sprintf("%04X", $_from + $n);
            } elseif (preg_match("#<([0-9a-f]{4})>\s+<([0-9a-f]{4})>\s+\[(.*)\]#ismU", trim($current[$k]), $map)) {
                $from = hexdec($map[1]);
                $to = hexdec($map[2]);
                $parts = preg_split("#\s+#", trim($map[3]));
                
                for ($m = $from, $n = 0; $m <= $to && $n < count($parts); $m++, $n++)
                    $transformations[sprintf("%04X", $m)] = sprintf("%04X", hexdec($parts[$n]));
            }
        }
    }
}
function getTextUsingTransformations($texts, $transformations) {
    $document = "";
    for ($i = 0; $i < count($texts); $i++) {
        $isHex = false;
        $isPlain = false;

        $hex = "";
        $plain = "";
        for ($j = 0; $j < strlen($texts[$i]); $j++) {
            $c = $texts[$i][$j];
            switch($c) {
                case "<":
                    $hex = "";
                    $isHex = true;
                break;
                case ">":
                    $hexs = str_split($hex, 4);
                    for ($k = 0; $k < count($hexs); $k++) {
                        $chex = str_pad($hexs[$k], 4, "0");
                        if (isset($transformations[$chex]))
                            $chex = $transformations[$chex];
                        $document .= html_entity_decode("&#x".$chex.";");
                    }
                    $isHex = false;
                break;
                case "(":
                    $plain = "";
                    $isPlain = true;
                break;
                case ")":
                    $document .= $plain;
                    $isPlain = false;
                break;
                case "\\":
                    $c2 = $texts[$i][$j + 1];
                    if (in_array($c2, array("\\", "(", ")"))) $plain .= $c2;
                    elseif ($c2 == "n") $plain .= '\n';
                    elseif ($c2 == "r") $plain .= '\r';
                    elseif ($c2 == "t") $plain .= '\t';
                    elseif ($c2 == "b") $plain .= '\b';
                    elseif ($c2 == "f") $plain .= '\f';
                    elseif ($c2 >= '0' && $c2 <= '9') {
                        $oct = preg_replace("#[^0-9]#", "", substr($texts[$i], $j + 1, 3));
                        $j += strlen($oct) - 1;
                        $plain .= html_entity_decode("&#".octdec($oct).";");
                    }
                    $j++;
                break;

                default:
                    if ($isHex)
                        $hex .= $c;
                    if ($isPlain)
                        $plain .= $c;
                break;
            }
        }
        $document .= "\n";
    }

    return $document;
}

function pdf2text($filename) {
    $infile = @file_get_contents($filename, FILE_BINARY);
    if (empty($infile))
        return "";

    $transformations = array();
    $texts = array();

    preg_match_all("#obj(.*)endobj#ismU", $infile, $objects);
    $objects = @$objects[1];

    for ($i = 0; $i < count($objects); $i++) {
        $currentObject = $objects[$i];

        if (preg_match("#stream(.*)endstream#ismU", $currentObject, $stream)) {
            $stream = ltrim($stream[1]);

            $options = getObjectOptions($currentObject);
            if (!(empty($options["Length1"]) && empty($options["Type"]) && empty($options["Subtype"])))
                continue;

            $data = getDecodedStream($stream, $options); 
            if (strlen($data)) {
                if (preg_match_all("#BT(.*)ET#ismU", $data, $textContainers)) {
                    $textContainers = @$textContainers[1];
                    getDirtyTexts($texts, $textContainers);
                } else
                    getCharTransformations($transformations, $data);
            }
        }
    }

    return getTextUsingTransformations($texts, $transformations);
}



//echo sha1("123456");

//$folderhandle = scandir("img/",1);
											
											
											//foreach ($folderhandle as $value) {
												
												//echo $value."<br>";
												//$resize=resize_imagepng("img/".$value,40,40);
												//$wmsource="";
												//$success = image_handler("img/".$value,"img/2".$value,20,20,100);
												//rename("img/".$value,"img/2".$value); 
												//$ctp=copyTransparent("img/".$value,"img/2".$value);
												
												//create_thumb("img/".$value, $box=200);
											//}


function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
	//$newwidth=40;
	//$newheight=40;
    $src = imagecreatefrompng($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	
	

    return $dst;
}



function resize_imagepng($file, $w, $h) {
   list($width, $height) = getimagesize($file);
   $src = imagecreatefrompng($file);
   $dst = imagecreatetruecolor($w, $h);
   imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
   return $dst;
}

function image_handler($source_image,$destination,$tn_w = 100,$tn_h = 100,$quality = 80,$wmsource = false) {
  // The getimagesize functions provides an "imagetype" string contstant, which can be passed to the image_type_to_mime_type function for the corresponding mime type
  $info = getimagesize($source_image);
  $imgtype = image_type_to_mime_type($info[2]);
  // Then the mime type can be used to call the correct function to generate an image resource from the provided image
  switch ($imgtype) {
  case 'image/jpeg':
    $source = imagecreatefromjpeg($source_image);
    break;
  case 'image/gif':
    $source = imagecreatefromgif($source_image);
    break;
  case 'image/png':
    $source = imagecreatefrompng($source_image);
    break;
  default:
    die('Invalid image type.');
  }
  // Now, we can determine the dimensions of the provided image, and calculate the width/height ratio
  $src_w = imagesx($source);
  $src_h = imagesy($source);
  $src_ratio = $src_w/$src_h;
  // Now we can use the power of math to determine whether the image needs to be cropped to fit the new dimensions, and if so then whether it should be cropped vertically or horizontally. We're just going to crop from the center to keep this simple.
  if ($tn_w/$tn_h > $src_ratio) {
  $new_h = $tn_w/$src_ratio;
  $new_w = $tn_w;
  } else {
  $new_w = $tn_h*$src_ratio;
  $new_h = $tn_h;
  }
  $x_mid = $new_w/2;
  $y_mid = $new_h/2;
  // Now actually apply the crop and resize!
  $newpic = imagecreatetruecolor(round($new_w), round($new_h));
  imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
  $final = imagecreatetruecolor($tn_w, $tn_h);
  imagecopyresampled($final, $newpic, 0, 0, ($x_mid-($tn_w/2)), ($y_mid-($tn_h/2)), $tn_w, $tn_h, $tn_w, $tn_h);
  // If a watermark source file is specified, get the information about the watermark as well. This is the same thing we did above for the source image.
  if($wmsource) {
  $info = getimagesize($wmsource);
  $imgtype = image_type_to_mime_type($info[2]);
  switch ($imgtype) {
    case 'image/jpeg':
      $watermark = imagecreatefromjpeg($wmsource);
      break;
    case 'image/gif':
      $watermark = imagecreatefromgif($wmsource);
      break;
    case 'image/png':
      $watermark = imagecreatefrompng($wmsource);
      break;
    default:
      die('Invalid watermark type.');
  }
  // Determine the size of the watermark, because we're going to specify the placement from the top left corner of the watermark image, so the width and height of the watermark matter.
  $wm_w = imagesx($watermark);
  $wm_h = imagesy($watermark);
  // Now, figure out the values to place the watermark in the bottom right hand corner. You could set one or both of the variables to "0" to watermark the opposite corners, or do your own math to put it somewhere else.
  $wm_x = $tn_w - $wm_w;
  $wm_y = $tn_h - $wm_h;
  // Copy the watermark onto the original image
  // The last 4 arguments just mean to copy the entire watermark
  

  imagecopy($final, $wm_x, $wm_y, 0, 0, $tn_w, $tn_h);
  }
  // Ok, save the output as a jpeg, to the specified destination path at the desired quality.
  // You could use imagepng or imagegif here if you wanted to output those file types instead.
  if(imagepng ($final,$destination,9)) {
  return true;
  }
  // If something went wrong
  return false;
}

function create_thumb($image1_path, $box=200){
    // get image size and type
    list($width1, $height1, $image1_type) = getimagesize($image1_path);
 
    // prepare thumb name in the same directory with prefix 'tn'
    $image2_path = dirname($image1_path) . '/tn_' .basename($image1_path);
     
    // make image smaller if doesn't fit to the box 
    if ($width1 > $box || $height1 > $box){
        // set the largest dimension
        $width2 = $height2 = $box;
        // calculate smaller thumb dimension (proportional)
        if ($width1 < $height1) $width2  = round(($box / $height1) * $width1);
        else                    $height2 = round(($box / $width1) * $height1);
         
        // set image type, blending and set functions for gif, jpeg and png
		
        switch($image1_type){
            case IMAGETYPE_PNG:  $img = 'png';  $blending = false; break;
            case IMAGETYPE_GIF:  $img = 'gif';  $blending = true;  break;
            case IMAGETYPE_JPEG: $img = 'jpeg'; break;
        }
		$width2=20;
		$height2=20;
        $imagecreate = "imagecreatefrom$img";
        $imagesave   = "image$img";
     
        // initialize image from the file
        $image1 = $imagecreate($image1_path);
 
        // create a new true color image with dimensions $width2 and $height2
        $image2 = imagecreatetruecolor($width2, $height2);
 
        // preserve transparency for PNG and GIF images
        if ($img == 'png' || $img == 'gif'){
          // allocate a color for thumbnail
            $background = imagecolorallocate($image2, 0, 0, 0);
            // define a color as transparent 
            imagecolortransparent($image2, $background);
            // set the blending mode for thumbnail
            imagealphablending($image2, $blending);
            // set the flag to save alpha channel  
            imagesavealpha($image2, true); 
        }
     
        // save thumbnail image to the file
        imagecopyresampled($image2, $image1, 0, 0, 0, 0, $width2, $height2, $width1, $height1);
        $imagesave($image2, $image2_path);
    }
    // else just copy the image
    else copy($image1_path, $image2_path);
}

?>