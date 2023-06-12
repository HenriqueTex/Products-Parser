<?php

namespace App\Enums;

enum ProductStatus: string
{
    case Trash = "trash";
    case Published = "published";
    case Draft = "draft";
}
