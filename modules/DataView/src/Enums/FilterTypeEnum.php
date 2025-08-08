<?php

namespace Modules\DataView\Enums;

enum FilterTypeEnum: string
{
    /**
     * Dropdown.
     */
    case DROPDOWN = 'dropdown';

    /**
     * Date range.
     */
    case DATE_RANGE = 'date_range';

    /**
     * Date time range.
     */
    case DATETIME_RANGE = 'datetime_range';
}
