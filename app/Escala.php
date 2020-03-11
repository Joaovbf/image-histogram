<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escala extends Model
{
    static public $hexColors = ["#C0BAB0","#A89E93",
        "#948678",
        "#AB987D",
        "#BA9B7C",
        "#BBBAAB",
        "#C6B5A2",
        "#BEA786",
        "#C8AC85",
        "#CCBCAC",
        "#CAB69D",
        "#B8A286",
        "#B9A282",
        "#A3987A",
            //"#C0B0A1",
        "#CDBBAC",
        "#C0B0A1"];

    static public $rgbColors = [
        [191, 186, 176],
        [168, 158, 147],
        [148, 134, 120],
        [171, 152, 125],
        [186, 155, 124],
        [187, 186, 171],
        [198, 181, 162],
        [190, 167, 134],
        [200, 172, 133],
        [204, 188, 172],
        [202, 182, 157],
        [184, 162, 134],
        [185, 162, 130],
        [163, 152, 122],
        [205, 187, 172],
        [192, 176, 161]
    ];

    static public $labels = ["A1","A2",
        "A3",
        "A35",
        "A4",
        "B1",
        "B2",
        "B3",
        "B4",
        "C1",
        "C2",
        "C3",
        "C4",
        "D1",
        "D2",
            //"D3",
        "D4"];
}
