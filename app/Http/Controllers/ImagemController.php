<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ImagemController extends Controller
{
    private function imageToArray($imagem){
        $width = imagesx($imagem);
        $height = imagesy($imagem);

        $retorno = [];

        for ($i = 0; $i < $width; $i++){
            for ($j = 0; $j < $height; $j++){
                $rgb = imagecolorat($imagem, $i, $j);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;
                $retorno[$i][$j] = [$r,$g,$b];
            }
        }

        return $retorno;
    }

    public function enviar(Request $request){
        Storage::putFileAs("public",$request->file('imagem'),"imagem.jpg");
        $imagem  = Storage::url("imagem.jpg");
        return view('selecionar',compact('imagem'));

    }

    public function analisar(Request $request){

        $path = storage_path("app/public/imagem.jpg");
        $file = new File($path);
        $mime = $file->getMimeType();

        $extensao = substr($mime,stripos($mime,"/")+1);
        switch ($extensao){
            case "jpeg":
            case "jpg":
                $imagem = imagecreatefromjpeg($file);
                break;
            case "png":
                $imagem = imagecreatefrompng($file);
                break;
        }
        $size = 30;
        $imagem = imagecrop($imagem, ['x' => $request->posicaoX-$size/2, 'y' => $request->posicaoY-$size/2, 'width' => $size, 'height' => $size]);

        $cores = $this->imageToArray($imagem);

        $histograma = $this->histograma($cores);

        $maiorR = 0;
        $maiorB = 0;
        $maiorG = 0;
        for ($i = 0; $i < count($histograma["R"]); $i++){
            if ($histograma["R"][$i]>$maiorR)
                $maiorR = $histograma["R"][$i];

            if ($histograma["G"][$i]>$maiorG)
                $maiorG = $histograma["G"][$i];

            if ($histograma["B"][$i]>$maiorB)
                $maiorB = $histograma["B"][$i];
        }

        $cor = $this->RGB_TO_HSV($maiorR,$maiorG,$maiorB);
        dd($histograma,$maiorR);
    }

    function RGB_TO_HSV ($R, $G, $B)  // RGB Values:Number 0-255
    {                                 // HSV Results:Number 0-1
        $HSL = array();

        $var_R = ($R / 255);
        $var_G = ($G / 255);
        $var_B = ($B / 255);

        $var_Min = min($var_R, $var_G, $var_B);
        $var_Max = max($var_R, $var_G, $var_B);
        $del_Max = $var_Max - $var_Min;

        $V = $var_Max;

        if ($del_Max == 0)
        {
            $H = 0;
            $S = 0;
        }
        else
        {
            $S = $del_Max / $var_Max;

            $del_R = ( ( ( $var_Max - $var_R ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
            $del_G = ( ( ( $var_Max - $var_G ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
            $del_B = ( ( ( $var_Max - $var_B ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;

            if      ($var_R == $var_Max) $H = $del_B - $del_G;
            else if ($var_G == $var_Max) $H = ( 1 / 3 ) + $del_R - $del_B;
            else if ($var_B == $var_Max) $H = ( 2 / 3 ) + $del_G - $del_R;

            if ($H<0) $H++;
            if ($H>1) $H--;
        }

        $HSL['H'] = $H;
        $HSL['S'] = $S;
        $HSL['V'] = $V;

        return $HSL;
    }

    /**
     * @param $cores
     *
     * @return mixed
     */
    function histograma($cores){
        $histograma = ["R"=>[],"G"=>[],"B"=>[]];
        for ($i = 0; $i < 256; $i++){
            $histograma["R"][$i] = 0;
            $histograma["G"][$i] = 0;
            $histograma["B"][$i] = 0;
        }

        for ($i = 0; $i < count($cores); $i++){
            for ($j = 0; $j < count($cores[$i]); $j++){
                $histograma["R"][$cores[$i][$j][0]]++;
                $histograma["G"][$cores[$i][$j][1]]++;
                $histograma["B"][$cores[$i][$j][2]]++;
            }
        }

        return $histograma;
    }

}
