<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class RandomizerType extends Enum
{
    const Picker =   1;
    const GroupPicker =   2;
    const CustomPicker = 3;
}
