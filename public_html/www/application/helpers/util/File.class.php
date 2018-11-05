<?php
/**
 * 파일 유틸리티 클래스
 * @file    File.class.php
 * @author  Yongmin Ma (milgam12@inplusweb.com)
 * @package util
 */
namespace sFramework;

class File
{
    /**
     * 디렉토리 생성 후 퍼미션 추가
     * @param string $dir_path
     */
    public static function makeDirectory($dir_path)
    {
        $tmp_path = str_replace(ROOT_PATH, '', $dir_path);
        $dir_path = ROOT_PATH;

        $dir_arr = explode('/', $tmp_path);
        for ($i = 1; $i < count($dir_arr); $i++) {
            $dir_name = $dir_arr[$i];
            if ($dir_arr) {
                $dir_path .= '/' . $dir_name;
                if (!is_dir($dir_path)) {
                    mkdir($dir_path, 0707);
                    chmod($dir_path, 0707);
                }
            }
        }
    }

    /**
     * 디렉토리와 하위 파일 삭제
     * @param string $dir_path
     */
    public static function deleteDirectory($dir_path)
    {
        if (is_dir($dir_path)) {
            $handle = opendir($dir_path);
            while (($file = readdir($handle)) !== false) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                $del_path = $dir_path . '/' . $file;
                if (is_dir($del_path)) {
                    self::deleteDirectory($del_path);
                } else {
                    unlink($del_path);
                }
            }
            closedir($handle);
            rmdir($dir_path);
        }
    }

    /**
     * 썸네일 이미지 생성
     * @param string $source_file
     * @param string $thumb_file
     * @param float $thumb_width
     * @param float $thumb_height
     * @param bool $is_create
     * @param bool $is_crop
     * @param string $crop_mode
     * @param bool $is_sharpen
     * @param string $um_value
     * @return string
     */
    public static function makeThumbnail(
        $source_file,
        $thumb_file,
        $thumb_width,
        $thumb_height,
        $is_create,
        $is_crop = false,
        $crop_mode = 'center',
        $is_sharpen = true,
        $um_value = '80/0.5/3'
    ) {
        if (!$thumb_width && !$thumb_height) {
            return null;
        }

        // 원본 파일이 없다면
        if (!is_file($source_file)) {
            return null;
        }

        // gif, jpg, png 에 대해서만 적용
        $size = @getimagesize($source_file);
        if ($size[2] < 1 || $size[2] > 3) {
            return null;
        }

        // Animated GIF는 썸네일 생성하지 않음
        if ($size[2] == 1) {
            if (self::isAnimatedGif($source_file)) {
                return null;
            }
        }

        $thumb_time = @filemtime($thumb_file);
        $source_time = @filemtime($source_file);

        // 이미 존재하기 때문에 바로 리턴
        if (file_exists($thumb_file)) {
            if ($is_create == false && $source_time < $thumb_time) {
                return basename($thumb_file);
            }
        }

        // 원본파일의 GD 이미지 생성
        $src = null;
        if ($size[2] == 1) {
            $src = imagecreatefromgif($source_file);
        } elseif ($size[2] == 2) {
            $src = imagecreatefromjpeg($source_file);
        } elseif ($size[2] == 3) {
            $src = imagecreatefrompng($source_file);
        } else {
            return null;
        }

        if (!$src) {
            return null;
        }

        $is_large = true;
        // width, height 설정
        if ($thumb_width) {
            if (!$thumb_height) {
                $thumb_height = round(($thumb_width * $size[1]) / $size[0]);
            } elseif ($size[0] < $thumb_width || $size[1] < $thumb_height) {
                $is_large = false;
            }
        } elseif ($thumb_height) {
            $thumb_width = round(($thumb_height * $size[0]) / $size[1]);
        }

        // 원본보다 작을 경우
        if ($thumb_width > $size[0] || $thumb_height > $size[1]) {
            $thumb_width = $size[0];
            $thumb_height = $size[1];
        }

        $dst_x = 0;
        $dst_y = 0;
        $src_x = 0;
        $src_y = 0;
        $dst_w = $thumb_width;
        $dst_h = $thumb_height;
        $src_w = $size[0];
        $src_h = $size[1];

        $ratio = $dst_h / $dst_w;

        if ($is_large) {
            // 크롭처리
            if ($is_crop) {
                switch ($crop_mode) {
                    case 'center':
                        if ($size[1] / $size[0] >= $ratio) {
                            $src_h = round($src_w * $ratio);
                            $src_y = round(($size[1] - $src_h) / 2);
                        } else {
                            $src_w = round($size[1] / $ratio);
                            $src_x = round(($size[0] - $src_w) / 2);
                        }
                        break;
                    default:
                        if ($size[1] / $size[0] >= $ratio) {
                            $src_h = round($src_w * $ratio);
                        } else {
                            $src_w = round($size[1] / $ratio);
                        }
                        break;
                }
            } else {
                if ($size[1] / $size[0] >= $ratio) {
                    $src_h = round($src_w * $ratio);
                } else {
                    $src_w = round($size[1] / $ratio);
                }
            }

            $dst = imagecreatetruecolor($dst_w, $dst_h);
        } else {
            $dst = imagecreatetruecolor($dst_w, $dst_h);

            if ($src_w < $dst_w) {
                if ($src_h >= $dst_h) {
                    $dst_x = round(($dst_w - $src_w) / 2);
                    $src_h = $dst_h;
                } else {
                    $dst_x = round(($dst_w - $src_w) / 2);
                    $dst_y = round(($dst_h - $src_h) / 2);
                    $dst_w = $src_w;
                    $dst_h = $src_h;
                }
            } elseif ($src_h < $dst_h) {
                $dst_y = round(($dst_h - $src_h) / 2);
                $dst_h = $src_h;
                $src_w = $dst_w;
            }

            $bgcolor = imagecolorallocate($dst, 255, 255, 255); // 배경색
            imagefill($dst, 0, 0, $bgcolor);
        }

        imagecopyresampled($dst, $src, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

        // sharpen 적용
        if ($is_sharpen && $is_large) {
            $val = explode('/', $um_value);
            self::unsharpMask($dst, $val[0], $val[1], $val[2]);
        }

        imagejpeg($dst, $thumb_file, 100);
        chmod($thumb_file, 0606); // 추후 삭제를 위하여 파일모드 변경

        imagedestroy($src);
        imagedestroy($dst);

        return basename($thumb_file);
    }

    /**
     * 샤픈 처리
     * @param resource $img
     * @param float $amount
     * @param float $radius
     * @param float $threshold
     */
    public static function unsharpMask($img, $amount, $radius, $threshold)
    {
        /*
        출처 : http://vikjavev.no/computing/ump.php
        New:
        - In version 2.1 (February 26 2007) Tom Bishop has done some important speed enhancements.
        - From version 2 (July 17 2006) the script uses the imageconvolution function in PHP
        version >= 5.1, which improves the performance considerably.


        Unsharp masking is a traditional darkroom technique that has proven very suitable for
        digital imaging. The principle of unsharp masking is to create a blurred copy of the image
        and compare it to the underlying original. The difference in colour values
        between the two images is greatest for the pixels near sharp edges. When this
        difference is subtracted from the original image, the edges will be
        accentuated.

        The Amount parameter simply says how much of the effect you want. 100 is 'normal'.
        Radius is the radius of the blurring circle of the mask. 'Threshold' is the least
        difference in colour values that is allowed between the original and the mask. In practice
        this means that low-contrast areas of the picture are left unrendered whereas edges
        are treated normally. This is good for pictures of e.g. skin or blue skies.

        Any suggenstions for improvement of the algorithm, expecially regarding the speed
        and the roundoff errors in the Gaussian blur process, are welcome.

        */

        ////////////////////////////////////////////////////////////////////////////////////////////////
        ////
        ////                  Unsharp Mask for PHP - version 2.1.1
        ////
        ////    Unsharp mask algorithm by Torstein Hønsi 2003-07.
        ////             thoensi_at_netcom_dot_no.
        ////               Please leave this notice.
        ////
        ///////////////////////////////////////////////////////////////////////////////////////////////



        // $img is an image that is already created within php using
        // imgcreatetruecolor. No url! $img must be a truecolor image.

        // Attempt to calibrate the parameters to Photoshop:
        if ($amount > 500) {
            $amount = 500;
        }
        $amount = $amount * 0.016;
        if ($radius > 50) {
            $radius = 50;
        }
        $radius = $radius * 2;
        if ($threshold > 255) {
            $threshold = 255;
        }

        $radius = abs(round($radius));     // Only integers make sense.
        if ($radius == 0) {
            return;
        }
        $w = imagesx($img);
        $h = imagesy($img);
        $imgCanvas = imagecreatetruecolor($w, $h);
        $imgBlur = imagecreatetruecolor($w, $h);


        // Gaussian blur matrix:
        //
        //    1    2    1
        //    2    4    2
        //    1    2    1
        //
        //////////////////////////////////////////////////

        if (function_exists('imageconvolution')) { // PHP >= 5.1
            $matrix = array(
                array( 1, 2, 1 ),
                array( 2, 4, 2 ),
                array( 1, 2, 1 )
            );
            $divisor = array_sum(array_map('array_sum', $matrix));
            $offset = 0;

            imagecopy($imgBlur, $img, 0, 0, 0, 0, $w, $h);
            imageconvolution($imgBlur, $matrix, $divisor, $offset);
        } else {
            // Move copies of the image around one pixel at the time and merge them with weight
            // according to the matrix. The same matrix is simply repeated for higher radii.
            for ($i = 0; $i < $radius; $i++) {
                imagecopy($imgBlur, $img, 0, 0, 1, 0, $w - 1, $h); // left
                imagecopymerge($imgBlur, $img, 1, 0, 0, 0, $w, $h, 50); // right
                imagecopymerge($imgBlur, $img, 0, 0, 0, 0, $w, $h, 50); // center
                imagecopy($imgCanvas, $imgBlur, 0, 0, 0, 0, $w, $h);

                imagecopymerge($imgBlur, $imgCanvas, 0, 0, 0, 1, $w, $h - 1, 33.33333); // up
                imagecopymerge($imgBlur, $imgCanvas, 0, 1, 0, 0, $w, $h, 25); // down
            }
        }

        if ($threshold>0) {
            // Calculate the difference between the blurred pixels and the original
            // and set the pixels
            for ($x = 0; $x < $w - 1; $x++) { // each row
                for ($y = 0; $y < $h; $y++) { // each pixel
                    $rgbOrig = imagecolorat($img, $x, $y);
                    $rOrig = (($rgbOrig >> 16) & 0xFF);
                    $gOrig = (($rgbOrig >> 8) & 0xFF);
                    $bOrig = ($rgbOrig & 0xFF);

                    $rgbBlur = imagecolorat($imgBlur, $x, $y);

                    $rBlur = (($rgbBlur >> 16) & 0xFF);
                    $gBlur = (($rgbBlur >> 8) & 0xFF);
                    $bBlur = ($rgbBlur & 0xFF);

                    // When the masked pixels differ less from the original
                    // than the threshold specifies, they are set to their original value.
                    $rNew = (abs($rOrig - $rBlur) >= $threshold)
                        ? max(0, min(255, ($amount * ($rOrig - $rBlur)) + $rOrig))
                        : $rOrig;
                    $gNew = (abs($gOrig - $gBlur) >= $threshold)
                        ? max(0, min(255, ($amount * ($gOrig - $gBlur)) + $gOrig))
                        : $gOrig;
                    $bNew = (abs($bOrig - $bBlur) >= $threshold)
                        ? max(0, min(255, ($amount * ($bOrig - $bBlur)) + $bOrig))
                        : $bOrig;

                    if (($rOrig != $rNew) || ($gOrig != $gNew) || ($bOrig != $bNew)) {
                        $pixCol = imagecolorallocate($img, $rNew, $gNew, $bNew);
                        imagesetpixel($img, $x, $y, $pixCol);
                    }
                }
            }
        } else {
            for ($x = 0; $x < $w; $x++) { // each row
                for ($y = 0; $y < $h; $y++) { // each pixel
                    $rgbOrig = imagecolorat($img, $x, $y);
                    $rOrig = (($rgbOrig >> 16) & 0xFF);
                    $gOrig = (($rgbOrig >> 8) & 0xFF);
                    $bOrig = ($rgbOrig & 0xFF);

                    $rgbBlur = imagecolorat($imgBlur, $x, $y);

                    $rBlur = (($rgbBlur >> 16) & 0xFF);
                    $gBlur = (($rgbBlur >> 8) & 0xFF);
                    $bBlur = ($rgbBlur & 0xFF);

                    $rNew = ($amount * ($rOrig - $rBlur)) + $rOrig;
                    if ($rNew>255) {
                        $rNew=255;
                    } elseif ($rNew<0) {
                        $rNew=0;
                    }
                    $gNew = ($amount * ($gOrig - $gBlur)) + $gOrig;
                    if ($gNew>255) {
                        $gNew=255;
                    } elseif ($gNew<0) {
                        $gNew=0;
                    }
                    $bNew = ($amount * ($bOrig - $bBlur)) + $bOrig;
                    if ($bNew>255) {
                        $bNew=255;
                    } elseif ($bNew<0) {
                        $bNew=0;
                    }
                    $rgbNew = ($rNew << 16) + ($gNew <<8) + $bNew;
                    imagesetpixel($img, $x, $y, $rgbNew);
                }
            }
        }
        imagedestroy($imgCanvas);
        imagedestroy($imgBlur);
    }

    /**
     * 애니메이션 git 인지 검사
     * @param string $filename
     * @return bool
     */
    public static function isAnimatedGif($filename)
    {
        if (!($fh = @fopen($filename, 'rb'))) {
            return false;
        }
        $count = 0;
        // 출처 : http://www.php.net/manual/en/function.imagecreatefromgif.php#104473
        // an animated gif contains multiple "frames", with each frame having a
        // header made up of:
        // * a static 4-byte sequence (\x00\x21\xF9\x04)
        // * 4 variable bytes
        // * a static 2-byte sequence (\x00\x2C) (some variants may use \x00\x21 ?)

        // We read through the file til we reach the end of the file, or we've found
        // at least 2 frame headers
        while (!feof($fh) && $count < 2) {
            $chunk = fread($fh, 1024 * 100); //read 100kb at a time
            $count += preg_match_all('#\x00\x21\xF9\x04.{4}\x00(\x2C|\x21)#s', $chunk, $matches);
        }

        fclose($fh);
        return ($count > 1);
    }
}
